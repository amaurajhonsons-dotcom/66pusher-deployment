UPDATE `settings` SET `value` = '{\"version\":\"5.0.0\", \"code\":\"500\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

UPDATE settings SET `value` = JSON_SET(`value`, '$.blacklisted_domains', JSON_ARRAY()) WHERE `key` = 'users';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

UPDATE settings SET `value` = JSON_SET(`value`, '$.blacklisted_domains', JSON_ARRAY()) WHERE `key` = 'websites';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --