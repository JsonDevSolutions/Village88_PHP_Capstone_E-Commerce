-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ecommerse_db
CREATE DATABASE IF NOT EXISTS `ecommerse_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ecommerse_db`;

-- Dumping structure for table ecommerse_db.billing_details
CREATE TABLE IF NOT EXISTS `billing_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL,
  `zip_code` int(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_billing_details_users1` (`user_id`),
  CONSTRAINT `fk_billing_details_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.billing_details: ~0 rows (approximately)

-- Dumping structure for table ecommerse_db.cart_items
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_items_products1` (`product_id`),
  KEY `fk_cart_items_users1` (`user_id`),
  CONSTRAINT `fk_cart_items_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_items_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.cart_items: ~0 rows (approximately)

-- Dumping structure for table ecommerse_db.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.categories: ~3 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'T-shirts', '2023-02-18 10:56:44', '2023-02-18 10:56:44'),
	(2, 'Shoes', '2023-02-18 10:56:50', '2023-02-18 10:56:51'),
	(3, 'Shorts', '2023-02-18 13:53:59', '2023-02-18 13:54:00');

-- Dumping structure for table ecommerse_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_items` text DEFAULT NULL,
  `billing_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Order in process','Shipped','Out for Delivery','Cancelled') DEFAULT 'Order in process',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_orders_users1` (`user_id`),
  CONSTRAINT `fk_orders_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.orders: ~5 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `order_items`, `billing_address`, `shipping_address`, `shipping_fee`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
	(13, 7, '{"8":["Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)","5","8.50"],"11":["BSJ0124 - BENCH\\/ Men\'s Active Shorts","3","12.70"]}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Tuburan","address_two":"Poblacion","city":"Malangas","state":"ZSP","zip_code":"7038"}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Tuburan","address_two":"Poblacion","city":"Malangas","state":"ZSP","zip_code":"7038"}', 1.00, 80.60, 'Shipped', '2023-02-21 19:48:30', '2023-02-21 19:48:30'),
	(14, 7, '{"8":["Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)","5","8.50"],"11":["BSJ0124 - BENCH\\/ Men\'s Active Shorts","3","12.70"]}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Malangas","address_two":"Poblacion","city":"Tuburan","state":"ZSP","zip_code":"7038"}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Malangas","address_two":"Poblacion","city":"Tuburan","state":"ZSP","zip_code":"7038"}', 1.00, 80.60, 'Cancelled', '2023-02-21 19:51:21', '2023-02-21 19:51:21'),
	(15, 7, '{"8":["Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)","5","8.50"],"11":["BSJ0124 - BENCH\\/ Men\'s Active Shorts","3","12.70"]}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Tuburan","address_two":"Poblacion","city":"Malangas","state":"ZSP","zip_code":"7038"}', '{"first_name":"Jeasson","last_name":"Seroy","address":"Tuburan","address_two":"Poblacion","city":"Malangas","state":"ZSP","zip_code":"7038"}', 1.00, 80.60, 'Order in process', '2023-02-21 20:02:11', '2023-02-21 20:02:11'),
	(17, 2, '{"8":["Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)",2,"8.50"],"11":["BSJ0124 - BENCH\\/ Men\'s Active Shorts",6,"12.70"],"12":["BSA0030 - BENCH\\/ Active Training Shorts",4,"15.00"]}', '{"first_name":"Fname","last_name":"Lname","address":"Address 1","address_two":"","city":"City 1","state":"sdfdsf","zip_code":"314235"}', '{"first_name":"Fname","last_name":"Lname","address":"Address 1","address_two":"","city":"City 1","state":"sdfdsf","zip_code":"314235"}', 1.00, 153.20, 'Cancelled', '2023-02-21 20:48:26', '2023-02-21 20:48:26'),
	(18, 6, '{"6":["adidas RUNNING X9000L4 HEAT.RDY Shoes FY1209","4","150.90"],"2":["RRJ Ladies\' Basic Tees Regular Fit 17409-U (Blush Pink)","2","4.00"],"8":["Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)","2","8.50"]}', '{"first_name":"Jane","last_name":"Doe","address":"Address New","address_two":"Sample","city":"City Co","state":"State","zip_code":"43543"}', '{"first_name":"Jane","last_name":"Doe","address":"Address New","address_two":"Sample","city":"City Co","state":"State","zip_code":"43543"}', 1.00, 628.60, 'Shipped', '2023-02-21 20:50:09', '2023-02-21 20:50:09');

-- Dumping structure for table ecommerse_db.orderss
CREATE TABLE IF NOT EXISTS `orderss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_address`)),
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shipping_address`)),
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Order in process','Shipped','Out for Delivery','Cancelled') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.orderss: ~0 rows (approximately)

