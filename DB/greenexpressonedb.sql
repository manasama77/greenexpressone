/*
 Navicat Premium Data Transfer

 Source Server         : MySql Local
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : greenexpressonedb

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 13/10/2022 22:19:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` enum('super admin','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admins_username_unique`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'Admin', 'admin', '$2y$10$gWgeQgqyC61CL.xEmcB.7egOdWqqjsTv/dc3YqNbH7lEc/5j.KQTO', NULL, 'Zsw47mT2Qd@gmail.com', 'super admin', NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES (1, 'img/slider/1.jpg', '#', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `banners` VALUES (2, 'img/slider/2.jpg', '#', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `banners` VALUES (3, 'img/slider/3.jpg', '#', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for booking_sequences
-- ----------------------------
DROP TABLE IF EXISTS `booking_sequences`;
CREATE TABLE `booking_sequences`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_sequence` date NOT NULL,
  `current_sequence` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of booking_sequences
-- ----------------------------

-- ----------------------------
-- Table structure for bookings
-- ----------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_id` int NOT NULL,
  `from_master_area_id` int NOT NULL,
  `from_master_area_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` int NULL DEFAULT NULL,
  `from_master_sub_area_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_master_area_id` int NOT NULL,
  `to_master_area_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` int NULL DEFAULT NULL,
  `to_master_sub_area_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vehicle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime_departure` datetime NOT NULL,
  `schedule_type` enum('shuttle','charter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passanger_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passanger_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_adult` int NOT NULL,
  `qty_baby` int NOT NULL,
  `special_request` tinyint(1) NOT NULL DEFAULT 0,
  `flight_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `luggage_qty` int NOT NULL,
  `luggage_price` decimal(19, 2) NOT NULL,
  `extra_price` decimal(19, 2) NOT NULL,
  `voucher_id` bigint UNSIGNED NULL DEFAULT NULL,
  `promo_price` decimal(19, 2) NOT NULL,
  `base_price` decimal(19, 2) NOT NULL,
  `total_price` decimal(19, 2) NOT NULL,
  `booking_status` enum('pending','active','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('waiting','paid','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_payment` decimal(19, 2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bookings_voucher_id_foreign`(`voucher_id` ASC) USING BTREE,
  CONSTRAINT `bookings_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bookings
-- ----------------------------

-- ----------------------------
-- Table structure for charters
-- ----------------------------
DROP TABLE IF EXISTS `charters`;
CREATE TABLE `charters`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_type` enum('airport','district') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_master_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vehicle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price` decimal(19, 2) NOT NULL,
  `driver_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of charters
-- ----------------------------
INSERT INTO `charters` VALUES (1, 'airport', '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', 1, NULL, 100.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `charters` VALUES (2, 'airport', '1', NULL, '2', '8', 'Avanza 2', 'B 9876 CCD', 1, NULL, 100.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `charters` VALUES (3, 'district', '2', '7', '1', NULL, 'Avanza 1', 'B 1234 CCD', 1, NULL, 100.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `charters` VALUES (4, 'district', '2', '8', '1', NULL, 'Avanza 2', 'B 9876 CCD', 1, NULL, 100.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for master_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_areas`;
CREATE TABLE `master_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_type` enum('departure','arrival') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_areas
-- ----------------------------
INSERT INTO `master_areas` VALUES (1, 'Jakarta - Bandara Internasional Soekarno-Hatta', 'departure', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_areas` VALUES (2, 'Jakarta Utara', 'arrival', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_areas` VALUES (3, 'Jakarta Timur', 'arrival', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_areas` VALUES (4, 'Jakarta Selatan', 'arrival', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_areas` VALUES (5, 'Jakarta Barat', 'arrival', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_areas` VALUES (6, 'Jakarta Pusat', 'arrival', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for master_special_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_special_areas`;
CREATE TABLE `master_special_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `master_sub_area_id` bigint UNSIGNED NOT NULL,
  `first_person_price` decimal(19, 2) UNSIGNED NOT NULL,
  `extra_person_price` decimal(19, 2) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `master_special_areas_master_sub_area_id_foreign`(`master_sub_area_id` ASC) USING BTREE,
  CONSTRAINT `master_special_areas_master_sub_area_id_foreign` FOREIGN KEY (`master_sub_area_id`) REFERENCES `master_sub_areas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_special_areas
-- ----------------------------
INSERT INTO `master_special_areas` VALUES (1, 7, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (2, 8, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (3, 9, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (4, 10, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (5, 11, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (6, 12, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (7, 13, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (8, 14, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (9, 15, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (10, 16, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (11, 17, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (12, 18, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (13, 19, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (14, 20, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (15, 21, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (16, 22, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (17, 23, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (18, 24, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (19, 25, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (20, 26, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (21, 27, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (22, 28, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (23, 29, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (24, 30, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (25, 31, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (26, 32, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (27, 33, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (28, 34, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (29, 35, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (30, 36, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (31, 37, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (32, 38, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (33, 39, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (34, 40, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (35, 41, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (36, 42, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (37, 43, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (38, 44, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (39, 45, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (40, 46, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_special_areas` VALUES (41, 47, 10.00, 5.00, 1, NULL, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for master_sub_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_sub_areas`;
CREATE TABLE `master_sub_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `master_area_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `master_sub_areas_master_area_id_foreign`(`master_area_id` ASC) USING BTREE,
  CONSTRAINT `master_sub_areas_master_area_id_foreign` FOREIGN KEY (`master_area_id`) REFERENCES `master_areas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_sub_areas
-- ----------------------------
INSERT INTO `master_sub_areas` VALUES (1, 1, 'Terminal 1A', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (2, 1, 'Terminal 1B', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (3, 1, 'Terminal 2D', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (4, 1, 'Terminal 2E', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (5, 1, 'Terminal 2F', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (6, 1, 'Terminal 3', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (7, 2, 'Cilincing', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (8, 2, 'Kelapa Gading', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (9, 2, 'Koja', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (10, 2, 'Pademangan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (11, 2, 'Penjaringan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (12, 2, 'Tanjung Priok', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (13, 3, 'Cakung', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (14, 3, 'Cipayung', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (15, 3, 'Ciracas', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (16, 3, 'Duren Sawit', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (17, 3, 'Jatinegara', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (18, 3, 'Kramat Jati', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (19, 3, 'Makasar', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (20, 3, 'Pasar Rebo', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (21, 3, 'Pulo Gadung', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (22, 4, 'Cilandak', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (23, 4, 'Jagakarsa', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (24, 4, 'Kebayoran baru', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (25, 4, 'Kebayoran Lama', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (26, 4, 'Mampang Prapatan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (27, 4, 'Pancoran', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (28, 4, 'Pasar Minggu', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (29, 4, 'Pesanggrahan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (30, 4, 'Setiabudi', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (31, 4, 'Tebet', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (32, 5, 'Cengkareng', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (33, 5, 'Grogol Petamburan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (34, 5, 'Taman Sari', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (35, 5, 'Tambora', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (36, 5, 'Kebon Jeruk', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (37, 5, 'Kalideres', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (38, 5, 'Palmerah', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (39, 5, 'Kembangan', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (40, 6, 'Cempaka Putih', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (41, 6, 'Gambir', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (42, 6, 'Johar Baru', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (43, 6, 'Kemayoran', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (44, 6, 'Menteng', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (45, 6, 'Sawah Besar', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (46, 6, 'Senen', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `master_sub_areas` VALUES (47, 6, 'Tanah Abang', 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_09_23_155543_create_banners_table', 1);
INSERT INTO `migrations` VALUES (6, '2022_09_24_202157_create_admins_table', 1);
INSERT INTO `migrations` VALUES (7, '2022_09_24_202341_create_pages_table', 1);
INSERT INTO `migrations` VALUES (8, '2022_09_24_202427_create_master_areas_table', 1);
INSERT INTO `migrations` VALUES (9, '2022_09_24_202444_create_master_sub_areas_table', 1);
INSERT INTO `migrations` VALUES (10, '2022_09_24_202502_create_master_special_areas_table', 1);
INSERT INTO `migrations` VALUES (11, '2022_09_24_202531_create_charters_table', 1);
INSERT INTO `migrations` VALUES (12, '2022_09_24_202531_create_schedule_shuttles_table', 1);
INSERT INTO `migrations` VALUES (13, '2022_09_24_202546_create_vouchers_table', 1);
INSERT INTO `migrations` VALUES (14, '2022_09_24_202600_create_bookings_table', 1);
INSERT INTO `migrations` VALUES (15, '2022_09_29_232653_create_booking_sequences_table', 1);

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES (1, 'Privacy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, provident.');
INSERT INTO `pages` VALUES (2, 'Term and Condition', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores recusandae exercitationem ipsa ab amet! Sed tempore maxime officiis possimus molestiae!');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for schedule_shuttles
-- ----------------------------
DROP TABLE IF EXISTS `schedule_shuttles`;
CREATE TABLE `schedule_shuttles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_master_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_master_sub_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_master_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_master_sub_area_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vehicle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_departure` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price` decimal(19, 2) NOT NULL,
  `driver_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `total_seat` int UNSIGNED NOT NULL,
  `luggage_price` decimal(19, 2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of schedule_shuttles
-- ----------------------------
INSERT INTO `schedule_shuttles` VALUES (1, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '01:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (2, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '04:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (3, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '07:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (4, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '10:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (5, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '13:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (6, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '16:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (7, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '19:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (8, '1', NULL, '2', '7', 'Avanza 1', 'B 1234 CCD', '22:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (9, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '01:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (10, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '04:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (11, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '07:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (12, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '10:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (13, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '13:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (14, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '16:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (15, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '19:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `schedule_shuttles` VALUES (16, '2', '7', '1', NULL, 'Avanza 2', 'B 9876 CCD', '22:00:00', 1, NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', 20, 5.00, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_phone_unique`(`phone` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for vouchers
-- ----------------------------
DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_expired` date NOT NULL,
  `discount_type` enum('percentage','value') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` decimal(19, 2) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vouchers
-- ----------------------------
INSERT INTO `vouchers` VALUES (1, 'Discount 10%', 'promo10%', '2022-09-01', '2022-10-31', 'percentage', 10.00, 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);
INSERT INTO `vouchers` VALUES (2, 'Media Social Promo', 'medsos', '2022-09-01', '2022-10-31', 'value', 5.00, 1, '2022-10-13 21:44:48', '2022-10-13 21:44:48', NULL);

SET FOREIGN_KEY_CHECKS = 1;
