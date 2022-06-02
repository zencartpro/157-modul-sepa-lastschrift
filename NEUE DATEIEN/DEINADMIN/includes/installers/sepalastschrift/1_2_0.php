<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1_2_0.php 2022-06-02 08:49:16Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'SEPA Lastschrift'
LIMIT 1;");

$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'gültig bis 02.09.2020' WHERE configuration_key = 'SEPALASTSCHRIFT_BLZ_VERSION' LIMIT 1;");