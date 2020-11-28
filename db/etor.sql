-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Nov 2020 pada 05.24
-- Versi server: 5.7.24
-- Versi PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(3) NOT NULL,
  `biro` varchar(100) NOT NULL,
  `bagian` varchar(100) NOT NULL,
  `sub_bagian` varchar(100) NOT NULL,
  `lokasi` varchar(250) NOT NULL,
  `program` varchar(150) NOT NULL,
  `kegiatan` varchar(150) NOT NULL,
  `sub_kegiatan` varchar(255) NOT NULL,
  `anggaran` bigint(50) NOT NULL,
  `apbd_murni` int(20) NOT NULL,
  `apbd_perubahan` int(20) NOT NULL,
  `tanggal` date NOT NULL,
  `sifat_kegiatan` varchar(100) NOT NULL,
  `nama_pengusul` int(3) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `latar_belakang` text NOT NULL,
  `maksud_tujuan` text NOT NULL,
  `sasaran` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(150) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `biro`, `bagian`, `sub_bagian`, `lokasi`, `program`, `kegiatan`, `sub_kegiatan`, `anggaran`, `apbd_murni`, `apbd_perubahan`, `tanggal`, `sifat_kegiatan`, `nama_pengusul`, `nip`, `latar_belakang`, `maksud_tujuan`, `sasaran`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 'asdasd', 'sadasd', 'asdasds', 'adsadasdsad', 'asdasd', 'Sesuatu', 'dasdasd', 1000000000, 200000000, 50000000, '2020-11-26', 'sadsadasdsa', 4, '3242135131231241', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham', '2020-11-26 10:56:05', 'Testing Users', '2020-11-27 08:19:20', 'Testing Users'),
(3, 'qweqwe', 'qweqwe', 'wqeqw', 'qweqw', 'qwqewq', 'ewqe', 'wqeqw', 1000000000000, 200000000, 50000000, '2020-11-27', 'PENTING', 5, '3273421238472838', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '2020-11-27 08:31:21', 'Testing Users', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(150) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role_permission`
--

INSERT INTO `role_permission` (`id`, `nama`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Admin', '2020-11-22 14:17:31', NULL, NULL, NULL),
(2, 'PPTK2', '2020-11-24 07:02:56', 'Testing Users', '2020-11-24 07:52:06', 'Testing Users'),
(3, 'Pemegang Kegiatan', '2020-11-24 02:46:24', 'Testing Users', '2020-11-24 07:48:38', 'Testing Users');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(3) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=nonactive, 1=active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(150) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `nama`, `email`, `no_hp`, `jabatan`, `password`, `role`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '1234567890123456', 'Testing Users', 'test@gmail.com', '081111111111', 'test jabatan', '$2y$10$cR7CVWlblWKS4r1BhT9PAOf1oXzmRwoGoXFAGlnsa5EfYkkVyjRuO', 1, 1, '2020-11-22 14:18:47', NULL, NULL, NULL),
(4, '3242135131231241', 'Daniel Edward', 'daniel@gmail.com', '082321234234', 'PPTK', '$2y$10$1CGwHxwHQNVoGhKGi9KoSO..NC5H0tml4uweMcda7y.QThrmrdTxa', 2, 1, '2020-11-27 08:07:51', 'Testing Users', NULL, NULL),
(5, '3273421238472838', 'Dummy', 'dummy2@example.com', '087672362732', 'PPTK', '$2y$10$l0WNYKIVyYLOi/i/neGAj.WnsLODWGYKuLPlagGoDEGxqrtHm46su', 2, 1, '2020-11-27 08:19:58', 'Testing Users', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
