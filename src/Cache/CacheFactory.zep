
/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Cache;

use Cardoe\Cache\Adapter\AdapterInterface;
use Cardoe\Cache;
use Psr\SimpleCache\CacheInterface;
use Cardoe\Cache\Exception\Exception;
use Cardoe\Config;
use Cardoe\Helper\Arr;

/**
 * Creates a new Cache class
 */
class CacheFactory
{
    /**
     * @var AdapterFactory
     */
    protected adapterFactory;

    /**
     * Constructor
     */
    public function __construct(<AdapterFactory> factory)
    {
        let this->adapterFactory = factory;
    }

    /**
     * Factory to create an instace from a Config object
     */
    public function load(var config) -> var
    {
        var name, options;

        if typeof config == "object" && config instanceof Config {
            let config = config->toArray();
        }

        if unlikely typeof config !== "array" {
            throw new Exception(
                "Config must be array or Cardoe\\Config object"
            );
        }

        if unlikely !isset config["adapter"] {
            throw new Exception(
                "You must provide 'adapter' option in factory config parameter."
            );
        }

        let name    = config["adapter"],
            options = Arr::get(config, "options", []);

        return this->newInstance(name, options);
    }

    /**
     * Constructs a new Cache instance.
     */
    public function newInstance(string! name, array! options = []) -> <CacheInterface>
    {
        var adapter;

        let adapter = this->adapterFactory->newInstance(name, options);

        return new Cache(adapter);
    }
}
