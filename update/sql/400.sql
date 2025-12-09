UPDATE `settings` SET `value` = '{\"version\":\"4.0.0\", \"code\":\"400\"}' WHERE `key` = 'product_info';

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --

alter table blog_posts add image_description varchar(256) null after description;

-- SEPARATOR --
-- NULLED BY LOSTKOREAN - BABIA.TO --