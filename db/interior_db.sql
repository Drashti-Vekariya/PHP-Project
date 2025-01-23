-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 05:24 PM
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
-- Database: `interior_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `content`) VALUES
(1, '<h4>Welcome to INTERIOR - Design can be art!..&nbsp;</h4><p>At INTERIOR, An interior design quotation is a formal document that interior designers send to their client that breaks down each item and its associated cost to complete their client\'s project</p><h4>Our Story:</h4><p>&nbsp;INTERIOR A designer has a duty to create timeless design. To be timeless you have to think really far into the future, not next year, not in two years but in 20 years minimum.</p><h4>Our Mission :</h4><p>Proper spatial planning and furniture arrangement can maximise functionality and usability.</p><p>&nbsp;</p><h4>Our Mission :</h4><p>Proper spatial planning and furniture arrangement can maximise functionality and usability.</p><p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `delivery_address`, `email`) VALUES
(7, 'Priyal<br>Ambika Township<br>nava mava<br>Rajkot-360020<br>gujarat<br>India<br>Mobile: 9725692846<br>Email::pkapadiya266@rku.ac.in', 'pkapadiya266@rku.ac.in'),
(9, 'Drashti<br>Vekariya Nagar<br>Amarnagar Road<br>Jetpur-360370<br>gujarat<br>India<br>Mobile: 7436002729<br>Email::dvekariya408@rku.ac.in', 'dvekariya@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image_url`, `alt_text`, `created_at`) VALUES
(10, 'img/banner13.jpeg', 'Banner', '2024-10-22 03:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `p_id` int(100) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_img` varchar(255) NOT NULL,
  `p_price` int(255) NOT NULL,
  `p_desc` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(100) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`, `c_img`) VALUES
(1, 'Chair', 'chair8.jpg'),
(2, 'Sofa', 'sofa1.jpg'),
(3, 'Table', 'table10.jpg'),
(4, 'Couch', 'couch1.jpg'),
(5, 'Carpet', 'carpet.jpg'),
(6, 'Swing', 'swing6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `subject`, `message`, `created_at`) VALUES
(1, 'Kunjvi', 'PHP', 'For interor design proejct', '2024-10-20 15:59:02'),
(2, 'Priyal', 'Web programming', 'For project ', '2024-10-23 03:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `sub_order_id` varchar(255) NOT NULL,
  `p_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `delivery_status` enum('Ordered','Shipped','Delivered','Return','Replaced') NOT NULL DEFAULT 'Ordered',
  `payment_status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `sub_order_id`, `p_id`, `qty`, `rating`, `review`, `email`, `delivery_address`, `sub_total`, `delivery_status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 'order_1734279778', 'sub_order_1734279778', 1, 1, 5.0, 'Awesome', 'drashtivekariya209@gmail.com', 'Drashti<br>Vekariya Nagar<br>Amarnagar Road<br>Jetpur-360370<br>gujarat<br>India<br>Mobile: 7436002729<br>Email::dvekariya408@rku.ac.in', 5865.00, 'Ordered', 'Pending', '2024-12-15 21:52:58', '2024-12-15 21:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(100) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_img` varchar(255) NOT NULL,
  `p_mrp` int(100) NOT NULL,
  `p_price` int(100) NOT NULL,
  `p_desc` varchar(255) NOT NULL,
  `c_id` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `p_discount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_img`, `p_mrp`, `p_price`, `p_desc`, `c_id`, `qty`, `p_discount`) VALUES
