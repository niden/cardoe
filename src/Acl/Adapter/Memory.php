<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Acl\Adapter;

use Cardoe\Acl\Component;
use Cardoe\Acl\ComponentAware;
use Cardoe\Acl\ComponentInterface;
use Cardoe\Acl\Exception;
use Cardoe\Acl\Role;
use Cardoe\Acl\RoleAware;
use Cardoe\Acl\RoleInterface;
use ReflectionException;
use ReflectionFunction;
use function array_keys;
use function array_push;
use function is_array;
use function is_object;
use function is_string;

class Memory extends AbstractAdapter
{
    /**
     * Access
     *
     * @var mixed
     */
    protected $access;

    /**
     * Access List
     *
     * @var mixed
     */
    protected $accessList;

    /**
     * Returns latest function used to acquire access
     *
     * @var mixed
     */
    protected $activeFunction;

    /**
     * Returns number of additional arguments(excluding role and resource)
     * for active function
     *
     * @var int
     */
    protected $activeFunctionCustomArgumentsCount = 0;

    /**
     * Returns latest key used to acquire access
     *
     * @var string|null
     */
    protected $activeKey;

    /**
     * Components
     *
     * @var mixed
     */
    protected $components;

    /**
     * Component Names
     *
     * @var mixed
     */
    protected $componentsNames;

    /**
     * Function List
     *
     * @var mixed
     */
    protected $func;

    /**
     * Default action for no arguments is allow
     *
     * @var mixed
     */
    protected $noArgumentsDefaultAction = self::DENY;

    /**
     * Roles
     *
     * @var mixed
     */
    protected $roles;

    /**
     * Role Inherits
     *
     * @var mixed
     */
    protected $roleInherits;

    /**
     * Roles Names
     *
     * @var mixed
     */
    protected $rolesNames;

    /**
     * Roles      []
     * Components []
     *
     * Access List
     *
     * role|component|access
     * role|component|*
     * role|*|access
     * role|*|*
     * *|component|access
     * *|*|access
     *
     * Inheritance
     *
     * role - role
     *
     */


    /**
     * Cardoe\Acl\Adapter\Memory constructor
     */
    public function __construct()
    {
        $this->componentsNames = ["*"   => true];
        $this->accessList      = ["*!*" => true];
    }

    /**
     * Adds a component to the ACL list
     *
     * Access names can be a particular action, by example
     * search, update, delete, etc or a list of them
     *
     * @param Component|string $componentValue
     * @param array|string     $accessList
     *
     * @return bool
     * @throws Exception
     */
    public function addComponent($componentValue, $accessList): bool
    {
        if (is_object($componentValue) && $componentValue instanceof ComponentInterface) {
            $componentObject = $componentValue;
        } else {
            $componentObject = new Component($componentValue);
        }

        $componentName = $componentObject->getName();

        if (!isset($this->componentsNames[$componentName])) {
            $this->components[]                    = $componentObject;
            $this->componentsNames[$componentName] = true;
        }

        return $this->addComponentAccess($componentName, $accessList);
    }

    /**
     * Adds access to components
     *
     * @param string       $componentName
     * @param array|string $accessList
     *
     * @return bool
     * @throws Exception
     */
    public function addComponentAccess(string $componentName, $accessList): bool
    {
        if (!(isset($this->componentsNames[$componentName]))) {
            throw new Exception(
                "Component '" . $componentName . "' does not exist in ACL"
            );
        }

        if (!is_array($accessList) && !is_string($accessList)) {
            throw new Exception("Invalid value for accessList");
        }

        $exists = true;
        if (is_array($accessList)) {
            foreach ($accessList as $accessName) {
                $accessKey = $componentName . "!" . $accessName;

                if (!isset($this->accessList[$accessKey])) {
                    $this->accessList[$accessKey] = $exists;
                }
            }
        } else {
            $accessKey = $componentName . "!" . $accessList;

            if (!isset($this->accessList[$accessKey])) {
                $this->accessList[$accessKey] = $exists;
            }
        }

        return true;
    }

    /**
     * Do a role inherit from another existing role
     *
     * @param string $roleName
     * @param mixed  $roleToInherits
     *
     * @return bool
     * @throws Exception
     */
    public function addInherit(string $roleName, $roleToInherits): bool
    {
        $rolesNames = $this->rolesNames;

        if (!isset($rolesNames[$roleName])) {
            throw new Exception(
                "Role '" . $roleName . "' does not exist in the role list"
            );
        }

        if (!isset($this->roleInherits[$roleName])) {
            $this->roleInherits[$roleName] = [];
        }

        /**
         * Type conversion
         */
        if (!is_array($roleToInherits)) {
            $roleToInheritList = [$roleToInherits];
        } else {
            $roleToInheritList = $roleToInherits;
        }

        /**
         * inherits
         */
        foreach ($roleToInheritList as $roleToInherit) {
            if (is_object($roleToInherit) && $roleToInherit instanceof RoleInterface) {
                $roleInheritName = $roleToInherit->getName();
            } else {
                $roleInheritName = $roleToInherit;
            }

            /**
             * Check if the role to inherit is repeat
             */
            if (in_array($roleInheritName, $this->roleInherits[$roleName])) {
                continue;
            }

            /**
             * Check if the role to inherit is valid
             */
            if (!isset($rolesNames[$roleInheritName])) {
                throw new Exception(
                    "Role '" . $roleInheritName .
                    "' (to inherit) does not exist in the role list"
                );
            }

            if ($roleName === $roleInheritName) {
                return false;
            }

            /**
             * Deep check if the role to inherit is valid
             */
            if (isset($this->roleInherits[$roleInheritName])) {
                $checkRoleToInherits = [];

                foreach ($this->roleInherits[$roleInheritName] as $usedRoleToInherit) {
                    array_push($checkRoleToInherits, $usedRoleToInherit);
                }

                $usedRoleToInherits = [];

                while (!empty($checkRoleToInherits)) {
                    $checkRoleToInherit = array_shift($checkRoleToInherits);

                    if (isset($usedRoleToInherits[$checkRoleToInherit])) {
                        continue;
                    }

                    $usedRoleToInherits[$checkRoleToInherit] = true;

                    if ($roleName === $checkRoleToInherit) {
                        throw new Exception(
                            "Role '" . $roleInheritName .
                            "' (to inherit) produces an infinite loop"
                        );
                    }

                    /**
                     * Push inherited roles
                     */
                    if (isset($this->roleInherits[$checkRoleToInherit])) {
                        foreach ($this->roleInherits[$checkRoleToInherit] as $usedRoleToInherit) {
                            array_push($checkRoleToInherits, $usedRoleToInherit);
                        }
                    }
                }
            }

            $this->roleInherits[$roleName][] = $roleInheritName;
        }

        return true;
    }

    /**
     * @param RoleInterface|string $role
     * @param null|mixed           $accessInherits
     *
     * @return bool
     * @throws Exception
     */
    public function addRole($role, $accessInherits = null): bool
    {
        if (is_object($role) && $role instanceof RoleInterface) {
            $roleObject = $role;
        } elseif (is_string($role)) {
            $roleObject = new Role($role);
        } else {
            throw new Exception(
                "Role must be either a string or implement RoleInterface"
            );
        }

        $roleName = $roleObject->getName();

        if (isset($this->rolesNames[$roleName])) {
            return false;
        }

        $this->roles[]               = $roleObject;
        $this->rolesNames[$roleName] = true;

        if (null !== $accessInherits) {
            return $this->addInherit($roleName, $accessInherits);
        }

        return true;
    }

    /**
     * Allow access to a role on a component
     *
     * @param string $roleName
     * @param string $componentName
     * @param mixed  $access
     * @param null   $func
     *
     * @throws Exception
     */
    public function allow(string $roleName, string $componentName, $access, $func = null): void
    {
        if ("*" !== $roleName) {
            $this->allowOrDeny(
                $roleName,
                $componentName,
                $access,
                self::ALLOW,
                $func
            );
        } else {
            $roleNames = array_keys($this->rolesNames);
            foreach ($roleNames as $innerRoleName) {
                $this->allowOrDeny(
                    $innerRoleName,
                    $componentName,
                    $access,
                    self::ALLOW,
                    $func
                );
            }
        }
    }

    /**
     * Deny access to a role on a component
     *
     * @param string $roleName
     * @param string $componentName
     * @param mixed  $access
     * @param null   $func
     *
     * @throws Exception
     */
    public function deny(string $roleName, string $componentName, $access, $func = null): void
    {
        if ("*" !== $roleName) {
            $this->allowOrDeny($roleName, $componentName, $access, self::DENY, $func);
        } else {
            $roleNames = array_keys($this->rolesNames);
            foreach ($roleNames as $innerRoleName) {
                $this->allowOrDeny(
                    $innerRoleName,
                    $componentName,
                    $access,
                    self::DENY,
                    $func
                );
            }
        }
    }

