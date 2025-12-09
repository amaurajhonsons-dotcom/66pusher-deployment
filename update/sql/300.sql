UPDATE `settings` SET `value` = '{\"version\":\"3.0.0\", \"code\":\"300\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

CREATE TABLE `personal_notifications` (
`personal_notification_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` bigint unsigned DEFAULT NULL,
`website_id` bigint unsigned DEFAULT NULL,
`subscriber_id` bigint unsigned DEFAULT NULL,
`name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`description` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`image` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`is_sent` tinyint unsigned DEFAULT '0',
`is_displayed` tinyint unsigned DEFAULT '0',
`is_clicked` tinyint unsigned DEFAULT '0',
`is_closed` tinyint unsigned DEFAULT '0',
`status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`scheduled_datetime` datetime DEFAULT NULL,
`sent_datetime` datetime DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`personal_notification_id`),
KEY `website_id` (`website_id`),
KEY `user_id` (`user_id`),
KEY `campaigns_scheduled_datetime_idx` (`scheduled_datetime`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add personal_notification_id bigint unsigned null after flow_id;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add constraint subscribers_logs_ibfk_8 foreign key (personal_notification_id) references personal_notifications (personal_notification_id) on update cascade on delete set null;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --