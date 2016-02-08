CREATE TABLE IF NOT EXISTS `flash_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(45) NOT NULL DEFAULT 'info',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
