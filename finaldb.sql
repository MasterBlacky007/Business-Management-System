-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 04:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addorder`
--

CREATE TABLE `addorder` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Address` text NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `spid` int(10) NOT NULL,
  `date` date NOT NULL,
  `hours` int(5) NOT NULL,
  `intime` time NOT NULL,
  `outtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`spid`, `date`, `hours`, `intime`, `outtime`) VALUES
(1, '2025-01-01', 8, '09:00:00', '17:00:00'),
(2, '2025-01-01', 7, '09:30:00', '16:30:00'),
(3, '2025-01-01', 6, '10:00:00', '16:00:00'),
(4, '2025-01-02', 8, '08:30:00', '16:30:00'),
(5, '2025-01-02', 5, '11:00:00', '16:00:00'),
(6, '2025-01-03', 7, '09:00:00', '16:00:00'),
(7, '2025-01-03', 6, '10:00:00', '16:00:00'),
(8, '2025-01-03', 8, '08:30:00', '16:30:00'),
(9, '2025-01-04', 7, '09:00:00', '16:00:00'),
(10, '2025-01-04', 6, '10:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cpayment`
--

CREATE TABLE `cpayment` (
  `pid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `oid` int(10) NOT NULL,
  `pdate` date NOT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` int(30) NOT NULL,
  `pmethod` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpayment`
--

INSERT INTO `cpayment` (`pid`, `cid`, `oid`, `pdate`, `currency`, `amount`, `pmethod`, `status`) VALUES
(1, 101, 1001, '2025-01-05', 'LKR', 5000, 'Credit Card', 'Paid'),
(2, 102, 1002, '2025-01-06', 'USD', 200, 'Debit Card', 'Pending'),
(3, 103, 1003, '2025-01-07', 'LKR', 15000, 'PayPal', 'Paid'),
(4, 104, 1004, '2025-01-08', 'LKR', 10000, 'Credit Card', 'Pending'),
(5, 105, 1005, '2025-01-09', 'USD', 300, 'Debit Card', 'Paid'),
(6, 106, 1006, '2025-01-10', 'LKR', 12000, 'PayPal', 'Pending'),
(7, 107, 1007, '2025-01-11', 'USD', 150, 'Credit Card', 'Paid'),
(8, 108, 1008, '2025-01-12', 'LKR', 8000, 'Debit Card', 'Pending'),
(9, 109, 1009, '2025-01-13', 'USD', 100, 'PayPal', 'Paid'),
(10, 110, 1010, '2025-01-14', 'LKR', 20000, 'Credit Card', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `credit_payments`
--

CREATE TABLE `credit_payments` (
  `PaymentID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Amount` int(20) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit_payments`
--

INSERT INTO `credit_payments` (`PaymentID`, `SupplierID`, `OrderID`, `PaymentDate`, `Currency`, `Amount`, `Status`) VALUES
(1, 3, 3, '2025-01-02', 'LKR', 10100, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `credit_table`
--

CREATE TABLE `credit_table` (
  `CreditID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CardNumber` varchar(16) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit_table`
--

INSERT INTO `credit_table` (`CreditID`, `OrderID`, `CardNumber`, `ExpiryDate`, `CVV`, `Amount`, `PaymentDate`, `CreatedAt`) VALUES
(1, 1, '45623178', '0000-00-00', '456', 100.00, '2025-01-04', '2025-01-04 02:50:27'),
(2, 1, '123456789', '0000-00-00', '123', 100.00, '2025-01-04', '2025-01-04 04:13:42'),
(3, 4, '8523697410', '2025-01-01', '852', 6000.00, '2025-01-04', '2025-01-04 10:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `daily_report`
--

CREATE TABLE `daily_report` (
  `id` int(5) NOT NULL,
  `date` date NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `today_sell` int(6) NOT NULL,
  `today_create` int(6) NOT NULL,
  `balance` int(6) NOT NULL,
  `today_amount` decimal(7,2) NOT NULL,
  `create_amount` decimal(7,2) NOT NULL,
  `today_revanew` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_report`
--

INSERT INTO `daily_report` (`id`, `date`, `product_name`, `today_sell`, `today_create`, `balance`, `today_amount`, `create_amount`, `today_revanew`) VALUES
(1, '2025-01-05', 'Apple', 150, 100, 50, 5000.00, 3500.00, 1500.00),
(2, '2025-01-06', 'Banana', 200, 150, 50, 6000.00, 4500.00, 1500.00),
(3, '2025-01-07', 'Orange', 180, 130, 50, 5400.00, 3900.00, 1500.00),
(4, '2025-01-08', 'Mango', 220, 170, 50, 6600.00, 5100.00, 1500.00),
(5, '2025-01-09', 'Pineapple', 160, 110, 50, 4800.00, 3300.00, 1500.00),
(6, '2025-01-10', 'Grapes', 210, 160, 50, 6300.00, 4800.00, 1500.00),
(7, '2025-01-11', 'Peach', 170, 120, 50, 5100.00, 3600.00, 1500.00),
(8, '2025-01-12', 'Papaya', 190, 140, 50, 5700.00, 4200.00, 1500.00),
(9, '2025-01-13', 'Guava', 200, 150, 50, 6000.00, 4500.00, 1500.00),
(10, '2025-01-14', 'Watermelon', 250, 200, 50, 7500.00, 6000.00, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `debit_payments`
--

CREATE TABLE `debit_payments` (
  `PaymentID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Amount` int(20) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debit_table`
--

CREATE TABLE `debit_table` (
  `DebitID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CardNumber` varchar(16) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `debit_table`
--

INSERT INTO `debit_table` (`DebitID`, `OrderID`, `CardNumber`, `ExpiryDate`, `CVV`, `Amount`, `PaymentDate`, `CreatedAt`) VALUES
(1, 0, '123456789', '0000-00-00', '222', 100.00, '2025-01-04', '2025-01-04 06:31:00'),
(2, 4, '478596123', '2025-06-01', '785', 6000.00, '2025-01-04', '2025-01-04 02:53:51'),
(4, 4, '9876543210', '2025-01-01', '741', 6000.00, '2025-01-04', '2025-01-04 10:31:32'),
(5, 1, '987654123', '2025-01-01', '852', 100.00, '2025-01-04', '2025-01-04 10:32:43'),
(6, 1, '7412558963', '2025-01-01', '963', 3400.00, '2025-01-04', '2025-01-04 14:34:59'),
(7, 1, '00025412254', '2025-01-01', '112', 15110.00, '2025-01-05', '2025-01-05 01:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `did` varchar(10) NOT NULL,
  `dname` varchar(20) NOT NULL,
  `smethod` varchar(20) NOT NULL,
  `sstatus` varchar(20) NOT NULL,
  `tcode` varchar(10) NOT NULL,
  `eid` varchar(10) NOT NULL,
  `lno` varchar(10) NOT NULL,
  `fno` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`did`, `dname`, `smethod`, `sstatus`, `tcode`, `eid`, `lno`, `fno`) VALUES
('1', 'Delivery 1', 'Air', 'Shipped', 'T123', '1', 'L123', 'F123'),
('10', 'Delivery 10', 'Sea', 'Shipped', 'T132', '10', 'L132', 'F132'),
('2', 'Delivery 2', 'Ground', 'In Transit', 'T124', '2', 'L124', 'F124'),
('3', 'Delivery 3', 'Sea', 'Delivered', 'T125', '3', 'L125', 'F125'),
('4', 'Delivery 4', 'Air', 'Shipped', 'T126', '4', 'L126', 'F126'),
('5', 'Delivery 5', 'Ground', 'Pending', 'T127', '5', 'L127', 'F127'),
('6', 'Delivery 6', 'Air', 'Shipped', 'T128', '6', 'L128', 'F128'),
('7', 'Delivery 7', 'Sea', 'In Transit', 'T129', '7', 'L129', 'F129'),
('8', 'Delivery 8', 'Ground', 'Delivered', 'T130', '8', 'L130', 'F130'),
('9', 'Delivery 9', 'Air', 'Pending', 'T131', '9', 'L131', 'F131');

-- --------------------------------------------------------

--
-- Table structure for table `dissues`
--

CREATE TABLE `dissues` (
  `IssuesID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Note` varchar(50) NOT NULL,
  `Description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dissues`
--

INSERT INTO `dissues` (`IssuesID`, `Type`, `Note`, `Description`) VALUES
(1, 'Delayed Delivery', 'delay', 'nd jkwdns'),
(2, 'Damaged Item', 'damage', 'dvh e hdbw '),
(3, 'Damaged Item', 'damage', 'dvh e hdbw '),
(4, 'Damaged Item', 'damage', 'dvh e hdbw '),
(5, 'Damaged Item', 'damage', 'dvh e hdbw '),
(6, 'Damaged Item', 'damage', 'dvh e hdbw '),
(7, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(8, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(9, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(10, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(11, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(12, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(13, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(14, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(15, 'Delayed Delivery', 'delay', 'hwbs wsjbqs hsj qbs'),
(16, 'Wrong Address', 'vbsja', 'jsniqk ksnq a'),
(17, 'Wrong Address', 'vbsja', 'jsniqk ksnq a'),
(18, 'Wrong Address', 'vbsja', 'jsniqk ksnq a'),
(19, 'Delayed Delivery', 'delayed', 'i face to traffic');

-- --------------------------------------------------------

--
-- Table structure for table `driver_status`
--

CREATE TABLE `driver_status` (
  `driver_id` int(5) NOT NULL,
  `driver_name` varchar(30) NOT NULL,
  `vehicale_no` varchar(7) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_status`
--

INSERT INTO `driver_status` (`driver_id`, `driver_name`, `vehicale_no`, `status`) VALUES
(1, 'kamal', 'LB-2842', 'type'),
(2, 'kamal', 'LB-2842', 'type'),
(3, 'Nimal', 'JP-2842', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `edaily`
--

CREATE TABLE `edaily` (
  `id` int(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `pid` varchar(20) NOT NULL,
  `mid` varchar(20) NOT NULL,
  `mstock` int(20) NOT NULL,
  `pstock` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edaily`
--

INSERT INTO `edaily` (`id`, `date`, `pid`, `mid`, `mstock`, `pstock`) VALUES
(1, '2025-01-01', '101', '201', 500, 300),
(2, '2025-01-02', '102', '202', 400, 200),
(3, '2025-01-03', '103', '203', 600, 450),
(4, '2025-01-04', '104', '204', 300, 150),
(5, '2025-01-05', '105', '205', 550, 400),
(6, '2025-01-06', '106', '206', 700, 500),
(7, '2025-01-07', '107', '207', 450, 350),
(8, '2025-01-08', '108', '208', 250, 200),
(9, '2025-01-09', '109', '209', 350, 300),
(10, '2025-01-10', '110', '210', 600, 550);

-- --------------------------------------------------------

--
-- Table structure for table `eperformance`
--

CREATE TABLE `eperformance` (
  `eno` int(11) NOT NULL,
  `jrole` varchar(20) NOT NULL,
  `skill` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eperformance`
--

INSERT INTO `eperformance` (`eno`, `jrole`, `skill`) VALUES
(1, 'Manager', 'Leadership'),
(2, 'Supervisor', 'Team Management'),
(3, 'Manager', 'Problem-Solving'),
(4, 'Supervisor', 'Communication'),
(5, 'Manager', 'Technical Skills'),
(6, 'Supervisor', 'Scheduling'),
(7, 'Manager', 'Strategic Planning'),
(8, 'Supervisor', 'Decision Making'),
(9, 'Manager', 'Time Management'),
(10, 'Supervisor', 'Attention to Detail');

-- --------------------------------------------------------

--
-- Table structure for table `genorder`
--

CREATE TABLE `genorder` (
  `oid` int(11) NOT NULL,
  `suid` varchar(20) NOT NULL,
  `odate` date NOT NULL,
  `rdate` date NOT NULL,
  `pmatirial` varchar(30) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genorder`
--

INSERT INTO `genorder` (`oid`, `suid`, `odate`, `rdate`, `pmatirial`, `quantity`, `status`) VALUES
(1, '1', '2025-01-01', '2025-01-05', 'Apples', 100, 'Transfered'),
(2, '2', '2025-01-02', '2025-01-06', 'Bananas', 150, 'Pending'),
(3, '3', '2025-01-03', '2025-01-07', 'Oranges', 200, 'Transfered'),
(4, '4', '2025-01-04', '2025-01-08', 'Grapes', 50, 'Pending'),
(5, '5', '2025-01-05', '2025-01-09', 'Pineapples', 80, 'Pending'),
(6, '1', '2025-01-06', '2025-01-10', 'Mangoes', 120, 'Pending'),
(7, '2', '2025-01-07', '2025-01-11', 'Pears', 90, 'Pending'),
(8, '3', '2025-01-08', '2025-01-12', 'Papayas', 60, 'Pending'),
(9, '4', '2025-01-09', '2025-01-13', 'Watermelons', 70, 'Pending'),
(10, '5', '2025-01-10', '2025-01-14', 'Strawberries', 30, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `incost`
--

CREATE TABLE `incost` (
  `id` int(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `mid` varchar(20) NOT NULL,
  `quantity` int(20) NOT NULL,
  `price` int(10) NOT NULL,
  `amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incost`
--

INSERT INTO `incost` (`id`, `date`, `mid`, `quantity`, `price`, `amount`) VALUES
(1, '2025-01-01', '1', 100, 50, 5000),
(2, '2025-01-02', '2', 150, 30, 4500),
(3, '2025-01-03', '3', 200, 20, 4000),
(4, '2025-01-04', '4', 120, 40, 4800),
(5, '2025-01-05', '5', 180, 25, 4500),
(6, '2025-01-06', '6', 220, 35, 7700),
(7, '2025-01-07', '7', 250, 15, 3750),
(8, '2025-01-08', '8', 160, 45, 7200),
(9, '2025-01-09', '9', 140, 38, 5320),
(10, '2025-01-10', '10', 190, 28, 5320);

-- --------------------------------------------------------

--
-- Table structure for table `lclogin`
--

CREATE TABLE `lclogin` (
  `Email` varchar(30) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lclogin`
--

INSERT INTO `lclogin` (`Email`, `Contact`, `Password`) VALUES
('amal.perera@gmail.com', 778912345, '23456789'),
('dilini.weera@gmail.com', 769012345, '89012345'),
('harsha.pathirana@gmail.com', 758123456, '78901234'),
('kamkanamlage394@gmail.com', 764846394, '12345678'),
('kasun.jaya@gmail.com', 752345678, '90123456'),
('kavinda.fernando@gmail.com', 712345678, '45678901'),
('nuwan.wick@gmail.com', 711234567, '56789012'),
('samantha.silva@gmail.com', 789345678, '34567890'),
('shanika.karuna@gmail.com', 768901234, '67890123'),
('tharushi.sena@gmail.com', 762345678, '01234567');

-- --------------------------------------------------------

--
-- Table structure for table `lcorder`
--

CREATE TABLE `lcorder` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(5) NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(5) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Amount` int(10) NOT NULL,
  `Payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lcorder`
--

INSERT INTO `lcorder` (`OrderID`, `ProductID`, `NIC`, `OrderDate`, `Quantity`, `Address`, `Amount`, `Payment`) VALUES
(1, 1, '200321911531', '2024-12-07', 2, 'No:320/7/1 Moraturoad,Suwarapola', 100, 'Paid'),
(4, 2, '200321911531', '2024-12-08', 19, 'No:663,Kiriibbanara,Sewanagala', 6000, 'Paid'),
(5, 2, '200329113332', '2024-12-08', 50, 'No:154,5thlane,Newtown,Embilipitiya', 1250, 'Paid'),
(6, 1, '982692733V', '2024-12-09', 30, 'No:320/7/1 Moraturoad,Suwarapola', 6000, 'pending'),
(7, 1, '200321911531', '2024-12-08', 5, 'No:663,Kiriibbanara,Sewanagala', 1000, 'pending'),
(8, 2, '200329113332', '2024-12-08', 10, 'No:154,5thlane,Newtown,Embilipitiya', 2000, 'pending'),
(9, 2, '200321911531', '2024-12-10', 200, 'No:320/7/1 Moraturoad,Suwarapola', 40000, 'pending'),
(10, 2, '200321911531', '2024-12-10', 200, 'No:320/7/1 Moraturoad,Suwarapola', 40000, 'pending'),
(11, 2, '195660803701', '2025-01-04', 20, 'No:663,Kiriibbanara,Sewanagala', 4000, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `lcregister`
--

CREATE TABLE `lcregister` (
  `ExportID` int(11) NOT NULL,
  `FullName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `City` varchar(20) NOT NULL,
  `NIC` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lcregister`
--

INSERT INTO `lcregister` (`ExportID`, `FullName`, `Email`, `Contact`, `Address`, `City`, `NIC`) VALUES
(11, 'Nigeeth Maleesha', 'kamkanamlage394@gmail.com', 764846394, 'No:320/7/1, Moraturoad, Suwarapola', 'Piliyandala', '200321911531'),
(12, 'Amal Perera', 'amal.perera@gmail.com', 778912345, 'No:12/3, Station Road, Galle', 'Galle', '200321911532'),
(13, 'Samantha Silva', 'samantha.silva@gmail.com', 789345678, 'No:5/8, Beach Road, Matara', 'Matara', '200321911533'),
(14, 'Kavinda Fernando', 'kavinda.fernando@gmail.com', 712345678, 'No:34, Lake View, Kandy', 'Kandy', '200321911534'),
(15, 'Nuwan Wickramasinghe', 'nuwan.wick@gmail.com', 711234567, 'No:22, River Side, Kurunegala', 'Kurunegala', '200321911535'),
(16, 'Shanika Karunaratne', 'shanika.karuna@gmail.com', 768901234, 'No:7, Hilltop, Nuwara Eliya', 'Nuwara Eliya', '200321911536'),
(17, 'Harsha Pathirana', 'harsha.pathirana@gmail.com', 758123456, 'No:18/2, Green Park, Colombo', 'Colombo', '200321911537'),
(18, 'Dilini Weerasinghe', 'dilini.weera@gmail.com', 769012345, 'No:15/1, Flower Road, Batticaloa', 'Batticaloa', '200321911538'),
(19, 'Kasun Jayawardena', 'kasun.jaya@gmail.com', 752345678, 'No:8, New Town, Anuradhapura', 'Anuradhapura', '200321911539'),
(20, 'Tharushi Senanayake', 'tharushi.sena@gmail.com', 762345678, 'No:23/4, Main Street, Jaffna', 'Jaffna', '200321911540');

-- --------------------------------------------------------

--
-- Table structure for table `lffeedback`
--

CREATE TABLE `lffeedback` (
  `ID` int(11) NOT NULL,
  `FeedbackType` varchar(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Discription` varchar(500) NOT NULL,
  `Reply` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lffeedback`
--

INSERT INTO `lffeedback` (`ID`, `FeedbackType`, `Name`, `Email`, `Discription`, `Reply`) VALUES
(1, 'Complaint', 'Nigeeth Maleesha', 'kamkanamlage394@gmail.com', 'The delivery was delayed by two days.', 'We apologize for the delay. We are working on improving our logistics.'),
(2, 'Suggestion', 'Amal Perera', 'amal.perera@gmail.com', 'It would be great to have more payment options.', 'Thank you for the suggestion. We are exploring this feature.'),
(3, 'Appreciati', 'Samantha Silva', 'samantha.silva@gmail.com', 'The product quality is excellent. Keep it up!', 'Thank you for your positive feedback!'),
(4, 'Complaint', 'Kavinda Fernando', 'kavinda.fernando@gmail.com', 'The product packaging was damaged upon arrival.', 'We regret the inconvenience. A replacement is on the way.'),
(5, 'Query', 'Nuwan Wickramasinghe', 'nuwan.wick@gmail.com', 'Can I change my shipping address after placing an order?', 'Yes, you can update the address before dispatch.'),
(6, 'Suggestion', 'Shanika Karunaratne', 'shanika.karuna@gmail.com', 'Consider introducing a loyalty rewards program.', 'We appreciate your idea and will consider it for future updates.'),
(7, 'Complaint', 'Harsha Pathirana', 'harsha.pathirana@gmail.com', 'Received the wrong product.', 'We apologize for the mix-up. A replacement has been arranged.'),
(8, 'Appreciati', 'Dilini Weerasinghe', 'dilini.weera@gmail.com', 'Customer support was very helpful and responsive.', 'Thank you for acknowledging our efforts!'),
(9, 'Query', 'Kasun Jayawardena', 'kasun.jaya@gmail.com', 'How can I track my order status?', 'You can track your order using the tracking ID sent via email.'),
(10, 'Suggestion', 'Tharushi Senanayake', 'tharushi.sena@gmail.com', 'Add more detailed product descriptions on the website.', 'Thank you for the suggestion. We will improve our product pages.');

-- --------------------------------------------------------

--
-- Table structure for table `lflogin`
--

CREATE TABLE `lflogin` (
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lflogin`
--

INSERT INTO `lflogin` (`Email`, `Contact`, `Password`) VALUES
('amal.perera@gmail.com', 778912345, '23456789'),
('dilini.weera@gmail.com', 769012345, '89012345'),
('harsha.pathirana@gmail.com', 758123456, '78901234'),
('kamkanamlage394@gmail.com', 764846394, '12345678'),
('kasun.jaya@gmail.com', 752345678, '90123456'),
('kavinda.fernando@gmail.com', 712345678, '45678901'),
('nuwan.wick@gmail.com', 711234567, '56789012'),
('samantha.silva@gmail.com', 789345678, '34567890'),
('shanika.karuna@gmail.com', 768901234, '67890123'),
('tharushi.sena@gmail.com', 762345678, '01234567');

-- --------------------------------------------------------

--
-- Table structure for table `lforder`
--

CREATE TABLE `lforder` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(5) NOT NULL,
  `IIC` varchar(12) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(5) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Amount` int(10) NOT NULL,
  `Payment` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lforder`
--

INSERT INTO `lforder` (`OrderID`, `ProductID`, `IIC`, `OrderDate`, `Quantity`, `Address`, `Country`, `Amount`, `Payment`) VALUES
(1, 1, '200321911531', '2024-12-08', 17, 'No:320/7/1 Moraturoad,Suwarapola', 'Sri Lanka', 3400, 'Paid'),
(2, 2, '200329113332', '2024-12-08', 11, 'No:154,5thlane,Newtown,Embilipitiya', 'Sri Lanka', 2200, 'pending'),
(3, 2, '200318401017', '2024-12-09', 9, 'No:154,5thlane,Newtown,Embilipitiya', 'Sri Lanka', 1800, 'pending'),
(4, 3, '200321911531', '2024-12-09', 50, 'No:320/7/1 Moraturoad,Suwarapola', 'England', 5000, 'Paid'),
(5, 1, '200318401017', '2025-01-04', 50, 'No:320/7/1 Moraturoad,Suwarapola', 'England', 10000, 'pending'),
(6, 3, '200321911531', '2025-01-05', 25, 'No:320/7/1 Moraturoad,Suwarapola', 'England', 2500, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `lfregister`
--

CREATE TABLE `lfregister` (
  `ExportID` int(11) NOT NULL,
  `FullName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ShippingMethod` varchar(20) NOT NULL,
  `IIC` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lfregister`
--

INSERT INTO `lfregister` (`ExportID`, `FullName`, `Email`, `Contact`, `Address`, `Country`, `Currency`, `ShippingMethod`, `IIC`) VALUES
(1, 'Nigeeth Maleesha', 'kamkanamlage394@gmail.com', 764846394, 'No:320/7/1, Moraturoad, Suwarapola', 'Sri Lanka', 'LKR', 'Online', '200321911531'),
(2, 'Amal Perera', 'amal.perera@gmail.com', 778912345, 'No:12/3, Station Road, Galle', 'Sri Lanka', 'LKR', 'Courier', '200321911532'),
(3, 'Samantha Silva', 'samantha.silva@gmail.com', 789345678, 'No:5/8, Beach Road, Matara', 'Sri Lanka', 'LKR', 'Online', '200321911533'),
(4, 'Kavinda Fernando', 'kavinda.fernando@gmail.com', 712345678, 'No:34, Lake View, Kandy', 'Sri Lanka', 'LKR', 'Courier', '200321911534'),
(5, 'Nuwan Wickramasinghe', 'nuwan.wick@gmail.com', 711234567, 'No:22, River Side, Kurunegala', 'Sri Lanka', 'LKR', 'Online', '200321911535'),
(6, 'Shanika Karunaratne', 'shanika.karuna@gmail.com', 768901234, 'No:7, Hilltop, Nuwara Eliya', 'Sri Lanka', 'LKR', 'Courier', '200321911536'),
(7, 'Harsha Pathirana', 'harsha.pathirana@gmail.com', 758123456, 'No:18/2, Green Park, Colombo', 'Sri Lanka', 'LKR', 'Online', '200321911537'),
(8, 'Dilini Weerasinghe', 'dilini.weera@gmail.com', 769012345, 'No:15/1, Flower Road, Batticaloa', 'Sri Lanka', 'LKR', 'Courier', '200321911538'),
(9, 'Kasun Jayawardena', 'kasun.jaya@gmail.com', 752345678, 'No:8, New Town, Anuradhapura', 'Sri Lanka', 'LKR', 'Online', '200321911539'),
(10, 'Tharushi Senanayake', 'tharushi.sena@gmail.com', 762345678, 'No:23/4, Main Street, Jaffna', 'Sri Lanka', 'LKR', 'Courier', '200321911540');

-- --------------------------------------------------------

--
-- Table structure for table `mrequest`
--

CREATE TABLE `mrequest` (
  `rid` int(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `mid` varchar(20) NOT NULL,
  `quantity` int(20) NOT NULL,
  `rsdate` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mrequest`
--

INSERT INTO `mrequest` (`rid`, `date`, `mid`, `quantity`, `rsdate`, `status`) VALUES
(1, '2025-01-01', '1', 500, '2025-01-02', 'cancel'),
(2, '2025-01-02', '2', 1000, '2025-01-03', 'Approved'),
(3, '2025-01-03', '3', 800, '2025-01-04', 'Pending'),
(4, '2025-01-04', '4', 300, '2025-01-05', 'Completed'),
(5, '2025-01-05', '5', 600, '2025-01-06', 'Approved'),
(6, '2025-01-06', '6', 250, '2025-01-07', 'Pending'),
(7, '2025-01-07', '7', 400, '2025-01-08', 'Approved'),
(8, '2025-01-08', '8', 500, '2025-01-09', 'Pending'),
(9, '2025-01-09', '9', 150, '2025-01-10', 'Completed'),
(10, '2025-01-10', '10', 200, '2025-01-11', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentType` varchar(20) NOT NULL,
  `PaymentDetails` text DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `OrderID`, `PaymentDate`, `PaymentType`, `PaymentDetails`, `Amount`, `CreatedAt`) VALUES
(1, 0, '2025-01-04', 'Debit', NULL, 100.00, '2025-01-04 06:31:00'),
(2, 1, '2025-01-04', 'Credit', 'Payment processed via Credit', 100.00, '2025-01-04 02:50:27'),
(3, 4, '2025-01-04', 'Debit', 'Payment processed via Debit', 6000.00, '2025-01-04 02:53:51'),
(4, 1, '2025-01-04', 'Credit', 'Payment processed via Credit', 100.00, '2025-01-04 04:13:42'),
(6, 4, '2025-01-04', 'Debit', 'Payment processed via Debit', 6000.00, '2025-01-04 10:31:32'),
(7, 1, '2025-01-04', 'Debit', 'Payment processed via Debit', 100.00, '2025-01-04 10:32:43'),
(8, 4, '2025-01-04', 'Credit', 'Payment processed via Credit', 6000.00, '2025-01-04 10:36:53'),
(9, 1, '2025-01-04', 'Debit', 'Payment processed via Debit', 3400.00, '2025-01-04 14:34:59'),
(10, 4, '2025-01-04', 'Paypal', 'Payment processed via Paypal', 5000.00, '2025-01-04 14:50:38'),
(11, 1, '2025-01-05', 'Debit', 'Payment processed via Debit', 15110.00, '2025-01-05 01:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_payments`
--

CREATE TABLE `paypal_payments` (
  `PaymentID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Amount` int(20) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_table`
--

CREATE TABLE `paypal_table` (
  `PaypalID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `VerificationCode` varchar(10) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paypal_table`
--

INSERT INTO `paypal_table` (`PaypalID`, `OrderID`, `Email`, `VerificationCode`, `Amount`, `PaymentDate`, `CreatedAt`) VALUES
(1, 4, 'kamkanamlage394@gmail.com', '1254', 5000.00, '2025-01-04', '2025-01-04 14:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `pmstock`
--

CREATE TABLE `pmstock` (
  `sid` varchar(20) NOT NULL,
  `pmid` varchar(30) NOT NULL,
  `quantity` int(20) NOT NULL,
  `location` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sdate` date NOT NULL,
  `rsdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pmstock`
--

INSERT INTO `pmstock` (`sid`, `pmid`, `quantity`, `location`, `status`, `sdate`, `rsdate`) VALUES
('01', 'Banana', 20, 'Embilipitiya', 'Active', '2024-12-10', '2024-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `pprocess`
--

CREATE TABLE `pprocess` (
  `ppid` varchar(20) NOT NULL,
  `pid` varchar(20) NOT NULL,
  `quantity` int(200) NOT NULL,
  `discription` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pprocess`
--

INSERT INTO `pprocess` (`ppid`, `pid`, `quantity`, `discription`, `date`) VALUES
('1', '101', 500, 'Processing of fresh apples for packaging', '2024-12-01'),
('10', '110', 300, 'Processing of papayas for packaging', '2024-12-10'),
('2', '102', 300, 'Processing of ripe bananas for packaging', '2024-12-02'),
('3', '103', 400, 'Processing of oranges for juice production', '2024-12-03'),
('4', '104', 250, 'Processing of pineapples for packaging', '2024-12-04'),
('5', '105', 350, 'Processing of grapes for packaging', '2024-12-05'),
('6', '106', 600, 'Processing of mangos for packaging', '2024-12-06'),
('7', '107', 450, 'Processing of strawberries for packaging', '2024-12-07'),
('8', '108', 200, 'Processing of guavas for juicing', '2024-12-08'),
('9', '109', 500, 'Processing of avocados for packaging', '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Price` int(10) NOT NULL,
  `Image` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `Price`, `Image`) VALUES
(1, 'Banana', 200, 'images/Banana.webp'),
(2, 'Mango', 200, 'images/download.jpeg'),
(3, 'Orange', 100, 'images (1).jpeg'),
(4, 'Apple', 250, 'download (2).jpeg'),
(5, 'Apple', 250, 'download (2).jpeg'),
(6, 'Mango', 300, 'images/download.jpeg'),
(7, 'Papaya', 300, 'uploads/papaya.jpeg'),
(9, 'Mango', 150, 'download.jpeg'),
(10, 'Banana', 500, 'Banana.webp'),
(11, 'Orange', 200, 'mages (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `production_cost_reports`
--

CREATE TABLE `production_cost_reports` (
  `id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_date` date NOT NULL,
  `fruit_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `labor_cost` decimal(10,2) NOT NULL,
  `transport_cost` decimal(10,2) NOT NULL,
  `packaging_cost` decimal(10,2) NOT NULL,
  `miscellaneous_cost` decimal(10,2) DEFAULT NULL,
  `total` double NOT NULL,
  `report_frequency` enum('daily','weekly','monthly') NOT NULL,
  `observations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production_cost_reports`
--

INSERT INTO `production_cost_reports` (`id`, `report_title`, `report_date`, `fruit_type`, `quantity`, `labor_cost`, `transport_cost`, `packaging_cost`, `miscellaneous_cost`, `total`, `report_frequency`, `observations`, `created_at`) VALUES
(1, 'January Production Report', '2025-01-01', 'Mangoes', 500, 1500.00, 800.00, 300.00, 200.00, 2800, 'daily', 'Smooth production with minimal issues', '2025-01-01 02:30:00'),
(2, 'February Production Report', '2025-02-01', 'Bananas', 1000, 2000.00, 1000.00, 400.00, 250.00, 3650, 'monthly', 'Increased demand due to market expansion', '2025-02-01 02:30:00'),
(3, 'March Production Report', '2025-03-01', 'Apples', 800, 1800.00, 900.00, 350.00, 150.00, 3200, 'monthly', 'Minor delay in transportation', '2025-03-01 02:30:00'),
(4, 'April Production Report', '2025-04-01', 'Pineapples', 300, 1000.00, 600.00, 200.00, 100.00, 1900, 'monthly', 'Excellent quality production', '2025-04-01 02:30:00'),
(5, 'May Production Report', '2025-05-01', 'Oranges', 600, 1200.00, 750.00, 280.00, 180.00, 2510, 'monthly', 'No significant issues during production', '2025-05-01 02:30:00'),
(6, 'June Production Report', '2025-06-01', 'Avocados', 250, 1100.00, 550.00, 220.00, 130.00, 2000, 'monthly', 'Slow production due to seasonal variations', '2025-06-01 02:30:00'),
(7, 'July Production Report', '2025-07-01', 'Papayas', 400, 900.00, 400.00, 180.00, 120.00, 1600, 'monthly', 'Good quality, no significant challenges', '2025-07-01 02:30:00'),
(8, 'August Production Report', '2025-08-01', 'Grapes', 500, 1500.00, 800.00, 300.00, 200.00, 2800, 'monthly', 'Minor delays due to weather conditions', '2025-08-01 02:30:00'),
(9, 'September Production Report', '2025-09-01', 'Strawberries', 150, 600.00, 300.00, 120.00, 80.00, 1100, 'monthly', 'High demand but good quality', '2025-09-01 02:30:00'),
(10, 'October Production Report', '2025-10-01', 'Blueberries', 200, 800.00, 350.00, 150.00, 90.00, 1390, 'monthly', 'Smooth production with no issues', '2025-10-01 02:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_material`
--

CREATE TABLE `product_material` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `request_date` date NOT NULL,
  `note` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_material`
--

INSERT INTO `product_material` (`material_id`, `material_name`, `quantity`, `request_date`, `note`, `status`) VALUES
(1, 'Mangoes', 500, '2025-01-01', 'Fresh mangoes for export', 'Pending'),
(2, 'Bananas', 1000, '2025-01-02', 'For wholesale distribution', 'Approved'),
(3, 'Apples', 800, '2025-01-03', 'For packaging into fruit baskets', 'Pending'),
(4, 'Pineapples', 300, '2025-01-04', 'For canning and juice production', 'Completed'),
(5, 'Oranges', 600, '2025-01-05', 'For fresh sale and juice', 'Approved'),
(6, 'Avocados', 250, '2025-01-06', 'For premium export market', 'Pending'),
(7, 'Papayas', 400, '2025-01-07', 'For fruit salad and packaging', 'Approved'),
(8, 'Grapes', 500, '2025-01-08', 'For fresh sale and export', 'Pending'),
(9, 'Strawberries', 150, '2025-01-09', 'For packaging and export', 'Completed'),
(10, 'Blueberries', 200, '2025-01-10', 'For fresh sale and juice', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `Profile_ID` int(5) NOT NULL,
  `staf_id` int(11) NOT NULL,
  `First_Name` varchar(10) NOT NULL,
  `Last_Name` varchar(10) NOT NULL,
  `NIC_number` int(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Mobile_Number` int(10) NOT NULL,
  `Lane_Number` int(10) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `Age` int(3) NOT NULL,
  `SAddress` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `transporter_no` varchar(5) NOT NULL,
  `vehicle_no` varchar(10) NOT NULL,
  `license_no` varchar(8) NOT NULL,
  `skill` varchar(50) NOT NULL,
  `Tmanager_no` varchar(5) NOT NULL,
  `fleet_size` varchar(8) NOT NULL,
  `pmNumber` varchar(5) NOT NULL,
  `pArea` varchar(20) NOT NULL,
  `tsize` int(3) NOT NULL,
  `skeeper_no` varchar(5) NOT NULL,
  `edate` date NOT NULL,
  `em_no` varchar(5) NOT NULL,
  `job_rol` varchar(20) NOT NULL,
  `sup_no` varchar(5) NOT NULL,
  `sup_area` varchar(20) NOT NULL,
  `fm_no` varchar(5) NOT NULL,
  `doa` date NOT NULL,
  `inv_no` varchar(5) NOT NULL,
  `inv_area` varchar(10) NOT NULL,
  `inv_size` int(3) NOT NULL,
  `sk_no` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`Profile_ID`, `staf_id`, `First_Name`, `Last_Name`, `NIC_number`, `Email`, `Mobile_Number`, `Lane_Number`, `Gender`, `date_of_birth`, `Age`, `SAddress`, `photo`, `transporter_no`, `vehicle_no`, `license_no`, `skill`, `Tmanager_no`, `fleet_size`, `pmNumber`, `pArea`, `tsize`, `skeeper_no`, `edate`, `em_no`, `job_rol`, `sup_no`, `sup_area`, `fm_no`, `doa`, `inv_no`, `inv_area`, `inv_size`, `sk_no`) VALUES
(6, 1, 'NIGEETH', 'MALEESHA', 2147483647, 'kamkanamlage394@gmail.com', 764846394, 114680635, 'Male', '2025-01-05', 19, 'No:320/7/1', 'b (3).jpeg', '', '', '', '2year', '', '', '', '', 0, '', '0000-00-00', '', '', '', '', '01', '2025-01-05', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pstock`
--

CREATE TABLE `pstock` (
  `sid` varchar(10) NOT NULL,
  `pid` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `location` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sdate` date NOT NULL,
  `rsdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pstock`
--

INSERT INTO `pstock` (`sid`, `pid`, `quantity`, `location`, `status`, `sdate`, `rsdate`) VALUES
('1', '1', 500, 'Warehouse A', 'Available', '2025-01-01', '2025-01-02'),
('10', '10', 200, 'Warehouse A', 'Available', '2025-01-10', '2025-01-11'),
('2', '2', 1000, 'Warehouse B', 'Available', '2025-01-02', '2025-01-03'),
('3', '3', 800, 'Warehouse C', 'Available', '2025-01-03', '2025-01-04'),
('4', '4', 300, 'Warehouse A', 'Out of Stock', '2025-01-04', '2025-01-05'),
('5', '5', 600, 'Warehouse B', 'Available', '2025-01-05', '2025-01-06'),
('6', '6', 250, 'Warehouse C', 'Out of Stock', '2025-01-06', '2025-01-07'),
('7', '7', 400, 'Warehouse A', 'Available', '2025-01-07', '2025-01-08'),
('8', '8', 500, 'Warehouse B', 'Available', '2025-01-08', '2025-01-09'),
('9', '9', 150, 'Warehouse C', 'Out of Stock', '2025-01-09', '2025-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `revenu`
--

CREATE TABLE `revenu` (
  `rid` int(20) NOT NULL,
  `gdate` date NOT NULL DEFAULT current_timestamp(),
  `month` date NOT NULL,
  `tpurchases` int(20) NOT NULL,
  `tsales` int(20) NOT NULL,
  `trevenu` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `SalaryID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `StaffNo` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `AccountNumber` int(20) NOT NULL,
  `BasicPay` int(10) NOT NULL,
  `OT` int(10) NOT NULL,
  `ETF` int(10) NOT NULL,
  `Amount` int(15) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`SalaryID`, `StaffID`, `StaffNo`, `Name`, `Month`, `Date`, `AccountNumber`, `BasicPay`, `OT`, `ETF`, `Amount`, `Status`) VALUES
(1, 1, 101, 'NIGEETH MALEESHA', 'December', '2024-12-09', 2147483647, 150000, 5, 22500, 128000, 'Active'),
(2, 2, 102, 'Pathum Perera', 'December', '2024-12-09', 2147483647, 140000, 8, 21000, 121000, 'Pending'),
(3, 3, 103, 'Saman Silva', 'December', '2024-12-09', 2147483647, 135000, 6, 20250, 117000, 'Active'),
(4, 4, 104, 'Kamal Jayasinghe', 'December', '2024-12-09', 2147483647, 160000, 7, 24000, 140000, 'Pending'),
(5, 5, 105, 'Dinesh Kumar', 'December', '2024-12-09', 2147483647, 145000, 9, 21750, 126250, 'Active'),
(6, 6, 106, 'Ruwan Wijesekera', 'December', '2024-12-09', 2147483647, 150000, 4, 22500, 128500, 'Pending'),
(7, 7, 107, 'Chamika Fernando', 'December', '2024-12-09', 2147483647, 155000, 10, 23250, 137500, 'Active'),
(8, 8, 108, 'Anusha Rani', 'December', '2024-12-09', 2147483647, 125000, 6, 18750, 113750, 'Pending'),
(9, 9, 109, 'Gayan Rajapaksha', 'December', '2024-12-09', 2147483647, 170000, 5, 25500, 145500, 'Active'),
(10, 10, 110, 'Shehan Perera', 'December', '2024-12-09', 2147483647, 150000, 8, 22500, 130500, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `saleID` int(20) NOT NULL,
  `pID` varchar(20) NOT NULL,
  `pname` varchar(20) NOT NULL,
  `quantity` int(20) NOT NULL,
  `uprise` int(20) NOT NULL,
  `amount` int(30) NOT NULL,
  `duration` date NOT NULL,
  `rdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`saleID`, `pID`, `pname`, `quantity`, `uprise`, `amount`, `duration`, `rdate`) VALUES
(1, '101', 'Apple', 50, 3, 125, '2025-01-01', '2025-01-07'),
(2, '102', 'Banana', 100, 1, 120, '2025-01-02', '2025-01-08'),
(3, '103', 'Orange', 75, 2, 150, '2025-01-03', '2025-01-09'),
(4, '104', 'Grapes', 40, 3, 120, '2025-01-04', '2025-01-10'),
(5, '105', 'Pineapple', 30, 4, 120, '2025-01-05', '2025-01-11'),
(6, '106', 'Mango', 20, 6, 110, '2025-01-06', '2025-01-12'),
(7, '107', 'Papaya', 25, 3, 80, '2025-01-07', '2025-01-13'),
(8, '108', 'Strawberry', 15, 6, 90, '2025-01-08', '2025-01-14'),
(9, '109', 'Watermelon', 10, 8, 80, '2025-01-09', '2025-01-15'),
(10, '110', 'Kiwi', 12, 7, 84, '2025-01-10', '2025-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `sgenpay`
--

CREATE TABLE `sgenpay` (
  `SupplierID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Price` int(20) NOT NULL,
  `OrderAmount` int(30) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sgenpay`
--

INSERT INTO `sgenpay` (`SupplierID`, `OrderID`, `OrderDate`, `Quantity`, `Price`, `OrderAmount`, `Status`) VALUES
(1, 1, '2024-12-09', 100, 150, 15110, 'Paid'),
(1, 2, '2024-12-09', 500, 200, 105000, ''),
(1, 3, '2025-01-05', 50, 100, 5499, 'pending'),
(2, 1, '2024-12-09', 50, 600, 30500, 'Paid'),
(2, 2, '2025-01-02', 10, 1000, 10100, 'pending'),
(3, 3, '2025-01-02', 10, 100, 10100, 'pending'),
(4, 1, '2025-01-05', 50, 100, 5500, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `shid` int(11) NOT NULL,
  `eno` int(11) NOT NULL,
  `date` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`shid`, `eno`, `date`, `stime`, `etime`, `status`) VALUES
(1, 1, '2024-12-10', '04:12:00', '21:17:00', 'approve'),
(2, 2, '2025-01-02', '14:48:00', '20:48:00', 'pending'),
(3, 3, '2025-01-01', '10:00:00', '18:00:00', 'Reject'),
(4, 4, '2025-01-02', '08:00:00', '16:00:00', 'Approve'),
(5, 5, '2025-01-02', '09:00:00', '17:00:00', 'Pending'),
(6, 6, '2025-01-02', '10:00:00', '18:00:00', 'Approve'),
(7, 7, '2025-01-03', '08:00:00', '16:00:00', 'Reject'),
(8, 8, '2025-01-03', '09:00:00', '17:00:00', 'Approve'),
(9, 9, '2025-01-03', '10:00:00', '18:00:00', 'Pending'),
(10, 10, '2025-01-04', '08:00:00', '16:00:00', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `spayment`
--

CREATE TABLE `spayment` (
  `PaymentID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Amount` int(20) NOT NULL,
  `Method` varchar(10) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spayment`
--

INSERT INTO `spayment` (`PaymentID`, `SupplierID`, `OrderID`, `PaymentDate`, `Currency`, `Amount`, `Method`, `Status`) VALUES
(1, 1, 1, '2024-12-09', 'LKR', 15110, 'credit', 'Active'),
(2, 1, 2, '2024-12-09', 'LKR', 105000, 'paypal', 'Pending'),
(5, 2, 2, '2025-01-15', 'LKR', 10100, 'credit', 'Active'),
(6, 3, 3, '2025-01-02', 'LKR', 10100, 'credit', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ID` int(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `Pid` varchar(50) NOT NULL,
  `mid` varchar(50) NOT NULL,
  `pinstock` int(50) NOT NULL,
  `minstock` int(50) NOT NULL,
  `poutstock` int(50) NOT NULL,
  `moutstock` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`ID`, `date`, `Pid`, `mid`, `pinstock`, `minstock`, `poutstock`, `moutstock`) VALUES
(1, '2025-01-01', '101', '1', 500, 100, 200, 50),
(2, '2025-01-02', '102', '2', 300, 150, 100, 30),
(3, '2025-01-03', '103', '3', 200, 50, 150, 60),
(4, '2025-01-04', '104', '4', 100, 200, 50, 20),
(5, '2025-01-05', '105', '5', 400, 80, 250, 70),
(6, '2025-01-06', '106', '6', 600, 120, 300, 90),
(7, '2025-01-07', '107', '7', 700, 90, 350, 100),
(8, '2025-01-08', '108', '8', 450, 110, 180, 40),
(9, '2025-01-09', '109', '9', 300, 80, 200, 60),
(10, '2025-01-10', '110', '10', 500, 150, 250, 50);

-- --------------------------------------------------------

--
-- Table structure for table `suplogin`
--

CREATE TABLE `suplogin` (
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suplogin`
--

INSERT INTO `suplogin` (`Email`, `Contact`, `Password`) VALUES
('amal.perera@gmail.com', 778912345, '23456789'),
('dilini.weera@gmail.com', 769012345, '89012345'),
('harsha.pathirana@gmail.com', 758123456, '78901234'),
('kamkanamlage394@gmail.com', 764846394, '12345678'),
('kasun.jaya@gmail.com', 752345678, '90123456'),
('kavinda.fernando@gmail.com', 712345678, '45678901'),
('nuwan.wick@gmail.com', 711234567, '56789012'),
('samantha.silva@gmail.com', 789345678, '34567890'),
('shanika.karuna@gmail.com', 768901234, '67890123'),
('tharushi.sena@gmail.com', 762345678, '01234567');

-- --------------------------------------------------------

--
-- Table structure for table `supply_requset`
--

CREATE TABLE `supply_requset` (
  `requset_id` int(5) NOT NULL,
  `request_date` date NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_name` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_requset`
--

INSERT INTO `supply_requset` (`requset_id`, `request_date`, `material_id`, `material_name`, `quantity`, `status`) VALUES
(1, '2025-01-01', 1, 'Mangoes', 500, 'Pending'),
(2, '2025-01-02', 2, 'Bananas', 1000, 'Approved'),
(3, '2025-01-03', 3, 'Apples', 800, 'Pending'),
(4, '2025-01-04', 4, 'Pineapples', 300, 'Completed'),
(5, '2025-01-05', 5, 'Oranges', 600, 'Approved'),
(6, '2025-01-06', 6, 'Avocados', 250, 'Pending'),
(7, '2025-01-07', 7, 'Papayas', 400, 'Approved'),
(8, '2025-01-08', 8, 'Grapes', 500, 'Pending'),
(9, '2025-01-09', 9, 'Strawberries', 150, 'Completed'),
(10, '2025-01-10', 10, 'Blueberries', 200, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `supregister`
--

CREATE TABLE `supregister` (
  `SupplierID` int(11) NOT NULL,
  `FullName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `DOJ` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supregister`
--

INSERT INTO `supregister` (`SupplierID`, `FullName`, `Email`, `Contact`, `Address`, `DOJ`) VALUES
(1, 'Nigeeth Maleesha', 'kamkanamlage394@gmail.com', 764846394, 'No:320/7/1, Moraturoad, Suwarapola', '2024-12-06'),
(2, 'Amal Perera', 'amal.perera@gmail.com', 778912345, '14/1, Galle Road, Galle', '2024-11-15'),
(3, 'Samantha Silva', 'samantha.silva@gmail.com', 789345678, '22/3, Beach Street, Matara', '2024-11-18'),
(4, 'Kavinda Fernando', 'kavinda.fernando@gmail.com', 712345678, '45/6, Lake View, Kandy', '2024-10-25'),
(5, 'Nuwan Wickramasinghe', 'nuwan.wick@gmail.com', 711234567, '78/2, River Side, Kurunegala', '2024-09-30'),
(6, 'Shanika Karunaratne', 'shanika.karuna@gmail.com', 768901234, '9/10, Green Park, Nuwara Eliya', '2024-08-12'),
(7, 'Harsha Pathirana', 'harsha.pathirana@gmail.com', 758123456, '5/4, Hill Top, Colombo', '2024-07-20'),
(8, 'Dilini Weerasinghe', 'dilini.weera@gmail.com', 769012345, '3/8, Flower Road, Batticaloa', '2024-06-18'),
(9, 'Kasun Jayawardena', 'kasun.jaya@gmail.com', 752345678, '2/5, New Town, Anuradhapura', '2024-05-25'),
(10, 'Tharushi Senanayake', 'tharushi.sena@gmail.com', 762345678, '12/9, Main Street, Jaffna', '2024-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `taskid` int(11) NOT NULL,
  `taskname` varchar(30) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `assignby` varchar(20) NOT NULL,
  `assignto` varchar(20) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `sstatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskid`, `taskname`, `discription`, `assignby`, `assignto`, `startdate`, `enddate`, `sstatus`) VALUES
(1, 'Task 1', 'Complete the project report', 'Owner', 'FactoryManager', '2025-01-01', '2025-01-07', 'Assign'),
(2, 'Task 2', 'Fix the bug in the system', 'Owner', 'FactoryManager, Prod', '2025-01-02', '2025-01-08', 'Pending'),
(3, 'Task 3', 'Prepare presentation for meeting', 'FactoryManager', 'Supervisor, Employee', '2025-01-03', '2025-01-09', 'Completed'),
(4, 'Task 4', 'Design new UI for website', 'FactoryManager', 'Supervisor, Employee', '2025-01-04', '2025-01-10', 'Assign'),
(5, 'Task 5', 'Test the new software release', 'FactoryManager', 'Supervisor, Employee', '2025-01-05', '2025-01-11', 'Pending'),
(6, 'Task 6', 'Update the database schema', 'FactoryManager', 'InventoryManager, St', '2025-01-06', '2025-01-12', 'Assign'),
(7, 'Task 7', 'Write unit tests for code', 'FactoryManager', 'InventoryManager, St', '2025-01-07', '2025-01-13', 'Completed'),
(8, 'Task 8', 'Research new technologies', 'Owner', 'TransportManager, Tr', '2025-01-08', '2025-01-14', 'Pending'),
(9, 'Task 9', 'Organize team meeting', 'FactoryManager', 'Supervisor, Employee', '2025-01-09', '2025-01-15', 'Assign'),
(10, 'Task 10', 'Prepare monthly budget report', 'Owner', 'FactoryManager, Supe', '2025-01-10', '2025-01-16', 'Completed'),
(11, 'Task 11', 'Complete market research', 'Owner', 'ProductionManager', '2025-01-11', '2025-01-17', 'Assign'),
(12, 'Task 12', 'Design product packaging', 'FactoryManager', 'ProductionManager, I', '2025-01-12', '2025-01-18', 'Pending'),
(13, 'Task 13', 'Train new employees', 'FactoryManager', 'Supervisor', '2025-01-13', '2025-01-19', 'Completed'),
(14, 'Task 14', 'Review financial reports', 'Owner', 'FactoryManager, Supe', '2025-01-14', '2025-01-20', 'Assign'),
(15, 'Task 15', 'Monitor production process', 'FactoryManager', 'ProductionManager, S', '2025-01-15', '2025-01-21', 'Pending'),
(16, 'Task 16', 'Test new production line', 'FactoryManager', 'ProductionManager', '2025-01-16', '2025-01-22', 'Completed'),
(17, 'Task 17', 'Inspect factory equipment', 'FactoryManager', 'Supervisor, Stockkee', '2025-01-17', '2025-01-23', 'Assign'),
(18, 'Task 18', 'Audit inventory records', 'FactoryManager', 'InventoryManager, St', '2025-01-18', '2025-01-24', 'Pending'),
(19, 'Task 19', 'Update transportation logistics', 'Owner', 'TransportManager, Tr', '2025-01-19', '2025-01-25', 'Completed'),
(20, 'Task 20', 'Review supplier contracts', 'Owner', 'FactoryManager, Supe', '2025-01-20', '2025-01-26', 'Assign');

-- --------------------------------------------------------

--
-- Table structure for table `transport_cost_reports`
--

CREATE TABLE `transport_cost_reports` (
  `id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_date` date NOT NULL,
  `transport_company` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `total_distance` int(11) NOT NULL,
  `fuel_cost` decimal(10,2) NOT NULL,
  `driver_cost` decimal(10,2) NOT NULL,
  `maintenance_cost` decimal(10,2) DEFAULT NULL,
  `other_costs` decimal(10,2) DEFAULT NULL,
  `total` double(7,2) NOT NULL,
  `observations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_cost_reports`
--

INSERT INTO `transport_cost_reports` (`id`, `report_title`, `report_date`, `transport_company`, `route`, `total_distance`, `fuel_cost`, `driver_cost`, `maintenance_cost`, `other_costs`, `total`, `observations`) VALUES
(1, 'January Transport Report', '2025-01-01', 'XYZ Transport Ltd.', 'Colombo to Kandy', 120, 8000.00, 5000.00, 2000.00, 1500.00, 16500.00, 'Smooth operations, slight delay due to weather conditions'),
(2, 'February Transport Report', '2025-02-01', 'ABC Logistics', 'Kandy to Galle', 150, 10000.00, 6000.00, 2500.00, 1700.00, 19500.00, 'No major issues encountered during the journey'),
(3, 'March Transport Report', '2025-03-01', 'LMN Freight Services', 'Colombo to Jaffna', 200, 12000.00, 7000.00, 3000.00, 2000.00, 24000.00, 'Extended rest stops for drivers'),
(4, 'April Transport Report', '2025-04-01', 'XYZ Transport Ltd.', 'Galle to Colombo', 130, 8500.00, 5500.00, 1800.00, 1200.00, 17300.00, 'Minor breakdown of vehicle, delayed arrival'),
(5, 'May Transport Report', '2025-05-01', 'ABC Logistics', 'Negombo to Colombo', 100, 7500.00, 4800.00, 1500.00, 1000.00, 14800.00, 'Smooth journey, no delays'),
(6, 'June Transport Report', '2025-06-01', 'LMN Freight Services', 'Jaffna to Galle', 250, 13000.00, 7500.00, 3500.00, 2100.00, 27000.00, 'Delays due to traffic congestion near city areas'),
(7, 'July Transport Report', '2025-07-01', 'XYZ Transport Ltd.', 'Colombo to Trincomalee', 180, 9500.00, 6000.00, 2300.00, 1800.00, 19600.00, 'Late arrival, vehicle checked for maintenance'),
(8, 'August Transport Report', '2025-08-01', 'ABC Logistics', 'Kandy to Colombo', 140, 8000.00, 5500.00, 2200.00, 1500.00, 18000.00, 'Unexpected delays due to roadworks'),
(9, 'September Transport Report', '2025-09-01', 'LMN Freight Services', 'Colombo to Matara', 170, 10500.00, 6500.00, 2900.00, 1900.00, 21900.00, 'Timely deliveries, smooth route'),
(10, 'October Transport Report', '2025-10-01', 'XYZ Transport Ltd.', 'Galle to Colombo', 160, 9200.00, 5800.00, 2100.00, 1600.00, 18700.00, 'Minor delays due to weather conditions');

-- --------------------------------------------------------

--
-- Table structure for table `transport_details`
--

CREATE TABLE `transport_details` (
  `transport_id` int(5) NOT NULL,
  `type` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `note` varchar(100) NOT NULL,
  `cost` double(7,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `driver_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `staf_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(12) NOT NULL,
  `password` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`staf_id`, `email`, `phone`, `password`) VALUES
(1, 'nigeeth@gmail.com', 764846394, '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addorder`
--
ALTER TABLE `addorder`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`spid`);

--
-- Indexes for table `cpayment`
--
ALTER TABLE `cpayment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `credit_payments`
--
ALTER TABLE `credit_payments`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `credit_table`
--
ALTER TABLE `credit_table`
  ADD PRIMARY KEY (`CreditID`);

--
-- Indexes for table `daily_report`
--
ALTER TABLE `daily_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_payments`
--
ALTER TABLE `debit_payments`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `debit_table`
--
ALTER TABLE `debit_table`
  ADD PRIMARY KEY (`DebitID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `dissues`
--
ALTER TABLE `dissues`
  ADD PRIMARY KEY (`IssuesID`);

--
-- Indexes for table `driver_status`
--
ALTER TABLE `driver_status`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `edaily`
--
ALTER TABLE `edaily`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eperformance`
--
ALTER TABLE `eperformance`
  ADD PRIMARY KEY (`eno`);

--
-- Indexes for table `genorder`
--
ALTER TABLE `genorder`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `incost`
--
ALTER TABLE `incost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lclogin`
--
ALTER TABLE `lclogin`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `lcorder`
--
ALTER TABLE `lcorder`
  ADD PRIMARY KEY (`OrderID`) USING BTREE,
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `lcregister`
--
ALTER TABLE `lcregister`
  ADD PRIMARY KEY (`ExportID`,`NIC`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `lffeedback`
--
ALTER TABLE `lffeedback`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lflogin`
--
ALTER TABLE `lflogin`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `lforder`
--
ALTER TABLE `lforder`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `lfregister`
--
ALTER TABLE `lfregister`
  ADD PRIMARY KEY (`ExportID`,`IIC`);

--
-- Indexes for table `mrequest`
--
ALTER TABLE `mrequest`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `paypal_payments`
--
ALTER TABLE `paypal_payments`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `paypal_table`
--
ALTER TABLE `paypal_table`
  ADD PRIMARY KEY (`PaypalID`);

--
-- Indexes for table `pmstock`
--
ALTER TABLE `pmstock`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `pprocess`
--
ALTER TABLE `pprocess`
  ADD PRIMARY KEY (`ppid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `production_cost_reports`
--
ALTER TABLE `production_cost_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_material`
--
ALTER TABLE `product_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`Profile_ID`);

--
-- Indexes for table `pstock`
--
ALTER TABLE `pstock`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `revenu`
--
ALTER TABLE `revenu`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`SalaryID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `sgenpay`
--
ALTER TABLE `sgenpay`
  ADD PRIMARY KEY (`SupplierID`,`OrderID`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shid`);

--
-- Indexes for table `spayment`
--
ALTER TABLE `spayment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `suplogin`
--
ALTER TABLE `suplogin`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `supply_requset`
--
ALTER TABLE `supply_requset`
  ADD PRIMARY KEY (`requset_id`);

--
-- Indexes for table `supregister`
--
ALTER TABLE `supregister`
  ADD PRIMARY KEY (`SupplierID`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskid`);

--
-- Indexes for table `transport_cost_reports`
--
ALTER TABLE `transport_cost_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_details`
--
ALTER TABLE `transport_details`
  ADD PRIMARY KEY (`transport_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`staf_id`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addorder`
--
ALTER TABLE `addorder`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `spid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `credit_payments`
--
ALTER TABLE `credit_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `credit_table`
--
ALTER TABLE `credit_table`
  MODIFY `CreditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `debit_payments`
--
ALTER TABLE `debit_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `debit_table`
--
ALTER TABLE `debit_table`
  MODIFY `DebitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dissues`
--
ALTER TABLE `dissues`
  MODIFY `IssuesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `edaily`
--
ALTER TABLE `edaily`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `genorder`
--
ALTER TABLE `genorder`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `incost`
--
ALTER TABLE `incost`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lcorder`
--
ALTER TABLE `lcorder`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lcregister`
--
ALTER TABLE `lcregister`
  MODIFY `ExportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lffeedback`
--
ALTER TABLE `lffeedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lforder`
--
ALTER TABLE `lforder`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lfregister`
--
ALTER TABLE `lfregister`
  MODIFY `ExportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mrequest`
--
ALTER TABLE `mrequest`
  MODIFY `rid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `paypal_payments`
--
ALTER TABLE `paypal_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypal_table`
--
ALTER TABLE `paypal_table`
  MODIFY `PaypalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `production_cost_reports`
--
ALTER TABLE `production_cost_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_material`
--
ALTER TABLE `product_material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `Profile_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `revenu`
--
ALTER TABLE `revenu`
  MODIFY `rid` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `SalaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `saleID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `shid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `spayment`
--
ALTER TABLE `spayment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supply_requset`
--
ALTER TABLE `supply_requset`
  MODIFY `requset_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supregister`
--
ALTER TABLE `supregister`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transport_cost_reports`
--
ALTER TABLE `transport_cost_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transport_details`
--
ALTER TABLE `transport_details`
  MODIFY `transport_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `staf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lcorder`
--
ALTER TABLE `lcorder`
  ADD CONSTRAINT `lcorder_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `lcregister`
--
ALTER TABLE `lcregister`
  ADD CONSTRAINT `lcregister_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `lclogin` (`Email`);

--
-- Constraints for table `lforder`
--
ALTER TABLE `lforder`
  ADD CONSTRAINT `lforder_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`staf_id`) REFERENCES `user` (`staf_id`);

--
-- Constraints for table `spayment`
--
ALTER TABLE `spayment`
  ADD CONSTRAINT `spayment_ibfk_1` FOREIGN KEY (`SupplierID`,`OrderID`) REFERENCES `sgenpay` (`SupplierID`, `OrderID`);

--
-- Constraints for table `supregister`
--
ALTER TABLE `supregister`
  ADD CONSTRAINT `supregister_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `suplogin` (`Email`);

--
-- Constraints for table `transport_details`
--
ALTER TABLE `transport_details`
  ADD CONSTRAINT `transport_details_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver_status` (`driver_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
