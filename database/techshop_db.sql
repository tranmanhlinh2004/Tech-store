-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 28, 2026 lúc 09:37 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `techshop_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `link`, `position`, `sort_order`, `status`, `created_at`) VALUES
(1, 'Summer Laptop Sale', 'template/images/slider/slide-1.jpg', '/shop?category=laptop', 'home_slider', 1, 1, '2026-05-04 01:00:00'),
(2, 'Smartphone Week', 'template/images/slider/slide-2.jpg', '/shop?category=smartphone', 'home_slider', 2, 1, '2026-05-04 01:02:00'),
(3, 'Gaming Gear Deals', 'template/images/slider/slide-3.jpg', '/shop?category=gaming', 'home_slider', 3, 1, '2026-05-04 01:04:00'),
(4, 'Audio Festival', 'template/images/slider/slide-4.jpg', '/shop?category=audio', 'home_slider', 4, 1, '2026-05-04 01:06:00'),
(5, 'Monitor Upgrade', 'template/images/slider/slide-5.jpg', '/shop?category=monitor', 'home_slider', 5, 1, '2026-05-04 01:08:00'),
(6, 'Wi-Fi 6 Router Promo', 'template/images/slider/slide-6.jpg', '/shop?category=router', 'home_slider', 6, 1, '2026-05-04 01:10:00'),
(7, 'Smart Home Essentials', 'template/images/slider/slide-7.jpg', '/shop?category=smart-home', 'home_slider', 7, 1, '2026-05-04 01:12:00'),
(8, 'Apple Collection', 'template/images/slider/slide-8.jpg', '/shop?brand=apple', 'home_slider', 8, 1, '2026-05-04 01:14:00'),
(9, 'Samsung Collection', 'template/images/slider/slide-9.jpg', '/shop?brand=samsung', 'home_slider', 9, 1, '2026-05-04 01:16:00'),
(10, 'Accessory Combo', 'template/images/promo/promo-img-1.jpg', '/shop?category=accessory', 'home_promo', 1, 1, '2026-05-04 01:18:00'),
(11, 'Keyboard and Mouse', 'template/images/promo/promo-img-2.jpg', '/shop?category=keyboard', 'home_promo', 2, 1, '2026-05-04 01:20:00'),
(12, 'Storage Upgrade', 'template/images/promo/promo-img-3.jpg', '/shop?category=ssd-and-ram', 'home_promo', 3, 1, '2026-05-04 01:22:00'),
(13, 'Power Bank Deal', 'template/images/promo/promo-img-4.jpg', '/shop?brand=anker', 'home_promo', 4, 1, '2026-05-04 01:24:00'),
(14, 'Office Setup', 'template/images/promo/promo-img-5.jpg', '/shop?tag=office', 'home_promo', 5, 1, '2026-05-04 01:26:00'),
(15, 'Student Combo', 'template/images/promo/promo-img-6.jpg', '/shop?tag=student', 'home_promo', 6, 1, '2026-05-04 01:28:00'),
(16, 'Mega Menu Laptop', 'template/images/banners/banner-mega-0.jpg', '/shop?category=laptop', 'mega_menu', 1, 1, '2026-05-04 01:30:00'),
(17, 'Mega Menu Phone', 'template/images/banners/banner-mega-1.jpg', '/shop?category=smartphone', 'mega_menu', 2, 1, '2026-05-04 01:32:00'),
(18, 'Mega Menu Audio', 'template/images/banners/banner-mega-2.jpg', '/shop?category=audio', 'mega_menu', 3, 1, '2026-05-04 01:34:00'),
(19, 'Mega Menu Network', 'template/images/banners/banner-mega-3.jpg', '/shop?category=network', 'mega_menu', 4, 1, '2026-05-04 01:36:00'),
(20, 'Footer Campaign', 'template/images/banners/banner-bg.jpg', '/shop', 'footer', 1, 1, '2026-05-04 01:38:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'apple', 'template/images/brand/b1.png', 'Premium phones, laptops and accessories.', 1, '2026-05-02 01:00:00', '2026-05-02 01:00:00'),
(2, 'Samsung', 'samsung', 'template/images/brand/b2.png', 'Phones, tablets, monitors and smart devices.', 1, '2026-05-02 01:02:00', '2026-05-02 01:02:00'),
(3, 'Dell', 'dell', 'template/images/brand/b3.png', 'Business laptops, desktops and monitors.', 1, '2026-05-02 01:04:00', '2026-05-02 01:04:00'),
(4, 'Asus', 'asus', 'template/images/brand/b4.png', 'Gaming laptops, motherboards and peripherals.', 1, '2026-05-02 01:06:00', '2026-05-02 01:06:00'),
(5, 'Acer', 'acer', 'template/images/brand/b5.png', 'Affordable laptops, monitors and gaming products.', 1, '2026-05-02 01:08:00', '2026-05-02 01:08:00'),
(6, 'HP', 'hp', 'template/images/brand/b6.png', 'Office laptops, printers and workstations.', 1, '2026-05-02 01:10:00', '2026-05-02 01:10:00'),
(7, 'Lenovo', 'lenovo', 'template/images/brand/b1.png', 'ThinkPad, IdeaPad and Legion devices.', 1, '2026-05-02 01:12:00', '2026-05-02 01:12:00'),
(8, 'MSI', 'msi', 'template/images/brand/b2.png', 'Gaming laptops and computer components.', 1, '2026-05-02 01:14:00', '2026-05-02 01:14:00'),
(9, 'LG', 'lg', 'template/images/brand/b3.png', 'Monitors, audio and smart home products.', 1, '2026-05-02 01:16:00', '2026-05-02 01:16:00'),
(10, 'Sony', 'sony', 'template/images/brand/b4.png', 'Audio, cameras and entertainment devices.', 1, '2026-05-02 01:18:00', '2026-05-02 01:18:00'),
(11, 'Logitech', 'logitech', 'template/images/brand/b5.png', 'Keyboards, mice, webcams and gaming gear.', 1, '2026-05-02 01:20:00', '2026-05-02 01:20:00'),
(12, 'Razer', 'razer', 'template/images/brand/b6.png', 'Gaming peripherals and laptops.', 1, '2026-05-02 01:22:00', '2026-05-02 01:22:00'),
(13, 'Kingston', 'kingston', 'template/images/brand/b1.png', 'Memory, SSD and storage solutions.', 1, '2026-05-02 01:24:00', '2026-05-02 01:24:00'),
(14, 'Corsair', 'corsair', 'template/images/brand/b2.png', 'PC components and gaming accessories.', 1, '2026-05-02 01:26:00', '2026-05-02 01:26:00'),
(15, 'Xiaomi', 'xiaomi', 'template/images/brand/b3.png', 'Phones and smart home products.', 1, '2026-05-02 01:28:00', '2026-05-02 01:28:00'),
(16, 'Oppo', 'oppo', 'template/images/brand/b4.png', 'Smartphones and mobile accessories.', 1, '2026-05-02 01:30:00', '2026-05-02 01:30:00'),
(17, 'Anker', 'anker', 'template/images/brand/b5.png', 'Chargers, cables and power banks.', 1, '2026-05-02 01:32:00', '2026-05-02 01:32:00'),
(18, 'JBL', 'jbl', 'template/images/brand/b6.png', 'Speakers, headphones and audio products.', 1, '2026-05-02 01:34:00', '2026-05-02 01:34:00'),
(19, 'TP-Link', 'tp-link', 'template/images/brand/b1.png', 'Routers and network devices.', 1, '2026-05-02 01:36:00', '2026-05-02 01:36:00'),
(20, 'Gigabyte', 'gigabyte', 'template/images/brand/b2.png', 'Motherboards, GPUs and gaming monitors.', 1, '2026-05-02 01:38:00', '2026-05-02 01:38:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `status` enum('active','converted','abandoned') DEFAULT 'active',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'active', NULL, '2026-05-05 01:00:00', '2026-05-05 01:00:00'),
(2, 2, NULL, 'active', NULL, '2026-05-05 01:02:00', '2026-05-05 01:02:00'),
(3, 3, NULL, 'active', NULL, '2026-05-05 01:04:00', '2026-05-05 01:04:00'),
(4, 4, NULL, 'converted', 'Converted to order #ORD2026052221023342', '2026-05-05 01:06:00', '2026-05-22 14:02:33'),
(5, 5, NULL, 'active', NULL, '2026-05-05 01:08:00', '2026-05-05 01:08:00'),
(6, 6, NULL, 'active', NULL, '2026-05-05 01:10:00', '2026-05-05 01:10:00'),
(7, 7, NULL, 'active', NULL, '2026-05-05 01:12:00', '2026-05-05 01:12:00'),
(8, 8, NULL, 'active', NULL, '2026-05-05 01:14:00', '2026-05-05 01:14:00'),
(9, 9, NULL, 'active', NULL, '2026-05-05 01:16:00', '2026-05-05 01:16:00'),
(10, 10, NULL, 'active', NULL, '2026-05-05 01:18:00', '2026-05-05 01:18:00'),
(11, 11, NULL, 'active', NULL, '2026-05-05 01:20:00', '2026-05-05 01:20:00'),
(12, 12, NULL, 'active', NULL, '2026-05-05 01:22:00', '2026-05-05 01:22:00'),
(13, 13, NULL, 'active', NULL, '2026-05-05 01:24:00', '2026-05-05 01:24:00'),
(14, 14, NULL, 'active', NULL, '2026-05-05 01:26:00', '2026-05-05 01:26:00'),
(15, 15, NULL, 'active', NULL, '2026-05-05 01:28:00', '2026-05-05 01:28:00'),
(16, 16, NULL, 'active', NULL, '2026-05-05 01:30:00', '2026-05-05 01:30:00'),
(17, 17, NULL, 'active', NULL, '2026-05-05 01:32:00', '2026-05-05 01:32:00'),
(18, 18, NULL, 'active', NULL, '2026-05-05 01:34:00', '2026-05-05 01:34:00'),
(19, 19, NULL, 'active', NULL, '2026-05-05 01:36:00', '2026-05-05 01:36:00'),
(20, 20, NULL, 'active', NULL, '2026-05-05 01:38:00', '2026-05-05 01:38:00'),
(21, 21, NULL, 'active', NULL, '2026-05-05 01:40:00', '2026-05-05 01:40:00'),
(22, 22, NULL, 'active', NULL, '2026-05-05 01:42:00', '2026-05-05 01:42:00'),
(23, 23, NULL, 'active', NULL, '2026-05-05 01:44:00', '2026-05-05 01:44:00'),
(24, 24, NULL, 'active', NULL, '2026-05-05 01:46:00', '2026-05-05 01:46:00'),
(25, 25, NULL, 'active', NULL, '2026-05-05 01:48:00', '2026-05-05 01:48:00'),
(26, 26, NULL, 'active', NULL, '2026-05-05 01:50:00', '2026-05-05 01:50:00'),
(27, 27, NULL, 'active', NULL, '2026-05-05 01:52:00', '2026-05-05 01:52:00'),
(28, 28, NULL, 'active', NULL, '2026-05-05 01:54:00', '2026-05-05 01:54:00'),
(29, 29, NULL, 'active', NULL, '2026-05-05 01:56:00', '2026-05-05 01:56:00'),
(30, 30, NULL, 'active', NULL, '2026-05-05 01:58:00', '2026-05-05 01:58:00'),
(31, 32, NULL, 'active', NULL, '2026-05-21 06:19:10', '2026-05-22 15:21:02'),
(32, 33, NULL, 'active', NULL, '2026-05-22 13:51:59', '2026-05-22 14:06:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_variant_id` int(11) DEFAULT NULL,
  `selected_color` varchar(50) DEFAULT NULL,
  `selected_size` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `product_variant_id`, `selected_color`, `selected_size`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Black', '256GB', 1, 27490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(2, 2, 6, 11, 'Titanium', '13 inch', 1, 27990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(3, 3, 19, 37, 'Blue', NULL, 2, 2590000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(4, 4, 15, 29, 'Graphite', NULL, 1, 5890000.00, '2026-05-17 19:42:38', '2026-05-21 06:56:30'),
