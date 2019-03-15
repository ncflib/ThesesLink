-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

-- --------------------------------------------------------

--
-- Table structure for table `aocs`
--

CREATE TABLE `aocs` (
  `id` int(11) NOT NULL,
  `aoc` text NOT NULL,
  `thesis` int(11) NOT NULL,
  `division` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `thesis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `theses`
--

CREATE TABLE `theses` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `student` text NOT NULL,
  `sponsor` text NOT NULL,
  `graduatedate` text NOT NULL,
  `degree` text NOT NULL,
  `grantor` text NOT NULL,
  `division` text NOT NULL,
  `tlink` text NOT NULL,
  `abstract` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aocs`
--
ALTER TABLE `aocs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis` (`thesis`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aocs`
--
ALTER TABLE `aocs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6896;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17876;
--
-- AUTO_INCREMENT for table `theses`
--
ALTER TABLE `theses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5737;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
