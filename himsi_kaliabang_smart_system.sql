-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Agu 2022 pada 17.39
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `himsi_kaliabang_smart_system`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni`
--

CREATE TABLE `alumni` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `balance_sheet`
--

CREATE TABLE `balance_sheet` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `month` enum('JANUARI','FEBUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` double DEFAULT 0,
  `kredit` double DEFAULT 0,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `certificate`
--

CREATE TABLE `certificate` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_finance`
--

CREATE TABLE `detail_finance` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `member_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finance_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentMethod` enum('DANA','BANK','OVO','GOPAY') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cash` double NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `document`
--

CREATE TABLE `document` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentName` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `eventName` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `startAt` datetime NOT NULL,
  `endAt` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `banner` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isGeneral` tinyint(1) NOT NULL DEFAULT 0,
  `member_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isFree` tinyint(1) NOT NULL DEFAULT 0,
  `price` double DEFAULT NULL,
  `isOnline` tinyint(1) NOT NULL DEFAULT 0,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contactPerson` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detailLocation` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_absence`
--

CREATE TABLE `event_absence` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isPaidOff` tinyint(1) DEFAULT NULL,
  `event_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('sakit','ijin','absen','hadir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absen',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_note`
--

CREATE TABLE `event_note` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `event_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance`
--

CREATE TABLE `finance` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `month` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `penalty` double DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `income`
--

CREATE TABLE `income` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `date` date NOT NULL,
  `total` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meet`
--

CREATE TABLE `meet` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `meetName` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `startAt` datetime NOT NULL,
  `endAt` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `isOnline` tinyint(1) NOT NULL DEFAULT 0,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `detailLocation` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meet_absence`
--

CREATE TABLE `meet_absence` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `meet_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('sakit','ijin','absen','hadir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absen',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meet_note`
--

CREATE TABLE `meet_note` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meet_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `phoneNumber` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(267, '2012_05_31_125128_create_roles_table', 1),
(268, '2014_10_12_000000_create_users_table', 1),
(269, '2014_10_12_100000_create_password_resets_table', 1),
(270, '2019_08_19_000000_create_failed_jobs_table', 1),
(271, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(272, '2022_06_01_134418_create_members_table', 1),
(273, '2022_06_05_132816_create_events_table', 1),
(274, '2022_06_12_074651_create_certificates_table', 1),
(275, '2022_06_13_134104_create_meets_table', 1),
(276, '2022_06_18_104646_create_event_notes_table', 1),
(277, '2022_06_29_094549_create_notes_table', 1),
(278, '2022_07_10_142959_create_receipts_table', 1),
(279, '2022_07_13_134021_create_meet_absences_table', 1),
(280, '2022_07_21_082903_create_event_absences_table', 1),
(281, '2022_07_22_081958_create_meet_notes_table', 1),
(282, '2022_07_22_134054_create_documents_table', 1),
(283, '2022_07_25_055055_create_finances_table', 1),
(284, '2022_07_25_055954_create_detail_finances_table', 1),
(285, '2022_07_25_060827_create_outcomes_table', 1),
(286, '2022_07_25_060839_create_incomes_table', 1),
(287, '2022_07_25_061258_create_balance_sheets_table', 1),
(288, '2022_07_30_132557_create_alumnis_table', 1),
(289, '2022_08_06_182808_create_galleries_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `note`
--

CREATE TABLE `note` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `event_note_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `outcome`
--

CREATE TABLE `outcome` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `date` date NOT NULL,
  `total` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `receipt`
--

CREATE TABLE `receipt` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `roleName`, `createdAt`, `updatedAt`) VALUES
(1, 'member', '2022-08-15 15:36:56', NULL),
(2, 'guest', '2022-08-15 15:36:56', NULL),
(99, 'admin', '2022-08-15 15:36:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isGuest` tinyint(1) NOT NULL DEFAULT 0,
  `gender` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `university` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `isGuest`, `gender`, `university`, `role_id`, `createdAt`, `updatedAt`) VALUES
('18654324-1cb0-11ed-9dd9-00155d837797', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 'laki-laki', NULL, 99, '2022-08-15 15:36:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `balance_sheet`
--
ALTER TABLE `balance_sheet`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificate_event_id_foreign` (`event_id`);

--
-- Indeks untuk tabel `detail_finance`
--
ALTER TABLE `detail_finance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_finance_member_id_foreign` (`member_id`),
  ADD KEY `detail_finance_finance_id_foreign` (`finance_id`),
  ADD KEY `detail_finance_receipt_id_foreign` (`receipt_id`);

--
-- Indeks untuk tabel `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_member_id_foreign` (`member_id`);

--
-- Indeks untuk tabel `event_absence`
--
ALTER TABLE `event_absence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_absence_event_id_foreign` (`event_id`);

--
-- Indeks untuk tabel `event_note`
--
ALTER TABLE `event_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_note_event_id_foreign` (`event_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meet`
--
ALTER TABLE `meet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meet_member_id_foreign` (`member_id`);

--
-- Indeks untuk tabel `meet_absence`
--
ALTER TABLE `meet_absence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meet_absence_meet_id_foreign` (`meet_id`),
  ADD KEY `meet_absence_member_id_foreign` (`member_id`);

--
-- Indeks untuk tabel `meet_note`
--
ALTER TABLE `meet_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meet_note_meet_id_foreign` (`meet_id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_nim_unique` (`nim`),
  ADD UNIQUE KEY `member_phonenumber_unique` (`phoneNumber`),
  ADD UNIQUE KEY `member_token_unique` (`token`),
  ADD UNIQUE KEY `member_user_id_unique` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_event_note_id_foreign` (`event_note_id`);

--
-- Indeks untuk tabel `outcome`
--
ALTER TABLE `outcome`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD KEY `user_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_finance`
--
ALTER TABLE `detail_finance`
  ADD CONSTRAINT `detail_finance_finance_id_foreign` FOREIGN KEY (`finance_id`) REFERENCES `finance` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_finance_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_finance_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipt` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event_absence`
--
ALTER TABLE `event_absence`
  ADD CONSTRAINT `event_absence_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event_note`
--
ALTER TABLE `event_note`
  ADD CONSTRAINT `event_note_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `meet`
--
ALTER TABLE `meet`
  ADD CONSTRAINT `meet_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `meet_absence`
--
ALTER TABLE `meet_absence`
  ADD CONSTRAINT `meet_absence_meet_id_foreign` FOREIGN KEY (`meet_id`) REFERENCES `meet` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `meet_absence_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `meet_note`
--
ALTER TABLE `meet_note`
  ADD CONSTRAINT `meet_note_meet_id_foreign` FOREIGN KEY (`meet_id`) REFERENCES `meet` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_event_note_id_foreign` FOREIGN KEY (`event_note_id`) REFERENCES `event_note` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
