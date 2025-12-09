<?php

/* Configuration of the site */
$db_url = getenv('DATABASE_URL');
$db_opts = $db_url ? parse_url($db_url) : [];

define('DATABASE_SERVER',   isset($db_opts['host']) ? $db_opts['host'] . (isset($db_opts['port']) ? ':' . $db_opts['port'] : '') : 'localhost');
define('DATABASE_USERNAME', isset($db_opts['user']) ? $db_opts['user'] : 'root');
define('DATABASE_PASSWORD', isset($db_opts['pass']) ? $db_opts['pass'] : '');
define('DATABASE_NAME',     isset($db_opts['path']) ? ltrim($db_opts['path'], '/') : '66pusher');
define('SITE_URL',          getenv('APP_URL') ?: 'http://localhost');

/* Only modify this if you want to use redis for caching instead of the default file system caching */
define('REDIS_IS_ENABLED', 0);
define('REDIS_SOCKET_PATH', null);
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASSWORD', null);
define('REDIS_DATABASE', 0);
define('REDIS_TIMEOUT', 2);
