<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon;

use Phalcon\Crypt\CryptInterface;
use Phalcon\Crypt\Exception as CryptException;
use Phalcon\Crypt\MismatchException;
use Phalcon\Helper\Str;

use function base64_decode;
use function base64_encode;
use function chr;
use function function_exists;
use function hash;
use function hash_algos;
use function hash_hmac;
use function hash_hmac_algos;
use function in_array;
use function openssl_cipher_iv_length;
use function openssl_decrypt;
use function openssl_encrypt;
use function openssl_get_cipher_methods;
use function openssl_random_pseudo_bytes;
use function ord;
use function rand;
use function range;
use function rtrim;
use function sprintf;
use function str_ireplace;
use function str_repeat;
use function strlen;
use function strrpos;
use function strtolower;
use function strtoupper;
use function substr;

use const OPENSSL_RAW_DATA;

/**
 * Provides encryption capabilities to Phalcon applications.
 *
 * ```php
 * use Phalcon\Crypt;
 *
 * $crypt = new Crypt();
 *
 * $crypt->setCipher('aes-256-ctr');
 *
 * $key  =
 * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
 * $text = "The message to be encrypted";
 *
 * $encrypted = $crypt->encrypt($text, $key);
 *
 * echo $crypt->decrypt($encrypted, $key);
 * ```
 *
 * @property string $authData
 * @property string $authTag
 * @property int    $authTagLength
 * @property array  $availableCiphers
 * @property string $cipher
 * @property string $hashAlgo
 * @property int    $ivLength
 * @property string $key
 * @property int    $padding
 * @property bool   $useSigning
 */
class Crypt implements CryptInterface
{
    public const PADDING_ANSI_X_923     = 1;
    public const PADDING_DEFAULT        = 0;
    public const PADDING_ISO_10126      = 3;
    public const PADDING_ISO_IEC_7816_4 = 4;
    public const PADDING_PKCS7          = 2;
    public const PADDING_SPACE          = 6;
    public const PADDING_ZERO           = 5;

    /**
     * @var string
     */
    protected $authData = "";

    /**
     * @var string
     */
    protected $authTag;

    /**
     * @var int
     */
    protected $authTagLength = 16;

    /**
     * Available cipher methods.
     *
     * @var array
     */
    protected $availableCiphers = [];

    /**
     * @var string
     */
    protected $cipher = "aes-256-cfb";

    /**
     * The name of hashing algorithm.
     *
     * @var string
     */
    protected $hashAlgo = "sha512";

    /**
     * The cipher iv length.
     *
     * @var int
     */
    protected $ivLength = 16;

    /**
     * @var string
     */
    protected $key = "";

    /**
     * @var int
     */
    protected $padding = 0;

    /**
     * Whether calculating message digest enabled or not.
     *
     * @var bool
     */
    protected $useSigning = true;

    /**
     * Crypt constructor.
     *
     * @param string $cipher
     * @param bool   $useSigning
     *
     * @throws CryptException
     */
    public function __construct(
        string $cipher = "aes-256-cfb",
        bool $useSigning = false
    ) {
        $this->initializeAvailableCiphers();

        $this->setCipher($cipher);
        $this->useSigning($useSigning);
    }

    /**
     * Decrypts an encrypted text.
     *
     * ```php
     * $encrypted = $crypt->decrypt(
     *     $encrypted,
     *     "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
     * );
     * ```
     *
     * @param string      $text
     * @param string|null $key
     *
     * @return string
     * @throws CryptException
     */
    public function decrypt(string $text, string $key = null): string
    {
        $decryptKey = $this->checkDecryptKey($key);

        $cipher   = $this->cipher;
        $mode     = strtolower(
            substr($cipher, strrpos($cipher, "-") - strlen($cipher))
        );
        $authData = $this->authData;
        $authTag  = $this->authTag;

        $this->assertCipherIsAvailable($cipher);

        $ivLength = $this->ivLength;

        if ($ivLength > 0) {
            $blockSize = $ivLength;
        } else {
            $blockSize = $this->getIvLength(
                str_ireplace("-" . $mode, "", $cipher)
            );
        }

        $iv = mb_substr($text, 0, $ivLength, "8bit");

        if ($this->useSigning) {
            return $this->calculateWithSigning(
                $text,
                $ivLength,
                $mode,
                $cipher,
                $decryptKey,
                $iv,
                $authTag,
                $authData,
                $blockSize
            );
        }

        $cipherText = mb_substr($text, $ivLength, null, "8bit");
        $decrypted  = $this->calculateGcmCcm(
            $mode,
            $cipherText,
            $cipher,
            $decryptKey,
            $iv,
            $authTag,
            $authData
        );

        if ($mode == "-cbc" || $mode == "-ecb") {
            $decrypted = $this->cryptUnpadText(
                $decrypted,
                $mode,
                $blockSize,
                $this->padding
            );
        }

        return $decrypted;
    }

    /**
     * Decrypt a text that is coded as a base64 string.
     *
     * @param string      $text
     * @param string|null $key
     * @param bool        $safe
     *
     * @return string
     * @throws CryptException
     */
    public function decryptBase64(
        string $text,
        $key = null,
        bool $safe = false
    ): string {
        if ($safe) {
            $text = strtr($text, "-_", "+/") .
                substr("===", (strlen($text) + 3) % 4);
        }

        return $this->decrypt(
            base64_decode($text),
            $key
        );
    }

    /**
     * Encrypts a text.
     *
     * ```php
     * $encrypted = $crypt->encrypt(
     *     "Top secret",
     *     "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
     * );
     * ```
     *
     * @param string      $text
     * @param string|null $key
     *
     * @return string
     * @throws CryptException
     */
    public function encrypt(string $text, string $key = null): string
    {
        if (empty($key)) {
            $encryptKey = $this->key;
        } else {
            $encryptKey = $key;
        }

        if (empty($encryptKey)) {
            throw new CryptException("Encryption key cannot be empty");
        }

        $cipher = $this->cipher;
        $mode   = strtolower(
            substr(
                $cipher,
                strrpos($cipher, "-") - strlen($cipher)
            )
        );

        $this->assertCipherIsAvailable($cipher);

        $ivLength = $this->ivLength;

        if ($ivLength > 0) {
            $blockSize = $ivLength;
        } else {
            $blockSize = $this->getIvLength(
                str_ireplace(
                    "-" . $mode,
                    "",
                    $cipher
                )
            );
        }

        $iv          = openssl_random_pseudo_bytes($ivLength);
        $paddingType = $this->padding;

        if ($paddingType != 0 && ($mode == "-cbc" || $mode == "-ecb")) {
            $padded = $this->cryptPadText($text, $mode, $blockSize, $paddingType);
        } else {
            $padded = $text;
        }

        /**
         * If the mode is "gcm" or "ccm" and auth data has been passed call it
         * with that data
         */
        if (("-gcm" === $mode || "-ccm" === $mode) && !empty($this->authData)) {
            $authData      = $this->authData;
            $authTag       = $this->authTag;
            $authTagLength = $this->authTagLength;

            $encrypted = openssl_encrypt(
                $padded,
                $cipher,
                $encryptKey,
                OPENSSL_RAW_DATA,
                $iv,
                $authTag,
                $authData,
                $authTagLength
            );

            $this->authTag = $authTag;
        } else {
            $encrypted = openssl_encrypt(
                $padded,
                $cipher,
                $encryptKey,
                OPENSSL_RAW_DATA,
                $iv
            );
        }

        if ($this->useSigning) {
            $hashAlgo = $this->getHashAlgo();
            $digest   = hash_hmac($hashAlgo, $padded, $encryptKey, true);

            return $iv . $digest . $encrypted;
        }

        return $iv . $encrypted;
    }

    /**
     * Encrypts a text returning the result as a base64 string.
     *
     * @param string     $text
     * @param mixed|null $key
     * @param bool       $safe
     *
     * @return string
     * @throws CryptException
     */
    public function encryptBase64(
        string $text,
        $key = null,
        bool $safe = false
    ): string {
        if ($safe === true) {
            return rtrim(
                strtr(
                    base64_encode(
                        $this->encrypt($text, $key)
                    ),
                    "+/",
                    "-_"
                ),
                "="
            );
        }

        return base64_encode(
            $this->encrypt($text, $key)
        );
    }

    /**
     * Returns a list of available ciphers.
     *
     * @return array
     * @throws CryptException
     */
    public function getAvailableCiphers(): array
    {
        $availableCiphers = $this->availableCiphers;

        if (empty($availableCiphers)) {
            $this->initializeAvailableCiphers();

            $availableCiphers = $this->availableCiphers;
        }

        $allowedCiphers = [];
        foreach ($availableCiphers as $cipher) {
            if (
                !Str::endsWith(strtolower($cipher), "des") &&
                !Str::endsWith(strtolower($cipher), "rc2") &&
                !Str::endsWith(strtolower($cipher), "rc4") &&
                !Str::endsWith(strtolower($cipher), "des") &&
                !Str::endsWith(strtolower($cipher), "ecb")
            ) {
                $allowedCiphers[] = $cipher;
            }
        }

        return $allowedCiphers;
    }

    /**
     * Return a list of registered hashing algorithms suitable for hash_hmac.
     */
    public function getAvailableHashAlgos(): array
    {
        if (function_exists("hash_hmac_algos")) {
            return hash_hmac_algos();
        }

        return hash_algos();
    }

    /**
     * @return string
     */
    public function getAuthData(): string
    {
        return $this->authData;
    }

    /**
     * @return string
     */
    public function getAuthTag(): string
    {
        return $this->authTag;
    }

    /**
     * @return int
     */
    public function getAuthTagLength(): int
    {
        return $this->authTagLength;
    }

    /**
     * Returns the current cipher
     */
    public function getCipher(): string
    {
        return $this->cipher;
    }

    /**
     * Get the name of hashing algorithm.
     */
    public function getHashAlgo(): string
    {
        return $this->hashAlgo;
    }

