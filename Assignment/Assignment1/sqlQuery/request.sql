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
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `request_number` varchar(13) NOT NULL,
  `customer_number` varchar(13) NOT NULL,
  `description` varchar(50) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `pickup_address` varchar(50) NOT NULL,
  `pickup_suburb` varchar(4) NOT NULL,
  `pickup_date` datetime DEFAULT NULL,
  `receiver_name` varchar(20) NOT NULL,
  `delivery_address` varchar(50) NOT NULL,
  `delivery_suburb` varchar(4) NOT NULL,
  `state` int(11) NOT NULL,
  `request_date` date NOT NULL,
  PRIMARY KEY (`request_number`),
  KEY `customer_number` (`customer_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_number`, `customer_number`, `description`, `weight`, `pickup_address`, `pickup_suburb`, `pickup_date`, `receiver_name`, `delivery_address`, `delivery_suburb`, `state`, `request_date`) VALUES
('55201ab296f22', '55cd7edbb76c3', 'Your description', '4', 'pickup address', '7521', '2015-08-15 00:00:00', 'receiver name', 'receiver address', '1567', 4, '0000-00-00'),
('55201ab296f23', '55cd7edbb76c3', 'Your description', '4', 'pickup address', '4567', '2015-08-15 00:00:00', 'receiver name', 'receiver address', '4566', 4, '0000-00-00'),
('55201ab296ft3', '55cd7edbb76c3', 'Your description', '4', 'pickup address', '4567', '2015-08-22 10:01:00', 'receiver name', 'receiver address', '4566', 4, '2015-08-20'),
('55301ab296f22', '55cd7edbb76c3', 'Your description', '8', 'pickup address', '8795', '2015-08-15 10:01:00', 'receiver name', 'receiver address', '4567', 5, '0000-00-00'),
('55301ab296f2d', '55cd7edbb76c3', 'Your description', '8', 'pickup address', '4567', '2015-08-15 10:01:00', 'receiver name', 'receiver address', '4566', 5, '0000-00-00'),
('55301ab296q2d', '55cd7edbb76c3', 'Your description', '8', 'pickup address', '4567', '2015-08-22 10:01:00', 'receiver name', 'receiver address', '4566', 5, '2015-08-21'),
('55d01723dd4dg', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '4567', '2015-08-22 12:32:00', 'receiver name', 'receiver address', '4566', 7, '2015-08-21'),
('55d01723ddedf', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '8562', '2015-08-20 12:32:00', 'receiver name', 'receiver address', '5656', 7, '2015-08-21'),
('55d01723ddedg', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '4567', '2015-08-20 12:32:00', 'receiver name', 'receiver address', '4566', 7, '2015-08-21'),
('55d01aab9118d', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '6521', '2015-08-22 12:00:00', 'receiver name', 'receiver address', '1231', 7, '2015-08-20'),
('55d01aab9118e', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '6521', '2015-08-22 12:00:00', 'receiver name', 'receiver address', '4588', 7, '2015-08-20'),
('55d01aab911se', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '6521', '2015-08-22 12:00:00', 'receiver name', 'receiver address', '4588', 7, '2015-08-20'),
('55d01aab9816d', '55cd7edbb76c3', 'Your description', '1', 'pickup address', '2134', '2015-08-21 00:00:00', 'receiver name', 'receiver address', '4565', 2, '2015-08-20'),
('55d01aab9816q', '55cd7edbb76c3', 'Your description', '1', 'pickup address', '2134', '2015-08-21 00:00:00', 'receiver name', 'receiver address', '4588', 2, '2015-08-20'),
('55d01aab981gq', '55cd7edbb76c3', 'Your description', '1', 'pickup address', '2134', '2015-08-22 00:00:00', 'receiver name', 'receiver address', '4588', 2, '2015-08-20'),
('55d01ab296322', '55cd7edbb76c3', 'Your description', '12', 'pickup address', '1234', '2015-08-21 00:00:00', 'receiver name', 'receiver address', '4564', 8, '2015-08-20'),
('55d01ab296f22', '55cd7edbb76c3', 'Your description', '7', 'pickup address', '7898', '2015-08-22 00:00:00', 'receiver name', 'receiver address', '4565', 9, '2015-08-21'),
('55d01e18c30d6', '55cd7edbb76c3', 'Your description', '8', 'pickup address', '1234', '2015-08-22 00:00:00', 'receiver name', 'receiver address', '1235', 4, '2015-08-20'),
('55d01e1e7cda5', '55cd7edbb76c3', 'Your description', '3', 'pickup address', '8884', '2015-08-22 00:01:00', 'receiver name', 'receiver address', '4566', 0, '2015-08-20'),
('55d01e2049382', '55cd7edbb76c3', 'Your description', '6', 'pickup address', '4567', '2015-08-21 00:01:00', 'receiver name', 'receiver address', '7895', 5, '2015-08-20'),
('55d01e2464e4b', '55cd7edbb76c3', 'Your description', '7', 'pickup address', '4568', '2015-08-22 00:01:00', 'receiver name', 'receiver address', '1489', 5, '2015-08-20'),
('55d01e42833bb', '55cd7edbb76c3', 'Your description', '5', 'pickup address', '4563', '2015-08-22 00:01:00', 'receiver name', 'receiver address', '1285', 5, '2015-08-20'),
('55dd48bf239d0', '55dd487f8780b', 'asdf', '4', 'asdf', '1234', '0000-00-00 00:00:00', 'we', 'sad', '4444', 1, '2015-08-26'),
('55dd75bf5460e', '55dd755be24a7', 'them1', '1', 'diachi1', '1111', '2015-08-28 08:22:00', 'diachi11', 'diachi11', '2222', 1, '2015-08-26'),
('55e592e8f2c09', '55e592600a6e3', 'Your description', '3', 'pickup address', '1234', '2015-09-03 11:34:00', 'receiver name', 'receiver address', '4567', 3, '2015-09-01'),
('55e5930a5b012', '55e592600a6e3', 'acn', '2', 'asd', '1324', '2015-09-04 07:45:00', 'ACN', 'asdf', '4567', 1, '2015-09-01');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`customer_number`) REFERENCES `customer` (`customer_number`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