(5, 4, 34, 67, 'Silver', NULL, 2, 790000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(6, 5, 3, 5, 'Blue', NULL, 1, 26490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(7, 5, 30, 59, 'Titanium', NULL, 1, 1990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(8, 6, 10, 19, 'Silver', NULL, 1, 17490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(9, 6, 36, 71, 'White', NULL, 1, 690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(10, 7, 21, 41, 'Gray', NULL, 1, 3190000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(11, 7, 20, 39, 'White', NULL, 1, 3490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(12, 8, 23, 45, 'Graphite', NULL, 1, 6990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(13, 8, 26, 51, 'Silver', '1TB', 2, 1390000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(14, 9, 33, 65, 'Black', NULL, 1, 3290000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(15, 9, 17, 33, 'Black', NULL, 1, 2990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(16, 10, 2, 3, 'Silver', '128GB', 1, 20990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(17, 10, 15, 29, 'Graphite', NULL, 1, 5890000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(18, 11, 8, 15, 'Red', NULL, 1, 25990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(19, 11, 22, 43, 'Titanium', NULL, 1, 1490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(20, 12, 31, 61, 'Graphite', NULL, 1, 4190000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(21, 12, 32, 63, 'Red', NULL, 2, 990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(22, 13, 4, 7, 'White', NULL, 1, 15990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(23, 13, 38, 75, 'Titanium', NULL, 1, 2190000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(24, 14, 25, 49, 'Black', NULL, 1, 12490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(25, 14, 37, 73, 'Gray', NULL, 1, 590000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(26, 15, 7, 13, 'Graphite', NULL, 1, 32990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(27, 15, 28, 55, 'White', NULL, 1, 8490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(28, 16, 13, 25, 'Gray', '11 inch', 1, 17990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(29, 16, 34, 67, 'Silver', NULL, 1, 790000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(30, 17, 16, 31, 'Red', NULL, 1, 7990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(31, 17, 35, 69, 'Blue', NULL, 1, 2990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(32, 18, 24, 47, 'Red', NULL, 1, 5990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(33, 18, 40, 79, 'Red', NULL, 1, 2690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(34, 19, 39, 77, 'Graphite', NULL, 1, 39990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(35, 19, 18, 35, 'Silver', NULL, 1, 690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(36, 20, 5, 9, 'Gray', NULL, 1, 8190000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(37, 20, 30, 59, 'Titanium', NULL, 1, 1990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(38, 21, 11, 21, 'Blue', NULL, 1, 15490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(39, 21, 19, 37, 'Blue', NULL, 1, 2590000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(40, 22, 12, 23, 'White', NULL, 1, 14990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(41, 22, 27, 53, 'Blue', '16GB', 2, 1490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(42, 23, 14, 27, 'Titanium', NULL, 1, 9990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(43, 23, 33, 65, 'Black', NULL, 1, 3290000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(44, 24, 29, 57, 'Gray', NULL, 1, 4390000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(45, 24, 40, 79, 'Red', NULL, 1, 2690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(46, 25, 9, 17, 'Black', NULL, 1, 31990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(47, 25, 37, 73, 'Gray', NULL, 1, 590000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(48, 26, 30, 59, 'Titanium', NULL, 2, 1990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(49, 26, 32, 63, 'Red', NULL, 1, 990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(50, 27, 17, 33, 'Black', NULL, 1, 2990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(51, 27, 38, 75, 'Titanium', NULL, 1, 2190000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(52, 28, 26, 51, 'Silver', '1TB', 3, 1390000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(53, 28, 27, 53, 'Blue', '16GB', 2, 1490000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(54, 29, 6, 11, 'Titanium', '13 inch', 1, 27990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(55, 29, 34, 67, 'Silver', NULL, 2, 790000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(56, 30, 36, 71, 'White', NULL, 1, 690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(57, 30, 37, 73, 'Gray', NULL, 1, 590000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(58, 30, 18, 35, 'Silver', NULL, 1, 690000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(59, 4, 16, 31, 'Red', NULL, 1, 7990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38'),
(60, 8, 35, 69, 'Blue', NULL, 1, 2990000.00, '2026-05-17 19:42:38', '2026-05-17 19:42:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laptop', 'laptop', 'Laptop for office, gaming and study.', 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 1, '2026-05-02 02:00:00', '2026-05-22 16:52:22'),
(2, NULL, 'Smartphone', 'smartphone', 'Phones and mobile devices.', 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 1, '2026-05-02 02:02:00', '2026-05-22 16:52:22'),
(3, NULL, 'Tablet', 'tablet', 'Tablets and stylus devices.', 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 1, '2026-05-02 02:04:00', '2026-05-22 16:52:22'),
(4, NULL, 'Audio', 'audio', 'Headphones, speakers and microphones.', 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 1, '2026-05-02 02:06:00', '2026-05-22 16:52:22'),
(5, NULL, 'Keyboard', 'keyboard', 'Office and mechanical keyboards.', 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 1, '2026-05-02 02:08:00', '2026-05-22 16:52:22'),
(6, NULL, 'Mouse', 'mouse', 'Office and gaming mouse products.', 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 1, '2026-05-02 02:10:00', '2026-05-22 16:52:22'),
(7, NULL, 'Monitor', 'monitor', 'Monitors for work and gaming.', 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 1, '2026-05-02 02:12:00', '2026-05-22 16:52:22'),
(8, NULL, 'PC Components', 'pc-components', 'RAM, SSD, CPU, GPU and cases.', 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 1, '2026-05-02 02:14:00', '2026-05-22 16:52:22'),
(9, NULL, 'Network', 'network', 'Routers, switches and adapters.', 'template/images/product/router/tp-link-archer-ax55.jpg', 1, '2026-05-02 02:16:00', '2026-05-22 16:52:22'),
(10, NULL, 'Smart Home', 'smart-home', 'Smart cameras, sensors and home devices.', 'template/images/product/smart-home/anker-737-power-bank.jpg', 1, '2026-05-02 02:18:00', '2026-05-22 16:52:22'),
(11, 1, 'Gaming Laptop', 'gaming-laptop', 'High performance laptops for gaming.', 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 1, '2026-05-02 02:20:00', '2026-05-22 16:52:22'),
(12, 1, 'Ultrabook', 'ultrabook', 'Thin and light laptops.', 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 1, '2026-05-02 02:22:00', '2026-05-22 16:52:22'),
(13, 2, 'Android Phone', 'android-phone', 'Android smartphones.', 'template/images/product/android-phone/xiaomi-14-5g.jpg', 1, '2026-05-02 02:24:00', '2026-05-22 16:52:22'),
(14, 2, 'iPhone', 'iphone', 'Apple iPhone models.', 'template/images/product/iphone/iphone-15-pro-256gb.webp', 1, '2026-05-02 02:26:00', '2026-05-22 16:52:22'),
(15, 4, 'Bluetooth Headphone', 'bluetooth-headphone', 'Wireless headphones and earbuds.', 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 1, '2026-05-02 02:28:00', '2026-05-22 16:52:22'),
(16, 4, 'Speaker', 'speaker', 'Portable and desktop speakers.', 'template/images/product/speaker/jbl-charge-5.jpg', 1, '2026-05-02 02:30:00', '2026-05-22 16:52:22'),
(17, 5, 'Mechanical Keyboard', 'mechanical-keyboard', 'Mechanical keyboards for gaming and work.', 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 1, '2026-05-02 02:32:00', '2026-05-22 16:52:22'),
(18, 6, 'Gaming Mouse', 'gaming-mouse', 'High DPI gaming mice.', 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg', 1, '2026-05-02 02:34:00', '2026-05-22 16:52:22'),
(19, 8, 'SSD and RAM', 'ssd-and-ram', 'Storage and memory upgrade parts.', 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 1, '2026-05-02 02:36:00', '2026-05-22 16:52:22'),
(20, 9, 'Router', 'router', 'Wi-Fi routers and mesh systems.', 'template/images/product/router/tp-link-deco-x20-2-pack.jpg', 1, '2026-05-02 02:38:00', '2026-05-22 16:52:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Nguyen Minh Anh', 'minhanh@example.com', '0901000004', 'Order support', 'I want to update my delivery time.', 1, '2026-05-10 01:00:00'),
(2, 'Tran Hoang Nam', 'hoangnam@example.com', '0901000005', 'Warranty question', 'Does the phone include official warranty?', 1, '2026-05-10 01:10:00'),
(3, 'Le Thu Ha', 'thuha@example.com', '0901000006', 'Laptop advice', 'Please recommend a laptop for accounting work.', 0, '2026-05-10 01:20:00'),
(4, 'Pham Quang Huy', 'quanghuy@example.com', '0901000007', 'Payment issue', 'My online payment is pending.', 0, '2026-05-10 01:30:00'),
(5, 'Do Bao Ngoc', 'baongoc@example.com', '0901000008', 'Product stock', 'Is the Dell monitor still available?', 1, '2026-05-10 01:40:00'),
(6, 'Hoang Gia Bao', 'giabao@example.com', '0901000009', 'Promotion', 'Can I combine two coupons?', 1, '2026-05-10 01:50:00'),
(7, 'Bui Lan Chi', 'lanchi@example.com', '0901000010', 'Delivery address', 'I need to change my delivery address.', 0, '2026-05-10 02:00:00'),
(8, 'Dang Tuan Kiet', 'tuankiet@example.com', '0901000011', 'Invoice', 'Please issue a VAT invoice.', 1, '2026-05-10 02:10:00'),
(9, 'Vu Phuong Linh', 'phuonglinh@example.com', '0901000012', 'Return request', 'I want to check the return policy.', 0, '2026-05-10 02:20:00'),
(10, 'Dinh Khanh Vy', 'khanhvy@example.com', '0901000013', 'Product comparison', 'Please compare Xiaomi 14 and Galaxy S24.', 1, '2026-05-10 02:30:00'),
(11, 'Cao Minh Quan', 'minhquan@example.com', '0901000014', 'Installment', 'Do you support installment payment?', 0, '2026-05-10 02:40:00'),
(12, 'Mai Anh Duc', 'anhduc@example.com', '0901000015', 'Gaming PC build', 'Please suggest a PC build under 25 million.', 0, '2026-05-10 02:50:00'),
(13, 'Ly Thanh Tam', 'thanhtam@example.com', '0901000016', 'Headphone advice', 'I need ANC headphones for travel.', 1, '2026-05-10 03:00:00'),
(14, 'Truong Nhat Minh', 'nhatminh@example.com', '0901000017', 'Router setup', 'Can your staff help set up the router?', 0, '2026-05-10 03:10:00'),
(15, 'Ha Ngoc Diep', 'ngocdiep@example.com', '0901000018', 'Cancelled order', 'When will my refund arrive?', 1, '2026-05-10 03:20:00'),
(16, 'Vo Quoc Bao', 'quocbao@example.com', '0901000019', 'Stock alert', 'Notify me when Legion 5 Pro is restocked.', 0, '2026-05-10 03:30:00'),
(17, 'Nguyen Hai Yen', 'haiyen@example.com', '0901000020', 'Coupon support', 'My coupon code does not work.', 0, '2026-05-10 03:40:00'),
(18, 'Product Manager User', 'product.manager@techshop.test', '0901000028', 'Supplier contact', 'Please update supplier contact information.', 1, '2026-05-10 03:50:00'),
(19, 'Order Manager User', 'order.manager@techshop.test', '0901000029', 'Order status', 'Need report for pending orders.', 1, '2026-05-10 04:00:00'),
(20, 'Guest Customer', 'guest@example.com', '0901999999', 'General question', 'What are your store opening hours?', 0, '2026-05-10 04:10:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(15,2) NOT NULL,
  `min_order_value` decimal(15,2) DEFAULT 0.00,
  `max_discount_amount` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `used_count` int(11) DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `name`, `discount_type`, `discount_value`, `min_order_value`, `max_discount_amount`, `quantity`, `used_count`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'WELCOME10', 'Welcome 10 percent', 'percentage', 10.00, 500000.00, 300000.00, 300, 25, '2026-05-01', '2026-06-30', 1, '2026-05-04 02:00:00'),
(2, 'LAPTOP500', 'Laptop discount 500k', 'fixed', 500000.00, 15000000.00, NULL, 100, 10, '2026-05-01', '2026-06-30', 1, '2026-05-04 02:02:00'),
(3, 'PHONE300', 'Phone discount 300k', 'fixed', 300000.00, 8000000.00, NULL, 150, 20, '2026-05-01', '2026-06-30', 1, '2026-05-04 02:04:00'),
(4, 'AUDIO15', 'Audio 15 percent', 'percentage', 15.00, 1000000.00, 250000.00, 200, 18, '2026-05-01', '2026-06-30', 1, '2026-05-04 02:06:00'),
(5, 'FREESHIP', 'Free shipping support', 'fixed', 50000.00, 300000.00, NULL, 500, 60, '2026-05-01', '2026-12-31', 1, '2026-05-04 02:08:00'),
(6, 'MONITOR7', 'Monitor 7 percent', 'percentage', 7.00, 3000000.00, 400000.00, 90, 7, '2026-05-01', '2026-07-31', 1, '2026-05-04 02:10:00'),
(7, 'ROUTER100', 'Router discount 100k', 'fixed', 100000.00, 1000000.00, NULL, 120, 9, '2026-05-01', '2026-08-31', 1, '2026-05-04 02:12:00'),
(8, 'GAMING8', 'Gaming gear 8 percent', 'percentage', 8.00, 2000000.00, 500000.00, 100, 14, '2026-05-01', '2026-07-31', 1, '2026-05-04 02:14:00'),
(9, 'SSD120', 'SSD discount 120k', 'fixed', 120000.00, 1000000.00, NULL, 120, 5, '2026-05-01', '2026-08-31', 1, '2026-05-04 02:16:00'),
(10, 'APPLE5', 'Apple 5 percent', 'percentage', 5.00, 10000000.00, 800000.00, 80, 8, '2026-05-01', '2026-06-15', 1, '2026-05-04 02:18:00'),
(11, 'SAMSUNG5', 'Samsung 5 percent', 'percentage', 5.00, 8000000.00, 700000.00, 80, 11, '2026-05-01', '2026-06-15', 1, '2026-05-04 02:20:00'),
(12, 'STUDENT200', 'Student discount 200k', 'fixed', 200000.00, 3000000.00, NULL, 200, 33, '2026-05-01', '2026-09-30', 1, '2026-05-04 02:22:00'),
(13, 'OFFICE300', 'Office setup discount', 'fixed', 300000.00, 5000000.00, NULL, 160, 21, '2026-05-01', '2026-09-30', 1, '2026-05-04 02:24:00'),
(14, 'MAYDAY12', 'May day 12 percent', 'percentage', 12.00, 1000000.00, 350000.00, 250, 45, '2026-05-01', '2026-05-31', 1, '2026-05-04 02:26:00'),
(15, 'FLASH99', 'Flash sale 99k', 'fixed', 99000.00, 500000.00, NULL, 99, 48, '2026-05-10', '2026-05-20', 1, '2026-05-04 02:28:00'),
(16, 'VIP20', 'VIP 20 percent', 'percentage', 20.00, 20000000.00, 1500000.00, 40, 3, '2026-05-01', '2026-12-31', 1, '2026-05-04 02:30:00'),
(17, 'PAYONLINE', 'Online payment discount', 'fixed', 150000.00, 2000000.00, NULL, 180, 16, '2026-05-01', '2026-08-31', 1, '2026-05-04 02:32:00'),
(18, 'NEWGEAR6', 'New gear 6 percent', 'percentage', 6.00, 2500000.00, 300000.00, 120, 12, '2026-05-01', '2026-07-31', 1, '2026-05-04 02:34:00'),
(19, 'CLEARANCE', 'Clearance discount', 'percentage', 18.00, 1000000.00, 600000.00, 70, 19, '2026-05-01', '2026-06-30', 1, '2026-05-04 02:36:00'),
(20, 'TESTOFF', 'Inactive test coupon', 'fixed', 100000.00, 1000000.00, NULL, 10, 0, '2026-05-01', '2026-05-31', 0, '2026-05-04 02:38:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `coupon_id`, `user_id`, `order_id`, `code`, `discount_amount`, `used_at`) VALUES
(1, 1, 4, 1, 'WELCOME10', 500000.00, '2026-05-06 01:00:00'),
(2, 2, 5, 2, 'LAPTOP500', 300000.00, '2026-05-06 01:15:00'),
(3, 3, 6, 3, 'PHONE300', 200000.00, '2026-05-06 01:30:00'),
(4, 4, 7, 4, 'AUDIO15', 100000.00, '2026-05-06 01:45:00'),
(5, 5, 8, 5, 'FREESHIP', 300000.00, '2026-05-06 02:00:00'),
(6, 6, 9, 6, 'MONITOR7', 99000.00, '2026-05-06 02:15:00'),
(7, 7, 10, 7, 'ROUTER100', 300000.00, '2026-05-06 02:30:00'),
(8, 8, 11, 8, 'GAMING8', 500000.00, '2026-05-06 02:45:00'),
(9, 9, 12, 9, 'SSD120', 100000.00, '2026-05-06 03:00:00'),
(10, 10, 13, 10, 'APPLE5', 300000.00, '2026-05-06 03:15:00'),
(11, 11, 14, 11, 'SAMSUNG5', 300000.00, '2026-05-06 03:30:00'),
(12, 12, 15, 12, 'STUDENT200', 800000.00, '2026-05-06 03:45:00'),
(13, 13, 16, 13, 'OFFICE300', 200000.00, '2026-05-06 04:00:00'),
(14, 14, 17, 14, 'MAYDAY12', 150000.00, '2026-05-06 04:15:00'),
(15, 15, 18, 15, 'FLASH99', 99000.00, '2026-05-06 04:30:00'),
(16, 16, 19, 16, 'VIP20', 1500000.00, '2026-05-06 04:45:00'),
(17, 17, 20, 17, 'PAYONLINE', 150000.00, '2026-05-06 05:00:00'),
(18, 18, 4, 18, 'NEWGEAR6', 200000.00, '2026-05-07 01:00:00'),
(19, 19, 5, 19, 'CLEARANCE', 200000.00, '2026-05-07 01:15:00'),
(20, 20, 6, 20, 'TESTOFF', 300000.00, '2026-05-07 01:30:00'),
(21, 1, 7, 21, 'WELCOME10', 150000.00, '2026-05-07 01:45:00'),
(22, 2, 8, 22, 'LAPTOP500', 500000.00, '2026-05-07 02:00:00'),
(23, 3, 9, 23, 'PHONE300', 100000.00, '2026-05-07 02:15:00'),
(24, 4, 10, 24, 'AUDIO15', 50000.00, '2026-05-07 02:30:00'),
(25, 5, 11, 25, 'FREESHIP', 500000.00, '2026-05-07 02:45:00'),
(26, 6, 12, 26, 'MONITOR7', 100000.00, '2026-05-07 03:00:00'),
(27, 7, 13, 27, 'ROUTER100', 150000.00, '2026-05-07 03:15:00'),
(28, 8, 14, 28, 'GAMING8', 150000.00, '2026-05-07 03:30:00'),
(29, 9, 15, 29, 'SSD120', 500000.00, '2026-05-07 03:45:00'),
(30, 10, 16, 30, 'APPLE5', 50000.00, '2026-05-07 04:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `user_id`, `title`, `slug`, `thumbnail`, `summary`, `content`, `status`, `created_at`) VALUES
(1, 22, 'How to choose a laptop for students', 'how-to-choose-a-laptop-for-students', 'template/images/blog/post-1.jpg', 'Simple laptop buying guide for students.', 'Choose a laptop based on CPU, RAM, battery life and warranty. Students should prioritize portability and stable performance.', 1, '2026-05-09 01:00:00'),
(2, 22, 'Top gaming accessories in 2026', 'top-gaming-accessories-in-2026', 'template/images/blog/post-2.jpg', 'Keyboard, mouse and headset recommendations.', 'Gaming accessories should match your play style. A good mouse and keyboard can improve comfort and accuracy.', 1, '2026-05-09 01:15:00'),
(3, 22, 'SSD upgrade guide for old laptops', 'ssd-upgrade-guide-for-old-laptops', 'template/images/blog/post-3.jpg', 'Why SSD upgrades make devices faster.', 'Replacing an old hard drive with an SSD is one of the most effective ways to improve boot and app load time.', 1, '2026-05-09 01:30:00'),
(4, 22, 'Wi-Fi 6 benefits for home networks', 'wi-fi-6-benefits-for-home-networks', 'template/images/blog/post-4.jpg', 'Better speed and stability for many devices.', 'Wi-Fi 6 helps reduce congestion when many phones, laptops and smart devices connect at the same time.', 1, '2026-05-09 01:45:00'),
(5, 22, 'Mechanical keyboard switch basics', 'mechanical-keyboard-switch-basics', 'template/images/blog/post-5.jpg', 'Understand common switch types.', 'Linear, tactile and clicky switches feel different. Test before buying if possible.', 1, '2026-05-09 02:00:00'),
(6, 22, 'Monitor refresh rate explained', 'monitor-refresh-rate-explained', 'template/images/blog/post-6.jpg', '60Hz, 144Hz and 165Hz differences.', 'Higher refresh rates make motion smoother, especially in competitive games.', 1, '2026-05-09 02:15:00'),
(7, 22, 'Phone fast charging tips', 'phone-fast-charging-tips', 'template/images/blog/post-7.jpg', 'Use safe chargers and cables.', 'Choose certified chargers and avoid overheating your phone while charging.', 1, '2026-05-09 02:30:00'),
(8, 22, 'Power bank buying checklist', 'power-bank-buying-checklist', 'template/images/blog/post-8.jpg', 'Capacity, output and portability.', 'A good power bank should match the power needs of your phone, tablet or laptop.', 1, '2026-05-09 02:45:00'),
(9, 22, 'Tablet for note taking', 'tablet-for-note-taking', 'template/images/blog/post-9.jpg', 'What to check before buying.', 'Screen quality, stylus support and app ecosystem are important for note taking.', 1, '2026-05-09 03:00:00'),
(10, 22, 'How to build a balanced gaming PC', 'how-to-build-a-balanced-gaming-pc', 'template/images/blog/post-10.jpg', 'Avoid overspending on one component.', 'A balanced gaming PC pairs CPU, GPU, RAM and PSU properly for stable performance.', 1, '2026-05-09 03:15:00'),
(11, 22, 'ANC headphone comparison', 'anc-headphone-comparison', 'template/images/blog/post-11.jpg', 'Noise cancelling features to compare.', 'Comfort, battery life and microphone quality matter as much as ANC strength.', 1, '2026-05-09 03:30:00'),
(12, 22, 'Router placement guide', 'router-placement-guide', 'template/images/blog/post-12.jpg', 'Improve Wi-Fi coverage at home.', 'Place the router in a central, open location and avoid thick walls or metal cabinets.', 1, '2026-05-09 03:45:00'),
(13, 22, 'Laptop warranty checklist', 'laptop-warranty-checklist', 'template/images/blog/post-1.jpg', 'Know what warranty covers.', 'Check warranty period, service center location and battery policy before buying.', 1, '2026-05-09 04:00:00'),
(14, 22, 'Choosing a work monitor', 'choosing-a-work-monitor', 'template/images/blog/post-2.jpg', 'Resolution and ergonomics matter.', 'For office work, prioritize size, resolution, adjustable stand and eye comfort.', 1, '2026-05-09 04:15:00'),
(15, 22, 'USB-C charger compatibility', 'usb-c-charger-compatibility', 'template/images/blog/post-3.jpg', 'Understand wattage and PD support.', 'USB-C PD chargers can power many devices, but wattage must match the device need.', 1, '2026-05-09 04:30:00'),
(16, 22, 'Bluetooth earbud fit tips', 'bluetooth-earbud-fit-tips', 'template/images/blog/post-4.jpg', 'Good fit improves sound and ANC.', 'Try different ear tips to improve comfort, bass and noise isolation.', 1, '2026-05-09 04:45:00'),
(17, 22, 'PC power supply basics', 'pc-power-supply-basics', 'template/images/blog/post-5.jpg', 'Choose enough wattage and efficiency.', 'A quality PSU protects your PC components and supports future upgrades.', 1, '2026-05-09 05:00:00'),
(18, 22, 'Smart camera privacy tips', 'smart-camera-privacy-tips', 'template/images/blog/post-6.jpg', 'Secure camera accounts properly.', 'Use strong passwords and update firmware to protect smart home devices.', 1, '2026-05-09 05:15:00'),
(19, 22, 'Laptop cooling habits', 'laptop-cooling-habits', 'template/images/blog/post-7.jpg', 'Keep performance stable.', 'Clean vents, use flat surfaces and avoid blocking airflow while using a laptop.', 1, '2026-05-09 05:30:00'),
(20, 22, 'Tech shop promotion calendar', 'tech-shop-promotion-calendar', 'template/images/blog/post-8.jpg', 'Monthly deal planning for buyers.', 'Plan major purchases around seasonal campaigns to get better prices.', 1, '2026-05-09 05:45:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `status` enum('subscribed','unsubscribed') DEFAULT 'subscribed',
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unsubscribed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `gender`, `status`, `subscribed_at`, `unsubscribed_at`) VALUES
(1, 'admin@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(2, 'manager@techshop.test', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(3, 'staff@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(4, 'minhanh@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(5, 'hoangnam@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(6, 'thuha@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(7, 'quanghuy@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(8, 'baongoc@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(9, 'giabao@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(10, 'lanchi@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(11, 'tuankiet@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(12, 'phuonglinh@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(13, 'khanhvy@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(14, 'minhquan@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(15, 'anhduc@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(16, 'thanhtam@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(17, 'nhatminh@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(18, 'ngocdiep@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(19, 'quocbao@example.com', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(20, 'haiyen@example.com', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(21, 'warehouse@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(22, 'content@techshop.test', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(23, 'support@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(24, 'accountant@techshop.test', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(25, 'marketing@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(26, 'seller@techshop.test', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(27, 'shipper@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(28, 'product.manager@techshop.test', 'female', 'subscribed', '2026-05-18 02:20:00', NULL),
(29, 'order.manager@techshop.test', 'male', 'subscribed', '2026-05-18 02:20:00', NULL),
(30, 'blocked@example.com', 'female', 'unsubscribed', '2026-05-18 02:20:00', '2026-05-18 02:50:00'),
(31, 'guest.newsletter@example.com', 'other', 'subscribed', '2026-05-18 02:21:00', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_full_name` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_postal_code` varchar(30) DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `billing_full_name` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(20) DEFAULT NULL,
  `billing_country` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_postal_code` varchar(30) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `shipping_fee` decimal(15,2) DEFAULT 0.00,
  `tax_amount` decimal(15,2) DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `shipping_method` varchar(50) DEFAULT 'standard',
  `tracking_number` varchar(100) DEFAULT NULL,
  `order_status` enum('pending','confirmed','processing','shipping','shipped','delivered','completed','cancelled','returned') DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','failed','refunded') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `coupon_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_full_name`, `shipping_phone`, `shipping_country`, `shipping_state`, `shipping_city`, `shipping_postal_code`, `billing_address`, `billing_full_name`, `billing_phone`, `billing_country`, `billing_state`, `billing_city`, `billing_postal_code`, `note`, `subtotal`, `discount_amount`, `shipping_fee`, `tax_amount`, `total_amount`, `shipping_method`, `tracking_number`, `order_status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'ORD2026050001', 'Nguyen Minh Anh', 'minhanh@example.com', '0901000004', '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', 'Vietnam', NULL, NULL, NULL, 'Deliver after 6 PM', 33380000.00, 500000.00, 30000.00, 0.00, 32910000.00, 'standard', 'TRKORD2026050001', 'completed', 'paid', '2026-05-06 01:00:00', '2026-05-17 19:42:38'),
(2, 5, 2, 'ORD2026050002', 'Tran Hoang Nam', 'hoangnam@example.com', '0901000005', '45 Le Loi, District 3, Ho Chi Minh City', 'Tran Hoang Nam', '0901000005', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '45 Le Loi, District 3, Ho Chi Minh City', 'Tran Hoang Nam', '0901000005', 'Vietnam', NULL, NULL, NULL, NULL, 26490000.00, 300000.00, 30000.00, 0.00, 26220000.00, 'standard', 'TRKORD2026050002', 'shipping', 'paid', '2026-05-06 01:15:00', '2026-05-17 19:42:38'),
(3, 6, 3, 'ORD2026050003', 'Le Thu Ha', 'thuha@example.com', '0901000006', '78 Tran Phu, Ha Dong, Ha Noi', 'Le Thu Ha', '0901000006', 'Vietnam', NULL, 'Ha Noi', NULL, '78 Tran Phu, Ha Dong, Ha Noi', 'Le Thu Ha', '0901000006', 'Vietnam', NULL, NULL, NULL, 'Call before delivery', 18180000.00, 200000.00, 30000.00, 0.00, 18010000.00, 'standard', 'TRKORD2026050003', 'processing', 'paid', '2026-05-06 01:30:00', '2026-05-17 19:42:38'),
(4, 7, 4, 'ORD2026050004', 'Pham Quang Huy', 'quanghuy@example.com', '0901000007', '22 Dien Bien Phu, Binh Thanh, Ho Chi Minh City', 'Pham Quang Huy', '0901000007', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '22 Dien Bien Phu, Binh Thanh, Ho Chi Minh City', 'Pham Quang Huy', '0901000007', 'Vietnam', NULL, NULL, NULL, NULL, 6680000.00, 100000.00, 30000.00, 0.00, 6610000.00, 'standard', 'TRKORD2026050004', 'confirmed', 'unpaid', '2026-05-06 01:45:00', '2026-05-17 19:42:38'),
(5, 8, 5, 'ORD2026050005', 'Do Bao Ngoc', 'baongoc@example.com', '0901000008', '9 Hai Ba Trung, Hoan Kiem, Ha Noi', 'Do Bao Ngoc', '0901000008', 'Vietnam', NULL, 'Ha Noi', NULL, '9 Hai Ba Trung, Hoan Kiem, Ha Noi', 'Do Bao Ngoc', '0901000008', 'Vietnam', NULL, NULL, NULL, NULL, 12760000.00, 300000.00, 30000.00, 0.00, 12490000.00, 'standard', 'TRKORD2026050005', 'completed', 'paid', '2026-05-06 02:00:00', '2026-05-17 19:42:38'),
(6, 9, 6, 'ORD2026050006', 'Hoang Gia Bao', 'giabao@example.com', '0901000009', '18 Bach Dang, Da Nang', 'Hoang Gia Bao', '0901000009', 'Vietnam', NULL, 'Da Nang', NULL, '18 Bach Dang, Da Nang', 'Hoang Gia Bao', '0901000009', 'Vietnam', NULL, NULL, NULL, 'Office hours delivery', 6280000.00, 99000.00, 30000.00, 0.00, 6211000.00, 'standard', 'TRKORD2026050006', 'completed', 'paid', '2026-05-06 02:15:00', '2026-05-17 19:42:38'),
(7, 10, 7, 'ORD2026050007', 'Bui Lan Chi', 'lanchi@example.com', '0901000010', '101 Nguyen Van Cu, Can Tho', 'Bui Lan Chi', '0901000010', 'Vietnam', NULL, 'Can Tho', NULL, '101 Nguyen Van Cu, Can Tho', 'Bui Lan Chi', '0901000010', 'Vietnam', NULL, NULL, NULL, NULL, 26880000.00, 300000.00, 30000.00, 0.00, 26610000.00, 'standard', 'TRKORD2026050007', 'shipping', 'paid', '2026-05-06 02:30:00', '2026-05-17 19:42:38'),
(8, 11, 8, 'ORD2026050008', 'Dang Tuan Kiet', 'tuankiet@example.com', '0901000011', '66 Vo Van Tan, District 3, Ho Chi Minh City', 'Dang Tuan Kiet', '0901000011', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '66 Vo Van Tan, District 3, Ho Chi Minh City', 'Dang Tuan Kiet', '0901000011', 'Vietnam', NULL, NULL, NULL, NULL, 27480000.00, 500000.00, 30000.00, 0.00, 27010000.00, 'standard', 'TRKORD2026050008', 'processing', 'paid', '2026-05-06 02:45:00', '2026-05-17 19:42:38'),
(9, 12, 9, 'ORD2026050009', 'Vu Phuong Linh', 'phuonglinh@example.com', '0901000012', '27 Hoang Dieu, Da Nang', 'Vu Phuong Linh', '0901000012', 'Vietnam', NULL, 'Da Nang', NULL, '27 Hoang Dieu, Da Nang', 'Vu Phuong Linh', '0901000012', 'Vietnam', NULL, NULL, NULL, NULL, 6170000.00, 100000.00, 30000.00, 0.00, 6100000.00, 'standard', 'TRKORD2026050009', 'pending', 'unpaid', '2026-05-06 03:00:00', '2026-05-17 19:42:38'),
(10, 13, 10, 'ORD2026050010', 'Dinh Khanh Vy', 'khanhvy@example.com', '0901000013', '33 Nguyen Hue, Hue', 'Dinh Khanh Vy', '0901000013', 'Vietnam', NULL, 'Hue', NULL, '33 Nguyen Hue, Hue', 'Dinh Khanh Vy', '0901000013', 'Vietnam', NULL, NULL, NULL, NULL, 18180000.00, 300000.00, 30000.00, 0.00, 17910000.00, 'standard', 'TRKORD2026050010', 'confirmed', 'paid', '2026-05-06 03:15:00', '2026-05-17 19:42:38'),
(11, 14, 11, 'ORD2026050011', 'Cao Minh Quan', 'minhquan@example.com', '0901000014', '88 Tran Hung Dao, Nha Trang', 'Cao Minh Quan', '0901000014', 'Vietnam', NULL, 'Nha Trang', NULL, '88 Tran Hung Dao, Nha Trang', 'Cao Minh Quan', '0901000014', 'Vietnam', NULL, NULL, NULL, NULL, 13080000.00, 300000.00, 30000.00, 0.00, 12810000.00, 'standard', 'TRKORD2026050011', 'completed', 'paid', '2026-05-06 03:30:00', '2026-05-17 19:42:38'),
(12, 15, 12, 'ORD2026050012', 'Mai Anh Duc', 'anhduc@example.com', '0901000015', '40 Phan Chu Trinh, Da Lat', 'Mai Anh Duc', '0901000015', 'Vietnam', NULL, 'Da Lat', NULL, '40 Phan Chu Trinh, Da Lat', 'Mai Anh Duc', '0901000015', 'Vietnam', NULL, NULL, NULL, NULL, 41480000.00, 800000.00, 30000.00, 0.00, 40710000.00, 'standard', 'TRKORD2026050012', 'processing', 'paid', '2026-05-06 03:45:00', '2026-05-17 19:42:38'),
(13, 16, 13, 'ORD2026050013', 'Ly Thanh Tam', 'thanhtam@example.com', '0901000016', '2 Ly Thuong Kiet, Hai Phong', 'Ly Thanh Tam', '0901000016', 'Vietnam', NULL, 'Hai Phong', NULL, '2 Ly Thuong Kiet, Hai Phong', 'Ly Thanh Tam', '0901000016', 'Vietnam', NULL, NULL, NULL, NULL, 18780000.00, 200000.00, 30000.00, 0.00, 18610000.00, 'standard', 'TRKORD2026050013', 'shipping', 'paid', '2026-05-06 04:00:00', '2026-05-17 19:42:38'),
(14, 17, 14, 'ORD2026050014', 'Truong Nhat Minh', 'nhatminh@example.com', '0901000017', '15 Nguyen Du, Vinh', 'Truong Nhat Minh', '0901000017', 'Vietnam', NULL, 'Vinh', NULL, '15 Nguyen Du, Vinh', 'Truong Nhat Minh', '0901000017', 'Vietnam', NULL, NULL, NULL, NULL, 10980000.00, 150000.00, 30000.00, 0.00, 10860000.00, 'standard', 'TRKORD2026050014', 'completed', 'paid', '2026-05-06 04:15:00', '2026-05-17 19:42:38'),
(15, 18, 15, 'ORD2026050015', 'Ha Ngoc Diep', 'ngocdiep@example.com', '0901000018', '71 Cach Mang Thang 8, Ho Chi Minh City', 'Ha Ngoc Diep', '0901000018', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '71 Cach Mang Thang 8, Ho Chi Minh City', 'Ha Ngoc Diep', '0901000018', 'Vietnam', NULL, NULL, NULL, NULL, 8680000.00, 99000.00, 30000.00, 0.00, 8611000.00, 'standard', 'TRKORD2026050015', 'cancelled', 'refunded', '2026-05-06 04:30:00', '2026-05-17 19:42:38'),
(16, 19, 16, 'ORD2026050016', 'Vo Quoc Bao', 'quocbao@example.com', '0901000019', '19 Ton Duc Thang, District 1, Ho Chi Minh City', 'Vo Quoc Bao', '0901000019', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '19 Ton Duc Thang, District 1, Ho Chi Minh City', 'Vo Quoc Bao', '0901000019', 'Vietnam', NULL, NULL, NULL, NULL, 40680000.00, 1500000.00, 30000.00, 0.00, 39210000.00, 'standard', 'TRKORD2026050016', 'completed', 'paid', '2026-05-06 04:45:00', '2026-05-17 19:42:38'),
(17, 20, 17, 'ORD2026050017', 'Nguyen Hai Yen', 'haiyen@example.com', '0901000020', '52 Quang Trung, Go Vap, Ho Chi Minh City', 'Nguyen Hai Yen', '0901000020', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '52 Quang Trung, Go Vap, Ho Chi Minh City', 'Nguyen Hai Yen', '0901000020', 'Vietnam', NULL, NULL, NULL, NULL, 10180000.00, 150000.00, 30000.00, 0.00, 10060000.00, 'standard', 'TRKORD2026050017', 'pending', 'unpaid', '2026-05-06 05:00:00', '2026-05-17 19:42:38'),
(18, 4, 18, 'ORD2026050018', 'Nguyen Minh Anh', 'minhanh@example.com', '0901000004', '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', 'Vietnam', NULL, NULL, NULL, NULL, 18080000.00, 200000.00, 30000.00, 0.00, 17910000.00, 'standard', 'TRKORD2026050018', 'completed', 'paid', '2026-05-07 01:00:00', '2026-05-17 19:42:38'),
(19, 5, 19, 'ORD2026050019', 'Tran Hoang Nam', 'hoangnam@example.com', '0901000005', '45 Le Loi, District 3, Ho Chi Minh City', 'Tran Hoang Nam', '0901000005', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '45 Le Loi, District 3, Ho Chi Minh City', 'Tran Hoang Nam', '0901000005', 'Vietnam', NULL, NULL, NULL, NULL, 17970000.00, 200000.00, 30000.00, 0.00, 17800000.00, 'standard', 'TRKORD2026050019', 'confirmed', 'unpaid', '2026-05-07 01:15:00', '2026-05-17 19:42:38'),
(20, 6, 20, 'ORD2026050020', 'Le Thu Ha', 'thuha@example.com', '0901000006', '78 Tran Phu, Ha Dong, Ha Noi', 'Le Thu Ha', '0901000006', 'Vietnam', NULL, 'Ha Noi', NULL, '78 Tran Phu, Ha Dong, Ha Noi', 'Le Thu Ha', '0901000006', 'Vietnam', NULL, NULL, NULL, NULL, 13280000.00, 300000.00, 30000.00, 0.00, 13010000.00, 'standard', 'TRKORD2026050020', 'shipping', 'paid', '2026-05-07 01:30:00', '2026-05-17 19:42:38'),
(21, 7, 1, 'ORD2026050021', 'Pham Quang Huy', 'quanghuy@example.com', '0901000007', '22 Dien Bien Phu, Binh Thanh, Ho Chi Minh City', 'Pham Quang Huy', '0901000007', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '22 Dien Bien Phu, Binh Thanh, Ho Chi Minh City', 'Pham Quang Huy', '0901000007', 'Vietnam', NULL, NULL, NULL, NULL, 7080000.00, 150000.00, 30000.00, 0.00, 6960000.00, 'standard', 'TRKORD2026050021', 'completed', 'paid', '2026-05-07 01:45:00', '2026-05-17 19:42:38'),
(22, 8, 2, 'ORD2026050022', 'Do Bao Ngoc', 'baongoc@example.com', '0901000008', '9 Hai Ba Trung, Hoan Kiem, Ha Noi', 'Do Bao Ngoc', '0901000008', 'Vietnam', NULL, 'Ha Noi', NULL, '9 Hai Ba Trung, Hoan Kiem, Ha Noi', 'Do Bao Ngoc', '0901000008', 'Vietnam', NULL, NULL, NULL, NULL, 32580000.00, 500000.00, 30000.00, 0.00, 32110000.00, 'standard', 'TRKORD2026050022', 'processing', 'paid', '2026-05-07 02:00:00', '2026-05-17 19:42:38'),
(23, 9, 3, 'ORD2026050023', 'Hoang Gia Bao', 'giabao@example.com', '0901000009', '18 Bach Dang, Da Nang', 'Hoang Gia Bao', '0901000009', 'Vietnam', NULL, 'Da Nang', NULL, '18 Bach Dang, Da Nang', 'Hoang Gia Bao', '0901000009', 'Vietnam', NULL, NULL, NULL, NULL, 4970000.00, 100000.00, 30000.00, 0.00, 4900000.00, 'standard', 'TRKORD2026050023', 'pending', 'failed', '2026-05-07 02:15:00', '2026-05-17 19:42:38'),
(24, 10, 4, 'ORD2026050024', 'Bui Lan Chi', 'lanchi@example.com', '0901000010', '101 Nguyen Van Cu, Can Tho', 'Bui Lan Chi', '0901000010', 'Vietnam', NULL, 'Can Tho', NULL, '101 Nguyen Van Cu, Can Tho', 'Bui Lan Chi', '0901000010', 'Vietnam', NULL, NULL, NULL, NULL, 1290000.00, 50000.00, 30000.00, 0.00, 1270000.00, 'standard', 'TRKORD2026050024', 'completed', 'paid', '2026-05-07 02:30:00', '2026-05-17 19:42:38'),
(25, 11, 5, 'ORD2026050025', 'Dang Tuan Kiet', 'tuankiet@example.com', '0901000011', '66 Vo Van Tan, District 3, Ho Chi Minh City', 'Dang Tuan Kiet', '0901000011', 'Vietnam', NULL, 'Ho Chi Minh City', NULL, '66 Vo Van Tan, District 3, Ho Chi Minh City', 'Dang Tuan Kiet', '0901000011', 'Vietnam', NULL, NULL, NULL, NULL, 29570000.00, 500000.00, 30000.00, 0.00, 29100000.00, 'standard', 'TRKORD2026050025', 'shipping', 'paid', '2026-05-07 02:45:00', '2026-05-17 19:42:38'),
(26, 12, 6, 'ORD2026050026', 'Vu Phuong Linh', 'phuonglinh@example.com', '0901000012', '27 Hoang Dieu, Da Nang', 'Vu Phuong Linh', '0901000012', 'Vietnam', NULL, 'Da Nang', NULL, '27 Hoang Dieu, Da Nang', 'Vu Phuong Linh', '0901000012', 'Vietnam', NULL, NULL, NULL, NULL, 4980000.00, 100000.00, 30000.00, 0.00, 4910000.00, 'standard', 'TRKORD2026050026', 'completed', 'paid', '2026-05-07 03:00:00', '2026-05-17 19:42:38'),
(27, 13, 7, 'ORD2026050027', 'Dinh Khanh Vy', 'khanhvy@example.com', '0901000013', '33 Nguyen Hue, Hue', 'Dinh Khanh Vy', '0901000013', 'Vietnam', NULL, 'Hue', NULL, '33 Nguyen Hue, Hue', 'Dinh Khanh Vy', '0901000013', 'Vietnam', NULL, NULL, NULL, NULL, 9670000.00, 150000.00, 30000.00, 0.00, 9550000.00, 'standard', 'TRKORD2026050027', 'processing', 'paid', '2026-05-07 03:15:00', '2026-05-17 19:42:38'),
(28, 14, 8, 'ORD2026050028', 'Cao Minh Quan', 'minhquan@example.com', '0901000014', '88 Tran Hung Dao, Nha Trang', 'Cao Minh Quan', '0901000014', 'Vietnam', NULL, 'Nha Trang', NULL, '88 Tran Hung Dao, Nha Trang', 'Cao Minh Quan', '0901000014', 'Vietnam', NULL, NULL, NULL, NULL, 10680000.00, 150000.00, 30000.00, 0.00, 10560000.00, 'standard', 'TRKORD2026050028', 'confirmed', 'unpaid', '2026-05-07 03:30:00', '2026-05-17 19:42:38'),
(29, 15, 9, 'ORD2026050029', 'Mai Anh Duc', 'anhduc@example.com', '0901000015', '40 Phan Chu Trinh, Da Lat', 'Mai Anh Duc', '0901000015', 'Vietnam', NULL, 'Da Lat', NULL, '40 Phan Chu Trinh, Da Lat', 'Mai Anh Duc', '0901000015', 'Vietnam', NULL, NULL, NULL, NULL, 31990000.00, 500000.00, 30000.00, 0.00, 31520000.00, 'standard', 'TRKORD2026050029', 'completed', 'paid', '2026-05-07 03:45:00', '2026-05-17 19:42:38'),
(30, 16, 10, 'ORD2026050030', 'Ly Thanh Tam', 'thanhtam@example.com', '0901000016', '2 Ly Thuong Kiet, Hai Phong', 'Ly Thanh Tam', '0901000016', 'Vietnam', NULL, 'Hai Phong', NULL, '2 Ly Thuong Kiet, Hai Phong', 'Ly Thanh Tam', '0901000016', 'Vietnam', NULL, NULL, NULL, NULL, 2180000.00, 50000.00, 30000.00, 0.00, 2160000.00, 'standard', 'TRKORD2026050030', 'pending', 'unpaid', '2026-05-07 04:00:00', '2026-05-17 19:42:38'),
(33, 4, NULL, 'ORD2026052221023342', 'Nguyen Minh Anh', 'minhanh@example.com', '0901000004', '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', 'Vietnam', NULL, NULL, NULL, '12 Nguyen Trai, District 1, Ho Chi Minh City', 'Nguyen Minh Anh', '0901000004', NULL, NULL, NULL, NULL, 'Giao tiêu chuẩn - Test COD checkout', 17260000.00, 1800000.00, 0.00, 0.00, 15460000.00, 'standard', NULL, 'pending', 'unpaid', '2026-05-22 14:02:33', '2026-05-22 14:02:33'),
(34, 33, NULL, 'ORD2026052221192036', 'Trần Mạnh Linh', 'manhlinh@gmail.com', '+84868066018', 'Can Lộc', 'Trần Mạnh Linh', '+84868066018', 'Vietnam', NULL, NULL, NULL, 'Can Lộc', 'Trần Mạnh Linh', '+84868066018', 'Vietnam', NULL, NULL, NULL, 'Giao tiêu chuẩn', 8990000.00, 500000.00, 0.00, 0.00, 8490000.00, 'standard', NULL, 'shipping', 'unpaid', '2026-05-22 14:19:20', '2026-05-22 14:21:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_variant_id` int(11) DEFAULT NULL,
  `product_sku` varchar(100) DEFAULT NULL,
  `selected_color` varchar(50) DEFAULT NULL,
  `selected_size` varchar(50) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_sku`, `selected_color`, `selected_size`, `product_name`, `product_image`, `price`, `quantity`, `total`) VALUES
(1, 1, 7, 13, 'ROG-G16-I7', 'Graphite', NULL, 'Asus ROG Strix G16', 'template/images/product/electronic/product7.jpg', 32990000.00, 1, 32990000.00),
(2, 1, 36, 71, 'LOG-K380', 'White', NULL, 'Logitech K380 Multi Device', 'template/images/product/product-d-1.jpg', 390000.00, 1, 390000.00),
(3, 2, 3, 5, 'SGS24U-256', 'Blue', NULL, 'Samsung Galaxy S24 Ultra', 'template/images/product/electronic/product3.jpg', 26490000.00, 1, 26490000.00),
(4, 3, 10, 19, 'LNV-S5-R7', 'Silver', NULL, 'Lenovo IdeaPad Slim 5', 'template/images/product/electronic/product10.jpg', 17490000.00, 1, 17490000.00),
(5, 3, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 690000.00, 1, 690000.00),
(6, 4, 19, 37, 'LOG-MXKS', 'Blue', NULL, 'Logitech MX Keys S', 'template/images/product/electronic/product19.jpg', 2590000.00, 1, 2590000.00),
(7, 4, 20, 39, 'RZ-BWV4', 'White', NULL, 'Razer BlackWidow V4', 'template/images/product/electronic/product20.jpg', 3490000.00, 1, 3490000.00),
(8, 4, 37, 73, 'LOG-M650', 'Gray', NULL, 'Logitech M650 Signature', 'template/images/product/product-d-2.jpg', 600000.00, 1, 600000.00),
(9, 5, 25, 49, 'DL-U2723QE', 'Black', NULL, 'Dell UltraSharp U2723QE', 'template/images/product/electronic/product25.jpg', 12490000.00, 1, 12490000.00),
(10, 5, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 270000.00, 1, 270000.00),
(11, 6, 17, 33, 'JBL-CHG5', 'Black', NULL, 'JBL Charge 5', 'template/images/product/electronic/product17.jpg', 2990000.00, 1, 2990000.00),
(12, 6, 33, 65, 'ANK-737-PB', 'Black', NULL, 'Anker 737 Power Bank', 'template/images/product/electronic/product33.jpg', 3290000.00, 1, 3290000.00),
(13, 7, 2, 3, 'IP15-128', 'Silver', '128GB', 'iPhone 15 128GB', 'template/images/product/electronic/product2.jpg', 20990000.00, 1, 20990000.00),
(14, 7, 15, 29, 'APP2-USBC', 'Graphite', NULL, 'AirPods Pro 2 USB-C', 'template/images/product/electronic/product15.jpg', 5890000.00, 1, 5890000.00),
(15, 8, 8, 15, 'MSI-K15-B13V', 'Red', NULL, 'MSI Katana 15 B13V', 'template/images/product/electronic/product8.jpg', 25990000.00, 1, 25990000.00),
(16, 8, 22, 43, 'RZ-DAV3', 'Titanium', NULL, 'Razer DeathAdder V3', 'template/images/product/electronic/product22.jpg', 1490000.00, 1, 1490000.00),
(17, 9, 31, 61, 'TPL-DECO-X20', 'Graphite', NULL, 'TP-Link Deco X20 2-Pack', 'template/images/product/electronic/product31.jpg', 4190000.00, 1, 4190000.00),
(18, 9, 32, 63, 'XM-CAM-C300', 'Red', NULL, 'Xiaomi Smart Camera C300', 'template/images/product/electronic/product32.jpg', 990000.00, 2, 1980000.00),
(19, 10, 4, 7, 'XM14-256', 'White', NULL, 'Xiaomi 14 5G', 'template/images/product/electronic/product4.jpg', 15990000.00, 1, 15990000.00),
(20, 10, 38, 75, 'JBL-TFLEX', 'Titanium', NULL, 'JBL Tune Flex', 'template/images/product/product-d-3.jpg', 2190000.00, 1, 2190000.00),
(21, 11, 23, 45, 'LG-27GP850', 'Graphite', NULL, 'LG UltraGear 27GP850', 'template/images/product/electronic/product23.jpg', 6990000.00, 1, 6990000.00),
(22, 11, 35, 69, 'LOG-BYETI', 'Blue', NULL, 'Logitech Blue Yeti', 'template/images/product/electronic/product35.jpg', 2990000.00, 1, 2990000.00),
(23, 11, 37, 73, 'LOG-M650', 'Gray', NULL, 'Logitech M650 Signature', 'template/images/product/product-d-2.jpg', 3100000.00, 1, 3100000.00),
(24, 12, 7, 13, 'ROG-G16-I7', 'Graphite', NULL, 'Asus ROG Strix G16', 'template/images/product/electronic/product7.jpg', 32990000.00, 1, 32990000.00),
(25, 12, 28, 55, 'GB-RTX4060-EOC', 'White', NULL, 'Gigabyte RTX 4060 Eagle OC', 'template/images/product/electronic/product28.jpg', 8490000.00, 1, 8490000.00),
(26, 13, 13, 25, 'IPAD-AIR-M2', 'Gray', '11 inch', 'iPad Air M2 11 inch', 'template/images/product/electronic/product13.jpg', 17990000.00, 1, 17990000.00),
(27, 13, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 790000.00, 1, 790000.00),
(28, 14, 16, 31, 'SONY-XM5', 'Red', NULL, 'Sony WH-1000XM5', 'template/images/product/electronic/product16.jpg', 7990000.00, 1, 7990000.00),
(29, 14, 35, 69, 'LOG-BYETI', 'Blue', NULL, 'Logitech Blue Yeti', 'template/images/product/electronic/product35.jpg', 2990000.00, 1, 2990000.00),
(30, 15, 24, 47, 'SS-ODG5-27', 'Red', NULL, 'Samsung Odyssey G5 27', 'template/images/product/electronic/product24.jpg', 5990000.00, 1, 5990000.00),
(31, 15, 40, 79, 'COR-RM750E', 'Red', NULL, 'Corsair RM750e PSU', 'template/images/product/product-d-5.jpg', 2690000.00, 1, 2690000.00),
(32, 16, 39, 77, 'LNV-L5P-R7', 'Graphite', NULL, 'Lenovo Legion 5 Pro', 'template/images/product/product-d-4.jpg', 39990000.00, 1, 39990000.00),
(33, 16, 18, 35, 'JBL-Q100', 'Silver', NULL, 'JBL Quantum 100', 'template/images/product/electronic/product18.jpg', 690000.00, 1, 690000.00),
(34, 17, 5, 9, 'OPR11F-256', 'Gray', NULL, 'Oppo Reno 11F 5G', 'template/images/product/electronic/product5.jpg', 8190000.00, 1, 8190000.00),
(35, 17, 30, 59, 'TPL-AX55', 'Titanium', NULL, 'TP-Link Archer AX55', 'template/images/product/electronic/product30.jpg', 1990000.00, 1, 1990000.00),
(36, 18, 11, 21, 'HP-PAV15-I5', 'Blue', NULL, 'HP Pavilion 15', 'template/images/product/electronic/product11.jpg', 15490000.00, 1, 15490000.00),
(37, 18, 19, 37, 'LOG-MXKS', 'Blue', NULL, 'Logitech MX Keys S', 'template/images/product/electronic/product19.jpg', 2590000.00, 1, 2590000.00),
(38, 19, 12, 23, 'AC-A7-R5', 'White', NULL, 'Acer Aspire 7', 'template/images/product/electronic/product12.jpg', 14990000.00, 1, 14990000.00),
(39, 19, 27, 53, 'COR-DDR5-16', 'Blue', '16GB', 'Corsair Vengeance 16GB DDR5', 'template/images/product/electronic/product27.jpg', 1490000.00, 2, 2980000.00),
(40, 20, 14, 27, 'TAB-S9FE', 'Titanium', NULL, 'Samsung Galaxy Tab S9 FE', 'template/images/product/electronic/product14.jpg', 9990000.00, 1, 9990000.00),
(41, 20, 33, 65, 'ANK-737-PB', 'Black', NULL, 'Anker 737 Power Bank', 'template/images/product/electronic/product33.jpg', 3290000.00, 1, 3290000.00),
(42, 21, 29, 57, 'AS-TUF-B650M', 'Gray', NULL, 'Asus TUF B650M Plus', 'template/images/product/electronic/product29.jpg', 4390000.00, 1, 4390000.00),
(43, 21, 40, 79, 'COR-RM750E', 'Red', NULL, 'Corsair RM750e PSU', 'template/images/product/product-d-5.jpg', 2690000.00, 1, 2690000.00),
(44, 22, 6, 11, 'MBA-M3-13', 'Titanium', '13 inch', 'MacBook Air M3 13 inch', 'template/images/product/electronic/product6.jpg', 27990000.00, 1, 27990000.00),
(45, 22, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 790000.00, 2, 1580000.00),
(46, 23, 30, 59, 'TPL-AX55', 'Titanium', NULL, 'TP-Link Archer AX55', 'template/images/product/electronic/product30.jpg', 1990000.00, 2, 3980000.00),
(47, 23, 32, 63, 'XM-CAM-C300', 'Red', NULL, 'Xiaomi Smart Camera C300', 'template/images/product/electronic/product32.jpg', 990000.00, 1, 990000.00),
(48, 24, 36, 71, 'LOG-K380', 'White', NULL, 'Logitech K380 Multi Device', 'template/images/product/product-d-1.jpg', 690000.00, 1, 690000.00),
(49, 24, 37, 73, 'LOG-M650', 'Gray', NULL, 'Logitech M650 Signature', 'template/images/product/product-d-2.jpg', 590000.00, 1, 590000.00),
(50, 25, 6, 11, 'MBA-M3-13', 'Titanium', '13 inch', 'MacBook Air M3 13 inch', 'template/images/product/electronic/product6.jpg', 27990000.00, 1, 27990000.00),
(51, 25, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 790000.00, 2, 1580000.00),
(52, 26, 17, 33, 'JBL-CHG5', 'Black', NULL, 'JBL Charge 5', 'template/images/product/electronic/product17.jpg', 2990000.00, 1, 2990000.00),
(53, 26, 38, 75, 'JBL-TFLEX', 'Titanium', NULL, 'JBL Tune Flex', 'template/images/product/product-d-3.jpg', 1990000.00, 1, 1990000.00),
(54, 27, 26, 51, 'KS-NV2-1TB', 'Silver', '1TB', 'Kingston NV2 1TB', 'template/images/product/electronic/product26.jpg', 1390000.00, 3, 4170000.00),
(55, 27, 27, 53, 'COR-DDR5-16', 'Blue', '16GB', 'Corsair Vengeance 16GB DDR5', 'template/images/product/electronic/product27.jpg', 1490000.00, 2, 2980000.00),
(56, 27, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 2520000.00, 1, 2520000.00),
(57, 28, 23, 45, 'LG-27GP850', 'Graphite', NULL, 'LG UltraGear 27GP850', 'template/images/product/electronic/product23.jpg', 6990000.00, 1, 6990000.00),
(58, 28, 35, 69, 'LOG-BYETI', 'Blue', NULL, 'Logitech Blue Yeti', 'template/images/product/electronic/product35.jpg', 2990000.00, 1, 2990000.00),
(59, 28, 37, 73, 'LOG-M650', 'Gray', NULL, 'Logitech M650 Signature', 'template/images/product/product-d-2.jpg', 700000.00, 1, 700000.00),
(60, 29, 9, 17, 'DXPS13P-512', 'Black', NULL, 'Dell XPS 13 Plus', 'template/images/product/electronic/product9.jpg', 31990000.00, 1, 31990000.00),
(61, 30, 37, 73, 'LOG-M650', 'Gray', NULL, 'Logitech M650 Signature', 'template/images/product/product-d-2.jpg', 590000.00, 1, 590000.00),
(62, 30, 18, 35, 'JBL-Q100', 'Silver', NULL, 'JBL Quantum 100', 'template/images/product/electronic/product18.jpg', 690000.00, 1, 690000.00),
(63, 30, 36, 71, 'LOG-K380', 'White', NULL, 'Logitech K380 Multi Device', 'template/images/product/product-d-1.jpg', 690000.00, 1, 690000.00),
(64, 30, 34, 67, 'ANK-NANO-65W', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/electronic/product34.jpg', 210000.00, 1, 210000.00),
(71, 33, 15, 29, 'APP2-USBC-GRA', 'Graphite', NULL, 'AirPods Pro 2 USB-C', 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 5890000.00, 1, 5890000.00),
(72, 33, 34, 67, 'ANK-NANO-65W-SIL', 'Silver', NULL, 'Anker Nano 65W Charger', 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 790000.00, 2, 1580000.00),
(73, 33, 16, 31, 'SONY-XM5-RED', 'Red', NULL, 'Sony WH-1000XM5', 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 7990000.00, 1, 7990000.00),
(74, 34, 28, NULL, 'GB-RTX4060-EOC', NULL, NULL, 'Gigabyte RTX 4060 Eagle OC', 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 8490000.00, 1, 8490000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status_histories`
--

CREATE TABLE `order_status_histories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status_histories`
--

INSERT INTO `order_status_histories` (`id`, `order_id`, `status`, `note`, `created_at`) VALUES
(1, 1, 'pending', 'Order received from checkout', '2026-05-06 01:00:00'),
(2, 1, 'confirmed', 'Order confirmed by store staff', '2026-05-06 05:00:00'),
(3, 1, 'processing', 'Items are being packed', '2026-05-06 09:00:00'),
(4, 1, 'shipped', 'Package handed to delivery partner', '2026-05-06 13:00:00'),
(5, 1, 'delivered', 'Customer received the package', '2026-05-06 17:00:00'),
(6, 2, 'pending', 'Order received from checkout', '2026-05-06 01:15:00'),
(7, 2, 'confirmed', 'Order confirmed by store staff', '2026-05-06 05:15:00'),
(8, 2, 'processing', 'Items are being packed', '2026-05-06 09:15:00'),
(9, 2, 'shipped', 'Package handed to delivery partner', '2026-05-06 13:15:00'),
(10, 3, 'pending', 'Order received from checkout', '2026-05-06 01:30:00'),
(11, 3, 'confirmed', 'Order confirmed by store staff', '2026-05-06 05:30:00'),
(12, 3, 'processing', 'Items are being packed', '2026-05-06 09:30:00'),
(13, 4, 'pending', 'Order received from checkout', '2026-05-06 01:45:00'),
(14, 4, 'confirmed', 'Order confirmed by store staff', '2026-05-06 05:45:00'),
(15, 5, 'pending', 'Order received from checkout', '2026-05-06 02:00:00'),
(16, 5, 'confirmed', 'Order confirmed by store staff', '2026-05-06 06:00:00'),
(17, 5, 'processing', 'Items are being packed', '2026-05-06 10:00:00'),
(18, 5, 'shipped', 'Package handed to delivery partner', '2026-05-06 14:00:00'),
(19, 5, 'delivered', 'Customer received the package', '2026-05-06 18:00:00'),
(20, 6, 'pending', 'Order received from checkout', '2026-05-06 02:15:00'),
(21, 6, 'confirmed', 'Order confirmed by store staff', '2026-05-06 06:15:00'),
(22, 6, 'processing', 'Items are being packed', '2026-05-06 10:15:00'),
(23, 6, 'shipped', 'Package handed to delivery partner', '2026-05-06 14:15:00'),
(24, 6, 'delivered', 'Customer received the package', '2026-05-06 18:15:00'),
(25, 7, 'pending', 'Order received from checkout', '2026-05-06 02:30:00'),
(26, 7, 'confirmed', 'Order confirmed by store staff', '2026-05-06 06:30:00'),
(27, 7, 'processing', 'Items are being packed', '2026-05-06 10:30:00'),
(28, 7, 'shipped', 'Package handed to delivery partner', '2026-05-06 14:30:00'),
(29, 8, 'pending', 'Order received from checkout', '2026-05-06 02:45:00'),
(30, 8, 'confirmed', 'Order confirmed by store staff', '2026-05-06 06:45:00'),
(31, 8, 'processing', 'Items are being packed', '2026-05-06 10:45:00'),
(32, 9, 'pending', 'Order received from checkout', '2026-05-06 03:00:00'),
(33, 10, 'pending', 'Order received from checkout', '2026-05-06 03:15:00'),
(34, 10, 'confirmed', 'Order confirmed by store staff', '2026-05-06 07:15:00'),
(35, 11, 'pending', 'Order received from checkout', '2026-05-06 03:30:00'),
(36, 11, 'confirmed', 'Order confirmed by store staff', '2026-05-06 07:30:00'),
(37, 11, 'processing', 'Items are being packed', '2026-05-06 11:30:00'),
(38, 11, 'shipped', 'Package handed to delivery partner', '2026-05-06 15:30:00'),
(39, 11, 'delivered', 'Customer received the package', '2026-05-06 19:30:00'),
(40, 12, 'pending', 'Order received from checkout', '2026-05-06 03:45:00'),
(41, 12, 'confirmed', 'Order confirmed by store staff', '2026-05-06 07:45:00'),
(42, 12, 'processing', 'Items are being packed', '2026-05-06 11:45:00'),
(43, 13, 'pending', 'Order received from checkout', '2026-05-06 04:00:00'),
(44, 13, 'confirmed', 'Order confirmed by store staff', '2026-05-06 08:00:00'),
(45, 13, 'processing', 'Items are being packed', '2026-05-06 12:00:00'),
(46, 13, 'shipped', 'Package handed to delivery partner', '2026-05-06 16:00:00'),
(47, 14, 'pending', 'Order received from checkout', '2026-05-06 04:15:00'),
(48, 14, 'confirmed', 'Order confirmed by store staff', '2026-05-06 08:15:00'),
(49, 14, 'processing', 'Items are being packed', '2026-05-06 12:15:00'),
(50, 14, 'shipped', 'Package handed to delivery partner', '2026-05-06 16:15:00'),
(51, 14, 'delivered', 'Customer received the package', '2026-05-06 20:15:00'),
(52, 15, 'pending', 'Order received from checkout', '2026-05-06 04:30:00'),
(53, 15, 'cancelled', 'Order was cancelled and refund flow started', '2026-05-06 08:30:00'),
(54, 16, 'pending', 'Order received from checkout', '2026-05-06 04:45:00'),
(55, 16, 'confirmed', 'Order confirmed by store staff', '2026-05-06 08:45:00'),
(56, 16, 'processing', 'Items are being packed', '2026-05-06 12:45:00'),
(57, 16, 'shipped', 'Package handed to delivery partner', '2026-05-06 16:45:00'),
(58, 16, 'delivered', 'Customer received the package', '2026-05-06 20:45:00'),
(59, 17, 'pending', 'Order received from checkout', '2026-05-06 05:00:00'),
(60, 18, 'pending', 'Order received from checkout', '2026-05-07 01:00:00'),
(61, 18, 'confirmed', 'Order confirmed by store staff', '2026-05-07 05:00:00'),
(62, 18, 'processing', 'Items are being packed', '2026-05-07 09:00:00'),
(63, 18, 'shipped', 'Package handed to delivery partner', '2026-05-07 13:00:00'),
(64, 18, 'delivered', 'Customer received the package', '2026-05-07 17:00:00'),
(65, 19, 'pending', 'Order received from checkout', '2026-05-07 01:15:00'),
(66, 19, 'confirmed', 'Order confirmed by store staff', '2026-05-07 05:15:00'),
(67, 20, 'pending', 'Order received from checkout', '2026-05-07 01:30:00'),
(68, 20, 'confirmed', 'Order confirmed by store staff', '2026-05-07 05:30:00'),
(69, 20, 'processing', 'Items are being packed', '2026-05-07 09:30:00'),
(70, 20, 'shipped', 'Package handed to delivery partner', '2026-05-07 13:30:00'),
(71, 21, 'pending', 'Order received from checkout', '2026-05-07 01:45:00'),
(72, 21, 'confirmed', 'Order confirmed by store staff', '2026-05-07 05:45:00'),
(73, 21, 'processing', 'Items are being packed', '2026-05-07 09:45:00'),
(74, 21, 'shipped', 'Package handed to delivery partner', '2026-05-07 13:45:00'),
(75, 21, 'delivered', 'Customer received the package', '2026-05-07 17:45:00'),
(76, 22, 'pending', 'Order received from checkout', '2026-05-07 02:00:00'),
(77, 22, 'confirmed', 'Order confirmed by store staff', '2026-05-07 06:00:00'),
(78, 22, 'processing', 'Items are being packed', '2026-05-07 10:00:00'),
(79, 23, 'pending', 'Order received from checkout', '2026-05-07 02:15:00'),
(80, 24, 'pending', 'Order received from checkout', '2026-05-07 02:30:00'),
(81, 24, 'confirmed', 'Order confirmed by store staff', '2026-05-07 06:30:00'),
(82, 24, 'processing', 'Items are being packed', '2026-05-07 10:30:00'),
(83, 24, 'shipped', 'Package handed to delivery partner', '2026-05-07 14:30:00'),
(84, 24, 'delivered', 'Customer received the package', '2026-05-07 18:30:00'),
(85, 25, 'pending', 'Order received from checkout', '2026-05-07 02:45:00'),
(86, 25, 'confirmed', 'Order confirmed by store staff', '2026-05-07 06:45:00'),
(87, 25, 'processing', 'Items are being packed', '2026-05-07 10:45:00'),
(88, 25, 'shipped', 'Package handed to delivery partner', '2026-05-07 14:45:00'),
(89, 26, 'pending', 'Order received from checkout', '2026-05-07 03:00:00'),
(90, 26, 'confirmed', 'Order confirmed by store staff', '2026-05-07 07:00:00'),
(91, 26, 'processing', 'Items are being packed', '2026-05-07 11:00:00'),
(92, 26, 'shipped', 'Package handed to delivery partner', '2026-05-07 15:00:00'),
(93, 26, 'delivered', 'Customer received the package', '2026-05-07 19:00:00'),
(94, 27, 'pending', 'Order received from checkout', '2026-05-07 03:15:00'),
(95, 27, 'confirmed', 'Order confirmed by store staff', '2026-05-07 07:15:00'),
(96, 27, 'processing', 'Items are being packed', '2026-05-07 11:15:00'),
(97, 28, 'pending', 'Order received from checkout', '2026-05-07 03:30:00'),
(98, 28, 'confirmed', 'Order confirmed by store staff', '2026-05-07 07:30:00'),
(99, 29, 'pending', 'Order received from checkout', '2026-05-07 03:45:00'),
(100, 29, 'confirmed', 'Order confirmed by store staff', '2026-05-07 07:45:00'),
(101, 29, 'processing', 'Items are being packed', '2026-05-07 11:45:00'),
(102, 29, 'shipped', 'Package handed to delivery partner', '2026-05-07 15:45:00'),
(103, 29, 'delivered', 'Customer received the package', '2026-05-07 19:45:00'),
(104, 30, 'pending', 'Order received from checkout', '2026-05-07 04:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `user_id`, `email`, `token`, `expires_at`, `used_at`, `created_at`) VALUES
(1, 4, 'minhanh@example.com', 'demo-reset-token-01', '2026-05-18 04:00:00', NULL, '2026-05-18 03:00:00'),
(2, 5, 'hoangnam@example.com', 'demo-reset-token-02', '2026-05-18 04:00:00', NULL, '2026-05-18 03:00:00'),
(3, 6, 'thuha@example.com', 'demo-reset-token-03', '2026-05-18 04:00:00', NULL, '2026-05-18 03:00:00'),
(4, 7, 'quanghuy@example.com', 'demo-reset-token-04', '2026-05-18 04:00:00', NULL, '2026-05-18 03:00:00'),
(5, 8, 'baongoc@example.com', 'demo-reset-token-05', '2026-05-18 04:00:00', '2026-05-18 03:10:00', '2026-05-18 03:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transaction_code` varchar(100) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `amount`, `transaction_code`, `paid_at`, `created_at`) VALUES
(1, 1, 'momo', 'paid', 32910000.00, 'MOMO2026050001', '2026-05-06 01:05:00', '2026-05-06 01:00:00'),
(2, 2, 'bank_transfer', 'paid', 26220000.00, 'BANK2026050002', '2026-05-06 01:20:00', '2026-05-06 01:15:00'),
(3, 3, 'vnpay', 'paid', 18010000.00, 'VNPAY2026050003', '2026-05-06 01:35:00', '2026-05-06 01:30:00'),
(4, 4, 'cod', 'unpaid', 6610000.00, NULL, NULL, '2026-05-06 01:45:00'),
(5, 5, 'momo', 'paid', 12490000.00, 'MOMO2026050005', '2026-05-06 02:05:00', '2026-05-06 02:00:00'),
(6, 6, 'bank_transfer', 'paid', 6211000.00, 'BANK2026050006', '2026-05-06 02:20:00', '2026-05-06 02:15:00'),
(7, 7, 'vnpay', 'paid', 26610000.00, 'VNPAY2026050007', '2026-05-06 02:35:00', '2026-05-06 02:30:00'),
(8, 8, 'bank_transfer', 'paid', 27010000.00, 'BANK2026050008', '2026-05-06 02:50:00', '2026-05-06 02:45:00'),
(9, 9, 'cod', 'unpaid', 6100000.00, NULL, NULL, '2026-05-06 03:00:00'),
(10, 10, 'momo', 'paid', 17910000.00, 'MOMO2026050010', '2026-05-06 03:20:00', '2026-05-06 03:15:00'),
(11, 11, 'vnpay', 'paid', 12810000.00, 'VNPAY2026050011', '2026-05-06 03:35:00', '2026-05-06 03:30:00'),
(12, 12, 'bank_transfer', 'paid', 40710000.00, 'BANK2026050012', '2026-05-06 03:50:00', '2026-05-06 03:45:00'),
(13, 13, 'momo', 'paid', 18610000.00, 'MOMO2026050013', '2026-05-06 04:05:00', '2026-05-06 04:00:00'),
(14, 14, 'vnpay', 'paid', 10860000.00, 'VNPAY2026050014', '2026-05-06 04:20:00', '2026-05-06 04:15:00'),
(15, 15, 'momo', 'refunded', 8611000.00, 'MOMO2026050015', '2026-05-06 04:35:00', '2026-05-06 04:30:00'),
(16, 16, 'bank_transfer', 'paid', 39210000.00, 'BANK2026050016', '2026-05-06 04:50:00', '2026-05-06 04:45:00'),
(17, 17, 'cod', 'unpaid', 10060000.00, NULL, NULL, '2026-05-06 05:00:00'),
(18, 18, 'momo', 'paid', 17910000.00, 'MOMO2026050018', '2026-05-07 01:05:00', '2026-05-07 01:00:00'),
(19, 19, 'cod', 'unpaid', 17800000.00, NULL, NULL, '2026-05-07 01:15:00'),
(20, 20, 'vnpay', 'paid', 13010000.00, 'VNPAY2026050020', '2026-05-07 01:35:00', '2026-05-07 01:30:00'),
(21, 21, 'momo', 'paid', 6960000.00, 'MOMO2026050021', '2026-05-07 01:50:00', '2026-05-07 01:45:00'),
(22, 22, 'bank_transfer', 'paid', 32110000.00, 'BANK2026050022', '2026-05-07 02:05:00', '2026-05-07 02:00:00'),
(23, 23, 'vnpay', 'failed', 4900000.00, 'VNPAY2026050023', NULL, '2026-05-07 02:15:00'),
(24, 24, 'momo', 'paid', 1270000.00, 'MOMO2026050024', '2026-05-07 02:35:00', '2026-05-07 02:30:00'),
(25, 25, 'bank_transfer', 'paid', 29100000.00, 'BANK2026050025', '2026-05-07 02:50:00', '2026-05-07 02:45:00'),
(26, 26, 'momo', 'paid', 4910000.00, 'MOMO2026050026', '2026-05-07 03:05:00', '2026-05-07 03:00:00'),
(27, 27, 'vnpay', 'paid', 9550000.00, 'VNPAY2026050027', '2026-05-07 03:20:00', '2026-05-07 03:15:00'),
(28, 28, 'cod', 'unpaid', 10560000.00, NULL, NULL, '2026-05-07 03:30:00'),
(29, 29, 'bank_transfer', 'paid', 31520000.00, 'BANK2026050029', '2026-05-07 03:50:00', '2026-05-07 03:45:00'),
(30, 30, 'cod', 'unpaid', 2160000.00, NULL, NULL, '2026-05-07 04:00:00'),
(33, 33, 'cod', 'unpaid', 15460000.00, NULL, NULL, '2026-05-22 14:02:33'),
(34, 34, 'cod', 'unpaid', 8490000.00, NULL, NULL, '2026-05-22 14:19:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'Xem dashboard', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(2, 'users.view', 'Xem tài khoản user', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(3, 'users.create', 'Tạo tài khoản user', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(4, 'users.update', 'Cập nhật tài khoản user', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(5, 'users.delete', 'Xóa tài khoản user', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(6, 'roles.manage', 'Quản lý vai trò và phân quyền', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(7, 'categories.manage', 'Quản lý danh mục', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(8, 'brands.manage', 'Quản lý thương hiệu', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(9, 'products.view', 'Xem sản phẩm', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(10, 'products.create', 'Thêm sản phẩm', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(11, 'products.update', 'Sửa sản phẩm', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(12, 'products.delete', 'Xóa sản phẩm', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(13, 'orders.view', 'Xem đơn hàng', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(14, 'orders.update', 'Cập nhật đơn hàng', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(15, 'payments.view', 'Xem thanh toán', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(16, 'coupons.manage', 'Quản lý mã giảm giá', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(17, 'banners.manage', 'Quản lý banner', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(18, 'news.manage', 'Quản lý bài viết', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(19, 'reviews.manage', 'Quản lý đánh giá', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(20, 'contacts.view', 'Xem liên hệ khách hàng', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(21, 'reports.view', 'Xem báo cáo', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(22, 'inventory.update', 'Cập nhật tồn kho', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(23, 'profile.update', 'Cập nhật hồ sơ cá nhân', '2026-05-22 16:57:08', '2026-05-22 16:57:08'),
(24, 'cart.checkout', 'Thanh toán giỏ hàng', '2026-05-22 16:57:08', '2026-05-22 16:57:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `price_alerts`
--

CREATE TABLE `price_alerts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `target_price` decimal(15,2) DEFAULT NULL,
  `status` enum('active','notified','cancelled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `price_alerts`
--

INSERT INTO `price_alerts` (`id`, `user_id`, `product_id`, `email`, `target_price`, `status`, `created_at`, `notified_at`) VALUES
(1, 4, 3, 'minhanh@example.com', 23841000.00, 'active', '2026-05-18 02:30:00', NULL),
(2, 5, 5, 'hoangnam@example.com', 7371000.00, 'active', '2026-05-18 02:30:00', NULL),
(3, 6, 7, 'thuha@example.com', 29691000.00, 'active', '2026-05-18 02:30:00', NULL),
(4, 7, 9, 'quanghuy@example.com', 28791000.00, 'active', '2026-05-18 02:30:00', NULL),
(5, 8, 11, 'baongoc@example.com', 13941000.00, 'notified', '2026-05-18 02:30:00', '2026-05-18 03:30:00'),
(6, 9, 13, 'giabao@example.com', 16191000.00, 'active', '2026-05-18 02:30:00', NULL),
(7, 10, 15, 'lanchi@example.com', 5301000.00, 'active', '2026-05-18 02:30:00', NULL),
(8, 11, 17, 'tuankiet@example.com', 2691000.00, 'active', '2026-05-18 02:30:00', NULL),
(9, 12, 19, 'phuonglinh@example.com', 2331000.00, 'active', '2026-05-18 02:30:00', NULL),
(10, 13, 21, 'khanhvy@example.com', 2871000.00, 'notified', '2026-05-18 02:30:00', '2026-05-18 03:30:00'),
(11, 14, 23, 'minhquan@example.com', 6291000.00, 'active', '2026-05-18 02:30:00', NULL),
(12, 15, 25, 'anhduc@example.com', 11241000.00, 'active', '2026-05-18 02:30:00', NULL),
(13, 16, 27, 'thanhtam@example.com', 1341000.00, 'active', '2026-05-18 02:30:00', NULL),
(14, 17, 29, 'nhatminh@example.com', 3951000.00, 'active', '2026-05-18 02:30:00', NULL),
(15, 18, 31, 'ngocdiep@example.com', 3771000.00, 'notified', '2026-05-18 02:30:00', '2026-05-18 03:30:00'),
(16, 19, 33, 'quocbao@example.com', 2961000.00, 'active', '2026-05-18 02:30:00', NULL),
(17, 20, 35, 'haiyen@example.com', 2691000.00, 'active', '2026-05-18 02:30:00', NULL),
(18, 21, 37, 'warehouse@techshop.test', 531000.00, 'active', '2026-05-18 02:30:00', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `import_price` decimal(15,2) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `warranty_months` int(11) DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','out_of_stock') DEFAULT 'active',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_free_shipping` tinyint(1) DEFAULT 0,
  `sold_count` int(11) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `sku`, `short_description`, `description`, `import_price`, `price`, `sale_price`, `quantity`, `warranty_months`, `thumbnail`, `status`, `is_featured`, `is_free_shipping`, `sold_count`, `view_count`, `created_at`, `updated_at`) VALUES
(1, 14, 1, 'iPhone 15 Pro 256GB', 'iphone-15-pro-256gb', 'IP15P-256', 'A17 Pro, 256GB, titanium body.', 'Premium iPhone with strong camera and performance for daily work and content creation.', 22000000.00, 28990000.00, 27490000.00, 45, 12, 'template/images/product/iphone/iphone-15-pro-256gb.webp', 'active', 1, 1, 0, 107, '2026-05-03 01:00:00', '2026-05-17 19:42:38'),
(2, 14, 1, 'iPhone 15 128GB', 'iphone-15-128gb', 'IP15-128', 'Dynamic Island and 48MP camera.', 'Balanced iPhone model for users who need camera quality and stable performance.', 16500000.00, 21990000.00, 20990000.00, 60, 12, 'template/images/product/iphone/iphone-15-128gb.jpg', 'active', 1, 1, 1, 114, '2026-05-03 01:02:00', '2026-05-17 19:42:38'),
(3, 13, 2, 'Samsung Galaxy S24 Ultra', 'samsung-galaxy-s24-ultra', 'SGS24U-256', 'Flagship Android phone with S Pen.', 'Large display, strong zoom camera and premium Android experience.', 21000000.00, 27990000.00, 26490000.00, 36, 12, 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 'active', 1, 1, 1, 121, '2026-05-03 01:04:00', '2026-05-17 19:42:38'),
(4, 13, 15, 'Xiaomi 14 5G', 'xiaomi-14-5g', 'XM14-256', 'Compact flagship with fast charging.', 'High performance Android phone for gaming and photography.', 12500000.00, 16990000.00, 15990000.00, 52, 12, 'template/images/product/android-phone/xiaomi-14-5g.jpg', 'active', 1, 1, 1, 128, '2026-05-03 01:06:00', '2026-05-17 19:42:38'),
(5, 13, 16, 'Oppo Reno 11F 5G', 'oppo-reno-11f-5g', 'OPR11F-256', 'Slim phone with AMOLED display.', 'Stylish mid-range smartphone for photo and social media users.', 5600000.00, 8990000.00, 8190000.00, 70, 12, 'template/images/product/android-phone/oppo-reno-11f-5g.webp', 'active', 0, 1, 1, 135, '2026-05-03 01:08:00', '2026-05-17 19:42:38'),
(6, 12, 1, 'MacBook Air M3 13 inch', 'macbook-air-m3-13-inch', 'MBA-M3-13', 'M3 chip, 8GB RAM, 256GB SSD.', 'Thin and light laptop for office, study and creative tasks.', 22500000.00, 28990000.00, 27990000.00, 28, 12, 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 'active', 1, 1, 2, 142, '2026-05-03 01:10:00', '2026-05-17 19:42:38'),
(7, 11, 4, 'Asus ROG Strix G16', 'asus-rog-strix-g16', 'ROG-G16-I7', 'Core i7, RTX 4060, 16GB RAM.', 'Gaming laptop with high refresh display and powerful GPU.', 26500000.00, 34990000.00, 32990000.00, 18, 24, 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 'active', 1, 1, 2, 149, '2026-05-03 01:12:00', '2026-05-17 19:42:38'),
(8, 11, 8, 'MSI Katana 15 B13V', 'msi-katana-15-b13v', 'MSI-K15-B13V', 'Core i7, RTX 4050, 144Hz display.', 'Gaming laptop for esports and graphics work.', 20500000.00, 27990000.00, 25990000.00, 22, 24, 'template/images/product/gaming-laptop/msi-katana-15-b13v.png', 'active', 1, 1, 1, 156, '2026-05-03 01:14:00', '2026-05-17 19:42:38'),
(9, 12, 3, 'Dell XPS 13 Plus', 'dell-xps-13-plus', 'DXPS13P-512', 'Premium ultrabook with 512GB SSD.', 'Compact laptop with modern design and vivid display.', 26000000.00, 33990000.00, 31990000.00, 14, 12, 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 'active', 1, 1, 1, 163, '2026-05-03 01:16:00', '2026-05-17 19:42:38'),
(10, 12, 7, 'Lenovo IdeaPad Slim 5', 'lenovo-ideapad-slim-5', 'LNV-S5-R7', 'Ryzen 7, 16GB RAM, 512GB SSD.', 'Reliable thin laptop for students and office users.', 13500000.00, 18990000.00, 17490000.00, 40, 12, 'template/images/product/ultrabook/lenovo-ideapad-slim-5.png', 'active', 0, 1, 1, 170, '2026-05-03 01:18:00', '2026-05-17 19:42:38'),
(11, 1, 6, 'HP Pavilion 15', 'hp-pavilion-15', 'HP-PAV15-I5', 'Core i5, 16GB RAM, 512GB SSD.', 'All-round laptop for study, office and entertainment.', 12000000.00, 16990000.00, 15490000.00, 31, 12, 'template/images/product/laptop/hp-pavilion-15.jpg', 'active', 0, 1, 1, 177, '2026-05-03 01:20:00', '2026-05-17 19:42:38'),
(12, 1, 5, 'Acer Aspire 7', 'acer-aspire-7', 'AC-A7-R5', 'Ryzen 5, GTX 1650, 512GB SSD.', 'Affordable laptop for light gaming and technical study.', 11000000.00, 15990000.00, 14990000.00, 26, 12, 'template/images/product/laptop/acer-aspire-7.jpg', 'active', 0, 1, 1, 184, '2026-05-03 01:22:00', '2026-05-22 16:58:04'),
(13, 3, 1, 'iPad Air M2 11 inch', 'ipad-air-m2-11-inch', 'IPAD-AIR-M2', 'M2 chip with Liquid Retina display.', 'Powerful tablet for note taking, drawing and media.', 14500000.00, 18990000.00, 17990000.00, 34, 12, 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 'active', 1, 1, 1, 191, '2026-05-03 01:24:00', '2026-05-17 19:42:38'),
(14, 3, 2, 'Samsung Galaxy Tab S9 FE', 'samsung-galaxy-tab-s9-fe', 'TAB-S9FE', '10.9 inch display with S Pen.', 'Android tablet for learning and entertainment.', 7500000.00, 10990000.00, 9990000.00, 39, 12, 'template/images/product/tablet/samsung-galaxy-tab-s9-fe.jpg', 'active', 0, 1, 1, 198, '2026-05-03 01:26:00', '2026-05-17 19:42:38'),
(15, 15, 1, 'AirPods Pro 2 USB-C', 'airpods-pro-2-usb-c', 'APP2-USBC', 'Noise cancellation wireless earbuds.', 'Compact earbuds with spatial audio and strong ANC.', 4200000.00, 6490000.00, 5890000.00, 79, 12, 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 'active', 1, 1, 2, 205, '2026-05-03 01:28:00', '2026-05-22 21:02:33'),
(16, 15, 10, 'Sony WH-1000XM5', 'sony-wh-1000xm5', 'SONY-XM5', 'Premium ANC over-ear headphones.', 'Comfortable headphones for travel, work and music.', 6200000.00, 8990000.00, 7990000.00, 41, 12, 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 'active', 1, 1, 2, 212, '2026-05-03 01:30:00', '2026-05-22 21:02:33'),
(17, 16, 18, 'JBL Charge 5', 'jbl-charge-5', 'JBL-CHG5', 'Portable waterproof speaker.', 'Powerful sound with long battery life for outdoor use.', 2100000.00, 3490000.00, 2990000.00, 55, 12, 'template/images/product/speaker/jbl-charge-5.jpg', 'active', 0, 1, 2, 219, '2026-05-03 01:32:00', '2026-05-17 19:42:38'),
(18, 4, 18, 'JBL Quantum 100', 'jbl-quantum-100', 'JBL-Q100', 'Wired gaming headset.', 'Entry gaming headset with clear microphone.', 450000.00, 790000.00, 690000.00, 90, 12, 'template/images/product/audio/jbl-quantum-100.png', 'active', 0, 0, 2, 226, '2026-05-03 01:34:00', '2026-05-17 19:42:38'),
(19, 17, 11, 'Logitech MX Keys S', 'logitech-mx-keys-s', 'LOG-MXKS', 'Wireless productivity keyboard.', 'Quiet backlit keyboard for office and creative work.', 1900000.00, 2990000.00, 2590000.00, 44, 12, 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 'active', 1, 1, 2, 233, '2026-05-03 01:36:00', '2026-05-17 19:42:38'),
(20, 17, 12, 'Razer BlackWidow V4', 'razer-blackwidow-v4', 'RZ-BWV4', 'Mechanical gaming keyboard.', 'RGB mechanical keyboard with fast switches.', 2500000.00, 3990000.00, 3490000.00, 25, 12, 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 'active', 1, 1, 1, 240, '2026-05-03 01:38:00', '2026-05-17 19:42:38'),
(21, 18, 11, 'Logitech G Pro X Superlight', 'logitech-g-pro-x-superlight', 'LOG-GPX-SL', 'Lightweight wireless gaming mouse.', 'High performance wireless mouse for competitive gaming.', 2200000.00, 3490000.00, 3190000.00, 38, 12, 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 'active', 1, 1, 0, 247, '2026-05-03 01:40:00', '2026-05-17 19:42:38'),
(22, 18, 12, 'Razer DeathAdder V3', 'razer-deathadder-v3', 'RZ-DAV3', 'Ergonomic wired gaming mouse.', 'Fast sensor and comfortable shape for FPS games.', 950000.00, 1690000.00, 1490000.00, 50, 12, 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg', 'active', 0, 0, 1, 254, '2026-05-03 01:42:00', '2026-05-17 19:42:38'),
(23, 7, 9, 'LG UltraGear 27GP850', 'lg-ultragear-27gp850', 'LG-27GP850', '27 inch QHD 165Hz gaming monitor.', 'Fast IPS gaming monitor with vivid colors.', 5200000.00, 7990000.00, 6990000.00, 20, 24, 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 'active', 1, 1, 2, 261, '2026-05-03 01:44:00', '2026-05-17 19:42:38'),
(24, 7, 2, 'Samsung Odyssey G5 27', 'samsung-odyssey-g5-27', 'SS-ODG5-27', 'Curved QHD gaming monitor.', 'Immersive curved monitor for gaming and multimedia.', 4300000.00, 6490000.00, 5990000.00, 18, 24, 'template/images/product/monitor/samsung-odyssey-g5-27.jpg', 'active', 0, 1, 1, 268, '2026-05-03 01:46:00', '2026-05-17 19:42:38'),
(25, 7, 3, 'Dell UltraSharp U2723QE', 'dell-ultrasharp-u2723qe', 'DL-U2723QE', '27 inch 4K USB-C monitor.', 'Professional monitor with accurate color and USB-C hub.', 9500000.00, 13490000.00, 12490000.00, 12, 36, 'template/images/product/monitor/dell-ultrasharp-u2723qe.jpg', 'active', 1, 1, 1, 275, '2026-05-03 01:48:00', '2026-05-17 19:42:38'),
(26, 19, 13, 'Kingston NV2 1TB', 'kingston-nv2-1tb', 'KS-NV2-1TB', 'NVMe PCIe 4.0 SSD.', 'Fast SSD upgrade for laptop and desktop.', 950000.00, 1590000.00, 1390000.00, 120, 36, 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 'active', 0, 0, 3, 282, '2026-05-03 01:50:00', '2026-05-17 19:42:38'),
(27, 19, 14, 'Corsair Vengeance 16GB DDR5', 'corsair-vengeance-16gb-ddr5', 'COR-DDR5-16', '16GB DDR5 5600MHz RAM.', 'Memory upgrade for modern desktops.', 950000.00, 1690000.00, 1490000.00, 85, 36, 'template/images/product/ssd-and-ram/corsair-vengeance-16gb-ddr5.jpg', 'active', 0, 0, 4, 289, '2026-05-03 01:52:00', '2026-05-17 19:42:38'),
(28, 8, 20, 'Gigabyte RTX 4060 Eagle OC', 'gigabyte-rtx-4060-eagle-oc', 'GB-RTX4060-EOC', '8GB GDDR6 graphics card.', 'Efficient GPU for 1080p and 1440p gaming.', 6300000.00, 8990000.00, 8490000.00, 15, 36, 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 'active', 1, 1, 2, 296, '2026-05-03 01:54:00', '2026-05-22 21:19:20'),
(29, 8, 4, 'Asus TUF B650M Plus', 'asus-tuf-b650m-plus', 'AS-TUF-B650M', 'AM5 motherboard with DDR5.', 'Durable motherboard for Ryzen desktop builds.', 3100000.00, 4790000.00, 4390000.00, 24, 36, 'template/images/product/pc-components/asus-tuf-b650m-plus.png', 'active', 0, 1, 1, 303, '2026-05-03 01:56:00', '2026-05-17 19:42:38'),
(30, 20, 19, 'TP-Link Archer AX55', 'tp-link-archer-ax55', 'TPL-AX55', 'Wi-Fi 6 router AX3000.', 'Fast home router with strong coverage.', 1400000.00, 2390000.00, 1990000.00, 64, 24, 'template/images/product/router/tp-link-archer-ax55.jpg', 'active', 1, 0, 3, 310, '2026-05-03 01:58:00', '2026-05-17 19:42:38'),
(31, 20, 19, 'TP-Link Deco X20 2-Pack', 'tp-link-deco-x20-2-pack', 'TPL-DECO-X20', 'Mesh Wi-Fi 6 system.', 'Whole-home mesh system for stable network coverage.', 2900000.00, 4590000.00, 4190000.00, 28, 24, 'template/images/product/router/tp-link-deco-x20-2-pack.jpg', 'active', 0, 1, 1, 317, '2026-05-03 02:00:00', '2026-05-17 19:42:38'),
(32, 10, 15, 'Xiaomi Smart Camera C300', 'xiaomi-smart-camera-c300', 'XM-CAM-C300', '2K smart home camera.', 'Indoor security camera with app control.', 650000.00, 1090000.00, 990000.00, 76, 12, 'template/images/product/smart-home/xiaomi-smart-camera-c300.png', 'active', 0, 0, 3, 324, '2026-05-03 02:02:00', '2026-05-17 19:42:38'),
(33, 10, 17, 'Anker 737 Power Bank', 'anker-737-power-bank', 'ANK-737-PB', '24,000mAh fast charging power bank.', 'High capacity power bank for laptops and phones.', 2300000.00, 3690000.00, 3290000.00, 33, 18, 'template/images/product/smart-home/anker-737-power-bank.jpg', 'active', 1, 1, 2, 331, '2026-05-03 02:04:00', '2026-05-17 19:42:38'),
(34, 10, 17, 'Anker Nano 65W Charger', 'anker-nano-65w-charger', 'ANK-NANO-65W', 'Compact GaN USB-C charger.', 'Fast charger for phone, tablet and laptop.', 520000.00, 890000.00, 790000.00, 93, 18, 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 'active', 0, 0, 11, 338, '2026-05-03 02:06:00', '2026-05-22 21:02:33'),
(35, 4, 11, 'Logitech Blue Yeti', 'logitech-blue-yeti', 'LOG-BYETI', 'USB condenser microphone.', 'Popular USB microphone for streaming and recording.', 2100000.00, 3490000.00, 2990000.00, 21, 12, 'template/images/product/audio/logitech-blue-yeti.jpg', 'active', 0, 1, 3, 345, '2026-05-03 02:08:00', '2026-05-17 19:42:38'),
(36, 5, 11, 'Logitech K380 Multi Device', 'logitech-k380-multi-device', 'LOG-K380', 'Compact Bluetooth keyboard.', 'Portable keyboard for laptop, tablet and phone.', 420000.00, 790000.00, 690000.00, 100, 12, 'template/images/product/keyboard/logitech-k380-multi-device.jpg', 'active', 0, 0, 3, 352, '2026-05-03 02:10:00', '2026-05-17 19:42:38'),
(37, 6, 11, 'Logitech M650 Signature', 'logitech-m650-signature', 'LOG-M650', 'Silent wireless mouse.', 'Comfortable wireless mouse for everyday work.', 360000.00, 690000.00, 590000.00, 110, 12, 'template/images/product/mouse/logitech-m650-signature.webp', 'active', 0, 0, 5, 359, '2026-05-03 02:12:00', '2026-05-17 19:42:38'),
(38, 15, 18, 'JBL Tune Flex', 'jbl-tune-flex', 'JBL-TFLEX', 'True wireless earbuds.', 'Wireless earbuds with app EQ and active noise control.', 1450000.00, 2490000.00, 2190000.00, 48, 12, 'template/images/product/bluetooth-headphone/jbl-tune-flex.png', 'active', 0, 1, 2, 366, '2026-05-03 02:14:00', '2026-05-17 19:42:38'),
(39, 11, 7, 'Lenovo Legion 5 Pro', 'lenovo-legion-5-pro', 'LNV-L5P-R7', 'Ryzen 7, RTX 4070, 16 inch display.', 'Powerful gaming laptop with high resolution display.', 32500000.00, 42990000.00, 39990000.00, 10, 24, 'template/images/product/gaming-laptop/lenovo-legion-5-pro.jpg', 'active', 1, 1, 1, 373, '2026-05-03 02:16:00', '2026-05-17 19:42:38'),
(40, 8, 14, 'Corsair RM750e PSU', 'corsair-rm750e-psu', 'COR-RM750E', '750W 80 Plus Gold power supply.', 'Reliable modular PSU for gaming PC builds.', 1900000.00, 2990000.00, 2690000.00, 30, 60, 'template/images/product/pc-components/corsair-rm750e-psu.jpg', 'active', 0, 1, 2, 380, '2026-05-03 02:18:00', '2026-05-17 19:42:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_main`, `sort_order`, `created_at`) VALUES
(1, 1, 'template/images/product/iphone/iphone-15-pro-256gb.webp', 1, 1, '2026-05-18 03:00:00'),
(2, 2, 'template/images/product/iphone/iphone-15-128gb.jpg', 1, 1, '2026-05-18 03:00:00'),
(3, 3, 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 1, 1, '2026-05-18 03:00:00'),
(4, 4, 'template/images/product/android-phone/xiaomi-14-5g.jpg', 1, 1, '2026-05-18 03:00:00'),
(5, 5, 'template/images/product/android-phone/oppo-reno-11f-5g.webp', 1, 1, '2026-05-18 03:00:00'),
(6, 6, 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 1, 1, '2026-05-18 03:00:00'),
(7, 7, 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 1, 1, '2026-05-18 03:00:00'),
(8, 8, 'template/images/product/gaming-laptop/msi-katana-15-b13v.png', 1, 1, '2026-05-18 03:00:00'),
(9, 9, 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 1, 1, '2026-05-18 03:00:00'),
(10, 10, 'template/images/product/ultrabook/lenovo-ideapad-slim-5.png', 1, 1, '2026-05-18 03:00:00'),
(11, 11, 'template/images/product/laptop/hp-pavilion-15.jpg', 1, 1, '2026-05-18 03:00:00'),
(13, 13, 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 1, 1, '2026-05-18 03:00:00'),
(14, 14, 'template/images/product/tablet/samsung-galaxy-tab-s9-fe.jpg', 1, 1, '2026-05-18 03:00:00'),
(15, 15, 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 1, 1, '2026-05-18 03:00:00'),
(16, 16, 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 1, 1, '2026-05-18 03:00:00'),
(17, 17, 'template/images/product/speaker/jbl-charge-5.jpg', 1, 1, '2026-05-18 03:00:00'),
(18, 18, 'template/images/product/audio/jbl-quantum-100.png', 1, 1, '2026-05-18 03:00:00'),
(19, 19, 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 1, 1, '2026-05-18 03:00:00'),
(20, 20, 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 1, 1, '2026-05-18 03:00:00'),
(21, 21, 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 1, 1, '2026-05-18 03:00:00'),
(22, 22, 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg', 1, 1, '2026-05-18 03:00:00'),
(23, 23, 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 1, 1, '2026-05-18 03:00:00'),
(24, 24, 'template/images/product/monitor/samsung-odyssey-g5-27.jpg', 1, 1, '2026-05-18 03:00:00'),
(25, 25, 'template/images/product/monitor/dell-ultrasharp-u2723qe.jpg', 1, 1, '2026-05-18 03:00:00'),
(26, 26, 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 1, 1, '2026-05-18 03:00:00'),
(27, 27, 'template/images/product/ssd-and-ram/corsair-vengeance-16gb-ddr5.jpg', 1, 1, '2026-05-18 03:00:00'),
(28, 28, 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 1, 1, '2026-05-18 03:00:00'),
(29, 29, 'template/images/product/pc-components/asus-tuf-b650m-plus.png', 1, 1, '2026-05-18 03:00:00'),
(30, 30, 'template/images/product/router/tp-link-archer-ax55.jpg', 1, 1, '2026-05-18 03:00:00'),
(31, 31, 'template/images/product/router/tp-link-deco-x20-2-pack.jpg', 1, 1, '2026-05-18 03:00:00'),
(32, 32, 'template/images/product/smart-home/xiaomi-smart-camera-c300.png', 1, 1, '2026-05-18 03:00:00'),
(33, 33, 'template/images/product/smart-home/anker-737-power-bank.jpg', 1, 1, '2026-05-18 03:00:00'),
(34, 34, 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 1, 1, '2026-05-18 03:00:00'),
(35, 35, 'template/images/product/audio/logitech-blue-yeti.jpg', 1, 1, '2026-05-18 03:00:00'),
(36, 36, 'template/images/product/keyboard/logitech-k380-multi-device.jpg', 1, 1, '2026-05-18 03:00:00'),
(37, 37, 'template/images/product/mouse/logitech-m650-signature.webp', 1, 1, '2026-05-18 03:00:00'),
(38, 38, 'template/images/product/bluetooth-headphone/jbl-tune-flex.png', 1, 1, '2026-05-18 03:00:00'),
(39, 39, 'template/images/product/gaming-laptop/lenovo-legion-5-pro.jpg', 1, 1, '2026-05-18 03:00:00'),
(40, 40, 'template/images/product/pc-components/corsair-rm750e-psu.jpg', 1, 1, '2026-05-18 03:00:00'),
(41, 12, 'template/images/product/laptop/acer-aspire-7.jpg', 1, 1, '2026-05-22 16:58:04'),
(42, 12, 'template/images/uploads/products/sleekshot-2026-05-23-06-47-37-20260522235804-nw7tlfch.png', 0, 2, '2026-05-22 16:58:04'),
(43, 12, 'template/images/uploads/products/sleekshot-2026-05-23-04-09-17-20260522235804-pf4jb1ai.png', 0, 3, '2026-05-22 16:58:04'),
(44, 12, 'template/images/uploads/products/sleekshot-2026-05-23-04-08-49-20260522235804-xna8jnx7.png', 0, 4, '2026-05-22 16:58:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `spec_name` varchar(255) NOT NULL,
  `spec_value` text NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `spec_name`, `spec_value`, `sort_order`) VALUES
(1, 1, 'Storage', '256GB', 1),
(2, 1, 'Warranty', '12 months', 2),
(3, 2, 'Storage', '128GB', 1),
(4, 2, 'Camera', '48MP main camera', 2),
(5, 3, 'Display', '6.8 inch AMOLED', 1),
(6, 3, 'Feature', 'S Pen included', 2),
(7, 4, 'Chipset', 'Snapdragon 8 Gen 3', 1),
(8, 4, 'Charging', '90W fast charging', 2),
(9, 5, 'Display', 'AMOLED 120Hz', 1),
(10, 5, 'Network', '5G', 2),
(11, 6, 'Chip', 'Apple M3', 1),
(12, 6, 'Weight', '1.24kg', 2),
(13, 7, 'GPU', 'NVIDIA RTX 4060', 1),
(14, 7, 'Refresh Rate', '165Hz', 2),
(15, 8, 'GPU', 'NVIDIA RTX 4050', 1),
(16, 8, 'RAM', '16GB DDR5', 2),
(17, 9, 'Display', '13.4 inch', 1),
(18, 9, 'Storage', '512GB SSD', 2),
(19, 10, 'CPU', 'Ryzen 7', 1),
(20, 10, 'RAM', '16GB', 2),
(21, 11, 'CPU', 'Intel Core i5', 1),
(22, 11, 'Storage', '512GB SSD', 2),
(23, 12, 'GPU', 'GTX 1650', 1),
(24, 12, 'Storage', '512GB SSD', 2),
(25, 13, 'Chip', 'Apple M2', 1),
(26, 13, 'Screen', '11 inch', 2),
(27, 14, 'Screen', '10.9 inch', 1),
(28, 14, 'Pen', 'S Pen included', 2),
(29, 15, 'Connection', 'Bluetooth', 1),
(30, 15, 'Feature', 'Active noise cancellation', 2),
(31, 16, 'Battery', 'Up to 30 hours', 1),
(32, 16, 'Feature', 'Adaptive noise canceling', 2),
(33, 17, 'Battery', 'Up to 20 hours', 1),
(34, 17, 'Waterproof', 'IP67', 2),
(35, 18, 'Connector', '3.5mm', 1),
(36, 18, 'Microphone', 'Detachable boom mic', 2),
(37, 19, 'Layout', 'Full size', 1),
(38, 19, 'Connection', 'Bluetooth and USB receiver', 2),
(39, 20, 'Switch', 'Mechanical green switch', 1),
(40, 20, 'Lighting', 'RGB', 2),
(41, 21, 'Weight', '63g', 1),
(42, 21, 'Sensor', 'HERO sensor', 2),
(43, 22, 'DPI', '30000 DPI', 1),
(44, 22, 'Connection', 'USB', 2),
(45, 23, 'Resolution', 'QHD 2560x1440', 1),
(46, 23, 'Refresh Rate', '165Hz', 2),
(47, 24, 'Resolution', 'QHD 2560x1440', 1),
(48, 24, 'Panel', 'Curved VA', 2),
(49, 25, 'Resolution', '4K UHD', 1),
(50, 25, 'Port', 'USB-C hub', 2),
(51, 26, 'Capacity', '1TB', 1),
(52, 26, 'Interface', 'NVMe PCIe 4.0', 2),
(53, 27, 'Capacity', '16GB', 1),
(54, 27, 'Bus', '5600MHz', 2),
(55, 28, 'VRAM', '8GB GDDR6', 1),
(56, 28, 'Output', 'HDMI and DisplayPort', 2),
(57, 29, 'Socket', 'AM5', 1),
(58, 29, 'Memory', 'DDR5', 2),
(59, 30, 'Wi-Fi', 'Wi-Fi 6 AX3000', 1),
(60, 30, 'Ports', 'Gigabit LAN', 2),
(61, 31, 'Wi-Fi', 'Mesh Wi-Fi 6', 1),
(62, 31, 'Pack', '2 units', 2),
(63, 32, 'Resolution', '2K', 1),
(64, 32, 'Feature', 'Night vision', 2),
(65, 33, 'Capacity', '24000mAh', 1),
(66, 33, 'Power', '140W output', 2),
(67, 34, 'Power', '65W', 1),
(68, 34, 'Port', 'USB-C', 2),
(69, 35, 'Connection', 'USB', 1),
(70, 35, 'Pattern', 'Multiple pickup patterns', 2),
(71, 36, 'Connection', 'Bluetooth', 1),
(72, 36, 'Battery', 'Up to 24 months', 2),
(73, 37, 'Connection', 'Wireless receiver and Bluetooth', 1),
(74, 37, 'Feature', 'Silent click', 2),
(75, 38, 'Connection', 'Bluetooth', 1),
(76, 38, 'Feature', 'App EQ', 2),
(77, 39, 'GPU', 'NVIDIA RTX 4070', 1),
(78, 39, 'Screen', '16 inch QHD', 2),
(79, 40, 'Power', '750W', 1),
(80, 40, 'Efficiency', '80 Plus Gold', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(120) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size_label` varchar(50) DEFAULT NULL,
  `storage_label` varchar(50) DEFAULT NULL,
  `price_adjustment` decimal(15,2) DEFAULT 0.00,
  `stock_quantity` int(11) DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','out_of_stock') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `color`, `size_label`, `storage_label`, `price_adjustment`, `stock_quantity`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'IP15P-256-BLA', 'Black', NULL, '256GB', 0.00, 22, 'template/images/product/iphone/iphone-15-pro-256gb.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(2, 1, 'IP15P-256-SIL', 'Silver', NULL, '256GB', 150000.00, 15, 'template/images/product/iphone/iphone-15-pro-256gb.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(3, 2, 'IP15-128-SIL', 'Silver', NULL, '128GB', 0.00, 30, 'template/images/product/iphone/iphone-15-128gb.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(4, 2, 'IP15-128-BLU', 'Blue', NULL, '128GB', 150000.00, 20, 'template/images/product/iphone/iphone-15-128gb.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(5, 3, 'SGS24U-256-BLU', 'Blue', NULL, NULL, 0.00, 18, 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(6, 3, 'SGS24U-256-WHI', 'White', NULL, NULL, 150000.00, 12, 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(7, 4, 'XM14-256-WHI', 'White', NULL, NULL, 0.00, 26, 'template/images/product/android-phone/xiaomi-14-5g.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(8, 4, 'XM14-256-GRA', 'Gray', NULL, NULL, 150000.00, 17, 'template/images/product/android-phone/xiaomi-14-5g.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(9, 5, 'OPR11F-256-GRA', 'Gray', NULL, NULL, 0.00, 35, 'template/images/product/android-phone/oppo-reno-11f-5g.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(10, 5, 'OPR11F-256-TIT', 'Titanium', NULL, NULL, 150000.00, 23, 'template/images/product/android-phone/oppo-reno-11f-5g.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(11, 6, 'MBA-M3-13-TIT', 'Titanium', '13 inch', NULL, 0.00, 14, 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(12, 6, 'MBA-M3-13-GRA', 'Graphite', '13 inch', NULL, 150000.00, 9, 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(13, 7, 'ROG-G16-I7-GRA', 'Graphite', NULL, NULL, 0.00, 9, 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(14, 7, 'ROG-G16-I7-RED', 'Red', NULL, NULL, 150000.00, 6, 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(15, 8, 'MSI-K15-B13V-RED', 'Red', NULL, NULL, 0.00, 11, 'template/images/product/gaming-laptop/msi-katana-15-b13v.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(16, 8, 'MSI-K15-B13V-BLA', 'Black', NULL, NULL, 150000.00, 7, 'template/images/product/gaming-laptop/msi-katana-15-b13v.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(17, 9, 'DXPS13P-512-BLA', 'Black', NULL, NULL, 0.00, 7, 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(18, 9, 'DXPS13P-512-SIL', 'Silver', NULL, NULL, 150000.00, 4, 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(19, 10, 'LNV-S5-R7-SIL', 'Silver', NULL, NULL, 0.00, 20, 'template/images/product/ultrabook/lenovo-ideapad-slim-5.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(20, 10, 'LNV-S5-R7-BLU', 'Blue', NULL, NULL, 150000.00, 13, 'template/images/product/ultrabook/lenovo-ideapad-slim-5.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(21, 11, 'HP-PAV15-I5-BLU', 'Blue', NULL, NULL, 0.00, 15, 'template/images/product/laptop/hp-pavilion-15.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(22, 11, 'HP-PAV15-I5-WHI', 'White', NULL, NULL, 150000.00, 10, 'template/images/product/laptop/hp-pavilion-15.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(23, 12, 'AC-A7-R5-WHI', 'White', NULL, NULL, 0.00, 13, 'template/images/product/laptop/acer-aspire-7.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(24, 12, 'AC-A7-R5-GRA', 'Gray', NULL, NULL, 150000.00, 8, 'template/images/product/laptop/acer-aspire-7.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(25, 13, 'IPAD-AIR-M2-GRA', 'Gray', '11 inch', NULL, 0.00, 17, 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(26, 13, 'IPAD-AIR-M2-TIT', 'Titanium', '11 inch', NULL, 150000.00, 11, 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(27, 14, 'TAB-S9FE-TIT', 'Titanium', NULL, NULL, 0.00, 19, 'template/images/product/tablet/samsung-galaxy-tab-s9-fe.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(28, 14, 'TAB-S9FE-GRA', 'Graphite', NULL, NULL, 150000.00, 13, 'template/images/product/tablet/samsung-galaxy-tab-s9-fe.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(29, 15, 'APP2-USBC-GRA', 'Graphite', NULL, NULL, 0.00, 39, 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 'active', '2026-05-18 02:00:00', '2026-05-22 21:02:33'),
(30, 15, 'APP2-USBC-RED', 'Red', NULL, NULL, 150000.00, 26, 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(31, 16, 'SONY-XM5-RED', 'Red', NULL, NULL, 0.00, 20, 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-22 21:02:33'),
(32, 16, 'SONY-XM5-BLA', 'Black', NULL, NULL, 150000.00, 14, 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(33, 17, 'JBL-CHG5-BLA', 'Black', NULL, NULL, 0.00, 27, 'template/images/product/speaker/jbl-charge-5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(34, 17, 'JBL-CHG5-SIL', 'Silver', NULL, NULL, 150000.00, 18, 'template/images/product/speaker/jbl-charge-5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(35, 18, 'JBL-Q100-SIL', 'Silver', NULL, NULL, 0.00, 45, 'template/images/product/audio/jbl-quantum-100.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(36, 18, 'JBL-Q100-BLU', 'Blue', NULL, NULL, 150000.00, 30, 'template/images/product/audio/jbl-quantum-100.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(37, 19, 'LOG-MXKS-BLU', 'Blue', NULL, NULL, 0.00, 22, 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(38, 19, 'LOG-MXKS-WHI', 'White', NULL, NULL, 150000.00, 14, 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(39, 20, 'RZ-BWV4-WHI', 'White', NULL, NULL, 0.00, 12, 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(40, 20, 'RZ-BWV4-GRA', 'Gray', NULL, NULL, 150000.00, 8, 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(41, 21, 'LOG-GPX-SL-GRA', 'Gray', NULL, NULL, 0.00, 19, 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(42, 21, 'LOG-GPX-SL-TIT', 'Titanium', NULL, NULL, 150000.00, 12, 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(43, 22, 'RZ-DAV3-TIT', 'Titanium', NULL, NULL, 0.00, 25, 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(44, 22, 'RZ-DAV3-GRA', 'Graphite', NULL, NULL, 150000.00, 16, 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(45, 23, 'LG-27GP850-GRA', 'Graphite', NULL, NULL, 0.00, 10, 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(46, 23, 'LG-27GP850-RED', 'Red', NULL, NULL, 150000.00, 6, 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(47, 24, 'SS-ODG5-27-RED', 'Red', NULL, NULL, 0.00, 9, 'template/images/product/monitor/samsung-odyssey-g5-27.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(48, 24, 'SS-ODG5-27-BLA', 'Black', NULL, NULL, 150000.00, 6, 'template/images/product/monitor/samsung-odyssey-g5-27.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(49, 25, 'DL-U2723QE-BLA', 'Black', NULL, NULL, 0.00, 6, 'template/images/product/monitor/dell-ultrasharp-u2723qe.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(50, 25, 'DL-U2723QE-SIL', 'Silver', NULL, NULL, 150000.00, 4, 'template/images/product/monitor/dell-ultrasharp-u2723qe.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(51, 26, 'KS-NV2-1TB-SIL', 'Silver', NULL, '1TB', 0.00, 60, 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(52, 26, 'KS-NV2-1TB-BLU', 'Blue', NULL, '1TB', 150000.00, 40, 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(53, 27, 'COR-DDR5-16-BLU', 'Blue', NULL, '16GB', 0.00, 42, 'template/images/product/ssd-and-ram/corsair-vengeance-16gb-ddr5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(54, 27, 'COR-DDR5-16-WHI', 'White', NULL, '16GB', 150000.00, 28, 'template/images/product/ssd-and-ram/corsair-vengeance-16gb-ddr5.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(55, 28, 'GB-RTX4060-EOC-WHI', 'White', NULL, NULL, 0.00, 8, 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(56, 28, 'GB-RTX4060-EOC-GRA', 'Gray', NULL, NULL, 150000.00, 5, 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(57, 29, 'AS-TUF-B650M-GRA', 'Gray', NULL, NULL, 0.00, 12, 'template/images/product/pc-components/asus-tuf-b650m-plus.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(58, 29, 'AS-TUF-B650M-TIT', 'Titanium', NULL, NULL, 150000.00, 8, 'template/images/product/pc-components/asus-tuf-b650m-plus.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(59, 30, 'TPL-AX55-TIT', 'Titanium', NULL, NULL, 0.00, 32, 'template/images/product/router/tp-link-archer-ax55.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(60, 30, 'TPL-AX55-GRA', 'Graphite', NULL, NULL, 150000.00, 21, 'template/images/product/router/tp-link-archer-ax55.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(61, 31, 'TPL-DECO-X20-GRA', 'Graphite', NULL, NULL, 0.00, 14, 'template/images/product/router/tp-link-deco-x20-2-pack.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(62, 31, 'TPL-DECO-X20-RED', 'Red', NULL, NULL, 150000.00, 9, 'template/images/product/router/tp-link-deco-x20-2-pack.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(63, 32, 'XM-CAM-C300-RED', 'Red', NULL, NULL, 0.00, 38, 'template/images/product/smart-home/xiaomi-smart-camera-c300.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(64, 32, 'XM-CAM-C300-BLA', 'Black', NULL, NULL, 150000.00, 25, 'template/images/product/smart-home/xiaomi-smart-camera-c300.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(65, 33, 'ANK-737-PB-BLA', 'Black', NULL, NULL, 0.00, 16, 'template/images/product/smart-home/anker-737-power-bank.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(66, 33, 'ANK-737-PB-SIL', 'Silver', NULL, NULL, 150000.00, 11, 'template/images/product/smart-home/anker-737-power-bank.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(67, 34, 'ANK-NANO-65W-SIL', 'Silver', NULL, NULL, 0.00, 45, 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 'active', '2026-05-18 02:00:00', '2026-05-22 21:02:33'),
(68, 34, 'ANK-NANO-65W-BLU', 'Blue', NULL, NULL, 150000.00, 31, 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(69, 35, 'LOG-BYETI-BLU', 'Blue', NULL, NULL, 0.00, 10, 'template/images/product/audio/logitech-blue-yeti.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(70, 35, 'LOG-BYETI-WHI', 'White', NULL, NULL, 150000.00, 7, 'template/images/product/audio/logitech-blue-yeti.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(71, 36, 'LOG-K380-WHI', 'White', NULL, NULL, 0.00, 50, 'template/images/product/keyboard/logitech-k380-multi-device.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(72, 36, 'LOG-K380-GRA', 'Gray', NULL, NULL, 150000.00, 33, 'template/images/product/keyboard/logitech-k380-multi-device.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(73, 37, 'LOG-M650-GRA', 'Gray', NULL, NULL, 0.00, 55, 'template/images/product/mouse/logitech-m650-signature.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(74, 37, 'LOG-M650-TIT', 'Titanium', NULL, NULL, 150000.00, 36, 'template/images/product/mouse/logitech-m650-signature.webp', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(75, 38, 'JBL-TFLEX-TIT', 'Titanium', NULL, NULL, 0.00, 24, 'template/images/product/bluetooth-headphone/jbl-tune-flex.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(76, 38, 'JBL-TFLEX-GRA', 'Graphite', NULL, NULL, 150000.00, 16, 'template/images/product/bluetooth-headphone/jbl-tune-flex.png', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(77, 39, 'LNV-L5P-R7-GRA', 'Graphite', NULL, NULL, 0.00, 5, 'template/images/product/gaming-laptop/lenovo-legion-5-pro.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(78, 39, 'LNV-L5P-R7-RED', 'Red', NULL, NULL, 150000.00, 3, 'template/images/product/gaming-laptop/lenovo-legion-5-pro.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(79, 40, 'COR-RM750E-RED', 'Red', NULL, NULL, 0.00, 15, 'template/images/product/pc-components/corsair-rm750e-psu.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00'),
(80, 40, 'COR-RM750E-BLA', 'Black', NULL, NULL, 150000.00, 10, 'template/images/product/pc-components/corsair-rm750e-psu.jpg', 'active', '2026-05-18 02:00:00', '2026-05-18 02:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `return_requests`
--

CREATE TABLE `return_requests` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('return','cancellation') NOT NULL,
  `reason` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `refund_amount` decimal(15,2) DEFAULT 0.00,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `return_requests`
--

INSERT INTO `return_requests` (`id`, `order_id`, `order_item_id`, `user_id`, `type`, `reason`, `message`, `status`, `refund_amount`, `requested_at`, `resolved_at`) VALUES
(1, 15, 31, 18, 'cancellation', 'Customer changed mind', 'Cancel before shipping and refund to original payment method.', 'completed', 8611000.00, '2026-05-06 05:00:00', '2026-05-06 06:30:00'),
(2, 1, 1, 4, 'return', 'Product not as described', 'Customer requested return after receiving the package.', 'approved', 32990000.00, '2026-05-10 02:00:00', NULL),
(3, 5, 9, 8, 'return', 'Damaged box', 'The monitor box was damaged during shipping.', 'pending', 0.00, '2026-05-11 02:00:00', NULL),
(4, 11, 21, 14, 'return', 'Wrong item ordered', 'Customer wants to exchange for a different monitor.', 'rejected', 0.00, '2026-05-12 02:00:00', '2026-05-12 08:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `reviewer_name` varchar(255) DEFAULT NULL,
  `reviewer_email` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_id`, `reviewer_name`, `reviewer_email`, `rating`, `title`, `comment`, `status`, `created_at`) VALUES
(1, 4, 7, 1, 'Nguyen Minh Anh', 'minhanh@example.com', 5, 'Review 5 stars', 'Powerful laptop, delivery was on time.', 1, '2026-05-08 01:00:00'),
(2, 5, 3, 2, 'Tran Hoang Nam', 'hoangnam@example.com', 5, 'Review 5 stars', 'Camera and display quality are excellent.', 1, '2026-05-08 01:10:00'),
(3, 6, 10, 3, 'Le Thu Ha', 'thuha@example.com', 4, 'Review 4 stars', 'Good laptop for office work.', 1, '2026-05-08 01:20:00'),
(4, 7, 19, 4, 'Pham Quang Huy', 'quanghuy@example.com', 5, 'Review 5 stars', 'Keyboard feels very premium.', 1, '2026-05-08 01:30:00'),
(5, 8, 25, 5, 'Do Bao Ngoc', 'baongoc@example.com', 5, 'Review 5 stars', 'Color accuracy is great for design work.', 1, '2026-05-08 01:40:00'),
(6, 9, 17, 6, 'Hoang Gia Bao', 'giabao@example.com', 4, 'Review 4 stars', 'Speaker is loud and battery lasts long.', 1, '2026-05-08 01:50:00'),
(7, 10, 2, 7, 'Bui Lan Chi', 'lanchi@example.com', 5, 'Review 5 stars', 'Smooth iPhone experience.', 1, '2026-05-08 02:00:00'),
(8, 11, 8, 8, 'Dang Tuan Kiet', 'tuankiet@example.com', 4, 'Review 4 stars', 'Good gaming performance for the price.', 1, '2026-05-08 02:10:00'),
(9, 12, 31, 9, 'Vu Phuong Linh', 'phuonglinh@example.com', 4, 'Review 4 stars', 'Mesh Wi-Fi coverage improved my house.', 1, '2026-05-08 02:20:00'),
(10, 13, 4, 10, 'Dinh Khanh Vy', 'khanhvy@example.com', 5, 'Review 5 stars', 'Fast phone and fast charging.', 1, '2026-05-08 02:30:00'),
(11, 14, 23, 11, 'Cao Minh Quan', 'minhquan@example.com', 5, 'Review 5 stars', 'Great QHD gaming monitor.', 1, '2026-05-08 02:40:00'),
(12, 15, 28, 12, 'Mai Anh Duc', 'anhduc@example.com', 4, 'Review 4 stars', 'GPU runs cool and quiet.', 1, '2026-05-08 02:50:00'),
(13, 16, 13, 13, 'Ly Thanh Tam', 'thanhtam@example.com', 5, 'Review 5 stars', 'iPad is perfect for notes and media.', 1, '2026-05-08 03:00:00'),
(14, 17, 16, 14, 'Truong Nhat Minh', 'nhatminh@example.com', 5, 'Review 5 stars', 'Noise cancellation is impressive.', 1, '2026-05-08 03:10:00'),
(15, 18, 24, 15, 'Ha Ngoc Diep', 'ngocdiep@example.com', 3, 'Review 3 stars', 'Order was cancelled but support handled it.', 1, '2026-05-08 03:20:00'),
(16, 19, 39, 16, 'Vo Quoc Bao', 'quocbao@example.com', 5, 'Review 5 stars', 'Very strong gaming laptop.', 1, '2026-05-08 03:30:00'),
(17, 20, 5, 17, 'Nguyen Hai Yen', 'haiyen@example.com', 4, 'Review 4 stars', 'Good value Android phone.', 1, '2026-05-08 03:40:00'),
(18, 4, 11, 18, 'Nguyen Minh Anh', 'minhanh@example.com', 4, 'Review 4 stars', 'Solid laptop for daily work.', 1, '2026-05-08 03:50:00'),
(19, 5, 12, 19, 'Tran Hoang Nam', 'hoangnam@example.com', 4, 'Review 4 stars', 'Affordable and useful for study.', 1, '2026-05-08 04:00:00'),
(20, 6, 14, 20, 'Le Thu Ha', 'thuha@example.com', 5, 'Review 5 stars', 'Tablet screen is bright and clear.', 1, '2026-05-08 04:10:00'),
(21, 7, 29, 21, 'Pham Quang Huy', 'quanghuy@example.com', 4, 'Review 4 stars', 'Motherboard has enough ports.', 1, '2026-05-08 04:20:00'),
(22, 8, 6, 22, 'Do Bao Ngoc', 'baongoc@example.com', 5, 'Review 5 stars', 'MacBook battery life is excellent.', 1, '2026-05-08 04:30:00'),
(23, 9, 30, 23, 'Hoang Gia Bao', 'giabao@example.com', 3, 'Review 3 stars', 'Payment failed but router price is good.', 0, '2026-05-08 04:40:00'),
(24, 10, 36, 24, 'Bui Lan Chi', 'lanchi@example.com', 4, 'Review 4 stars', 'Compact keyboard, easy to carry.', 1, '2026-05-08 04:50:00'),
(25, 11, 6, 25, 'Dang Tuan Kiet', 'tuankiet@example.com', 5, 'Review 5 stars', 'Fast delivery and sealed product.', 1, '2026-05-08 05:00:00'),
(26, 12, 38, 26, 'Vu Phuong Linh', 'phuonglinh@example.com', 4, 'Review 4 stars', 'Earbuds sound good for the price.', 1, '2026-05-08 05:10:00'),
(27, 13, 26, 27, 'Dinh Khanh Vy', 'khanhvy@example.com', 5, 'Review 5 stars', 'SSD upgrade made my PC faster.', 1, '2026-05-08 05:20:00'),
(28, 14, 23, 28, 'Cao Minh Quan', 'minhquan@example.com', 5, 'Review 5 stars', 'Monitor is smooth for gaming.', 1, '2026-05-08 05:30:00'),
(29, 15, 9, 29, 'Mai Anh Duc', 'anhduc@example.com', 4, 'Review 4 stars', 'Premium build and nice screen.', 1, '2026-05-08 05:40:00'),
(30, 16, 37, 30, 'Ly Thanh Tam', 'thanhtam@example.com', 4, 'Review 4 stars', 'Silent mouse works well.', 1, '2026-05-08 05:50:00'),
(31, NULL, 39, NULL, 'Trần Mạnh Linh', 'manhlinh@gmail.com', 5, 'tốtfdgdfgdfgdf', 'hài lòngfdgdfgdfgdf', 0, '2026-05-22 12:56:53'),
(32, 33, 39, NULL, 'Trần Mạnh Linh', 'manhlinh@gmail.com', 5, 'sdfsđsdf', 'sffsdfsddsfdsf', 1, '2026-05-22 16:54:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Full system administrator', '2026-05-22 15:34:50', '2026-05-22 15:38:07'),
(2, 'manager', 'Store manager with sales and product access', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(3, 'staff', 'General shop staff', '2026-05-22 15:34:50', '2026-05-22 15:40:13'),
(4, 'customer', 'Registered customer account', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(5, 'warehouse', 'Warehouse and inventory staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(6, 'content', 'Content and product description editor', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(7, 'support', 'Customer support staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(8, 'accountant', 'Payment and revenue accountant', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(9, 'marketer', 'Marketing and campaign staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(10, 'seller', 'Sales consultant', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(11, 'shipper', 'Delivery staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(12, 'product_manager', 'Product catalog manager', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(13, 'order_manager', 'Order processing manager', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(14, 'review_moderator', 'Review moderation staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(16, 'inventory_auditor', 'Inventory audit staff', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(17, 'coupon_manager', 'Coupon and promotion manager', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(18, 'banner_manager', 'Homepage banner manager', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(19, 'news_editor', 'Technology news editor', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(20, 'guest_member', 'Limited member role for testing', '2026-05-22 15:34:50', '2026-05-22 15:34:50'),
(21, 'manage', 'Legacy manager role alias', '2026-05-22 15:34:50', '2026-05-22 15:34:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 2, 1),
(26, 2, 7),
(27, 2, 8),
(28, 2, 9),
(29, 2, 10),
(30, 2, 11),
(31, 2, 13),
(32, 2, 14),
(33, 2, 16),
(34, 2, 21),
(35, 3, 9),
(36, 3, 13),
(37, 3, 14),
(38, 3, 20),
(39, 4, 23),
(40, 4, 24),
(41, 5, 9),
(42, 5, 22),
(43, 6, 18),
(44, 7, 20),
(45, 8, 15),
(46, 8, 21),
(47, 9, 16),
(48, 9, 17),
(49, 10, 13),
(50, 10, 14),
(51, 11, 13),
(52, 12, 9),
(53, 12, 10),
(54, 12, 11),
(55, 13, 13),
(56, 13, 14),
(57, 14, 19),
(59, 16, 22),
(60, 17, 16),
(61, 18, 1),
(62, 18, 17),
(63, 19, 1),
(64, 19, 18),
(65, 21, 1),
(66, 21, 21),
(67, 21, 9),
(68, 21, 10),
(69, 21, 11),
(70, 21, 7),
(71, 21, 8),
(72, 21, 13),
(73, 21, 14),
(74, 21, 16),
(75, 21, 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `search_queries`
--

CREATE TABLE `search_queries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `keyword` varchar(255) NOT NULL,
  `result_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `search_queries`
--

INSERT INTO `search_queries` (`id`, `user_id`, `keyword`, `result_count`, `created_at`) VALUES
(1, 4, 'iphone', 2, '2026-05-18 03:01:00'),
(2, 5, 'gaming laptop', 3, '2026-05-18 03:02:00'),
(3, NULL, 'router wifi 6', 2, '2026-05-18 03:03:00'),
(4, 7, 'airpods', 1, '2026-05-18 03:04:00'),
(5, 8, 'monitor 27 inch', 3, '2026-05-18 03:05:00'),
(6, NULL, 'mechanical keyboard', 2, '2026-05-18 03:06:00'),
(7, 10, 'anker charger', 2, '2026-05-18 03:07:00'),
(8, 11, 'ssd 1tb', 1, '2026-05-18 03:08:00'),
(9, NULL, 'bluetooth headphone', 3, '2026-05-18 03:09:00'),
(10, 13, 'rtx 4060', 1, '2026-05-18 03:10:00'),
(11, 14, 'tablet samsung', 1, '2026-05-18 03:11:00'),
(12, NULL, 'macbook air', 1, '2026-05-18 03:12:00'),
(13, 16, 'mouse logitech', 2, '2026-05-18 03:13:00'),
(14, 17, 'power bank', 1, '2026-05-18 03:14:00'),
(15, NULL, 'smart camera', 1, '2026-05-18 03:15:00'),
(16, 19, 'corsair ram', 1, '2026-05-18 03:16:00'),
(17, 20, 'jbl speaker', 2, '2026-05-18 03:17:00'),
(18, NULL, 'dell xps', 1, '2026-05-18 03:18:00'),
(19, 4, 'xiaomi phone', 2, '2026-05-18 03:19:00'),
(20, 5, 'sony headphone', 1, '2026-05-18 03:20:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` int(11) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `state_code` varchar(20) DEFAULT NULL,
  `state_name` varchar(100) DEFAULT NULL,
  `postal_code_prefix` varchar(20) DEFAULT NULL,
  `method` varchar(50) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `free_shipping_min` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shipping_rates`
--

INSERT INTO `shipping_rates` (`id`, `country_code`, `country_name`, `state_code`, `state_name`, `postal_code_prefix`, `method`, `rate`, `free_shipping_min`, `status`, `created_at`) VALUES
(1, 'VN', 'Vietnam', 'HCM', 'Ho Chi Minh City', '700', 'standard', 30000.00, 2000000.00, 1, '2026-05-18 02:35:00'),
(2, 'VN', 'Vietnam', 'HN', 'Ha Noi', '100', 'standard', 30000.00, 2000000.00, 1, '2026-05-18 02:35:00'),
(3, 'VN', 'Vietnam', 'DN', 'Da Nang', '550', 'standard', 35000.00, 2500000.00, 1, '2026-05-18 02:35:00'),
(4, 'VN', 'Vietnam', 'CT', 'Can Tho', '900', 'standard', 40000.00, 2500000.00, 1, '2026-05-18 02:35:00'),
(5, 'VN', 'Vietnam', 'HCM', 'Ho Chi Minh City', '700', 'express', 60000.00, 5000000.00, 1, '2026-05-18 02:35:00'),
(6, 'US', 'United States', 'CA', 'California', NULL, 'standard', 350000.00, 15000000.00, 1, '2026-05-18 02:35:00'),
(7, 'US', 'United States', 'NY', 'New York', NULL, 'standard', 380000.00, 15000000.00, 1, '2026-05-18 02:35:00'),
(8, 'UK', 'United Kingdom', NULL, NULL, NULL, 'standard', 420000.00, 18000000.00, 1, '2026-05-18 02:35:00'),
(9, 'UAE', 'United Arab Emirates', NULL, NULL, NULL, 'standard', 450000.00, 20000000.00, 1, '2026-05-18 02:35:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `newsletter_opt_in` tinyint(1) DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `first_name`, `last_name`, `gender`, `date_of_birth`, `newsletter_opt_in`, `email`, `phone`, `password`, `avatar`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin Demo', 'Admin', 'Demo', 'male', '1988-04-07', 0, 'admin@gmail.com', '0901000001', '$2y$12$MAu87un.puUbhXdCOidnH.9otboZTrLQXth9aZ5/XCooNK0orKO5i', 'template/images/about/member-1.jpg', 'active', '2026-05-01 04:00:00', NULL, '2026-05-01 04:00:00', '2026-05-22 17:08:04'),
(2, 2, 'Manager Demo', 'Manager', 'Demo', 'female', '1988-07-13', 0, 'manager@techshop.test', '0901000002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/about/member-2.jpg', 'active', '2026-05-01 04:02:00', NULL, '2026-05-01 04:02:00', '2026-05-17 19:42:38'),
(3, 3, 'Staff Demo', 'Staff', 'Demo', 'male', '1988-10-18', 0, 'staff@techshop.test', '0901000003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/about/member-3.jpg', 'active', '2026-05-01 04:04:00', NULL, '2026-05-01 04:04:00', '2026-05-17 19:42:38'),
(4, 4, 'Nguyen Minh Anh', 'Nguyen', 'Minh Anh', 'female', '1989-01-23', 1, 'minhanh@example.com', '0901000004', '$2y$12$8ARaWWdB.MKXqIYyHb/mJOoZ.7saz4ZKgBqQJHbtNjwRmBwCDX0Tq', 'template/images/blog/avatar.jpg', 'active', '2026-05-01 04:06:00', NULL, '2026-05-01 04:06:00', '2026-05-21 03:12:56'),
(5, 4, 'Tran Hoang Nam', 'Tran', 'Hoang Nam', 'male', '1989-04-30', 1, 'hoangnam@example.com', '0901000005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/blog/avatar-2.jpg', 'active', '2026-05-01 04:08:00', NULL, '2026-05-01 04:08:00', '2026-05-17 19:42:38'),
(6, 4, 'Le Thu Ha', 'Le', 'Thu Ha', 'female', '1989-08-05', 1, 'thuha@example.com', '0901000006', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/blog/avatar-3.jpg', 'active', '2026-05-01 04:10:00', NULL, '2026-05-01 04:10:00', '2026-05-17 19:42:38'),
(7, 4, 'Pham Quang Huy', 'Pham', 'Quang Huy', 'male', '1989-11-10', 1, 'quanghuy@example.com', '0901000007', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/blog/avatar-4.jpg', 'active', '2026-05-01 04:12:00', NULL, '2026-05-01 04:12:00', '2026-05-17 19:42:38'),
(8, 4, 'Do Bao Ngoc', 'Do', 'Bao Ngoc', 'female', '1990-02-15', 1, 'baongoc@example.com', '0901000008', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'template/images/blog/avatar-5.jpg', 'active', '2026-05-01 04:14:00', NULL, '2026-05-01 04:14:00', '2026-05-17 19:42:38'),
(9, 4, 'Hoang Gia Bao', 'Hoang', 'Gia Bao', 'male', '1990-05-23', 1, 'giabao@example.com', '0901000009', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:16:00', NULL, '2026-05-01 04:16:00', '2026-05-17 19:42:38'),
(10, 4, 'Bui Lan Chi', 'Bui', 'Lan Chi', 'female', '1990-08-28', 1, 'lanchi@example.com', '0901000010', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:18:00', NULL, '2026-05-01 04:18:00', '2026-05-17 19:42:38'),
(11, 4, 'Dang Tuan Kiet', 'Dang', 'Tuan Kiet', 'male', '1990-12-03', 1, 'tuankiet@example.com', '0901000011', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:20:00', NULL, '2026-05-01 04:20:00', '2026-05-17 19:42:38'),
(12, 4, 'Vu Phuong Linh', 'Vu', 'Phuong Linh', 'female', '1991-03-10', 1, 'phuonglinh@example.com', '0901000012', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:22:00', NULL, '2026-05-01 04:22:00', '2026-05-17 19:42:38'),
(13, 4, 'Dinh Khanh Vy', 'Dinh', 'Khanh Vy', 'male', '1991-06-15', 1, 'khanhvy@example.com', '0901000013', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:24:00', NULL, '2026-05-01 04:24:00', '2026-05-17 19:42:38'),
(14, 4, 'Cao Minh Quan', 'Cao', 'Minh Quan', 'female', '1991-09-20', 1, 'minhquan@example.com', '0901000014', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:26:00', NULL, '2026-05-01 04:26:00', '2026-05-17 19:42:38'),
(15, 4, 'Mai Anh Duc', 'Mai', 'Anh Duc', 'male', '1991-12-26', 1, 'anhduc@example.com', '0901000015', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:28:00', NULL, '2026-05-01 04:28:00', '2026-05-17 19:42:38'),
(16, 4, 'Ly Thanh Tam', 'Ly', 'Thanh Tam', 'female', '1992-04-01', 1, 'thanhtam@example.com', '0901000016', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:30:00', NULL, '2026-05-01 04:30:00', '2026-05-17 19:42:38'),
(17, 4, 'Truong Nhat Minh', 'Truong', 'Nhat Minh', 'male', '1992-07-07', 1, 'nhatminh@example.com', '0901000017', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:32:00', NULL, '2026-05-01 04:32:00', '2026-05-17 19:42:38'),
(18, 4, 'Ha Ngoc Diep', 'Ha', 'Ngoc Diep', 'female', '1992-10-12', 1, 'ngocdiep@example.com', '0901000018', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:34:00', NULL, '2026-05-01 04:34:00', '2026-05-17 19:42:38'),
(19, 4, 'Vo Quoc Bao', 'Vo', 'Quoc Bao', 'male', '1993-01-17', 1, 'quocbao@example.com', '0901000019', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:36:00', NULL, '2026-05-01 04:36:00', '2026-05-17 19:42:38'),
(20, 4, 'Nguyen Hai Yen', 'Nguyen', 'Hai Yen', 'female', '1993-04-24', 1, 'haiyen@example.com', '0901000020', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:38:00', NULL, '2026-05-01 04:38:00', '2026-05-17 19:42:38'),
(21, 5, 'Warehouse User', 'Warehouse', 'User', 'male', '1993-07-30', 0, 'warehouse@techshop.test', '0901000021', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:40:00', NULL, '2026-05-01 04:40:00', '2026-05-17 19:42:38'),
(22, 6, 'Content User', 'Content', 'User', 'female', '1993-11-04', 0, 'content@techshop.test', '0901000022', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:42:00', NULL, '2026-05-01 04:42:00', '2026-05-17 19:42:38'),
(23, 7, 'Support User', 'Support', 'User', 'male', '1994-02-09', 0, 'support@techshop.test', '0901000023', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:44:00', NULL, '2026-05-01 04:44:00', '2026-05-17 19:42:38'),
(24, 8, 'Accountant User', 'Accountant', 'User', 'female', '1994-05-17', 0, 'accountant@techshop.test', '0901000024', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:46:00', NULL, '2026-05-01 04:46:00', '2026-05-17 19:42:38'),
(25, 9, 'Marketing User', 'Marketing', 'User', 'male', '1994-08-22', 0, 'marketing@techshop.test', '0901000025', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:48:00', NULL, '2026-05-01 04:48:00', '2026-05-17 19:42:38'),
(26, 10, 'Seller User', 'Seller', 'User', 'female', '1994-11-27', 0, 'seller@techshop.test', '0901000026', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:50:00', NULL, '2026-05-01 04:50:00', '2026-05-17 19:42:38'),
(27, 11, 'Shipper User', 'Shipper', 'User', 'male', '1995-03-04', 0, 'shipper@techshop.test', '0901000027', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:52:00', NULL, '2026-05-01 04:52:00', '2026-05-17 19:42:38'),
(28, 12, 'Product Manager User', 'Product', 'Manager User', 'female', '1995-06-09', 0, 'product.manager@techshop.test', '0901000028', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:54:00', NULL, '2026-05-01 04:54:00', '2026-05-17 19:42:38'),
(29, 13, 'Order Manager User', 'Order', 'Manager User', 'male', '1995-09-14', 0, 'order.manager@techshop.test', '0901000029', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-05-01 04:56:00', NULL, '2026-05-01 04:56:00', '2026-05-17 19:42:38'),
(30, 4, 'Blocked Customer', 'Blocked', 'Customer', 'female', '1995-12-20', 0, 'blocked@example.com', '0901000030', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'blocked', NULL, NULL, '2026-05-01 04:58:00', '2026-05-17 19:42:38'),
(32, 4, 'Hồ Vũ Anh Minh', NULL, NULL, NULL, NULL, 0, 'zzzmmm270907@gmail.com', '0339981185', '$2y$12$OYZygwbO35brw4b49NJNKOfBWrrqUbKfdvM71tr9aXIx7ztJe5Wpq', NULL, 'active', NULL, NULL, '2026-05-21 02:11:37', '2026-05-21 02:11:37'),
(33, 4, 'Trần Mạnh Linh', NULL, NULL, NULL, NULL, 0, 'manhlinh@gmail.com', '+84868066018', '$2y$12$d/O1q6BohaAAWtsE9znH0./hON2J7x/XcA/76oesZuzYSyMF0VYfW', NULL, 'active', NULL, NULL, '2026-05-22 13:09:35', '2026-05-22 13:09:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('shipping','billing','both') DEFAULT 'both',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(30) DEFAULT NULL,
  `is_default_shipping` tinyint(1) DEFAULT 0,
  `is_default_billing` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `type`, `first_name`, `last_name`, `phone`, `address_line`, `address_line2`, `country`, `state`, `city`, `postal_code`, `is_default_shipping`, `is_default_billing`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'both', 'Nguyen', 'Minh Anh', '0901000004', '12 Nguyen Trai', NULL, 'Vietnam', 'District 1', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(2, 4, 'shipping', 'Nguyen', 'Minh Anh', '0901000004', '100 Demo Street', 'Office', 'Vietnam', 'District 1', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(3, 5, 'both', 'Tran', 'Hoang Nam', '0901000005', '45 Le Loi', NULL, 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(4, 5, 'shipping', 'Tran', 'Hoang Nam', '0901000005', '101 Demo Street', 'Office', 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(5, 6, 'both', 'Le', 'Thu Ha', '0901000006', '78 Tran Phu', NULL, 'Vietnam', 'Ha Dong', 'Ha Noi', '100000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(6, 6, 'shipping', 'Le', 'Thu Ha', '0901000006', '102 Demo Street', 'Office', 'Vietnam', 'Ha Dong', 'Ha Noi', '100000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(7, 7, 'both', 'Pham', 'Quang Huy', '0901000007', '22 Dien Bien Phu', NULL, 'Vietnam', 'Binh Thanh', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(8, 7, 'shipping', 'Pham', 'Quang Huy', '0901000007', '103 Demo Street', 'Office', 'Vietnam', 'Binh Thanh', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(9, 8, 'both', 'Do', 'Bao Ngoc', '0901000008', '9 Hai Ba Trung', NULL, 'Vietnam', 'Hoan Kiem', 'Ha Noi', '100000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(10, 8, 'shipping', 'Do', 'Bao Ngoc', '0901000008', '104 Demo Street', 'Office', 'Vietnam', 'Hoan Kiem', 'Ha Noi', '100000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(11, 9, 'both', 'Hoang', 'Gia Bao', '0901000009', '18 Bach Dang', NULL, 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(12, 9, 'shipping', 'Hoang', 'Gia Bao', '0901000009', '105 Demo Street', 'Office', 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(13, 10, 'both', 'Bui', 'Lan Chi', '0901000010', '101 Nguyen Van Cu', NULL, 'Vietnam', 'Ninh Kieu', 'Can Tho', '900000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(14, 10, 'shipping', 'Bui', 'Lan Chi', '0901000010', '106 Demo Street', 'Office', 'Vietnam', 'Ninh Kieu', 'Can Tho', '900000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(15, 11, 'both', 'Dang', 'Tuan Kiet', '0901000011', '66 Vo Van Tan', NULL, 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(16, 11, 'shipping', 'Dang', 'Tuan Kiet', '0901000011', '107 Demo Street', 'Office', 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(17, 12, 'both', 'Vu', 'Phuong Linh', '0901000012', '27 Hoang Dieu', NULL, 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(18, 12, 'shipping', 'Vu', 'Phuong Linh', '0901000012', '108 Demo Street', 'Office', 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(19, 13, 'both', 'Dinh', 'Khanh Vy', '0901000013', '33 Nguyen Hue', NULL, 'Vietnam', 'Thua Thien Hue', 'Hue', '530000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(20, 13, 'shipping', 'Dinh', 'Khanh Vy', '0901000013', '109 Demo Street', 'Office', 'Vietnam', 'Thua Thien Hue', 'Hue', '530000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(21, 14, 'both', 'Cao', 'Minh Quan', '0901000014', '88 Tran Hung Dao', NULL, 'Vietnam', 'Khanh Hoa', 'Nha Trang', '650000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(22, 14, 'shipping', 'Cao', 'Minh Quan', '0901000014', '110 Demo Street', 'Office', 'Vietnam', 'Khanh Hoa', 'Nha Trang', '650000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(23, 15, 'both', 'Mai', 'Anh Duc', '0901000015', '40 Phan Chu Trinh', NULL, 'Vietnam', 'Lam Dong', 'Da Lat', '670000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(24, 15, 'shipping', 'Mai', 'Anh Duc', '0901000015', '111 Demo Street', 'Office', 'Vietnam', 'Lam Dong', 'Da Lat', '670000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(25, 16, 'both', 'Ly', 'Thanh Tam', '0901000016', '12 Nguyen Trai', NULL, 'Vietnam', 'District 1', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(26, 16, 'shipping', 'Ly', 'Thanh Tam', '0901000016', '112 Demo Street', 'Office', 'Vietnam', 'District 1', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(27, 17, 'both', 'Truong', 'Nhat Minh', '0901000017', '45 Le Loi', NULL, 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(28, 17, 'shipping', 'Truong', 'Nhat Minh', '0901000017', '113 Demo Street', 'Office', 'Vietnam', 'District 3', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(29, 18, 'both', 'Ha', 'Ngoc Diep', '0901000018', '78 Tran Phu', NULL, 'Vietnam', 'Ha Dong', 'Ha Noi', '100000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(30, 18, 'shipping', 'Ha', 'Ngoc Diep', '0901000018', '114 Demo Street', 'Office', 'Vietnam', 'Ha Dong', 'Ha Noi', '100000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(31, 19, 'both', 'Vo', 'Quoc Bao', '0901000019', '22 Dien Bien Phu', NULL, 'Vietnam', 'Binh Thanh', 'Ho Chi Minh City', '700000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(32, 19, 'shipping', 'Vo', 'Quoc Bao', '0901000019', '115 Demo Street', 'Office', 'Vietnam', 'Binh Thanh', 'Ho Chi Minh City', '700000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(33, 20, 'both', 'Nguyen', 'Hai Yen', '0901000020', '9 Hai Ba Trung', NULL, 'Vietnam', 'Hoan Kiem', 'Ha Noi', '100000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(34, 20, 'shipping', 'Nguyen', 'Hai Yen', '0901000020', '116 Demo Street', 'Office', 'Vietnam', 'Hoan Kiem', 'Ha Noi', '100000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(35, 21, 'both', 'Warehouse', 'User', '0901000021', '18 Bach Dang', NULL, 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 1, 1, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00'),
(36, 21, 'shipping', 'Warehouse', 'User', '0901000021', '117 Demo Street', 'Office', 'Vietnam', 'Hai Chau', 'Da Nang', '550000', 0, 0, 1, '2026-05-18 02:05:00', '2026-05-18 02:05:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_payment_methods`
--

CREATE TABLE `user_payment_methods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('card','paypal','bank_transfer') NOT NULL,
  `provider` varchar(100) DEFAULT NULL,
  `card_holder` varchar(255) DEFAULT NULL,
  `card_brand` varchar(50) DEFAULT NULL,
  `last_four` varchar(4) DEFAULT NULL,
  `expiry_month` tinyint(2) DEFAULT NULL,
  `expiry_year` smallint(4) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_payment_methods`
--

INSERT INTO `user_payment_methods` (`id`, `user_id`, `type`, `provider`, `card_holder`, `card_brand`, `last_four`, `expiry_month`, `expiry_year`, `paypal_email`, `bank_name`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'card', 'stripe', 'Nguyen Minh Anh', 'Mastercard', '1201', 2, 2029, NULL, NULL, 1, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(2, 5, 'card', 'stripe', 'Tran Hoang Nam', 'JCB', '1202', 3, 2030, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(3, 6, 'card', 'stripe', 'Le Thu Ha', 'American Express', '1203', 4, 2031, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(4, 7, 'paypal', 'paypal', NULL, NULL, NULL, NULL, NULL, 'quanghuy@example.com', NULL, 1, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(5, 8, 'card', 'stripe', 'Do Bao Ngoc', 'Mastercard', '1205', 6, 2029, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(6, 9, 'card', 'stripe', 'Hoang Gia Bao', 'JCB', '1206', 7, 2030, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(7, 10, 'card', 'stripe', 'Bui Lan Chi', 'American Express', '1207', 8, 2031, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(8, 11, 'paypal', 'paypal', NULL, NULL, NULL, NULL, NULL, 'tuankiet@example.com', NULL, 1, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(9, 12, 'card', 'stripe', 'Vu Phuong Linh', 'Mastercard', '1209', 10, 2029, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(10, 13, 'card', 'stripe', 'Dinh Khanh Vy', 'JCB', '1210', 11, 2030, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(11, 14, 'card', 'stripe', 'Cao Minh Quan', 'American Express', '1211', 12, 2031, NULL, NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00'),
(12, 15, 'paypal', 'paypal', NULL, NULL, NULL, NULL, NULL, 'anhduc@example.com', NULL, 0, 'active', '2026-05-18 02:15:00', '2026-05-18 02:15:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 4, 1, '2026-05-18 02:10:00'),
(2, 4, 6, '2026-05-18 02:10:00'),
(3, 5, 4, '2026-05-18 02:10:00'),
(4, 5, 13, '2026-05-18 02:10:00'),
(5, 6, 7, '2026-05-18 02:10:00'),
(6, 6, 20, '2026-05-18 02:10:00'),
(7, 7, 10, '2026-05-18 02:10:00'),
(8, 7, 27, '2026-05-18 02:10:00'),
(9, 8, 13, '2026-05-18 02:10:00'),
(10, 8, 34, '2026-05-18 02:10:00'),
(11, 9, 16, '2026-05-18 02:10:00'),
(12, 9, 1, '2026-05-18 02:10:00'),
(13, 10, 19, '2026-05-18 02:10:00'),
(14, 10, 8, '2026-05-18 02:10:00'),
(15, 11, 22, '2026-05-18 02:10:00'),
(16, 11, 15, '2026-05-18 02:10:00'),
(17, 12, 25, '2026-05-18 02:10:00'),
(18, 12, 22, '2026-05-18 02:10:00'),
(19, 13, 28, '2026-05-18 02:10:00'),
(20, 13, 29, '2026-05-18 02:10:00'),
(21, 14, 31, '2026-05-18 02:10:00'),
(22, 14, 36, '2026-05-18 02:10:00'),
(23, 15, 34, '2026-05-18 02:10:00'),
(24, 15, 3, '2026-05-18 02:10:00'),
(25, 16, 37, '2026-05-18 02:10:00'),
(26, 16, 10, '2026-05-18 02:10:00'),
(27, 17, 40, '2026-05-18 02:10:00'),
(28, 17, 17, '2026-05-18 02:10:00'),
(29, 18, 3, '2026-05-18 02:10:00'),
(30, 18, 24, '2026-05-18 02:10:00'),
(31, 19, 6, '2026-05-18 02:10:00'),
(32, 19, 31, '2026-05-18 02:10:00'),
(33, 20, 9, '2026-05-18 02:10:00'),
(34, 20, 38, '2026-05-18 02:10:00'),
(35, 21, 12, '2026-05-18 02:10:00'),
(36, 21, 5, '2026-05-18 02:10:00'),
(41, 33, 39, '2026-05-22 16:54:05');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `carts_session_id_idx` (`session_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_items_product_variant_id_idx` (`product_variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_coupon_id_idx` (`coupon_id`),
  ADD KEY `orders_tracking_number_idx` (`tracking_number`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_items_product_variant_id_idx` (`product_variant_id`);

--
-- Chỉ mục cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `email` (`email`),
  ADD KEY `token` (`token`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `price_alerts`
--
ALTER TABLE `price_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `email` (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `products_sold_count_idx` (`sold_count`),
  ADD KEY `products_is_free_shipping_idx` (`is_free_shipping`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Chỉ mục cho bảng `search_queries`
--
ALTER TABLE `search_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `keyword` (`keyword`);

--
-- Chỉ mục cho bảng `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_state` (`country_code`,`state_code`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `user_payment_methods`
--
ALTER TABLE `user_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD CONSTRAINT `order_status_histories_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `price_alerts`
--
ALTER TABLE `price_alerts`
  ADD CONSTRAINT `price_alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `price_alerts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_requests_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `return_requests_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `search_queries`
--
ALTER TABLE `search_queries`
  ADD CONSTRAINT `search_queries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Các ràng buộc cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_payment_methods`
--
ALTER TABLE `user_payment_methods`
  ADD CONSTRAINT `user_payment_methods_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
