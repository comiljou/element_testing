CREATE TABLE IF NOT EXISTS `stored_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hid` char(26) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('completed','failed') NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `ip` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;