-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 21, 2024 at 01:27 PM
-- Server version: 9.0.1
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `food_id` int NOT NULL,
  `note` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `food_id`, `note`, `quantity`, `created_at`) VALUES
(9, 9, 1, 'Cabuk!!1', 3, '2024-09-21 00:23:35'),
(10, 9, 2, 'hehe', 1, '2024-09-21 00:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `score` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `restaurant_id`, `username`, `title`, `description`, `score`, `created_at`, `updated_at`) VALUES
(1, 9, 2, 'user', 'cok ii', 'ellerinize saglik', 6, '2024-09-21 01:55:21', '2024-09-21 01:55:21'),
(2, 9, 2, 'user', 'eh', 'fena degil', 3, '2024-09-21 02:22:41', '2024-09-21 02:22:41'),
(3, 12, 2, 'user1', 'soguk', 'yimek soguk geldi :((', 1, '2024-09-21 13:16:03', '2024-09-21 13:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `description`, `logo_path`, `deleted_at`) VALUES
(1, 'tanrim umarim', 'gunceller', '../uploads/company/1726662212.jpeg', '2024-09-17 13:34:26'),
(3, 'qwe124', 'teost mi', '../uploads/company/1726742779.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cupon`
--

CREATE TABLE `cupon` (
  `id` int NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `discount` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cupon`
--

INSERT INTO `cupon` (`id`, `restaurant_id`, `name`, `discount`, `created_at`) VALUES
(2, NULL, 'kupon1', 78, '2024-09-18 10:52:17'),
(3, 2, 'gguncelkupon', 54, '2024-09-20 10:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `discount` int NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `restaurant_id`, `name`, `description`, `image_path`, `price`, `discount`, `created_at`, `deleted_at`) VALUES
(1, 2, 'pide', 'kiymali kasarli pide', '../uploads/food/1726745889.jpg', 99, 50, '2024-09-19 11:38:09', NULL),
(2, 2, 'lehmacun', 'finduk', '../uploads/food/1726785197.jpg', 150, 0, '2024-09-19 22:33:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `total_price` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `food_id` int NOT NULL,
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `company_id`, `name`, `description`, `image_path`, `created_at`) VALUES
(1, 3, 'azhakiki brolar', 'lahmacuncu', '../uploads/restaurant/1726692758.png', '2024-09-18 17:13:34'),
(2, 3, 'haskardesler', 'corbaci', '../uploads/restaurant/1726690011.jpeg', '2024-09-18 20:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '2',
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` int NOT NULL DEFAULT '5000',
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `role`, `name`, `surname`, `username`, `password`, `balance`, `created_at`, `deleted_at`) VALUES
(0, NULL, 0, 'admin', 'admin', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$S0Q5MFVIc3RiMzJHb0NoeQ$U74dYhrrSF9Cqvg71HH5XEnEM3PY9aL6dHU2NkoKI58', 5000, '2024-09-15 17:18:48', NULL),
(9, NULL, 2, 'user', 'user', 'user', '$argon2id$v=19$m=65536,t=4,p=1$UGZuS2FWWC91OHlzci9BLg$lLFPlb3OXZGHn/y/4UjWjo4AymdMG6OIRr++P7+lR78', 5056, '2024-09-15 17:19:30', NULL),
(10, NULL, 2, 'banlı', 'kullanıcı', 'banlı', '$argon2id$v=19$m=65536,t=4,p=1$RFF1bVBNblZZSi5SRTU0eQ$/kWhF9svqdZ2np8u7A844TdlQfZBdLrrwSSurFFAvAE', 5000, '2024-09-15 21:00:42', '2024-09-15 22:02:34'),
(11, 3, 1, 'firma', 'firma', 'firma', '$argon2id$v=19$m=65536,t=4,p=1$QzRncTNvcDFYWVdSdEEvSA$MuceoqxSAPArTBdJICj5I644u19SxDIPB2Aq9MeDoVw', 5000, '2024-09-18 13:01:42', NULL),
(12, NULL, 2, 'user1', 'user1', 'user1', '$argon2id$v=19$m=65536,t=4,p=1$c05UYWU3UkNHQnRVVEdObw$1zOf/YOLA7MUfiHc1zC7WptXC4xqmroSrRxZy11SQCE', 5000, '2024-09-21 13:15:35', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_basket` (`user_id`),
  ADD KEY `fk_food_basket` (`food_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_comments` (`user_id`),
  ADD KEY `fk_restaurant_comments` (`restaurant_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurant_cupon` (`restaurant_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurant_food` (`restaurant_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_order` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food_order_items` (`food_id`),
  ADD KEY `fk_order_order_items` (`order_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_restaurant` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_users` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cupon`
--
ALTER TABLE `cupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `fk_food_basket` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_users_basket` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_restaurant_comments` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_users_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `cupon`
--
ALTER TABLE `cupon`
  ADD CONSTRAINT `fk_restaurant_cupon` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_restaurant_food` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_users_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_food_order_items` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_order_order_items` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `fk_company_restaurant` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_company_users` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