(1, 'WHITE COUCH', 'couch2.jpg', 7500, 2300, 'A sofa is defined as an upholstered bench or seat featuring arms and a back, allowing people to sit comfortably.', 4, 3, 15),
(2, 'FANCY CARPET', 'carpet2.jpg', 2000, 1600, 'A carpet is a textile floor covering typically consisting of an upper layer of pile attached to a backing. ', 5, 1, 2),
(3, 'GREY SOFA', 'sofa3.jpg', 10000, 900, 'This is the most common word used nowadays to describe the comfy piece of furniture we all relax on in the living room.', 2, 0, 30),
(4, 'WOODEN TABLE', 'table6.jpg', 3000, 2500, 'A table is an item of furniture with a raised flat top and is supported most commonly by 1 to 4 legs (although some can have more).', 3, 0, 12),
(5, 'FANCY CHAIR', 'chair11.jpg', 4990, 4999, 'A chair is a type of seat, typically designed for one person and consisting of one or more legs, a flat or slightly angled seat and a back-rest.', 1, 2, 45),
(7, 'WOOVEN  SWING', 'swing5.jpg', 5990, 790, 'swing Add to list Share. To swing is to sway back and forth, or to move in a sweeping, curving motion. ', 6, 4, 5),
(8, 'WHITE SWING', 'swing2.jpg', 3990, 2500, 'To cause to move to and fro, sway, or oscillate, as something suspended from above: to swing one\'s arms in walking', 6, 2, 0),
(9, 'WOODEN SWING', 'swing6.jpg', 6990, 3200, 'Twist each ground stake into the ground alongside each recommended ground board.\r\n\r\nFormulated with new-age, bio-available, non-prescription forms of Vitamin-A. Granactiv', 6, 0, 0),
(10, 'GREY CHAIR', 'chair12.jpg', 1290, 1150, 'Soft seating refers to upholstered furniture or cushioned seating. That\'s why soft seating, including couches, ottomans, and lounge furniture, are included in our vast inventory of fine, functional, and versatile office furniture', 1, 3, 0),
(11, 'WOODEN CHAIR', 'chair10.webp', 4290, 1299, 'It may be made of wood, metal, or synthetic materials, and may be padded or upholstered in various colors and fabrics.', 1, 1, 65),
(12, 'BROWN SOFA', 'sofa5.jpg', 8490, 1450, 'A sofa is a piece of furniture that a few people can comfortably sit on together.', 2, 1, 18),
(13, 'BLUE SOFA', 'sofa4.jpg', 6000, 1700, 'On a rainy weekend, you and your friends might pile on the sofa to watch scary movies and eat popcorn', 2, 2, 0),
(14, 'WHITE TABLE', 'table7.jpg', 2970, 2670, 'Table are the backbone of any living space, serving as platforms for a myriad of activities', 3, 1, 0),
(15, 'BROWN TABLE', 'table8.jpg', 1490, 1340, 'They act as central hubs for dining, gathering, and working, facilitating daily routines while offering a place to display cherished belongings.', 3, 2, 0),
(16, 'FANCY COUCH', 'couch3.jpg', 7000, 1359, 'This is the most common word used nowadays to describe the comfy piece of furniture we all relax on in the living room.\r\n', 4, 1, 20),
(17, 'WHITE FANCY COUCH', 'couch1.jpg', 8990, 1550, 'The word settee or setee comes from the Old English word setl, which was used to describe long benches with high backs and arms, but is now generally used to describe small upholstered seating structures.', 4, 4, 0),
(18, 'BROWN CARPET', 'carpet3.jpg', 1290, 1160, 'Quality carpets use tufts that are constructed from two or three plies of yarn that are tightly twisted together and heat-treated to prevent unraveling. ', 5, 0, 0),
(19, 'CIRCLE CARPET', 'carpet5.jpg', 2990, 2100, 'We bought a new carpet for the bedroom. Which brand of carpet did you choose? The ground was covered by a carpet of leaves.', 5, 1, 29);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `testimonial_id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `testimonial_data` varchar(255) NOT NULL,
  `testimonial_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`testimonial_id`, `name`, `testimonial_data`, `testimonial_img`) VALUES
(1, 'Drashti Vekariya', 'The design team listened to all my preferences and exceeded my expectations with their creativity and expertise. ', 'testimonial-1.jpg'),
(2, 'Priyal Kapadiya', ' They were professional, friendly, knowledgable and helpful throughout and we could not recommend them highly enough.', 'testimonial-2.jpg'),
(3, 'Priyanshi Dobariya', 'A collection of positive client testimonials is a powerful marketing tool for your interior design business.', 'testimonial-3.jpg'),
(4, 'Shreya Vekariya', 'We would like to express our sincerest gratitude for your superb decorating services.', 'testimonial-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `user_id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`user_id`, `name`, `email`, `password`, `user_type`, `profile_picture`, `status`) VALUES
(1, 'Drashti Vekariya', 'drashtivekariya209@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1000036634.png', 'active'),
(2, 'Drashti ', 'dvekariya408@rku.ac.in', 'e10adc3949ba59abbe56e057f20f883e', 'user', '1000036634.png', 'active'),
(3, 'Shruti V', 'fvachhani311@rku.ac.in', 'e10adc3949ba59abbe56e057f20f883e', 'user', '1000036634.png', 'inactive'),
(4, 'Pooja G', 'pgojariya142@rku.ac.in', 'e10adc3949ba59abbe56e057f20f883e', 'user', '1000036634.png', 'inactive'),
(5, 'Priyal Kapadiya', 'priyalkapadiya03@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'user', '1000036634.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `p_id` int(100) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_img` varchar(255) NOT NULL,
  `qty` int(100) NOT NULL,
  `p_price` int(100) NOT NULL,
  `p_desc` varchar(255) NOT NULL,
  `p_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wish_id`, `user_id`, `p_id`, `p_name`, `p_img`, `qty`, `p_price`, `p_desc`, `p_discount`) VALUES
(1, 2, 12, 'BROWN SOFA', 'sofa5.jpg', 0, 5904, 'A sofa is a piece of furniture that a few people can comfortably sit on together.', 18),
(2, 2, 8, 'WHITE SWING', 'swing2.jpg', 0, 3890, 'To cause to move to and fro, sway, or oscillate, as something suspended from above: to swing one\'s arms in walking', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`p_id`);

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_token`
--
ALTER TABLE `password_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `testimonial_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
