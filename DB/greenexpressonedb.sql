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

 Date: 28/09/2022 13:22:42
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
INSERT INTO `admins` VALUES (1, 'Admin', 'admin', '$2y$10$L3RNIeT5AbWxRSaavqFKse.A92L1eFeYDd1bpvDT8zBQtD6yw1TLq', NULL, 'OFZLDcH3Z6@gmail.com', 'super admin', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES (1, 'http://127.0.0.1:8000/1.png', '#', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `banners` VALUES (2, 'http://127.0.0.1:8000/2.png', '#', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `banners` VALUES (3, 'http://127.0.0.1:8000/3.png', '#', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

-- ----------------------------
-- Table structure for bookings
-- ----------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint UNSIGNED NOT NULL,
  `from_id` int NOT NULL,
  `from_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_id` int NOT NULL,
  `to_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `vehicle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime_departure` datetime NOT NULL,
  `datetime_arrival` datetime NOT NULL,
  `schedule_type` enum('one way','charter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `qty_adult` int NOT NULL,
  `qty_baby` int NOT NULL,
  `is_extra` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flight_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `luggage_qty` int NOT NULL,
  `luggage_price` decimal(19, 2) NOT NULL,
  `extra_price` decimal(19, 2) NOT NULL,
  `voucher_id` bigint UNSIGNED NULL DEFAULT NULL,
  `promo_price` decimal(19, 2) NOT NULL,
  `total_price` decimal(19, 2) NOT NULL,
  `booking_status` enum('active','used','waiting payment','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_payment` decimal(19, 2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bookings_schedule_id_foreign`(`schedule_id` ASC) USING BTREE,
  INDEX `bookings_vehicle_id_foreign`(`vehicle_id` ASC) USING BTREE,
  INDEX `bookings_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `bookings_voucher_id_foreign`(`voucher_id` ASC) USING BTREE,
  CONSTRAINT `bookings_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookings_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bookings
-- ----------------------------

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
-- Table structure for luggage_prices
-- ----------------------------
DROP TABLE IF EXISTS `luggage_prices`;
CREATE TABLE `luggage_prices`  (
  `price` decimal(19, 2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`price`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of luggage_prices
-- ----------------------------
INSERT INTO `luggage_prices` VALUES (1.00);

-- ----------------------------
-- Table structure for master_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_areas`;
CREATE TABLE `master_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_type` enum('departure','arrival') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_areas
-- ----------------------------
INSERT INTO `master_areas` VALUES (1, 'Jakarta - Bandara Internasional Soekarno-Hatta', 'departure', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (2, 'Jakarta Utara', 'arrival', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (3, 'Jakarta Timur', 'arrival', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (4, 'Jakarta Selatan', 'arrival', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (5, 'Jakarta Barat', 'arrival', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (6, 'Jakarta Pusat', 'arrival', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_areas` VALUES (7, 'Cilandak', 'departure', 'yes', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for master_special_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_special_areas`;
CREATE TABLE `master_special_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `master_sub_area_id` bigint UNSIGNED NOT NULL,
  `first_person_price` decimal(19, 2) UNSIGNED NOT NULL,
  `extra_person_price` decimal(19, 2) UNSIGNED NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `master_special_areas` VALUES (1, 7, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (2, 8, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (3, 9, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (4, 10, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (5, 11, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (6, 12, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (7, 13, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (8, 14, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (9, 15, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (10, 16, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (11, 17, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (12, 18, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (13, 19, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (14, 20, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (15, 21, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (16, 22, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (17, 23, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (18, 24, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (19, 25, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (20, 26, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (21, 27, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (22, 28, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (23, 29, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (24, 30, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (25, 31, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (26, 32, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (27, 33, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (28, 34, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (29, 35, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (30, 36, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (31, 37, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (32, 38, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (33, 39, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (34, 40, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (35, 41, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (36, 42, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (37, 43, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (38, 44, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (39, 45, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (40, 46, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_special_areas` VALUES (41, 47, 10.00, 5.00, 'yes', NULL, '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

-- ----------------------------
-- Table structure for master_sub_areas
-- ----------------------------
DROP TABLE IF EXISTS `master_sub_areas`;
CREATE TABLE `master_sub_areas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `master_area_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `master_sub_areas` VALUES (1, 1, 'Terminal 1A', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (2, 1, 'Terminal 1B', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (3, 1, 'Terminal 2D', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (4, 1, 'Terminal 2E', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (5, 1, 'Terminal 2F', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (6, 1, 'Terminal 3', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (7, 2, 'Cilincing', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (8, 2, 'Kelapa Gading', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (9, 2, 'Koja', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (10, 2, 'Pademangan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (11, 2, 'Penjaringan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (12, 2, 'Tanjung Priok', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (13, 3, 'Cakung', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (14, 3, 'Cipayung', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (15, 3, 'Ciracas', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (16, 3, 'Duren Sawit', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (17, 3, 'Jatinegara', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (18, 3, 'Kramat Jati', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (19, 3, 'Makasar', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (20, 3, 'Pasar Rebo', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (21, 3, 'Pulo Gadung', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (22, 4, 'Cilandak', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (23, 4, 'Jagakarsa', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (24, 4, 'Kebayoran baru', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (25, 4, 'Kebayoran Lama', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (26, 4, 'Mampang Prapatan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (27, 4, 'Pancoran', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (28, 4, 'Pasar Minggu', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (29, 4, 'Pesanggrahan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (30, 4, 'Setiabudi', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (31, 4, 'Tebet', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (32, 5, 'Cengkareng', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (33, 5, 'Grogol Petamburan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (34, 5, 'Taman Sari', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (35, 5, 'Tambora', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (36, 5, 'Kebon Jeruk', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (37, 5, 'Kalideres', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (38, 5, 'Palmerah', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (39, 5, 'Kembangan', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (40, 6, 'Cempaka Putih', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (41, 6, 'Gambir', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (42, 6, 'Johar Baru', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (43, 6, 'Kemayoran', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (44, 6, 'Menteng', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (45, 6, 'Sawah Besar', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (46, 6, 'Senen', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `master_sub_areas` VALUES (47, 6, 'Tanah Abang', 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_09_23_155543_create_banners_table', 1);
INSERT INTO `migrations` VALUES (6, '2022_09_24_202157_create_admins_table', 1);
INSERT INTO `migrations` VALUES (7, '2022_09_24_202325_create_luggage_prices_table', 1);
INSERT INTO `migrations` VALUES (8, '2022_09_24_202341_create_privacies_table', 1);
INSERT INTO `migrations` VALUES (9, '2022_09_24_202354_create_term_and_conditions_table', 1);
INSERT INTO `migrations` VALUES (10, '2022_09_24_202427_create_master_areas_table', 1);
INSERT INTO `migrations` VALUES (11, '2022_09_24_202444_create_master_sub_areas_table', 1);
INSERT INTO `migrations` VALUES (12, '2022_09_24_202502_create_master_special_areas_table', 1);
INSERT INTO `migrations` VALUES (13, '2022_09_24_202517_create_vehicles_table', 1);
INSERT INTO `migrations` VALUES (14, '2022_09_24_202531_create_schedules_table', 1);
INSERT INTO `migrations` VALUES (15, '2022_09_24_202546_create_bookings_table', 1);
INSERT INTO `migrations` VALUES (16, '2022_09_24_202600_create_vouchers_table', 1);

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES (1, 'App\\Models\\User', 1, '+6282114578976', '94dc499834e17b311d6748a5062e90d7d6d463363d9e4e2453754b3438d2c38e', '[\"*\"]', NULL, NULL, '2022-09-27 14:21:32', '2022-09-27 14:21:32');

-- ----------------------------
-- Table structure for privacies
-- ----------------------------
DROP TABLE IF EXISTS `privacies`;
CREATE TABLE `privacies`  (
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of privacies
-- ----------------------------
INSERT INTO `privacies` VALUES ('Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, architecto!');

-- ----------------------------
-- Table structure for schedules
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_id` int NOT NULL,
  `from_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_id` int NOT NULL,
  `to_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `datetime_departure` datetime NOT NULL,
  `datetime_arrival` datetime NOT NULL,
  `schedule_type` enum('one way','charter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `normal_price` decimal(19, 2) NOT NULL,
  `driver_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `schedules_vehicle_id_foreign`(`vehicle_id` ASC) USING BTREE,
  CONSTRAINT `schedules_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of schedules
-- ----------------------------
INSERT INTO `schedules` VALUES (1, 1, 'master_sub_areas', 7, 'master_sub_areas', 1, '2022-09-27 14:21:25', '2022-09-27 18:21:25', 'one way', 'yes', NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `schedules` VALUES (2, 1, 'master_sub_areas', 7, 'master_sub_areas', 1, '2022-09-27 14:21:25', '2022-09-27 18:21:25', 'charter', 'yes', NULL, 25.00, '+62123456789', 'Lorem ipsum dolor sit amet.', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

-- ----------------------------
-- Table structure for term_and_conditions
-- ----------------------------
DROP TABLE IF EXISTS `term_and_conditions`;
CREATE TABLE `term_and_conditions`  (
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of term_and_conditions
-- ----------------------------
INSERT INTO `term_and_conditions` VALUES ('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Blanditiis similique sapiente autem dolorem amet fugit numquam repellendus voluptas fugiat tempore?');

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `page_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES (1, 'privacy', 'test');
INSERT INTO `test` VALUES (2, 'term and condition', 'test');

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'adam', '+6282114578976', '$2y$10$PLHbaxUHZEaq0Grg6WicY.W/TrTNLK.NE4YGya7FkaHE7FfTHOz1y', NULL, 'adam.pm77@gmail.com', NULL, '2022-09-27 14:21:32', '2022-09-27 14:21:32', NULL);

-- ----------------------------
-- Table structure for vehicles
-- ----------------------------
DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE `vehicles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_seat` int NOT NULL DEFAULT 0,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vehicles
-- ----------------------------
INSERT INTO `vehicles` VALUES (1, 'Car 1', 'B 1234 CCD', 15, NULL, 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `vehicles` VALUES (2, 'Car 2', 'B 5678 CCD', 19, NULL, 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

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
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vouchers
-- ----------------------------
INSERT INTO `vouchers` VALUES (1, 'Discount 10%', 'promo10%', '2022-09-01', '2022-10-31', 'percentage', 10.00, 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);
INSERT INTO `vouchers` VALUES (2, 'Media Social Promo', 'medsos', '2022-09-01', '2022-10-31', 'value', 5.00, 'yes', '2022-09-27 14:21:25', '2022-09-27 14:21:25', NULL);

SET FOREIGN_KEY_CHECKS = 1;
