<?php
// do not change!
if (IS_ADMIN_FLAG === true) {
if (!defined('MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS')) define('MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS', 'False');
if (!defined('MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY')) define('MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY', 'True');
if (!defined('MODULE_PAYMENT_SEPALASTSCHRIFT_CI')) define('MODULE_PAYMENT_SEPALASTSCHRIFT_CI', '');
}
// do not change!
// Platzhalter Email - do not change!
$tstamp ='';
$tag ='';
$ci = '';
$kontonummer ='';
if (MODULE_PAYMENT_SEPALASTSCHRIFT_STATUS === 'True'){
$tstamp = mktime(0, 0, 0, date("m"), date("d") + MODULE_PAYMENT_SEPALASTSCHRIFT_DUE_DELAY, date("Y"));
$tag = date("d.m.Y", $tstamp);
$ci = MODULE_PAYMENT_SEPALASTSCHRIFT_CI;
$kontonummer = $_SESSION['sepalastschrift_info']['sepalastschrift_number']??'';
}
//Ende
// ab hier koennen Sie falls noetig Anpassungen vornehmen, die Definitionen weiter oben NIE aendern!
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_TITLE', 'SEPA Direct Debit');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_DESCRIPTION', 'SEPA Direct Debit');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_INFO','');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_NOTE', 'Note:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK', 'Banktransfer');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_INFO', ((MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY != 'True') ? 'Please note that direct debit without IBAN/BIC is <b>only available</b> from a <b>german bank account</b>.<br/>' : '') . 'Fields marked with (*) are mandatory.<br/><br/>');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER', 'Account Owner:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER_EMAIL', 'E-Mail Account Owner:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NUMBER', 'Account Number / IBAN:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_IBAN', 'IBAN:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BLZ', 'Bank Code / BIC:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BIC', 'BIC:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NAME', 'Bank Name:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_MANDATSREFERENZ', 'Your Reference: ');
// Note these MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_X texts appear also in the URL, so no html-entities are allowed here
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR', 'ERROR:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_1', 'Account number and bank code do not fit! Please check again.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_2', 'No plausibility check method available for this bank code!');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_3', 'Account number cannot be verified!');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_4', 'Account number cannot be verified! Please check again.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_5', 'Bank code not found! Please check again.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_8', 'Incorrect bank code or no bank code entered.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_9', 'No account number indicated.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_10', 'No account holder indicated.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_11', 'No BIC indicated.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_12', 'No valid IBAN indicated.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_13', 'invalid E-Mail-Address to inform Account Owner.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_14', 'No valid Country for SEPA.');
define('JS_BANK_BLZ', '* Please enter your bank code!\n\n');
define('JS_BANK_NAME', '* Please enter your bank name!\n\n');
define('JS_BANK_NUMBER', '* Please enter your account number!\n\n');
define('JS_BANK_OWNER', '* Please enter the name of the account owner!\n\n');
define('JS_BANK_OWNER_EMAIL', '* Please enter E-Mail-Address of the account owner!\n\n');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_EMAIL_FOOTER', 
"The invoice amount will be collected by using the SEPA Direct Debit with due date $tag for creditor identifier $ci from your account $kontonummer.\n" .
"\nPlease ensure that there are sufficient funds on your account to cover the payment.");