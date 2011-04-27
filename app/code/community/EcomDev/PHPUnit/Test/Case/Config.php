<?php
/**
 * PHP Unit test suite for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev_PHPUnit
 * @copyright  Copyright (c) 2011 Ecommerce Developers (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */


/**
 * Base test case for testing module configurations
 *
 */
abstract class EcomDev_PHPUnit_Test_Case_Config extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Returns a new instance of EcomDev_PHPUnit_Constraint_Config
     *
     * @param EcomDev_PHPUnit_Constraint_Config_Interface $configContstraint
     * @return EcomDev_PHPUnit_Constraint_Config
     */
    public static function config($configContstraint)
    {
        return new EcomDev_PHPUnit_Constraint_Config($configContstraint);
    }

    /**
     * A new constraint for checking node value
     *
     * @param string $nodePath
     * @param string $type
     * @param mixed $expectedValue
     */
    public static function configNode($nodePath, $type, $expectedValue = null)
    {
        return self::config(
            new EcomDev_PHPUnit_Constraint_Config_Node($nodePath, $type, $expectedValue)
        );
    }

    /**
     * A new constraint for checking module node
     *
     * @param string $moduleName
     * @param string $type
     * @param string|null $expectedValue
     */
    public static function configModule($moduleName, $type, $expectedValue = null)
    {
        return self::config(
            new EcomDev_PHPUnit_Constraint_Config_Module($moduleName, $type, $expectedValue)
        );
    }

    /**
     * Executes configuration constraint
     *
     * @param EcomDev_PHPUnit_Constraint_Config $constraint
     * @param string $message
     */
    public static function assertThatConfig(EcomDev_PHPUnit_Constraint_Config $constraint, $message)
    {
        self::assertThat(Mage::getConfig(), $constraint, $message);
    }

    /**
     * Asserts that config node value is equal to the expected value.
     *
     *
     * @param string $nodePath
     * @param mixed $expectedValue
     * @param string $message
     * @param string $type type of assertion (string, xml, child, etc)
     */
    public static function assertConfigNodeValue($nodePath, $expectedValue, $message = '',
        $type = EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_STRING)
    {
        self::assertThatConfig(
            self::configNode($nodePath, $type, $expectedValue),
            $message
        );
    }

    /**
     * Asserts that config node value is not equal to the expected value.
     *
     *
     * @param string $nodePath
     * @param mixed $expectedValue
     * @param string $message
     * @param string $type type of assertion (EcomDev_PHPUnit_Constraint_Config_Node::TYPE_*)
     */
    public static function assertConfigNodeNotValue($nodePath, $expectedValue, $message = '',
        $type = EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_STRING)
    {
        self::assertThatConfig(
            self::logicalNot(
                self::configNode($nodePath, $type, $expectedValue)
            ),
            $message
        );
    }


    /**
     * Assert that configuration node $nodePath has child with tag name $childName
     *
     * @param string $nodePath
     * @param string $childName
     * @param string $message
     */
    public static function assertConfigNodeHasChild($nodePath, $childName, $message = '')
    {
        self::assertConfigNodeValue(
            $nodePath, $childName, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_HAS_CHILD
        );
    }

    /**
     * Assert that configuration node $nodePath doesn't have child with tag name $childName
     *
     * @param string $nodePath
     * @param string $childName
     * @param string $message
     */
    public static function assertConfigNodeNotHasChild($nodePath, $childName, $message = '')
    {
        self::assertConfigNodeNotValue(
            $nodePath, $childName, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_HAS_CHILD
        );
    }

    /**
     * Assert that configuration node $nodePath has children
     *
     * @param string $nodePath
     * @param string $message
     */
    public static function assertConfigNodeHasChildren($nodePath, $message = '')
    {
        self::assertConfigNodeValue(
            $nodePath, null, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_HAS_CHILDREN
        );
    }

    /**
     * Assert config node $nodePath doesn't have children
     *
     * @param string $nodePath
     * @param string $message
     */
    public static function assertConfigNodeNotHasChildren($nodePath, $message = '')
    {
        self::assertConfigNodeNotValue(
            $nodePath, null, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_HAS_CHILDREN
        );
    }

    /**
     * Assert that configuration node $nodePath contains $expectedValue in comma separated value list
     *
     * @param string $nodePath
     * @param scalar $expectedValue
     * @param string $message
     */
    public static function assertConfigNodeContainsValue($nodePath, $expectedValue, $message = '')
    {
        self::assertConfigNodeValue(
            $nodePath, $expectedValue, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_CONTAIN_VALUE
        );
    }

    /**
     * Assert that configuration node $nodePath doesn't contain $expectedValue in comma separated value list
     *
     * @param string $nodePath
     * @param scalar $expectedValue
     * @param string $message
     */
    public static function assertConfigNodeNotContainsValue($nodePath, $expectedValue, $message = '')
    {
        self::assertConfigNodeValue(
            $nodePath, $expectedValue, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_CONTAIN_VALUE
        );
    }

    /**
     * Assert config node is equal to content of simple xml element
     *
     * @param string $nodePath
     * @param SimpleXmlElement $simpleXml
     * @param string $message
     */
    public static function assertConfigNodeSimpleXml($nodePath, SimpleXmlElement $simpleXml, $message = '')
    {
         self::assertConfigNodeValue(
            $nodePath, $simpleXml, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_XML
        );
    }

    /**
     * Assert config node is not equal to content of simple xml element
     *
     * @param string $nodePath
     * @param SimpleXmlElement $simpleXml
     * @param string $message
     */
    public static function assertConfigNodeNotSimpleXml($nodePath, SimpleXmlElement $simpleXml, $message = '')
    {
         self::assertConfigNodeNotValue(
            $nodePath, $simpleXml, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_XML
        );
    }

    /**
     * Assert config node is less than expected decimal value
     *
     * @param string $nodePath
     * @param decimal $expectedValue
     * @param string $message
     */
    public static function assertConfigNodeLessThan($nodePath, $expectedValue, $message = '')
    {
         self::assertConfigNodeValue(
            $nodePath, $expectedValue, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_LESS_THAN
        );
    }

    /**
     * Assert config node is less or equals than expected decimal value
     *
     * @param string $nodePath
     * @param decimal $expectedValue
     */
    public static function assertConfigNodeLessThanOrEquals($nodePath, $expectedValue, $message = '')
    {
        self::assertThatConfig(
            self::logicalOr(
                self::configNode(
                    $nodePath,
                    EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_NUMBER,
                    $expectedValue
                ),
                self::configNode(
                    $nodePath,
                    EcomDev_PHPUnit_Constraint_Config_Node::TYPE_LESS_THAN,
                    $expectedValue
                )
           ),
           $message
       );
    }

    /**
     * Assert config node is greater than expected decimal value
     *
     * @param string $nodePath
     * @param decimal $expectedValue
     * @param string $message
     */
    public static function assertConfigNodeGreaterThan($nodePath, $expectedValue, $message = '')
    {
         self::assertConfigNodeValue(
            $nodePath, $expectedValue, $message,
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_GREATER_THAN
        );
    }

    /**
     * Assert config node is less or equalsthan expected decimal value
     *
     * @param string $nodePath
     * @param decimal $expectedValue
     */
    public static function assertConfigNodeGreaterThanOrEquals($nodePath, $expectedValue, $message = '')
    {
        self::assertThatConfig(
            self::logicalOr(
                self::configNode(
                    $nodePath,
                    EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_NUMBER,
                    $expectedValue
                ),
                self::configNode(
                    $nodePath,
                    EcomDev_PHPUnit_Constraint_Config_Node::TYPE_GREATER_THAN,
                    $expectedValue
                )
           ),
           $message
       );
    }

    /**
     * Assert that the module is active
     *
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleIsActive($message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_IS_ACTIVE
            ),
            $message
        );
    }

    /**
     * Assert that the module is not active
     *
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleIsNotActive($message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::logicalNot(
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_IS_ACTIVE
                )
            ),
            $message
        );
    }

    /**
     * Assert that the module is in a particular code pool
     *
     * @param string $expected
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleCodePool($expected, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_CODE_POOL,
                $expected
            ),
            $message
        );
    }

    /**
     * Assert that the module depends on another module
     *
     * @param string $requiredModuleName
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleDepends($requiredModuleName, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_DEPENDS,
                $requiredModuleName
            ),
            $message
        );
    }

    /**
     * Assert that the module doesn't depend on another module
     *
     * @param string $requiredModuleName
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleNotDepends($requiredModuleName, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::logicalNot(
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_DEPENDS,
                    $requiredModuleName
                )
            ),
            $message
        );
    }

    /**
     * Assert that the module version is equal to expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersion($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_EQUALS_VERSION,
                $expectedVersion
            ),
            $message
        );
    }

    /**
     * Assert that the module version is not equal to expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersionNot($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::logicalNot(
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_EQUALS_VERSION,
                    $expectedVersion
                )
            ),
            $message
        );
    }

    /**
     * Assert that the module version is less than expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersionLessThan($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_LESS_THAN_VERSION,
                $expectedVersion
            ),
            $message
        );
    }

    /**
     * Assert that the module version is less than or equal to expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersionLessThanOrEquals($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::logicalOr(
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_EQUALS_VERSION,
                    $expectedVersion
                ),
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_LESS_THAN_VERSION,
                    $expectedVersion
                )
            ),
            $message
        );
    }

    /**
     * Assert that the module version is greater than expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersionGreaterThan($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::configModule(
                $moduleName,
                EcomDev_PHPUnit_Constraint_Config_Module::TYPE_GREATER_THAN_VERSION,
                $expectedVersion
            ),
            $message
        );
    }

    /**
     * Assert that the module version is greater than or equal to expected one
     *
     * @param string $expectedVersion
     * @param string $message
     * @param string $moduleName
     */
    public static function assertModuleVersionGreaterThanOrEquals($expectedVersion, $message = '', $moduleName = null)
    {
        if ($moduleName === null) {
            $moduleName = self::getModuleNameFromCallStack();
        }

        self::assertThatConfig(
            self::logicalOr(
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_EQUALS_VERSION,
                    $expectedVersion
                ),
                self::configModule(
                    $moduleName,
                    EcomDev_PHPUnit_Constraint_Config_Module::TYPE_GREATER_THAN_VERSION,
                    $expectedVersion
                )
            ),
            $message
        );
    }
}