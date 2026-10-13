-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2025 pada 07.54
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epemilos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
('1', 'kpos', '4dmin#KP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_calon`
--

CREATE TABLE `tb_calon` (
  `id` varchar(50) NOT NULL,
  `namacalon` varchar(50) NOT NULL,
  `visi` varchar(100) NOT NULL,
  `misi` varchar(200) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `totalsuara` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_calon`
--

INSERT INTO `tb_calon` (`id`, `namacalon`, `visi`, `misi`, `foto`, `totalsuara`) VALUES
('692e8b1f42b80', 'Raisya & Nauval', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', '692e8b1f42b80.png', 0),
('692e8b41d6c46', 'Sila & ALwa', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', '692e8b41d6c46.png', 0),
('692e8b5dd818a', 'Ikhsan & Ririn', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', '692e8b5dd818a.png', 0),
('692e8b7bc55a0', 'Adit & Euis', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '692e8b7bc55a0.png', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengawas`
--

CREATE TABLE `tb_pengawas` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `namapengawas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pengawas`
--

INSERT INTO `tb_pengawas` (`id`, `username`, `password`, `namapengawas`) VALUES
('690054a141970', 'ifa', 'ifa@123', 'Nursyifa'),
('690054cf3ae5e', 'diah', 'diah@123', 'Rodiatul Mardiah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id` varchar(255) NOT NULL,
  `nis` varchar(18) NOT NULL,
  `password` varchar(50) NOT NULL,
  `namasiswa` varchar(50) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `suara` varchar(255) NOT NULL,
  `absen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id`, `nis`, `password`, `namasiswa`, `kelas`, `suara`, `absen`) VALUES
('69005d6c2f57c', 'AS007', 'AS007', 'Ust. Yuda Hasan Sulaeman, M.Pd.', 'Asatidz', '0', '0'),
('69005d87d9c4f', 'AS008', 'AS008', 'Ust. Ahmad Humaedi, S.Pd.I.', 'Asatidz', '0', '0'),
('69005ddc6befc', 'AS010', 'AS010', 'Ust. Didin Jamaludin, S.Pd.', 'Asatidz', '0', '0'),
('69005e05ae7b3', 'AS011', 'AS011', 'Ust Muhammad Indra Nur A. S.Pd.', 'Asatidz', '0', '0'),
('69005e175fb33', 'AS012', 'AS012', 'Ust. Dede Majreha Djoharuddin, S.Pd.', 'Asatidz', '0', '0'),
('69005e294d2c1', 'AS013', 'AS013', 'Ust. Kris Nandang, S.Ag. M.H.', 'Asatidz', '0', '0'),
('69005e3f6a03c', 'AS014', 'AS014', 'Usth. Uswatun Khasanah', 'Asatidz', '0', '0'),
('69005f7f4ac35', 'AS015', 'AS015', 'Utsh. Intan Inarotul Millah', 'Asatidz', '0', '0'),
('69005f90f0caa', 'AS016', 'AS016', 'Usth. Yati Rosmiyati, S.Ag.', 'Asatidz', '0', '0'),
('69005fb57813e', 'AS018', 'AS018', 'Usth. Rizki Alpiani Mulyani, S.Ag.', 'Asatidz', '0', '0'),
('690060266680f', 'KP001', 'KP001', 'Adittyan Nugraha', 'Muta\'ali', '0', '0'),
('6900603e83edc', 'KP002', 'KP002', 'Muhammad Ikhsan', 'Muta\'ali', '0', '0'),
('6900606a07005', 'KP003', 'KP003', 'Shiel Shiela', 'Muta\'ali', '0', '0'),
('690061d853dd9', 'KP004', 'KP004', 'Siti Raysa Juliana', 'Muta\'ali', '0', '0'),
('690061efdfd21', 'KP005', 'KP005', 'Dimas Nurmauludin Nugraha', 'Mutawasith', '0', '0'),
('690062030eced', 'KP006', 'KP006', 'Dinda Halimatus Sa\'diyah', 'Mutawasith', '0', '0'),
('69006216eda49', 'KP007', 'KP007', 'Fatimah Husna Maulida', 'Mutawasith', '0', '0'),
('6900622dbd569', 'KP008', 'KP008', 'Sahla Amilatul Mahfiyah', 'Mutawasith', '0', '0'),
('6900624494039', 'KP009', 'KP009', 'Sandi Ramadhani', 'Mutawasith', '0', '0'),
('69006258c4d5e', 'KP010', 'KP010', 'Syafa Salsabila Fauziyyah', 'Mutawasith', '0', '0'),
('6900626d794d1', 'KP011', 'KP011', 'Syifa Salsabila Fauziyyah', 'Mutawasith', '0', '0'),
('690062835c3fe', 'KP012', 'KP012', 'Maila Khofifah', 'Mutawasith', '0', '0'),
('690062db89f75', 'KP013', 'KP013', 'Anhar Azkiya', 'Mubtadi', '0', '0'),
('690062f2259a8', 'KP014', 'KP014', 'Anna Riani Fujiana', 'Mubtadi', '0', '0'),
('69006311382a9', 'KP015', 'KP015', 'Desi Nurjanah', 'Mubtadi', '0', '0'),
('6900633768e35', 'KP016', 'KP016', 'Deswita Febriyanti Maharani', 'Mubtadi', '0', '0'),
('6900635846d04', 'KP017', 'KP017', 'Dinda Ramdhan Gusdina', 'Mubtadi', '0', '0'),
('690064db77111', 'KP018', 'KP018', 'Euis Rodianti', 'Mubtadi', '0', '0'),
('690064f96c7e5', 'KP019', 'KP019', 'Firda Maulidah', 'Mubtadi', '0', '0'),
('6900650fb0e47', 'KP020', 'KP020', 'Ilham Nur Alam Bachtiar', 'Mubtadi', '0', '0'),
('69006527ce9f5', 'KP021', 'KP021', 'Isma Sahilla Rizkiana', 'Mubtadi', '0', '0'),
('6900653ac0e4b', 'KP022', 'KP022', 'Kiki Kardiman', 'Mubtadi', '0', '0'),
('690065530be31', 'KP023', 'KP023', 'Luthfi Dzaki', 'Mubtadi', '0', '0'),
('6900656f6aec3', 'KP024', 'KP024', 'M Fahri Ilahi Matin', 'Mubtadi', '0', '0'),
('690065866c53b', 'KP025', 'KP025', 'Muhamad Alwa Irafy', 'Mubtadi', '0', '0'),
('690065987134c', 'KP026', 'KP026', 'Muhamad Parhan', 'Mubtadi', '0', '0'),
('690065ad6a3e8', 'KP027', 'KP027', 'Naufal Akmal Ghifari', 'Mubtadi', '0', '0'),
('690065c5976fe', 'KP028', 'KP028', 'Noviyatul Husna', 'Mubtadi', '0', '0'),
('690065daa87f8', 'KP029', 'KP029', 'Nugie Nugraha Ramadhan', 'Mubtadi', '0', '0'),
('690065ef1f296', 'KP030', 'KP030', 'Nur Syifa', 'Mubtadi', '0', '0'),
('6900661d8c1ba', 'KP031', 'KP031', 'Qeisya Novalia', 'Mubtadi', '0', '0'),
('690066326ae47', 'KP032', 'KP032', 'Ririn Aryanti', 'Mubtadi', '0', '0'),
('690066511c543', 'KP033', 'KP033', 'Rodiatul Mardiah', 'Mubtadi', '0', '0'),
('6900666ad1fe3', 'KP034', 'KP034', 'Tiara Ismayanti', 'Mubtadi', '0', '0'),
('6900667d19f68', 'KP035', 'KP035', 'Wildan Guntara', 'Mubtadi', '0', '0'),
('69006693e289b', 'KP036', 'KP036', 'Zahrra Mutiara Ramadhani', 'Mubtadi', '0', '0'),
('690066cb72f25', 'KP037', 'KP037', 'Zihan Nur Azizah', 'Mubtadi', '0', '0'),
('690066e66b93c', 'KP038', 'KP038', 'Al Nahyan Wahraniya Abdallah', 'Takhasus', '0', '0'),
('690067150addd', 'KP039', 'KP039', 'Aura Putri Ramadhani', 'Takhasus', '0', '0'),
('69006729b13e5', 'KP040', 'KP040', 'Devina Zahirah Yusriyah', 'Takhasus', '0', '0'),
('69006743b4465', 'KP041', 'KP041', 'Ende Nyanyu Marliyah', 'Takhasus', '0', '0'),
('690068cd5e1ba', 'KP042', 'KP042', 'Fariz Haidar Palah', 'Takhasus', '0', '0'),
('690068e6419c2', 'KP043', 'KP043', 'Hani Rahayu', 'Takhasus', '0', '0'),
('6900691985314', 'KP044', 'KP044', 'Kanzas Ramadan Misbah', 'Takhasus', '0', '0'),
('6900692d0b3f7', 'KP045', 'KP045', 'Latipah', 'Takhasus', '0', '0'),
('6900696f40ee8', 'KP046', 'KP046', 'Maysaroh Khusna Khoirunnisa', 'Takhasus', '0', '0'),
('69006982a94fa', 'KP047', 'KP047', 'Mila Ismayanti', 'Takhasus', '0', '0'),
('690069a3df2ca', 'KP048', 'KP048', 'Mitha Amelia Andryanti', 'Takhasus', '0', '0'),
('690069c2a3414', 'KP049', 'KP049', 'Naila', 'Takhasus', '0', '0'),
('690069d8a56d2', 'KP050', 'KP050', 'Najwa Luthpiana Adlia', 'Takhasus', '0', '0'),
('690069fe92bb9', 'KP051', 'KP051', 'Neng Siti Amanah Nurohmah', 'Takhasus', '0', '0'),
('69006a195dec8', 'KP052', 'KP052', 'Nilam Sidqia Anida', 'Takhasus', '0', '0'),
('69006a2e441cf', 'KP053', 'KP053', 'Nurul Chopidoh', 'Takhasus', '0', '0'),
('69006a9240c5f', 'KP054', 'KP054', 'Ratu Asnia Ryanifa', 'Takhasus', '0', '0'),
('69006aa7e8752', 'KP055', 'KP055', 'Shifa Nur Ramdani', 'Takhasus', '0', '0'),
('69006ac0ec802', 'KP056', 'KP056', 'Siti Alida Salsabila', 'Takhasus', '0', '0'),
('69006ae0bdd2f', 'KP057', 'KP057', 'Syalwa Awalliya Maulidina', 'Takhasus', '0', '0'),
('69006af84cf1f', 'KP058', 'KP058', 'Syifa Kamila Rahayu', 'Takhasus', '0', '0'),
('69006b145353f', 'KP059', 'KP059', 'Windyani', 'Takhasus', '0', '0');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeks untuk tabel `tb_calon`
--
ALTER TABLE `tb_calon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pengawas`
--
ALTER TABLE `tb_pengawas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suara` (`suara`,`absen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
