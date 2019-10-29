-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2019 at 03:05 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_farina`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_alamat`
--

CREATE TABLE `tb_alamat` (
  `id_alamat` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kodepos` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_alamat`
--

INSERT INTO `tb_alamat` (`id_alamat`, `id_user`, `nama`, `alamat`, `telepon`, `kecamatan`, `provinsi`, `kodepos`) VALUES
('alt-5d6d0c7b98d12-001', '5d6d0c7b98d12', 'reza hmm', 'jl gunung gunungan', '021 - hmm', 'Gambir', 'DKI Jakarta', '11401');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking`
--

CREATE TABLE `tb_booking` (
  `id_booking` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_facial` varchar(100) NOT NULL,
  `tanggal_book` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` date NOT NULL,
  `jam` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `edit` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`id_booking`, `id_user`, `nama`, `telepon`, `email`, `id_facial`, `tanggal_book`, `tanggal`, `jam`, `status`, `harga`, `edit`) VALUES
('18/10/2019/01', '5d6d0c7b98d12', 'Muhamad Reza', '089797112928', 'reza.2207@gmail.com', 'facial-001', '2019-09-16 20:43:50', '2019-10-18', '10.00', 'Batal', 400000, 0),
('24/10/2019/02', '5d6d0c7b98d12', 'Muhamad Reza', '089797112928', 'reza.2207@gmail.com', 'facial-004', '2019-10-23 23:31:02', '2019-10-24', '10:00', 'Batal', 155000, 0),
('25/10/2019/01', '5d7ceb12ef154', 'tes', '22', 'asda', 'facial-003', '2019-10-23 22:54:08', '2019-10-25', '14:30', 'Batal', 150000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_transaksi`
--

CREATE TABLE `tb_detail_transaksi` (
  `id_detail_transaksi` varchar(100) NOT NULL,
  `id_transaksi` varchar(100) NOT NULL,
  `id_produk` varchar(100) NOT NULL,
  `harga` int(7) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_detail_transaksi`
--

INSERT INTO `tb_detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_produk`, `harga`, `jumlah`) VALUES
('trx-20191022-0001-000', 'trx-20191022-0001', '5d862f267f444', 213212, 12),
('trx-20191022-0001-001', 'trx-20191022-0001', '5d862fac69131', 2132132, 3),
('trx-20191025-0002-000', 'trx-20191025-0002', '5d862f267f444', 213212, 2),
('trx-20191025-0003-000', 'trx-20191025-0003', '5d862f267f444', 213212, 10),
('trx-20191029-0004-000', 'trx-20191029-0004', '5d862f267f444', 213212, 1),
('trx-20191029-0005-000', 'trx-20191029-0005', '5d862f267f444', 213212, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_facial`
--

CREATE TABLE `tb_facial` (
  `id_facial` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `harga` int(7) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_facial`
--

INSERT INTO `tb_facial` (`id_facial`, `nama`, `deskripsi`, `harga`, `status`) VALUES
('facial-001', 'Facial Sulfur', 'Mengobati jerawat yang meradang dengan menggunakan masker belerang.', 150000, 'Aktif'),
('facial-002', 'Facial Tea Tree', 'Mengobati jerawat pada kulit sensitiv dan berminyak dengan menggunakan masker tea tree.', 170000, 'Aktif'),
('facial-003', 'Facial Bengkuang', 'Mencerahkan wajah dang mengecilkan pori-pori dengan ekstrak buah bengkoang untuk semua jenis kulit.', 150000, 'Aktif'),
('facial-004', 'Facial Apel', 'Mencerahkan wajah dan melembapkan wajah dengan ekstrak buah apel untuk kulit kering.', 155000, 'Aktif'),
('facial-005', 'Facial Anggur', 'Mencerahkan wajah dan mengecilkan pori-pori dengan ekstrak buah anggur untuk kulit berminyak.', 155000, 'Aktif'),
('facial-006', 'Facial SSP Mikrodermabrasi', 'Perawatan untuk mengecilkan pori-pori dan mengurangi bekas jerawat dengan menggunakan butiran kristal halus.', 260000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jam`
--

CREATE TABLE `tb_jam` (
  `id_jam` int(11) NOT NULL,
  `jam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jam`
--

INSERT INTO `tb_jam` (`id_jam`, `jam`) VALUES
(1, '10:00'),
(2, '11:30'),
(3, '13:00'),
(4, '14:30'),
(5, '16:00'),
(6, '17:30');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kecamatan`
--

CREATE TABLE `tb_kecamatan` (
  `id_kec` int(10) NOT NULL,
  `id_kab` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kecamatan`
--

INSERT INTO `tb_kecamatan` (`id_kec`, `id_kab`, `nama`) VALUES
(310101, 3101, 'Kepulauan Seribu Utara'),
(310102, 3101, 'Kepulauan Seribu Selatan.'),
(317101, 3171, 'Gambir'),
(317102, 3171, 'Sawah Besar'),
(317103, 3171, 'Kemayoran'),
(317104, 3171, 'Senen'),
(317105, 3171, 'Cempaka Putih'),
(317106, 3171, 'Menteng'),
(317107, 3171, 'Tanah Abang'),
(317108, 3171, 'Johar Baru'),
(317201, 3172, 'Penjaringan'),
(317202, 3172, 'Tanjung Priok'),
(317203, 3172, 'Koja'),
(317204, 3172, 'Cilincing'),
(317205, 3172, 'Pademangan'),
(317206, 3172, 'Kelapa Gading'),
(317301, 3173, 'Cengkareng'),
(317302, 3173, 'Grogol Petamburan'),
(317303, 3173, 'Taman Sari'),
(317304, 3173, 'Tambora'),
(317305, 3173, 'Kebon Jeruk'),
(317306, 3173, 'Kalideres'),
(317307, 3173, 'Pal Merah'),
(317308, 3173, 'Kembangan'),
(317401, 3174, 'Tebet'),
(317402, 3174, 'Setiabudi'),
(317403, 3174, 'Mampang Prapatan'),
(317404, 3174, 'Pasar Minggu'),
(317405, 3174, 'Kebayoran Lama'),
(317406, 3174, 'Cilandak'),
(317407, 3174, 'Kebayoran Baru'),
(317408, 3174, 'Pancoran'),
(317409, 3174, 'Jagakarsa'),
(317410, 3174, 'Pesanggrahan'),
(317501, 3175, 'Matraman'),
(317502, 3175, 'Pulogadung'),
(317503, 3175, 'Jatinegara'),
(317504, 3175, 'Kramatjati'),
(317505, 3175, 'Pasar Rebo'),
(317506, 3175, 'Cakung'),
(317507, 3175, 'Duren Sawit'),
(317508, 3175, 'Makasar'),
(317509, 3175, 'Ciracas'),
(317510, 3175, 'Cipayung');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(100) NOT NULL,
  `id_transaksi` varchar(100) NOT NULL,
  `tanggal_transfer` date NOT NULL,
  `jumlah_transfer` int(8) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `nama_rekening` varchar(100) NOT NULL,
  `bukti_transfer` varchar(100) NOT NULL,
  `tgl_submit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `id_transaksi`, `tanggal_transfer`, `jumlah_transfer`, `bank`, `nama_rekening`, `bukti_transfer`, `tgl_submit`, `status_pembayaran`) VALUES
('trf-20191006-001', 'trx-20191006-0003', '2019-10-15', 213212, 'mandiri', 'bobi', '03a3318e77c7895691ceae2e994f2944.jpg', '2019-10-13 19:55:11', 'Pembayaran Lunas'),
('trf-20191022-001', 'trx-20191022-0001', '2019-10-23', 0, 'bca', 'ss', '484e0a95ea9f9b418e285159517f5c57.jpg', '2019-10-22 01:03:57', 'Pembayaran Lunas'),
('trf-20191025-001', 'trx-20191025-0002', '2019-10-25', 436424, 'bca', 'ss', 'c22b672c76771c7521bbc625085b1b5e.jpg', '2019-10-25 20:11:55', 'Pembayaran Lunas'),
('trf-20191029-001', 'trx-20191029-0005', '2019-10-29', 223212, 'bca', 'suparman', 'a3c14857e5db92e8ebac216c9a93ec81.jpg', '2019-10-29 20:49:04', 'Pembayaran Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` varchar(250) NOT NULL,
  `harga` int(7) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal_buat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nama`, `deskripsi`, `harga`, `gambar`, `status`, `tanggal_buat`) VALUES
('5d862f267f444', 'Natural Whitening Cream WP 5s', 'Cream Malam yang bisa digunakan untuk kulit Normald', 213212, 'fe06f9c458ad12c5746d464c0970ab77.jpg', 'Aktif', '2019-09-22 12:44:15'),
('5d862fac69131', 'Natural Whitening Cream WP 5d', 'Cream Malam yang bisa digunakan untuk kulit Normals', 2132132, '28ceb239d3d4ccaebc079f6742079f69.jpg', 'Aktif', '2019-09-22 17:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok`
--

CREATE TABLE `tb_stok` (
  `id_stok` varchar(100) NOT NULL,
  `id_produk` varchar(200) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_stok`
--

INSERT INTO `tb_stok` (`id_stok`, `id_produk`, `jumlah`, `tanggal_input`) VALUES
('5d87327e90ed3', '5d862f267f444', 200, '0000-00-00 00:00:00'),
('5d8732d30e377', '5d862fac69131', 300, '2019-10-22 01:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_temp_trans`
--

CREATE TABLE `tb_temp_trans` (
  `id_temp_trans` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `id_produk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` varchar(100) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kodepos` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `tgl_transaksi`, `id_user`, `status`, `nama`, `alamat`, `telepon`, `kecamatan`, `provinsi`, `kodepos`) VALUES
('trx-20191022-0001', '2019-10-22 01:02:44', '5d6d0c7b98d12', 'Terkirim', 'reza hmm', 'jl gunung gunungan', '021 - hmm', 'Gambir', 'DKI Jakarta', '11401'),
('trx-20191025-0002', '2019-10-25 19:56:50', '5d6d0c7b98d12', 'Terkirim', 'reza hmm', 'jl gunung gunungan', '021 - hmm', 'Gambir', 'DKI Jakarta', '11401'),
('trx-20191025-0003', '2019-10-25 20:58:09', '5d6d0c7b98d12', 'Batal', 'reza hmm', 'jl gunung gunungan', '021 - hmm', 'Gambir', 'DKI Jakarta', '11401'),
('trx-20191029-0004', '0000-00-00 00:00:00', '5db1ddbd14015', 'Menunggu Konfirmasi Alamat', '', '', '', '', '', ''),
('trx-20191029-0005', '2019-10-29 20:42:19', '5d6d0c7b98d12', 'Terkirim', 'reza hmm', 'jl gunung gunungan', '021 - hmm', 'Gambir', 'DKI Jakarta', '11401');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('','Laki-laki','Perempuan') NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `peran` varchar(50) NOT NULL,
  `status` enum('Active','Non Active') NOT NULL,
  `no_member` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `email`, `password`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `tgl_lahir`, `peran`, `status`, `no_member`) VALUES
('5d6d0c7b98d12', 'reza.2207@gmail.com', '$2y$10$y3VFDqE41lHjLUiX/X4RauCQ8ZZfLiIJ6MyOIkCwS7ufwQ/2X6Yjm', 'Muhamad Reza', 'Laki-laki', 'Jl. G hmmm ', '089797112928', '2019-10-07', 'user', 'Active', '7123912'),
('5d7ceb12ef154', 'admin@farina.com', '$2y$10$3pSYQOeag15IeUd.eEDPluJMq6Q37PI5ehiPGGipMPmSw/p2PQ1ci', 'Admin Farina', '', '', '', '0000-00-00', 'admin', 'Active', ''),
('5d90cd9f65223', 'rina123@gmail.com', '$2y$10$JqDxdCn0kf7qKOCLhasDu.0oONkD3C5J3zhfiERRVn7wAt2XLX/ei', 'Rina Marina', 'Perempuan', 'jl.kembang no.40', '08961234567', '2000-06-17', 'user', 'Active', ''),
('5db1ddbd14015', 'reza.220793@gmail.com', '$2y$10$/GSbXeb5hMD7yWn9keSQouME2yheOtJJl.HrbycDnpZ25HQDpSKKm', 'Muhamad Reza', 'Laki-laki', 'asdasdas', '21312312', '2019-10-24', 'user', 'Active', ''),
('5db319310f947', 'reza.2207@gmail.co', '$2y$10$UiiJQ4tNtTGCfQXgfEGAkO3VIaMqu4wZDlNZAuQ4CYPoEUEcQKM2a', 'Muhamad Reza', 'Laki-laki', 'asdas1231', '12312312312', '2019-10-15', 'user', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id_token` varchar(150) NOT NULL,
  `expired` datetime NOT NULL,
  `id_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_alamat`
--
ALTER TABLE `tb_alamat`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_facial` (`id_facial`);

--
-- Indexes for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_facial`
--
ALTER TABLE `tb_facial`
  ADD PRIMARY KEY (`id_facial`);

--
-- Indexes for table `tb_jam`
--
ALTER TABLE `tb_jam`
  ADD PRIMARY KEY (`id_jam`);

--
-- Indexes for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  ADD PRIMARY KEY (`id_kec`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_stok`
--
ALTER TABLE `tb_stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_temp_trans`
--
ALTER TABLE `tb_temp_trans`
  ADD PRIMARY KEY (`id_temp_trans`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `email` (`email`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_jam`
--
ALTER TABLE `tb_jam`
  MODIFY `id_jam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
