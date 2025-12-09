UPDATE `settings` SET `value` = '{\"version\":\"14.0.0\", \"code\":\"1400\"}' WHERE `key` = 'product_info';
-- SEPARATOR --

ALTER TABLE `users` ADD INDEX `idx_users_next_cleanup_datetime` (`next_cleanup_datetime`);

-- SEPARATOR --
alter table users modify twofa_secret varchar(32) collate utf8mb4_unicode_ci null;


-- SEPARATOR --

ALTER TABLE `subscribers_logs` ADD INDEX `idx_user_datetime` (`user_id`, `datetime`);
-- SEPARATOR --

alter table broadcasts_statistics modify type enum ('view', 'click') null;

-- SEPARATOR --

alter table pages modify type enum ('internal', 'external') null;

-- SEPARATOR --

alter table segments modify type enum ('custom', 'filter') null;

-- SEPARATOR --

alter table users modify device_type enum ('mobile', 'tablet', 'desktop') null;

-- SEPARATOR --

alter table users_logs modify device_type enum ('mobile', 'tablet', 'desktop') null;

-- SEPARATOR --

alter table subscribers modify device_type enum ('mobile', 'tablet', 'desktop') null;
-- SEPARATOR --

alter table users modify continent_code ENUM('AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA') null;

-- SEPARATOR --

alter table users_logs modify continent_code ENUM('AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA') null;

-- SEPARATOR --

alter table subscribers modify continent_code ENUM('AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA') null;

-- SEPARATOR --

alter table subscribers_logs add error text null after type;
-- SEPARATOR --