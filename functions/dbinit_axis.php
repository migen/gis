<?php

function dbinit_axis($db){
	
$q=\'
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `03_paymodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(2) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `dates` varchar(160) NOT NULL,
  `count` tinyint(2) DEFAULT NULL,
  `periods` varchar(200) DEFAULT NULL,
  `surcharge` decimal(3,2) DEFAULT '1.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


INSERT INTO `03_paymodes` (`id`, `code`, `name`, `dates`, `count`, `periods`, `surcharge`) VALUES
(1, 'y1', 'Yearly', '', 1, '', '0.25'),
(2, 's2', 'Semi-yearly', '2017-10-16', 2, '06,10', '0.25'),
(3, 'm3', 'Monthly', '2017-06-30,2017-07-31,2017-08-31,2017-09-29,2017-10-16,2017-11-29,2017-12-11', 8, '04,07,08,09,10,11,12', '1.00'),
(4, 'q4', 'Quarterly', '2017-08-07,2017-10-16,2017-12-11', 4, '04,08,10,12', '0.50');


CREATE TABLE IF NOT EXISTS `30_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `terminal` tinyint(2) DEFAULT NULL,
  `ecid` int(11) DEFAULT '0',
  `date` date DEFAULT NULL,
  `c05` int(11) DEFAULT NULL,
  `c10` int(11) DEFAULT NULL,
  `c25` int(11) DEFAULT NULL,
  `c50` int(11) DEFAULT NULL,
  `1` int(11) DEFAULT NULL,
  `5` int(11) DEFAULT NULL,
  `10` int(11) DEFAULT NULL,
  `20` int(11) DEFAULT NULL,
  `50` int(11) DEFAULT NULL,
  `100` int(11) DEFAULT NULL,
  `200` int(11) DEFAULT NULL,
  `500` int(11) DEFAULT NULL,
  `1000` int(11) DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT NULL,
  `sales` decimal(10,2) DEFAULT NULL,
  `is_finalized` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `composite` (`date`,`terminal`,`ecid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


';

$db->query($q);


}	/* fxn */