    /**
     * Removes an access from a component
     *
     * @param string $componentName
     * @param mixed  $accessList
     */
    public function dropComponentAccess(string $componentName, $accessList): void
    {
        if (is_string($accessList)) {
            $accessList = [$accessList];
        }

        if (is_array($accessList)) {
            foreach ($accessList as $accessName) {
                $accessKey = $componentName . "!" . $accessName;

                if (isset($this->accessList[$accessKey])) {
                    unset($this->accessList[$accessKey]);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getActiveFunction()
    {
        return $this->activeFunction;
    }

    /**
     * @return int
     */
    public function getActiveFunctionCustomArgumentsCount(): int
    {
        return $this->activeFunctionCustomArgumentsCount;
    }

    /**
     * @return string|null
     */
    public function getActiveKey(): ?string
    {
        return $this->activeKey;
    }

    /**
     * Returns the default ACL access level for no arguments provided in
     * isAllowed action if there exists func for accessKey
     *
     * @return int
     */
    public function getNoArgumentsDefaultAction(): int
    {
        return $this->noArgumentsDefaultAction;
    }

    /**
     * Return an array with every component registered in the list
     *
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * Return an array with every role registered in the list
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Check whether a role is allowed to access an action from a component
     *
     * @param RoleInterface|RoleAware|string           $roleName
     * @param ComponentInterface|ComponentAware|string $componentName
     * @param string                                   $access
     * @param array|null                               $parameters
     *
     * @return bool
     * @throws Exception
     * @throws ReflectionException
     */
    public function isAllowed($roleName, $componentName, string $access, array $parameters = null): bool
    {
        $componentObject = null;
        $haveAccess      = null;
        $funcAccess      = null;
        $roleObject      = null;
        $hasComponent    = false;
        $hasRole         = false;
        $parameters      = $parameters ?? [];

        if (is_object($roleName)) {
            if ($roleName instanceof RoleAware) {
                $roleObject = $roleName;
                $roleName   = $roleObject->getRoleName();
            } elseif ($roleName instanceof RoleInterface) {
                $roleName = $roleName->getName();
            } else {
                throw new Exception(
                    "Object passed as roleName must implement " .
                    "Cardoe\\Acl\\RoleAware or Cardoe\\Acl\\RoleInterface"
                );
            }
        }

        if (is_object($componentName)) {
            if ($componentName instanceof ComponentAware) {
                $componentObject = $componentName;
                $componentName   = $componentObject->getComponentName();
            } elseif ($componentName instanceof ComponentInterface) {
                $componentName = $componentName->getName();
            } else {
                throw new Exception(
                    "Object passed as componentName must implement " .
                    "Cardoe\\Acl\\ComponentAware or Cardoe\\Acl\\ComponentInterface"
                );
            }
        }

        $this->activeRole      = $roleName;
        $this->activeComponent = $componentName;
        $this->activeAccess    = $access;
        $this->activeKey       = null;
        $this->activeKey       = null;
        $this->activeFunction  = null;
        $accessList            = $this->access;
        $funcList              = $this->func;

        $this->activeFunctionCustomArgumentsCount = 0;

        /**
         * Check if the role exists
         */
        $rolesNames = $this->rolesNames;

        if (!isset($rolesNames[$roleName])) {
            return ($this->defaultAccess == self::ALLOW);
        }

        /**
         * Check if there is a direct combination for role-component-access
         */
        $accessKey = $this->canAccess($roleName, $componentName, $access);
        if (false !== $accessKey && isset($accessList[$accessKey])) {
            $haveAccess = $accessList[$accessKey];
            $funcAccess = $funcList[$accessKey] ?? null;
        }

        /**
         * Check in the inherits roles
         */
        $this->accessGranted  = $haveAccess;
        $this->activeKey      = $accessKey;
        $this->activeFunction = $funcAccess;

        if ($haveAccess === null) {
            /**
             * Change activeKey to most narrow if there was no access for any
             * patterns found
             */
            $this->activeKey = $roleName . "!" . $componentName . "!" . $access;

            return $this->defaultAccess == self::ALLOW;
        }

        /**
         * If we have funcAccess then do all the checks for it
         */
        if (is_callable($funcAccess)) {
            $reflectionFunction   = new ReflectionFunction($funcAccess);
            $reflectionParameters = $reflectionFunction->getParameters();
            $parameterNumber      = count($reflectionParameters);

            /**
             * No parameters, just return haveAccess and call function without
             * array
             */
            if ($parameterNumber === 0) {
                return $haveAccess == self::ALLOW && call_user_func($funcAccess);
            }

            $parametersForFunction      = [];
            $numberOfRequiredParameters = $reflectionFunction->getNumberOfRequiredParameters();
            $userParametersSizeShouldBe = $parameterNumber;

            foreach ($reflectionParameters as $reflectionParameter) {
                $reflectionClass  = $reflectionParameter->getClass();
                $parameterToCheck = $reflectionParameter->getName();

                if ($reflectionClass !== null) {
                    // roleObject is this class
                    if ($roleObject !== null &&
                        $reflectionClass->isInstance($roleObject) &&
                        !$hasRole
                    ) {
                        $hasRole                 = true;
                        $parametersForFunction[] = $roleObject;
                        $userParametersSizeShouldBe--;

                        continue;
                    }

                    // componentObject is this class
                    if ($componentObject !== null &&
                        $reflectionClass->isInstance($componentObject) &&
                        !$hasComponent
                    ) {
                        $hasComponent            = true;
                        $parametersForFunction[] = $componentObject;
                        $userParametersSizeShouldBe--;

                        continue;
                    }

                    /**
                     * This is some user defined class, check if his parameter
                     * is instance of it
                     */
                    if (isset($parameters[$parameterToCheck]) &&
                        is_object($parameters[$parameterToCheck]) &&
                        !$reflectionClass->isInstance($parameters[$parameterToCheck])
                    ) {
                        throw new Exception(
                            "Your passed parameter doesn't have the " .
                            "same class as the parameter in defined function " .
                            "when checking if " . $roleName . " can " . $access .
                            " " . $componentName . ". Class passed: " .
                            get_class($parameters[$parameterToCheck]) .
                            " , Class in defined function: " .
                            $reflectionClass->getName() . "."
                        );
                    }
                }

                if (isset($parameters[$parameterToCheck])) {
                    /**
                     * We can't check type of ReflectionParameter in PHP 5.x so
                     * we just add it as it is
                     */
                    $parametersForFunction[] = $parameters[$parameterToCheck];
                }
            }

            $this->activeFunctionCustomArgumentsCount = $userParametersSizeShouldBe;

            if (count($parameters) > $userParametersSizeShouldBe) {
                trigger_error(
                    "Number of parameters in array is higher than " .
                    "the number of parameters in defined function when checking if '" .
                    $roleName . "' can '" . $access . "' '" . $componentName .
                    "'. Extra parameters will be ignored.",
                    E_USER_WARNING
                );
            }

            // We dont have any parameters so check default action
            if (count($parametersForFunction) == 0) {
                if ($numberOfRequiredParameters > 0) {
                    trigger_error(
                        "You didn't provide any parameters when '" . $roleName .
                        "' can '" . $access . "' '" . $componentName .
                        "'. We will use default action when no arguments."
                    );

                    return $haveAccess == self::ALLOW && $this->noArgumentsDefaultAction == self::ALLOW;
                }

                /**
                 * Number of required parameters == 0 so call funcAccess without
                 * any arguments
                 */
                return $haveAccess == self::ALLOW && call_user_func($funcAccess);
            }

            // Check necessary parameters
            if (count($parametersForFunction) >= $numberOfRequiredParameters) {
                return $haveAccess == self::ALLOW && call_user_func_array($funcAccess, $parametersForFunction);
            }

            // We don't have enough parameters
            throw new Exception(
                "You did not provide all necessary parameters for the " .
                "defined function when checking if '" . $roleName . "' can '" .
                $access . "' for '" . $componentName . "'."
            );
        }

        return $haveAccess == self::ALLOW;
    }

    /**
     * Check whether component exist in the components list
     *
     * @param string $componentName
     *
     * @return bool
     */
    public function isComponent(string $componentName): bool
    {
        return isset($this->componentsNames[$componentName]);
    }

    /**
     * Check whether role exist in the roles list
     *
     * @param string $roleName
     *
     * @return bool
     */
    public function isRole(string $roleName): bool
    {
        return isset($this->rolesNames[$roleName]);
    }

    /**
     * Sets the default access level (Cardoe\Acl::ALLOW or Cardoe\Acl::DENY)
     * for no arguments provided in isAllowed action if there exists func for
     * accessKey
     *
     * @param int $defaultAccess
     */
    public function setNoArgumentsDefaultAction(int $defaultAccess): void
    {
        $this->noArgumentsDefaultAction = $defaultAccess;
    }

    /**
     * Checks if a role has access to a component
     *
     * @param string $roleName
     * @param string $componentName
     * @param mixed  $access
     * @param mixed  $action
     * @param null   $func
     *
     * @throws Exception
     */
    private function allowOrDeny(
        string $roleName,
        string $componentName,
        $access,
        $action,
        $func = null
    ): void {
        if (!isset($this->rolesNames[$roleName])) {
            throw new Exception(
                "Role '" . $roleName . "' does not exist in the ACL"
            );
        }

        if (!isset($this->componentsNames[$componentName])) {
            throw new Exception(
                "Component '" . $componentName . "' does not exist in the ACL"
            );
        }

        $accessList = $this->accessList;

        if (is_array($access)) {
            foreach ($access as $accessName) {
                $accessKey = $componentName . "!" . $accessName;

                if (!isset($accessList[$accessKey])) {
                    throw new Exception(
                        "Access '" . $accessName .
                        "' does not exist in component '" . $componentName . "'"
                    );
                }
            }

            foreach ($access as $accessName) {
                $accessKey                = $roleName . "!" . $componentName . "!" . $accessName;
                $this->access[$accessKey] = $action;

                if ($func != null) {
                    $this->func[$accessKey] = $func;
                }
            }
        } else {
            if ($access !== "*") {
                $accessKey = $componentName . "!" . $access;

                if (!isset($accessList[$accessKey])) {
                    throw new Exception(
                        "Access '" . $access .
                        "' does not exist in component '" . $componentName . "'"
                    );
                }
            }

            $accessKey = $roleName . "!" . $componentName . "!" . $access;

            /**
             * Define the access action for the specified accessKey
             */
            $this->access[$accessKey] = $action;

            if ($func != null) {
                $this->func[$accessKey] = $func;
            }
        }
    }

    /**
     * Check whether a role is allowed to access an action from a component
     *
     * @param string $roleName
     * @param string $componentName
     * @param string $access
     *
     * @return string|bool
     */
    private function canAccess(string $roleName, string $componentName, string $access)
    {
        $accessList = $this->access;
        $accessKey  = $roleName . "!" . $componentName . "!" . $access;

        /**
         * Check if there is a direct combination for role-component-access
         */
        if (isset($accessList[$accessKey])) {
            return $accessKey;
        }

        /**
         * Check if there is a direct combination for role-*-*
         */
        $accessKey = $roleName . "!" . $componentName . "!*";

        if (isset($accessList[$accessKey])) {
            return $accessKey;
        }

        /**
         * Check if there is a direct combination for role-*-*
         */
        $accessKey = $roleName . "!*!*";

        if (isset($accessList[$accessKey])) {
            return $accessKey;
        }

        /**
         * Deep check if the role to inherit is valid
         */
        if (isset($this->roleInherits[$roleName])) {
            $checkRoleToInherits = [];
            foreach ($this->roleInherits[$roleName] as $usedRoleToInherit) {
                array_push($checkRoleToInherits, $usedRoleToInherit);
            }

            $usedRoleToInherits = [];

            while (!empty($checkRoleToInherits)) {
                $checkRoleToInherit = array_shift($checkRoleToInherits);

                if (isset($usedRoleToInherits[$checkRoleToInherit])) {
                    continue;
                }

                $usedRoleToInherits[$checkRoleToInherit] = true;

                $accessKey = $checkRoleToInherit . "!" . $componentName . "!" . $access;

                /**
                 * Check if there is a direct combination in one of the
                 * inherited roles
                 */
                if (isset($accessList[$accessKey])) {
                    return $accessKey;
                }

                /**
                 * Check if there is a direct combination for role-*-*
                 */
                $accessKey = $checkRoleToInherit . "!" . $componentName . "!*";

                if (isset($accessList[$accessKey])) {
                    return $accessKey;
                }

                /**
                 * Check if there is a direct combination for role-*-*
                 */
                $accessKey = $checkRoleToInherit . "!*!*";

                if (isset($accessList[$accessKey])) {
                    return $accessKey;
                }

                /**
                 * Push inherited roles
                 */
                if (isset($this->roleInherits[$checkRoleToInherit])) {
                    foreach ($this->roleInherits[$checkRoleToInherit] as $usedRoleToInherit) {
                        array_push($checkRoleToInherits, $usedRoleToInherit);
                    }
                }
            }
        }

        return false;
    }
}
