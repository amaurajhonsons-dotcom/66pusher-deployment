<?php

/* Configuration of the site */
define('DATABASE_SERVER',   '');
define('DATABASE_USERNAME', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME',     '');
define('SITE_URL',          '');

/* Only modify this if you want to use redis for caching instead of the default file system caching */
define('REDIS_IS_ENABLED', 0);
define('REDIS_SOCKET_PATH', null);
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASSWORD', null);
define('REDIS_DATABASE', 0);
define('REDIS_TIMEOUT', 2);
