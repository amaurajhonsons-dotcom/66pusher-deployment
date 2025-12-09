UPDATE `settings` SET `value` = '{\"version\":\"10.0.0\", \"code\":\"1000\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

CREATE TABLE `blog_posts_ratings` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`blog_post_id` bigint unsigned DEFAULT NULL,
`user_id` bigint unsigned DEFAULT NULL,
`ip_binary` varbinary(16) DEFAULT NULL,
`rating` tinyint(1) DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `blog_posts_ratings_blog_post_id_ip_binary_idx` (`blog_post_id`,`ip_binary`) USING BTREE,
KEY `user_id` (`user_id`),
CONSTRAINT `blog_posts_ratings_ibfk_1` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`blog_post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `blog_posts_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table blog_posts add total_ratings bigint unsigned not null default 0 after total_views;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table blog_posts add average_rating float unsigned not null default 0 after total_views;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

INSERT INTO `settings` (`key`, `value`) VALUES ('lemonsqueezy', '{"is_enabled":false,"api_key":"","signing_secret":"","store_id":"","one_time_monthly_variant_id":"","one_time_annual_variant_id":"","one_time_lifetime_variant_id":"","recurring_monthly_variant_id":"","recurring_annual_variant_id":"","currencies":["USD"]}');

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --