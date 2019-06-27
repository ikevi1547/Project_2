-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2019 at 11:50 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `21`
--

CREATE TABLE `21` (
  `ID` int(11) NOT NULL,
  `USER_COMMENTS` longtext NOT NULL,
  `USER_NAME` varchar(40) NOT NULL,
  `COMMENT_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `21`
--

INSERT INTO `21` (`ID`, `USER_COMMENTS`, `USER_NAME`, `COMMENT_DATE`) VALUES
(1, 'I was due to go to Cornwall on Saturday and Trnsmt. Iâ€™m gutted but have dried my tears and completely understand the decision. Might still go to Cornwall for a wee holiday. All my love to you all and wishing Nate and Johnny the speediest of recoveries. X ðŸ’™â„ï¸', 'kevin peter', '2019-06-27 14:07:43'),
(3, 'So sorry to read this guys. Wishing Nathan and Johnny speedy recoveries. You guys come first, your both the hub of Snow Patrol. Hugs xx', 'kevin peter', '2019-06-27 14:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `22`
--

CREATE TABLE `22` (
  `ID` int(11) NOT NULL,
  `USER_COMMENTS` longtext NOT NULL,
  `USER_NAME` varchar(40) NOT NULL,
  `COMMENT_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `ID` int(11) NOT NULL,
  `BLOG_CATEGORY` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`ID`, `BLOG_CATEGORY`) VALUES
(4, 'Technology'),
(5, 'Travel'),
(6, 'Events'),
(8, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `blog_info`
--

CREATE TABLE `blog_info` (
  `ID` int(11) NOT NULL,
  `BLOG_TITLE` varchar(100) NOT NULL,
  `BLOG_COMMENT_TABLE_NAME` int(11) NOT NULL,
  `BLOG_CATEGORY` varchar(20) NOT NULL,
  `BLOG_CONTENT` longtext NOT NULL,
  `BLOG_DATE_TIME` datetime DEFAULT NULL,
  `BLOG_UPDATED` datetime DEFAULT NULL,
  `BLOG_PHOTOS_PATH` varchar(100) NOT NULL DEFAULT 'N',
  `BLOG_AUTHOR` varchar(50) NOT NULL,
  `BLOG_TAGS` varchar(2000) NOT NULL,
  `BLOG_STATUS` varchar(10) NOT NULL,
  `BLOG_RECOMMEND` varchar(1) NOT NULL DEFAULT 'N',
  `BLOG_ADMIN_COMMENTS` longtext NOT NULL,
  `BLOG_COMMENT_COUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_info`
--

INSERT INTO `blog_info` (`ID`, `BLOG_TITLE`, `BLOG_COMMENT_TABLE_NAME`, `BLOG_CATEGORY`, `BLOG_CONTENT`, `BLOG_DATE_TIME`, `BLOG_UPDATED`, `BLOG_PHOTOS_PATH`, `BLOG_AUTHOR`, `BLOG_TAGS`, `BLOG_STATUS`, `BLOG_RECOMMEND`, `BLOG_ADMIN_COMMENTS`, `BLOG_COMMENT_COUNT`) VALUES
(21, 'SNOW PATROL FORCED TO WITHDRAW, THE CHARLATANS TO PLAY THAT SLOT', 21, 'Events', 'Unfortunately. Snow Patrol have been forced to cancel their 6.30pm Other Stage performance on Friday evening for medical reasons. The Charlatans will now be playing that slot.', '2019-06-25 17:00:00', '2019-06-27 14:21:22', '65728166_10157462984052072_336829567488491520_n.jpg', 'Glaston Bury Festivals', 'Packages-Holidays-', 'publish', 'N', 'I\'m just thankful to have been able to continue a tradition of seeing you guys live. The first time I took my oldest for her 7th Birthday present, and this past show, with my youngest, who is 9. You guys need to get better soon, so you will be rocking out, when we see you the next album!', 2),
(22, 'ENGLAND WOMEN\'S WORLD CUP GAME TO BE SHOWN ON WEST HOLTS SCREENS', 22, 'Sports', 'We are delighted to be able to announce that â€“ of course! â€“ we\'ll be screening The Lionesses\' big Women\'s World Cup quarter-final match. England vs Norway, Thursday evening, on the West Holts Stage\'s big screens. Kick-off is at 8pm. We\'ll see you there!', '2019-06-25 14:00:00', '2019-06-27 14:31:57', 'england.jpg', 'Glaston Bury', 'Entertainment-', 'publish', 'Y', 'Thursday evening, on the West Holts Stage\'s big screens. Kick-off is at 8pm. We\'ll see you there!'', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `ID` int(11) NOT NULL,
  `BLOG_TAG` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_tags`
--

INSERT INTO `blog_tags` (`ID`, `BLOG_TAG`) VALUES
(13, 'Airline'),
(14, 'Hotel'),
(15, 'Car'),
(16, 'Packages'),
(17, 'Holidays'),
(18, 'Deals'),
(20, 'Entertainment');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `MOBILENUMBER` int(10) NOT NULL,
  `PASS` varchar(255) NOT NULL,
  `ADMIN_ACCESS` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `USERNAME`, `EMAIL`, `MOBILENUMBER`, `PASS`, `ADMIN_ACCESS`) VALUES
(1, 'kevi', 'kevinxpeter@gmail.com', 23423, 'keviloveu', 'NO'),
(3, 'kevin peter', 'kevinxpeter@gmail.com', 242342, 'keviloveu', 'GRANT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `21`
--
ALTER TABLE `21`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `22`
--
ALTER TABLE `22`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blog_info`
--
ALTER TABLE `blog_info`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `21`
--
ALTER TABLE `21`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `22`
--
ALTER TABLE `22`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blog_info`
--
ALTER TABLE `blog_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
