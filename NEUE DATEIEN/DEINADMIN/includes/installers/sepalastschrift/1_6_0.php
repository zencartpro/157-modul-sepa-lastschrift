<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1_6_0.php 2023-11-13 12:53:16Z webchills $
 */
 
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.6.0' WHERE configuration_key = 'SEPALASTSCHRIFT_MODUL_VERSION';");
$messageStack->add('Modul SEPA Lastschrift erfolgreich aktualisiert.', 'success');  