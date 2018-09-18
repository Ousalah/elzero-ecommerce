-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2018 at 06:40 PM
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
(4, 'abmlk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abmlk@gmail.com', 'ayoub abmlk', 0, 0, 0, '0000-00-00'),
(5, 'hamza', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'hamza@gmail.com', 'hamza hamza', 0, 0, 0, '0000-00-00'),
(9, 'fgfgfgfd', '3c0fc5decc5eed3df6324d4264fa9b91d66f18e5', 'fgfg@gfg', 'fgfg', 0, 0, 0, '0000-00-00'),
(10, 'fgfhgfhgfDD', '0ff018db3f38a357b13522beacb17aefa44cdfdd', 'fgfg@gfg', 'dfdfd', 0, 0, 0, '0000-00-00'),
(12, 'moha', 'e54840d847d19a9beafe2faa6bf00583d2a9fee9', 'mohamed@gmail.com', 'mohamed mohamed', 0, 0, 0, '2018-09-18');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
