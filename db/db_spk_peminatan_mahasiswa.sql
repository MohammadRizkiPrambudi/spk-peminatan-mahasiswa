-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Agu 2025 pada 15.12
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spk_peminatan_mahasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dempster_shafer_results`
--

CREATE TABLE `dempster_shafer_results` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `belief` json NOT NULL,
  `plausibility` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dempster_shafer_results`
--

INSERT INTO `dempster_shafer_results` (`id`, `mahasiswa_id`, `belief`, `plausibility`, `created_at`, `updated_at`) VALUES
(11, 2, '{\"AI\": 0.3806, \"θ\": 0, \"Jaringan\": 0.3705, \"Sistem Cerdas\": 0.2489}', '{\"AI\": 0.3806, \"θ\": 0, \"Jaringan\": 0.3705, \"Sistem Cerdas\": 0.2489}', '2025-08-05 21:42:13', '2025-08-05 22:47:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fuzzy_results`
--

CREATE TABLE `fuzzy_results` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `output_fuzzy` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fuzzy_results`
--

INSERT INTO `fuzzy_results` (`id`, `mahasiswa_id`, `output_fuzzy`, `created_at`, `updated_at`) VALUES
(9, 2, '{\"AI\": 0.5556, \"θ\": 0, \"Jaringan\": 0.0555, \"Sistem Cerdas\": 0.3889}', '2025-08-05 21:42:13', '2025-08-06 07:09:57'),
(10, 3, '{\"AI\": 0.06, \"θ\": 0, \"Jaringan\": 0.84, \"Sistem Cerdas\": 0.1}', '2025-08-06 05:17:40', '2025-08-06 06:56:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Teknik Informatika',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `user_id`, `nama`, `nim`, `prodi`, `created_at`, `updated_at`) VALUES
(2, 3, 'Mahasiswa', '24980192100', 'Teknik Informatika', '2025-07-27 21:49:36', '2025-07-27 21:49:36'),
(3, 4, 'Erlangga', '212015242', 'Teknik Informatika', '2025-07-31 07:26:45', '2025-07-31 07:26:45'),
(4, 5, 'Budi Santoso', '24980192106', 'Teknik Informatika', '2025-08-06 05:59:42', '2025-08-06 05:59:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah_bidang`
--

CREATE TABLE `matakuliah_bidang` (
  `id` bigint UNSIGNED NOT NULL,
  `matakuliah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` enum('AI','Sistem Cerdas','Jaringan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `matakuliah_bidang`
--

INSERT INTO `matakuliah_bidang` (`id`, `matakuliah`, `bidang`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 'Algoritma Dan Struktur Data', 'AI', 0.4, NULL, '2025-08-06 05:02:46'),
(2, 'Algoritma Dan Struktur Data', 'Sistem Cerdas', 0.6, NULL, '2025-08-06 05:06:28'),
(15, 'Sistem Digital', 'AI', 0.2, '2025-08-06 05:52:08', '2025-08-06 05:52:08'),
(16, 'Sistem Digital', 'Sistem Cerdas', 0.6, '2025-08-06 05:52:28', '2025-08-06 05:52:28'),
(17, 'Sistem Digital', 'Jaringan', 0.2, '2025-08-06 05:52:59', '2025-08-06 05:52:59'),
(18, 'Pemrograman Beriorentasi Objek', 'AI', 0.4, '2025-08-06 05:53:41', '2025-08-06 05:53:41'),
(19, 'Pemrograman Beriorentasi Objek', 'Sistem Cerdas', 0.5, '2025-08-06 05:54:12', '2025-08-06 05:54:12'),
(20, 'Pemrograman Beriorentasi Objek', 'Jaringan', 0.1, '2025-08-06 05:54:30', '2025-08-06 05:54:30'),
(21, 'Perancangan Sistem', 'AI', 0.3, '2025-08-06 05:54:57', '2025-08-06 05:54:57'),
(22, 'Perancangan Sistem', 'Sistem Cerdas', 0.5, '2025-08-06 05:55:26', '2025-08-06 05:55:26'),
(23, 'Perancangan Sistem', 'Jaringan', 0.2, '2025-08-06 05:56:24', '2025-08-06 05:56:24'),
(24, 'Jaringan Komputer', 'Jaringan', 1, '2025-08-06 05:56:52', '2025-08-06 05:56:52'),
(25, 'Grafika Komputer', 'AI', 1, '2025-08-06 05:57:23', '2025-08-06 05:57:23'),
(26, 'Pemrograman Jaringan', 'Jaringan', 1, '2025-08-06 05:57:42', '2025-08-06 05:57:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_26_030543_create_mahasiswa_table', 1),
(6, '2025_07_26_030625_create_nilai_akademik_table', 1),
(7, '2025_07_26_030711_create_preferensi_minat_table', 1),
(8, '2025_07_26_030748_create_tes_bakat_table', 1),
(9, '2025_07_26_030843_create_fuzzy_results_table', 1),
(10, '2025_07_26_030927_create_dempster_shafer_results_table', 1),
(11, '2025_07_26_031011_create_rekomendasi_peminatan_table', 1),
(12, '2025_07_28_013910_create_permission_tables', 2),
(13, '2025_07_28_051917_create_matakuliah_bidang_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_akademik`
--

CREATE TABLE `nilai_akademik` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `matakuliah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai_akademik`
--

INSERT INTO `nilai_akademik` (`id`, `mahasiswa_id`, `matakuliah`, `nilai`, `created_at`, `updated_at`) VALUES
(17, 2, 'Algoritma Dan Struktur Data', 85.00, '2025-07-27 22:00:37', '2025-08-06 05:00:27'),
(18, 2, 'Sistem Digital', 90.00, '2025-07-27 22:00:37', '2025-07-27 22:00:37'),
(19, 2, 'Pemrograman Beriorentasi Objek', 75.00, '2025-07-27 22:00:37', '2025-08-06 05:00:41'),
(20, 2, 'Perancangan Sistem', 70.00, '2025-07-27 22:00:37', '2025-08-06 05:00:53'),
(21, 2, 'Jaringan Komputer', 50.00, '2025-07-27 22:00:37', '2025-08-06 05:01:09'),
(22, 2, 'Grafika Komputer', 85.00, '2025-07-27 22:00:37', '2025-08-05 20:46:45'),
(23, 2, 'Pemrograman Jaringan', 65.00, '2025-07-27 22:00:37', '2025-08-06 05:01:25'),
(24, 3, 'Algoritma Dan Struktur Data', 70.00, '2025-08-06 05:13:34', '2025-08-06 05:13:34'),
(25, 3, 'Sistem Digital', 60.00, '2025-08-06 05:13:51', '2025-08-06 05:13:51'),
(26, 3, 'Pemrograman Beriorentasi Objek', 65.00, '2025-08-06 05:14:06', '2025-08-06 05:14:06'),
(27, 3, 'Perancangan Sistem', 75.00, '2025-08-06 05:14:49', '2025-08-06 05:14:49'),
(28, 3, 'Jaringan Komputer', 90.00, '2025-08-06 05:15:03', '2025-08-06 05:15:03'),
(29, 3, 'Grafika Komputer', 60.00, '2025-08-06 05:15:20', '2025-08-06 05:15:20'),
(30, 3, 'Pemrograman Jaringan', 80.00, '2025-08-06 05:15:36', '2025-08-06 05:15:36'),
(31, 4, 'Algoritma Dan Struktur Data', 90.00, '2025-08-06 08:07:11', '2025-08-06 08:07:11'),
(32, 4, 'Sistem Digital', 95.00, '2025-08-06 08:07:39', '2025-08-06 08:07:39'),
(33, 4, 'Pemrograman Beriorentasi Objek', 90.00, '2025-08-06 08:08:02', '2025-08-06 08:08:02'),
(34, 4, 'Perancangan Sistem', 90.00, '2025-08-06 08:08:34', '2025-08-06 08:08:34'),
(35, 4, 'Jaringan Komputer', 65.00, '2025-08-06 08:08:59', '2025-08-06 08:08:59'),
(36, 4, 'Grafika Komputer', 50.00, '2025-08-06 08:09:21', '2025-08-06 08:09:21'),
(37, 4, 'Pemrograman Jaringan', 50.00, '2025-08-06 08:09:47', '2025-08-06 08:09:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `preferensi_minat`
--

CREATE TABLE `preferensi_minat` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `bidang` enum('Sistem Cerdas','AI','Jaringan','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_minat` enum('rendah','sedang','tinggi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `preferensi_minat`
--

INSERT INTO `preferensi_minat` (`id`, `mahasiswa_id`, `bidang`, `tingkat_minat`, `created_at`, `updated_at`) VALUES
(17, 2, 'Sistem Cerdas', 'rendah', '2025-07-27 22:02:59', '2025-08-06 02:50:55'),
(18, 2, 'AI', 'tinggi', '2025-07-27 22:02:59', '2025-08-05 21:23:55'),
(19, 2, 'Jaringan', 'tinggi', '2025-07-27 22:02:59', '2025-08-06 02:42:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi_peminatan`
--

CREATE TABLE `rekomendasi_peminatan` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `peminatan_utama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_kepercayaan` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekomendasi_peminatan`
--

INSERT INTO `rekomendasi_peminatan` (`id`, `mahasiswa_id`, `peminatan_utama`, `nilai_kepercayaan`, `created_at`, `updated_at`) VALUES
(9, 2, 'AI', 0.37, '2025-08-05 21:42:13', '2025-08-06 07:55:36'),
(10, 3, 'Jaringan', 0.44, '2025-08-06 05:17:40', '2025-08-06 07:23:15'),
(11, 4, 'Sistem Cerdas', 0.38, '2025-08-06 08:11:15', '2025-08-06 08:11:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-27 18:42:00', '2025-07-27 18:42:00'),
(2, 'mahasiswa', 'web', '2025-07-27 18:42:11', '2025-07-27 18:42:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tes_bakat`
--

CREATE TABLE `tes_bakat` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `kategori_bakat` enum('Sistem Cerdas','AI','Jaringan','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `skor` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tes_bakat`
--

INSERT INTO `tes_bakat` (`id`, `mahasiswa_id`, `kategori_bakat`, `skor`, `created_at`, `updated_at`) VALUES
(17, 2, 'Sistem Cerdas', 75.00, '2025-07-27 22:03:53', '2025-08-06 05:10:17'),
(18, 2, 'AI', 80.00, '2025-07-27 22:03:53', '2025-08-05 20:46:54'),
(19, 2, 'Jaringan', 80.00, '2025-07-27 22:03:53', '2025-08-06 05:10:03'),
(20, 3, 'AI', 85.00, '2025-08-06 05:16:14', '2025-08-06 05:16:14'),
(21, 3, 'Jaringan', 90.00, '2025-08-06 05:16:29', '2025-08-06 05:16:29'),
(22, 3, 'Sistem Cerdas', 70.00, '2025-08-06 05:17:19', '2025-08-06 05:17:19'),
(23, 4, 'Sistem Cerdas', 80.00, '2025-08-06 08:10:09', '2025-08-06 08:10:09'),
(24, 4, 'AI', 75.00, '2025-08-06 08:10:37', '2025-08-06 08:10:37'),
(25, 4, 'Jaringan', 85.00, '2025-08-06 08:11:01', '2025-08-06 08:11:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$WfzzsMnIShPUwowWf3EWQeM0a7ORHsKaFICAsbR/yKvos9j13X1LG', NULL, '2025-07-25 20:38:46', '2025-07-25 20:38:46'),
(3, 'Mahasiswa', 'mahasiswa@example.com', NULL, '$2y$12$6p5zjvAFdRGGjsU4/DII/ealiVQ.yQ0I.JhtNaVEGvk12e9JnoiIS', NULL, '2025-07-27 21:49:36', '2025-07-27 21:49:36'),
(4, 'Erlangga', 'erlanggarizkimura9@gmail.com', NULL, '$2y$12$2nYtkEtCv.2.huU4o91obOiGP2E5yn2z2Qbuygbg.fuyrciW/veRS', NULL, '2025-07-31 07:26:45', '2025-07-31 07:26:45'),
(5, 'Budi Santoso', 'budi10@gmail.com', NULL, '$2y$12$hu9/kgtpKXRROqgD8C4YN.Om2VfnW1Z/C5TrE4SFV7Q78hR/z24/a', NULL, '2025-08-06 05:59:42', '2025-08-06 05:59:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dempster_shafer_results`
--
ALTER TABLE `dempster_shafer_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dempster_shafer_results_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `fuzzy_results`
--
ALTER TABLE `fuzzy_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuzzy_results_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_nim_unique` (`nim`),
  ADD KEY `mahasiswa_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `matakuliah_bidang`
--
ALTER TABLE `matakuliah_bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `nilai_akademik`
--
ALTER TABLE `nilai_akademik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_akademik_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `preferensi_minat`
--
ALTER TABLE `preferensi_minat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preferensi_minat_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `rekomendasi_peminatan`
--
ALTER TABLE `rekomendasi_peminatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekomendasi_peminatan_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `tes_bakat`
--
ALTER TABLE `tes_bakat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tes_bakat_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dempster_shafer_results`
--
ALTER TABLE `dempster_shafer_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fuzzy_results`
--
ALTER TABLE `fuzzy_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `matakuliah_bidang`
--
ALTER TABLE `matakuliah_bidang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `nilai_akademik`
--
ALTER TABLE `nilai_akademik`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `preferensi_minat`
--
ALTER TABLE `preferensi_minat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi_peminatan`
--
ALTER TABLE `rekomendasi_peminatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tes_bakat`
--
ALTER TABLE `tes_bakat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dempster_shafer_results`
--
ALTER TABLE `dempster_shafer_results`
  ADD CONSTRAINT `dempster_shafer_results_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fuzzy_results`
--
ALTER TABLE `fuzzy_results`
  ADD CONSTRAINT `fuzzy_results_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_akademik`
--
ALTER TABLE `nilai_akademik`
  ADD CONSTRAINT `nilai_akademik_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `preferensi_minat`
--
ALTER TABLE `preferensi_minat`
  ADD CONSTRAINT `preferensi_minat_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekomendasi_peminatan`
--
ALTER TABLE `rekomendasi_peminatan`
  ADD CONSTRAINT `rekomendasi_peminatan_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tes_bakat`
--
ALTER TABLE `tes_bakat`
  ADD CONSTRAINT `tes_bakat_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