-- Dumping structure for table ecommerse_db.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(45) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_order_details_orders1` (`order_id`),
  KEY `fk_order_details_products1` (`product_id`),
  CONSTRAINT `fk_order_details_orders1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_details_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.order_details: ~0 rows (approximately)

-- Dumping structure for table ecommerse_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `onhand` int(11) DEFAULT 0,
  `sold` int(11) DEFAULT 0,
  `main_image_url` varchar(255) DEFAULT NULL,
  `sub_image_urls` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sub_image_urls`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_products_categories1` (`category_id`),
  CONSTRAINT `fk_products_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.products: ~12 rows (approximately)
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `onhand`, `sold`, `main_image_url`, `sub_image_urls`, `created_at`, `updated_at`) VALUES
	(1, 1, 'RRJ Ladies\' Basic Tees Relaxed Fit 18584-U (Gray-Gray)', 'RRJ Ladies\' Basic Tees Relaxed Fit 18584-U (Gray-Gray)', 4.50, 10, 0, 'assets/img/products/t-shirts/1.jfif', '{"1": "assets/img/products/t-shirts/1.jfif", "2": "assets/img/products/t-shirts/2.jfif", "3": "assets/img/products/t-shirts/3.jfif"}', '2023-02-18 14:14:37', '2023-02-18 14:14:37'),
	(2, 1, 'RRJ Ladies\' Basic Tees Regular Fit 17409-U (Blush Pink)', 'RRJ Ladies\' Basic Tees Regular Fit 17409-U (Blush Pink)', 4.00, 10, 0, 'assets/img/products/t-shirts/4.jfif', '{"1": "assets/img/products/t-shirts/4.jfif", "2": "assets/img/products/t-shirts/5.jfif", "3": "assets/img/products/t-shirts/6.jfif"}', '2023-02-18 14:20:21', '2023-02-18 14:20:21'),
	(3, 1, 'RRJ Ladies Basic Tees Boxy Fit 111664-U (Blue)', 'RRJ Ladies Basic Tees Boxy Fit 111664-U (Blue)', 6.00, 10, 0, 'assets/img/products/t-shirts/7.jfif', '{"1": "assets/img/products/t-shirts/7.jfif", "2": "assets/img/products/t-shirts/8.jfif", "3": "assets/img/products/t-shirts/9.jfif"}', '2023-02-18 14:21:15', '2023-02-18 14:21:15'),
	(4, 2, 'adidas RUNNING Ultraboost 4.0 DNA Shoes FY9121', 'A young legend. The adidas Ultraboost debuted in 2015, and it became a go-to far beyond the realm of running. These shoes have a soft knit upper that offers ventilation where you need it most.', 163.60, 10, 0, 'assets/img/products/shoes/1.jfif', '{"1": "assets/img/products/shoes/1.jfif", "2": "assets/img/products/shoes/2.jfif", "3": "assets/img/products/shoes/3.jfif"}', '2023-02-18 15:09:09', '2023-02-18 15:09:09'),
	(5, 2, 'adidas RUNNING Adizero Pro Shoes FY0101', 'adidas worked with some of the fastest athletes on the planet to create these running shoes.', 172.70, 10, 0, 'assets/img/products/shoes/4.jfif', '{"1": "assets/img/products/shoes/4.jfif", "2": "assets/img/products/shoes/5.jfif", "3": "assets/img/products/shoes/6.jfif"}', '2023-02-18 15:09:37', '2023-02-18 15:09:37'),
	(6, 2, 'adidas RUNNING X9000L4 HEAT.RDY Shoes FY1209', 'In a high-tech world, things move fast. Game plan? These adidas running shoes.', 150.90, 10, 0, 'assets/img/products/shoes/7.jfif', '{"1": "assets/img/products/shoes/7.jfif", "2": "assets/img/products/shoes/8.jfif", "3": "assets/img/products/shoes/9.jfif"}', '2023-02-18 15:10:03', '2023-02-18 15:10:03'),
	(7, 3, 'Ego Twill Tapered Shorts ESB12-0078 (Blue Ashes)', 'Unique and Stylish design, Suitable for any occasion', 8.00, 10, 0, 'assets/img/products/shorts/1.jfif', '{"1": "assets/img/products/shorts/1.jfif", "2": "assets/img/products/shorts/2.jfif", "3": "assets/img/products/shorts/3.jfif"}', '2023-02-18 15:13:26', '2023-02-18 15:13:26'),
	(8, 3, 'Ego Twill Tapered Shorts ESB12-0077 (Turkish Coffee)', 'Unique and Stylish design, Suitable for any occasion, Fashion and Comfortable to Wear', 8.50, 10, 0, 'assets/img/products/shorts/4.jfif', '{"1": "assets/img/products/shorts/4.jfif", "2": "assets/img/products/shorts/5.jfif", "3": "assets/img/products/shorts/6.jfif"}', '2023-02-18 15:15:54', '2023-02-18 15:15:54'),
	(9, 3, 'Petrol Men\'s Basic Non Denim Chino Shorts 13632-U ( NAVY )', 'Petrol Men\'s Basic Non Denim Chino Shorts 13632-U ( NAVY )', 9.00, 10, 0, 'assets/img/products/shorts/7.jfif', '{"1": "assets/img/products/shorts/7.jfif", "2": "assets/img/products/shorts/8.jfif", "3": "assets/img/products/shorts/9.jfif"}', '2023-02-18 15:17:49', '2023-02-18 15:17:49'),
	(10, 2, '361 Degrees Overseas International Line CENTAURI Sports Shoes', 'Applicable to short and medium distances of 3-10km in a single trip', 127.80, 11, 0, 'assets/img/products/shoes/10.jfif', '{"1": "assets/img/products/shoes/10.jfif", "2": "assets/img/products/shoes/11.jfif", "3": "assets/img/products/shoes/12.jfif"}', '2023-02-18 16:09:33', '2023-02-18 16:09:33'),
	(11, 3, 'BSJ0124 - BENCH/ Men\'s Active Shorts', 'BSJ0124 - BENCH/ Men\'s Active Shorts', 12.70, 12, 0, 'assets/img/products/shorts/10.jfif', '{"1": "assets/img/products/shorts/10.jfif", "2": "assets/img/products/shorts/11.jfif", "3": "assets/img/products/shorts/12.jfif"}', '2023-02-18 16:14:32', '2023-02-18 16:14:32'),
	(12, 3, 'BSA0030 - BENCH/ Active Training Shorts', 'BSA0030 - BENCH/ Active Training Shorts', 15.00, 13, 0, 'assets/img/products/shorts/13.jfif', '{"1": "assets/img/products/shorts/13.jfif", "2": "assets/img/products/shorts/14.jfif", "3": "assets/img/products/shorts/15.jfif"}', '2023-02-18 16:17:19', '2023-02-18 16:17:19');

-- Dumping structure for table ecommerse_db.shipping_details
CREATE TABLE IF NOT EXISTS `shipping_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL,
  `zip_code` int(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shipping_details_users1` (`user_id`),
  CONSTRAINT `fk_shipping_details_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.shipping_details: ~0 rows (approximately)

-- Dumping structure for table ecommerse_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(11) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `is_admin` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table ecommerse_db.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `password`, `salt`, `is_admin`, `created_at`, `updated_at`) VALUES
	(2, 'Guest', 'Guest', 'guest@gmail.com', '09222222222', '', '', 0, '2023-02-21 20:47:58', '2023-02-21 20:47:59'),
	(5, 'Jeasson', 'Seroy', 'jeassonseroy4@gmail.com', '09273932807', '82835c6a4b1ab1101e9b55218eb0ebfa', '8352921b29074ae2a1da624e8083813f9ec8bb21ee33', 1, '2023-02-21 02:48:43', '2023-02-21 02:48:43'),
	(6, 'Jane', 'Doe', 'janedoe@email.com', '09999999999', '5dce44c42c9930a94135d6184556c13f', 'e26b774af8b5d1aec587522c92e63513610ca39adbb7', 0, '2023-02-21 02:49:33', '2023-02-21 02:49:33'),
	(7, 'Mark', 'Doe', 'markdoe@gmail.com', '09273932808', '6f38905900e710247cd0240c2cbc6ea1', 'a7a46d040a760fc807f348f314c0ceb03b60108d5dd5', 0, '2023-02-21 03:33:26', '2023-02-21 03:33:26');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
