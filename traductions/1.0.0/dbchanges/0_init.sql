CREATE TABLE IF NOT EXISTS `link_expressions_traductions` (
  `traduction_id` int(11) NOT NULL,
  `expression_id` varchar(40) NOT NULL,
  PRIMARY KEY (`traduction_id`,`expression_id`),
  KEY `link_expressions_traductions_ibfk_2` (`expression_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `link_files_expressions` (
  `file_id` int(11) NOT NULL,
  `expression_id` varchar(40) NOT NULL,
  PRIMARY KEY (`file_id`,`expression_id`),
  KEY `link_files_expressions_ibfk_2` (`expression_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `link_files_traductions` (
  `file_id` int(11) NOT NULL,
  `traduction_id` int(11) NOT NULL,
  PRIMARY KEY (`file_id`,`traduction_id`),
  KEY `link_files_traductions_ibfk_2` (`traduction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `translator_expressions` (
  `id` varchar(40) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `translator_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `absolute_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_absolute_path` (`absolute_path`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `translator_traductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(6) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=382 ;

ALTER TABLE `link_expressions_traductions`
  ADD CONSTRAINT `link_expressions_traductions_ibfk_1` FOREIGN KEY (`traduction_id`) REFERENCES `translator_traductions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `link_expressions_traductions_ibfk_2` FOREIGN KEY (`expression_id`) REFERENCES `translator_expressions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `link_files_expressions`
  ADD CONSTRAINT `link_files_expressions_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `translator_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `link_files_expressions_ibfk_2` FOREIGN KEY (`expression_id`) REFERENCES `translator_expressions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `link_files_traductions`
  ADD CONSTRAINT `link_files_traductions_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `translator_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `link_files_traductions_ibfk_2` FOREIGN KEY (`traduction_id`) REFERENCES `translator_traductions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
