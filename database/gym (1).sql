-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 02:43 AM
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
-- Database: `gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adname` varchar(60) NOT NULL,
  `adpass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adname`, `adpass`) VALUES
('admin', 0),
('admin', 0),
('admin1', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `planid` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `plan_validity` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`planid`, `plan_name`, `schedule`, `amount`, `plan_validity`, `description`, `trainer_id`, `archived`) VALUES
(1, 'Fitness Classes', 'Monday: 10:00am-11:30am & Tuesday: 2:00pm-3:30pm', 459.00, '1 Month', 'Get fit and healthy with our fitness class, designed for all levels.', 1, 0),
(2, 'Muscle Training', 'Friday: 10:00am-11:30am & Thursday: 2:00pm-3:30pm', 599.00, '1 Month', 'Build strength and muscle with our expert trainers.', 2, 0),
(3, 'Body Building', 'Tuesday: 10:00am-11:30am & Monday: 2:00pm-3:30pm', 499.00, '1 Month', 'Transform your body with our body building program, tailored to your goals.', 3, 0),
(4, 'Yoga Training Class', 'Wednesday: 10:00am-11:30am & Friday: 2:00pm-3:30pm', 599.00, '1 Month', 'Find balance and harmony with our yoga training class, suitable for all levels.', 4, 0),
(5, 'Advanced Training', 'Thursday: 10:00am-11:30am & Wednesday: 2:00pm-3:30pm', 749.00, '1 Month', 'Take your fitness to the next level with our advanced training program, designed for experienced athletes.', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `user_id`, `plan_id`, `purchase_date`, `purchase_amount`, `payment_method`, `plan_start_date`, `plan_end_date`) VALUES
(6665, 13, 3, '2024-06-09 17:36:23', 998.00, 'Cash', '2024-06-09', '2024-08-09'),
(6666, 18, 1, '2024-06-10 14:41:46', 918.00, 'Cash', '2024-06-10', '2024-08-10'),
(666670, 17, 3, '2024-06-10 05:19:05', 1497.00, 'Cash', '2024-06-10', '2024-09-10'),
(6665905, 12, 1, '2024-06-09 13:22:07', 918.00, 'Credit Card', '2024-06-09', '2024-08-09'),
(6666710, 17, 1, '2024-06-10 05:20:45', 1377.00, 'Cash', '2024-06-10', '2024-09-10'),
(6666726, 17, 3, '2024-06-10 05:26:37', 998.00, 'Debit Card', '2024-06-10', '2024-08-10'),
(66667039, 17, 3, '2024-06-10 05:17:13', 1996.00, 'Cash', '2024-06-10', '2024-10-10'),
(666591224, 12, 5, '2024-06-09 13:25:22', 749.00, 'Credit Card', '2024-06-09', '2024-07-09'),
(666666973, 17, 2, '2024-06-10 04:36:07', 1198.00, 'Cash', '2024-06-10', '2024-08-10');

--
-- Triggers `purchases`
--
DELIMITER $$
CREATE TRIGGER `update_user_plan` AFTER INSERT ON `purchases` FOR EACH ROW BEGIN
  UPDATE users
  SET user_plan_status = 'active'
  WHERE id = NEW.user_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `certification` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `rate`, `email`, `phone`, `certification`, `specialization`, `archived`) VALUES
(1, 'William G. Stewart', 55.00, 'willstewart@gmail.com', '123-456-7890', 'Certified Nutritionist', 'Fitness Training', 0),
(2, 'Paul D. Newman', 40.00, 'paulnewman@gmail.com', '098-765-4321', 'ACE Certified Personal Trainer', 'Muscle Training', 0),
(3, 'Boyd C. Harris', 60.00, 'boydharris@gmail.com', '555-123-4567', 'NSCA Certified Strength and Conditioning Specialist', 'Body Building', 0),
(4, 'Hector T. Daigle', 45.00, 'hectordaigle@gmail.com', '789-012-3456', 'Yoga Alliance RYT 200', 'Yoga Training', 0),
(5, 'Bret D. Bowers', 55.00, 'bretbowers@gmail.com', '901-234-5678', 'ACE Certified Group Fitness Instructor', 'Advanced Training', 0),
(6, 'William G. Stewart/', 45.00, 'willstewart2@gmail.com', '123', 'Fafafafa', 'Mammamam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` int(11) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `planid` int(11) DEFAULT NULL,
  `user_plan_status` varchar(60) NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `email`, `phone`, `pass`, `planid`, `user_plan_status`, `archived`) VALUES
(12, 'Dave', 'dave@gmail.com', 2147483647, '$2y$10$vm/LegvX3KEd1oxNpAy8X.zhZE4piLMt22nGgcumzRdUzXXuYnYkO', 1, 'active', 0),
(13, 'Haro', 'haro@gmail.com', 2147483647, '$2y$10$XbRYR8HsPJ0/WaWfW6I4UuWHl8cVdoD9R3PdbWxJuQQxjxNoXBvxK', 4, 'active', 0),
(16, 'Harold', 'harold@gmail.com', 2147483647, '$2y$10$emGOvaJv2WacmV9OnrQjN.WgavtYjttjdORz/Af9PZhDYFYkZKPWu', 5, '', 0),
(17, 'Nicko Mercado', 'nickomercado03@gmail.com', 2147483647, '$2y$10$sqWqxnQxRe5Z3VLR8ALOM.6XJ0N/hPG8ANrfQ.aNo7vSJROx1HtmG', NULL, 'active', 0),
(18, 'Terence', 'terence@gmail.com', 2147483647, '$2y$10$85G0pS4XJsfs3SnhWTtmweuOfmiw1jfdhZXetS6VpP7CBfdLn8U/W', NULL, 'active', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`planid`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planid` (`planid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`planid`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`planid`) REFERENCES `plans` (`planid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
