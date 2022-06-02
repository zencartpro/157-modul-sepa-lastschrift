<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sepalastschrift.php 2022-06-02 08:49:16Z webchills $
 */
 
function makeTRTD($name, $value){ 
     $tmpCont = '<tr> 
            <td class="main">' . $name . '</td> 
            <td class="main">' . $value . '</td> 
          </tr>'; 
     return $tmpCont; 
     } 
     
function displaySepaLastschrift(){
    global $db;
    $sql = "select * from " . TABLE_SEPALASTSCHRIFT . " where orders_id ='" . zen_db_input($_GET['oID']) . "'"; 
    $sepalastschrift = $db -> Execute($sql); 
    $content = ''; 
    while(!$sepalastschrift -> EOF){ 
        
         $content .= '<tr> 
                <td colspan="2">' . zen_draw_separator('pixel_trans.gif', '1', '10') . '</td> 
              </tr>' . 
         makeTRTD(TEXT_SEPALASTSCHRIFT_NAME, $sepalastschrift -> fields['sepalastschrift_bankname']) . 
         makeTRTD(TEXT_SEPALASTSCHRIFT_BIC, $sepalastschrift -> fields['sepalastschrift_bic']) .
         makeTRTD(TEXT_SEPALASTSCHRIFT_IBAN, $sepalastschrift -> fields['sepalastschrift_iban']) .
         makeTRTD(TEXT_SEPALASTSCHRIFT_BLZ, $sepalastschrift -> fields['sepalastschrift_blz']) . 
         makeTRTD(TEXT_SEPALASTSCHRIFT_NUMBER, $sepalastschrift -> fields['sepalastschrift_number']) . 
         makeTRTD(TEXT_SEPALASTSCHRIFT_OWNER_EMAIL, $sepalastschrift -> fields['sepalastschrift_owner_email']) . 
         makeTRTD(TEXT_SEPALASTSCHRIFT_OWNER, $sepalastschrift -> fields['sepalastschrift_owner']); 
        
         if ($sepalastschrift->fields['sepalastschrift_status'] == 0){ 
             $content .= makeTRTD(TEXT_SEPALASTSCHRIFT_STATUS, 'OK'); 
             }else{ 
             $content .= makeTRTD(TEXT_SEPALASTSCHRIFT_STATUS, $sepalastschrift -> fields['sepalastschrift_status']); 
             } 
        
         switch ($sepalastschrift -> fields['sepalastschrift_status']){ 
         case 1: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_1; 
             break; 
         case 2: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_2; 
             break; 
         case 3: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_3; 
             break; 
         case 4: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_4; 
             break; 
         case 5: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_5; 
             break; 
         case 8: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_8; 
             break; 
         case 9: $error_val = TEXT_SEPALASTSCHRIFT_ERROR_9; 
             break; 
             } 
        
         
     $sepalastschrift -> MoveNext(); 
    } 
     return $content ; 
}