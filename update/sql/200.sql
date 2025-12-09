UPDATE `settings` SET `value` = '{\"version\":\"2.0.0\", \"code\":\"200\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table users add next_cleanup_datetime datetime default CURRENT_TIMESTAMP null after datetime;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --