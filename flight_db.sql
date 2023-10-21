-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2023 at 05:05 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flight_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines_list`
--

CREATE TABLE `airlines_list` (
  `airline_id` int(255) NOT NULL,
  `airlines` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airlines_list`
--

INSERT INTO `airlines_list` (`airline_id`, `airlines`) VALUES
(1, 'Dhaka Airway'),
(2, 'CTG AIRWAY'),
(3, 'Sadid Airline\'s'),
(4, 'Noakhali Mahfuz'),
(5, 'Feni Sohan');

-- --------------------------------------------------------

--
-- Table structure for table `airport_list`
--

CREATE TABLE `airport_list` (
  `airport_id` int(255) NOT NULL,
  `airport_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airport_list`
--

INSERT INTO `airport_list` (`airport_id`, `airport_name`, `location`) VALUES
(2, 'CTG', 'CTG'),
(3, 'Dhaka', 'Dhaka'),
(4, 'Test', 'Test'),
(5, 'Feni', 'Feni'),
(6, 'Noakhali International Airport (UNA)', 'Noakhali');

-- --------------------------------------------------------

--
-- Table structure for table `booked_flight`
--

CREATE TABLE `booked_flight` (
  `booked_flight_id` int(255) NOT NULL,
  `flight_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `passport` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(255) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(100, 'admin'),
(101, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `flight_list`
--

CREATE TABLE `flight_list` (
  `flight_id` int(255) NOT NULL,
  `airline_id` int(255) NOT NULL,
  `plane_no` varchar(255) NOT NULL,
  `departure_airport_id` int(255) NOT NULL,
  `arrival_airport_id` int(255) NOT NULL,
  `departure_datetime` datetime NOT NULL,
  `arrival_datetime` datetime NOT NULL,
  `seats` int(255) NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flight_list`
--

INSERT INTO `flight_list` (`flight_id`, `airline_id`, `plane_no`, `departure_airport_id`, `arrival_airport_id`, `departure_datetime`, `arrival_datetime`, `seats`, `price`) VALUES
(1, 2, '1012 ', 2, 3, '2023-09-19 20:56:31', '2023-09-20 00:00:00', 50, 100),
(2, 1, '1011', 2, 3, '2023-09-30 18:48:00', '2023-10-01 06:48:00', 10, 100),
(3, 3, '420', 5, 6, '2023-10-05 21:02:00', '2023-10-06 21:03:00', 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `address`, `contact`, `email`, `password`, `department_id`) VALUES
(1, 'Administration', '', '', 'admin@gmail.com', 'admin123', 100),
(2, 'Md. Shakib Shahariar Junayed', '342/6, West Jurain, Khondokar Mahtab Uddin Road, Shympur', '+8801934469404', 'junayed12sents@gmail.com', '1234', 100),
(3, 'test', 'dhaka', '1234567890', 'test@gmail.com', '1234', 101);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines_list`
--
ALTER TABLE `airlines_list`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airport_list`
--
ALTER TABLE `airport_list`
  ADD PRIMARY KEY (`airport_id`);

--
-- Indexes for table `booked_flight`
--
ALTER TABLE `booked_flight`
  ADD PRIMARY KEY (`booked_flight_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `flight_list`
--
ALTER TABLE `flight_list`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `airline_id` (`airline_id`),
  ADD KEY `departure_airport_id` (`departure_airport_id`),
  ADD KEY `arrival_airport_id` (`arrival_airport_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airlines_list`
--
ALTER TABLE `airlines_list`
  MODIFY `airline_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `airport_list`
--
ALTER TABLE `airport_list`
  MODIFY `airport_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booked_flight`
--
ALTER TABLE `booked_flight`
  MODIFY `booked_flight_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight_list`
--
ALTER TABLE `flight_list`
  MODIFY `flight_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_flight`
--
ALTER TABLE `booked_flight`
  ADD CONSTRAINT `booked_flight_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight_list` (`flight_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight_list`
--
ALTER TABLE `flight_list`
  ADD CONSTRAINT `flight_list_ibfk_1` FOREIGN KEY (`airline_id`) REFERENCES `airlines_list` (`airline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flight_list_ibfk_2` FOREIGN KEY (`departure_airport_id`) REFERENCES `airport_list` (`airport_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flight_list_ibfk_3` FOREIGN KEY (`arrival_airport_id`) REFERENCES `airport_list` (`airport_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
