-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2017 at 12:15 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filo`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` int(11) NOT NULL,
  `ItemName` varchar(25) NOT NULL,
  `Category` enum('Pet','Phone','Jewellery') NOT NULL,
  `FoundTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` int(11) NOT NULL,
  `FoundPlace` varchar(25) NOT NULL,
  `Colour` varchar(20) NOT NULL,
  `Photo` varchar(256) NOT NULL,
  `Description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `RequestID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Status` enum('Pending','Approved','Rejected') NOT NULL,
  `Description` varchar(100) NOT NULL,
  `DateCreated` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`RequestID`, `UserID`, `ItemID`, `Status`, `Description`, `DateCreated`) VALUES
(1, 1, 1, 'Pending', 'sadasdasdas', '2017-04-04 16:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Postcode` varchar(6) NOT NULL,
  `TelephoneNo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `IsAdmin`, `Username`, `Password`, `Firstname`, `Surname`, `Gender`, `Postcode`, `TelephoneNo`) VALUES
(1, 1, 'testuser', '42810cb02db3bb2cbb428af0d8b0376e', 'test', 'user', 'Male', '111111', '111111'),
(3, 0, 'sadds', 'hai', 'hai', 'hai', 'Male', 'hai', 'hai'),
(5, 0, 'hai', '42810cb02db3bb2cbb428af0d8b0376e', 'hai', 'hai', 'Male', 'hai', 'h'),
(6, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'user', 'Male', 'admin', 'admin'),
(7, 0, 'testr', '5f4dcc3b5aa765d61d8327deb882cf99', 'test', 'r', 'Male', 'test', 'test'),
(8, 0, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'user', 'Male', 'b11b11', '01211111111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
