-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 12, 2019 at 09:39 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cl`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `db_comment`
--

CREATE TABLE IF NOT EXISTS `db_comment` (
`id_comment` int(11) NOT NULL,
  `id_request` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `note_comment` text NOT NULL,
  `date_comment` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_comment`
--

INSERT INTO `db_comment` (`id_comment`, `id_request`, `id_user`, `note_comment`, `date_comment`) VALUES
(1, 8, 162, 'boleh lampirkan dokumen PO nya?', '2019-03-20 19:38:47'),
(2, 8, 162, 'mana dokumennya?', '2019-03-20 19:44:29'),
(5, 8, 165, 'nanti ya', '2019-03-20 23:43:21'),
(6, 11, 165, 'ini kok blom diproses', '2019-03-21 08:49:51'),
(7, 11, 162, 'Herni, tolong tambahkan NPWP  customer', '2019-03-21 08:51:48'),
(8, 8, 162, 'AR tidak ada ada masalah, perusahaan real bukan fiktif', '2019-03-21 17:23:42'),
(9, 8, 162, 'AR boleh dipertimbangkan', '2019-03-21 17:24:33'),
(10, 8, 162, 'tambah lagi', '2019-03-21 17:26:17'),
(11, 13, 162, 'setelah dicek, tidak ada tunggakan dari customer', '2019-03-22 11:04:36'),
(12, 12, 162, 'approve ya, customer baru, perusahaan bukan fiktif', '2019-03-22 11:07:33'),
(13, 12, 1, 'done', '2019-03-22 11:16:19'),
(14, 13, 162, 'alamat customer bodong', '2019-03-22 11:52:28'),
(15, 11, 162, 'dianalisa dulu ya', '2019-03-22 12:02:44'),
(16, 8, 163, 'boleh di supply ya', '2019-03-22 12:12:33'),
(17, 8, 1, 'credit limit sudah di update', '2019-03-22 12:26:01'),
(18, 13, 163, 'ok boleh di supply', '2019-03-22 16:45:57'),
(19, 13, 1, 'credit limit sudah di update', '2019-03-22 16:46:30'),
(20, 14, 162, 'boleh di supply ya, input credit limit sesuai dengan nominal PO pertama', '2019-03-22 17:11:39'),
(21, 14, 1, 'credit limit sudah di update', '2019-03-22 17:12:15'),
(22, 16, 162, 'tolong lengkapin dokumen NPWP, KTP PIC', '2019-04-25 14:55:49'),
(23, 16, 165, 'dokumen sudah dilengkapi', '2019-04-25 14:56:58'),
(27, 16, 163, 'Dgn pertimbangan track record ok', '2019-04-25 15:25:22'),
(28, 16, 163, 'Ada tolakan giro, jd hold dulu sd byr an msk', '2019-04-25 15:31:07'),
(31, 16, 162, 'belum ada kepastian', '2019-05-09 14:29:32'),
(32, 16, 162, 'udah bisa', '2019-05-09 14:32:01'),
(33, 16, 162, 'blm jelas', '2019-05-09 14:33:43'),
(34, 13, 163, 'Confidential', '2019-05-09 14:36:50'),
(35, 13, 163, 'Confidential', '2019-05-09 14:37:42'),
(36, 13, 163, 'Confidential credit team', '2019-05-09 14:38:05'),
(37, 16, 162, 'coba comment', '2019-05-09 14:38:12'),
(38, 13, 163, 'Confidential ', '2019-05-09 14:38:27'),
(39, 13, 163, 'Abcdefg', '2019-05-09 14:39:01'),
(40, 16, 162, 'tes', '2019-05-09 14:39:35'),
(41, 16, 162, 'msh ga jelas', '2019-05-08 18:39:54'),
(43, 16, 163, 'Minta history payment ya', '2019-05-09 14:41:03'),
(44, 14, 1, 'hold', '2019-05-09 16:57:25'),
(45, 14, 1, 'updated', '2019-05-09 16:57:43'),
(46, 11, 162, 'auto approved', '2019-05-09 18:34:56'),
(47, 11, 162, 'data sudah di update', '2019-05-09 18:35:14'),
(48, 32, 162, 'udah di update', '2019-05-09 18:48:11'),
(49, 16, 162, 'wew', '2019-05-10 15:26:24'),
(50, 31, 162, 'tes', '2019-05-12 17:42:17'),
(51, 31, 162, 'tes lagi', '2019-05-12 19:18:41'),
(52, 31, 162, 'tes lagi 2', '2019-05-12 19:21:09'),
(53, 31, 162, 'tes lagi 3', '2019-05-12 19:28:10'),
(54, 31, 162, 'tes lagi 4', '2019-05-12 19:30:10'),
(55, 31, 162, 'tes lagi 5', '2019-05-12 20:04:28'),
(56, 31, 162, 'tes lagi 6', '2019-05-12 20:06:35'),
(57, 31, 165, 'tes ya', '2019-05-12 22:45:18'),
(58, 30, 162, 'test notification', '2019-05-13 00:56:57'),
(59, 31, 162, 'tes lagi', '2019-05-14 11:17:50'),
(60, 31, 162, 'tes', '2019-05-14 12:00:03'),
(61, 31, 165, 'paan sih', '2019-05-14 14:37:35'),
(62, 33, 162, 'tolong tambahkan document legalitas perusahaan', '2019-05-23 11:02:38'),
(63, 33, 162, 'silahkan diproses', '2019-05-23 11:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `db_companies`
--

CREATE TABLE IF NOT EXISTS `db_companies` (
`id_company` int(10) NOT NULL,
  `name_company` varchar(200) NOT NULL,
  `alias_company` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_companies`
--

INSERT INTO `db_companies` (`id_company`, `name_company`, `alias_company`) VALUES
(0, 'global', 'global'),
(1, 'PT Sefas Pelindotama', 'SP'),
(4, 'PT Sefas Keliantama', 'SK'),
(5, 'PT Tribina Panutan', 'TP'),
(6, 'PT Blue Coolant Indonesia', 'BCI'),
(9, 'PT Cahaya Samoedera Bersaudara', 'CSB');

-- --------------------------------------------------------

--
-- Table structure for table `db_company_areas`
--

CREATE TABLE IF NOT EXISTS `db_company_areas` (
`id_area` int(10) NOT NULL,
  `name_area` varchar(100) NOT NULL,
  `id_company` int(10) NOT NULL,
  `area_address` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_company_areas`
--

INSERT INTO `db_company_areas` (`id_area`, `name_area`, `id_company`, `area_address`) VALUES
(0, 'global', 0, 'global'),
(3, 'Jakarta', 4, 'Jl. Cideng Barat No. 87, Jakarta Pusat'),
(4, 'Cilegon', 5, 'Jl. Raya Bojonegara km. 2  No. 7 RT. 002/004, Kedaleman, Kecamatan Cibeber, Kota Cilego, Banten'),
(5, 'Balikpapan', 1, 'Jl. Mulawarman No. 12 RT 03  Batakan Balikpapan 76116, Kalimantan Timur'),
(7, 'Bali & Nusa Tenggara', 4, 'Bali & Nusa Tenggara'),
(12, 'global', 6, 'Jl. Cideng Barat No. 87, Jakarta Pusat'),
(13, 'Banjarmasin', 1, 'Banjarmasin'),
(14, 'PAMA', 1, 'Jl. Cideng Barat No. 87, Jakarta Pusat'),
(16, 'Tangerang', 5, 'Kawasan Sentral Gudang Bitung Blok B-10 Industri Kadu, Jl. Tembusan Industri Kadu Baitussa Adah RT.03/RW.01, Kel. Kadu, Kec. Curug, Tangerang'),
(17, 'Marine', 9, 'Marine');

-- --------------------------------------------------------

--
-- Table structure for table `db_notification`
--

CREATE TABLE IF NOT EXISTS `db_notification` (
`notification_id` int(11) NOT NULL,
  `notification_label` varchar(200) NOT NULL,
  `notification_link` varchar(200) NOT NULL,
  `notification_datetime` datetime NOT NULL,
  `notification_reference_type` int(11) NOT NULL,
  `notification_reference_id` int(11) NOT NULL,
  `notification_read` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_notification`
--

INSERT INTO `db_notification` (`notification_id`, `notification_label`, `notification_link`, `notification_datetime`, `notification_reference_type`, `notification_reference_id`, `notification_read`, `id_user`) VALUES
(1, 'you have new comment', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 17:42:17', 1, 31, 1, 162),
(2, '$id_user commented on request no. $id', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 19:18:41', 1, 31, 1, 162),
(3, '162 commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 19:21:09', 1, 31, 1, 162),
(4, ' commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 19:28:10', 1, 31, 1, 162),
(5, 'Meliza commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 19:30:10', 1, 31, 1, 162),
(6, 'Meliza commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 20:04:28', 1, 31, 1, 162),
(7, 'Meliza commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 20:06:35', 1, 31, 1, 162),
(8, 'Herni commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-12 22:45:18', 1, 31, 1, 165),
(9, 'Meliza commented on request no. 30', 'http://localhost/cl/index.php/request/view_request/30/19470', '2019-05-13 00:56:57', 1, 30, 1, 162),
(10, 'Meliza commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-14 11:17:50', 1, 31, 1, 162),
(11, 'Meliza commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-14 12:00:03', 1, 31, 1, 162),
(12, 'Herni commented on request no. 31', 'http://localhost/cl/index.php/request/view_request/31/17786', '2019-05-14 14:37:35', 1, 31, 1, 165),
(13, 'Meliza commented on request no. 33', 'http://192.168.1.4/cl/index.php/request/view_request/33/319', '2019-05-23 11:02:38', 1, 33, 1, 162),
(14, 'Meliza commented on request no. 33', 'http://192.168.1.4/cl/index.php/request/view_request/33/319', '2019-05-23 11:28:53', 1, 33, 0, 162);

-- --------------------------------------------------------

--
-- Table structure for table `db_requests`
--

CREATE TABLE IF NOT EXISTS `db_requests` (
`id_request` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `credit_limit` bigint(15) NOT NULL,
  `top` int(4) NOT NULL,
  `max_top` int(4) NOT NULL,
  `po_amount` bigint(15) NOT NULL,
  `requested_note` text NOT NULL,
  `requested_date` datetime NOT NULL,
  `id_request_status` int(1) NOT NULL,
  `update_by` int(2) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_requests`
--

INSERT INTO `db_requests` (`id_request`, `id_user`, `id_customer`, `credit_limit`, `top`, `max_top`, `po_amount`, `requested_note`, `requested_date`, `id_request_status`, `update_by`, `update_date`) VALUES
(8, 165, 7062, 1000000000, 90, 0, 250000000, '<p>customer tidak ada tunggakan sama sekali, baru pertama kali beli</p>', '2019-03-08 17:03:50', 7, 1, '2019-03-22 12:26:01'),
(10, 165, 13422, 1000000000, 60, 0, 60000000, 'tolong di supply, tidak ada tunggakan', '2019-03-21 08:45:32', 1, 0, '0000-00-00 00:00:00'),
(11, 165, 16958, 61000000, 60, 0, 60000000, 'tolong di supply, tidak ada tunggakan', '2019-03-21 08:47:06', 7, 162, '2019-05-09 18:35:14'),
(12, 165, 17574, 150000000, 45, 0, 100000000, 'customer tidak ada tunggakan', '2019-03-21 12:59:45', 7, 1, '2019-03-22 11:16:19'),
(13, 165, 10245, 14000000, 45, 0, 6700000, 'tidak ada masalah pembayaran\n\ntolong di supply', '2019-03-22 10:58:04', 7, 1, '2019-03-22 16:46:30'),
(14, 166, 15771, 16000000, 45, 0, 15500000, 'repeat', '2019-03-22 17:10:09', 7, 1, '2019-05-09 16:57:42'),
(15, 166, 9594, 34000000, 60, 0, 30000000, 'customer baru', '2019-03-22 17:10:41', 1, 0, '0000-00-00 00:00:00'),
(16, 165, 18253, 105000000, 45, 0, 5000000, 'tolong di supply, customer tidak ada AR yang jatuh tempo', '2019-04-25 14:48:44', 4, 162, '2019-05-09 14:39:54'),
(17, 165, 14637, 10000000, 30, 0, 5000000, 'ready', '2019-04-29 16:28:09', 1, 0, '0000-00-00 00:00:00'),
(18, 165, 13422, 0, 30, 0, 4000000, 'customer baru', '2019-05-08 17:12:05', 1, 0, '0000-00-00 00:00:00'),
(19, 165, 6828, 0, 60, 0, 5000000, 'customer baru', '2019-05-08 17:16:57', 1, 0, '0000-00-00 00:00:00'),
(20, 165, 19470, 0, 60, 0, 4000000, 'ready', '2019-05-08 17:17:47', 1, 0, '0000-00-00 00:00:00'),
(21, 165, 13422, 0, 30, 0, 5000000, 'ready', '2019-05-08 17:20:27', 1, 0, '0000-00-00 00:00:00'),
(22, 165, 13422, 0, 60, 0, 1000000, 'ready', '2019-05-08 17:23:38', 1, 0, '0000-00-00 00:00:00'),
(23, 165, 13422, 0, 30, 0, 100000, 'ready', '2019-05-08 17:24:19', 1, 0, '0000-00-00 00:00:00'),
(24, 165, 6828, 0, 30, 0, 100000, 'ready', '2019-05-08 17:25:13', 1, 0, '0000-00-00 00:00:00'),
(25, 165, 13422, 0, 30, 0, 1000000, 'ready', '2019-05-08 17:26:21', 1, 0, '0000-00-00 00:00:00'),
(26, 165, 13422, 0, 30, 0, 1000, 'ready', '2019-05-08 17:27:00', 1, 0, '0000-00-00 00:00:00'),
(27, 165, 13422, 0, 50, 0, 1000000, 'READY', '2019-05-09 09:50:49', 1, 0, '0000-00-00 00:00:00'),
(28, 165, 14333, 0, 0, 0, 1000000, 'a', '2019-05-09 09:57:44', 1, 0, '0000-00-00 00:00:00'),
(29, 165, 19470, 0, 0, 0, 5000000, 'ready', '2019-05-09 10:42:00', 1, 0, '0000-00-00 00:00:00'),
(30, 165, 19470, 5000000, 30, 0, 10000000, 'tes', '2019-05-09 10:44:04', 1, 0, '0000-00-00 00:00:00'),
(31, 165, 17786, 1100000000, 30, 0, 10000000, 'customer baru', '2019-05-09 14:05:23', 1, 0, '0000-00-00 00:00:00'),
(32, 165, 19470, 1000000, 40, 0, 9000000, 'repeat order', '2019-05-09 14:06:40', 7, 162, '2019-05-09 18:48:11'),
(33, 165, 319, 5000000, 30, 0, 5000000, 'customer baru', '2019-05-23 10:56:38', 5, 162, '2019-05-23 11:28:53'),
(34, 165, 17786, 5000000, 60, 75, 10000000, 'repeat order Gadus', '2019-05-23 11:34:06', 1, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `db_request_file`
--

CREATE TABLE IF NOT EXISTS `db_request_file` (
`id_request_file` int(11) NOT NULL,
  `id_request` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `status_confidential` smallint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_request_file`
--

INSERT INTO `db_request_file` (`id_request_file`, `id_request`, `file_name`, `status_confidential`) VALUES
(2, 8, 'Business_Card_BCI7.pdf', 0),
(4, 8, 'General_Intro-SK.pdf', 0),
(5, 10, 'Business_Card_BCI.pdf', 0),
(6, 11, 'Business_Card_BCI1.pdf', 0),
(7, 11, 'General_Intro-SK1.pdf', 0),
(8, 12, 'Business_Card_BCI2.pdf', 0),
(9, 13, 'Business_Card_BCI3.pdf', 0),
(15, 18, 'cideng_timur.jpeg', 0),
(16, 19, 'Business_Card_BCI6.pdf', 0),
(17, 20, 'kedai_mamie.png', 0),
(18, 21, 'Business_Card_BCI8.pdf', 0),
(19, 22, 'cideng_timur1.jpeg', 0),
(20, 22, 'kedai_mamie1.png', 0),
(21, 23, 'Business_Card_BCI9.pdf', 0),
(22, 23, 'General_Intro-SK2.pdf', 0),
(23, 24, 'General_Intro-SK4.pdf', 0),
(24, 24, 'user_CRRM.xlsx', 0),
(25, 25, 'Business_Card_BCI10.pdf', 0),
(26, 25, 'kedai_mamie2.png', 0),
(27, 26, 'Business_Card_BCI11.pdf', 0),
(28, 26, 'cideng_timur2.jpeg', 0),
(29, 31, 'cideng_timur3.jpeg', 0),
(30, 16, 'Business_Card_BCI4.pdf', 1),
(31, 16, 'Business_Card_BCI5.pdf', 0),
(32, 33, '(EXP_1_APR_2019)_PT_CEMINDO_GEMILANG_(1).pdf', 0),
(33, 33, '01._Document_Legalitas_SSTrans_(1)_.pdf', 0),
(34, 33, '4._Flyer_Rubber_Asphalt_General_.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_request_status`
--

CREATE TABLE IF NOT EXISTS `db_request_status` (
`id_request_status` int(11) NOT NULL,
  `name_request_status` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_request_status`
--

INSERT INTO `db_request_status` (`id_request_status`, `name_request_status`) VALUES
(1, 'New'),
(2, 'Hold'),
(3, 'Recommended'),
(4, 'Not Recommended'),
(5, 'Approved'),
(6, 'Reject'),
(7, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `db_request_timeline`
--

CREATE TABLE IF NOT EXISTS `db_request_timeline` (
`id_timeline` int(11) NOT NULL,
  `id_request` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_timeline` datetime NOT NULL,
  `id_request_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_request_timeline`
--

INSERT INTO `db_request_timeline` (`id_timeline`, `id_request`, `id_user`, `date_timeline`, `id_request_status`) VALUES
(1, 12, 165, '2019-03-21 12:59:45', 1),
(2, 8, 162, '2019-03-21 17:26:17', 3),
(3, 13, 165, '2019-03-22 10:58:04', 1),
(4, 13, 162, '2019-03-22 11:04:36', 3),
(5, 12, 162, '2019-03-22 11:07:33', 5),
(6, 12, 1, '2019-03-22 11:16:19', 7),
(7, 13, 162, '2019-03-22 11:52:28', 4),
(8, 11, 162, '2019-03-22 12:02:44', 2),
(9, 8, 163, '2019-03-22 12:12:33', 5),
(10, 8, 1, '2019-03-22 12:26:01', 7),
(11, 13, 163, '2019-03-22 16:45:57', 5),
(12, 13, 1, '2019-03-22 16:46:30', 7),
(13, 14, 166, '2019-03-22 17:10:09', 1),
(14, 15, 166, '2019-03-22 17:10:41', 1),
(15, 14, 162, '2019-03-22 17:11:39', 5),
(16, 14, 1, '2019-03-22 17:12:15', 7),
(17, 16, 165, '2019-04-25 14:48:44', 1),
(18, 16, 162, '2019-04-25 14:59:54', 3),
(19, 16, 163, '2019-04-25 15:25:22', 5),
(20, 16, 163, '2019-04-25 15:31:07', 2),
(21, 16, 163, '2019-04-25 15:32:17', 5),
(22, 16, 163, '2019-04-25 15:40:00', 6),
(23, 17, 165, '2019-04-29 16:28:09', 1),
(24, 18, 165, '2019-05-08 17:12:05', 1),
(25, 19, 165, '2019-05-08 17:16:57', 1),
(26, 20, 165, '2019-05-08 17:17:47', 1),
(27, 21, 165, '2019-05-08 17:20:27', 1),
(28, 22, 165, '2019-05-08 17:23:38', 1),
(29, 23, 165, '2019-05-08 17:24:19', 1),
(30, 24, 165, '2019-05-08 17:25:13', 1),
(31, 25, 165, '2019-05-08 17:26:21', 1),
(32, 26, 165, '2019-05-08 17:27:00', 1),
(33, 27, 165, '2019-05-09 09:50:49', 1),
(34, 28, 165, '2019-05-09 09:57:44', 1),
(35, 29, 165, '2019-05-09 10:42:00', 1),
(36, 30, 165, '2019-05-09 10:44:04', 1),
(37, 31, 165, '2019-05-09 14:05:23', 1),
(38, 32, 165, '2019-05-09 14:06:40', 1),
(39, 16, 162, '2019-05-09 14:29:32', 2),
(40, 16, 162, '2019-05-09 14:32:01', 3),
(41, 16, 162, '2019-05-09 14:33:43', 2),
(42, 16, 162, '2019-05-09 14:39:35', 2),
(43, 16, 162, '2019-05-09 14:39:54', 4),
(44, 14, 1, '2019-05-09 16:57:25', 2),
(45, 14, 1, '2019-05-09 16:57:42', 7),
(46, 11, 162, '2019-05-09 18:34:56', 5),
(47, 11, 162, '2019-05-09 18:35:14', 7),
(48, 32, 162, '2019-05-09 18:48:11', 7),
(49, 33, 165, '2019-05-23 10:56:38', 1),
(50, 33, 162, '2019-05-23 11:28:53', 5),
(51, 34, 165, '2019-05-23 11:34:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_roles`
--

CREATE TABLE IF NOT EXISTS `db_roles` (
`id` int(10) NOT NULL,
  `name_role` varchar(100) NOT NULL,
  `permissions` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_roles`
--

INSERT INTO `db_roles` (`id`, `name_role`, `permissions`) VALUES
(1, 'Administrator', '{"admin_login":1,"user_list":1,"user_role":1,"admin_view":0,"request":1,"view_request":1,"customer":1,"notification":1}'),
(7, 'Credit Admin', '{"admin_login":1,"user_list":0,"user_role":0,"admin_view":1,"request":1,"view_request":1,"customer":0,"notification":1}'),
(8, 'Finance Manager', '{"admin_login":1,"user_list":0,"user_role":0,"admin_view":1,"request":1,"view_request":1,"customer":0,"notification":1}'),
(9, 'Finance Director', '{"admin_login":1,"user_list":0,"user_role":0,"admin_view":1,"request":1,"view_request":1,"customer":0,"notification":1}'),
(10, 'Sales Admin', '{"admin_login":1,"user_list":0,"user_role":0,"admin_view":0,"request":1,"view_request":1,"customer":0,"notification":1}');

-- --------------------------------------------------------

--
-- Table structure for table `db_roles_users`
--

CREATE TABLE IF NOT EXISTS `db_roles_users` (
`id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_roles_users`
--

INSERT INTO `db_roles_users` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1),
(162, 7, 162),
(163, 8, 163),
(164, 9, 164),
(165, 10, 165),
(166, 10, 166),
(167, 1, 167);

-- --------------------------------------------------------

--
-- Table structure for table `db_users`
--

CREATE TABLE IF NOT EXISTS `db_users` (
`id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `id_role` int(1) NOT NULL,
  `id_company` char(2) NOT NULL,
  `id_area` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_users`
--

INSERT INTO `db_users` (`id`, `email`, `password`, `name_user`, `id_role`, `id_company`, `id_area`, `phone`, `mobile_phone`, `photo`) VALUES
(1, 'it@sefasgroup.com', '86630c8cb0a331f1735f3176dd1e8988', 'Dion', 1, '0', 0, '', '', '1.jpg'),
(162, 'credit@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Meliza', 7, '0', 0, '', '', '162.jpg'),
(163, 'kurniadi.ligawan@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Kurniadi Ligawan', 8, '0', 0, '', '', ''),
(164, 'yulia.trifena@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Yulia', 9, '0', 0, '', '', ''),
(165, 'herni.rismawati@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Herni', 10, '4', 3, '', '', '165.jpg'),
(166, 'sefas.nugra@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Devi', 10, '4', 7, '', '', ''),
(167, 'febri.satria@sefasgroup.com', 'b7be342667b2adabf3e8f420616e278d', 'Febri Satria', 1, '0', 0, '', '081315745009', '167.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `db_comment`
--
ALTER TABLE `db_comment`
 ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `db_companies`
--
ALTER TABLE `db_companies`
 ADD PRIMARY KEY (`id_company`);

--
-- Indexes for table `db_company_areas`
--
ALTER TABLE `db_company_areas`
 ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `db_notification`
--
ALTER TABLE `db_notification`
 ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `db_requests`
--
ALTER TABLE `db_requests`
 ADD PRIMARY KEY (`id_request`);

--
-- Indexes for table `db_request_file`
--
ALTER TABLE `db_request_file`
 ADD PRIMARY KEY (`id_request_file`);

--
-- Indexes for table `db_request_status`
--
ALTER TABLE `db_request_status`
 ADD PRIMARY KEY (`id_request_status`);

--
-- Indexes for table `db_request_timeline`
--
ALTER TABLE `db_request_timeline`
 ADD PRIMARY KEY (`id_timeline`);

--
-- Indexes for table `db_roles`
--
ALTER TABLE `db_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_roles_users`
--
ALTER TABLE `db_roles_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_users`
--
ALTER TABLE `db_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_comment`
--
ALTER TABLE `db_comment`
MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `db_companies`
--
ALTER TABLE `db_companies`
MODIFY `id_company` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `db_company_areas`
--
ALTER TABLE `db_company_areas`
MODIFY `id_area` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `db_notification`
--
ALTER TABLE `db_notification`
MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `db_requests`
--
ALTER TABLE `db_requests`
MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `db_request_file`
--
ALTER TABLE `db_request_file`
MODIFY `id_request_file` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `db_request_status`
--
ALTER TABLE `db_request_status`
MODIFY `id_request_status` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `db_request_timeline`
--
ALTER TABLE `db_request_timeline`
MODIFY `id_timeline` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `db_roles`
--
ALTER TABLE `db_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `db_roles_users`
--
ALTER TABLE `db_roles_users`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=168;
--
-- AUTO_INCREMENT for table `db_users`
--
ALTER TABLE `db_users`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=168;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
