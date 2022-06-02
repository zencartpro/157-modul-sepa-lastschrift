<?php
function sepa_validate_email($email) {
    
    if (strpos($email,"\0")!== false) {return false;}
    if (strpos($email,"\x00")!== false) {return false;}
    if (strpos($email,"\u0000")!== false) {return false;}
    if (strpos($email,"\000")!== false) {return false;}    

    $email = trim($email);
    $valid_address = false;
    if (strlen($email) > 255) {
      $valid_address = false;    
    } else {
      if ( substr_count( $email, '@' ) > 1 ) {
        $valid_address = false;
      }    
              
      $regex = "/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,15})$/i";
      $valid_address = preg_match($regex, $email);      
    }
    
    if ($valid_address && ENTRY_EMAIL_ADDRESS_CHECK == 'true') {
      $domain = explode('@', $email);
      if (!checkdnsrr($domain[1], "MX") && !checkdnsrr($domain[1], "A")) {
        $valid_address = false;
      }
    }    
    return $valid_address;
  }