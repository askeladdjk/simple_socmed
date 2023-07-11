-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 08:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `octagram_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`) VALUES
(1, 15, 4, 'i like it AHA AHA', '2023-06-14 06:58:19'),
(12, 10, 11, 'add', '2023-06-14 13:21:30'),
(13, 10, 17, 'asd', '2023-06-14 13:25:36'),
(17, 10, 4, 'nami-himeeeee ', '2023-06-15 05:00:00'),
(18, 10, 101, 'Piw Piw\r\n', '2023-06-15 05:07:28'),
(19, 10, 4, 'brook using, \"i wanna see your undies\"', '2023-06-15 05:12:54'),
(20, 15, 87, 'Hellow', '2023-06-15 05:13:43'),
(21, 15, 4, 'i\'ll kill u buggy-chan hehe', '2023-06-15 05:14:09'),
(23, 15, 4, 'Are you in east blue?', '2023-06-15 05:39:22'),
(24, 15, 68, 'Bading', '2023-06-15 05:50:58'),
(25, 15, 68, 'One Shotted by the Overlord, sword king my buttcrack', '2023-06-15 05:51:30'),
(27, 16, 102, 'Monster Energy', '2023-06-15 06:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`) VALUES
(4, 10, 'Nami- swaaaan', '2023-06-14 03:52:24'),
(11, 10, 'yameti kudasai\r\n', '2023-06-14 04:24:47'),
(14, 15, 'Kaisuko ', '2023-06-14 05:14:37'),
(17, 15, 'Look like a star only on a camera', '2023-06-14 05:21:29'),
(68, 15, 'Swork King Stronoff', '2023-06-14 14:19:22'),
(71, 15, 'cat calling: meow meorw', '2023-06-14 14:20:01'),
(87, 10, 'Hi Raksan', '2023-06-15 03:32:54'),
(88, 10, 'kami kami ha ', '2023-06-15 03:33:02'),
(89, 10, 'Spirit Dive', '2023-06-15 03:33:31'),
(91, 10, 'Kuma Kuma Kuma Bear', '2023-06-15 03:34:30'),
(93, 10, 'class S na halimaw\r\n', '2023-06-15 03:34:54'),
(94, 10, 'Askeladd san', '2023-06-15 04:08:36'),
(98, 10, 'Hadoken', '2023-06-15 04:17:02'),
(99, 10, 'Yami Mahuo Yami Matoy', '2023-06-15 04:44:34'),
(100, 10, 'Akina 86 - Fujiwara Takumi', '2023-06-15 05:06:47'),
(101, 10, 'Death The Kid', '2023-06-15 05:07:19'),
(102, 16, 'Boom Tarat Tarat', '2023-06-15 06:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `bdate` date NOT NULL,
  `phonenumber` varchar(250) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fname`, `lname`, `bdate`, `phonenumber`, `gender`, `created_at`) VALUES
(10, 'adminbuggy@gmail.com', '$2y$10$XSyAs/JMBLveTUjJk8VF6.zScvi0qYjvUiALRvZ05h0mSYPyazP2W', 'admin', 'buggy', '2001-12-11', '9969012550', 'male', '2023-06-12 14:53:48'),
(11, 'gai@gmail.com', '$2y$10$WM5tM//UV3P2rQSM56MWQeU/pM1TVBgjDFdmVV6afJeKkt4LUgSXe', 'Might ', 'Gai', '2001-12-11', '99690127780', 'male', '2023-06-14 05:02:29'),
(12, 'majinbuu@gmail.com', '$2y$10$s/vhEcUAf6urGhHUhJ6kCexydGHBCrjgpwOy9BeT2erF1XfvrE62i', 'Majin', 'Buuu', '2001-12-11', '99690127110', 'male', '2023-06-14 05:05:30'),
(13, 'skrtlord@gmail.com', '$2y$10$nBHaIsvpuH6zBzgS91qKduljnoqHcOouh9B0.DpS9PUDm/Rwk8Gce', 'Scarr', 'Lord', '2011-11-11', '9782222123', 'male', '2023-06-14 05:12:15'),
(15, 'raksan@gmail.com', '$2y$10$YStCD9cSTyh99gk/x.K60eubV7aWnB/kMCOvERkqcjxBh10nCOB6y', 'ray', 'gunn', '2009-02-12', '9778823121', 'female', '2023-06-14 05:13:59'),
(16, 'majorbazooka@gmail.com', '$2y$10$sOgWY9AlBRPu07iCf93DVebIwrb21aCqDKuRP0llfbBGaFxe7GWGq', 'Major ', 'Bazooka', '2201-12-11', '9923901021', 'male', '2023-06-15 06:18:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
