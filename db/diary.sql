-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2018 at 11:07 AM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diary`
--

-- --------------------------------------------------------

--
-- Table structure for table `dagboeken`
--

CREATE TABLE `dagboeken` (
  `id_dagboek` int(5) NOT NULL,
  `naam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dagboeken_posts`
--

CREATE TABLE `dagboeken_posts` (
  `id_dagboek` int(5) NOT NULL,
  `id_post` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id_gebruiker` int(5) NOT NULL,
  `voornaam` varchar(50) NOT NULL,
  `tussenvoegsels` varchar(10) NOT NULL,
  `achternaam` varchar(50) NOT NULL,
  `Email` varchar(254) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id_gebruiker`, `voornaam`, `tussenvoegsels`, `achternaam`, `Email`, `wachtwoord`) VALUES
(1, 'test', 'test', 'test', 'test@test.nl', '$2y$12$b/4g4XM.Lc5CYc5d97yjuuzrsHm9pn9H8slrNusnR8SbRW6uB3NbW');

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers_dagboeken`
--

CREATE TABLE `gebruikers_dagboeken` (
  `id_gebruiker` int(5) NOT NULL,
  `id_dagboek` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gebruikers_dagboeken`
--

INSERT INTO `gebruikers_dagboeken` (`id_gebruiker`, `id_dagboek`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(5) NOT NULL,
  `post` text NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_post`, `post`, `datum`) VALUES
(1, '', '2018-09-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dagboeken`
--
ALTER TABLE `dagboeken`
  ADD PRIMARY KEY (`id_dagboek`);

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id_gebruiker`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dagboeken`
--
ALTER TABLE `dagboeken`
  MODIFY `id_dagboek` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id_gebruiker` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
