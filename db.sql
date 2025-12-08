-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for unema
CREATE DATABASE IF NOT EXISTS `unema` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `unema`;

-- Dumping structure for table unema.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `showtime_id` bigint unsigned NOT NULL,
  `seats` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_showtime_id_foreign` (`showtime_id`),
  CONSTRAINT `bookings_showtime_id_foreign` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.bookings: ~37 rows (approximately)
INSERT INTO `bookings` (`id`, `user_id`, `showtime_id`, `seats`, `total_price`, `booking_code`, `status`, `created_at`, `updated_at`) VALUES
	(58, 133, 80, 'F5', 1000.00, 'BK6EJWEU8X', 'cancelled', '2025-11-25 05:23:05', '2025-11-25 05:26:15'),
	(59, 133, 80, 'G6', 1000.00, 'BKHLJLGAA5', 'pending', '2025-11-25 05:28:39', '2025-11-25 05:28:39'),
	(60, 134, 80, 'F8', 1000.00, 'BKUUPCMN9Q', 'pending', '2025-11-25 05:51:03', '2025-11-25 05:51:03'),
	(61, 134, 80, 'G7', 1000.00, 'BKSRUVB6U0', 'pending', '2025-11-25 06:21:21', '2025-11-25 06:21:21'),
	(62, 134, 80, 'G8', 1000.00, 'BK6WLCWNJY', 'pending', '2025-11-25 06:24:29', '2025-11-25 06:24:29'),
	(63, 134, 80, 'H8', 1000.00, 'BK3UTMVX9Q', 'pending', '2025-11-25 06:28:53', '2025-11-25 06:28:53'),
	(64, 134, 80, 'H7', 1000.00, 'BKPC2MN0UM', 'pending', '2025-11-25 06:29:23', '2025-11-25 06:29:23'),
	(65, 134, 80, 'H6', 1000.00, 'BKBXXFUCRN', 'pending', '2025-11-25 06:30:54', '2025-11-25 06:30:54'),
	(66, 134, 80, 'H5', 1000.00, 'BKICRX4DDE', 'pending', '2025-11-25 06:31:21', '2025-11-25 06:31:21'),
	(67, 134, 80, 'F7', 1000.00, 'BKTWY3YXPC', 'pending', '2025-11-25 06:33:10', '2025-11-25 06:33:10'),
	(68, 134, 80, 'E8', 1000.00, 'BK19JU0PZC', 'pending', '2025-11-25 06:33:33', '2025-11-25 06:33:33'),
	(69, 134, 80, 'D8', 1000.00, 'BK3KVYELRC', 'pending', '2025-11-25 06:35:14', '2025-11-25 06:35:14'),
	(70, 134, 80, 'E7', 1000.00, 'BK4MM0KVCG', 'pending', '2025-11-25 06:36:17', '2025-11-25 06:36:17'),
	(71, 134, 80, 'D7', 1000.00, 'BK6NELFTUG', 'pending', '2025-11-25 06:41:06', '2025-11-25 06:41:06'),
	(72, 134, 80, 'E6', 1000.00, 'BKOPEGHGKX', 'pending', '2025-11-25 06:45:42', '2025-11-25 06:45:42'),
	(73, 134, 80, 'H3', 1000.00, 'BK4995A0BP', 'pending', '2025-11-25 06:52:06', '2025-11-25 06:52:06'),
	(74, 134, 80, 'F6', 1000.00, 'BKBDOH85QS', 'pending', '2025-11-25 06:53:28', '2025-11-25 06:53:28'),
	(75, 134, 80, 'D6', 1000.00, 'BKLSDL8JCU', 'pending', '2025-11-25 07:02:46', '2025-11-25 07:02:46'),
	(76, 133, 80, 'E5', 1000.00, 'BK7GSNQBFQ', 'pending', '2025-11-25 07:07:43', '2025-11-25 07:07:43'),
	(77, 133, 80, 'F5', 1000.00, 'BKGONACMFC', 'pending', '2025-11-25 07:08:58', '2025-11-25 07:08:58'),
	(78, 133, 80, 'G5', 1000.00, 'BKLQHPC4KF', 'pending', '2025-11-25 07:11:01', '2025-11-25 07:11:01'),
	(79, 133, 80, 'H4', 1000.00, 'BK2XMH5XVT', 'pending', '2025-11-25 07:25:15', '2025-11-25 07:25:15'),
	(80, 133, 80, 'D5', 1000.00, 'BK4AWX0AFQ', 'pending', '2025-11-25 07:26:01', '2025-11-25 07:26:01'),
	(81, 133, 80, 'G4', 1000.00, 'BKYZSEHVXB', 'pending', '2025-11-25 07:28:24', '2025-11-25 07:28:24'),
	(82, 133, 80, 'F4', 1000.00, 'BKKSOXKBDN', 'pending', '2025-11-25 07:36:09', '2025-11-25 07:36:09'),
	(83, 133, 80, 'G3', 1000.00, 'BKFDF2TIZDIO', 'pending', '2025-11-25 07:41:19', '2025-11-25 07:41:19'),
	(84, 133, 80, 'F3', 1000.00, 'BKKW394R1E', 'pending', '2025-11-25 07:41:55', '2025-11-25 07:41:55'),
	(85, 133, 80, 'E4', 1000.00, 'BKOUU7VR0M', 'pending', '2025-11-25 07:44:27', '2025-11-25 07:44:27'),
	(86, 133, 80, 'E3', 1000.00, 'BK6PMBVBEL', 'cancelled', '2025-11-25 07:46:23', '2025-11-27 04:46:33'),
	(87, 133, 80, 'D4', 1000.00, 'BK4QH07JN8', 'pending', '2025-11-27 04:29:07', '2025-11-27 04:29:07'),
	(88, 133, 80, 'D3', 1000.00, 'BKFSHBIQIW', 'pending', '2025-11-27 04:36:15', '2025-11-27 04:36:15'),
	(89, 133, 80, 'H2', 1000.00, 'BKNA9Y0NDR', 'pending', '2025-11-27 04:46:03', '2025-11-27 04:46:03'),
	(90, 133, 80, 'E3', 1000.00, 'BKDAKWIXCJ', 'pending', '2025-11-27 04:46:45', '2025-11-27 04:46:45'),
	(91, 133, 80, 'G2', 1000.00, 'BKOJETZA0N', 'pending', '2025-11-27 04:51:03', '2025-11-27 04:51:03'),
	(92, 133, 80, 'F2', 1000.00, 'BKVQY70GL4', 'pending', '2025-11-27 04:51:37', '2025-11-27 04:51:37'),
	(93, 133, 80, 'E2', 1000.00, 'BKBA5XGTGK', 'pending', '2025-11-27 04:54:04', '2025-11-27 04:54:04'),
	(94, 133, 80, 'D2', 1000.00, 'BKWGNARBM1', 'confirmed', '2025-11-27 05:15:47', '2025-11-27 06:52:08'),
	(95, 133, 80, 'H1', 1000.00, 'BK1RRB4XNH', 'pending', '2025-11-27 07:24:43', '2025-11-27 07:24:43'),
	(96, 133, 80, 'G1', 1000.00, 'BKADAQJOJA', 'pending', '2025-11-27 07:25:52', '2025-11-27 07:25:52'),
	(97, 164, 92, 'F5', 50000.00, 'BKD5B0343D', 'pending', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(98, 181, 106, 'H10', 50000.00, 'BKFD8E01A9', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(99, 179, 108, 'E2', 50000.00, 'BK2E5B58E0', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(100, 181, 124, 'A9', 50000.00, 'BK28C952D4', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(101, 174, 94, 'B3', 50000.00, 'BK29260FD4', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(102, 155, 127, 'C8', 50000.00, 'BK10D03601', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(103, 174, 80, 'F2', 50000.00, 'BKE4454A26', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(104, 184, 100, 'A8', 50000.00, 'BKBBA7636F', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(105, 138, 82, 'F5', 50000.00, 'BK5D7B84D2', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(106, 135, 92, 'G5', 50000.00, 'BK152A11CD', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(107, 145, 84, 'C4', 50000.00, 'BK428929DD', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(108, 145, 122, 'A5', 50000.00, 'BK867AF6C3', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(109, 165, 104, 'D9', 50000.00, 'BK9ED53AB5', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(110, 176, 111, 'F5', 50000.00, 'BKC3EB82E4', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(111, 135, 104, 'C1', 50000.00, 'BK9ABEA16C', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(112, 147, 130, 'E1', 50000.00, 'BK5A50B11F', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(113, 166, 119, 'H3', 50000.00, 'BK33535019', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(114, 161, 123, 'H3', 50000.00, 'BK6E119856', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(115, 184, 106, 'A6', 50000.00, 'BKB9AC3788', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(116, 143, 115, 'C6', 50000.00, 'BKFBA8BF05', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(117, 182, 93, 'A2', 50000.00, 'BK93833A3E', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(118, 155, 100, 'F2', 50000.00, 'BK7BDCEAB5', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(119, 146, 98, 'D1', 50000.00, 'BK6212D701', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(120, 135, 88, 'H5', 50000.00, 'BK9964BA89', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(121, 157, 82, 'F6', 50000.00, 'BK3485946E', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(122, 147, 109, 'C2', 50000.00, 'BKB25CA807', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(123, 169, 107, 'A4', 50000.00, 'BK00CADB5D', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(124, 174, 93, 'C6', 50000.00, 'BKF1143FAA', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(125, 166, 95, 'H9', 50000.00, 'BK6F4501E9', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(126, 152, 99, 'C4', 50000.00, 'BKEB6A3502', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(127, 146, 118, 'E4', 50000.00, 'BKF7A2AA1C', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(128, 184, 128, 'H5', 50000.00, 'BK65EA9220', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(129, 159, 96, 'C7', 50000.00, 'BK7CCB6DD7', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(130, 162, 112, 'B9', 50000.00, 'BKF4C15FA6', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(131, 157, 101, 'G3', 50000.00, 'BKE83FE94E', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(132, 172, 87, 'F2', 50000.00, 'BK05CF8829', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(133, 171, 102, 'H5', 50000.00, 'BK1D2FC03B', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(134, 165, 126, 'G1', 50000.00, 'BK1ABD3A24', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(135, 146, 114, 'G10', 50000.00, 'BK0E113152', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(136, 136, 121, 'E5', 50000.00, 'BK77BE2E85', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(137, 142, 117, 'B10', 50000.00, 'BK5E7F025D', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(138, 169, 91, 'H10', 50000.00, 'BK6B9F7A5C', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(139, 150, 116, 'C10', 50000.00, 'BKD72F336A', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(140, 138, 102, 'A5', 50000.00, 'BK0FEEF9DB', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(141, 177, 115, 'F5', 50000.00, 'BKDC98C2DB', 'confirmed', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(142, 170, 91, 'A3', 50000.00, 'BK3A23C12C', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(143, 153, 91, 'C2', 50000.00, 'BKFADE4300', 'pending', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(144, 169, 93, 'C10', 50000.00, 'BKE4814EC3', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(145, 179, 97, 'C10', 50000.00, 'BKDFB89475', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(146, 146, 111, 'C10', 50000.00, 'BK52A46804', 'cancelled', '2025-12-01 11:47:04', '2025-12-01 11:47:04');

-- Dumping structure for table unema.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.cache: ~0 rows (approximately)

-- Dumping structure for table unema.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.cache_locks: ~0 rows (approximately)

-- Dumping structure for table unema.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table unema.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.jobs: ~0 rows (approximately)

-- Dumping structure for table unema.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.job_batches: ~0 rows (approximately)

-- Dumping structure for table unema.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.migrations: ~4 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_01_01_000000_add_columns_to_users_table', 1),
	(5, '2024_01_01_000001_create_movies_table', 1),
	(6, '2024_01_01_000002_create_showtimes_table', 1),
	(7, '2024_01_01_000003_create_bookings_table', 1),
	(8, '2024_01_01_000004_create_reviews_table', 1),
	(9, '2024_01_01_000005_create_sessions_table', 1);

-- Dumping structure for table unema.movies
CREATE TABLE IF NOT EXISTS `movies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `poster_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'https://www.rawpixel.com/search/Public%20domain%20movies',
  `trailer_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('now_showing','coming_soon') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'now_showing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.movies: ~53 rows (approximately)