    /**
     * Returns the encryption key
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $data
     *
     * @return CryptInterface
     */
    public function setAuthData(string $data): CryptInterface
    {
        $this->authData = $data;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return CryptInterface
     */
    public function setAuthTag(string $tag): CryptInterface
    {
        $this->authTag = $tag;

        return $this;
    }

    /**
     * @param int $length
     *
     * @return CryptInterface
     */
    public function setAuthTagLength(int $length): CryptInterface
    {
        $this->authTagLength = $length;

        return $this;
    }

    /**
     * Sets the cipher algorithm for data encryption and decryption.
     *
     * The `aes-256-gcm' is the preferable cipher, but it is not usable
     * until the openssl library is upgraded, which is available in PHP 7.1.
     *
     * The `aes-256-ctr' is arguably the best choice for cipher
     * algorithm for current openssl library version.
     *
     * @param string $cipher
     *
     * @return CryptInterface
     * @throws CryptException
     */
    public function setCipher(string $cipher): CryptInterface
    {
        $this->assertCipherIsAvailable($cipher);

        $this->ivLength = $this->getIvLength($cipher);
        $this->cipher   = $cipher;

        return $this;
    }

    /**
     * Set the name of hashing algorithm.
     *
     * @param string $hashAlgo
     *
     * @return CryptInterface
     * @throws CryptException
     */
    public function setHashAlgo(string $hashAlgo): CryptInterface
    {
        $this->assertHashAlgorithmAvailable($hashAlgo);

        $this->hashAlgo = $hashAlgo;

        return $this;
    }

    /**
     * Sets the encryption key.
     *
     * The `$key' should have been previously generated in a cryptographically
     * safe way.
     *
     * Bad key:
     * "le password"
     *
     * Better (but still unsafe):
     * "#1dj8$=dp?.ak//j1V$~%*0X"
     *
     * Good key:
     * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
     *
     * @param string $key
     *
     * @return CryptInterface
     */
    public function setKey(string $key): CryptInterface
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Changes the padding scheme used.
     *
     * @param int $scheme
     *
     * @return CryptInterface
     */
    public function setPadding(int $scheme): CryptInterface
    {
        $this->padding = $scheme;

        return $this;
    }

    /**
     * Sets if the calculating message digest must used.
     *
     * @param bool $useSigning
     *
     * @return CryptInterface
     */
    public function useSigning(bool $useSigning): CryptInterface
    {
        $this->useSigning = $useSigning;

        return $this;
    }

    /**
     * Assert the cipher is available.
     *
     * @param string $cipher
     *
     * @throws CryptException
     */
    protected function assertCipherIsAvailable(string $cipher): void
    {
        $availableCiphers = $this->getAvailableCiphers();

        if (!in_array(strtoupper($cipher), $availableCiphers)) {
            throw new CryptException(
                sprintf(
                    "The cipher algorithm \"%s\" is not supported on this system.",
                    $cipher
                )
            );
        }
    }

    /**
     * Assert the hash algorithm is available.
     *
     * @param string $hashAlgo
     *
     * @throws CryptException
     */
    protected function assertHashAlgorithmAvailable(string $hashAlgo): void
    {
        $availableAlgorithms = $this->getAvailableHashAlgos();

        if (!in_array($hashAlgo, $availableAlgorithms)) {
            throw new CryptException(
                sprintf(
                    "The hash algorithm \"%s\" is not supported on this system.",
                    $hashAlgo
                )
            );
        }
    }

    /**
     * Pads texts before encryption.
     *
     * @see http://www.di-mgt.com.au/cryptopad.html
     *
     * @param string $text
     * @param string $mode
     * @param int    $blockSize
     * @param int    $paddingType
     *
     * @return string
     * @throws CryptException
     */
    protected function cryptPadText(
        string $text,
        string $mode,
        int $blockSize,
        int $paddingType
    ): string {

        $paddingSize = 0;
        $padding     = null;

        if ($mode == "cbc" || $mode == "ecb") {
            $paddingSize = $blockSize - (strlen($text) % $blockSize);

            if ($paddingSize >= 256) {
                throw new CryptException("Block size is bigger than 256");
            }

            switch ($paddingType) {
                case self::PADDING_ANSI_X_923:
                    $padding = str_repeat(chr(0), $paddingSize - 1) . chr($paddingSize);
                    break;

                case self::PADDING_PKCS7:
                    $padding = str_repeat(chr($paddingSize), $paddingSize);
                    break;

                case self::PADDING_ISO_10126:
                    $padding = "";

                    foreach (range(0, $paddingSize - 2) as $counter) {
                        $padding .= chr(rand());
                    }

                    $padding .= chr($paddingSize);

                    break;

                case self::PADDING_ISO_IEC_7816_4:
                    $padding = chr(0x80) . str_repeat(chr(0), $paddingSize - 1);
                    break;

                case self::PADDING_ZERO:
                    $padding = str_repeat(chr(0), $paddingSize);
                    break;

                case self::PADDING_SPACE:
                    $padding = str_repeat(" ", $paddingSize);
                    break;

                default:
                    $paddingSize = 0;
                    break;
            }
        }

        if (!$paddingSize) {
            return $text;
        }

        if ($paddingSize > $blockSize) {
            throw new CryptException("Invalid padding size");
        }

        return $text . substr($padding, 0, $paddingSize);
    }

    /**
     * Removes a padding from a text.
     *
     * If the function detects that the text was not padded, it will return it
     * unmodified.
     *
     * @param string $text
     * @param string $mode
     * @param int    $blockSize
     * @param int    $paddingType
     *
     * @return false|string
     */
    protected function cryptUnpadText(
        string $text,
        string $mode,
        int $blockSize,
        int $paddingType
    ) {
        $paddingSize = 0;
        $length      = strlen($text);

        if (
            $length > 0 &&
            ($length % $blockSize == 0) &&
            ($mode == "cbc" || $mode == "ecb")
        ) {
            switch ($paddingType) {
                case self::PADDING_ANSI_X_923:
                    $paddingSize = $this->getPaddingSizeAnsiX923(
                        $text,
                        $length,
                        $blockSize
                    );
                    break;

                case self::PADDING_PKCS7:
                    $paddingSize = $this->getPaddingSizePkcs7(
                        $text,
                        $length,
                        $blockSize
                    );
                    break;

                case self::PADDING_ISO_10126:
                    return $this->getPaddingSizeIso10126($text, $length);

                case self::PADDING_ISO_IEC_7816_4:
                    return $this->getPaddingSizeIsoIec78164(
                        $text,
                        $length,
                        $blockSize
                    );

                case self::PADDING_ZERO:
                    return $this->getPaddingSizeZero(
                        $text,
                        $length,
                        $blockSize
                    );

                case self::PADDING_SPACE:
                    return $this->getPaddingSizeSpace(
                        $text,
                        $length,
                        $blockSize
                    );

                default:
                    break;
            }

            if ($paddingSize && $paddingSize <= $blockSize) {
                if ($paddingSize < $length) {
                    return substr($text, 0, $length - $paddingSize);
                }

                return "";
            } else {
                $paddingSize = 0;
            }
        }

        if (!$paddingSize) {
            return $text;
        }
    }

    /**
     * Initialize available cipher algorithms.
     *
     * @param string $cipher
     *
     * @return int
     * @throws CryptException
     */
    protected function getIvLength(string $cipher): int
    {
        if (!function_exists("openssl_cipher_iv_length")) {
            throw new CryptException("openssl extension is required");
        }

        return openssl_cipher_iv_length($cipher);
    }

    /**
     * Initialize available cipher algorithms.
     *
     * @throws CryptException
     */
    protected function initializeAvailableCiphers(): void
    {
        if (!function_exists("openssl_get_cipher_methods")) {
            throw new CryptException("openssl extension is required");
        }

        $availableCiphers = openssl_get_cipher_methods(true);

        foreach ($availableCiphers as $key => $cipher) {
            $availableCiphers[$key] = strtoupper($cipher);
        }

        $this->availableCiphers = $availableCiphers;
    }

    /**
     * @param string $mode
     * @param string $cipherText
     * @param string $cipher
     * @param string $decryptKey
     * @param string $iv
     * @param string $authTag
     * @param string $authData
     *
     * @return string
     */
    private function calculateGcmCcm(
        string $mode,
        string $cipherText,
        string $cipher,
        string $decryptKey,
        string $iv,
        string $authTag,
        string $authData
    ): string {
        if (("-gcm" === $mode || "-ccm" === $mode) && !empty($this->authData)) {
            $decrypted = openssl_decrypt(
                $cipherText,
                $cipher,
                $decryptKey,
                OPENSSL_RAW_DATA,
                $iv,
                $authTag,
                $authData
            );
        } else {
            $decrypted = openssl_decrypt(
                $cipherText,
                $cipher,
                $decryptKey,
                OPENSSL_RAW_DATA,
                $iv
            );
        }

        return $decrypted;
    }

    /**
     * @param string $text
     * @param int    $ivLength
     * @param string $mode
     * @param string $cipher
     * @param string $decryptKey
     * @param string $iv
     * @param string $authTag
     * @param string $authData
     * @param int    $blockSize
     *
     * @return string
     * @throws MismatchException
     */
    private function calculateWithSigning(
        string $text,
        int $ivLength,
        string $mode,
        string $cipher,
        string $decryptKey,
        string $iv,
        string $authTag,
        string $authData,
        int $blockSize
    ): string {
        $hashAlgo   = $this->getHashAlgo();
        $hashLength = strlen(hash($hashAlgo, "", true));
        $hash       = mb_substr($text, $ivLength, $hashLength, "8bit");
        $cipherText = mb_substr($text, $ivLength + $hashLength, null, "8bit");

        if (
            ("-gcm" === $mode || "-ccm" === $mode) &&
            !empty($this->authData)
        ) {
            $decrypted = openssl_decrypt(
                $cipherText,
                $cipher,
                $decryptKey,
                OPENSSL_RAW_DATA,
                $iv,
                $authTag,
                $authData
            );
        } else {
            $decrypted = openssl_decrypt(
                $cipherText,
                $cipher,
                $decryptKey,
                OPENSSL_RAW_DATA,
                $iv
            );
        }

        if ($mode == "-cbc" || $mode == "-ecb") {
            $decrypted = $this->cryptUnpadText(
                $decrypted,
                $mode,
                $blockSize,
                $this->padding
            );
        }

        /**
         * Checks on the decrypted's message digest using the HMAC method.
         */
        if (hash_hmac($hashAlgo, $decrypted, $decryptKey, true) !== $hash) {
            throw new MismatchException("Hash does not match.");
        }

        return $decrypted;
    }


    /**
     * @param string|null $key
     *
     * @return string
     * @throws CryptException
     */
    private function checkDecryptKey(string $key = null): string
    {
        if (empty($key)) {
            $decryptKey = $this->key;
        } else {
            $decryptKey = $key;
        }

        if (empty($decryptKey)) {
            throw new CryptException("Decryption key cannot be empty");
        }

        return $decryptKey;
    }

    /**
     * @param string $text
     * @param int    $length
     * @param int    $blockSize
     *
     * @return int
     */
    private function getPaddingSizeAnsiX923(
        string $text,
        int $length,
        int $blockSize
    ): int {
        $paddingSize = 0;
        $last        = substr($text, $length - 1, 1);
        $ord         = (int) ord($last);

        if ($ord <= $blockSize) {
            $paddingSize = $ord;
            $padding     = str_repeat(chr(0), $paddingSize - 1) . $last;

            if (substr($text, $length - $paddingSize) != $padding) {
                $paddingSize = 0;
            }
        }

        return $paddingSize;
    }

    /**
     * @param string $text
     * @param int    $length
     * @param int    $blockSize
     *
     * @return int
     */
    private function getPaddingSizePkcs7(
        string $text,
        int $length,
        int $blockSize
    ): int {
        $paddingSize = 0;
        $last = substr($text, $length - 1, 1);
        $ord  = (int) ord($last);

        if ($ord <= $blockSize) {
            $paddingSize = $ord;
            $padding     = str_repeat(chr($paddingSize), $paddingSize);

            if (substr($text, $length - $paddingSize) != $padding) {
                $paddingSize = 0;
            }
        }

        return $paddingSize;
    }

    /**
     * @param string $text
     * @param int    $length
     *
     * @return int
     */
    private function getPaddingSizeIso10126(
        string $text,
        int $length
    ): int {
        $last = substr($text, $length - 1, 1);

        return (int) ord($last);
    }

    /**
     * @param string $text
     * @param int    $length
     * @param int    $blockSize
     *
     * @return int
     */
    private function getPaddingSizeIsoIec78164(
        string $text,
        int $length,
        int $blockSize
    ): int {
        $paddingSize = 0;
        $i = $length - 1;

        while ($i > 0 && $text[$i] == 0x00 && $paddingSize < $blockSize) {
            $paddingSize++;
            $i--;
        }

        if ($text[$i] == 0x80) {
            $paddingSize++;
        } else {
            $paddingSize = 0;
        }

        return $paddingSize;
    }

    /**
     * @param string $text
     * @param int    $length
     * @param int    $blockSize
     *
     * @return int
     */
    private function getPaddingSizeZero(
        string $text,
        int $length,
        int $blockSize
    ): int {
        $paddingSize = 0;
        $i = $length - 1;

        while ($i >= 0 && $text[$i] == 0x00 && $paddingSize <= $blockSize) {
            $paddingSize++;
            $i--;
        }

        return $paddingSize;
    }



    /**
     * @param string $text
     * @param int    $length
     * @param int    $blockSize
     *
     * @return int
     */
    private function getPaddingSizeSpace(
        string $text,
        int $length,
        int $blockSize
    ): int {
        $paddingSize = 0;
        $i = $length - 1;

        while ($i >= 0 && $text[$i] == 0x20 && $paddingSize <= $blockSize) {
            $paddingSize++;
            $i--;
        }

        return $paddingSize;
    }
}
