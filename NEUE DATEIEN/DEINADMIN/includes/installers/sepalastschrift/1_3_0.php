<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1_3_0.php 2022-06-02 08:49:16Z webchills $
 */
 
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.3.0' WHERE configuration_key = 'SEPALASTSCHRIFT_MODUL_VERSION';");