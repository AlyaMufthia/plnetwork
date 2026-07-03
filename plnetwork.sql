-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 06:39 AM
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
-- Database: `plnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gangguans`
--

CREATE TABLE `gangguans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_laporan` varchar(255) NOT NULL,
  `no_tiket` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `gardu_induk` varchar(255) NOT NULL,
  `waktu_kejadian` datetime DEFAULT NULL,
  `status` enum('on_progress','paused','resolved') DEFAULT 'on_progress',
  `tahapan` tinyint(3) UNSIGNED DEFAULT 1,
  `jenis_gangguan` varchar(255) DEFAULT NULL,
  `status_jaringan` enum('UP','DOWN') DEFAULT 'DOWN',
  `foto_lokasi` varchar(255) DEFAULT NULL,
  `foto_petugas` varchar(255) DEFAULT NULL,
  `catatan_perbaikan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gangguans`
--

INSERT INTO `gangguans` (`id`, `id_laporan`, `no_tiket`, `ip_address`, `gardu_induk`, `waktu_kejadian`, `status`, `tahapan`, `jenis_gangguan`, `status_jaringan`, `foto_lokasi`, `foto_petugas`, `catatan_perbaikan`, `created_at`, `updated_at`) VALUES
(1, 'FLT-20260614-002', NULL, '10.16.176.1', 'UP3 MEDAN TIMUR', '2026-06-06 07:30:00', 'resolved', 4, NULL, 'DOWN', 'foto_gangguan/FWDObAjbs2oqRThzBjHExnLOArTvlfotiYhUAZxA.jpg', 'foto_gangguan/TAt6vKYx7Y8J3Hc30kxVVcCsUhypqmJS5u2iVvGO.jpg', 'Sedang antri masa perbaikan, jadi mohon ditunggu ya.', NULL, '2026-06-24 20:41:54'),
(2, 'FLT-20260617-002', NULL, '10.16.218.1', 'UP3 PADANG SIDEMPUAN', '2026-06-17 08:00:00', 'on_progress', 2, NULL, 'DOWN', NULL, NULL, 'sedang ada blackout.', NULL, NULL),
(3, 'LAP-20260626041526', NULL, '10.124.12', 'glugur', '2026-06-26 04:15:00', 'resolved', 4, NULL, 'DOWN', NULL, NULL, 'okeeee', '2026-06-25 21:15:26', '2026-06-25 21:19:48'),
(4, 'LAP-20260626045136', NULL, NULL, 'GI Tanjung Pura', '2026-06-26 04:51:36', 'on_progress', 1, NULL, 'DOWN', NULL, NULL, 'sedang ada kerusakan perangkat', '2026-06-25 21:51:36', '2026-06-25 21:51:36'),
(5, 'LAP-20260626045702', NULL, NULL, 'GI Asahan 1', '2026-06-26 04:57:02', 'on_progress', 1, NULL, 'DOWN', NULL, NULL, 'otwtwtwwtwttwttwttw', '2026-06-25 21:57:02', '2026-06-25 21:57:02'),
(6, 'LAP-20260628151917', NULL, NULL, 'GI Martabe', '2026-06-28 15:19:17', 'on_progress', 1, 'Ping Timeout', 'UP', NULL, NULL, 'otww yaaa bapak ibu semuanya', '2026-06-28 08:19:18', '2026-06-28 08:19:18'),
(7, 'LAP-20260628151954', NULL, NULL, 'GI Sei Mangke', '2026-06-28 15:19:54', 'on_progress', 1, 'Lainnya', 'UP', NULL, NULL, NULL, '2026-06-28 08:19:54', '2026-06-28 08:19:54'),
(8, 'LAP-20260628154030', NULL, NULL, 'GI Pangururan', '2026-06-28 15:40:30', 'on_progress', 1, 'Beban Berlebih', 'DOWN', NULL, NULL, 'sedang blackout, mohon bersabar', '2026-06-28 08:40:30', '2026-06-28 08:40:30'),
(9, 'LAP-20260629012902', NULL, NULL, 'GI Sei Mangke', '2026-06-29 01:29:02', 'on_progress', 1, 'Tegangan Drop', 'UP', NULL, NULL, 'okkkkkkkkkkkkkkkkkkkkkkkk', '2026-06-28 18:29:02', '2026-06-28 18:29:02'),
(10, 'LAP-20260630023600', NULL, NULL, '10.43.10.1 (Palo Alto)', '2026-06-30 02:36:00', 'on_progress', 1, 'Gangguan Jaringan', 'UP', NULL, NULL, NULL, '2026-06-29 19:36:00', '2026-06-29 19:36:00'),
(12, 'LAP-20260630040544', '30062026-0001', NULL, '10.43.50.17 (VMWare Host 1)', '2026-06-30 04:05:44', 'on_progress', 1, 'Tegangan Drop', 'UP', NULL, NULL, 'tegangan drop jadi yagitudehh', '2026-06-29 21:05:44', '2026-06-29 21:05:44'),
(13, 'LAP-20260630042611', '30062026-0002', NULL, '10.16.151.1 (ULP HELVETIA)', '2026-06-30 04:26:11', 'on_progress', 1, 'Gangguan Jaringan', 'DOWN', NULL, NULL, 'sedaang dalam perjalanan', '2026-06-29 21:26:11', '2026-06-29 21:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `gangguan_logs`
--

CREATE TABLE `gangguan_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gangguan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `tahapan` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gangguan_logs`
--

INSERT INTO `gangguan_logs` (`id`, `gangguan_id`, `tanggal`, `tahapan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(92, 1, '2026-06-02', 2, 'okiolkkkkkkkkkkkkkk', '2026-06-24 20:41:54', '2026-06-24 20:41:54'),
(93, 1, '2026-06-22', 3, 'ipehh kerenn', '2026-06-24 20:41:54', '2026-06-24 20:41:54'),
(94, 1, '2026-06-23', 2, 'alya sedang menulis', '2026-06-24 20:41:54', '2026-06-24 20:41:54'),
(95, 1, '2026-06-24', 1, 'ipehhhhhhhhhh', '2026-06-24 20:41:54', '2026-06-24 20:41:54'),
(96, 1, '2026-07-25', 4, 'alyyaaa anak hebatt', '2026-06-24 20:41:54', '2026-06-24 20:41:54'),
(99, 3, '2026-06-26', 2, 'lagiii jalann boss', '2026-06-25 21:19:48', '2026-06-25 21:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_25_022329_add_foto_to_gangguans_table', 2),
(5, '2026_06_24_021939_create_gangguans_table', 1),
(6, '2026_06_24_084926_create_gangguan_logs_table', 1),
(7, '2026_06_24_021939_create_gangguans_table', 1),
(8, '2026_06_24_084926_create_gangguan_logs_table', 1),
(9, '2026_06_24_021939_create_gangguans_table', 1),
(10, '2026_06_24_084926_create_gangguan_logs_table', 1),
(11, '2026_06_26_040447_add_jenis_gangguan_to_gangguans_table', 3),
(12, '2026_06_29_020444_add_missing_columns_to_gangguans_table', 4),
(13, '2026_06_30_032444_add_no_tiket_to_gangguans_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6JjVUb4U5C1nW9KSOv1T7wsKLBW3ZqI7hnv26JZg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.126.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'eyJfdG9rZW4iOiJaelNlWGhTYXZqMVJKSEZTRkxHRWpjUEU1bjI1NHdwTnl6b25nNktCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9yaXdheWF0Iiwicm91dGUiOiJyaXdheWF0LmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782787874),
('Jsvbct0nxUhPsxNOiJgMISkKHxCef8H1ghjut1xV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJhb0k5Y2FDbWhMdjdZUFR5Q0k0ZGZpMmdaR1pmZkVGdERTbkJ0WEtFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9yaXdheWF0Iiwicm91dGUiOiJyaXdheWF0LmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782794260);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `divisi` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `divisi`, `foto`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'El Putra', 'elranggacinta@gmail.com', NULL, 'foto-profil/fCffCpldHgfY5313AhHjj1aGwxOrREkA9IgaZtYI.jpg', NULL, '$2y$12$.Ig/0VQfxB9BZHCTahCZ4uJvN3DhFiwv0yt04ibAhguHI9aQ7ndGm', NULL, '2026-06-28 08:57:39', '2026-06-28 08:58:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `gangguans`
--
ALTER TABLE `gangguans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_laporan` (`id_laporan`),
  ADD UNIQUE KEY `gangguans_no_tiket_unique` (`no_tiket`);

--
-- Indexes for table `gangguan_logs`
--
ALTER TABLE `gangguan_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gangguan_id` (`gangguan_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gangguans`
--
ALTER TABLE `gangguans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gangguan_logs`
--
ALTER TABLE `gangguan_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gangguan_logs`
--
ALTER TABLE `gangguan_logs`
  ADD CONSTRAINT `gangguan_logs_ibfk_1` FOREIGN KEY (`gangguan_id`) REFERENCES `gangguans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
