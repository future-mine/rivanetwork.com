DROP TABLE IF EXISTS `accountLoginSessions`;
CREATE TABLE IF NOT EXISTS `accountLoginSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `sessionToken` varchar(255) NOT NULL DEFAULT 'token',
  `sessionIP` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accountPaymentInformation`;
CREATE TABLE IF NOT EXISTS `accountPaymentInformation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `surName` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT 'yourname',
  `realname` varchar(255) NOT NULL DEFAULT 'YourName',
  `email` varchar(255) NOT NULL DEFAULT 'your@example.com',
  `password` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '121.1.0.0',
  `permission` int(11) NOT NULL DEFAULT '1',
  `credit` int(11) NOT NULL DEFAULT '0',
  `registerDate` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  `lastLogin` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  `discord` varchar(255) NOT NULL DEFAULT '-',
  `imageAvatar` varchar(255) NOT NULL DEFAULT '-',
  `skype` varchar(255) NOT NULL DEFAULT '-',
  `instagram` varchar(255) NOT NULL DEFAULT '-',
  `twitter` varchar(255) NOT NULL DEFAULT '-',
  `youtube` varchar(255) NOT NULL DEFAULT '-',
  `totalCredit` int(11) NOT NULL DEFAULT '0',
  `notificationStatus` int(11) NOT NULL DEFAULT '1',
  `profileMessageStatus` int(11) NOT NULL DEFAULT '1',
  `inventorySlot` int(11) NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accountsInventory`;
CREATE TABLE IF NOT EXISTS `accountsInventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `variables` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accountsMessage`;
CREATE TABLE IF NOT EXISTS `accountsMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `messageAuthorUsername` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accountsNotifications`;
CREATE TABLE IF NOT EXISTS `accountsNotifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` text NOT NULL,
  `data` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `accountsPermission`;
CREATE TABLE IF NOT EXISTS `accountsPermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permName` varchar(255) NOT NULL DEFAULT 'Permission',
  `variables` text NOT NULL,
  `permColorBG` varchar(255) NOT NULL DEFAULT '#069ac0',
  `permColorText` varchar(255) NOT NULL DEFAULT '#ffffff',
  `removeStatus` int(11) NOT NULL DEFAULT '1',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(1, 'Oyuncu', '{\"panel_login\":\"FALSE\",\"maintance\":\"FALSE\",\"statistics\":\"FALSE\",\"store\":\"FALSE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"FALSE\",\"store_public\":\"FALSE\",\"support\":\"FALSE\",\"support_category\":\"FALSE\",\"support_answer\":\"FALSE\",\"support_public\":\"FALSE\",\"public\":\"FALSE\",\"public_news\":\"FALSE\",\"public_news_category\":\"FALSE\",\"public_broadcast\":\"FALSE\",\"public_page\":\"FALSE\",\"player\":\"FALSE\",\"player_detail\":\"FALSE\",\"player_update\":\"FALSE\",\"player_add\":\"FALSE\",\"player_remove\":\"FALSE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"FALSE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"FALSE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"FALSE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"FALSE\",\"updates\":\"FALSE\"}', '#fadb5d', '#ffffff', 0, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(2, 'Yönetici', '{\"panel_login\":\"TRUE\",\"maintance\":\"TRUE\",\"statistics\":\"TRUE\",\"forum\":\"TRUE\",\"store\":\"TRUE\",\"store_server\":\"TRUE\",\"store_category\":\"TRUE\",\"store_product\":\"TRUE\",\"store_coupon\":\"TRUE\",\"store_public\":\"TRUE\",\"support\":\"TRUE\",\"support_category\":\"TRUE\",\"support_answer\":\"TRUE\",\"support_public\":\"TRUE\",\"public\":\"TRUE\",\"public_news\":\"TRUE\",\"public_news_category\":\"TRUE\",\"public_broadcast\":\"TRUE\",\"public_page\":\"TRUE\",\"player\":\"TRUE\",\"player_detail\":\"TRUE\",\"player_update\":\"TRUE\",\"player_add\":\"TRUE\",\"player_remove\":\"TRUE\",\"player_permissions\":\"TRUE\",\"player_ban\":\"TRUE\",\"player_perm\":\"TRUE\",\"settings\":\"TRUE\",\"settings_public\":\"TRUE\",\"settings_system\":\"TRUE\",\"settings_smtp\":\"TRUE\",\"settings_payment\":\"TRUE\",\"modules\":\"TRUE\",\"modules_card_game\":\"TRUE\",\"modules_gift_coupon\":\"TRUE\",\"modules_theme\":\"TRUE\",\"modules_webhooks\":\"TRUE\",\"modules_image\":\"TRUE\",\"modules_module\":\"TRUE\",\"modules_backups\":\"TRUE\",\"modules_lottery\":\"TRUE\",\"updates\":\"TRUE\"}', '#fa3d06', '#ffffff', 0, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(3, 'Moderatör', '{\"panel_login\":\"TRUE\",\"maintance\":\"TRUE\",\"statistics\":\"FALSE\",\"forum\":\"TRUE\",\"store\":\"TRUE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"TRUE\",\"store_public\":\"TRUE\",\"support\":\"TRUE\",\"support_category\":\"TRUE\",\"support_answer\":\"TRUE\",\"support_public\":\"TRUE\",\"public\":\"TRUE\",\"public_news\":\"TRUE\",\"public_news_category\":\"TRUE\",\"public_broadcast\":\"TRUE\",\"public_page\":\"TRUE\",\"player\":\"TRUE\",\"player_detail\":\"TRUE\",\"player_update\":\"TRUE\",\"player_add\":\"TRUE\",\"player_remove\":\"TRUE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"TRUE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"TRUE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"TRUE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"TRUE\",\"modules_module\":\"FALSE\",\"modules_backups\":\"FALSE\",\"modules_lottery\":\"FALSE\",\"updates\":\"FALSE\"}', '#1f8f9f', '#ffffff', 1, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(4, 'Destek Görevlisi', '{\"panel_login\":\"TRUE\",\"maintance\":\"TRUE\",\"statistics\":\"FALSE\",\"store\":\"FALSE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"FALSE\",\"store_public\":\"FALSE\",\"support\":\"TRUE\",\"support_category\":\"TRUE\",\"support_answer\":\"TRUE\",\"support_public\":\"TRUE\",\"public\":\"FALSE\",\"public_news\":\"FALSE\",\"public_news_category\":\"FALSE\",\"public_broadcast\":\"FALSE\",\"public_page\":\"FALSE\",\"player\":\"FALSE\",\"player_detail\":\"FALSE\",\"player_update\":\"FALSE\",\"player_add\":\"FALSE\",\"player_remove\":\"FALSE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"FALSE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"TRUE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"FALSE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"TRUE\",\"updates\":\"FALSE\"}', '#30d35b', '#ffffff', 1, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(5, 'Yazar', '{\"panel_login\":\"TRUE\",\"maintance\":\"TRUE\",\"statistics\":\"FALSE\",\"store\":\"FALSE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"FALSE\",\"store_public\":\"FALSE\",\"support\":\"FALSE\",\"support_category\":\"FALSE\",\"support_answer\":\"FALSE\",\"support_public\":\"FALSE\",\"public\":\"TRUE\",\"public_news\":\"TRUE\",\"public_news_category\":\"TRUE\",\"public_broadcast\":\"TRUE\",\"public_page\":\"TRUE\",\"player\":\"FALSE\",\"player_detail\":\"FALSE\",\"player_update\":\"FALSE\",\"player_add\":\"FALSE\",\"player_remove\":\"FALSE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"FALSE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"TRUE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"FALSE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"TRUE\",\"updates\":\"FALSE\"}', '#f19438', '#ffffff', 1, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(6, 'YouTuber', '{\"panel_login\":\"FALSE\",\"statistics\":\"FALSE\",\"store\":\"FALSE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"FALSE\",\"store_public\":\"FALSE\",\"support\":\"FALSE\",\"support_category\":\"FALSE\",\"support_answer\":\"FALSE\",\"support_public\":\"FALSE\",\"public\":\"FALSE\",\"public_news\":\"FALSE\",\"public_news_category\":\"FALSE\",\"public_broadcast\":\"FALSE\",\"public_page\":\"FALSE\",\"player\":\"FALSE\",\"player_detail\":\"FALSE\",\"player_update\":\"FALSE\",\"player_add\":\"FALSE\",\"player_remove\":\"FALSE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"FALSE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"FALSE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"FALSE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"FALSE\",\"updates\":\"FALSE\"}', '#e80d36', '#ffffff', 1, '01.01.2022 00:00:00');
INSERT INTO `accountsPermission` (`id`, `permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES(7, 'VIP', '{\"panel_login\":\"FALSE\",\"statistics\":\"FALSE\",\"store\":\"FALSE\",\"store_server\":\"FALSE\",\"store_category\":\"FALSE\",\"store_product\":\"FALSE\",\"store_coupon\":\"FALSE\",\"store_public\":\"FALSE\",\"support\":\"FALSE\",\"support_category\":\"FALSE\",\"support_answer\":\"FALSE\",\"support_public\":\"FALSE\",\"public\":\"FALSE\",\"public_news\":\"FALSE\",\"public_news_category\":\"FALSE\",\"public_broadcast\":\"FALSE\",\"public_page\":\"FALSE\",\"player\":\"FALSE\",\"player_detail\":\"FALSE\",\"player_update\":\"FALSE\",\"player_add\":\"FALSE\",\"player_remove\":\"FALSE\",\"player_permissions\":\"FALSE\",\"player_ban\":\"FALSE\",\"player_perm\":\"FALSE\",\"settings\":\"FALSE\",\"settings_public\":\"FALSE\",\"settings_system\":\"FALSE\",\"settings_smtp\":\"FALSE\",\"settings_payment\":\"FALSE\",\"modules\":\"FALSE\",\"modules_card_game\":\"FALSE\",\"modules_gift_coupon\":\"FALSE\",\"modules_theme\":\"FALSE\",\"modules_webhooks\":\"FALSE\",\"modules_image\":\"FALSE\",\"updates\":\"FALSE\"}', '#15dcde', '#ffffff', 1, '01.01.2022 00:00:00');

DROP TABLE IF EXISTS `banned`;
CREATE TABLE IF NOT EXISTS `banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT 'yourname',
  `type` varchar(255) NOT NULL,
  `bannedDate` varchar(255) NOT NULL DEFAULT '1000-01-01 00:00:00',
  `reason` varchar(255) NOT NULL DEFAULT 'Diğer',
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `broadcast`;
CREATE TABLE IF NOT EXISTS `broadcast` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `cardGame`;
CREATE TABLE IF NOT EXISTS `cardGame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Belirlenmemiş',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `hours` varchar(255) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `cardGameHistory`;
CREATE TABLE IF NOT EXISTS `cardGameHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `cardID` int(11) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `rewardType` varchar(255) NOT NULL DEFAULT 'winner',
  `date` varchar(255) NOT NULL,
  `timeStamp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `cardGameItem`;
CREATE TABLE IF NOT EXISTS `cardGameItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'Belirlenmemiş',
  `reward` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '/main/includes/packages/layouts/card/image/default.png',
  `chance` varchar(255) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `categoryProduct`;
CREATE TABLE IF NOT EXISTS `categoryProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverID` int(11) NOT NULL,
  `categoryID` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) NOT NULL,
  `posters` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `serverType` int(11) NOT NULL DEFAULT '0',
  `commandServer` text NOT NULL,
  `productCommand` text NOT NULL,
  `productCount` int(11) NOT NULL DEFAULT '0',
  `productType` int(11) NOT NULL DEFAULT '0',
  `productDiscount` int(11) NOT NULL DEFAULT '0',
  `productTime` int(11) NOT NULL DEFAULT '0',
  `timeEndCommands` text NOT NULL,
  `text` text NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `chestHistory`;
CREATE TABLE IF NOT EXISTS `chestHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `usernameTo` varchar(255) NOT NULL,
  `serverName` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` varchar(255) NOT NULL,
  `productID` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `newsID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `custom` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `couponHistory`;
CREATE TABLE IF NOT EXISTS `couponHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `couponCode` varchar(255) NOT NULL,
  `couponID` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `couponItem`;
CREATE TABLE IF NOT EXISTS `couponItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `couponCode` varchar(255) NOT NULL,
  `couponID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `creditHistory`;
CREATE TABLE IF NOT EXISTS `creditHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 NOT NULL,
  `usernameTo` varchar(255) NOT NULL DEFAULT 'yourname',
  `method` varchar(255) CHARACTER SET utf8 NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `transID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 NOT NULL,
  `timeStamp` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `discountCoupon`;
CREATE TABLE IF NOT EXISTS `discountCoupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `couponCount` varchar(255) NOT NULL DEFAULT '0-0-0-0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `discountCouponHistory`;
CREATE TABLE IF NOT EXISTS `discountCouponHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `couponID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `forumCategory`;
CREATE TABLE IF NOT EXISTS `forumCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT 'Title',
  `text` varchar(255) NOT NULL DEFAULT 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'username',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `forumMessage`;
CREATE TABLE IF NOT EXISTS `forumMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topicID` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT 'username',
  `message` text NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `forumReport`;
CREATE TABLE IF NOT EXISTS `forumReport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reportType` varchar(255) NOT NULL DEFAULT 'topic',
  `status` int(11) NOT NULL DEFAULT '0',
  `messageID` int(11) NOT NULL DEFAULT '0',
  `reporter` varchar(255) NOT NULL DEFAULT 'username',
  `message` text NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `forumSubCategory`;
CREATE TABLE IF NOT EXISTS `forumSubCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL DEFAULT '0',
  `topicStatus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'username',
  `title` varchar(255) NOT NULL DEFAULT 'Title',
  `text` varchar(255) NOT NULL DEFAULT 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `forumTopic`;
CREATE TABLE IF NOT EXISTS `forumTopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT 'Title',
  `content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `commentStatus` int(11) NOT NULL DEFAULT '0',
  `pinned` int(255) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT 'username',
  `views` int(11) NOT NULL DEFAULT '0',
  `topicPriority` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `generalChat`;
CREATE TABLE IF NOT EXISTS `generalChat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `messageAuthorIP` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.0001 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `helpCenter`;
CREATE TABLE IF NOT EXISTS `helpCenter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Topic',
  `title` varchar(255) NOT NULL DEFAULT 'Title',
  `description` varchar(255) NOT NULL DEFAULT 'Description',
  `categoryIcon` varchar(255) NOT NULL DEFAULT '<i class="fas fa-question"></i>',
  `iconColor` varchar(255) NOT NULL DEFAULT '#fff',
  `iconBackgroundColor` varchar(255) NOT NULL DEFAULT '#000',
  `contents` text NOT NULL,
  `author` varchar(255) NOT NULL DEFAULT 'defualt',
  `views` int(11) NOT NULL DEFAULT '0',
  `useful` int(11) NOT NULL DEFAULT '0',
  `useless` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `helpCenter` (`id`, `name`, `title`, `description`, `categoryIcon`, `iconColor`, `iconBackgroundColor`, `contents`, `author`, `views`, `useful`, `useless`, `date`) VALUES
(1, 'Account', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'fa-user', '#bae6fd', '#0ea5e9', '[{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"}]', 'admin', 0, 0, 0, '25.07.2022 21:08:23'),
(2, 'Store', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'fa-shopping-cart', '#fecdd3', '#f43f5e', '[{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"}]', 'admin', 0, 0, 0, '25.07.2022 21:17:37'),
(3, 'Payment', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'fa-credit-card', '#bfdbfe', '#1d4ed8', '[{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"}]', 'admin', 0, 0, 0, '25.07.2022 21:20:38'),
(4, 'Frequently Asked Questions', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'fa-question', '#a7f3d0', '#059669', '[{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"},{\"title\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit.\",\"content\":\"<p>Lorem ipsum dolor sit amet consectetur adipiscing elit.<\\/p>\"}]', 'admin', 0, 0, 0, '25.07.2022 21:22:14');

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT 'en',
  `title` varchar(255) NOT NULL DEFAULT 'English',
  `author` varchar(255) NOT NULL DEFAULT 'username',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `languages` (`id`, `code`, `title`, `author`) VALUES
(1, 'tr', 'Türkçe', 'minexon'),
(2, 'en', 'English', 'minexon'),
(3, 'de', 'Deutsch', 'minexon'),
(4, 'fr', 'Français', 'minexon'),
(5, 'ru', 'Русский', 'minexon'),
(6, 'es', 'Español', 'minexon');

DROP TABLE IF EXISTS `lotteryJoins`;
CREATE TABLE IF NOT EXISTS `lotteryJoins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'username',
  `tickets` int(11) NOT NULL DEFAULT '0',
  `lotteryPass` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lotterySettings`;
CREATE TABLE IF NOT EXISTS `lotterySettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lotteryPass` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ticketPrice` int(11) NOT NULL DEFAULT '1',
  `starterDate` datetime NOT NULL DEFAULT '2022-01-01 00:00:00',
  `endDate` datetime NOT NULL DEFAULT '2022-01-01 00:00:00',
  `extraGiftStatus` int(11) NOT NULL DEFAULT '0',
  `extraGift` text NOT NULL,
  `comission` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `lotterySettings` (`id`, `lotteryPass`, `status`, `ticketPrice`, `starterDate`, `endDate`, `extraGiftStatus`, `extraGift`, `comission`) VALUES
(1, '0aed49e1ed4a970eaf2bed516d6c2cd1', 0, 1, '2022-01-01 00:00:00', '2022-01-01 00:00:00', 0, '[]', 0);

DROP TABLE IF EXISTS `lotteryWinners`;
CREATE TABLE IF NOT EXISTS `lotteryWinners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'username',
  `amount` int(11) NOT NULL DEFAULT '0',
  `tickets` int(11) NOT NULL DEFAULT '0',
  `chance` varchar(255) NOT NULL DEFAULT '0',
  `lotteryPass` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL,
  `instagram` varchar(255) NOT NULL DEFAULT 'https://www.instagram.com/MineXON.web.tr/',
  `facebook` varchar(255) NOT NULL DEFAULT 'https://www.facebook.com/MineXON/',
  `twitter` varchar(255) NOT NULL DEFAULT 'https://twitter.com/MineXON',
  `discord` varchar(255) NOT NULL DEFAULT 'https://discord.MineXON.web.tr/',
  `youtube` varchar(255) NOT NULL DEFAULT 'https://www.youtube.com/MineXON',
  `email` varchar(255) NOT NULL DEFAULT 'info@MineXON.web.tr',
  `widget` varchar(255) NOT NULL DEFAULT '786706437564923947',
  `status` int(11) NOT NULL DEFAULT '1',
  `alerts` int(11) NOT NULL DEFAULT '0',
  `liveSupportStatus` int(11) NOT NULL DEFAULT '0',
  `liveSupportEmbed` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `media` (`id`, `instagram`, `facebook`, `twitter`, `discord`, `youtube`, `email`, `widget`, `status`, `alerts`, `liveSupportStatus`, `liveSupportEmbed`) VALUES(0, '//www.instagram.com/MineXON.web.tr', '//www.facebook.com/MineXON', '//twitter.com/MineXON', '//discord.MineXON.web.tr/', 'https://www.youtube.com/MineXON', 'info@MineXON.web.tr', '786706437564923947', 1, 0, 0, '0');

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL,
  `extraCredit` int(11) NOT NULL DEFAULT '0',
  `extraCreditStatus` int(11) NOT NULL DEFAULT '0',
  `extraCreditText` text NOT NULL,
  `storeDiscount` int(11) NOT NULL DEFAULT '0',
  `storeDiscountStatus` int(11) NOT NULL DEFAULT '0',
  `storeDiscountText` text NOT NULL,
  `creditTransferStatus` int(11) NOT NULL DEFAULT '0',
  `giftTransferStatus` int(11) NOT NULL DEFAULT '1',
  `storeExProductStatus` int(11) NOT NULL DEFAULT '1',
  `broadcastStatus` int(11) NOT NULL DEFAULT '1',
  `sidebarStatus` int(11) NOT NULL DEFAULT '1',
  `preloaderStatus` int(11) NOT NULL DEFAULT '1',
  `generalChatStatus` int(11) NOT NULL DEFAULT '1',
  `personalizationMode` int(11) NOT NULL DEFAULT '1',
  `snowModeStatus` int(11) NOT NULL DEFAULT '0',
  `homeBarType` int(11) NOT NULL DEFAULT '0',
  `KDVStatus` int(11) NOT NULL DEFAULT '0',
  `KDVValue` int(11) NOT NULL DEFAULT '0',
  `maxSupportLimit` int(11) NOT NULL DEFAULT '3',
  `voteSystemStatus` int(11) NOT NULL DEFAULT '0',
  `voteSystemServerKey` varchar(255) NOT NULL DEFAULT 'XXX',
  `creditMultiplier` int(11) NOT NULL DEFAULT '1',
  `forumStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `module` (`id`, `extraCredit`, `extraCreditStatus`, `extraCreditText`, `storeDiscount`, `storeDiscountStatus`, `storeDiscountText`, `creditTransferStatus`, `giftTransferStatus`, `storeExProductStatus`, `broadcastStatus`, `sidebarStatus`, `preloaderStatus`, `generalChatStatus`, `personalizationMode`, `snowModeStatus`, `KDVStatus`, `KDVValue`, `maxSupportLimit`, `voteSystemStatus`, `voteSystemServerKey`, `creditMultiplier`, `forumStatus`) VALUES(0, 0, 0, 'Şuanda sitemizde %[credit] kredi bonusu mevcut!', 0, 0, 'Şuanda mağazamızda ki tüm ürünlerde %[discount] indirim bulunmakta!', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 3, 0, "XXX", "1", 0);

DROP TABLE IF EXISTS `newsCategory`;
CREATE TABLE IF NOT EXISTS `newsCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `newsCategory` (`id`, `name`, `date`) VALUES(1, 'Güncelleme', '05.02.2020 11:32:00');
INSERT INTO `newsCategory` (`id`, `name`, `date`) VALUES(2, 'Bilgi', '05.02.2020 11:39:00');
INSERT INTO `newsCategory` (`id`, `name`, `date`) VALUES(3, 'Duyuru', '05.02.2020 11:39:00');

DROP TABLE IF EXISTS `newsLike`;
CREATE TABLE IF NOT EXISTS `newsLike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `newsID` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `newsList`;
CREATE TABLE IF NOT EXISTS `newsList` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `text` text NOT NULL,
  `newsAuthor` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `newsHearts` varchar(255) NOT NULL DEFAULT '0',
  `newsDisplay` varchar(255) NOT NULL DEFAULT '0',
  `commentStatus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `newsTags`;
CREATE TABLE IF NOT EXISTS `newsTags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `newsID` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `page` (`id`, `username`, `title`, `description`, `date`) VALUES(1, 'demo', 'İNİNAL İLE ÖDEME NASIL YAPILIR?', '<h1 style=\"text-align:center\"><strong>İNİNAL &Ouml;DEME</strong></h1>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<ul>\r\n	<li><strong>İlk yapmanız gereken aşağıdaki ininal barkod hesabına y&uuml;klemek istediğiniz miktarı g&ouml;nderiniz.</strong></li>\r\n	<li><strong>Sonra bir destek talebi oluşturun ve bunu bize bildirin.</strong></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><strong>Barkod:&nbsp;<span style=\"color:#e74c3c\">000000000</span></strong></p>\r\n', '29.04.2021 12:52:51');
INSERT INTO `page` (`id`, `username`, `title`, `description`, `date`) VALUES(2, 'demo', 'TOSLA İLE ÖDEME NASIL YAPILIR?', '<h1 style=\"text-align:center\"><strong>TOSLA &Ouml;DEME</strong></h1>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<ul>\r\n	<li><strong>İlk yapmanız gereken aşağıdaki tosla barkod hesabına y&uuml;klemek istediğiniz miktarı g&ouml;nderiniz.</strong></li>\r\n	<li><strong>Sonra bir destek talebi oluşturun ve bunu bize bildirin.</strong></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><strong>Barkod:&nbsp;<span style=\"color:#e74c3c\">000000000</span></strong></p>\r\n', '29.04.2021 13:04:43');
INSERT INTO `page` (`id`, `username`, `title`, `description`, `date`) VALUES(3, 'demo', 'PAPARA İLE ÖDEME NASIL YAPILIR?', '<h1 style=\"text-align:center\"><strong>PAPARA &Ouml;DEME</strong></h1>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<ul>\r\n	<li><strong>İlk yapmanız gereken aşağıdaki papara barkod hesabına y&uuml;klemek istediğiniz miktarı g&ouml;nderiniz.</strong></li>\r\n	<li><strong>Sonra bir destek talebi oluşturun ve bunu bize bildirin.</strong></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><strong>Barkod:&nbsp;<span style=\"color:#e74c3c\">000000000</span></strong></p>\r\n', '29.04.2021 13:05:16');
INSERT INTO `page` (`id`, `username`, `title`, `description`, `date`) VALUES(4, 'demo', 'HAVALE/EFT İLE ÖDEME NASIL YAPILIR?', '<h1 style=\"text-align:center\"><strong>Havale/EFT ile &Ouml;DEME</strong></h1>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<ul>\r\n	<li><strong>İlk yapmanız gereken aşağıdaki banka hesabına y&uuml;klemek istediğiniz miktarı g&ouml;nderiniz.</strong></li>\r\n	<li><strong>Sonra bir destek talebi oluşturun ve bunu bize bildirin.</strong></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><strong>IBAN:&nbsp;<span style=\"color:#e74c3c\">TR00 0000 0000 0000 0000 0000 00</span></strong></p>\r\n', '29.04.2021 13:05:16');

DROP TABLE IF EXISTS `passwordRecovery`;
CREATE TABLE IF NOT EXISTS `passwordRecovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT 'YourName',
  `email` varchar(255) NOT NULL DEFAULT 'your@example.com',
  `token` varchar(255) NOT NULL DEFAULT 'XXXXXXXXXX',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payments` text NOT NULL,
  `variables` text NOT NULL,
  `creditPackets` text NOT NULL,
  `creditType` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `payments` (`id`, `payments`, `variables`, `creditPackets`, `creditType`) VALUES(1, 'disabled', '{\"stripeMode\":\"STRIPE-MODE\",\"stripePublishKey\":\"STRIPE-PUBLISH-KEY\",\"stripeSecretKey\":\"STRIPE-SECRET-KEY\",\"paypalMode\":\"PAYPAL-MODE\",\"paypalClientID\":\"PAYPAL-CLIENT-ID\",\"paypalClientSecret\":\"PAYPAL-CLIENT-SECRET\",\"paytrID\":\"PAYTR-ID\",\"paytrAPIKey\":\"PAYTR-API-KEY\",\"paytrAPISecretKey\":\"PAYTR-API-SECRET-KEY\",\"paywantAPIKey\":\"PAYWANT-API-KEY\",\"paywantAPISecretKey\":\"PAYWANT-API-SECRET-KEY\",\"paywantCommissionType\":\"2\",\"shipyAPIKey\":\"SHIPY-API-KEY\",\"paylithAPIKey\":\"PAYLITH-API-KEY\",\"paylithAPISecretKey\":\"PAYLITH-API-SECRET-KEY\",\"shopierAPIKey\":\"SHOPIER-API-KEY\",\"shopierAPISecretKey\":\"SHOPIER-API-SECRET-KEY\",\"batihostID\":\"BATIHOST-ID\",\"batihostToken\":\"BATIHOST-MERCHANT-TOKEN\",\"batihostEmail\":\"BATIHOST-MERCHANT-EMAIL\",\"keyubuID\":\"KEYUBU-MERCHANT-ID\",\"keyubuToken\":\"KEYUBU-MERCHANT-TOKEN\",\"rabisuID\":\"RABISU-MERCHANT-ID\",\"rabisuToken\":\"RABISU-MERCHANT-TOKEN\",\"transfer\":\"0\",\"ininal\":\"0\",\"papara\":\"0\",\"tosla\":\"0\"}', 'disabled', '0');

DROP TABLE IF EXISTS `paymentTransactions`;
CREATE TABLE IF NOT EXISTS `paymentTransactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentAPIType` varchar(255) NOT NULL DEFAULT 'disabled',
  `paymentID` varchar(255) NOT NULL,
  `variables` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `productPosters`;
CREATE TABLE IF NOT EXISTS `productPosters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `productRates`;
CREATE TABLE IF NOT EXISTS `productRates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productID` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `productStockHistory`;
CREATE TABLE IF NOT EXISTS `productStockHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `serverCategory`;
CREATE TABLE IF NOT EXISTS `serverCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) NOT NULL,
  `serverID` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `serverList`;
CREATE TABLE IF NOT EXISTS `serverList` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) NOT NULL,
  `connectIP` varchar(255) NOT NULL,
  `connectPort` varchar(255) NOT NULL,
  `connectPassword` varchar(255) NOT NULL,
  `connectType` varchar(255) NOT NULL DEFAULT 'websender',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `serverLogo` varchar(255) NOT NULL DEFAULT '/assets/uploads/images/landing/logo/default.png',
  `footerCardImage` varchar(255) NOT NULL DEFAULT '/assets/uploads/images/landing/footer/default.png',
  `headerLogo` varchar(255) NOT NULL DEFAULT '	/assets/uploads/images/landing/header/default.jpeg',
  `metaTitle` varchar(255) NOT NULL DEFAULT 'MineXON - Top Server',
  `metaDescription` varchar(255) NOT NULL DEFAULT 'You can edit this post from the admin panel.',
  `IPAdres` varchar(255) NOT NULL DEFAULT 'play.minexon.net',
  `metaSlogan` varchar(255) NOT NULL DEFAULT 'Best server ever',
  `serverName` varchar(255) NOT NULL DEFAULT 'MineXON',
  `pageAbouts` text NOT NULL,
  `metaKeyword` varchar(255) NOT NULL DEFAULT 'MineXON, HasanES, Minecraft,',
  `recaptchaPublicKey` varchar(255) NOT NULL DEFAULT 'XXXXXXX',
  `recaptchaPrivateKey` varchar(255) NOT NULL DEFAULT 'XXXXXXX',
  `recaptchaStatus` int(11) NOT NULL DEFAULT '0',
  `pageRules` text NOT NULL,
  `pagePrivacy` text NOT NULL,
  `serverOnlineStatusAPI` int(11) NOT NULL DEFAULT '1',
  `avatarAPI` int(11) NOT NULL DEFAULT '1',
  `commentsStatus` int(11) NOT NULL DEFAULT '0',
  `registerLimit` int(11) NOT NULL DEFAULT '0',
  `smtpServer` varchar(255) NOT NULL,
  `smtpPort` varchar(255) NOT NULL,
  `smtpSecure` int(11) NOT NULL,
  `smtpUsername` varchar(255) NOT NULL,
  `smtpPassword` varchar(255) NOT NULL,
  `smtpTemplate` text NOT NULL,
  `passwordHash` int(11) NOT NULL DEFAULT '0',
  `minimumLoadCredit` int(11) NOT NULL DEFAULT '1',
  `supportMessageTemplate` text NOT NULL,
  `debugModeStatus` int(11) NOT NULL DEFAULT '0',
  `SSLModeStatus` int(11) NOT NULL DEFAULT '0',
  `maintanceStatus` int(11) NOT NULL DEFAULT '0',
  `bannedType` int(11) NOT NULL DEFAULT '0',
  `defaultLanguage` varchar(255) NOT NULL DEFAULT 'en',
  `currency` varchar(255) NOT NULL DEFAULT 'USD',
  `apiKey` varchar(255) NOT NULL DEFAULT 'XXXXXXXXXX',
  `googleAI` varchar(255) NOT NULL DEFAULT '0',
  `defaultTimezone` varchar(255) NOT NULL DEFAULT 'Europe/Istanbul',
  `creditName` varchar(255) NOT NULL DEFAULT 'Gold',
  `creditIcon` varchar(255) NOT NULL DEFAULT '$',
  `salesAgreementType` int(11) NOT NULL DEFAULT '0',
  `salesAgreement` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `settings` (`id`, `serverLogo`, `footerCardImage`, `headerLogo`, `metaTitle`, `metaDescription`, `IPAdres`, `metaSlogan`, `serverName`, `pageAbouts`, `metaKeyword`, `recaptchaPublicKey`, `recaptchaPrivateKey`, `recaptchaStatus`, `pageRules`, `pagePrivacy`, `serverOnlineStatusAPI`, `avatarAPI`, `commentsStatus`, `registerLimit`, `smtpServer`, `smtpPort`, `smtpSecure`, `smtpUsername`, `smtpPassword`, `smtpTemplate`, `passwordHash`, `minimumLoadCredit`, `supportMessageTemplate`, `debugModeStatus`, `SSLModeStatus`, `maintanceStatus`, `bannedType`, `defaultLanguage`, `currency`, `apiKey`, `googleAI`, `defaultTimezone`, `creditName`, `creditIcon`, `salesAgreementType`, `salesAgreement`) VALUES(0, '/assets/uploads/images/landing/logo/u2P4I4d4V2D5.png', '/assets/uploads/images/landing/footer/w10L7F2h7S2O8.jpg', '/assets/uploads/images/landing/header/default.jpeg', 'MineXON - Top Server', 'You can edit this post from the admin panel.', 'play.minexon.net', 'Best server ever', 'MineXON', '<p><strong>[serverName]</strong>, g&uuml;n&uuml;n&uuml;z&uuml; harika ge&ccedil;irebileceğiniz bir eğlence platformu.<br />\r\n<br />\r\nY&uuml;klenen her kredi <strong>[serverName]</strong>&#39;ın daha da gelişmesine yardımcı olacak. Bu sunucu i&ccedil;in uzun s&uuml;redir gece g&uuml;nd&uuml;z dememeden &ccedil;alışıyoruz. Hedeflerimiz her zaman ileriye gitmek y&ouml;n&uuml;ndedir.<br />\r\n<br />\r\n<br />\r\n<strong>[serverName] Tanıtım Videosu:</strong><br />\r\n<iframe height=\"400\" src=\"https://www.youtube.com/embed/Y0ujP5Tkhjg\" width=\"100%\"></iframe><br />\r\n<br />\r\n<br />\r\nSevgilerle, <strong>[serverName]</strong></p>\r\n', 'SunucuCraft, MineXON, HasanES,', 'XXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXX', 0, '<p><strong>[serverName]</strong> Kuralları.</p>\r\n\r\n<p>1-&gt; Oyun y&ouml;neticilerini gereksiz ithamlarla, yalan belgelerle kandırmaya &ccedil;alışmak yasaktır.</p>\r\n\r\n<p>2-&gt; Oyuncuları &ouml;rg&uuml;tleyip bir kimseye veya bir gruba hakaret etmek, su&ccedil; atmak, gururunu kırmak yasaktır.</p>\r\n\r\n<p>3-&gt; Sohbetin akışını sabote edecek şekilde mesaj atmak (spam/flood) ceza sebebidir.</p>\r\n\r\n<p>4-&gt; Herhangi bir platformda <strong>[serverName]</strong> aleyhine paylaşımlar yapmak, marka değerini d&uuml;ş&uuml;ren ithamlarda ve/veya s&ouml;ylemlerde bulunmak yasaktır.</p>\r\n\r\n<p>5-&gt; Bir kimsenin &ouml;zel hayatına dair bilgileri <strong>[serverName]</strong> platformlarında yayınlamak ceza sebebidir. Fotoğraf, telefon numarası ve video gibi &ouml;ğeler dahildir.</p>\r\n\r\n<p>6-&gt; Oyun a&ccedil;ıklarını kullanıp haksız kazan&ccedil; elde etmek yasaktır.</p>\r\n\r\n<p>7-&gt; <strong>[serverName]</strong> platformlarında siyasi, dini g&ouml;r&uuml;şlere hakaret etmek veya aşağılayıcı kelimeler sarfetmek ceza sebebidir.</p>\r\n\r\n<p>8-&gt; <strong>[serverName]</strong> sunucusunda oyun i&ccedil;i veya oyunla ilgisi olmayan unsurların/hizmetlerin; para,&nbsp;site kredisi&nbsp;karşılığında, para değeri olan/olmayan &ouml;geler ve benzerleri karşılığında ticaretin yapılması/yapılmaya teşebb&uuml;s edilmesi ceza sebebidir.</p>\r\n\r\n<p>9-&gt; Oyun y&ouml;neticileri gerekli g&ouml;rd&uuml;ğ&uuml; hallerde asıl/yan hesaplarınızı ve arkadaşlarınızı oyundan uzaklaştırabilir.</p>\r\n\r\n<p>10-&gt; Farklı bir şekilde oyun oynama avantajı sağlayan herhangi bir client/mod kullanmak yasaktır. Yasadışı client veya modlar kullanmak kesinlikle yasaktır. Kill aura, anti-knockback, x-rayler, auto-clickerlar, makro basışları, freecamlar, oyuncu lokasyonunu g&ouml;steren mapler, u&ccedil;mak yasadışı modlara &ouml;rneklerdir. Regedit de buna dahil (Kayıt defterini d&uuml;zenleme). Bile bile yasadışı modlar kullanan kişiler ile takım olmak sizide yasaklandırabilir.</p>\r\n\r\n<p>11-&gt; Kimliğe b&uuml;r&uuml;nmek, diğer oyuncuları sizi bir yetkili veya bir YouTuber olduğunuza inandırmaya zorlamaya &ccedil;alışmak olarak tanımlanır. Kimliğe b&uuml;r&uuml;nme kesin olarak yasaktır.</p>\r\n\r\n<p>12-&gt; Reklamcılık diğer sunucuların, sosyal medya hesaplarının, Youtube Twitch hesaplarının veya diğer herhangi mal veya hizmetin tanıtımı olarak tanımlanır. Youtube&#39;un veya yayın yapmanın hafif reklamlarına izin verilir, ancak spam yapılır veya k&ouml;t&uuml;ye kullanılması durumunda ceza ile sonu&ccedil;lanacaktır. Youtuber rankına sahip kullanıcılar kendi kanallarını veya diğer sosyal medya hesaplarını reklam yapabilir.</p>\r\n', '<p>İşbu gizlilik politikası (&ldquo;Gizlilik Politikası&rdquo;) ile, <strong>[serverName]</strong> tarafından size oyunlarımızı, uygulamalarımızı, internet sitelerimizi ve ve mobil cihazlar veya masa&uuml;st&uuml; cihazlar kullanarak gibi nasıl eriştiğiniz dikkate alınmaksızın hizmetlerimizi (&ldquo;<strong>[serverName]</strong> Hizmetleri&rdquo;) kullanmanız sırasında ne gibi bilgileri topladığımız ve bunları nasıl kullanabileceğimizi a&ccedil;ıklamaktadır.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>1-) TOPLADIĞIMIZ BİLGİLER</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\n1.1) <strong>[serverName]</strong> Hizmetleri kullanımınız sırasında bilgi girişi yaparak sağladığınız bilgileri topluyoruz. Aşağıdakiler bunlar arasındadır:<br />\r\n- E-posta adresiniz, doğum tarihiniz, oyun i&ccedil;i adınız (rumuz) ve benzer iletişim bilgileriniz.<br />\r\n- <strong>[serverName]</strong> Hizmetleri&rsquo;ne erişimin g&uuml;venliğini sağlamamız i&ccedil;in bize yardımcı olan kullanıcı adınız ve oturum a&ccedil;ma tarihleriniz, IP adresleriniz gibi ayrıntılar.<br />\r\n- Satın alımlarınızın işlenmesinde yardımcı olması i&ccedil;in adınız, fatura adresiniz, telefon numaranız, &ouml;deme methodunuz ve başka ayrıntılar.<br />\r\n- Yardım Merkezi ile ilgili bilgileriniz. Yardıma ihtiyacınız olduğu konular, destek talepleriniz, hesap ve sipariş ayrıntılarınız.<br />\r\n- Tercihleriniz, ilgi alanlarınız ve genel demografik bilgiler.<br />\r\n- Yarışma veya &ccedil;ekilişlerle bağlantılı olarak bizimle paylaştığınız bilgiler.<br />\r\n- <strong>[serverName]</strong> hesabı bilgileriniz.<br />\r\n<br />\r\n1.2) <strong>[serverName]</strong> Hizmetleri kullanımınız sırasında kullanım deneyiminizi, etkileşimi nasıl y&uuml;r&uuml;tt&uuml;ğ&uuml;n&uuml;z&uuml; ve bunları yapmak i&ccedil;in kullandığınız cihaz ve yazılımı anlamak i&ccedil;in birtakım bilgiler topluyoruz. Aşağıdakiler bunlar arasındadır:<br />\r\n- <strong>[serverName]</strong> Hizmetleri&rsquo;ni kullanmanız sırasındaki zaman damgaları, g&ouml;z atma s&uuml;releri, tıklamalar, kaydırmalar, y&ouml;nlendirme/&ccedil;ıkış sayfaları ve oyun i&ccedil;i faaliyetler.<br />\r\n- Bilgisayarınızın benzersiz ID&rsquo;leri, markası, modeli, donanım &ouml;zellikleri, ip adresiniz, konumunuz, &ccedil;&ouml;z&uuml;n&uuml;rl&uuml;ğ&uuml;n&uuml;z.<br />\r\n- Tarayıcı s&uuml;r&uuml;m&uuml;n&uuml;z, işletim sisteminiz ve s&uuml;r&uuml;m&uuml;, internet servis sağlayıcınız.<br />\r\n- <strong>[serverName]</strong> Hizmetleri kullanımı sırasında aldığınız performans bilgileri. FPS durumunuz, ping durumunuz.<br />\r\n&nbsp;</p>\r\n\r\n<p><strong>2) BİLGİLERİ NASIL TOPLADIĞIMIZ</strong></p>\r\n\r\n<p>Sizin sağladığınız bilgilere ek olarak <strong>[serverName]</strong> Hizmetleri kullanımınız sırasında bazı verileri otomatik olarak topluyor ve kaydediyoruz. Bu bilgiler <strong>[serverName]</strong> Hizmetleri&rsquo;nin sağlanabilmesi i&ccedil;in gerekli bilgilerdir.<br />\r\n- &Ccedil;erezler ve bağlantılı teknolojiler ile.<br />\r\n- Web sitelerimiz aracılığıyla.<br />\r\n- Oyun istemcimizden ve programlarımızdan.<br />\r\n&nbsp;</p>\r\n\r\n<p><strong>3) BİLGİLERİ NASIL KULLANDIĞIMIZ</strong></p>\r\n\r\n<p>Bilgileri <strong>[serverName]</strong> Hizmetleri&rsquo;nin tedarik edilmesi, geliştirilmesi, iyileştirilmesi, daha iyi kullanıcı deneyimleri oluşturma, pazarlama konularında bize yardımcı olmaları i&ccedil;in aşağıdaki yasal dayanaklara uygun olarak kullanıyor ve paylaşıyoruz.<br />\r\n<br />\r\n3.1) Yasal Dayanak<br />\r\n- Hizmet Şartları&rsquo;nın uygulanması ve <strong>[serverName]</strong> Hizmetleri&rsquo;nin tedariki i&ccedil;in gerekli olduğu şekillerde.<br />\r\n- Bilgilerinizin işlenmesi i&ccedil;in muvafakat verdiğiniz hallerde.<br />\r\n- <strong>[serverName]</strong>&rsquo;nun yasal zorunluluğa veya bir mahkeme kararına uyması veya yasal hakkını kullanması ve savunması i&ccedil;in.<br />\r\n- Sizin ve başkalarının yaşamsal &ccedil;ıkarlarını korumak i&ccedil;in.<br />\r\n- Kamu yararı i&ccedil;in gerekli olan durumlarda.<br />\r\n<br />\r\n3.2) Bilgilerin Kullanılması<br />\r\nTopladığımız bilgileri <strong>[serverName]</strong> Hizmetleri&rsquo;nin tedariki, hizmetlerin geliştirilmesi ve iyileştirilmesi, sizinle iletişimimizi y&uuml;r&uuml;tmemizde ve reklam faaliyetlerimizi d&uuml;zenlememizde yardımcı olması i&ccedil;in kullanıyoruz.<br />\r\n<br />\r\nAyrıca gerekli veya uygun olduğu hallerde (yasal y&uuml;k&uuml;ml&uuml;l&uuml;k, meşru bir &ccedil;ıkar, kamu yararı i&ccedil;in, sizin veya 3. şahısların yaşamsal &ccedil;ıkarlarını korumak i&ccedil;in) de bilgileri kullanabilir ve ifşa ve muhafaza edebiliriz. Aşağıdakiler bu gibi durumlara &ouml;rnektir:<br />\r\n- Kanunların gereği yerine getirmek veya bir yasal s&uuml;rece karşılık vermek.<br />\r\n- <strong>[serverName]</strong> Hizmetleri&rsquo;nin g&uuml;venli bir şekilde y&uuml;r&uuml;t&uuml;lmesini sağlamak.<br />\r\n- Kullanıcıları veya &uuml;&ccedil;&uuml;nc&uuml; şahısları korumak i&ccedil;in.<br />\r\n- Kendi haklarımızı, faaliyetlerimizi ve m&uuml;lkiyetlerimizi korumak i&ccedil;in.<br />\r\n<br />\r\n3.3) Bilgilerin Paylaşılması<br />\r\nİletişim bilgilerinizi (e-posta adresiniz veya ev adresiniz gibi) sizin bilginiz olmadan bağımsız &uuml;&ccedil;&uuml;nc&uuml; şahıslarla paylaşmıyoruz.<br />\r\n<br />\r\n3.4) Sohbet ve Oyuncu Davranışları<br />\r\nOyuncularımızın oyun i&ccedil;i davranışlarının Hizmet Şartları, Kullanım Kuralları ve T&uuml;rkiye Cumhuriyeti kanunlarına uygunluğunu denetlemek i&ccedil;in &ouml;zel veya kamuya a&ccedil;ık mesajlarınız, hareket kalıplarınız, tıklamalarınız gibi verileri manuel ara&ccedil;lar veya teknikler (destek sistemimizden bize bildirmeniz veya oyuncuları denetlemesi i&ccedil;in g&ouml;revlendirdiğimiz &ccedil;alışanlar gibi) ile veya otomatik sistemler (oyuncu davranışlarını inceleyen yapay zeka sistemler veya mesaj aktivitelerini denetleyen sistemler gibi) aracılığıyla inceliyor ve işliyoruz.<br />\r\n&nbsp;</p>\r\n\r\n<p><strong>4) &Uuml;&Ccedil;&Uuml;NC&Uuml; ŞAHIS WEB SİTELERİ VE HİZMETLERİ</strong></p>\r\n\r\n<p>Tecr&uuml;benizi daha iyi kılmak, kullanıcı davranışlarını daha iyi anlamak veya pazarlama stratejilerimize yardımcı olmaları i&ccedil;in &uuml;&ccedil;&uuml;nc&uuml; şahıslarla etkileşimlerinize izin veriyoruz ancak politikamız, sahibi olmadığımız, kontrol&uuml;m&uuml;zde olmayan ve talimat vermediğimiz kurumlar i&ccedil;in ge&ccedil;erli değildir ve hi&ccedil;bir şekilde ge&ccedil;erli olmasına imkan yoktur. Bağımsız &uuml;&ccedil;&uuml;nc&uuml; şahısların bizimle aynı uygulamaları benimsemiş olmalarına dair bir garanti vermemize imkan yoktur.</p>\r\n', 1, 1, 1, 0, 'smtp.gmail.com', '465', 1, 'support@MineXON.web.tr', 'xxxxx', '<p style=\"text-align: center;\"><img src=\"https://www.minelab.web.tr/main/theme/assets/img/landing/brand-logo-text.png\" width=\"220\" height=\"80\" class=\"fr-fic fr-dii\"></p><p><br></p><div style=\"justify-content: center; align-items: center; text-align:center; width: 500px; height: 500px; background: #fff; border-radius: 25px; padding: 3rem; border: #f0f0f0 3px solid; border-left: #06b6d4 5px solid;border-right: #06b6d4 5px solid;  margin-left: 7rem;\"><p style=\"text-align: center; color: black; font-weight: 600; font-size: 18px; padding-top: 1rem;\">Sayın, <span style=\" font-weight: 900;\">[username]</span></p><p style=\"text-align: center; color: black; font-weight: 600; font-size: 18px; padding-top: 2rem;\"><span style=\" font-weight: 600;\"><br>Senin eski şifreni g&ouml;nderemeyiz.&nbsp;</span><span style=\" font-weight: 600;\"><br>Eski şifreni sıfırlaman i&ccedil;in bir bağlantı oluşturulduk.</span><span style=\" font-weight: 600;\"><br>Şifreni sıfırlamak i&ccedil;in aşağıdaki bağlantıya tıkla ve talimatları uygula. &nbsp;</span></p><br><br><br><a href=\"[url]\" style=\"background: #06b6d4; text-align: center; width: 60px; padding: 1rem; border-radius: .3rem; margin-top: 10rem; font-size: 18px; color: #f1f1f1;\">Şifreyi Değiştir</a></div><p><br></p>', 0, 1, '<p>Merhaba <strong>[username]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>[message]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>[serverName] Destek Hattı</strong></p>\r\n\r\n<p><strong>Yanıtlayan Yetkili:&nbsp;</strong>[admin]</p>\r\n\r\n<p><strong>Sunucu IP Adresi:</strong>&nbsp;[serverIP]</p>\r\n', 0, 0, 0, 0, 'en', 'USD', 'XXXXXXXXX', '0', 'Europe/Istanbul', 'Gold', '$', '0', 'Tester');

DROP TABLE IF EXISTS `shoppingCart`;
CREATE TABLE IF NOT EXISTS `shoppingCart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `productCount` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `storeHistory`;
CREATE TABLE IF NOT EXISTS `storeHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverID` int(11) NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `productPrice` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `supportCategory`;
CREATE TABLE IF NOT EXISTS `supportCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `supportCategory` (`id`, `title`, `date`) VALUES(1, 'Diğer', '01.01.2022 00:00:00');
INSERT INTO `supportCategory` (`id`, `title`, `date`) VALUES(2, 'Hile', '01.01.2022 00:00:00');
INSERT INTO `supportCategory` (`id`, `title`, `date`) VALUES(3, 'Hata / Bug / Açık', '01.01.2022 00:00:00');

DROP TABLE IF EXISTS `supportList`;
CREATE TABLE IF NOT EXISTS `supportList` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `serverName` varchar(255) NOT NULL DEFAULT 'Diğer',
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `lockStatus` int(11) NOT NULL DEFAULT '0',
  `lastUpdate` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2021 00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `supportReadyAnswers`;
CREATE TABLE IF NOT EXISTS `supportReadyAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `supportReply`;
CREATE TABLE IF NOT EXISTS `supportReply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `supportID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2021 00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `systemNotifications`;
CREATE TABLE IF NOT EXISTS `systemNotifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `text` text NOT NULL,
  `variables` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL,
  `CSS` text NOT NULL,
  `themeColor` int(11) NOT NULL DEFAULT '0',
  `defaultVariables` text NOT NULL,
  `southVariables` text NOT NULL,
  `sitaryVariables` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `theme` (`id`, `CSS`, `themeColor`, `defaultVariables`, `southVariables`, `sitaryVariables`) VALUES(0, 'body {\r\n}', 0, '{"bodyImage":"\/assets\/uploads\/images\/landing\/images\/default\/j4G5Z4m4R7V6.png","headerImage":"\/assets\/uploads\/images\/landing\/images\/default\/e3K8A8l9P4M4.jpg","footerImage":"\/assets\/uploads\/images\/landing\/images\/default\/m4L5P8a10N10D7.jpg","storeImage":"\/assets\/uploads\/images\/landing\/images\/default\/z9V5I7m8F10J8.jpg","bodyType":"1","navbarType":"0","headerBlur":"1","headerParticles":"1","color":{"50":"#fff7ed","100":"#ffedd5","200":"#fed7aa","300":"#fdba74","400":"#884106","500":"#632d08","600":"#652707","700":"#441a08","800":"#341105","900":"#1d0902"}}', '{"bodyImage":"\/assets\/uploads\/images\/landing\/images\/sitary\/y9W9U5b1T9Q10.jpg","footerImage":"\/assets\/uploads\/images\/landing\/images\/sitary\/k8L9B5f43J3.png","bodyType":"2","defaultColor":"dark"}', '{"bodyImage":"\/assets\/uploads\/images\/landing\/images\/sitary\/u1W1K103P5R6.jpg","headerImage":"\/assets\/uploads\/images\/landing\/images\/sitary\/z8M1R3s9L6B8.jpg","footerImage":"\/assets\/uploads\/images\/landing\/images\/sitary\/a5B4K1j3G7S4.png","bodyType":"2","color":{"400":"#ce2525","500":"#9b1515"}}');

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '/admin/theme/assets/light/images/placeholder.jpg',
  `fileSlug` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `themesStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `themes` (`id`, `name`, `text`, `code`, `image`, `fileSlug`, `date`, `status`, `themesStatus`) VALUES(1, 'Default', 'Zevkine göre uyarla, farkını yarat.', 'dft-632', '/assets/uploads/images/landing/themes/default.jpg', 'default', '01.01.2022 00:00:00', 1, 1);
INSERT INTO `themes` (`id`, `name`, `text`, `code`, `image`, `fileSlug`, `date`, `status`, `themesStatus`) VALUES(2, 'South', 'Eşsiz görünümü ile oyuncularının gözlerini şenlendir.', 'sht-326', '/assets/uploads/images/landing/themes/south.jpg', 'south', '01.01.2022 00:00:00', 0, 1);
INSERT INTO `themes` (`id`, `name`, `text`, `code`, `image`, `fileSlug`, `date`, `status`, `themesStatus`) VALUES(3, 'Sitary', 'Yepyeni görünüş ile farkını ortaya koy.', 'stry-510', '/assets/uploads/images/landing/themes/sitary.jpg', 'sitary', '29.01.2022 21:00:00', 0, 1);
INSERT INTO `themes` (`id`, `name`, `text`, `code`, `image`, `fileSlug`, `date`, `status`, `themesStatus`) VALUES(4, 'Darken (MCTHEMES)', 'Karalığın derinlerinde kendini bul.', 'dark-7126', '/assets/uploads/images/landing/themes/darken.jpg', 'dark', '12.04.2022 21:00:00', 0, 1);

DROP TABLE IF EXISTS `uploadsImage`;
CREATE TABLE IF NOT EXISTS `uploadsImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT 'Resim Yükleme',
  `image` varchar(255) NOT NULL DEFAULT '/assets/uploads/images/upload/default.png',
  `imageName` varchar(255) NOT NULL DEFAULT 'default.png',
  `date` varchar(255) NOT NULL DEFAULT '01.01.2022 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `uploadsImage` (`id`, `title`, `image`, `imageName`, `date`) VALUES(1, 'SMTP Logo', '/assets/uploads/images/upload/smtp-logo.png', 'smtp-logo.png', '27.04.2021 03:40:36');
INSERT INTO `uploadsImage` (`id`, `title`, `image`, `imageName`, `date`) VALUES(2, 'Card Reward Empty', '/assets/uploads/images/upload/box.png', 'box.png', '29.04.2021 11:59:09');
INSERT INTO `uploadsImage` (`id`, `title`, `image`, `imageName`, `date`) VALUES(3, 'Card Reward Invent', '/assets/uploads/images/upload/gift-box.png', 'gift-box.jpg', '29.04.2021 12:02:44');
INSERT INTO `uploadsImage` (`id`, `title`, `image`, `imageName`, `date`) VALUES(4, 'Card Reward Credit', '/assets/uploads/images/upload/coin.png', 'coin.png', '29.04.2021 12:05:02');

DROP TABLE IF EXISTS `userChest`;
CREATE TABLE IF NOT EXISTS `userChest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `webhooks`;
CREATE TABLE IF NOT EXISTS `webhooks` (
  `id` int(11) NOT NULL,
  `webhookCreditStatus` int(11) NOT NULL DEFAULT '0',
  `webhookCreditImage` varchar(255) NOT NULL DEFAULT '0',
  `webhookCreditName` varchar(255) NOT NULL DEFAULT '[username]',
  `webhookCreditTitle` text NOT NULL,
  `webhookCreditDescription` text NOT NULL,
  `webhookCreditAPI` varchar(255) NOT NULL DEFAULT 'XXXXX',
  `webhookCreditSignature` int(11) NOT NULL DEFAULT '0',
  `webhookStoreStatus` int(11) NOT NULL DEFAULT '0',
  `webhookStoreImage` varchar(255) NOT NULL DEFAULT '0',
  `webhookStoreName` varchar(255) NOT NULL DEFAULT '[username]',
  `webhookStoreTitle` text NOT NULL,
  `webhookStoreDescription` text NOT NULL,
  `webhookStoreAPI` varchar(255) NOT NULL DEFAULT 'XXXXX',
  `webhookStoreSignature` int(11) NOT NULL DEFAULT '0',
  `webhookNewsStatus` int(11) NOT NULL DEFAULT '0',
  `webhookNewsImage` varchar(255) NOT NULL DEFAULT '0',
  `webhookNewsName` varchar(255) NOT NULL DEFAULT '[username]',
  `webhookNewsTitle` text NOT NULL,
  `webhookNewsDescription` text NOT NULL,
  `webhookNewsAPI` varchar(255) NOT NULL DEFAULT 'XXXXX',
  `webhookNewsSignature` int(11) NOT NULL DEFAULT '0',
  `webhookCommentStatus` int(11) NOT NULL DEFAULT '0',
  `webhookCommentImage` varchar(255) NOT NULL DEFAULT '0',
  `webhookCommentName` varchar(255) NOT NULL DEFAULT '[username]',
  `webhookCommentAPI` varchar(255) NOT NULL,
  `webhookCommentTitle` text NOT NULL,
  `webhookCommentDescription` text NOT NULL,
  `webhookCommentSignature` int(11) NOT NULL DEFAULT '1',
  `webhookSupportStatus` int(11) NOT NULL DEFAULT '0',
  `webhookSupportImage` varchar(255) NOT NULL DEFAULT '0',
  `webhookSupportName` varchar(255) NOT NULL DEFAULT '[username]',
  `webhookSupportTitle` text NOT NULL,
  `webhookSupportDescription` text NOT NULL,
  `webhookSupportAPI` varchar(255) NOT NULL DEFAULT 'XXXXX',
  `webhookSupportSignature` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `webhooks` (`id`, `webhookCreditStatus`, `webhookCreditImage`, `webhookCreditName`, `webhookCreditTitle`, `webhookCreditDescription`, `webhookCreditAPI`, `webhookCreditSignature`, `webhookStoreStatus`, `webhookStoreImage`, `webhookStoreName`, `webhookStoreTitle`, `webhookStoreDescription`, `webhookStoreAPI`, `webhookStoreSignature`, `webhookNewsStatus`, `webhookNewsImage`, `webhookNewsName`, `webhookNewsTitle`, `webhookNewsDescription`, `webhookNewsAPI`, `webhookNewsSignature`, `webhookCommentStatus`, `webhookCommentImage`, `webhookCommentName`, `webhookCommentAPI`, `webhookCommentTitle`, `webhookCommentDescription`, `webhookCommentSignature`, `webhookSupportStatus`, `webhookSupportImage`, `webhookSupportName`, `webhookSupportTitle`, `webhookSupportDescription`, `webhookSupportAPI`, `webhookSupportSignature`) VALUES(0, 0, '0', '[username]', 'Yeni bir bağış geldi!', '> Yükleyen: **[username]**\r\n> Miktar: **[credit]**₺\r\n> Bizi desteklediğin için teşekkür ederiz **[username]**', 'https://discord.com/api/webhooks/0/X', 1, 0, '0', '[username]', 'Yeni bir ürün satın alımı gerçekleşti!', '> **[username]** adlı oyuncu **[server]** sunucusundan **[product]** adlı ürünü satın aldı!\r\n> Hayırlı olsun güle güle kullan **[username]**', 'https://discord.com/api/webhooks/0/X', 1, 1, '0', '[username]', 'Yeni bir haber yayınlandı!', '> **[username]** adlı yetkili **[title]** başlıklı bir haber yayınladı!\r\n> \r\n> **Haber Bağlantısı**: [url]', 'https://discord.com/api/webhooks/935876753430298624/rvvI20vGs07w6dnBhkm2mQPKQzdVMNMnQCcp5yHMR6CqCrvlTAHNNpsjI7zk-jaIUHXk', 0, 0, '0', '[username]', 'https://discord.com/api/webhooks/0/X', 'Yeni bir yorum geldi!', '> **[username]** adlı oyuncu bir habere yorum yaptı!\r\n> \r\n> **Haber Bağlantısı:** [url]', 0, 0, '0', '[username]', 'Yeni bir destek talebi oluşturuldu!', '> **[username]** adlı kullanıcı bir destek mesajı gönderdi!\r\n> \r\n> **Bağlantı:** [url]', 'https://discord.com/api/webhooks/0/X', 1);