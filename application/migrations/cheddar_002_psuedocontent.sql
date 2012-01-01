# Adding support for psuedocontent and category timestamps

ALTER TABLE `categories` ADD `date` int(10);
ALTER TABLE `categories` ADD `psuedocontent` int(1) NOT NULL DEFAULT '0';


# Fixing issue with pages

ALTER TABLE `pages` MODIFY custom_css text;