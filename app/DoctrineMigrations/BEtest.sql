-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 19, 2014 at 10:36 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `BEtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `check_in`
-- Note: This is a table that collects rider check-ins on RidePal buses
-- Columns:
--   check_in_id: unique id for bus
--   user_id: unique id for a rider
--   time: time of checkin
--   date: date of checkin

CREATE TABLE `check_in` (
  `check_in_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`check_in_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=45720 ;

--
-- Dumping data for table `check_in`
-- Note: this is just sample data. Please create your own when implementing the API.
--

INSERT INTO `check_in` (`check_in_id`, `user_id`, `time`, `date`) VALUES
(24122, 584, '07:13:54', '2013-09-03'),
(24123, 2435, '07:19:06', '2013-09-03'),
(24124, 2716, '07:33:55', '2013-09-03'),
(45719, 1417, '09:03:28', '2014-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `items`
-- Note: this table contains the kinds of passes that a rider may purchase on the RidePal website
-- Columns:
--   item_id: unique id for an item
--   description:  name of an item
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
-- Note:  this is NOT sample data and should not be altered.
--

INSERT INTO `items` (`item_id`, `description`) VALUES
(1, 'single ride'),
(2, 'daily pass'),
(3, '10 ridepack'),
(4, 'monthly pass');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
-- Note:  a table that contains the summary details of purchases made by riders on the RidePal website
--        Orders are composed of a non-null set of order_items which are described in the order_items table below.
-- Columns:  
--   order_id:  unique id for order
--   user_id: unique id for rider
--   amount:  total amount of purchase
--   date: date of purchase
--   receipt:  receipt number

CREATE TABLE `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` float(6,2) DEFAULT NULL,
  `date` date NOT NULL,
  `receipt` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4102 ;

--
-- Dumping data for table `orders`
-- Note: this is just sample data. Please create your own when implementing the API.

INSERT INTO `orders` (`order_id`, `user_id`, `amount`, `date`, `receipt`) VALUES
(2485, 2201, 173.85, '2013-09-02', '56136236'),
(2486, 2201, 51.85, '2013-09-02', '56136548'),
(2487, 727, 129.32, '2013-09-02', '56160662'),
(4101, 936, 51.85, '2014-03-19', '73257121');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
-- Note: this table contains items that are customized for inclusion in an order
-- Columns:  
--   order_id: foreign key to orders table
--   item_id: foreign key to items table
--   quantity: number of this item in an order
--

CREATE TABLE `order_items` (
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`order_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `order_items`
-- Note: this is just sample data. Please create your own when implementing the API.
--

INSERT INTO `order_items` (`order_id`, `item_id`, `quantity`) VALUES
(2486, 3, 1),
(2487, 1, 5),
(2487, 4, 1),
(4101, 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
