-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 04:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filmfare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `role`) VALUES
(3, 'Cat', 'cat@example.com', '$2y$10$Q.mealuTKyV54RV0jBV6ZOewDu8FS8Rsob2Ci6WbyQSe3NuQTSMgG', 'admin'),
(4, 'Tree', 'Tree@example.com', '$2y$10$o1wgRVxNicJhL/7j3OWj1..yEhGBdxrZ4gFv2pZApYAUAIqNoFnu2', 'admin'),
(5, 'Car', 'car@example.com', '$2y$10$GSfCOehvLDeuAmiwJ4KKDulJOai0Y/kj6Rs9KkO742Qg.vhoEewXK', 'admin'),
(6, 'Fish', 'fish@example.com', '$2y$10$K1AW9XItjfPsURGeIhexP.ZzV3aCsQplsK3rmjACVs0ClJ7htu8XS', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_description` text NOT NULL,
  `movie_image` varchar(255) NOT NULL,
  `movie_price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_name`, `movie_description`, `movie_image`, `movie_price`, `rating`) VALUES
(8, 'Dunkirk', 'Allied soldiers from Belgium, the British Commonwealth and Empire, and France are surrounded by the German Army and evacuated during a fierce battle in World War II. 400,000 soldiers are away from home, so home came to them instead.', 'img/dest/Dunkirk.png', 5000.00, 4.50),
(9, 'All Quiet On The Western Front', 'War breaks out in Germany in 1914. Paul Bäumer and his classmates quickly enlist in the army to serve their fatherland. No sooner are they drafted than the first images from the battlefield show them the reality of war.', 'img/dest/All quiet on the western front.png', 5000.00, 5.00),
(10, '12 Strong', '12 Strong tells the story of the first Special Forces team deployed to Afghanistan after 9/11; under the leadership of a new captain, the team must work with an Afghan warlord to take down the Taliban.', 'img/dest/12 Strong.png', 5000.00, 4.00),
(11, 'Saving Private Ryan', 'Following the Normandy Landings, a group of U.S. soldiers go behind enemy lines to retrieve a paratrooper whose brothers have been killed in action.', 'img/dest/Saving Private Ryan.png', 5000.00, 4.00),
(12, 'Nepoleon', 'An epic that details the chequered rise and fall of French Emperor Napoleon Bonaparte and his relentless journey to power through the prism of his addictive, volatile relationship with his wife, Josephine.', 'img/dest/Nepoleon.png', 5000.00, 5.00),
(13, 'Hacksaw Ridge', 'World War II American Army Medic Desmond T. Doss, serving during the Battle of Okinawa, refuses to kill people and becomes the first man in American history to receive the Medal of Honor without firing a shot.', 'img/dest/Hacksaw Ridge.png', 5000.00, 3.00),
(14, 'Full Metal Jacket', 'A pragmatic U.S. Marine observes the dehumanizing effects the Vietnam War has on his fellow recruits from their brutal boot camp training to the bloody street fighting in Hue.', 'img/dest/Full Metal Jacket.png', 5000.00, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `movie_timings`
--

CREATE TABLE `movie_timings` (
  `timing_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_timings`
--

INSERT INTO `movie_timings` (`timing_id`, `movie_id`, `show_date`, `show_time`) VALUES
(7, 8, '2025-06-03', '17:00:00'),
(8, 8, '2025-06-03', '22:00:00'),
(42, 9, '2024-12-12', '21:00:00'),
(43, 9, '2024-12-13', '21:00:00'),
(44, 10, '2025-09-06', '21:00:00'),
(45, 11, '2025-09-01', '21:00:00'),
(46, 12, '2025-11-05', '21:00:00'),
(47, 13, '2025-02-05', '21:00:00'),
(48, 14, '2025-02-20', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `package_price`) VALUES
(1, 'Basic', 0.00),
(2, 'Premium', 10000.00),
(3, 'VIP', 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `movie_id`, `user_id`, `payment_date`, `payment_amount`, `payment_method`, `payment_status`) VALUES
(14, 14, 8, '2024-10-09 18:49:27', 47500.00, 'card', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `movie_id`, `user_name`, `location`, `rating`, `review`, `created_at`) VALUES
(8, 9, 'Petro Camatose', 'Warsaw', 5, '\"We the unwilling, led by the unqualified to kill the unfortunate, die for the ungrateful.\"', '2024-10-09 12:07:29'),
(9, 9, 'Sidorovich ', 'Belorussia ', 4, 'The true face of the first world war, not close to the book but darn close enough to give the same chills.', '2024-10-09 12:08:52'),
(10, 12, 'Mario ', 'London', 1, 'He was short.', '2024-10-09 13:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `trailers`
--

CREATE TABLE `trailers` (
  `trailer_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trailers`
--

INSERT INTO `trailers` (`trailer_id`, `movie_id`, `trailer_url`) VALUES
(2, 8, 'https://youtu.be/F-eMt3SrfFU?si=lxSB-mxS8rwT_1Nz'),
(3, 9, 'https://youtu.be/hf8EYbVxtCY?si=jrLjRNcpcf3mjbMF'),
(4, 10, 'https://youtu.be/-Denciie5oA?si=il44SfIiilJWqGSL'),
(5, 11, 'https://youtu.be/PrthROm6ocY?si=G12UmEYDerQ_a2EK'),
(6, 12, 'https://youtu.be/OAZWXUkrjPc?si=VNm8n4Ko5FS0tRUB'),
(7, 13, 'https://youtu.be/s2-1hz1juBI?si=MXWYb4I_UNxTOZg2'),
(8, 14, 'https://youtu.be/n2i917l5RFc?si=mP6KxRkA66ZRyKM6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `password_hash`) VALUES
(7, 'Cat', 'cat@example.com', '$2y$10$aoJ/n8SOO5IFFgjuhtQipu8AbTeETxEKPrSr0OKevXjURgFcwQVEy', NULL),
(8, 'Man', 'man@example.com', '$2y$10$R17nsBeJ/zFOmFOChu0x5./vqGGYUOpXo12aNqXi2umlPLKO3B0li', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `movie_timings`
--
ALTER TABLE `movie_timings`
  ADD PRIMARY KEY (`timing_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `trailers`
--
ALTER TABLE `trailers`
  ADD PRIMARY KEY (`trailer_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `movie_timings`
--
ALTER TABLE `movie_timings`
  MODIFY `timing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trailers`
--
ALTER TABLE `trailers`
  MODIFY `trailer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie_timings`
--
ALTER TABLE `movie_timings`
  ADD CONSTRAINT `movie_timings_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `trailers`
--
ALTER TABLE `trailers`
  ADD CONSTRAINT `trailers_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
