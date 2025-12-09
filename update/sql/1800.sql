UPDATE `settings` SET `value` = '{\"version\":\"15.0.0\", \"code\":\"1500\"}' WHERE `key` = 'product_info';
-- SEPARATOR --
alter table users add pusher_total_sent_push_notifications bigint unsigned default 0 null after pusher_sent_push_notifications_current_month;
-- SEPARATOR --
alter table pages add plans_ids text null after pages_category_id;
-- SEPARATOR --UPDATE `settings` SET `value` = '{\"version\":\"16.0.0\", \"code\":\"1600\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table domains add type tinyint default 0 null after custom_not_found_url;
-- SEPARATOR --UPDATE `settings` SET `value` = '{\"version\":\"17.0.0\", \"code\":\"1700\"}' WHERE `key` = 'product_info';
-- SEPARATOR --
UPDATE users SET email = LOWER(email);


-- SEPARATOR --

INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('klarna', '{"is_enabled":1,"mode":"https:\/\/api.playground.klarna.com\/","username":"","password":"","currencies":["USD"]}');

-- SEPARATOR --

INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('paddle_billing', '{"is_enabled":1,"mode":"sandbox","api_key":"","secret_key":"","client_side_token":"","currencies":["USD"]}');

-- SEPARATOR --

alter table plans add additional_settings text null after settings;

-- SEPARATOR --UPDATE `settings` SET `value` = '{\"version\":\"18.0.0\", \"code\":\"1800\"}' WHERE `key` = 'product_info';
-- SEPARATOR --
INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('plisio', '{\"is_enabled\":false,\"secret_key\":\"\",\"accepted_cryptocurrencies\":[\"DOGE\",\"SOL\",\"ETH\",\"BTC\"],\"default_cryptocurrency\":\"SOL\",\"currencies\":[\"USD\"]}');
-- SEPARATOR --

INSERT INTO `settings` (`key`, `value`) VALUES ('revolut', '{\"is_enabled\":false,\"mode\":\"sandbox\",\"secret_key\":\"\",\"webhook_id\":\"\",\"currencies\":[\"USD\"]}');
-- SEPARATOR --

INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('plisio_whitelabel', '{\"is_enabled\":false,\"secret_key\":\"\",\"accepted_cryptocurrencies\":[\"DOGE\",\"SOL\",\"ETH\",\"BTC\"],\"default_cryptocurrency\":\"SOL\",\"currencies\":[\"USD\"]}');

-- SEPARATOR --

create index `status` on users (status);

-- SEPARATOR --

create index users_logs_datetime_index on users_logs (datetime);

-- SEPARATOR --

create index internal_notifications_datetime_index on internal_notifications (datetime);
-- SEPARATOR --