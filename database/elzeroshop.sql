-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2018 at 12:22 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) NOT NULL DEFAULT '0',
  `Visibility` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 = hidden, 1 = visible',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '1',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(9, 'Handmade', 'Handmade items', 0, 1, 1, 1, 1),
(10, 'Computers', 'Computers  items', 0, 2, 1, 1, 1),
(11, 'Cell Phones', 'Cell Phones items', 0, 3, 1, 1, 1),
(12, 'Clothing', 'Clothing items', 0, 4, 1, 1, 1),
(13, 'Tools', 'Home Tools items', 0, 5, 1, 1, 1),
(14, 'Nokia', 'Nokia mobile phone', 11, 2, 1, 1, 1),
(15, 'Samsung', '', 11, 0, 1, 1, 1),
(16, 'LG', '', 11, 0, 1, 1, 1),
(17, 'Boxes', '', 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `ItemID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `Comment`, `Status`, `Comment_Date`, `ItemID`, `UserID`) VALUES
(1, 'very good item', 1, '2018-10-08', 8, 1),
(2, 'good item', 1, '2018-10-11', 10, 15),
(5, 'this is a big heading changing the code', 1, '2018-10-11', 8, 1),
(6, 'Hi friends', 1, '2018-10-11', 8, 5),
(7, 'nice', 0, '2018-10-14', 8, 1);

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
  `Approve` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 == Not approved, 1 == approved',
  `CatID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `CatID`, `MemberID`) VALUES
(8, 'Acer Aspire E 15', 'Acer Aspire E 15 E5-576-392H comes with these high level specs: 8th Generation Intel Core i3-8130U Processor 2.2GHz with Turbo Boost Technology up to 3.4GHz, Windows 10 Home, 15.6\" Full HD (1920 x 1080) widescreen LED-backlit display, Intel UHD Graphics 620, 6GB Dual Channel Memory, 1TB 5400RPM SATA Hard Drive, 8X DVD Double-Layer Drive RW (M-DISC enabled), Secure Digital (SD) card reader, Acer True Harmony, Two Built-in Stereo Speakers, 802.11ac Wi-Fi featuring MU-MIMO technology (Dual-Band 2.4GHz and 5GHz), Bluetooth 4.1, HD Webcam (1280 x 720) supporting High Dynamic Range (HDR), 1 - USB 3.1 Type C Gen 1 port (up to 5 Gbps), 2 - USB 3.0 ports (one with power-off charging), 1 - USB 2.0 port, 1 - HDMI Port with HDCP support, 6-cell Li-Ion Battery (2800 mAh), Up to 13.5-hours Battery Life, 5.27 lbs. | 2.39 kg (system unit only) (NX.GRYAA.001).', '379.99', '2018-10-04', 'Europe', '', '1', 0, 1, 10, 1),
(9, 'Logitech G502 Proteus Spectrum RGB Tunable', 'G502 features an advanced optical sensor for maximum tracking accuracy, customizable RGB lighting, custom game profiles, from 200 up to 12,000 DPI, and repositionable weights. Troubleshooting steps- • Unplug and re-plug the USB cable to ensure a good connection. • Try the mouse USB cable in another USB port on the computer. • Use only a powered USB port. • Try rebooting the computer. • If possible, test the mouse on another computer.', '49.98', '2018-10-04', 'USA', '', '2', 0, 1, 10, 2),
(10, 'Samsung Galaxy S8', 'U.S. limited warranty. Latest Galaxy phone with Infinity Display, Duel Pixel Camera, iris scanning and Ip68-rated water and dust resistance. The phone comes with a stunning 5.8\" Quad HD+ Super AMOLED display (2960x1440) with 570 ppi and world\'s first 10nm processor.', '499.99', '2018-10-04', 'Korea', '', '1', 0, 1, 11, 4),
(11, 'Keyboard Logitech', 'this is a good keyboard for the professional person', '80', '2018-10-11', 'USA', '', '1', 0, 0, 10, 1);

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
(2, 'mohamed', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'mohamed@gmail.com', 'mohamed mohamed', 0, 0, 0, '2018-09-10'),
(4, 'abmlk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abmlk@gmail.com', 'ayoub abmlk', 0, 0, 1, '0000-00-00'),
(5, 'hamza', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'hamza@gmail.com', 'hamza hamza', 0, 0, 1, '0000-00-00'),
(12, 'moha', 'e54840d847d19a9beafe2faa6bf00583d2a9fee9', 'moha@gmail.com', 'mohamed mohamed', 0, 0, 1, '2018-09-18'),
(13, 'Soufiane', '1e99398da6cf1faa3f9a196382f1fadc7bb32fb7', 'Soufiane@gmail.com', 'Soufiane Soufiane', 0, 0, 1, '2018-09-20'),
(14, 'osama', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'osama@gmail.com', 'osama osama', 0, 0, 1, '2018-10-05'),
(15, 'karim', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'karim@gmail.com', '', 0, 0, 0, '2018-10-08');

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `items_comment` (`ItemID`),
  ADD KEY `users_comment` (`UserID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `member_1` (`MemberID`),
  ADD KEY `cat_1` (`CatID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comment` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`CatID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`MemberID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
