<?php
// HTTP
define('HTTP_SERVER', 'http://travy.by/');

// HTTPS
define('HTTPS_SERVER', 'http://travy.by/');

// DIR
define('DIR_APPLICATION', '/var/www/pdk911/data/www/travy.by/catalog/');
define('DIR_SYSTEM', '/var/www/pdk911/data/www/travy.by/system/');
define('DIR_IMAGE', '/var/www/pdk911/data/www/travy.by/image/');
define('DIR_STORAGE', '/var/www/pdk911/data/www/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'travy_dmitry');
define('DB_PASSWORD', '1M0c6G4t');
define('DB_DATABASE', 'travy_by');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');