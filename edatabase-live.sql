-- --------------------------------------------------------
-- Host:                         sql6.freemysqlhosting.net
-- Server version:               5.5.62-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sql6525945
CREATE DATABASE IF NOT EXISTS `sql6525945` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sql6525945`;

-- Dumping structure for table sql6525945.biodata
CREATE TABLE IF NOT EXISTS `biodata` (
  `ID` varchar(50) NOT NULL DEFAULT '',
  `SDMID` int(11) NOT NULL,
  `Posisi` varchar(50) DEFAULT NULL,
  `Nama_personil` varchar(50) DEFAULT NULL,
  `Nama_perusahaan` varchar(50) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(50) DEFAULT NULL,
  `Pendidikan` text,
  `Pendidikan_non_formal` text,
  `Nomor_hp` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  `Status_bio` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.biodata: ~1 rows (approximately)
/*!40000 ALTER TABLE `biodata` DISABLE KEYS */;
INSERT IGNORE INTO `biodata` (`ID`, `SDMID`, `Posisi`, `Nama_personil`, `Nama_perusahaan`, `Tempat_tanggal_lahir`, `Pendidikan`, `Pendidikan_non_formal`, `Nomor_hp`, `Email`, `Status`, `Status_bio`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	('BIO-00001', 0, 'Project Manager', 'Maria Palastri', 'WIJAYA KARYA (PERSERO), TBK .PT', 'Semarang, 12 Oktober 1993', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:05', NULL),
	('BIO-00002', 0, 'Site Engineer', 'Patricia Prastuti', 'WASKITA KARYA (PERSERO), TBK .PT', 'Medan, 21 Mei 1990', 'S1 Teknik Sipil ', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:05', NULL),
	('BIO-00003', 0, 'Structure Engineering', 'Bahuraksa Tamba', 'PEMBANGUNAN PERUMAHAN (PERSERO)TBK .PT', 'Jakarta, 31 Juli 1991', 'S1 Teknik Konstruksi Gedung', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('BIO-00004', 0, 'Architect Engineering', 'Budi Saptono', 'ADHI KARYA (PERSERO) TBK ,PT', 'Bandung, 12 Desember 1989', 'S1 Teknik Konstruksi Dan perumahan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('BIO-00005', 0, 'Quality Control', 'Kacung Permadi', 'Hutama Karya .PT', 'Bekasi, 09 Maret 1982', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('BIO-00006', 0, 'Drafter', 'Umay Permadi', 'Brantas Abipraya .PT', 'Surabaya, 12 November 1998', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('BIO-00007', 0, 'Quantity Engineer', 'Restu Suryatmi', 'Nindya Karya .PT', 'Cimahi, 02 Oktober 1999', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('BIO-00008', 0, 'Staff Akuntansi', 'Laswi Firgantoro', 'Istaka Karya .PT', 'Cianjur, 09 September 2000', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:07', NULL),
	('BIO-00009', 0, 'Administrasi Umum', 'Ajeng Mayasari', 'Amarta Karya .PT', 'Depok, 04 Agustus 2001', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:07', NULL),
	('BIO-00010', 0, 'General Affair', 'Belinda Mulyani', 'ADHI PERSADA GEDUNG .PT', 'Cibubur, 06 Maret 2002', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:07', NULL),
	('BIO-00011', 0, 'Chief Inspector', 'Warji Firgantoro', 'WIJAYA KARYA BETON, TBK .PT', 'Purworejo, 30 Juni 1991', 'S1 Teknik Sipil ', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:08', NULL),
	('BIO-00012', 0, 'Supervisor', 'Syahrini Puspita', 'WIJAYA KARYA INDUSTRI & KONSTRUKSI .PT', 'Tanggerang, 01 Oktober 2004', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:08', NULL),
	('BIO-00013', 0, 'Surveyor', 'Laila Suryatmi', 'WASKITA BETON PRECAST TBK .PT', 'Depok, 29 Oktober 2005', 'S1 Teknik Sipil Dan Perencanaan', 'Seminar Nasional Teknik Sipil 2022\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi', NULL, NULL, 1, 1, 'Admin', NULL, '2022-10-14 13:48:08', NULL);
/*!40000 ALTER TABLE `biodata` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sql6525945.ci_sessions: ~2 rows (approximately)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT IGNORE INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('5h1rkn4utqgc5rglgk03ntoiembr1t3f', '::1', 1637284653, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633373238343635333B6261686173617C733A373A22656E676C697368223B6C6F67696E7C623A313B5573657249447C733A313A2231223B456D61696C7C733A31383A226173656D7437313040676D61696C2E636F6D223B4E616D657C733A353A2241646D696E223B4E616D654C6173747C733A303A22223B526F6C6549447C733A313A2231223B4C6576656C7C4E3B48616B416B7365737C733A31313A22446576656C6F706D656E74223B48616B416B736573547970657C733A313A2231223B48616B416B736573547970655478747C733A393A22446576656C6F706572223B496D6167657C733A36383A22687474703A2F2F6C6F63616C686F73742F652D64617461626173652D63762D6769742F696D672F636F6D70616E792F616C70615F3231303932343232313933332E706E67223B50686F6E657C733A31313A223839363039393734313139223B5374617475737C733A313A2231223B446570617274656D656E747C733A303A22223B436F6D70616E7949447C733A313A2231223B436F6D70616E794E616D657C733A353A2241646D696E223B436F6D70616E79496D6167657C733A36383A22687474703A2F2F6C6F63616C686F73742F652D64617461626173652D63762D6769742F696D672F636F6D70616E792F616C70615F3231303932343232313933332E706E67223B436F6D70616E7950686F6E657C733A31313A223839363039393734313139223B436F6D70616E7949736F7C733A333A222B3632223B436F6D70616E79456D61696C7C733A31383A226173656D7437313040676D61696C2E636F6D223B436F6D70616E794C6F636174696F6E7C733A373A2242616E64756E67223B436F6D70616E794C617469747564657C733A31383A222D362E393532353834333733353433303537223B436F6D70616E794C6F6E6769747564657C733A31383A223130372E3539373232373331383030353235223B436F6D70616E795261646975737C733A343A2231303030223B436F6D70616E79416464726573737C4E3B436F6D70616E794A6F696E446174657C733A31303A22323031392D31312D3136223B436F6D70616E79557365724E616D657C733A353A2241646D696E223B436F6D70616E795374617274576F726B446174657C733A31303A22323032302D30312D3235223B436F6D70616E795468656D657C733A313A2233223B506172656E744C6973747C613A303A7B7D706167656E79617C733A303A22223B746970656E79617C733A303A22223B),
	('d6ehdt32bjgibqhsgjuavpvuc8gr2vl3', '::1', 1637284655, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633373238343635333B6261686173617C733A373A22656E676C697368223B6C6F67696E7C623A313B5573657249447C733A313A2231223B456D61696C7C733A31383A226173656D7437313040676D61696C2E636F6D223B4E616D657C733A353A2241646D696E223B4E616D654C6173747C733A303A22223B526F6C6549447C733A313A2231223B4C6576656C7C4E3B48616B416B7365737C733A31313A22446576656C6F706D656E74223B48616B416B736573547970657C733A313A2231223B48616B416B736573547970655478747C733A393A22446576656C6F706572223B496D6167657C733A36383A22687474703A2F2F6C6F63616C686F73742F652D64617461626173652D63762D6769742F696D672F636F6D70616E792F616C70615F3231303932343232313933332E706E67223B50686F6E657C733A31313A223839363039393734313139223B5374617475737C733A313A2231223B446570617274656D656E747C733A303A22223B436F6D70616E7949447C733A313A2231223B436F6D70616E794E616D657C733A353A2241646D696E223B436F6D70616E79496D6167657C733A36383A22687474703A2F2F6C6F63616C686F73742F652D64617461626173652D63762D6769742F696D672F636F6D70616E792F616C70615F3231303932343232313933332E706E67223B436F6D70616E7950686F6E657C733A31313A223839363039393734313139223B436F6D70616E7949736F7C733A333A222B3632223B436F6D70616E79456D61696C7C733A31383A226173656D7437313040676D61696C2E636F6D223B436F6D70616E794C6F636174696F6E7C733A373A2242616E64756E67223B436F6D70616E794C617469747564657C733A31383A222D362E393532353834333733353433303537223B436F6D70616E794C6F6E6769747564657C733A31383A223130372E3539373232373331383030353235223B436F6D70616E795261646975737C733A343A2231303030223B436F6D70616E79416464726573737C4E3B436F6D70616E794A6F696E446174657C733A31303A22323031392D31312D3136223B436F6D70616E79557365724E616D657C733A353A2241646D696E223B436F6D70616E795374617274576F726B446174657C733A31303A22323032302D30312D3235223B436F6D70616E795468656D657C733A313A2233223B506172656E744C6973747C613A303A7B7D706167656E79617C733A303A22223B746970656E79617C733A303A22223B);
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_daftar_riwayat
CREATE TABLE IF NOT EXISTS `mt_daftar_riwayat` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BioID` varchar(50) DEFAULT NULL,
  `PelID` varchar(50) DEFAULT NULL,
  `Posisi` varchar(250) DEFAULT NULL,
  `Uraian_tugas` text,
  `Nama_perusahaan` varchar(250) DEFAULT NULL,
  `Nama_personil` varchar(250) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(250) DEFAULT NULL,
  `Pendidikan` text,
  `Pendidikan_non_formal` text,
  `Nama_kegiatan` varchar(500) DEFAULT NULL,
  `Lokasi_kegiatan` varchar(500) DEFAULT NULL,
  `Pengguna_jasa` varchar(500) DEFAULT NULL,
  `Waktu_pelaksanaan_mulai` date DEFAULT NULL,
  `Waktu_pelaksanaan_selesai` date DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  `Status_bio` int(11) DEFAULT '1',
  `UserAdd` varchar(1024) DEFAULT NULL,
  `UserCh` varchar(1024) DEFAULT NULL,
  `DateAdd` varchar(1024) DEFAULT NULL,
  `DateCh` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_daftar_riwayat: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_daftar_riwayat` DISABLE KEYS */;
INSERT IGNORE INTO `mt_daftar_riwayat` (`ID`, `BioID`, `PelID`, `Posisi`, `Uraian_tugas`, `Nama_perusahaan`, `Nama_personil`, `Tempat_tanggal_lahir`, `Pendidikan`, `Pendidikan_non_formal`, `Nama_kegiatan`, `Lokasi_kegiatan`, `Pengguna_jasa`, `Waktu_pelaksanaan_mulai`, `Waktu_pelaksanaan_selesai`, `Status`, `Status_bio`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	(1, NULL, 'PEL-00001', NULL, NULL, 'PT. Nusa Konstruksi Engginnering (NKE) tbk', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Jakarta', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:13', NULL),
	(2, NULL, 'PEL-00002', NULL, NULL, 'PT. Acset Indonusa tbk', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Sumatera', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:13', NULL),
	(3, NULL, 'PEL-00003', NULL, NULL, 'PT. Bumi Karsa', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'NTT', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(4, NULL, 'PEL-00004', NULL, NULL, 'PT. Jaya Konstruksi Manggala Pratama tbk', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Kalimantan', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(5, NULL, 'PEL-00005', NULL, NULL, 'PT. Nusa Raya Cipta tbk', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Jakarta', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(6, NULL, 'PEL-00006', NULL, NULL, 'PT. Fanitra Indotama', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Sumatera', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(7, NULL, 'PEL-00007', NULL, NULL, 'PT. Lubuk Minturun Konstruksi Persada', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'NTT', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(8, NULL, 'PEL-00008', NULL, NULL, 'PT. Conbloc Infratecno', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Kalimantan', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(9, NULL, 'PEL-00009', NULL, NULL, 'PT. Modern Surya Jaya', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Jakarta', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(10, NULL, 'PEL-00010', NULL, NULL, 'PT. Modern Widya Technical', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Sumatera', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:14', NULL),
	(11, NULL, 'PEL-00011', NULL, NULL, 'PT. Sumbersari Cipta Marga', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'NTT', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:15', NULL),
	(12, NULL, 'PEL-00012', NULL, NULL, 'PT. Gorip Nanda Guna', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Kalimantan', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:15', NULL),
	(13, NULL, 'PEL-00013', NULL, NULL, 'PT. Total Bangun Persada tbkPT. Nusa Konstruksi Engginnering (NKE) tbk', NULL, NULL, NULL, NULL, 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Jakarta', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', '2020-06-01', '2022-05-02', 1, 1, 'Admin', NULL, '2022-10-14 13:48:15', NULL);
/*!40000 ALTER TABLE `mt_daftar_riwayat` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_konstruksi
CREATE TABLE IF NOT EXISTS `mt_konstruksi` (
  `ID` varchar(50) NOT NULL DEFAULT '',
  `BioID` varchar(50) NOT NULL DEFAULT '',
  `PelID` varchar(50) NOT NULL DEFAULT '',
  `Posisi` varchar(50) DEFAULT NULL,
  `Nama_perusahaan1` varchar(50) DEFAULT NULL,
  `Nama_personil` varchar(50) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(50) DEFAULT NULL,
  `Pendidikan` text,
  `Pendidikan_non_formal` text,
  `Penguasaan_bahasa_indo` varchar(50) DEFAULT NULL,
  `Penguasaan_bahasa_inggris` varchar(50) DEFAULT NULL,
  `Penguasaan_bahasa_setempat` varchar(50) DEFAULT NULL,
  `Status_kepegawaian2` varchar(50) DEFAULT NULL,
  `Pernyataan` int(11) DEFAULT '0',
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_konstruksi: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_konstruksi` DISABLE KEYS */;
INSERT IGNORE INTO `mt_konstruksi` (`ID`, `BioID`, `PelID`, `Posisi`, `Nama_perusahaan1`, `Nama_personil`, `Tempat_tanggal_lahir`, `Pendidikan`, `Pendidikan_non_formal`, `Penguasaan_bahasa_indo`, `Penguasaan_bahasa_inggris`, `Penguasaan_bahasa_setempat`, `Status_kepegawaian2`, `Pernyataan`, `Status`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`, `CompanyID`) VALUES
	('FIK-00001', '', '', 'Site Engineer', 'WASKITA KARYA (PERSERO), TBK .PT', 'Patricia Prastuti', 'Medan, 21 Mei 1990', '<div>S1 Teknik Sipil </div>', '<div>Seminar Nasional Teknik Sipil 2022\r\nInovasi Teknologi Mitigasi Bencana di Bidang Konstruksi</div>', 'Baik', 'Sangat Baik', 'Sangat Baik', 'Tetap', 1, 1, 'Admin', 'Admin', '2022-10-14 13:49:47', '2022-10-14 14:07:45', NULL);
/*!40000 ALTER TABLE `mt_konstruksi` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_konstruksi_det
CREATE TABLE IF NOT EXISTS `mt_konstruksi_det` (
  `DetID` int(11) NOT NULL AUTO_INCREMENT,
  `PengalamanID` varchar(50) DEFAULT NULL,
  `ID` varchar(50) NOT NULL DEFAULT '',
  `Nama_kegiatan` varchar(500) DEFAULT NULL,
  `Lokasi_kegiatan` varchar(500) DEFAULT NULL,
  `Pengguna_jasa` varchar(500) DEFAULT NULL,
  `Nama_perusahaan` varchar(500) DEFAULT NULL,
  `Uraian_tugas` text,
  `Waktu_pelaksanaan` varchar(500) DEFAULT NULL,
  `Posisi_penugasan` varchar(500) DEFAULT NULL,
  `Status_kepegawaian` varchar(500) DEFAULT NULL,
  `Surat_referensi` varchar(500) DEFAULT NULL,
  `Description` text,
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DetID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_konstruksi_det: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_konstruksi_det` DISABLE KEYS */;
INSERT IGNORE INTO `mt_konstruksi_det` (`DetID`, `PengalamanID`, `ID`, `Nama_kegiatan`, `Lokasi_kegiatan`, `Pengguna_jasa`, `Nama_perusahaan`, `Uraian_tugas`, `Waktu_pelaksanaan`, `Posisi_penugasan`, `Status_kepegawaian`, `Surat_referensi`, `Description`, `Status`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`, `CompanyID`) VALUES
	(10, 'PEL-00001', 'FIK-00001', 'Manajemen Konstruksi Penataan KSPN Kawasan Puncak Waringin Kabupaten Manggarai Barat', 'Jakarta', 'Pelaksanaan Prasarana Permukiman Wilayah II Provinsi', 'PT. Nusa Konstruksi Engginnering (NKE) tbk', 'Sebagai penanggung jawab tertinggi pekerjaan manajemen konstruksi secara keceluruhan ;\r\nSebagai koordinator seluruh kegiatan teknis maupun administrasi di lapangan ;\r\nSebagai pengkoordinir komunikasi antara PPK dengan penyedia jasa konstruksi .', '01 Juni 2020 - 02 Mei 2022 (23 Bulan)', 'Tenaga Ahli Sipil', 'Tetap', 'Terlampir', NULL, 1, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `mt_konstruksi_det` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_non_konstruksi
CREATE TABLE IF NOT EXISTS `mt_non_konstruksi` (
  `ID` varchar(50) NOT NULL DEFAULT '',
  `BioID` varchar(50) NOT NULL DEFAULT '',
  `Posisi` varchar(50) DEFAULT NULL,
  `Nama_perusahaan1` varchar(50) DEFAULT NULL,
  `Nama_personil` varchar(50) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(50) DEFAULT NULL,
  `Pendidikan` varchar(50) DEFAULT NULL,
  `Pendidikan_non_formal` varchar(50) DEFAULT NULL,
  `Penguasaan_bahasa_indo` varchar(50) DEFAULT NULL,
  `Penguasaan_bahasa_inggris` varchar(50) DEFAULT NULL,
  `Penguasaan_bahasa_setempat` varchar(50) DEFAULT NULL,
  `Status_kepegawaian2` varchar(50) DEFAULT NULL,
  `Pernyataan` int(11) DEFAULT '0',
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_non_konstruksi: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_non_konstruksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `mt_non_konstruksi` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_non_konstruksi_det
CREATE TABLE IF NOT EXISTS `mt_non_konstruksi_det` (
  `DetID` int(11) NOT NULL AUTO_INCREMENT,
  `PengalamanID` varchar(50) DEFAULT NULL,
  `ID` varchar(50) NOT NULL DEFAULT '',
  `Nama_kegiatan` varchar(500) DEFAULT NULL,
  `Lokasi_kegiatan` varchar(500) DEFAULT NULL,
  `Pengguna_jasa` varchar(500) DEFAULT NULL,
  `Nama_perusahaan` varchar(500) DEFAULT NULL,
  `Uraian_tugas` text,
  `Waktu_pelaksanaan` varchar(500) DEFAULT NULL,
  `Posisi_penugasan` varchar(500) DEFAULT NULL,
  `Status_kepegawaian` varchar(500) DEFAULT NULL,
  `Surat_referensi` varchar(500) DEFAULT NULL,
  `Description` text,
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_non_konstruksi_det: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_non_konstruksi_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `mt_non_konstruksi_det` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_posisi_uraian
CREATE TABLE IF NOT EXISTS `mt_posisi_uraian` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Posisi` varchar(250) DEFAULT NULL,
  `Uraian_tugas` text,
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(1024) DEFAULT NULL,
  `UserCh` varchar(1024) DEFAULT NULL,
  `DateAdd` varchar(1024) DEFAULT NULL,
  `DateCh` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_posisi_uraian: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_posisi_uraian` DISABLE KEYS */;
INSERT IGNORE INTO `mt_posisi_uraian` (`ID`, `Posisi`, `Uraian_tugas`, `Status`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	(1, 'Tenaga Ahli Sipil', 'Sebagai penanggung jawab tertinggi pekerjaan manajemen konstruksi secara keceluruhan ;\nSebagai koordinator seluruh kegiatan teknis maupun administrasi di lapangan ;\nSebagai pengkoordinir komunikasi antara PPK dengan penyedia jasa konstruksi .', 1, 'Admin', NULL, '2022-10-14 13:31:21', NULL);
/*!40000 ALTER TABLE `mt_posisi_uraian` ENABLE KEYS */;

-- Dumping structure for table sql6525945.mt_sdm
CREATE TABLE IF NOT EXISTS `mt_sdm` (
  `ID` varchar(50) NOT NULL DEFAULT '',
  `BIOID` int(11) NOT NULL,
  `Nama_personil` varchar(500) DEFAULT NULL,
  `Status_pegawai` varchar(500) DEFAULT NULL,
  `Status_pegawai1` int(11) DEFAULT '0',
  `Nama_perusahaan` varchar(500) DEFAULT NULL,
  `Proyek` varchar(500) DEFAULT NULL,
  `Periode_proyek_mulai` date DEFAULT NULL,
  `Periode_proyek_selesai` date DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  `Status_sdm` int(11) DEFAULT '0',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.mt_sdm: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_sdm` DISABLE KEYS */;
INSERT IGNORE INTO `mt_sdm` (`ID`, `BIOID`, `Nama_personil`, `Status_pegawai`, `Status_pegawai1`, `Nama_perusahaan`, `Proyek`, `Periode_proyek_mulai`, `Periode_proyek_selesai`, `Status`, `Status_sdm`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	('SDM-00001', 0, 'Maria Palastri', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:05', NULL),
	('SDM-00002', 0, 'Patricia Prastuti', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:05', NULL),
	('SDM-00003', 0, 'Bahuraksa Tamba', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('SDM-00004', 0, 'Budi Saptono', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('SDM-00005', 0, 'Kacung Permadi', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('SDM-00006', 0, 'Umay Permadi', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('SDM-00007', 0, 'Restu Suryatmi', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:06', NULL),
	('SDM-00008', 0, 'Laswi Firgantoro', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:07', NULL),
	('SDM-00009', 0, 'Ajeng Mayasari', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:07', NULL),
	('SDM-00010', 0, 'Belinda Mulyani', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:08', NULL),
	('SDM-00011', 0, 'Warji Firgantoro', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:08', NULL),
	('SDM-00012', 0, 'Syahrini Puspita', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:08', NULL),
	('SDM-00013', 0, 'Laila Suryatmi', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, 'Admin', NULL, '2022-10-14 13:48:08', NULL);
/*!40000 ALTER TABLE `mt_sdm` ENABLE KEYS */;

-- Dumping structure for table sql6525945.proyek
CREATE TABLE IF NOT EXISTS `proyek` (
  `ID` varchar(50) NOT NULL DEFAULT '',
  `AttachmentID` int(11) DEFAULT NULL,
  `Nama_kegiatan` varchar(50) DEFAULT NULL,
  `Pengguna_jasa` varchar(50) DEFAULT NULL,
  `Tanggal_tender` date DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sql6525945.proyek: ~0 rows (approximately)
/*!40000 ALTER TABLE `proyek` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyek` ENABLE KEYS */;

-- Dumping structure for table sql6525945.t_temp
CREATE TABLE IF NOT EXISTS `t_temp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` int(11) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `Code` varchar(50) DEFAULT NULL,
  `Page` varchar(50) DEFAULT NULL,
  `Column` varchar(50) DEFAULT NULL,
  `Temp` longtext,
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='temporary table before save to real table\r\n';

-- Dumping data for table sql6525945.t_temp: 0 rows
/*!40000 ALTER TABLE `t_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_temp` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_attachment
CREATE TABLE IF NOT EXISTS `ut_attachment` (
  `AttachmentID` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` int(11) NOT NULL,
  `ID` varchar(50) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL,
  `Remark` text,
  `Url` text,
  `Type` varchar(50) DEFAULT NULL,
  `Cek` int(11) NOT NULL DEFAULT '0',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`AttachmentID`,`CompanyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_attachment: ~0 rows (approximately)
/*!40000 ALTER TABLE `ut_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ut_attachment` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_general
CREATE TABLE IF NOT EXISTS `ut_general` (
  `Code` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Value` text,
  `Image` blob,
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`Code`,`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_general: ~8 rows (approximately)
/*!40000 ALTER TABLE `ut_general` DISABLE KEYS */;
INSERT IGNORE INTO `ut_general` (`Code`, `Name`, `Value`, `Image`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	('general', 'AppDownloadLink', '', NULL, 'Development', 'Development', '2021-08-28 23:12:10', '2021-09-03 13:38:14'),
	('general', 'AppName', 'E-DATABASE CV', NULL, 'Development', NULL, '2020-05-14 15:06:33', NULL),
	('general', 'AppReviewLink', '', NULL, 'Development', 'Development', '2021-08-28 23:12:10', '2021-09-03 13:38:14'),
	('general', 'AppVersionCode', '', NULL, 'Development', 'Development', '2021-08-28 23:12:10', '2021-09-03 13:38:14'),
	('general', 'AppVersionName', '', NULL, 'Development', 'Development', '2021-08-28 23:12:10', '2021-09-03 13:38:14'),
	('general', 'SiteLogo', 'img/attachment/alpa_SiteLogo_general_1630651094.png', NULL, 'Development', 'Development', '2020-01-03 23:56:41', '2021-09-03 13:38:14'),
	('policy-page-setting', 'Description', '\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<div><br></div>', NULL, 'Development', 'Admin', '2020-01-01 09:18:04', '2021-09-25 18:52:47'),
	('term-and-condition', 'Description', '<p>Term and Condition</p>', NULL, 'Development', 'Development', '2020-01-01 12:05:29', '2020-01-03 22:10:32');
/*!40000 ALTER TABLE `ut_general` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_log
CREATE TABLE IF NOT EXISTS `ut_log` (
  `Code` varchar(50) NOT NULL DEFAULT '',
  `CompanyID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `HakAksesType` int(11) DEFAULT '0' COMMENT 'deskripsi ada di ut_role type',
  `LogType` int(11) DEFAULT NULL COMMENT '1 = log, 2 = notif, 3 = open page',
  `Type` int(11) DEFAULT NULL COMMENT '1 = login, 2 = insert, 3 = update, 4 = delete, 5 = logout, 6 = active, 7 = nonactive, 8 = approve, 9 = rejected, 10 = save attachment, 11 = delete attachment. 12 = open page',
  `Page` varchar(50) DEFAULT NULL,
  `Content` text,
  `UserAgent` text,
  `Status` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`Code`,`CompanyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_log: ~391 rows (approximately)
/*!40000 ALTER TABLE `ut_log` DISABLE KEYS */;
INSERT IGNORE INTO `ut_log` (`Code`, `CompanyID`, `UserID`, `HakAksesType`, `LogType`, `Type`, `Page`, `Content`, `UserAgent`, `Status`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	('LOG-2021-IX-00001', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
	('LOG-2021-IX-00001', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 09:39:47', NULL),
	('LOG-2021-IX-00002', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 09:39:47', NULL),
	('LOG-2021-IX-00003', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 14:17:05', NULL),
	('LOG-2021-IX-00004', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 14:17:05', NULL),
	('LOG-2021-IX-00005', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 21:08:52', NULL),
	('LOG-2021-IX-00006', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 21:31:29', NULL),
	('LOG-2021-IX-00007', 1, 1, 1, 1, 3, 'company', '1', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 21:57:59', NULL),
	('LOG-2021-IX-00008', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 21:58:21', NULL),
	('LOG-2021-IX-00009', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 21:58:21', NULL),
	('LOG-2021-IX-00010', 1, 1, 1, 1, 3, 'company', '1', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Development', NULL, '2021-09-06 22:01:21', NULL),
	('LOG-2021-IX-00011', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 22:01:35', NULL),
	('LOG-2021-IX-00012', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 22:01:35', NULL),
	('LOG-2021-IX-00013', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 22:03:12', NULL),
	('LOG-2021-IX-00014', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 23:25:39', NULL),
	('LOG-2021-IX-00015', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 23:25:40', NULL),
	('LOG-2021-IX-00016', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 23:26:38', NULL),
	('LOG-2021-IX-00017', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-06 23:27:38', NULL),
	('LOG-2021-IX-00018', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 00:55:10', NULL),
	('LOG-2021-IX-00019', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 00:55:10', NULL),
	('LOG-2021-IX-00020', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 02:03:55', NULL),
	('LOG-2021-IX-00021', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 92.0.4515.159","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 02:03:55', NULL),
	('LOG-2021-IX-00022', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 19:37:51', NULL),
	('LOG-2021-IX-00023', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 19:37:51', NULL),
	('LOG-2021-IX-00024', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 20:44:14', NULL),
	('LOG-2021-IX-00025', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 20:44:14', NULL),
	('LOG-2021-IX-00026', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 21:08:59', NULL),
	('LOG-2021-IX-00027', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 21:08:59', NULL),
	('LOG-2021-IX-00028', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Safari 604.1","sistem operasi":"iOS","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 23:38:27', NULL),
	('LOG-2021-IX-00029', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 23:46:24', NULL),
	('LOG-2021-IX-00030', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 23:46:24', NULL),
	('LOG-2021-IX-00031', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 23:57:30', NULL),
	('LOG-2021-IX-00032', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-07 23:57:30', NULL),
	('LOG-2021-IX-00033', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-08 13:49:09', NULL),
	('LOG-2021-IX-00034', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-08 13:49:09', NULL),
	('LOG-2021-IX-00035', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-08 21:12:19', NULL),
	('LOG-2021-IX-00036', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-08 21:12:20', NULL),
	('LOG-2021-IX-00037', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-09 23:20:02', NULL),
	('LOG-2021-IX-00038', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-09 23:20:02', NULL),
	('LOG-2021-IX-00039', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 00:02:37', NULL),
	('LOG-2021-IX-00040', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 00:02:37', NULL),
	('LOG-2021-IX-00041', 10, 10, NULL, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:41:09', NULL),
	('LOG-2021-IX-00042', 10, 10, NULL, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:41:10', NULL),
	('LOG-2021-IX-00043', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 00:42:12', NULL),
	('LOG-2021-IX-00044', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 00:42:13', NULL),
	('LOG-2021-IX-00045', 1, 1, 1, 1, 2, 'role', 'Insert Success', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 00:44:22', NULL),
	('LOG-2021-IX-00046', 10, 10, NULL, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:44:54', NULL),
	('LOG-2021-IX-00047', 10, 10, NULL, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:44:54', NULL),
	('LOG-2021-IX-00048', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:50:51', NULL),
	('LOG-2021-IX-00049', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:50:51', NULL),
	('LOG-2021-IX-00050', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:53:32', NULL),
	('LOG-2021-IX-00051', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 00:53:32', NULL),
	('LOG-2021-IX-00052', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 01:45:04', NULL),
	('LOG-2021-IX-00053', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 01:45:04', NULL),
	('LOG-2021-IX-00054', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 02:45:32', NULL),
	('LOG-2021-IX-00055', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 02:45:33', NULL),
	('LOG-2021-IX-00056', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 02:47:01', NULL),
	('LOG-2021-IX-00057', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 02:47:02', NULL),
	('LOG-2021-IX-00058', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 02:47:25', NULL),
	('LOG-2021-IX-00059', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 02:47:25', NULL),
	('LOG-2021-IX-00060', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 09:04:13', NULL),
	('LOG-2021-IX-00061', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 09:04:13', NULL),
	('LOG-2021-IX-00062', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:03:26', NULL),
	('LOG-2021-IX-00063', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:03:26', NULL),
	('LOG-2021-IX-00064', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:07:10', NULL),
	('LOG-2021-IX-00065', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:07:10', NULL),
	('LOG-2021-IX-00066', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:08:48', NULL),
	('LOG-2021-IX-00067', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:08:48', NULL),
	('LOG-2021-IX-00068', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:09:47', NULL),
	('LOG-2021-IX-00069', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:09:48', NULL),
	('LOG-2021-IX-00070', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:10:11', NULL),
	('LOG-2021-IX-00071', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:12:30', NULL),
	('LOG-2021-IX-00072', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:12:31', NULL),
	('LOG-2021-IX-00073', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:13:30', NULL),
	('LOG-2021-IX-00074', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:13:30', NULL),
	('LOG-2021-IX-00075', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:15:24', NULL),
	('LOG-2021-IX-00076', 10, 10, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-10 11:15:24', NULL),
	('LOG-2021-IX-00077', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 11:15:47', NULL),
	('LOG-2021-IX-00078', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 11:15:47', NULL),
	('LOG-2021-IX-00079', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 13:24:33', NULL),
	('LOG-2021-IX-00080', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 13:24:33', NULL),
	('LOG-2021-IX-00081', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 14:09:40', NULL),
	('LOG-2021-IX-00082', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 14:09:41', NULL),
	('LOG-2021-IX-00083', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 18:52:35', NULL),
	('LOG-2021-IX-00084', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 18:52:36', NULL),
	('LOG-2021-IX-00085', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 19:01:10', NULL),
	('LOG-2021-IX-00086', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 19:01:10', NULL),
	('LOG-2021-IX-00087', 1, 1, 1, 1, 2, 'company', '11', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 19:03:05', NULL),
	('LOG-2021-IX-00088', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 19:59:39', NULL),
	('LOG-2021-IX-00089', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 19:59:39', NULL),
	('LOG-2021-IX-00090', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 20:15:37', NULL),
	('LOG-2021-IX-00091', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 20:15:37', NULL),
	('LOG-2021-IX-00092', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 20:24:23', NULL),
	('LOG-2021-IX-00093', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-10 20:24:23', NULL),
	('LOG-2021-IX-00094', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:49:18', NULL),
	('LOG-2021-IX-00095', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:49:18', NULL),
	('LOG-2021-IX-00096', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:51:53', NULL),
	('LOG-2021-IX-00097', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:53:04', NULL),
	('LOG-2021-IX-00098', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:53:05', NULL),
	('LOG-2021-IX-00099', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:54:31', NULL),
	('LOG-2021-IX-00100', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 15:54:31', NULL),
	('LOG-2021-IX-00101', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:00:04', NULL),
	('LOG-2021-IX-00102', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:00:05', NULL),
	('LOG-2021-IX-00103', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:01:12', NULL),
	('LOG-2021-IX-00104', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:01:12', NULL),
	('LOG-2021-IX-00105', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:02:58', NULL),
	('LOG-2021-IX-00106', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:02:58', NULL),
	('LOG-2021-IX-00107', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:04:26', NULL),
	('LOG-2021-IX-00108', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:04:26', NULL),
	('LOG-2021-IX-00109', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:05:33', NULL),
	('LOG-2021-IX-00110', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:05:33', NULL),
	('LOG-2021-IX-00111', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:12:10', NULL),
	('LOG-2021-IX-00112', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:12:10', NULL),
	('LOG-2021-IX-00113', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:14:48', NULL),
	('LOG-2021-IX-00114', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:14:48', NULL),
	('LOG-2021-IX-00115', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:15:15', NULL),
	('LOG-2021-IX-00116', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:15:15', NULL),
	('LOG-2021-IX-00117', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:21:44', NULL),
	('LOG-2021-IX-00118', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-11 16:21:44', NULL),
	('LOG-2021-IX-00119', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-12 12:09:00', NULL),
	('LOG-2021-IX-00120', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-12 12:09:00', NULL),
	('LOG-2021-IX-00121', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 08:06:37', NULL),
	('LOG-2021-IX-00122', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 08:06:37', NULL),
	('LOG-2021-IX-00123', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 10:34:09', NULL),
	('LOG-2021-IX-00124', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 10:34:10', NULL),
	('LOG-2021-IX-00125', 36, 36, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-13 13:13:27', NULL),
	('LOG-2021-IX-00126', 36, 36, 2, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'ilham', NULL, '2021-09-13 13:13:27', NULL),
	('LOG-2021-IX-00127', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 13:24:18', NULL),
	('LOG-2021-IX-00128', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 13:24:18', NULL),
	('LOG-2021-IX-00129', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 19:35:39', NULL),
	('LOG-2021-IX-00130', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-13 19:35:39', NULL),
	('LOG-2021-IX-00131', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 10:02:25', NULL),
	('LOG-2021-IX-00132', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 10:02:25', NULL),
	('LOG-2021-IX-00133', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 19:15:30', NULL),
	('LOG-2021-IX-00134', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 19:15:31', NULL),
	('LOG-2021-IX-00135', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 21:28:52', NULL),
	('LOG-2021-IX-00136', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-14 21:28:52', NULL),
	('LOG-2021-IX-00137', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-15 10:46:32', NULL),
	('LOG-2021-IX-00138', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.63","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-15 10:46:32', NULL),
	('LOG-2021-IX-00139', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-15 19:03:18', NULL),
	('LOG-2021-IX-00140', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-15 19:03:18', NULL),
	('LOG-2021-IX-00141', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-16 08:56:51', NULL),
	('LOG-2021-IX-00142', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-16 08:56:51', NULL),
	('LOG-2021-IX-00143', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-16 18:14:03', NULL),
	('LOG-2021-IX-00144', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 10:35:22', NULL),
	('LOG-2021-IX-00145', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 10:35:22', NULL),
	('LOG-2021-IX-00146', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 13:36:49', NULL),
	('LOG-2021-IX-00147', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 13:36:49', NULL),
	('LOG-2021-IX-00148', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 18:50:59', NULL),
	('LOG-2021-IX-00149', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-17 18:50:59', NULL),
	('LOG-2021-IX-00150', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-20 09:55:23', NULL),
	('LOG-2021-IX-00151', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-20 09:55:24', NULL),
	('LOG-2021-IX-00152', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-21 09:48:41', NULL),
	('LOG-2021-IX-00153', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-21 09:48:41', NULL),
	('LOG-2021-IX-00154', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-21 20:07:01', NULL),
	('LOG-2021-IX-00155', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-21 20:07:01', NULL),
	('LOG-2021-IX-00156', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-22 10:39:30', NULL),
	('LOG-2021-IX-00157', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-22 10:39:30', NULL),
	('LOG-2021-IX-00158', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-22 11:18:18', NULL),
	('LOG-2021-IX-00159', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-22 19:13:58', NULL),
	('LOG-2021-IX-00160', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-22 19:13:58', NULL),
	('LOG-2021-IX-00161', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 08:09:47', NULL),
	('LOG-2021-IX-00162', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 08:09:47', NULL),
	('LOG-2021-IX-00163', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 08:26:39', NULL),
	('LOG-2021-IX-00164', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 08:44:05', NULL),
	('LOG-2021-IX-00165', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 18:47:00', NULL),
	('LOG-2021-IX-00166', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 18:47:00', NULL),
	('LOG-2021-IX-00167', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-23 22:14:56', NULL),
	('LOG-2021-IX-00168', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 21:04:37', NULL),
	('LOG-2021-IX-00169', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 21:04:37', NULL),
	('LOG-2021-IX-00170', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:08', NULL),
	('LOG-2021-IX-00171', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:08', NULL),
	('LOG-2021-IX-00172', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:09', NULL),
	('LOG-2021-IX-00173', 1, 1, 1, 1, 3, 'company', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:33', NULL),
	('LOG-2021-IX-00174', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:43', NULL),
	('LOG-2021-IX-00175', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-24 22:19:43', NULL),
	('LOG-2021-IX-00176', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-25 17:11:26', NULL),
	('LOG-2021-IX-00177', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-25 17:11:26', NULL),
	('LOG-2021-IX-00178', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-25 17:57:08', NULL),
	('LOG-2021-IX-00179', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-26 10:31:37', NULL),
	('LOG-2021-IX-00180', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-26 10:31:37', NULL),
	('LOG-2021-IX-00181', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-26 10:31:37', NULL),
	('LOG-2021-IX-00182', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-26 10:31:37', NULL),
	('LOG-2021-IX-00183', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-27 09:26:59', NULL),
	('LOG-2021-IX-00184', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-27 09:26:59', NULL),
	('LOG-2021-IX-00185', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-28 10:22:52', NULL),
	('LOG-2021-IX-00186', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-28 10:22:52', NULL),
	('LOG-2021-IX-00187', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-28 20:04:21', NULL),
	('LOG-2021-IX-00188', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-28 20:04:21', NULL),
	('LOG-2021-IX-00189', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 10:16:41', NULL),
	('LOG-2021-IX-00190', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 10:16:41', NULL),
	('LOG-2021-IX-00191', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 13:43:47', NULL),
	('LOG-2021-IX-00192', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 13:43:47', NULL),
	('LOG-2021-IX-00193', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 13:43:51', NULL),
	('LOG-2021-IX-00194', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 19:26:50', NULL),
	('LOG-2021-IX-00195', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 93.0.4577.82","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 19:26:50', NULL),
	('LOG-2021-IX-00196', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 20:13:53', NULL),
	('LOG-2021-IX-00197', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-29 20:13:53', NULL),
	('LOG-2021-IX-00198', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-30 11:05:59', NULL),
	('LOG-2021-IX-00199', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-30 11:05:59', NULL),
	('LOG-2021-IX-00200', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-30 20:31:22', NULL),
	('LOG-2021-IX-00201', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-30 20:31:22', NULL),
	('LOG-2021-IX-00202', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-09-30 22:18:48', NULL),
	('LOG-2021-X-00001', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-01 17:38:53', NULL),
	('LOG-2021-X-00002', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-01 17:38:53', NULL),
	('LOG-2021-X-00003', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-01 22:26:33', NULL),
	('LOG-2021-X-00004', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-01 22:26:33', NULL),
	('LOG-2021-X-00005', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-01 22:26:36', NULL),
	('LOG-2021-X-00006', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-02 17:04:36', NULL),
	('LOG-2021-X-00007', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-02 17:04:36', NULL),
	('LOG-2021-X-00008', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-03 09:48:42', NULL),
	('LOG-2021-X-00009', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-03 09:48:42', NULL),
	('LOG-2021-X-00010', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-03 18:53:45', NULL),
	('LOG-2021-X-00011', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-03 18:53:45', NULL),
	('LOG-2021-X-00012', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-04 10:29:06', NULL),
	('LOG-2021-X-00013', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-04 10:29:06', NULL),
	('LOG-2021-X-00014', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-05 08:47:10', NULL),
	('LOG-2021-X-00015', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.61","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-05 08:47:10', NULL),
	('LOG-2021-X-00016', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-06 09:39:26', NULL),
	('LOG-2021-X-00017', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-06 09:39:26', NULL),
	('LOG-2021-X-00018', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-06 23:30:38', NULL),
	('LOG-2021-X-00019', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-06 23:30:38', NULL),
	('LOG-2021-X-00020', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-07 10:56:55', NULL),
	('LOG-2021-X-00021', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-07 10:56:55', NULL),
	('LOG-2021-X-00022', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-07 20:14:34', NULL),
	('LOG-2021-X-00023', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-07 20:14:34', NULL),
	('LOG-2021-X-00024', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-08 08:02:44', NULL),
	('LOG-2021-X-00025', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-08 08:02:44', NULL),
	('LOG-2021-X-00026', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-08 08:02:45', NULL),
	('LOG-2021-X-00027', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-09 20:05:13', NULL),
	('LOG-2021-X-00028', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-09 20:05:13', NULL),
	('LOG-2021-X-00029', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 10:56:55', NULL),
	('LOG-2021-X-00030', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 15:56:14', NULL),
	('LOG-2021-X-00031', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 15:56:14', NULL),
	('LOG-2021-X-00032', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 22:33:19', NULL),
	('LOG-2021-X-00033', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 22:33:19', NULL),
	('LOG-2021-X-00034', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-10 22:33:23', NULL),
	('LOG-2021-X-00035', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 10:14:50', NULL),
	('LOG-2021-X-00036', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 10:14:50', NULL),
	('LOG-2021-X-00037', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 13:24:45', NULL),
	('LOG-2021-X-00038', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 13:24:52', NULL),
	('LOG-2021-X-00039', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 19:10:28', NULL),
	('LOG-2021-X-00040', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-11 19:10:28', NULL),
	('LOG-2021-X-00041', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 12:23:54', NULL),
	('LOG-2021-X-00042', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 12:23:54', NULL),
	('LOG-2021-X-00043', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 19:58:21', NULL),
	('LOG-2021-X-00044', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 19:58:21', NULL),
	('LOG-2021-X-00045', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 23:14:26', NULL),
	('LOG-2021-X-00046', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-12 23:14:26', NULL),
	('LOG-2021-X-00047', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-13 09:22:56', NULL),
	('LOG-2021-X-00048', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.71","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-13 09:22:56', NULL),
	('LOG-2021-X-00049', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-14 09:05:04', NULL),
	('LOG-2021-X-00050', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-14 09:05:04', NULL),
	('LOG-2021-X-00051', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-14 20:39:52', NULL),
	('LOG-2021-X-00052', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-14 20:39:52', NULL),
	('LOG-2021-X-00053', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 07:24:54', NULL),
	('LOG-2021-X-00054', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 07:24:54', NULL),
	('LOG-2021-X-00055', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 11:17:13', NULL),
	('LOG-2021-X-00056', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 11:17:13', NULL),
	('LOG-2021-X-00057', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 19:28:00', NULL),
	('LOG-2021-X-00058', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-15 19:28:00', NULL),
	('LOG-2021-X-00059', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-16 08:33:47', NULL),
	('LOG-2021-X-00060', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-16 08:33:47', NULL),
	('LOG-2021-X-00061', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-16 20:21:29', NULL),
	('LOG-2021-X-00062', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-16 20:21:29', NULL),
	('LOG-2021-X-00063', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-17 10:29:15', NULL),
	('LOG-2021-X-00064', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-17 10:29:15', NULL),
	('LOG-2021-X-00065', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-17 13:56:37', NULL),
	('LOG-2021-X-00066', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-17 13:56:37', NULL),
	('LOG-2021-X-00067', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 12:18:07', NULL),
	('LOG-2021-X-00068', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 12:18:08', NULL),
	('LOG-2021-X-00069', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 12:35:33', NULL),
	('LOG-2021-X-00070', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 12:35:33', NULL),
	('LOG-2021-X-00071', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 14:20:03', NULL),
	('LOG-2021-X-00072', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 14:20:03', NULL),
	('LOG-2021-X-00073', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 14:20:03', NULL),
	('LOG-2021-X-00074', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 14:20:03', NULL),
	('LOG-2021-X-00075', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-18 17:04:26', NULL),
	('LOG-2021-X-00076', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 09:43:04', NULL),
	('LOG-2021-X-00077', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 09:43:04', NULL),
	('LOG-2021-X-00078', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 20:12:37', NULL),
	('LOG-2021-X-00079', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 20:12:38', NULL),
	('LOG-2021-X-00080', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 22:58:07', NULL),
	('LOG-2021-X-00081', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-19 22:58:07', NULL),
	('LOG-2021-X-00082', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-20 08:33:38', NULL),
	('LOG-2021-X-00083', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-20 08:33:38', NULL),
	('LOG-2021-X-00084', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-20 12:10:08', NULL),
	('LOG-2021-X-00085', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-20 12:10:08', NULL),
	('LOG-2021-X-00086', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-21 09:04:31', NULL),
	('LOG-2021-X-00087', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-21 09:04:31', NULL),
	('LOG-2021-X-00088', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-21 20:11:30', NULL),
	('LOG-2021-X-00089', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-21 20:11:30', NULL),
	('LOG-2021-X-00090', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-23 09:07:44', NULL),
	('LOG-2021-X-00091', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-23 09:07:44', NULL),
	('LOG-2021-X-00092', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 01:35:56', NULL),
	('LOG-2021-X-00093', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 01:35:56', NULL),
	('LOG-2021-X-00094', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 01:35:56', NULL),
	('LOG-2021-X-00095', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 01:35:56', NULL),
	('LOG-2021-X-00096', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 10:45:33', NULL),
	('LOG-2021-X-00097', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 10:45:33', NULL),
	('LOG-2021-X-00098', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 13:19:52', NULL),
	('LOG-2021-X-00099', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-24 13:19:53', NULL),
	('LOG-2021-X-00100', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-25 11:02:52', NULL),
	('LOG-2021-X-00101', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-25 11:02:52', NULL),
	('LOG-2021-X-00102', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-25 21:10:26', NULL),
	('LOG-2021-X-00103', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-25 21:10:26', NULL),
	('LOG-2021-X-00104', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-26 10:01:21', NULL),
	('LOG-2021-X-00105', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-26 10:01:21', NULL),
	('LOG-2021-X-00106', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 09:33:02', NULL),
	('LOG-2021-X-00107', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 09:33:03', NULL),
	('LOG-2021-X-00108', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 17:49:09', NULL),
	('LOG-2021-X-00109', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 17:49:09', NULL),
	('LOG-2021-X-00110', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 23:25:56', NULL),
	('LOG-2021-X-00111', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-27 23:25:56', NULL),
	('LOG-2021-X-00112', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-28 09:09:34', NULL),
	('LOG-2021-X-00113', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 94.0.4606.81","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-28 09:09:34', NULL),
	('LOG-2021-X-00114', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-28 22:20:30', NULL),
	('LOG-2021-X-00115', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-28 22:20:31', NULL),
	('LOG-2021-X-00116', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 07:12:00', NULL),
	('LOG-2021-X-00117', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 07:12:00', NULL),
	('LOG-2021-X-00118', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 10:52:52', NULL),
	('LOG-2021-X-00119', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 10:52:52', NULL),
	('LOG-2021-X-00120', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 19:02:27', NULL),
	('LOG-2021-X-00121', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-29 19:02:28', NULL),
	('LOG-2021-X-00122', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-30 11:36:57', NULL),
	('LOG-2021-X-00123', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-30 11:36:57', NULL),
	('LOG-2021-X-00124', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-30 19:18:03', NULL),
	('LOG-2021-X-00125', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-30 19:18:03', NULL),
	('LOG-2021-X-00126', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-31 07:55:47', NULL),
	('LOG-2021-X-00127', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-31 07:55:47', NULL),
	('LOG-2021-X-00128', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-31 12:48:36', NULL),
	('LOG-2021-X-00129', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-31 12:48:36', NULL),
	('LOG-2021-X-00130', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-10-31 17:56:20', NULL),
	('LOG-2021-XI-00001', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-01 09:21:27', NULL),
	('LOG-2021-XI-00002', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-01 09:21:28', NULL),
	('LOG-2021-XI-00003', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-01 13:23:17', NULL),
	('LOG-2021-XI-00004', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-01 13:23:33', NULL),
	('LOG-2021-XI-00005', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-02 10:21:26', NULL),
	('LOG-2021-XI-00006', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-02 10:21:26', NULL),
	('LOG-2021-XI-00007', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-02 14:24:01', NULL),
	('LOG-2021-XI-00008', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 07:04:45', NULL),
	('LOG-2021-XI-00009', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 07:04:45', NULL),
	('LOG-2021-XI-00010', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 09:07:32', NULL),
	('LOG-2021-XI-00011', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.54","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 09:07:32', NULL),
	('LOG-2021-XI-00012', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 20:49:32', NULL),
	('LOG-2021-XI-00013', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 20:49:33', NULL),
	('LOG-2021-XI-00014', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 22:47:45', NULL),
	('LOG-2021-XI-00015', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-03 22:47:45', NULL),
	('LOG-2021-XI-00016', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-04 10:24:47', NULL),
	('LOG-2021-XI-00017', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-04 10:24:47', NULL),
	('LOG-2021-XI-00018', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-04 10:42:33', NULL),
	('LOG-2021-XI-00019', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-05 15:10:09', NULL),
	('LOG-2021-XI-00020', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-05 15:10:09', NULL),
	('LOG-2021-XI-00021', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-06 09:32:43', NULL),
	('LOG-2021-XI-00022', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-06 09:32:43', NULL),
	('LOG-2021-XI-00023', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-08 09:59:45', NULL),
	('LOG-2021-XI-00024', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-08 09:59:45', NULL),
	('LOG-2021-XI-00025', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-08 16:17:28', NULL),
	('LOG-2021-XI-00026', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 09:55:48', NULL),
	('LOG-2021-XI-00027', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 09:55:48', NULL),
	('LOG-2021-XI-00028', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 16:24:33', NULL),
	('LOG-2021-XI-00029', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 16:28:28', NULL),
	('LOG-2021-XI-00030', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 19:54:05', NULL),
	('LOG-2021-XI-00031', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 19:54:06', NULL),
	('LOG-2021-XI-00032', 1, 1, 1, 1, 3, 'role', '1', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-09 20:01:34', NULL),
	('LOG-2021-XI-00033', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-10 07:31:24', NULL),
	('LOG-2021-XI-00034', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-10 07:31:24', NULL),
	('LOG-2021-XI-00035', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-11 14:48:20', NULL),
	('LOG-2021-XI-00036', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-11 14:48:20', NULL),
	('LOG-2021-XI-00037', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 01:31:14', NULL),
	('LOG-2021-XI-00038', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 01:31:14', NULL),
	('LOG-2021-XI-00039', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 16:18:18', NULL),
	('LOG-2021-XI-00040', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 16:18:18', NULL),
	('LOG-2021-XI-00041', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 22:19:17', NULL),
	('LOG-2021-XI-00042', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-12 22:19:17', NULL),
	('LOG-2021-XI-00043', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 09:02:08', NULL),
	('LOG-2021-XI-00044', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 09:02:08', NULL),
	('LOG-2021-XI-00045', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 13:33:13', NULL),
	('LOG-2021-XI-00046', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 13:33:13', NULL),
	('LOG-2021-XI-00047', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 20:11:54', NULL),
	('LOG-2021-XI-00048', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 20:11:54', NULL),
	('LOG-2021-XI-00049', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 23:56:17', NULL),
	('LOG-2021-XI-00050', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-14 23:56:17', NULL),
	('LOG-2021-XI-00051', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-15 10:14:20', NULL),
	('LOG-2021-XI-00052', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-15 10:14:20', NULL),
	('LOG-2021-XI-00053', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-15 19:36:50', NULL),
	('LOG-2021-XI-00054', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-15 19:36:50', NULL),
	('LOG-2021-XI-00055', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-16 09:31:12', NULL),
	('LOG-2021-XI-00056', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-16 09:31:12', NULL),
	('LOG-2021-XI-00057', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-16 15:07:34', NULL),
	('LOG-2021-XI-00058', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-16 15:07:34', NULL),
	('LOG-2021-XI-00059', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-17 00:03:08', NULL),
	('LOG-2021-XI-00060', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-17 00:03:08', NULL),
	('LOG-2021-XI-00061', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-17 10:23:49', NULL),
	('LOG-2021-XI-00062', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-17 10:23:49', NULL),
	('LOG-2021-XI-00063', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 12:52:05', NULL),
	('LOG-2021-XI-00064', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 12:52:05', NULL),
	('LOG-2021-XI-00065', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 18:34:36', NULL),
	('LOG-2021-XI-00066', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 18:34:36', NULL),
	('LOG-2021-XI-00067', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 22:49:57', NULL),
	('LOG-2021-XI-00068', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-18 22:49:57', NULL),
	('LOG-2021-XI-00069', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-19 08:13:18', NULL),
	('LOG-2021-XI-00070', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-19 08:13:18', NULL),
	('LOG-2021-XI-00071', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-19 13:52:38', NULL),
	('LOG-2021-XI-00072', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-19 13:52:38', NULL),
	('LOG-2021-XI-00073', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-21 13:10:50', NULL),
	('LOG-2021-XI-00074', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-21 13:10:50', NULL),
	('LOG-2021-XI-00075', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-23 09:47:18', NULL),
	('LOG-2021-XI-00076', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-23 09:47:18', NULL),
	('LOG-2021-XI-00077', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-23 21:50:12', NULL),
	('LOG-2021-XI-00078', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 95.0.4638.69","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-11-23 21:50:12', NULL),
	('LOG-2021-XII-00001', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 96.0.4664.45","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-12-06 10:05:38', NULL),
	('LOG-2021-XII-00002', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 96.0.4664.45","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-12-06 10:05:38', NULL),
	('LOG-2021-XII-00003', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 96.0.4664.45","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-12-06 20:45:55', NULL),
	('LOG-2021-XII-00004', 1, 1, 1, 1, 1, 'login', '', '{"browser":"Chrome 96.0.4664.45","sistem operasi":"Windows 10","IP":"::1"}', 1, 'Admin', NULL, '2021-12-06 20:45:55', NULL);
/*!40000 ALTER TABLE `ut_log` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_menu
CREATE TABLE IF NOT EXISTS `ut_menu` (
  `MenuID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `Url` varchar(50) DEFAULT NULL,
  `Root` varchar(50) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `Role` int(11) DEFAULT '0' COMMENT '1 = active role',
  `Icon` varchar(50) DEFAULT NULL,
  `Index` int(11) DEFAULT NULL,
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`MenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_menu: ~131 rows (approximately)
/*!40000 ALTER TABLE `ut_menu` DISABLE KEYS */;
INSERT IGNORE INTO `ut_menu` (`MenuID`, `Name`, `Url`, `Root`, `Type`, `Level`, `ParentID`, `Role`, `Icon`, `Index`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	(1, 'Menu', 'menu', 'menu/index', '["backend"]', 2, 9, 1, 'fa fa-list-ul', 22, 'Development', 'Admin', '2019-09-16 23:42:00', '2021-11-04 10:42:51'),
	(3, 'Menu Save', 'menu-save', 'menu/save', '[]', 3, 1, 0, '', NULL, 'Development', 'Development', '2019-09-17 22:12:08', '2019-09-22 11:45:49'),
	(4, 'Menu List', 'menu-list', 'menu/list', '[]', 3, 1, 0, '', NULL, 'Development', 'Development', '2019-09-17 22:14:41', '2019-09-22 11:46:06'),
	(5, 'Menu Delete', 'menu-delete', 'menu/delete', '[]', 3, 1, 0, '', NULL, 'Development', 'Development', '2019-09-17 22:15:30', '2019-09-22 11:46:18'),
	(6, 'Role', 'role', 'Role', '["backend"]', 2, 12, 1, 'fa fa-cogs', 20, 'Development', 'Admin', '2019-09-17 23:02:41', '2021-11-04 10:42:51'),
	(8, 'Menu Edit', 'menu-edit', 'Menu/edit', '[]', 3, 1, 0, '', NULL, 'Development', 'Development', '2019-09-18 20:52:02', '2019-09-22 11:46:33'),
	(9, 'Utilities', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-cog', 21, 'Development', 'Admin', '2019-09-22 11:44:15', '2021-11-04 10:42:51'),
	(10, 'Users', 'users', 'Users', '["backend"]', 2, 12, 1, 'fa fa-user-circle-o', 19, 'Development', 'Admin', '2019-09-22 11:56:34', '2021-11-04 10:42:51'),
	(12, 'Settings ', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-th-list', 17, 'Development', 'Admin', '2019-09-22 13:23:18', '2021-11-04 10:42:51'),
	(13, 'Company List', 'company-list', 'Users/list', '[]', 3, 10, NULL, '', NULL, 'Development', 'Development', '2019-09-24 23:35:00', '2019-11-03 19:03:12'),
	(14, 'Company Edit', 'company-edit', 'Users/edit', '[]', 3, 10, NULL, '', NULL, 'Development', 'Development', '2019-09-24 23:35:39', '2019-11-02 22:02:39'),
	(15, 'Company Active', 'company-active', 'Users/active', '[]', 3, 10, NULL, '', NULL, 'Development', 'Development', '2019-09-24 23:36:19', '2019-11-02 22:02:24'),
	(16, 'Company Save', 'company-save', 'Users/save', '["backend"]', 3, 10, NULL, '', NULL, 'Development', 'Development', '2019-09-26 20:14:36', '2019-11-02 22:03:23'),
	(17, 'Role List', 'role-list', 'Role/list', '[]', 3, 6, NULL, '', NULL, 'Development', NULL, '2019-09-29 14:18:35', NULL),
	(19, 'Role Save', 'role-save', 'Role/save', '["backend"]', 3, 6, NULL, '', NULL, 'Development', NULL, '2019-10-07 22:36:52', NULL),
	(20, 'Role Edit', 'role-edit', 'Role/edit', '["backend"]', 3, 6, NULL, '', NULL, 'Development', NULL, '2019-10-07 22:51:16', NULL),
	(21, 'Role Active', 'role-active', 'Role/active', '["backend"]', 3, 6, NULL, '', NULL, 'Development', NULL, '2019-10-07 23:08:28', NULL),
	(22, 'Logout', 'logout', 'Main/logout', '[]', 1, NULL, NULL, '', NULL, 'Development', NULL, '2019-10-08 21:03:28', NULL),
	(48, 'Settings', '', '', '[]', 1, NULL, 1, 'fa fa-asterisk', NULL, 'Development', 'Development', '2019-11-16 16:54:17', '2020-04-08 13:48:18'),
	(49, 'Company Profile', 'company-profile', 'Users/company_profile', '["backend"]', 2, 12, 1, 'fa fa-home', 18, 'Development', 'Admin', '2019-11-16 16:56:18', '2021-11-04 10:42:51'),
	(50, 'Company Profile Edit', 'company-profile-edit', 'Users/company_edit', '["backend"]', 3, 49, NULL, '', NULL, 'Development', NULL, '2019-11-17 15:01:44', NULL),
	(51, 'Company Edit save', 'company-edit-save', 'Users/company_save', '[]', 3, 49, NULL, '', NULL, 'Development', NULL, '2019-11-17 16:18:07', NULL),
	(78, 'Menu Shorting', 'menu-shorting', 'main/menu_shorting', '["backend"]', 2, 9, NULL, 'fa fa-list-ol', 23, 'Development', 'Admin', '2019-12-18 22:08:36', '2021-11-04 10:42:51'),
	(93, 'Menu Shorting Save', 'menu-shorting-save', 'Main/menu_shorting_save', '[]', 3, 78, NULL, '', NULL, 'Development', NULL, '2019-12-21 05:44:36', NULL),
	(96, 'Forgot Password', 'reset-password', 'main/forgot_password', '[]', 1, NULL, NULL, '', NULL, 'Development', NULL, '2019-12-26 23:37:57', NULL),
	(98, 'Page Settings', 'page-settings/(:any)', 'main/general_setting/$1', '["backend"]', 3, 102, 1, '', NULL, 'Development', 'Development', '2019-12-27 19:31:02', '2019-12-30 20:00:02'),
	(100, 'Policy Page Setting', 'page-settings/policy-page-settings', 'x', '[]', 3, 98, NULL, '', NULL, 'Development', 'Development', '2019-12-30 18:38:09', '2019-12-30 19:49:55'),
	(101, 'Term & Condition', 'page-settings/term-and-condition', 'x', '[]', 3, 98, NULL, '', NULL, 'Development', 'Development', '2019-12-30 18:39:04', '2019-12-30 19:26:41'),
	(102, 'Page Setting', 'page-settings/general', 'x', '["backend"]', 2, 9, 1, 'fa fa-wrench', 24, 'Development', 'Admin', '2019-12-30 19:01:09', '2021-11-04 10:42:51'),
	(132, 'Login', 'login', 'Main/login', '[]', 1, NULL, NULL, '', NULL, 'Development', NULL, '2020-05-14 14:25:24', NULL),
	(133, 'Log Info', 'log-info', 'Api/log_info', '[]', 3, 49, NULL, '', NULL, 'Development', NULL, '2020-05-14 14:55:56', NULL),
	(134, 'DASHBOARD', 'dashboard', 'main/Dashboard', '["backend"]', 1, NULL, NULL, 'ti-layout-grid2', 0, 'Development', 'Admin', '2021-08-31 09:13:32', '2021-11-04 10:42:51'),
	(135, 'Dashboard List', 'dashboard-list', 'Dashboard/list', '[]', 2, 134, NULL, '', NULL, 'Development', NULL, '2021-08-31 09:14:32', NULL),
	(136, 'Dashboard List Detail', 'dashboard-list-detail', 'Dashboard/Detail', '[]', 2, 134, NULL, '', NULL, 'Development', NULL, '2021-08-31 09:17:23', NULL),
	(137, 'MASTER DATA CV', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-file-o', 1, 'Development', 'Admin', '2021-09-01 12:32:10', '2021-11-04 10:42:51'),
	(138, 'Non Konstruksi', 'non_konstruksi', 'Non_konstruksi', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 5, 'Development', 'Admin', '2021-09-01 12:33:46', '2021-11-04 10:42:51'),
	(139, 'Non Konstruksi List', 'non_konstruksi-list', 'Non_konstruksi/list', '[]', 3, 138, NULL, '', NULL, 'Development', NULL, '2021-09-01 12:35:32', NULL),
	(140, 'Non Konstruksi Active', 'non_konstruksi-active', 'Non_konstruksi/active', '[]', 3, 138, NULL, '', NULL, 'Development', NULL, '2021-09-01 12:37:04', NULL),
	(141, 'Non Konstruksi Save', 'non_konstruksi-save', 'Non_konstruksi/save', '[]', 3, 138, NULL, '', NULL, 'Development', NULL, '2021-09-01 12:37:39', NULL),
	(142, 'Non Konstruksi Edit', 'non_konstruksi-edit', 'Non_konstruksi/edit', '[]', 3, 138, NULL, '', NULL, 'Development', NULL, '2021-09-01 12:38:41', NULL),
	(143, 'Konstruksi', 'konstruksi', 'Konstruksi', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 4, 'Development', 'Admin', '2021-09-04 03:34:55', '2021-11-04 10:42:51'),
	(144, 'Konstruksi List', 'konstruksi-list', 'Konstruksi/list', '[]', 3, 143, NULL, '', NULL, 'Development', NULL, '2021-09-04 03:35:50', NULL),
	(145, 'Konstruksi Active', 'konstruksi-active', 'Konstruksi/active', '[]', 3, 143, NULL, '', NULL, 'Development', NULL, '2021-09-04 03:36:22', NULL),
	(146, 'Konstruksi Save', 'konstruksi-save', 'Konstruksi/save', '[]', 3, 143, NULL, '', NULL, 'Development', NULL, '2021-09-04 03:36:54', NULL),
	(147, 'Konstruksi Edit', 'konstruksi-edit', 'Konstruksi/edit', '[]', 3, 143, NULL, '', NULL, 'Development', NULL, '2021-09-04 03:37:21', NULL),
	(148, 'SDM Pegawai Non PT.Ciriajasa EC.', 'sdm_pegawai', 'Sdm_pegawai', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 7, 'Development', 'Admin', '2021-09-04 17:07:18', '2021-11-04 10:42:51'),
	(149, 'SDM Pegawai Non PT.Ciriajasa EC-List', 'sdm_pegawai-list', 'Sdm_pegawai/list', '[]', 3, 148, NULL, '', NULL, 'Development', NULL, '2021-09-04 17:08:23', NULL),
	(150, 'SDM Pegawai Non PT.Ciriajasa EC Active', 'sdm_pegawai-active', 'Sdm_pegawai/active', '[]', 3, 148, NULL, '', NULL, 'Development', NULL, '2021-09-04 17:09:06', NULL),
	(151, 'SDM Pegawai Non PT.Ciriajasa EC Save', 'sdm_pegawai-save', 'Sdm_pegawai/save', '[]', 3, 148, NULL, '', NULL, 'Development', NULL, '2021-09-04 17:09:41', NULL),
	(152, 'SDM Pegawai Non PT.Ciriajasa EC. Edit', 'sdm_pegawai-edit', 'Sdm_pegawai/edit', '[]', 3, 148, NULL, '', NULL, 'Development', NULL, '2021-09-04 17:10:22', NULL),
	(153, 'Biodata Tenaga Ahli', 'pendidikan', 'Pendidikan', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 2, 'Development', 'Admin', '2021-09-04 18:14:41', '2021-11-04 10:42:51'),
	(154, 'Master Pendidikan List', 'pendidikan-list', 'Pendidikan/list', '[]', 3, 153, NULL, '', NULL, 'Development', NULL, '2021-09-04 18:15:35', NULL),
	(155, 'Master Pendidikan Active', 'pendidikan-active', 'Pendidikan/active', '[]', 3, 153, NULL, '', NULL, 'Development', NULL, '2021-09-04 18:16:09', NULL),
	(156, 'Master Pendidikan Save', 'pendidikan-save', 'Pendidikan/save', '[]', 3, 153, NULL, '', NULL, 'Development', 'Admin', '2021-09-04 18:16:40', '2021-10-07 17:20:51'),
	(157, 'Master Pendidikan Edit', 'pendidikan-edit', 'Pendidikan/edit', '[]', 3, 153, NULL, '', NULL, 'Development', NULL, '2021-09-04 18:17:10', NULL),
	(158, 'Verification User', 'verification-user', 'main/verification', '[]', 1, NULL, NULL, '', NULL, 'Admin', 'Admin', '2021-09-10 00:08:15', '2021-09-10 20:16:04'),
	(159, 'Konstruksi Export', 'konstruksi-export', 'Konstruksi/export', '[]', 3, 143, NULL, '', NULL, 'Admin', NULL, '2021-09-14 23:05:44', NULL),
	(160, 'Non Konstruksi Export', 'non_konstruksi-export', 'Non_konstruksi/export', '[]', 3, 138, NULL, '', NULL, 'Admin', 'Admin', '2021-09-16 12:35:19', '2021-09-16 12:52:41'),
	(161, 'Pengalaman Kerja ', 'pengalaman', 'Pengalaman_kerja', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 3, 'Admin', 'Admin', '2021-09-16 18:09:35', '2021-11-04 10:42:51'),
	(162, 'Pengalaman Kerja Active', 'pengalman-active', 'Pengalaman_kerja/active', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-16 18:10:49', NULL),
	(163, 'Pengalaman Kerja Edit', 'pengalaman-edit', 'Pengalaman_kerja/edit', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-16 18:12:39', NULL),
	(164, 'Pengalaman Kerja Export', 'pengalaman-export', 'Pengalaman_kerja/export', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-16 18:13:14', NULL),
	(165, 'Pengalaman Kerja Save', 'pengalaman-save', 'Pengalaman_kerja/save', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-16 18:13:39', NULL),
	(166, 'Pengalaman Kerja List', 'pengalaman-list', 'Pengalaman_kerja/list', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-16 18:38:53', NULL),
	(167, 'OUTPUT', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-file-text-o', 8, 'Admin', 'Admin', '2021-09-22 11:12:24', '2021-11-04 10:42:51'),
	(168, 'CV', 'output_cv', 'Output_cv', '["backend"]', 2, 167, NULL, 'fa fa-circle-o', 11, 'Admin', 'Admin', '2021-09-22 11:14:10', '2021-11-04 10:42:51'),
	(169, 'CV Active', 'output_cv-active', 'Output_cv/active', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-09-22 11:15:45', NULL),
	(170, 'CV Edit', 'output_cv-edit', 'Output_cv/edit', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-09-22 11:16:23', NULL),
	(171, 'CV Export', 'output_cv-export', 'Output_cv/export', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-09-22 11:16:55', NULL),
	(172, 'CV List', 'output_cv-list', 'Output_cv/list', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-09-22 11:17:24', NULL),
	(173, 'CV Save', 'output_cv-save', 'Output_cv/save', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-09-22 11:17:57', NULL),
	(174, 'UPLOAD ARSIP', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-file-text-o', 13, 'Admin', 'Admin', '2021-09-23 08:37:22', '2021-11-04 10:42:51'),
	(175, 'ARSIP TENDER', 'upload_cv', 'Upload_cv', '["backend"]', 2, 174, NULL, 'fa fa-circle-o', 14, 'Admin', 'Admin', '2021-09-23 08:39:28', '2021-11-04 10:42:51'),
	(176, 'PROYEK Active', 'upload_cv-active', 'Upload_cv/active', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-09-23 08:41:00', NULL),
	(177, 'Proyek Edit', 'upload_cv-edit', 'Upload_cv/edit', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-09-23 08:41:40', NULL),
	(178, 'Proyek Export', 'upload_cv-export', 'Upload_cv/export', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-09-23 08:42:25', NULL),
	(179, 'Proyek List', 'upload_cv-list', 'Upload_cv/list', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-09-23 08:43:03', NULL),
	(180, 'PROYEK Save', 'upload_cv-save', 'Upload_cv/save', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-09-23 08:43:44', NULL),
	(181, 'DATABASE', '', '', '["backend"]', 1, NULL, NULL, 'fa fa-database', 15, 'Admin', 'Admin', '2021-09-23 22:10:49', '2021-11-04 10:42:51'),
	(185, 'Pengalaman Kerja Import', 'pengalaman-save-import', 'Pengalaman_kerja/save_import', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-09-29 16:11:52', NULL),
	(186, 'SDM Pegawai PT.Ciriajasa EC.', 'sdm_pegawai_ciriajasa', 'Sdm_pegawai_ciriajasa', '["backend"]', 2, 137, NULL, 'fa fa-circle-o', 6, 'Admin', 'Admin', '2021-09-30 22:13:38', '2021-11-04 10:42:51'),
	(187, 'SDM Pegawai PT.Ciriajasa EC Active', 'sdm_pegawai_ciriajasa-active', 'Sdm_pegawai_ciriajasa/active', '[]', 3, 186, NULL, '', NULL, 'Admin', NULL, '2021-09-30 22:15:10', NULL),
	(188, 'SDM Pegawai PT.Ciriajasa EC Save', 'sdm_pegawai_ciriajasa-save', 'Sdm_pegawai_ciriajasa/save', '[]', 3, 186, NULL, '', NULL, 'Admin', NULL, '2021-09-30 22:15:57', NULL),
	(189, 'SDM Pegawai PT.Ciriajasa EC-List', 'sdm_pegawai_ciriajasa-list', 'Sdm_pegawai_ciriajasa/list', '[]', 3, 186, NULL, '', NULL, 'Admin', NULL, '2021-09-30 22:16:42', NULL),
	(190, 'SDM Pegawai PT.Ciriajasa EC.', 'sdm_pegawai_ciriajasa', 'Sdm_pegawai_ciriajasa', '[]', 3, 186, NULL, '', NULL, 'Admin', NULL, '2021-09-30 22:17:34', NULL),
	(191, 'SDM Pegawai PT.Ciriajasa EC. Edit', 'sdm_pegawai_ciriajasa-edit', 'Sdm_pegawai_ciriajasa/edit', '[]', 3, 186, NULL, '', NULL, 'Admin', NULL, '2021-09-30 22:18:30', NULL),
	(192, 'Pengalaman Kerja Save Uraian', 'pengalaman-save-uraian', 'Pengalaman_kerja/save_uraian', '[]', 3, 161, NULL, '', NULL, 'Admin', NULL, '2021-10-06 11:31:19', NULL),
	(193, 'Pengalaman Kerja Template import', 'pengalaman-template', 'Pengalaman_kerja/template_import', '[]', 3, 161, NULL, '', NULL, 'Admin', 'Admin', '2021-10-10 22:39:11', '2021-10-11 13:19:28'),
	(194, 'Konstruksi Export Word', 'konstruksi-export_word', 'Konstruksi/export_word', '[]', 3, 143, NULL, '', NULL, 'Admin', NULL, '2021-10-15 19:46:59', NULL),
	(195, 'Non Konstruksi Export Word', 'non_konstruksi-export_word', 'Non_konstruksi/export_word', '[]', 3, 138, NULL, '', NULL, 'Admin', NULL, '2021-10-17 14:28:17', NULL),
	(196, 'Save Attachment', 'save-attachment', 'Attachment/save_new_attachment', '[]', 1, NULL, NULL, '', NULL, 'Luna - RC Electronic', 'Admin', '2021-10-18 01:10:50', '2021-10-18 12:19:39'),
	(197, 'Show Attachment Frame', 'show-attachment', 'Main/frame', '[]', 1, NULL, NULL, '', NULL, 'Admin', NULL, '2021-10-18 12:19:17', NULL),
	(199, 'ARSIP TENDER', 'output_proyek', 'Output_proyek', '["backend"]', 2, 167, NULL, 'fa fa-circle-o', 12, 'Admin', 'Admin', '2021-10-18 17:04:07', '2021-11-04 10:42:51'),
	(200, 'PROYEK OUTPUT ACTIVE', 'output_proyek-active', 'Output_proyek/active', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-10-18 17:09:14', NULL),
	(201, 'PROYEK OUTPUT EDIT', 'output_proyek-edit', 'Output_proyek/edit', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-10-18 17:09:54', NULL),
	(202, 'PROYEK OUTPUT EXPORT', 'output_proyek-export', 'Output_proyek/export', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-10-18 17:10:34', NULL),
	(203, 'PROYEK OUTPUT LIST', 'output_proyek-list', 'Output_proyek/list', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-10-18 17:11:15', NULL),
	(204, 'PROYEK OUTPUT SAVE', 'output_proyek-save', 'Output_proyek/save', '[]', 3, 175, NULL, '', NULL, 'Admin', NULL, '2021-10-18 17:11:59', NULL),
	(205, 'Pengalaman Kerja Template import2', 'posisi-template', 'Posisi_uraian/template_import', '[]', 3, 161, NULL, '', NULL, 'Admin', 'Admin', '2021-10-21 22:03:11', '2021-10-21 22:56:53'),
	(206, 'Pengalaman Kerja Import2', 'posisi-save-import', 'Posisi_uraian/save_import', '[]', 3, 161, NULL, '', NULL, 'Admin', 'Admin', '2021-10-21 22:32:47', '2021-10-21 22:55:44'),
	(207, 'CV List Non Konstruksi', 'output_cv-list_non_konstruksi', 'Output_cv/list_non_konstruksi', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-10-26 15:14:55', NULL),
	(208, 'CV Edit2', 'output_cv-edit_non_konstruksi', 'Output_cv/edit2', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-10-26 16:29:53', NULL),
	(209, 'CV Update konstruksi', 'output_cv-update-konstruksi', 'Output_cv/update_konstruksi', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-10-27 11:11:29', NULL),
	(210, 'CV Update Non Konstruksi', 'output_cv-update-non_konstruksi', 'Output_cv/update_non_konstruksi', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-10-27 11:13:40', NULL),
	(215, 'PENGALAMAN KERJA ', 'output_pengalaman', 'Output_pengalaman', '["backend"]', 2, 167, NULL, 'fa fa-circle-o', 10, 'Admin', 'Admin', '2021-11-02 14:18:14', '2021-11-04 10:42:51'),
	(216, 'PENGALAMAN KERJA LIST', 'output_pengalaman-list', 'Output_pengalaman/list', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-02 14:20:22', NULL),
	(217, 'PENGALAMAN KERJA ACTIVE', 'output_pengalaman-active', 'Output_pengalaman/active', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-02 14:21:27', NULL),
	(218, 'PENGALAMAN KERJA EDIT', 'output_pengalaman-edit', 'Output_pengalaman/edit', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-02 14:22:16', NULL),
	(219, 'PENGALAMAN KERJA SAVE', 'output_pengalaman-save', 'Output_pengalaman/save', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-02 14:22:57', NULL),
	(220, 'PENGALAMAN KERJA SAVE URAIAN', 'output_pengalaman-save-uraian', 'Output_pengalaman/save_uraian', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-03 09:23:28', NULL),
	(222, 'PENGALAMAN KERJA LIST URAIAN', 'output_pengalaman-list_uraian', 'Output_pengalaman/list_uraian', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-03 14:37:20', NULL),
	(223, 'PENGALAMAN KERJA EDIT URAIAN', 'output_pengalaman-edit_uraian', 'Output_pengalaman/edit2', '[]', 3, 215, NULL, '', NULL, 'Admin', NULL, '2021-11-03 15:29:30', NULL),
	(224, 'BIODATA TENAGA AHLI', 'output_pendidikan', 'Output_pendidikan', '["backend"]', 2, 167, NULL, 'fa fa-circle-o', 9, 'Admin', 'Admin', '2021-11-04 10:37:22', '2021-11-04 10:42:51'),
	(225, 'BIODATA TENAGA AHLI EDIT', 'output_pendidikan-edit', 'Output_pendidikan/edit', '[]', 3, 224, NULL, '', NULL, 'Admin', NULL, '2021-11-04 10:38:50', NULL),
	(226, 'BIODATA TENAGA AHLI SAVE', 'output_pendidikan-save', 'Output_pendidikan/save', '[]', 3, 224, NULL, '', NULL, 'Admin', NULL, '2021-11-04 10:39:45', NULL),
	(227, 'BIODATA TENAGA AHLI ACTIVE', 'output_pendidikan-active', 'Output_pendidikan/active', '[]', 3, 224, NULL, '', NULL, 'Admin', NULL, '2021-11-04 10:40:35', NULL),
	(228, 'BIODATA TENGA AHLI LIST', 'output_pendidikan-list', 'Output_pendidikan/list', '[]', 3, 224, NULL, '', NULL, 'Admin', NULL, '2021-11-04 10:42:18', NULL),
	(232, 'UPLOAD DATABASE DAFTAR RIWAYAT', 'database_riwayat', 'Database_riwayat', '["backend"]', 2, 181, NULL, 'fa fa-circle-o', NULL, 'Admin', 'Admin', '2021-11-08 16:05:59', '2021-11-09 16:18:54'),
	(233, 'UPLOAD DATABASE RIWAYAT SAVE', 'database_riwayat-save', 'Database_riwayat/save', '[]', 3, 232, NULL, '', NULL, 'Admin', 'Admin', '2021-11-08 16:08:46', '2021-11-08 16:13:35'),
	(234, 'UPLOAD DATABASE RIWAYAT LIST', 'database_riwayat-list', 'Database_riwayat/list', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2021-11-08 16:12:58', NULL),
	(235, 'UPLOAD DATABASE RIWAYAT ACTIVE', 'database_riwayat-active', 'Database_riwayat/active', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2021-11-08 16:14:47', NULL),
	(236, 'UPLOAD DATABASE RIWAYAT EXPORT', 'database_riwayat-export', 'Database_riwayat/export', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2021-11-08 16:15:38', NULL),
	(237, 'UPLOAD DATABASE RIWAYAT SAVE IMPORT', 'database_riwayat-save-import', 'Database_riwayat/save_import', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2021-11-08 16:17:09', NULL),
	(238, 'UPLOAD DATABASE RIWAYAT TEMPLATE', 'database_riwayat-template', 'Database_riwayat/template_import', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2021-11-08 16:25:41', NULL),
	(253, 'Dashboard List SDM PT', 'dashboard-list-sdm-pt', 'Dashboard/list_sdm', '[]', 2, 134, NULL, '', NULL, 'Admin', NULL, '2021-11-12 01:40:32', NULL),
	(254, 'Dashboard Save SDM', 'dashboard-save_sdm', 'Dashboard/save_sdm', '[]', 2, 134, NULL, '', NULL, 'Admin', NULL, '2021-11-12 03:52:44', NULL),
	(255, 'Dashboard List SDM NON PT', 'dashboard-list-sdm-non', 'Dashboard/list_non', '[]', 2, 134, NULL, '', NULL, 'Admin', NULL, '2021-11-12 04:14:36', NULL),
	(256, 'Dashboard Save SDM NON PT', 'dashboard-save_sdm_non', 'Dashboard/save_sdm_non', '[]', 2, 134, NULL, '', NULL, 'Admin', NULL, '2021-11-12 05:06:34', NULL),
	(257, 'CV Export word Konstruksi', 'output_cv-export_konstruksi', 'Output_cv/export_word_konstruksi', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-11-12 16:41:43', NULL),
	(258, 'CV Export word Non Konstruksi', 'output_cv-export_non_konstruksi', 'Output_cv/export_word_non_konstruksi', '[]', 3, 168, NULL, '', NULL, 'Admin', NULL, '2021-11-12 16:41:45', NULL),
	(259, 'UPLOAD DATABASE RIWAYAT SAVE IMPORT2', 'database_riwayat-save-import2', 'Database_riwayat/save_import2', '[]', 3, 232, NULL, '', NULL, 'Admin', NULL, '2022-10-14 13:24:02', NULL);
/*!40000 ALTER TABLE `ut_menu` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_role
CREATE TABLE IF NOT EXISTS `ut_role` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `View` text,
  `Insert` text,
  `Update` text,
  `Delete` text,
  `Approve` text,
  `Type` int(11) DEFAULT NULL COMMENT '1 =Developer, 2  = Super Admin, 3  = Company ',
  `Status` int(11) DEFAULT NULL,
  `Remark` varchar(50) DEFAULT NULL,
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_role: ~2 rows (approximately)
/*!40000 ALTER TABLE `ut_role` DISABLE KEYS */;
INSERT IGNORE INTO `ut_role` (`RoleID`, `CompanyID`, `UserID`, `Name`, `Level`, `View`, `Insert`, `Update`, `Delete`, `Approve`, `Type`, `Status`, `Remark`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	(1, NULL, NULL, 'Development', NULL, '["153","161","143","138","186","148","224","215","168","199","175","232","240","49","10","6","1","78","102"]', '["153","161","143","138","186","148","224","215","168","199","175","232","240","49","10","6","1","78","102"]', '["153","161","143","138","186","148","224","215","168","199","175","232","240","49","10","6","1","78","102"]', '["153","161","143","138","186","148","224","215","168","199","175","232","240","49","10","6","1","78"]', NULL, 1, 1, 'untuk develop', 'Development', 'Admin', '2019-10-07 22:46:33', '2021-11-09 20:01:34'),
	(15, NULL, NULL, 'Super Admin', NULL, '["143","138","148","153"]', '["143","138","148","153"]', '["143","138","148","153"]', '["143","138","148","153"]', NULL, 2, 1, 'Untuk Admin', 'Admin', NULL, '2021-09-10 00:44:22', NULL);
/*!40000 ALTER TABLE `ut_role` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_smtp
CREATE TABLE IF NOT EXISTS `ut_smtp` (
  `protocol` varchar(50) DEFAULT NULL,
  `smtp_host` varchar(50) DEFAULT NULL,
  `smtp_port` varchar(50) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_smtp: 1 rows
/*!40000 ALTER TABLE `ut_smtp` DISABLE KEYS */;
INSERT IGNORE INTO `ut_smtp` (`protocol`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`) VALUES
	('smtp', 'ssl://smtp.gmail.com', '465', 'admin', 'admin');
/*!40000 ALTER TABLE `ut_smtp` ENABLE KEYS */;

-- Dumping structure for table sql6525945.ut_user
CREATE TABLE IF NOT EXISTS `ut_user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` int(11) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `CountryIso` varchar(250) DEFAULT NULL,
  `Phone` varchar(250) DEFAULT NULL,
  `Image` varchar(250) DEFAULT NULL,
  `LocationName` varchar(250) DEFAULT NULL,
  `Address` varchar(250) DEFAULT NULL,
  `Latitude` varchar(250) DEFAULT NULL,
  `Longitude` varchar(250) DEFAULT NULL,
  `Radius` int(11) DEFAULT NULL,
  `DateJoin` date DEFAULT NULL,
  `StartWorkDate` date DEFAULT NULL,
  `RoleID` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `StatusVerify` int(11) DEFAULT '0',
  `Token` varchar(250) DEFAULT NULL,
  `Theme` int(11) DEFAULT '1',
  `UserAdd` varchar(50) DEFAULT NULL,
  `UserCh` varchar(50) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `DateCh` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table sql6525945.ut_user: ~1 rows (approximately)
/*!40000 ALTER TABLE `ut_user` DISABLE KEYS */;
INSERT IGNORE INTO `ut_user` (`UserID`, `CompanyID`, `Name`, `Email`, `Username`, `Password`, `CountryIso`, `Phone`, `Image`, `LocationName`, `Address`, `Latitude`, `Longitude`, `Radius`, `DateJoin`, `StartWorkDate`, `RoleID`, `Status`, `StatusVerify`, `Token`, `Theme`, `UserAdd`, `UserCh`, `DateAdd`, `DateCh`) VALUES
	(1, NULL, 'Admin', 'admin@admin', 'Admin', 'da398e89ff325421bc677f569ac3a859c40adc78', '+62', '89609974119', 'img/company/alpa_210924221933.png', 'Bandung', NULL, '-6.952584373543057', '107.59722731800525', 1000, '2019-11-16', '2020-01-25', 1, 1, 0, 'aa78b60adb02a8e8f93811343a579a32296848f8', 3, 'Development', 'Admin', '2019-09-15 00:00:00', '2021-09-24 22:19:33');
/*!40000 ALTER TABLE `ut_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
