<?php
/**
 * @package SEPA Lastschrift 
 * Zen Cart German Specific 
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: sepalastschrift.php 2023-02-18 17:54:16Z webchills $
 */

class sepalastschrift {
    var $code, $title, $description, $enabled;

    function __construct() {
      global $order;

      $this->code = 'sepalastschrift';
      $this->title = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_DESCRIPTION;
	    $this->sort_order = defined('MODULE_PAYMENT_SEPALASTSCHRIFT_SORT_ORDER') ? MODULE_PAYMENT_SEPALASTSCHRIFT_SORT_ORDER : null;
      $this->min_order = defined('MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER') ? MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER : null;    
      
      $this->email_footer = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_EMAIL_FOOTER;
   
	   $this->enabled = (defined('MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS') && MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS == 'True'); 
      if (null === $this->sort_order) return false;
	   $this->info=MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_INFO;
      if ((int)MODULE_PAYMENT_SEPALASTSCHRIFT_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_SEPALASTSCHRIFT_ORDER_STATUS_ID;
      }
      if (is_object($order)) {
        $this->update_status();
      }
      
    }

    function update_status() {
      global $order, $db;
      
      // check country
        $dest_country = isset ($order->billing['country']['iso_code_2']) ? $order->billing['country']['iso_code_2'] : 0 ;
        $error = false;
        $countries_table = MODULE_PAYMENT_SEPALASTSCHRIFT_COUNTRIES; 
        $country_zones = explode(",", $countries_table);
        if (in_array($dest_country, $country_zones)) {            
            $this->enabled = true;
        } else {
            $this->enabled = false;
        }  
        
	    
	  if (IS_ADMIN_FLAG === false) {
	  	$customer_id = $_SESSION['customer_id']; 
	  } else {
	  	$customer_id = ''; 
	  }
	  
	  $test_query = $db->Execute("select count(*) as total from " . TABLE_ORDERS . " where customers_id='" . $customer_id . "' AND orders_status=3");
	  $total = $test_query->fields['total']; 

	  if (($total+1) < MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER) {
		$this->enabled = false;
	  }
    }      
    
   
    function javascript_validation() {
      $js = 'if (payment_value == "' . $this->code . '") {' . "\n" .
            '  var sepalastschrift_blz = document.checkout_payment.sepalastschrift_blz.value;' . "\n" .
            '  var sepalastschrift_number = document.checkout_payment.sepalastschrift_number.value;' . "\n" .
            '  var sepalastschrift_number_length = sepalastschrift_number.replace(/\s/g, "").length;' . "\n" .
            '  var sepalastschrift_owner = document.checkout_payment.sepalastschrift_owner.value;' . "\n" .
            '  var sepalastschrift_owner_email = document.checkout_payment.sepalastschrift_owner_email.value;' . "\n";
            $js .='    if (sepalastschrift_number.substr(0, 2) != "DE" && sepalastschrift_blz == "") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_BLZ . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (sepalastschrift_number == "") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_NUMBER . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (sepalastschrift_number_length < "22") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_NUMBER_LENGTH . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (sepalastschrift_number_length > "22") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_NUMBER_LENGTH . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (sepalastschrift_owner == "") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_OWNER . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (sepalastschrift_owner_email == "") {' . "\n" .
            '      error_message = error_message + "' . JS_BANK_OWNER_EMAIL . '";' . "\n" .
            '      error = 1;' . "\n" .
           
            
            '}' . "\n";
$js .='}' . "\n";
      return $js;
    }

    function selection() {
      global $order;
            
      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'description'=>$this->info,
                         'fields' => array(array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_NOTE,
                                                 'field' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_INFO),
                                           array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER,
                                                 'field' => isset($_GET['sepalastschrift_owner'])? zen_draw_input_field('sepalastschrift_owner', $_GET['sepalastschrift_owner'], 'size="40" maxlength="64"') : zen_draw_input_field('sepalastschrift_owner', $order->billing['firstname'] . ' ' . $order->billing['lastname'], 'size="40" maxlength="64"')), 
                                           array('title' => ((MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY == 'False') ? MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NUMBER : MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_IBAN),
                                                 'field' => zen_draw_input_field('sepalastschrift_number', (isset($_GET['sepalastschrift_number'])) ? $_GET['sepalastschrift_number'] : ((isset($_SESSION['sepalastschrift_info']['sepalastschrift_number'])) ? $_SESSION['sepalastschrift_info']['sepalastschrift_number'] : ''), 'size="40" maxlength="40"')),
                                           array('title' => ((MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY == 'False') ? MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BLZ : MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BIC),
                                                 'field' => zen_draw_input_field('sepalastschrift_blz', (isset($_GET['sepalastschrift_blz'])) ? $_GET['sepalastschrift_blz'] : ((isset($_SESSION['sepalastschrift_info']['sepalastschrift_blz'])) ? $_SESSION['sepalastschrift_info']['sepalastschrift_blz'] : ''), 'size="40" maxlength="11"')),
                                           array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NAME,
                                                 'field' => zen_draw_input_field('sepalastschrift_bankname', (isset($_GET['sepalastschrift_bankname'])) ? $_GET['sepalastschrift_bankname'] : ((isset($_SESSION['sepalastschrift_info']['sepalastschrift_bankname'])) ? $_SESSION['sepalastschrift_info']['sepalastschrift_bankname'] : ''), 'size="40" maxlength="64"')),
                                           array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER_EMAIL,
                                                 'field' => isset($_GET['sepalastschrift_owner_email'])? zen_draw_input_field('sepalastschrift_owner_email', $_GET['sepalastschrift_owner_email'], 'size="40" maxlength="96"') : zen_draw_input_field('sepalastschrift_owner_email', ((isset($_SESSION['sepalastschrift_info']['sepalastschrift_owner_email'])) ? $_SESSION['sepalastschrift_info']['sepalastschrift_owner_email'] : $order->customer['email_address']), 'size="40" maxlength="96"')),
                                           array('title' => '',
                                                 'field' => isset($_POST['recheckok']) ? zen_draw_hidden_field('recheckok', $_POST['recheckok']) : '')
                                           ));

      
      return $selection;
    }

    function pre_confirmation_check(){
    	global $db, $messageStack;
      if (@$_POST['recheckok'] != 'true') {
        include(DIR_WS_CLASSES . 'sepa-check.php');

        // iban / classic?
        $number = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['sepalastschrift_number']);
        if (ctype_digit($number) && MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY == 'False') {
          // classic
          $sepalastschrift_validation = new AccountCheck;
          $sepalastschrift_result = $sepalastschrift_validation->CheckAccount($number, $_POST['sepalastschrift_blz']);
          // some error codes <> 0/OK pass as OK 
          if ($sepalastschrift_validation->account_acceptable($sepalastschrift_result))
            $sepalastschrift_result = 0;
        } else {
          // iban
          $sepalastschrift_validation = new IbanAccountCheck;
          $sepalastschrift_result = $sepalastschrift_validation->IbanCheckAccount($number, $_POST['sepalastschrift_blz']);
          // some error codes <> 0/OK pass as OK
          if ($sepalastschrift_validation->account_acceptable($sepalastschrift_result))
            $sepalastschrift_result = 0;
          // owner email ?
          if ($sepalastschrift_result == 0 && isset($_POST['sepalastschrift_owner_email'])) {
            
            if (!sepa_validate_email($_POST['sepalastschrift_owner_email']))
              $sepalastschrift_result = 13;
          }  
       
          
          // map return codes. refine where necessary
          // iban not ok
          if (in_array($sepalastschrift_result, array(1000, 1010, 1020, 1030, 1040))) 
            $sepalastschrift_result = 12;
          // bic not ok
          else if (in_array($sepalastschrift_result, array(1050, 1060, 1070, 1080))) 
            $sepalastschrift_result = 11;
          // classic check of bank details derived from iban, map to classic return codes
          else if ($sepalastschrift_result > 2000) 
            $sepalastschrift_result -= 2000;
          
        } 
        
        if (!empty($sepalastschrift_validation->Bankname)) {
          $this->sepalastschrift_bankname =  $sepalastschrift_validation->Bankname;
        } else {
          $this->sepalastschrift_bankname = zen_db_prepare_input($_POST['sepalastschrift_bankname']);
        }
        if (isset($_POST['sepalastschrift_owner']) && $_POST['sepalastschrift_owner'] == '') {
          $sepalastschrift_result = 10;
        }

        switch ($sepalastschrift_result) {
          case 0: // payment o.k.
            $error = 'O.K.';
            $recheckok = 'false';
            break;
          case 1: // number & blz not ok
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_1;
            $recheckok = 'false';
            break;
          case 2: // account number has no calculation method
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_2;
            $recheckok = 'true';
            break;
          case 3: // No calculation method implemented
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_3;
            $recheckok = 'true';
            break;
          case 4: // Number cannot be checked
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_4;
            $recheckok = 'true';
            break;
          case 5: // BLZ not found
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_5;
            $recheckok = 'false'; // Set "true" if you have not the latest BLZ table!
            break;
          case 8: // no BLZ entered
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_8;
            $recheckok = 'false';
            break;
          case 9: // no number entered
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_9;
            $recheckok = 'false';
            break;
          case 10: // no account holder entered
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_10;
            $recheckok = 'false';
            break;
          case 11: // no bic entered
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_11;
            $recheckok = 'false';
            break;
          case 12: // iban not o.k.
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_12;
            $recheckok = 'false';
            break;
          case 13: // no account holder notification email entered
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_13;
            $recheckok = 'false';
            break;
          case 14: // iban country not allowed in payment zone
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_14;
            $recheckok = 'false';
            break;
          case 128: // Internal error
            $error = 'Internal error, please check again to process your payment';
            $recheckok = 'true';
            break;
          default:
            $error = MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_4;
            $recheckok = 'true';
            break;
        }

        if ($sepalastschrift_result > 0 && isset($_POST['recheckok']) && $_POST['recheckok'] != 'true') {
          $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error) . '&sepalastschrift_owner=' . urlencode($_POST['sepalastschrift_owner']) . '&sepalastschrift_number=' . urlencode($_POST['sepalastschrift_number']) . '&sepalastschrift_blz=' . urlencode($_POST['sepalastschrift_blz']) . '&sepalastschrift_bankname=' . urlencode($_POST['sepalastschrift_bankname']) .'&sepalastschrift_owner_email=' . urlencode($_POST['sepalastschrift_owner_email']) .  '&recheckok=' . $recheckok;
          $stackAlert = 'checkout_payment';
          $messageStack->add_session($stackAlert, $error, 'error');
          zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, $error, 'SSL', true, false));
          
        }
        
        $this->iban_mode = ($sepalastschrift_validation->checkmode == 'iban');
        $this->sepalastschrift_owner = zen_db_prepare_input($_POST['sepalastschrift_owner']);
        $this->sepalastschrift_owner_email = zen_db_prepare_input($_POST['sepalastschrift_owner_email']);
        $this->sepalastschrift_iban = $sepalastschrift_validation->sepalastschrift_iban;
        $this->sepalastschrift_bic = $sepalastschrift_validation->sepalastschrift_bic;
        $this->sepalastschrift_number = $sepalastschrift_validation->sepalastschrift_number;
        $this->sepalastschrift_blz = $sepalastschrift_validation->sepalastschrift_blz;
        $this->sepalastschrift_prz = $sepalastschrift_validation->PRZ;
        $this->sepalastschrift_status = $sepalastschrift_result;
      }
    }

    function confirmation() {
      // write data to session      
      $_SESSION['sepalastschrift_info'] =  array('sepalastschrift_owner' => $this->sepalastschrift_owner,
                                              'sepalastschrift_bankname' => $this->sepalastschrift_bankname,
                                              'sepalastschrift_owner_email' => $this->sepalastschrift_owner_email,
                                              'sepalastschrift_number' => (($this->iban_mode) ? $this->sepalastschrift_iban : $this->sepalastschrift_number),
                                              'sepalastschrift_blz' => (($this->iban_mode) ? $this->sepalastschrift_bic : $this->sepalastschrift_blz),
                                              );
             
      if ($_POST['sepalastschrift_owner'] != '') {
        $confirmation = array('title' => '',
                              'fields' => array(array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER.'<br>'.
                                                                 (($this->iban_mode) ? MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_IBAN : MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NUMBER).'<br>'.
                                                                 (($this->iban_mode) ? MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BIC : MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BLZ).'<br>'.
                                                                 MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NAME.'<br>'.
                                                                 MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER_EMAIL.'<br>',
                                                      'field' => $this->sepalastschrift_owner.'<br>'.
                                                                 (($this->iban_mode) ? $this->sepalastschrift_iban : $this->sepalastschrift_number).'<br>'. 
                                                                 (($this->iban_mode) ? $this->sepalastschrift_bic : $this->sepalastschrift_blz).'<br>'.
                                                                 $this->sepalastschrift_bankname.'<br>'.
                                                                 $this->sepalastschrift_owner_email.'<br>'
                                                )));
      }
      
     
      
      return $confirmation;
    }

    function process_button() {
      global $_POST;
      
      $process_button_string = zen_draw_hidden_field('sepalastschrift_blz', ($this->iban_mode) ? $this->sepalastschrift_bic : $this->sepalastschrift_blz) .
                               zen_draw_hidden_field('sepalastschrift_bankname', $this->sepalastschrift_bankname).
                               zen_draw_hidden_field('sepalastschrift_number', ($this->iban_mode) ? $this->sepalastschrift_iban : $this->sepalastschrift_number) .
                               zen_draw_hidden_field('sepalastschrift_owner', $this->sepalastschrift_owner) .
                               zen_draw_hidden_field('sepalastschrift_owner_email', $this->sepalastschrift_owner_email) .
                               zen_draw_hidden_field('sepalastschrift_status', $this->sepalastschrift_status) .
                               zen_draw_hidden_field('sepalastschrift_prz', $this->sepalastschrift_prz);

      return $process_button_string;
    }

    function before_process() {
      
      $this->pre_confirmation_check();
      $this->sepalastschrift_bankname = zen_db_prepare_input($_POST['sepalastschrift_bankname']);
      
      return false;
    }

    function after_process() {
      global $db, $insert_id, $_POST;
      
      $sql_data_array = array('orders_id' => $insert_id,
                              'sepalastschrift_owner' => $this->sepalastschrift_owner,
                              'sepalastschrift_number' => $this->sepalastschrift_number,
                              'sepalastschrift_bankname' => $this->sepalastschrift_bankname,
                              'sepalastschrift_blz' => $this->sepalastschrift_blz,
                              'sepalastschrift_status' => $this->sepalastschrift_status,
                              'sepalastschrift_prz' => $this->sepalastschrift_prz,
                              'sepalastschrift_iban' => $this->sepalastschrift_iban,
                              'sepalastschrift_bic' => $this->sepalastschrift_bic,
                              'sepalastschrift_owner_email' => $this->sepalastschrift_owner_email,
                              );
      zen_db_perform(TABLE_SEPALASTSCHRIFT, $sql_data_array);

     
      if (isset($this->order_status) && $this->order_status) {
        $db->Execute("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");
        $db->Execute("UPDATE ".TABLE_ORDERS_STATUS_HISTORY." SET orders_status_id='".$this->order_status."' WHERE orders_id='".$insert_id."'");
      }
    }
    
    function info() {
      global $order, $send_by_admin;
      
      if ($send_by_admin) {
        $sepalastschrift_query = $db->Execute("SELECT sepalastschrift_iban,
                                                   sepalastschrift_bankname,
                                                   sepalastschrift_owner_email
                                              FROM ".TABLE_SEPALASTSCHRIFT."
                                             WHERE orders_id = '".$order->info['order_id']."'");
        if ($sepalastschrift_query->RecordCount() > 0) {  
        
          $sepalastschrift = $sepalastschrift_query;
          
          return $sepalastschrift;
        }
      }
      
      return array('sepalastschrift_iban' => $this->sepalastschrift_iban, 
                   'sepalastschrift_bankname' => $this->sepalastschrift_bankname,
                   'sepalastschrift_owner_email' => $this->sepalastschrift_owner_email);
    }
    
    function get_error() {
      global $HTTP_GET_VARS;
      
        $error = array('title' => MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR,
                       'error' => stripslashes(urldecode($HTTP_GET_VARS['error'])));
        return $error;
      
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Activate direct debiting?', 'MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS', 'True', 'Do you want to offer direct debiting for EU bank accounts?', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_PAYMENT_SEPALASTSCHRIFT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Order Status', 'MODULE_PAYMENT_SEPALASTSCHRIFT_ORDER_STATUS_ID', '0',  'Set the status of orders made with this payment module to this value', '6', '3', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Countries', 'MODULE_PAYMENT_SEPALASTSCHRIFT_COUNTRIES', 'DE', 'Enter the countries for which you want to offer SEPA Lastschrift. Two digit ISO codes, comma separated.<br/><br/><b>Please use DE only!</b><br/>If you want to offer SEPA Lastschrift for other EU countries than Germany activate the sepalastschrifteu module. ', '6', '4', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Min Order', 'MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER', '0', 'Minimum orders required for a customer to be able to pay via direct debit', '6', '5', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Identification Number (CI)', 'MODULE_PAYMENT_SEPALASTSCHRIFT_CI', '', 'Enter your SEPA-ID', '6', '6', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Prefix for Reference (optional)', 'MODULE_PAYMENT_SEPALASTSCHRIFT_REFERENCE_PREFIX', '', 'Enter a prefix for the reference (optional)', '6', '7', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Due Delay', 'MODULE_PAYMENT_SEPALASTSCHRIFT_DUE_DELAY', '3', 'Enter period (in days) to execute direct debit', '6', '8', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('IBAN only', 'MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY', 'True', 'Do you want to accept IBAN banktransfer payments only? (recommended)', '6', '9', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Zahlung per SEPA Lastschrift aktivieren?', 'MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS', '43', 'Wollen Sie Zahlung per SEPA Lastschrift anbieten?', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Sortierreihenfolge', 'MODULE_PAYMENT_SEPALASTSCHRIFT_SORT_ORDER', '43', 'Anzeigereigenfolge für das SEPA Lastschrift Modul. Der niedrigste Wert wird zuerst angezeigt.', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Bestellstatus', 'MODULE_PAYMENT_SEPALASTSCHRIFT_ORDER_STATUS_ID', '43', 'Welchen Bestellstatus sollen Bestellungen bekommen, die mit Lastschrift bezahlt werden?', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Länder', 'MODULE_PAYMENT_SEPALASTSCHRIFT_COUNTRIES', '43', '<b>Dieses Modul sollte nur für Deutschland angeboten werden, daher lassen Sie hier immer DE eingestellt!</b><br/>Falls Sie SEPA Lastschrift auch für andere EU Länder anbieten wollen, dann aktivieren Sie zusätzlich das Modul sepalastschrifteu!', now())");   
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Mindestens erforderliche Anzahl von Bestellungen', 'MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER', '43', 'Ab der wievielten Bestellung soll Lastschrift erlaubt sein?', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Gläubiger-Identifikationsnummer (CI)', 'MODULE_PAYMENT_SEPALASTSCHRIFT_CI', '43', 'Geben Sie hier Ihre SEPA-Gläubiger-ID (CI) ein', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Präfix für Mandatsreferenz', 'MODULE_PAYMENT_SEPALASTSCHRIFT_REFERENCE_PREFIX', '43', 'Geben Sie hier ein Präfix für die Mandatsreferenz ein (optional)', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Fälligkeit', 'MODULE_PAYMENT_SEPALASTSCHRIFT_DUE_DELAY', '43', 'Geben Sie ein, nach welcher Frist (in Tagen) Sie die Lastschrift ausführen', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION_LANGUAGE   . " (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) values ('Nur IBAN akzeptieren?', 'MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY', '43', 'Möchten Sie nur IBAN Zahlungen erlauben? (empfohlen)', now())");
      
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
     
      $db->Execute("delete from " . TABLE_CONFIGURATION_LANGUAGE . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS',
                    
                    
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_ORDER_STATUS_ID',
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_SORT_ORDER',
                    
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_COUNTRIES',
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_MIN_ORDER',
                    
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_CI',
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_REFERENCE_PREFIX',
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_DUE_DELAY',
                    'MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY',
                    );
    }
  }
?>