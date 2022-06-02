<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1_1_0.php 2022-06-02 08:49:16Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'SEPA Lastschrift'
LIMIT 1;");


$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('SEPA Lastschrift - BLZ/BIC Version', 'SEPALASTSCHRIFT_BLZ_VERSION', 'gültig vom 05.12.2016 bis 05.03.2017', 'Version of the BLZ/BIC numbers in the table sepalastschrift_blz', @gid, 1, NOW(), NOW(), NULL, 'zen_cfg_read_only(')");

$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('SEPA Lastschrift - Version der hinterlegten BLZ/BIC', 'SEPALASTSCHRIFT_BLZ_VERSION', 'Stand der in der Tabelle sepalastschrift_blz hinterlegten Bankleitzahlen/BIC', 43);");

$db->Execute("CREATE TABLE IF NOT EXISTS " . TABLE_SEPALASTSCHRIFT . " (
  `orders_id` int(11) NOT NULL DEFAULT '0',
  `sepalastschrift_owner` varchar(64) DEFAULT NULL,
  `sepalastschrift_number` varchar(24) DEFAULT NULL,
  `sepalastschrift_bankname` varchar(255) DEFAULT NULL,
  `sepalastschrift_blz` varchar(11) DEFAULT NULL,
  `sepalastschrift_iban` varchar(34) DEFAULT NULL,
  `sepalastschrift_bic` varchar(11) DEFAULT NULL,
  `sepalastschrift_status` int(11) DEFAULT NULL,
  `sepalastschrift_prz` char(2) DEFAULT NULL,  
  `sepalastschrift_owner_email` varchar(96) DEFAULT NULL,
  KEY `idx_orders_id` (`orders_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

// delete old configuration/ menu
$admin_page = 'configSEPALastschrift';
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
// add configuration menu
if (!zen_page_key_exists($admin_page)) {
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'UID'
LIMIT 1;");
$db->Execute("INSERT INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('configSEPALastschrift','BOX_CONFIGURATION_SEPA_LASTSCHRIFT','FILENAME_CONFIGURATION',CONCAT('gID=',@gid),'configuration','Y',@gid)");
$messageStack->add('SEPA Lastschrift Konfiguration erfolgreich installiert.', 'success');  
}

