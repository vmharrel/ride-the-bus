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
-- Database: `routes`
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

CREATE TABLE IF EXISTS `check_in`;

--
-- Table structure for table `items`
-- Note: this table contains the kinds of passes that a rider may purchase on the RidePal website
-- Columns:
--   item_id: unique id for an item
--   description:  name of an item
--

CREATE TABLE IF EXISTS `items`;

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

DROP TABLE IF EXISTS `orders`;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
-- Note: this table contains items that are customized for inclusion in an order
-- Columns:  
--   order_id: foreign key to orders table
--   item_id: foreign key to items table
--   quantity: number of this item in an order
--

CREATE TABLE IF EXISTS `order_items`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