INSERT INTO `movies` (`id`, `title`, `description`, `poster_url`, `trailer_url`, `duration`, `rating`, `release_date`, `genre`, `status`, `created_at`, `updated_at`) VALUES
	(126, 'Captain America: The Winter Soldier', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://youtu.be/D8Qxxq0Oh9M?si=Zsa7fDcmIhKj_ROU', 136, 4.0, '2024-04-04', 'Action, Adventure', 'now_showing', '2025-11-24 04:42:45', '2025-11-27 07:07:23'),
	(127, 'The Avengers', 'Earth\'s mightiest heroes must come together to stop Loki from conquering Earth.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 143, 4.8, '2024-05-01', 'Action, Sci-Fi', 'now_showing', '2025-11-24 04:42:45', '2025-11-24 04:42:45'),
	(128, 'Iron Man', 'After being held captive, billionaire Tony Stark creates a unique weapon suit to fight evil.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', NULL, 126, 4.5, '2024-06-15', 'Action, Adventure', 'coming_soon', '2025-11-24 04:42:45', '2025-11-24 04:42:45'),
	(129, 'Movie Title 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 147, 3.5, '2025-09-11', 'Drama', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(130, 'Movie Title 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 101, 1.7, '2025-08-28', 'Sci-Fi', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(131, 'Movie Title 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 92, 2.4, '2025-05-07', 'Sci-Fi', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(132, 'Movie Title 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 129, 1.0, '2025-11-19', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(133, 'Movie Title 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 102, 4.3, '2025-06-03', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(134, 'Movie Title 6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 131, 4.5, '2025-09-09', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(135, 'Movie Title 7', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 130, 1.8, '2025-11-29', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(136, 'Movie Title 8', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 132, 3.3, '2025-02-21', 'Action', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(137, 'Movie Title 9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 130, 1.3, '2025-07-30', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(138, 'Movie Title 10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 143, 1.2, '2025-05-08', 'Horror', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(139, 'Movie Title 11', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 116, 1.5, '2025-08-16', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(140, 'Movie Title 12', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 134, 4.4, '2025-10-29', 'Sci-Fi', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(141, 'Movie Title 13', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 91, 3.9, '2025-05-01', 'Horror', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(142, 'Movie Title 14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 117, 2.9, '2024-12-18', 'Drama', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(143, 'Movie Title 15', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 96, 2.6, '2025-03-15', 'Drama', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(144, 'Movie Title 16', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 148, 1.3, '2025-06-20', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(145, 'Movie Title 17', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 130, 1.5, '2025-05-08', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(146, 'Movie Title 18', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 108, 2.2, '2025-05-05', 'Sci-Fi', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(147, 'Movie Title 19', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 123, 3.0, '2025-02-13', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(148, 'Movie Title 20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 117, 3.8, '2025-11-10', 'Drama', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(149, 'Movie Title 21', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 103, 1.5, '2025-11-20', 'Horror', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(150, 'Movie Title 22', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 93, 2.1, '2025-08-29', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(151, 'Movie Title 23', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 143, 1.6, '2025-11-03', 'Sci-Fi', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(152, 'Movie Title 24', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 105, 1.4, '2025-03-28', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(153, 'Movie Title 25', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 110, 1.3, '2025-08-08', 'Drama', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(154, 'Movie Title 26', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 134, 4.2, '2025-03-04', 'Drama', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(155, 'Movie Title 27', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 102, 3.7, '2025-02-10', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(156, 'Movie Title 28', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 129, 4.0, '2025-03-01', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(157, 'Movie Title 29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 96, 3.1, '2025-08-10', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(158, 'Movie Title 30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 144, 3.5, '2025-07-25', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(159, 'Movie Title 31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 107, 3.3, '2024-12-14', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(160, 'Movie Title 32', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 127, 3.8, '2025-04-13', 'Action', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(161, 'Movie Title 33', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 92, 4.4, '2025-10-10', 'Action', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(162, 'Movie Title 34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 110, 3.6, '2025-10-05', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(163, 'Movie Title 35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 140, 3.0, '2024-12-10', 'Drama', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(164, 'Movie Title 36', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 97, 2.7, '2025-02-21', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(165, 'Movie Title 37', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 112, 4.8, '2025-03-27', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(166, 'Movie Title 38', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 132, 3.2, '2025-04-28', 'Drama', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(167, 'Movie Title 39', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 127, 2.5, '2024-12-29', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(168, 'Movie Title 40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 142, 3.6, '2025-03-21', 'Comedy', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(169, 'Movie Title 41', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 134, 2.5, '2025-04-08', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(170, 'Movie Title 42', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 132, 3.8, '2025-07-29', 'Horror', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(171, 'Movie Title 43', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 90, 2.9, '2025-08-14', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(172, 'Movie Title 44', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 146, 3.9, '2025-02-22', 'Horror', 'coming_soon', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(173, 'Movie Title 45', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 102, 1.9, '2025-05-27', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(174, 'Movie Title 46', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 141, 3.2, '2025-09-08', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(175, 'Movie Title 47', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 99, 3.4, '2025-05-20', 'Sci-Fi', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(176, 'Movie Title 48', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 118, 4.7, '2025-09-29', 'Action', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(177, 'Movie Title 49', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 125, 1.1, '2025-08-03', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(178, 'Movie Title 50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://img.freepik.com/free-photo/movie-background-collage_23-2149876004.jpg?semt=ais_hybrid&w=740&q=80', 'https://www.youtube.com/watch?v=dummy', 91, 1.9, '2025-11-17', 'Comedy', 'now_showing', '2025-12-01 11:47:03', '2025-12-01 11:47:03');

-- Dumping structure for table unema.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_movie_id_foreign` (`movie_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.reviews: ~0 rows (approximately)
INSERT INTO `reviews` (`id`, `movie_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
	(4, 126, 133, 4, 'mantap sekali filmnya', '2025-11-27 07:07:23', '2025-11-27 07:07:23'),
	(5, 172, 166, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(6, 158, 136, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(7, 129, 170, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(8, 165, 173, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(9, 130, 156, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(10, 147, 150, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(11, 137, 151, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(12, 143, 157, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(13, 165, 155, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(14, 147, 139, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(15, 136, 142, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(16, 131, 183, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(17, 130, 184, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(18, 154, 149, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(19, 171, 157, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(20, 141, 163, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(21, 162, 172, 5, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(22, 162, 182, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(23, 167, 147, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(24, 134, 146, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(25, 155, 148, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(26, 139, 141, 5, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(27, 176, 171, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(28, 155, 181, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(29, 147, 168, 5, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(30, 134, 138, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(31, 151, 178, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(32, 162, 133, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(33, 166, 170, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(34, 169, 151, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(35, 133, 142, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(36, 173, 156, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(37, 158, 150, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(38, 139, 159, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(39, 159, 137, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(40, 152, 167, 5, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(41, 126, 150, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(42, 168, 136, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(43, 177, 150, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(44, 132, 161, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(45, 126, 173, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(46, 140, 148, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(47, 164, 175, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(48, 178, 173, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(49, 168, 140, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(50, 148, 146, 4, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(51, 146, 141, 2, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(52, 162, 144, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(53, 132, 160, 3, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04'),
	(54, 161, 150, 1, 'Automated dummy review comment for testing purposes.', '2025-12-01 11:47:04', '2025-12-01 11:47:04');

-- Dumping structure for table unema.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.sessions: ~8 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('8utUxLcseqYiiYJiRDx7L9yv3DLEuWIlMwx11jyA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDRJNHVEMFFyRGQ2bVFNaDB6bVllYXVvelJmUklKem9YTzFlZXBMRCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764591667),
	('Al15vV2IxKrEiec540IzbA2HY3ZqIIkW4JpRkGLk', 133, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOXRnUWdqWVo2MkxCU0JqNG44QTc5OU5OaDc5TjhsaXVrRmpDeFFWSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTMzO30=', 1764592462),
	('nsZXYsC95uvV4Grv3fw1P8iFnKCuYMYVswjj5SwZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibk9VR1BMSk1jUjd0NVpINlBHSE9MdERvRm9YOW5KMGpDNWR4WmNUZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764591667);

-- Dumping structure for table unema.showtimes
CREATE TABLE IF NOT EXISTS `showtimes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `studio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_seats` int NOT NULL DEFAULT '0',
  `total_seats` int NOT NULL DEFAULT '50',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `showtimes_movie_id_foreign` (`movie_id`),
  CONSTRAINT `showtimes_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.showtimes: ~0 rows (approximately)
INSERT INTO `showtimes` (`id`, `movie_id`, `show_date`, `show_time`, `studio`, `price`, `available_seats`, `total_seats`, `created_at`, `updated_at`) VALUES
	(80, 126, '2025-11-28', '07:00:00', 'Studio 1', 1000.00, 50, 50, '2025-11-24 04:43:48', '2025-11-27 04:22:29'),
	(81, 156, '2025-12-02', '16:37:57', 'Studio 2', 50000.00, 32, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(82, 135, '2025-12-01', '20:36:47', 'Studio 2', 35000.00, 12, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(83, 148, '2025-12-08', '11:08:08', 'Studio 4', 50000.00, 3, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(84, 132, '2025-12-07', '01:01:20', 'Studio 5', 50000.00, 36, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(85, 174, '2025-12-03', '03:46:52', 'Studio 2', 35000.00, 12, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(86, 133, '2025-12-03', '07:59:41', 'Studio 1', 35000.00, 40, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(87, 153, '2025-12-03', '08:26:11', 'Studio 1', 35000.00, 18, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(88, 135, '2025-12-07', '00:38:25', 'Studio 5', 50000.00, 1, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(89, 140, '2025-12-12', '14:45:11', 'Studio 3', 35000.00, 11, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(90, 162, '2025-12-11', '11:29:18', 'Studio 2', 35000.00, 4, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(91, 173, '2025-12-12', '07:34:07', 'Studio 2', 50000.00, 45, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(92, 129, '2025-12-12', '21:52:01', 'Studio 1', 50000.00, 46, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(93, 174, '2025-12-06', '13:43:43', 'Studio 4', 50000.00, 26, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(94, 142, '2025-12-06', '17:26:28', 'Studio 3', 50000.00, 18, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(95, 169, '2025-12-07', '05:23:35', 'Studio 5', 50000.00, 12, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(96, 163, '2025-12-01', '12:11:14', 'Studio 2', 50000.00, 9, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(97, 172, '2025-12-02', '17:00:43', 'Studio 2', 35000.00, 16, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(98, 152, '2025-12-08', '09:11:05', 'Studio 2', 50000.00, 17, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(99, 156, '2025-12-08', '13:52:18', 'Studio 2', 50000.00, 30, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(100, 129, '2025-12-14', '06:53:59', 'Studio 3', 35000.00, 26, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(101, 153, '2025-12-11', '08:50:49', 'Studio 3', 35000.00, 25, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(102, 154, '2025-12-13', '01:36:28', 'Studio 4', 35000.00, 28, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(103, 178, '2025-12-03', '18:03:02', 'Studio 2', 50000.00, 22, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(104, 155, '2025-12-02', '19:56:15', 'Studio 4', 50000.00, 36, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(105, 158, '2025-12-07', '09:37:30', 'Studio 4', 35000.00, 2, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(106, 178, '2025-12-01', '03:14:23', 'Studio 3', 35000.00, 46, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(107, 132, '2025-12-05', '09:53:39', 'Studio 1', 35000.00, 15, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(108, 167, '2025-12-02', '22:28:01', 'Studio 2', 50000.00, 9, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(109, 174, '2025-12-11', '15:47:22', 'Studio 5', 35000.00, 28, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(110, 144, '2025-12-05', '19:00:23', 'Studio 5', 50000.00, 5, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(111, 133, '2025-12-01', '01:50:51', 'Studio 2', 50000.00, 14, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(112, 149, '2025-12-10', '07:07:31', 'Studio 3', 50000.00, 13, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(113, 143, '2025-12-08', '02:46:07', 'Studio 5', 50000.00, 42, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(114, 169, '2025-12-11', '03:01:31', 'Studio 3', 35000.00, 21, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(115, 148, '2025-12-04', '22:31:04', 'Studio 5', 50000.00, 24, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(116, 151, '2025-12-05', '06:24:00', 'Studio 2', 35000.00, 32, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(117, 155, '2025-12-11', '06:15:37', 'Studio 1', 35000.00, 20, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(118, 153, '2025-12-09', '08:44:17', 'Studio 1', 50000.00, 38, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(119, 145, '2025-12-02', '12:03:09', 'Studio 2', 35000.00, 49, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(120, 126, '2025-12-10', '19:12:24', 'Studio 5', 50000.00, 30, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(121, 130, '2025-12-06', '18:54:01', 'Studio 4', 35000.00, 19, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(122, 159, '2025-12-06', '01:15:32', 'Studio 1', 50000.00, 7, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(123, 147, '2025-12-03', '06:14:08', 'Studio 4', 35000.00, 1, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(124, 158, '2025-12-05', '20:47:32', 'Studio 3', 50000.00, 48, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(125, 130, '2025-12-10', '06:22:46', 'Studio 2', 50000.00, 6, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(126, 172, '2025-12-08', '11:16:43', 'Studio 5', 35000.00, 42, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(127, 169, '2025-12-02', '15:55:25', 'Studio 5', 50000.00, 36, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(128, 176, '2025-12-10', '20:10:47', 'Studio 1', 50000.00, 15, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(129, 174, '2025-12-01', '06:40:10', 'Studio 2', 50000.00, 0, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(130, 144, '2025-12-03', '00:38:36', 'Studio 3', 35000.00, 5, 50, '2025-12-01 11:47:03', '2025-12-01 11:47:03');

-- Dumping structure for table unema.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table unema.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `is_admin`, `created_at`, `updated_at`) VALUES
	(133, 'admin', 'admin@nema.com', '$2y$12$tpi6AY2lWaYyLBDqemkKPu2IgipCFDiA6bPgl/wKmxufl5YSM6iZ.', 'Administrator', '08123456789', 1, '2025-11-24 04:42:45', '2025-11-24 04:42:45'),
	(134, 'testuser', 'user@test.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Test User', '08123456780', 0, '2025-11-24 04:42:45', '2025-11-24 04:42:45'),
	(135, 'user_101662490311524352', 'user1_101662490311524353@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 1', '08125946501', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(136, 'user_101662490311524354', 'user2_101662490311524355@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 2', '08127370299', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(137, 'user_101662490311524356', 'user3_101662490311524357@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 3', '08129011992', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(138, 'user_101662490311524358', 'user4_101662490311524359@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 4', '08122949065', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(139, 'user_101662490311524360', 'user5_101662490311524361@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 5', '08127709350', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(140, 'user_101662490311524362', 'user6_101662490311524363@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 6', '08129699555', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(141, 'user_101662490311524364', 'user7_101662490311524365@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 7', '08125369726', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(142, 'user_101662490311524366', 'user8_101662490311524367@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 8', '08127749968', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(143, 'user_101662490311524368', 'user9_101662490311524369@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 9', '08122640660', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(144, 'user_101662490311524370', 'user10_101662490311524371@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 10', '08129953398', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(145, 'user_101662490311524372', 'user11_101662490311524373@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 11', '08121845010', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(146, 'user_101662490311524374', 'user12_101662490311524375@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 12', '08129364857', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(147, 'user_101662490311524376', 'user13_101662490311524377@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 13', '08121289258', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(148, 'user_101662490311524378', 'user14_101662490311524379@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 14', '08128351717', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(149, 'user_101662490311524380', 'user15_101662490311524381@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 15', '08127890814', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(150, 'user_101662490311524382', 'user16_101662490311524383@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 16', '08124398920', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(151, 'user_101662490311524384', 'user17_101662490311524385@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 17', '08128322157', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(152, 'user_101662490311524386', 'user18_101662490311524387@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 18', '08128414026', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(153, 'user_101662490311524388', 'user19_101662490311524389@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 19', '08127103662', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(154, 'user_101662490311524390', 'user20_101662490311524391@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 20', '0812276232', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(155, 'user_101662490311524392', 'user21_101662490311524393@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 21', '081270176', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(156, 'user_101662490311524394', 'user22_101662490311524395@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 22', '08129522184', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(157, 'user_101662490311524396', 'user23_101662490311524397@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 23', '08127400394', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(158, 'user_101662490311524398', 'user24_101662490311524399@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 24', '08128435419', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(159, 'user_101662490311524400', 'user25_101662490311524401@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 25', '08129975914', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(160, 'user_101662490311524402', 'user26_101662490311524403@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 26', '08124573312', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(161, 'user_101662490311524404', 'user27_101662490311524405@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 27', '08122938820', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(162, 'user_101662490311524406', 'user28_101662490311524407@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 28', '0812974165', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(163, 'user_101662490311524408', 'user29_101662490311524409@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 29', '08126054365', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(164, 'user_101662490311524410', 'user30_101662490311524411@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 30', '08127349329', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(165, 'user_101662490311524412', 'user31_101662490311524413@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 31', '08128583554', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(166, 'user_101662490311524414', 'user32_101662490311524415@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 32', '0812869782', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(167, 'user_101662490311524416', 'user33_101662490311524417@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 33', '08128598250', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(168, 'user_101662490311524418', 'user34_101662490311524419@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 34', '0812381906', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(169, 'user_101662490311524420', 'user35_101662490311524421@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 35', '08126114780', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(170, 'user_101662490311524422', 'user36_101662490311524423@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 36', '08129428182', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(171, 'user_101662490311524424', 'user37_101662490311524425@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 37', '08128796571', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(172, 'user_101662490311524426', 'user38_101662490311524427@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 38', '08125698308', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(173, 'user_101662490311524428', 'user39_101662490311524429@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 39', '08122101829', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(174, 'user_101662490311524430', 'user40_101662490311524431@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 40', '08123414220', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(175, 'user_101662490311524432', 'user41_101662490311524433@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 41', '0812765615', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(176, 'user_101662490311524434', 'user42_101662490311524435@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 42', '08123585414', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(177, 'user_101662490311524436', 'user43_101662490311524437@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 43', '08125630228', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(178, 'user_101662490311524438', 'user44_101662490311524439@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 44', '08127394898', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(179, 'user_101662490311524440', 'user45_101662490311524441@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 45', '081283809', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(180, 'user_101662490311524442', 'user46_101662490311524443@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 46', '08128234350', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(181, 'user_101662490311524444', 'user47_101662490311524445@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 47', '0812920322', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(182, 'user_101662490311524446', 'user48_101662490311524447@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 48', '08129898563', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(183, 'user_101662490311524448', 'user49_101662490311524449@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 49', '08126731849', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03'),
	(184, 'user_101662490311524450', 'user50_101662490311524451@example.com', '$2y$12$KEKcpueZIuj/1i9ygBQMcuOUmj.xhLVoCxmPuH966.JGjrGfW.ZNu', 'Dummy User 50', '08123963557', 0, '2025-12-01 11:47:03', '2025-12-01 11:47:03');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
