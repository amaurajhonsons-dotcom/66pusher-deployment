<?php
const ALTUMCODE = 66;
define('ROOT', realpath(__DIR__ . '/..') . '/');
define('ROOT_PATH', ROOT);
require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'app/includes/product.php';

function get_ip()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            return trim(reset($ips));
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER['REMOTE_ADDR'];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    return '';
}

$altumcode_api = '';

/* Make sure the product wasn't already installed */
if (file_exists(ROOT . 'install/installed')) {
    die();
}

/* Make sure all the required fields are present */
$required_fields = ['license_key', 'database_host', 'database_name', 'database_username', 'database_password', 'installation_url'];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        die(json_encode([
            'status' => 'error',
            'message' => 'One of the required fields are missing.'
        ]));
    }
}

foreach (['database_host', 'database_name', 'database_username', 'database_password'] as $key) {
    $_POST[$key] = str_replace('\'', '\\\'', $_POST[$key]);
}

/* Parse Host:Port */
$db_host = $_POST['database_host'];
$db_port = 3306;
if (strpos($db_host, ':') !== false) {
    list($db_host, $db_port) = explode(':', $db_host);
}

/* Make sure the database details are correct */
mysqli_report(MYSQLI_REPORT_OFF);

try {
    $database = mysqli_init();
    $database->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    $database->ssl_set(NULL, NULL, NULL, NULL, NULL);
    $database->real_connect(
        $db_host,
        $_POST['database_username'],
        $_POST['database_password'],
        $_POST['database_name'],
        (int) $db_port
    );
} catch (\Exception $exception) {
    die(json_encode([
        'status' => 'error',
        'message' => 'The database connection has failed: ' . $exception->getMessage()
    ]));
}

if ($database->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'The database connection has failed! ' . $database->connect_error
    ]));
}

$database->set_charset('utf8mb4');

/* Prepare the config file content (Cloud Native Version) */
$config_content =
    <<<ALTUM
<?php

/* Configuration of the site */
\$db_url = getenv('DATABASE_URL');
\$db_opts = \$db_url ? parse_url(\$db_url) : [];

define('DATABASE_SERVER',   isset(\$db_opts['host']) ? \$db_opts['host'] : '{$db_host}');
define('DATABASE_USERNAME', isset(\$db_opts['user']) ? \$db_opts['user'] : '{$_POST['database_username']}');
define('DATABASE_PASSWORD', isset(\$db_opts['pass']) ? \$db_opts['pass'] : '{$_POST['database_password']}');
define('DATABASE_NAME',     isset(\$db_opts['path']) ? ltrim(\$db_opts['path'], '/') : '{$_POST['database_name']}');
define('DATABASE_PORT',     isset(\$db_opts['port']) ? \$db_opts['port'] : {$db_port});
define('SITE_URL',          '{$_POST['installation_url']}');

// Debugging to logs
error_log("DB DEBUG: Host=" . DATABASE_SERVER . " Port=" . DATABASE_PORT);

/* Only modify this if you want to use redis for caching instead of the default file system caching */
define('REDIS_IS_ENABLED', 0);
define('REDIS_SOCKET_PATH', null);
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASSWORD', null);
define('REDIS_DATABASE', 0);
define('REDIS_TIMEOUT', 2);
ALTUM;

/* Write the new config file */
file_put_contents(ROOT . 'config.php', $config_content);

/* Run SQL */
$dump_content = file_get_contents(ROOT . 'install/dump.sql');

$dump = explode('-- SEPARATOR --', $dump_content);

foreach ($dump as $query) {
    $database->query($query);

    if ($database->error) {
        die(json_encode([
            'status' => 'error',
            'message' => 'Error when running the database queries: ' . $database->error
        ]));
    }
}

/* Create the installed file */
file_put_contents(ROOT . 'install/installed', '');

die(json_encode([
    'status' => 'success',
    'message' => ''
]));
