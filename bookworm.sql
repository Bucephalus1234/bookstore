-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 06:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookworm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(18, 6, 'Science Fitction', 49, 1, 'Science Fiction.png'),
(19, 6, 'Fantasy', 29, 1, 'Fantasy.png'),
(20, 6, 'The World', 59, 1, 'the_world.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `iv` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`, `iv`) VALUES
(3, 6, 'Rafiq', 'rafiqjamal59@gmail.com', '4', 'ezu8ORfHlUC7YbfBrUhA8A==', '6f1c4c048843e5bfb6735fe3c22c5ac5'),
(5, 6, 'Rafiq', 'rafiqjamal59@gmail.com', '12345678', 'jlz/Rd5XSyuhoJ3YOF8phErJBrp8P8mLt6HgsSVdGrJWykBWuP4/1h3xQUUC9Skd', '237d0029d40860e5ffb42047c9d7ff63'),
(6, 6, 'Rafiq', 'rafiqjamal59@gmail.com', '12345678', 'G7C/Y01bFjyTfp7ensIQNSKlGYX9lR26MNDkq/wd4sMxM39Ogw3CSuURINlB0bOX', 'cef151b47f79856b934a957d79c66ca7'),
(7, 6, 'Kyaw', 'rafiqjamal59@gmail.com', '108956', 'xV+aqRmaBef+Q5eRboM7XQ==', '0d218f27f8a449a74516d3393a0b4689'),
(8, 6, 'Kyaw', 'rafiqjamal59@gmail.com', '108956', 'LapxZjG3qdfdPJJTa6L2oQ==', '1dfb99b4992dc5c3a9784489a60fb536'),
(9, 6, 'Kyaw', 'rafiqjamal59@gmail.com', '108956', 'SXAFX2vq/6OAjRp5rM2Vjg==', '8b0cce59bf5e9c2f63fe8b2ba0650076');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 6, 'Rafiq', '4', 'rafiqjamal59@gmail.com', 'cash on delivery', 'flat no. 1, 12, Singapore, Singapore - 123456', ', The World (1) , Science Fitction (1) ', 249, '04-Jun-2024', 'completed'),
(2, 6, 'Rafiq', '4', 'rafiqjamal59@gmail.com', 'cash on delivery', 'flat no. 1, 12, Singapore, Singapore - 123456', ', Science Fitction (1) , The World (1) , Mystery (1) ', 137, '16-Jun-2024', 'completed'),
(3, 6, 'Kyaw', '123', 'kzinlatt553@gmail.com', 'credit card', 'flat no. 123, q2, Singapore, Singapore - 121231', ', Science Fitction (1) , Fantasy (1) , The World (1) ', 137, '17-Jun-2024', 'completed'),
(4, 6, 'Kyaw', '123', 'kzinlatt553@gmail.com', 'credit card', 'flat no. 123, q2, Singapore, Singapore - 121231', ', Science Fitction (1) , Mystery (1) , The World (1) ', 137, '17-Jun-2024', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(6, 'Science Fitction', 49, 'Science Fiction.png'),
(7, 'Fantasy', 29, 'Fantasy.png'),
(8, 'The World', 59, 'the_world.jpg'),
(9, 'Clever Lands', 19, 'clever_lands.jpg'),
(10, 'Mystery', 29, 'Mystery.png'),
(12, 'Romance', 26, 'Romance.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `otp`, `otp_expiration`) VALUES
(6, 'Rafiq', 'rafiqjamal59@gmail.com', '$2y$10$v1h0Q/uMBwCOpxfO7LXGBO/e7McdAEMuaBz4m36vIIPFd.mkvabEa', 'user', NULL, NULL),
(8, 'Admin', 'kzinlatt553@gmail.com', '$2y$10$MxXFJMXE9BW3ctLLAM.TVO2yvp/fpm8Xlg6Sx8/90/hmKGRfU76kW', 'admin', NULL, NULL),
(10, 'Kyaw Zin Latt', 'kyawzinlatt111187@gmail.com', '$2y$10$8s0.X46jMaBrXo/YTRopTewKV0HxLgG2bhMpKX3573iqSKpSkx9GO', 'user', '', '0000-00-00 00:00:00'),
(12, 'Kyaw', 'kyawzinlattrafiq@gmail.com', '$2y$10$gqLrkLsxF4BNBzHJcC6xB.dGKZnQZ0JPdWkmNs1sgC.1w5ivLdZ/W', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
