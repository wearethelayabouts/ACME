## Adding columns added since last migration

ALTER TABLE `content` ADD `published` int(1) NOT NULL DEFAULT '1'

ALTER TABLE `categories` ADD `published` int(1) NOT NULL DEFAULT '1'

ALTER TABLE `pages` ADD `custom_css` text