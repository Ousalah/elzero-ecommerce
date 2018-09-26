-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2018 at 02:01 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elzeroshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` smallint(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) NOT NULL DEFAULT '0',
  `Visibility` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 = hidden, 1 = visible',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '1',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Electronics', '', 1000, 0, 0, 0),
(2, 'PC', 'Pc description', 0, 0, 1, 0),
(3, 'Mobile', 'this is category of mobile like samsung, iphone, htc, nokia', 10, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL COMMENT 'New, Used, Like New, ...',
  `Rating` smallint(6) NOT NULL,
  `CatID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Registration Approval',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'ousalah', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohamed@ousalah.com', 'Mohamed Ousalah', 1, 0, 1, '2018-09-07'),
(2, 'mohamed', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'mohamed@gmail.com', 'mohamed mohamed', 0, 0, 1, '2018-09-10'),
(4, 'abmlk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abmlk@gmail.com', 'ayoub abmlk', 0, 0, 1, '0000-00-00'),
(5, 'hamza', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'hamza@gmail.com', 'hamza hamza', 0, 0, 1, '0000-00-00'),
(12, 'moha', 'e54840d847d19a9beafe2faa6bf00583d2a9fee9', 'moha@gmail.com', 'mohamed mohamed', 0, 0, 1, '2018-09-18'),
(13, 'gfgf', '1e99398da6cf1faa3f9a196382f1fadc7bb32fb7', 'fgfg@gfg', 'fgfgfd', 0, 0, 0, '2018-09-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
