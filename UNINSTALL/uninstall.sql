##########################################################################
# SEPA Lastschrift UNINSTALLER - 2022-06-02 - webchills
# NUR AUSFÜHREN WENN SIE DAS MODUL AUS DER DATENBANK ENTFERNEN WOLLEN!!!!!
##########################################################################

DELETE FROM configuration_group WHERE configuration_group_title LIKE '%SEPA Lastschrift%';

DELETE FROM configuration WHERE configuration_key = 'SEPALASTSCHRIFT_BLZ_VERSION';
DELETE FROM configuration WHERE configuration_key = 'SEPALASTSCHRIFT_MODUL_VERSION';
DELETE FROM configuration_language WHERE configuration_key = 'SEPALASTSCHRIFT_BLZ_VERSION';

DELETE FROM admin_pages WHERE page_key='configSEPALastschrift';

DROP TABLE IF EXISTS sepalastschrift;
DROP TABLE IF EXISTS sepalastschrift_blz;