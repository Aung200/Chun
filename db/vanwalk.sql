-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 12:24 PM
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
-- Database: `vanwalk`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderid` char(3) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phoneno` varchar(500) NOT NULL,
  `qty` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `ordered_datetime` datetime NOT NULL,
  `Prodid` char(3) DEFAULT NULL,
  `userid` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderid`, `productname`, `price`, `size`, `color`, `address`, `phoneno`, `qty`, `image_path`, `payment_method`, `ordered_datetime`, `Prodid`, `userid`) VALUES
('210', 'Flowy Dress', 45, 'Size: Free', 'pink', '680771', 'qwqw', 1, 'uploads/IMG_4262.JPG', 'paypal', '2024-11-14 18:47:53', '147', '021'),
('567', 'Cargo Pants', 0, 'Size: Free', 'black', '680771', 'qwqw', 1, 'uploads/IMG_4242.JPG', 'paypal', '2024-11-14 18:47:53', '167', '021'),
('687', 'Little Blue Dress', 51, 'Size: Free', 'blue', '680771', 'qwqw', 1, 'uploads/IMG_4264.JPG', 'paypal', '2024-11-14 18:47:53', '193', '021'),
('694', 'Pattern mid skirt', 28, 'Size: Free', 'blue', '680771', 'qwqw', 1, 'uploads/IMG_4248.JPG', 'paypal', '2024-11-14 18:47:53', '753', '021'),
('892', 'High-Waisted Denim Jeans', 47.5, 'Size: Free', 'black', '680771', 'qwqw', 1, 'uploads/IMG_4240.JPG', 'paypal', '2024-11-14 18:47:53', '201', '021'),
('914', 'Delilah Blouse', 22.5, 'Size: Free', 'red', '680771', 'qwqw', 1, 'uploads/IMG_4235.JPG', 'credit-card', '2024-11-14 18:31:42', '398', '540'),
('934', 'Cozy Knit Sweater', 45, 'Size: Free', 'black', '680771', 'qwqw', 1, 'uploads/IMG_4268.JPG', 'paypal', '2024-11-14 18:47:53', '698', '021');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Prodid` char(3) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Price` float NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Description` longtext NOT NULL,
  `qty` int(11) NOT NULL,
  `Discount` float NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Prodid`, `Name`, `Price`, `Type`, `Color`, `Description`, `qty`, `Discount`, `isNew`, `created_datetime`, `image_path`) VALUES
('096', 'Sophia Camilia', 40, 'top', 'white', 'Trendy and fitted, great for layering.', 50, 5, 1, '2024-11-14 16:46:44', 'uploads/IMG_4274.JPG'),
('146', 'Mini pattern skirt', 40, 'bottom', 'black', 'Timeless and versatile, a wardrobe essential.', 12, 20, 1, '2024-11-14 18:05:44', 'uploads/IMG_4247.JPG'),
('147', 'Flowy Dress', 50, 'dress', 'pink', 'Effortlessly elegant, ideal for summer days.', 7, 10, 1, '2024-11-14 18:11:20', 'uploads/IMG_4262.JPG'),
('152', 'Flowy Summer Top', 40, 'top', 'blue', 'Lightweight and breezy, perfect for warm days.', 0, 50, 0, '2024-11-14 17:44:16', 'uploads/IMG_4236.JPG'),
('167', 'Cargo Pants', 40, 'bottom', 'black', 'Functional and fashionable, a modern take on a classic style.', 22, 0, 1, '2024-11-14 18:04:47', 'uploads/IMG_4242.JPG'),
('193', 'Little Blue Dress', 60, 'dress', 'blue', 'A timeless classic, perfect for any occasion.', 29, 15, 1, '2024-11-14 18:10:10', 'uploads/IMG_4264.JPG'),
('201', 'High-Waisted Denim Jeans', 50, 'bottom', 'black', 'Timeless and versatile, a wardrobe essential', 21, 5, 1, '2024-11-14 17:55:07', 'uploads/IMG_4240.JPG'),
('235', 'Branchy Maxi Skirt', 30, 'bottom', 'blue', 'Effortlessly elegant, ideal for any occasion.', 11, 30, 1, '2024-11-14 18:02:52', 'uploads/IMG_4249.JPG'),
('398', 'Delilah Blouse', 25, 'top', 'red', 'Delilah Blouse Breezy and bohemian, perfect for sunny days.', 29, 10, 1, '2024-11-14 16:44:45', 'uploads/IMG_4235.JPG'),
('478', 'Flower Dress', 40, 'dress', 'black', 'Glamorous and dazzling, perfect for a party.', 12, 0, 1, '2024-11-14 18:15:17', 'uploads/IMG_4293.JPG'),
('532', 'Bodycon Dress', 40, 'dress', 'black', 'Sleek and sexy, perfect for a night out.', 12, 0, 0, '2024-11-14 18:13:09', 'uploads/IMG_4292.JPG'),
('698', 'Cozy Knit Sweater', 50, 'top', 'black', 'Soft and warm, ideal for chilly evenings.', 4, 10, 0, '2024-11-14 17:46:07', 'uploads/IMG_4268.JPG'),
('753', 'Pattern mid skirt', 40, 'bottom', 'blue', 'Edgy and chic, a bold fashion statement', 29, 30, 0, '2024-11-14 18:08:14', 'uploads/IMG_4248.JPG'),
('800', 'Classic Button-Down Shirt', 35, 'top', 'pink', 'Versatile and timeless, a wardrobe staple.', 22, 30, 0, '2024-11-14 17:47:25', 'uploads/IMG_4234.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Userid` char(3) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `isadmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Userid`, `Username`, `Password`, `Email`, `isadmin`) VALUES
('021', 'admin', '$2y$10$HBDMWKQmYnJMW.E77PqOYeGISGAbW.VFcttNDqhSY3y.9jzRF4Kd.', 'admin@gmail.com', 1),
('540', 'chun', '$2y$10$e4deVQwvvH1xll5JrxJDiuUfUvuodtqm60njDbdEkjPOCrNhLxdk2', 'chun@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `Prodid` (`Prodid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Prodid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Userid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`Prodid`) REFERENCES `product` (`Prodid`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`Userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
