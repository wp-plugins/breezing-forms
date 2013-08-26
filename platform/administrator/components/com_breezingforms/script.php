<?php
/**
 * @package     BreezingForms
 * @author      Markus Bopp
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
*/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class com_breezingformsInstallerScript
{
        /**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
	}
        
        /**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
        }
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
            $db = JFactory::getDBO();
            $db->setQuery("Select id From `#__menu` Where `alias` = 'root'");
            if(!$db->loadResult()){
                $db->setQuery("INSERT INTO `#__menu` VALUES(1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, ( Select mlftrgt From (Select max(mlft.rgt)+1 As mlftrgt From #__menu As mlft) As tbone ), 0, '*', 0)");
                $db->query();
            }
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
            $db = JFactory::getDBO();
            $db->setQuery("Select id From `#__menu` Where `alias` = 'root'");
            if(!$db->loadResult()){
                $db->setQuery("INSERT INTO `#__menu` VALUES(1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, ( Select mlftrgt From (Select max(mlft.rgt)+1 As mlftrgt From #__menu As mlft) As tbone ), 0, '*', 0)");
                $db->query();
            }
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
            $db = JFactory::getDBO();
            
            $db->setQuery("Select id From `#__menu` Where `alias` = 'root'");
            if(!$db->loadResult()){
                $db->setQuery("INSERT INTO `#__menu` VALUES(1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, ( Select mlftrgt From (Select max(mlft.rgt)+1 As mlftrgt From #__menu As mlft) As tbone ), 0, '*', 0)");
                $db->query();
            }
	}
}

