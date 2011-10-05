## Create initial tables in the database

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `accesslevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal access level identifier',
  `title` tinytext NOT NULL COMMENT 'name of the access level group',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal category identifier',
  `parent_id` int(10) unsigned NOT NULL COMMENT 'set to zero for no parent (meaning it''s a medium)',
  `slug` tinytext NOT NULL COMMENT 'shortened name that only appears in the URL',
  `name` tinytext NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `category_template` tinytext NOT NULL COMMENT 'name of the template file for the category index. if left blank, it will inherit the closest category_template from from its parent categories. one of these is REQUIRED for each medium',
  `content_template` tinytext NOT NULL COMMENT 'name of the template file for all the content in the category (unless otherwise specified in a subcategory) if left blank, it will inherit the closest category_template from from its parent categories. one of these is REQUIRED for each medium.',
  `category_thumbnail` int(10) unsigned NOT NULL COMMENT 'a 200x150 icon to represent the category uploaded to the category with no icon of their own. (points to column `id` in table `files`.) if blank, it will inherit the closest category_thumbnail from its parent categories. one of these is REQUIRED for each m',
  `default_content_thumbnail` int(10) unsigned NOT NULL COMMENT 'a 200x100 icon to represent content pieces uploaded to the category with no icon of their own. (points to column `id` in table `files`.) if blank, it will inherit the closest default_content_thumbnail from its parent categories. one of these is REQUIRED f',
  `is_hub` tinyint(1) NOT NULL DEFAULT '0',
  `rating` tinytext NOT NULL,
  `rating_description` tinytext NOT NULL,
  `return_all_content` int(1) NOT NULL DEFAULT '0',
  `allow_zip` int(1) NOT NULL DEFAULT '0',
  `oldest_first` int(1) NOT NULL DEFAULT '0',
  `allow_play_all` int(1) NOT NULL,
  `nav_comic` int(1) NOT NULL,
  `comicnav_first` int(11) NOT NULL,
  `comicnav_back` int(11) NOT NULL,
  `comicnav_next` int(11) NOT NULL,
  `comicnav_last` int(11) NOT NULL,
  `list_priority` int(11) NOT NULL DEFAULT '0' COMMENT 'list priority level. higher numbers come first',
  `desc` text NOT NULL,
  `desc_bg` int(10) unsigned NOT NULL,
  `subcategory_name` tinytext NOT NULL,
  `no_subcontent_prefixes` int(1) NOT NULL DEFAULT '0' COMMENT 'if set to 1, users browsing this category will not see the hub name listed before content pieces with a hub deeper than this category',
  `no_content_prefixes` int(1) NOT NULL DEFAULT '0' COMMENT 'if set to 1, users seeing a piece of content in this hub in a higher category will not see the hub name listed before the content piece',
  `addon_domain` text NOT NULL,
  `only_show` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `configuration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` tinytext NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` (`id`,`key`,`value`)
VALUES
	(1,'templategroup','brighthorizon');

/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;

CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal content identifier',
  `category_id` int(10) unsigned NOT NULL COMMENT 'identifier of associated category (points to column "id" in table `categories`)',
  `hub_slug` tinytext NOT NULL,
  `slug` tinytext NOT NULL COMMENT 'shortened name that only appears in the URL',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `name` tinytext NOT NULL COMMENT 'full name',
  `body` text NOT NULL COMMENT 'full rich text associated with the content; appears here as HTML.',
  `main_attachment` int(10) unsigned NOT NULL COMMENT 'whatever item is the main focus of content page - ignored if category''s medium is writing (points to column `id` in table `files`)',
  `image_attachment` int(10) unsigned NOT NULL,
  `download_attachment` int(10) unsigned NOT NULL,
  `content_thumbnail` int(10) unsigned NOT NULL COMMENT 'a 200x100 icon to represent the content piece. (points to column `id` in table `files`.) if blank, it will inherit the closest default_content_thumbnail from its parent categories.',
  `date` int(10) unsigned NOT NULL COMMENT 'UNIX Timestamp of content creation.',
  `votes_up` int(10) unsigned NOT NULL,
  `votes_down` int(10) unsigned NOT NULL,
  `votes_neutral` int(10) unsigned NOT NULL,
  `rating` tinytext NOT NULL,
  `rating_description` tinytext NOT NULL,
  `custom_embed` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `contentauthors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal author reference number',
  `contentid` int(10) unsigned NOT NULL COMMENT 'id of the object being referenced',
  `user` int(10) unsigned NOT NULL COMMENT 'id of the user being referenced',
  `show_icon` int(1) NOT NULL DEFAULT '1',
  `rolename` text NOT NULL COMMENT 'the role that the user had in the project.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal file identifier',
  `type` tinytext NOT NULL,
  `name` tinytext,
  `is_downloadable` int(11) NOT NULL DEFAULT '0',
  `internal_description` tinytext NOT NULL COMMENT 'Put in a description of the file to help keep track of what file this is.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `poster_id` int(11) unsigned NOT NULL,
  `title` tinytext NOT NULL,
  `content` mediumtext NOT NULL,
  `shortcontent` text NOT NULL,
  `date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` tinytext NOT NULL,
  `title` text NOT NULL,
  `custom_css` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `userdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal field data identifier',
  `field_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `userfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'internal field identifier',
  `name` tinytext NOT NULL COMMENT 'name of the field',
  `slug` tinytext NOT NULL COMMENT 'the field''s slug',
  `description` mediumtext NOT NULL COMMENT 'the field''s description',
  `crucial` int(1) NOT NULL DEFAULT '0' COMMENT 'determines whether the field is important for ACME',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `userfields` WRITE;
/*!40000 ALTER TABLE `userfields` DISABLE KEYS */;
INSERT INTO `userfields` (`id`,`name`,`slug`,`description`,`crucial`)
VALUES
	(1,'Access Level','access_level','ties to one of the levels in `accesslevels`',1),
	(2,'Full Name','full_name','our real name.',1);

/*!40000 ALTER TABLE `userfields` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;