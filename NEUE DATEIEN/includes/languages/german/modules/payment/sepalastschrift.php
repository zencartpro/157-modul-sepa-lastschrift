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
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_TITLE', 'Lastschriftverfahren');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_DESCRIPTION', 'Lastschriftverfahren');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_INFO', '');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_NOTE', 'Hinweis:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK', 'Bankeinzug');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_INFO', ((MODULE_PAYMENT_SEPALASTSCHRIFT_IBAN_ONLY != 'True') ? 'Bitte beachten Sie, dass das Lastschriftverfahren mit Bankleitzahl/Kontonummer <b>nur</b> von einem <b>deutschen Girokonto</b> aus möglich ist.<br/>' : '') . 'Felder mit (*) sind Pflichtangaben. <br/><br/>');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER', 'Kontoinhaber:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_OWNER_EMAIL', 'E-Mail Kontoinhaber:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NUMBER', 'Kontonummer:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_IBAN', 'IBAN:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BLZ', 'BLZ:*');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_BIC', 'BIC:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_NAME', 'Bank:');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_MANDATSREFERENZ', 'Ihre Mandatsreferenz: ');
// Note these MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_X texts appear also in the URL, so no html-entities are allowed here
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR', 'FEHLER: ');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_1', 'Kontonummer und Bankleitzahl stimmen nicht &uuml;berein, bitte korrigieren Sie Ihre Angabe.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_2', 'Diese Kontonummer ist nicht pr&uuml;fbar, bitte kontrollieren Sie zur Sicherheit Ihre Eingabe nochmals.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_3', 'Diese Kontonummer ist nicht pr&uuml;fbar, bitte kontrollieren Sie zur Sicherheit Ihre Eingabe nochmals.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_4', 'Diese Kontonummer ist nicht pr&uuml;fbar, bitte kontrollieren Sie zur Sicherheit Ihre Eingabe nochmals.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_5', 'Diese Bankleitzahl existiert nicht, bitte korrigieren Sie Ihre Angabe.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_8', 'Sie haben keine korrekte Bankleitzahl eingegeben.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_9', 'Sie haben keine korrekte Kontonummer eingegeben.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_10', 'Sie haben keinen Kontoinhaber angegeben.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_11', 'Sie haben keinen korrekten BIC angegeben.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_12', 'Sie haben keine korrekte IBAN eingegeben.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_13', 'Ung&uuml;ltige E-Mail-Adresse f&uuml;r die Benachrichtigung des Kontoinhabers.');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_BANK_ERROR_14', 'Keine Lastschriftfreigabe f&uuml;r dieses SEPA-Land.');
define('JS_BANK_BLZ', '* Bitte geben Sie die BLZ / BIC Ihrer Bank ein!\n\n');
define('JS_BANK_NAME', '* Bitte geben Sie den Namen Ihrer Bank ein!\n\n');
define('JS_BANK_NUMBER', '* Bitte geben Sie Ihre Kontonummer / IBAN ein!\n\n');
define('JS_BANK_NUMBER_LENGTH', '* Die IBAN muss 22 Stellen haben!\n\n');
define('JS_BANK_OWNER', '* Bitte geben Sie den Namen des Kontoinhabers ein!\n\n');
define('JS_BANK_OWNER_EMAIL', '* Bitte geben Sie die E-Mail-Adresse des Kontoinhabers ein!\n\n');
define('MODULE_PAYMENT_SEPALASTSCHRIFT_TEXT_EMAIL_FOOTER', 
"Den Rechnungsbetrag ziehen wir als SEPA-Lastschrift zum Fälligkeitstag $tag mit unserer Gläubiger-ID $ci von Ihrem angegebenen Konto $kontonummer ein.\n" .
"\nBitte stellen Sie sicher, dass genügend Geld für die Zahlung auf dem Konto verfügbar ist.");