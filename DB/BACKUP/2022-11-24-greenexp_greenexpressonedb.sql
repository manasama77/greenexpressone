-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2022 at 10:54 PM
-- Server version: 10.3.36-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenexp_greenexpressonedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('super admin','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `photo`, `email`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin', '$2y$10$rdVYHMN8XV1IzLqnn95gWuO06dVoqwTF8xddXc1dP4X6zfVz7uwjy', 'img/admin_pp/default.jpg', '0qeeTZWWFa@gmail.com', 'super admin', NULL, '2022-11-17 07:45:53', '2022-11-17 07:45:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Agent 1', 'agent1', NULL, NULL),
(2, 'Agent 2', 'agent2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `picture`, `url`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'img/slider/1.jpg', '#', 1, '2022-11-17 07:45:53', '2022-11-17 07:45:53', NULL),
(2, 'img/slider/2.jpg', '#', 1, '2022-11-17 07:45:53', '2022-11-17 07:45:53', NULL),
(3, 'img/slider/3.jpg', '#', 1, '2022-11-17 07:45:53', '2022-11-17 07:45:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `from_master_area_id` int(11) NOT NULL,
  `from_master_area_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` int(11) DEFAULT NULL,
  `from_master_sub_area_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_master_area_id` int(11) NOT NULL,
  `to_master_area_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` int(11) DEFAULT NULL,
  `to_master_sub_area_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime_departure` datetime NOT NULL,
  `schedule_type` enum('shuttle','charter') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_adult` int(11) NOT NULL,
  `qty_baby` int(11) NOT NULL,
  `base_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `total_base_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `flight_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flight_info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luggage_qty` int(11) DEFAULT 0,
  `luggage_price` decimal(19,2) DEFAULT 0.00,
  `overweight_luggage_qty` int(11) DEFAULT 0,
  `overweight_luggage_price` decimal(10,2) DEFAULT 0.00,
  `special_request` tinyint(1) NOT NULL DEFAULT 0,
  `special_area_id` int(11) DEFAULT NULL,
  `special_area_detail` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `promo_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `sub_total_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `fee_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(19,2) NOT NULL DEFAULT 0.00,
  `booking_status` enum('pending','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('waiting','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_payment` decimal(19,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_number`, `schedule_id`, `from_master_area_id`, `from_master_area_name`, `from_master_sub_area_id`, `from_master_sub_area_name`, `to_master_area_id`, `to_master_area_name`, `to_master_sub_area_id`, `to_master_sub_area_name`, `vehicle_name`, `vehicle_number`, `datetime_departure`, `schedule_type`, `user_id`, `customer_phone`, `customer_name`, `customer_email`, `qty_adult`, `qty_baby`, `base_price`, `total_base_price`, `flight_number`, `flight_info`, `notes`, `luggage_qty`, `luggage_price`, `overweight_luggage_qty`, `overweight_luggage_price`, `special_request`, `special_area_id`, `special_area_detail`, `regional_name`, `extra_price`, `voucher_id`, `promo_price`, `sub_total_price`, `fee_price`, `total_price`, `booking_status`, `payment_status`, `payment_method`, `payment_token`, `total_payment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GEO2211240001', 1, 1, 'Philadelphia', 1, '2800 south 3rd st PA19148 (Oregon Supermarket)', 3, 'New Ark Airport', 6, 'Terminal A', 'Shuttle', '123', '2022-11-25 07:30:00', 'shuttle', 6, '+1 (378) 921-3907', 'Mufutau Valdez', 'lafybydy@mailinator.com', 1, 0, '70.00', '70.00', '817', 'Architecto laborum', 'Vitae magna tenetur', 24, '440.00', 30, '300.00', 0, NULL, 'Reprehenderit odio m', NULL, '0.00', NULL, '0.00', '810.00', '29.97', '839.97', 'pending', 'waiting', NULL, NULL, '839.97', '2022-11-24 15:47:26', '2022-11-24 15:47:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_customers`
--

CREATE TABLE `booking_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `customer_name`, `customer_phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'George Reid', '+1 (638) 458-2311', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_sequences`
--

CREATE TABLE `booking_sequences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_sequence` date NOT NULL,
  `current_sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `booking_sequences`
--

INSERT INTO `booking_sequences` (`id`, `date_sequence`, `current_sequence`, `created_at`, `updated_at`) VALUES
(1, '2022-11-24', 1, '2022-11-24 15:47:26', '2022-11-24 15:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `charters`
--

CREATE TABLE `charters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_type` enum('airport','city') COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_master_area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_seat` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(19,2) NOT NULL,
  `driver_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `charters`
--

INSERT INTO `charters` (`id`, `from_type`, `from_master_area_id`, `from_master_sub_area_id`, `to_master_area_id`, `to_master_sub_area_id`, `vehicle_name`, `vehicle_number`, `total_seat`, `is_available`, `photo`, `price`, `driver_contact`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'airport', '4', NULL, '2', '5', 'Gail Dunlap', '203', 9, 1, 'img/vehicle/default.png', '137.00', 'Perferendis in iusto', 'Esse natus hic aute', '2022-11-22 16:07:13', '2022-11-22 16:07:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `master_areas`
--

CREATE TABLE `master_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_type` enum('airport','city') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_areas`
--

INSERT INTO `master_areas` (`id`, `name`, `area_type`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Philadelphia', 'city', 1, '2022-11-21 14:39:35', '2022-11-21 14:39:35', NULL),
(2, 'New Jersey', 'city', 1, '2022-11-21 14:39:49', '2022-11-21 14:39:49', NULL),
(3, 'New Ark Airport', 'airport', 1, '2022-11-21 14:40:02', '2022-11-21 14:40:02', NULL),
(4, 'JFK Airport', 'airport', 1, '2022-11-21 14:40:11', '2022-11-21 14:40:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_special_areas`
--

CREATE TABLE `master_special_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_sub_area_id` bigint(20) UNSIGNED NOT NULL,
  `regional_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_person_price` decimal(19,2) UNSIGNED NOT NULL,
  `extra_person_price` decimal(19,2) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `master_sub_areas`
--

CREATE TABLE `master_sub_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_area_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_sub_areas`
--

INSERT INTO `master_sub_areas` (`id`, `master_area_id`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2800 south 3rd st PA19148 (Oregon Supermarket)', 1, '2022-11-21 14:40:41', '2022-11-21 14:41:00', NULL),
(2, 1, '828 Race Street PA19107', 1, '2022-11-21 14:41:06', '2022-11-21 14:41:06', NULL),
(3, 2, '601 Fellowship Rd, Mt Laurel Township, NJ 08054 ( Walmart )', 1, '2022-11-21 14:41:21', '2022-11-21 14:41:21', NULL),
(4, 2, '75 NJ Tpke, Hamilton NJ 08620, Rest Area New Jersey, T.P. Woodrow Wilson', 1, '2022-11-21 14:41:35', '2022-11-21 14:41:35', NULL),
(5, 2, '511 Old Post Rd, NJ08817 (Kam Man Food)', 1, '2022-11-21 14:41:55', '2022-11-21 14:41:55', NULL),
(6, 3, 'Terminal A', 1, '2022-11-21 14:42:19', '2022-11-21 14:42:19', NULL),
(7, 3, 'Terminal B', 1, '2022-11-21 14:42:27', '2022-11-21 14:42:27', NULL),
(8, 3, 'Terminal C', 1, '2022-11-21 14:42:35', '2022-11-21 14:42:35', NULL),
(9, 3, 'Terminal D', 1, '2022-11-21 14:42:42', '2022-11-21 14:42:42', NULL),
(10, 4, 'Terminal 1', 1, '2022-11-21 14:43:03', '2022-11-21 14:43:03', NULL),
(11, 4, 'Terminal 2', 1, '2022-11-21 14:43:11', '2022-11-21 14:43:25', NULL),
(12, 4, 'Terminal 3', 1, '2022-11-21 14:43:33', '2022-11-21 14:43:33', NULL),
(13, 4, 'Terminal 4', 1, '2022-11-21 14:43:43', '2022-11-21 14:43:43', NULL),
(14, 4, 'Terminal 5', 1, '2022-11-21 14:43:56', '2022-11-21 14:43:56', NULL),
(15, 4, 'Terminal 6', 1, '2022-11-21 14:44:02', '2022-11-21 14:44:02', NULL),
(16, 4, 'Terminal 7', 1, '2022-11-21 14:44:08', '2022-11-21 14:44:08', NULL),
(17, 4, 'Terminal 8', 1, '2022-11-21 14:44:14', '2022-11-21 14:44:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_23_155543_create_banners_table', 1),
(6, '2022_09_24_202157_create_admins_table', 1),
(7, '2022_09_24_202341_create_pages_table', 1),
(8, '2022_09_24_202427_create_master_areas_table', 1),
(9, '2022_09_24_202444_create_master_sub_areas_table', 1),
(10, '2022_09_24_202502_create_master_special_areas_table', 1),
(11, '2022_09_24_202531_create_charters_table', 1),
(12, '2022_09_24_202531_create_schedule_shuttles_table', 1),
(13, '2022_09_24_202546_create_vouchers_table', 1),
(14, '2022_09_24_202600_create_bookings_table', 1),
(15, '2022_09_29_232653_create_booking_sequences_table', 1),
(16, '2022_10_29_210900_create_booking_customers_table', 1),
(17, '2022_10_30_021859_create_agents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `page_title`, `page_content`) VALUES
(1, 'privacy', 'Privacy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, provident.'),
(2, 'term-and-condition', 'Term and Condition', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores recusandae exercitationem ipsa ab amet! Sed tempore maxime officiis possimus molestiae!');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, '896-9679-6688', '9f76c810658397794a3e308a27e83884c239f0514ecc55cc487c8213b7acc9e3', '[\"*\"]', NULL, NULL, '2022-11-22 08:30:22', '2022-11-22 08:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_shuttles`
--

CREATE TABLE `schedule_shuttles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_type` enum('airport','city') COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_master_area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_departure` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(19,2) NOT NULL,
  `driver_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_seat` int(10) UNSIGNED NOT NULL,
  `luggage_price` decimal(19,2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `schedule_shuttles`
--

INSERT INTO `schedule_shuttles` (`id`, `from_type`, `from_master_area_id`, `from_master_sub_area_id`, `to_master_area_id`, `to_master_sub_area_id`, `vehicle_name`, `vehicle_number`, `time_departure`, `is_active`, `photo`, `price`, `driver_contact`, `notes`, `total_seat`, `luggage_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'city', '1', '1', '3', NULL, 'Shuttle', '123', '07:30:00', 1, 'img/vehicle/default.png', '70.00', NULL, NULL, 18, '20.00', '2022-11-21 14:48:03', '2022-11-24 15:47:26', NULL),
(2, 'city', '1', '2', '3', NULL, 'Shuttle', '123', '07:35:00', 1, 'img/vehicle/default.png', '70.00', NULL, NULL, 20, '20.00', '2022-11-21 14:48:59', '2022-11-21 14:48:59', NULL),
(3, 'city', '1', '1', '4', NULL, 'Shuttle', '123', '15:45:00', 1, 'img/vehicle/default.png', '70.00', NULL, NULL, 20, '20.00', '2022-11-21 14:49:57', '2022-11-22 07:04:03', NULL),
(4, 'airport', '4', NULL, '1', '1', 'Shuttle', '123', '13:00:00', 1, 'img/vehicle/default.png', '70.00', NULL, NULL, 20, '20.00', '2022-11-21 14:51:05', '2022-11-23 15:36:04', NULL),
(5, 'airport', '4', NULL, '1', '2', 'Shuttle', '111', '22:15:00', 1, 'img/vehicle/default.png', '70.00', NULL, NULL, 17, '20.00', '2022-11-21 14:51:35', '2022-11-22 08:30:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `password`, `photo`, `email`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Eleanor Sosa', '+1 (322) 271-3652', '$2y$10$FeBR7HDc0Wq6AhYMyUH6WeRrncrDve2XKKrGyOWC97SxuQXYLFe5e', 'img/user_pp/default.jpg', 'fotoji@mailinator.com', NULL, '2022-11-20 11:12:40', '2022-11-20 11:12:40', NULL),
(2, 'Surakarta', '082131732227', '$2y$10$u0tAPiOLJyJExmQuTPCXMO88YPv/pmLNMuV2cB6KY1Uej8MmHu3jy', 'img/user_pp/default.jpg', 'acmaskfair@gmail.com', NULL, '2022-11-22 06:25:48', '2022-11-22 06:32:37', NULL),
(3, 'bagus', '896-9679-6688', '$2y$10$oIMpMThBbqH1nba2KBLZM.ENdEs4mahtx0VPMQ0QkwIOgnT.sdUvm', 'img/user_pp/default.jpg', 'bagusbagus2733@gmail.com', NULL, '2022-11-22 08:30:21', '2022-11-22 08:30:21', NULL),
(4, 'Surakarta', '+6282131732227', '$2y$10$9ZdfASBz9lYKRbH0ixCnteTM546sT615htFjNPBgguOiY7Gm2D47S', 'img/user_pp/default.jpg', 'acmaskfair@gmail.com', NULL, '2022-11-23 15:05:24', '2022-11-23 15:05:24', NULL),
(5, 'Deirdre Simmons', '+1 (129) 691-7474', '$2y$10$pG6r1CPnoLNWFjAfmdJl2.roXOJeEKKY1yi9xsHZIXlufC272sexe', 'img/user_pp/default.jpg', 'cehu@mailinator.com', NULL, '2022-11-24 15:34:38', '2022-11-24 15:34:38', NULL),
(6, 'Mufutau Valdez', '+1 (378) 921-3907', '$2y$10$85zrmoTGui4Mdwny2a48mOhGSh0WeLj5cASiT7q3oyfl.Mi6MEW6i', 'img/user_pp/default.jpg', 'lafybydy@mailinator.com', NULL, '2022-11-24 15:47:26', '2022-11-24 15:47:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_expired` date NOT NULL,
  `discount_type` enum('percentage','value') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` decimal(19,2) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `name`, `code`, `date_start`, `date_expired`, `discount_type`, `discount_value`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Agent 1 Discount 10%', 'agent1', '2022-09-01', '2022-10-31', 'percentage', '10.00', 1, '2022-11-17 07:45:54', '2022-11-17 07:45:54', NULL),
(2, 'Agent 2 Discount $5', 'agent2', '2022-09-01', '2022-10-31', 'value', '5.00', 1, '2022-11-17 07:45:54', '2022-11-17 07:45:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admins_username_unique` (`username`) USING BTREE;

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `bookings_user_id_foreign` (`user_id`) USING BTREE,
  ADD KEY `bookings_voucher_id_foreign` (`voucher_id`) USING BTREE;

--
-- Indexes for table `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `booking_sequences`
--
ALTER TABLE `booking_sequences`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `charters`
--
ALTER TABLE `charters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE;

--
-- Indexes for table `master_areas`
--
ALTER TABLE `master_areas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_special_areas`
--
ALTER TABLE `master_special_areas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `master_special_areas_master_sub_area_id_foreign` (`master_sub_area_id`) USING BTREE;

--
-- Indexes for table `master_sub_areas`
--
ALTER TABLE `master_sub_areas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `master_sub_areas_master_area_id_foreign` (`master_area_id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

--
-- Indexes for table `schedule_shuttles`
--
ALTER TABLE `schedule_shuttles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_phone_unique` (`phone`) USING BTREE;

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_sequences`
--
ALTER TABLE `booking_sequences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `charters`
--
ALTER TABLE `charters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_areas`
--
ALTER TABLE `master_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_special_areas`
--
ALTER TABLE `master_special_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_sub_areas`
--
ALTER TABLE `master_sub_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedule_shuttles`
--
ALTER TABLE `schedule_shuttles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `master_special_areas`
--
ALTER TABLE `master_special_areas`
  ADD CONSTRAINT `master_special_areas_master_sub_area_id_foreign` FOREIGN KEY (`master_sub_area_id`) REFERENCES `master_sub_areas` (`id`);

--
-- Constraints for table `master_sub_areas`
--
ALTER TABLE `master_sub_areas`
  ADD CONSTRAINT `master_sub_areas_master_area_id_foreign` FOREIGN KEY (`master_area_id`) REFERENCES `master_areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
