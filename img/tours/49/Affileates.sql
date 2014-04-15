-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg45.eigbox.net
-- Generation Time: Mar 21, 2014 at 06:05 AM
-- Server version: 5.5.32
-- PHP Version: 4.4.9
-- 
-- Database: `eidev`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `affiliatedeals`
-- 

CREATE TABLE `affiliatedeals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `redeemoutletid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `promotionid` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `affiliatecode` char(50) DEFAULT NULL,
  `voucherlistid` int(11) NOT NULL,
  `defaultlink` longtext,
  `contractterms` longtext,
  `affiliatefee` float NOT NULL,
  `currencyid` int(11) NOT NULL,
  `clientsplit` float NOT NULL,
  `artistsplit` float NOT NULL,
  `recordstatus` int(11) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `datechanged` datetime DEFAULT NULL,
  `datedeleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `affiliatedeals`
-- 

INSERT INTO `affiliatedeals` (`id`, `name`, `redeemoutletid`, `clientid`, `promotionid`, `description`, `affiliatecode`, `voucherlistid`, `defaultlink`, `contractterms`, `affiliatefee`, `currencyid`, `clientsplit`, `artistsplit`, `recordstatus`, `datecreated`, `datechanged`, `datedeleted`) VALUES (1, 'See Ticket (Default)', 1, 0, 0, 'Ei to See standard affiliate deal', 'EISEEXX', 0, 'http://www.seetickets.com/music-tickets', 'Entertainment Intelligence will direct fans from artists websites and social networks to See Tickets and collect sales data to report to their label and management. We will collect affiliate fees based on incoming sales figures.', 0.25, 226, 0.1, 0.1, 1, '2014-03-21 05:57:56', NULL, NULL);
