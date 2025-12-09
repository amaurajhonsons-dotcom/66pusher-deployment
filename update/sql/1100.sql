UPDATE `settings` SET `value` = '{\"version\":\"11.0.0\", \"code\":\"1100\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table users add plan_campaigns_limit_notice tinyint default 0 null;

-- SEPARATOR --

alter table users add plan_sent_push_notifications_limit_notice tinyint default 0 null;

-- SEPARATOR --

INSERT INTO `settings` (`key`, `value`) VALUES ('myfatoorah', '{}');

-- SEPARATOR --