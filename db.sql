CREATE DATABASE IF NOT EXISTS `register_login_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `register_login_db`;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `countries` (`id`, `country_name`) VALUES
  (1, 'Ukraine'),
  (2, 'Poland'),
  (3, 'USA'),
  (4, 'Canada'),
  (5, 'Germany'),
  (6, 'Egypt'),
  (7, 'Russia'),
  (8, 'Lithuania'),
  (9, 'France'),
  (10, 'Portugal'),
  (11, 'Mexico'),
  (12, 'China'),
  (13, 'Japan'),
  (14, 'South Africa');


CREATE TABLE `registered_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `birth_date` date NOT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;