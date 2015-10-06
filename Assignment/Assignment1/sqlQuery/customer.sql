-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.ict.swin.edu.au:3306
-- Generation Time: Sep 01, 2015 at 10:07 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s4959353_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_number` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`customer_number`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_number`, `name`, `password`, `email`, `phone`) VALUES
('55cd7d72f2b47', 'abletran', '123', 'haiha262@gmail.coma', '1'),
('55cd7edbb76c3', 'abletran', 'root', 'hai@d.com', '12'),
('55cd89b122c21', 'abletran', '123', 'asdf2asdf@adf.c', '123'),
('55dd487f8780b', 'HA', '123456', 'haih@gs.vv', '1234567890'),
('55dd755be24a7', 'Ha', '1234', 'haiha262@gmail.com1', '1234567890'),
('55e592600a6e3', 'Ha', '123456', 'haiha262@gmail.com', '123');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
