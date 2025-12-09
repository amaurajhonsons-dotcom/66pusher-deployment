UPDATE `settings` SET `value` = '{\"version\":\"9.0.0\", \"code\":\"900\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

DELETE FROM personal_notifications;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table personal_notifications add constraint personal_notifications_users_user_id_fk foreign key (user_id) references users (user_id) on update cascade on delete cascade;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table personal_notifications add foreign key (website_id) references websites (website_id) on update cascade on delete cascade;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table personal_notifications add constraint personal_notifications_subscribers_subscriber_id_fk foreign key (subscriber_id) references subscribers (subscriber_id) on update cascade on delete cascade;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

CREATE TABLE `rss_automations` (
`rss_automation_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` bigint unsigned DEFAULT NULL,
`website_id` bigint unsigned DEFAULT NULL,
`name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`rss_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`description` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`image` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`segment` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`rss_last_entries` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`is_enabled` tinyint DEFAULT '1',
`total_sent_push_notifications` bigint unsigned DEFAULT '0',
`total_displayed_push_notifications` bigint unsigned DEFAULT '0',
`total_clicked_push_notifications` bigint unsigned DEFAULT '0',
`total_closed_push_notifications` bigint unsigned DEFAULT '0',
`next_check_datetime` datetime DEFAULT NULL,
`last_check_datetime` datetime DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`rss_automation_id`),
KEY `flows_segment_idx` (`segment`) USING BTREE,
KEY `user_id` (`user_id`),
KEY `website_id` (`website_id`),
CONSTRAINT `rss_automations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `rss_automations_ibfk_2` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add rss_automation_id bigint unsigned null after personal_notification_id;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add constraint subscribers_logs_rss_automations_rss_automation_id_fk foreign key (rss_automation_id) references rss_automations (rss_automation_id) on update cascade on delete cascade;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table campaigns add rss_automation_id bigint unsigned null after website_id;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table campaigns add constraint campaigns_rss_automations_rss_automation_id_fk foreign key (rss_automation_id) references rss_automations (rss_automation_id)            on update cascade on delete set null;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs drop foreign key subscribers_logs_rss_automations_rss_automation_id_fk;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add constraint subscribers_logs_rss_automations_rss_automation_id_fk foreign key (rss_automation_id) references rss_automations (rss_automation_id) on update cascade on delete set null;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table rss_automations add total_campaigns bigint unsigned default 0 null after is_enabled;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

CREATE TABLE `recurring_campaigns` (
`recurring_campaign_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` bigint unsigned DEFAULT NULL,
`website_id` bigint unsigned DEFAULT NULL,
`name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`description` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`image` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`segment` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`is_enabled` tinyint DEFAULT '1',
`total_campaigns` bigint unsigned DEFAULT '0',
`total_sent_push_notifications` bigint unsigned DEFAULT '0',
`total_displayed_push_notifications` bigint unsigned DEFAULT '0',
`total_clicked_push_notifications` bigint unsigned DEFAULT '0',
`total_closed_push_notifications` bigint unsigned DEFAULT '0',
`next_run_datetime` datetime DEFAULT NULL,
`last_run_datetime` datetime DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`recurring_campaign_id`),
KEY `flows_segment_idx` (`segment`) USING BTREE,
KEY `user_id` (`user_id`),
KEY `website_id` (`website_id`),
CONSTRAINT `recurring_campaigns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `recurring_campaigns_ibfk_2` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table campaigns add recurring_campaign_id bigint unsigned null after rss_automation_id;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table campaigns add constraint campaigns_recurring_campaigns_recurring_campaign_id_fk foreign key (recurring_campaign_id) references recurring_campaigns (recurring_campaign_id) on update cascade on delete set null;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table subscribers_logs add recurring_campaign_id bigint unsigned null after rss_automation_id;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --