CREATE TABLE IF NOT EXISTS `users_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `forname` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users_admin` (`id`, `name`, `forname`) VALUES
(1, 'Thibault', 'Truffert');
INSERT INTO `users_admin` (`id`, `name`, `forname`) VALUES
(2, 'Alex', 'Taurisano');

ALTER TABLE `users_admin`
  ADD CONSTRAINT `users_admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `groups` (`name`) VALUES ('administrators');
