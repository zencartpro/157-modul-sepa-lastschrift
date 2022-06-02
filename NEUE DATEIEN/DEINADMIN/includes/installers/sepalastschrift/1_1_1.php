<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1_1_1.php 2022-06-02 08:49:16Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'SEPA Lastschrift'
LIMIT 1;");


$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('SEPA Lastschrift - BLZ/BIC Version', 'SEPALASTSCHRIFT_BLZ_VERSION', 'gültig vom 04.12.2017 bis 04.03.2018', 'Version of the BLZ/BIC numbers in the table sepalastschrift_blz', @gid, 1, NOW(), NOW(), NULL, 'zen_cfg_read_only(')");

$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('SEPA Lastschrift - Version der hinterlegten BLZ/BIC', 'SEPALASTSCHRIFT_BLZ_VERSION', 'Stand der in der Tabelle sepalastschrift_blz hinterlegten Bankleitzahlen/BIC', 43);");