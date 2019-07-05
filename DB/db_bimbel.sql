/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : db_bimbel
Target Host     : localhost:3306
Target Database : db_bimbel
Date: 25/06/2019 16:39:07
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for detail_pelajaran
-- ----------------------------
DROP TABLE IF EXISTS `detail_pelajaran`;
CREATE TABLE `detail_pelajaran` (
  `kd_detail_pelajaran` char(11) NOT NULL,
  `nama_detail_pelajaran` varchar(40) NOT NULL,
  `kelas` char(20) NOT NULL,
  PRIMARY KEY (`kd_detail_pelajaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detail_pelajaran
-- ----------------------------

-- ----------------------------
-- Table structure for guru
-- ----------------------------
DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
  `kd_guru` char(6) NOT NULL,
  `user_id` char(5) NOT NULL,
  `nama_guru` char(50) NOT NULL,
  `alamat_guru` varchar(50) NOT NULL,
  `no_hp` char(12) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of guru
-- ----------------------------
INSERT INTO `guru` VALUES ('G001', 'ID001', 'Damar Risnanda', 'Blitar', '087756788988', '../guru/foto_guru/DistroIT.jpg');
INSERT INTO `guru` VALUES ('G002', 'ID007', 'Raffi Ahmad', 'Gresik', '087756789900', '../guru/foto_guru/depan.jpg');
INSERT INTO `guru` VALUES ('G003', 'ID008', 'Maghviroh', 'Jombang', '089922122333', '../guru/foto_guru/2x3.jpg');
INSERT INTO `guru` VALUES ('G004', 'ID009', 'Bagus Kurniawan', 'Batu', '087756781123', '../guru/foto_guru/pos.jpg');
INSERT INTO `guru` VALUES ('G005', 'ID010', 'Supri', 'Surabaya', '081336553023', '../guru/foto_guru/tumblr_oedcwwBOnG1twt4dho1_540.jpg');
INSERT INTO `guru` VALUES ('G006', 'ID011', 'Riani  Andriyanti', 'Bandung', '089776009776', '../guru/foto_guru/depan.jpg');
INSERT INTO `guru` VALUES ('G007', 'ID012', 'Guntur', 'Lampung', '082315670099', '../guru/foto_guru/pos.jpg');
INSERT INTO `guru` VALUES ('G008', 'ID013', 'Bahtiar Galih', 'Tulungagung', '089533145679', '../guru/foto_guru/SiNiS.jpg');

-- ----------------------------
-- Table structure for jadwal
-- ----------------------------
DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
  `kd_jadwal` char(5) NOT NULL,
  `kd_pelajaran` char(5) NOT NULL,
  `kd_guru` char(5) NOT NULL,
  `kd_ruang` char(5) NOT NULL,
  `nama_guru` char(50) NOT NULL,
  `nama_pelajaran` char(16) NOT NULL,
  `nama_ruang` text NOT NULL,
  `kategori_kelas` char(9) NOT NULL,
  `hari` text NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` text NOT NULL,
  `jam_selesai` text NOT NULL,
  PRIMARY KEY (`kd_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jadwal
-- ----------------------------
INSERT INTO `jadwal` VALUES ('J001', 'PL005', 'G005', 'R001', 'Supri', 'IPA', 'L1-A', 'SMP', 'Minggu', '2019-06-25', '09:00', '15:57');
INSERT INTO `jadwal` VALUES ('J002', 'PL003', 'G003', 'R001', 'Maghviroh', 'Bahasa Inggris', 'L1-A', 'SD', 'Sabtu', '2019-06-26', '09:00', '15:43');
INSERT INTO `jadwal` VALUES ('J003', 'PL004', 'G004', 'R011', 'Bagus Kurniawan', 'IPA', 'L2-E', 'SD', 'Sabtu', '2019-06-25', '10:00', '10:54');
INSERT INTO `jadwal` VALUES ('J004', 'PL001', 'G001', 'R002', 'Damar Risnanda', 'Bahasa Indonesia', 'L1-B', 'SD', 'Minggu', '2019-06-26', '16:00', '16:05');
INSERT INTO `jadwal` VALUES ('J005', 'PL005', 'G005', 'R004', 'Supri', 'IPA', 'L1-D', 'SD', 'Sabtu', '2019-06-25', '15:00', '16:10');

-- ----------------------------
-- Table structure for jadwal_pegawai
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_pegawai`;
CREATE TABLE `jadwal_pegawai` (
  `kd_jadwalpegawai` char(5) NOT NULL,
  `kd_pegawai` varchar(5) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` char(6) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  PRIMARY KEY (`kd_jadwalpegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jadwal_pegawai
-- ----------------------------

-- ----------------------------
-- Table structure for murid
-- ----------------------------
DROP TABLE IF EXISTS `murid`;
CREATE TABLE `murid` (
  `kd_murid` char(6) NOT NULL,
  `user_id` char(5) NOT NULL,
  `nama_murid` char(50) NOT NULL,
  `kelas` char(2) NOT NULL,
  `kategori_kelas` char(9) NOT NULL,
  `alamat_murid` char(30) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_murid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of murid
-- ----------------------------
INSERT INTO `murid` VALUES ('M001', 'ID002', 'Beti Wahyudi', '3', 'SD', 'Blitar', '082334900900', '../murid/foto_murid/tumblr_oedcwwBOnG1twt4dho1_540.jpg');
INSERT INTO `murid` VALUES ('M002', 'ID005', 'Gading Martin', '2', 'SMP', 'Semolowaru', '082334566755', '../murid/foto_murid/pos.jpg');

-- ----------------------------
-- Table structure for pelajaran
-- ----------------------------
DROP TABLE IF EXISTS `pelajaran`;
CREATE TABLE `pelajaran` (
  `kd_pelajaran` char(6) NOT NULL,
  `kd_guru` char(5) NOT NULL,
  `nama_pelajaran` varchar(16) NOT NULL,
  `nama_guru` char(20) NOT NULL,
  `kategori_kelas` char(9) NOT NULL,
  PRIMARY KEY (`kd_pelajaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pelajaran
-- ----------------------------
INSERT INTO `pelajaran` VALUES ('PL001', 'G001', 'Bahasa Indonesia', 'Damar Risnanda', 'SMP');
INSERT INTO `pelajaran` VALUES ('PL002', 'G002', 'Matematika', 'Raffi Ahmad', 'SMP');
INSERT INTO `pelajaran` VALUES ('PL003', 'G003', 'Bahasa Inggris', 'Maghviroh', 'SMP');
INSERT INTO `pelajaran` VALUES ('PL004', 'G004', 'IPA', 'Bagus Kurniawan', 'SMP');
INSERT INTO `pelajaran` VALUES ('PL005', 'G005', 'IPA', 'Supri', 'SD');
INSERT INTO `pelajaran` VALUES ('PL006', 'G006', 'Matematika', 'Riani  Andriyanti', 'SD');
INSERT INTO `pelajaran` VALUES ('PL007', 'G007', 'Bahasa Indonesia', 'Guntur', 'SD');
INSERT INTO `pelajaran` VALUES ('PL008', 'G008', 'Bahasa Inggris', 'Bahtiar Galih', 'SD');

-- ----------------------------
-- Table structure for ruang
-- ----------------------------
DROP TABLE IF EXISTS `ruang`;
CREATE TABLE `ruang` (
  `kd_ruang` char(5) NOT NULL,
  `nama_ruang` text NOT NULL,
  PRIMARY KEY (`kd_ruang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ruang
-- ----------------------------
INSERT INTO `ruang` VALUES ('R001', 'L1-A');
INSERT INTO `ruang` VALUES ('R002', 'L1-B');
INSERT INTO `ruang` VALUES ('R003', 'L1-C');
INSERT INTO `ruang` VALUES ('R004', 'L1-D');
INSERT INTO `ruang` VALUES ('R005', 'L1-E');
INSERT INTO `ruang` VALUES ('R006', 'L1-F');
INSERT INTO `ruang` VALUES ('R007', 'L2-A');
INSERT INTO `ruang` VALUES ('R008', 'L2-B');
INSERT INTO `ruang` VALUES ('R009', 'L2-C');
INSERT INTO `ruang` VALUES ('R010', 'L2-D');
INSERT INTO `ruang` VALUES ('R011', 'L2-E');
INSERT INTO `ruang` VALUES ('R012', 'L2-F');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `kd_staff` char(6) NOT NULL,
  `user_id` char(5) NOT NULL,
  `nama_staff` varchar(30) NOT NULL,
  `alamat_staff` varchar(50) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`kd_staff`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('S001', 'ID003', 'Bonet Kurniawan', 'Malang', '087766789900', '../member/foto_member/depan.jpg');
INSERT INTO `staff` VALUES ('S002', 'ID006', 'Maghvirna', 'Kediri', '081234567890', '../member/foto_member/tumblr_oedcwwBOnG1twt4dho1_540.jpg');

-- ----------------------------
-- Table structure for transaksi_pendaftaran
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pendaftaran`;
CREATE TABLE `transaksi_pendaftaran` (
  `kd_transaksi` char(6) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  PRIMARY KEY (`kd_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi_pendaftaran
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` char(5) NOT NULL,
  `username` char(10) NOT NULL,
  `password` char(8) NOT NULL,
  `fullname` text NOT NULL,
  `privilege` text NOT NULL,
  `gambar_user` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('ID001', 'G001', '123', 'Damar Risnanda', 'admin', '../guru/foto_guru/pos.jpg');
INSERT INTO `user` VALUES ('ID002', 'M001', '123', 'Beti Wahyudi', 'user_sd', 'gambar_admin/DistroIT.jpg');
INSERT INTO `user` VALUES ('ID003', 'S001', '123', 'Bonet Kurniawan', 'superuser', 'gambar_admin/DistroIT.jpg');
INSERT INTO `user` VALUES ('ID005', 'M002', '123', 'Gading Martin', 'user_smp', '../murid/foto_murid/2x3.jpg');
INSERT INTO `user` VALUES ('ID006', 'S002', '123', 'Maghvirna', 'superuser', '../member/foto_member/tumblr_oedcwwBOnG1twt4dho1_540.jpg');
INSERT INTO `user` VALUES ('ID007', 'G002', '123', 'Raffi Ahmad', 'admin', '../guru/foto_guru/depan.jpg');
INSERT INTO `user` VALUES ('ID008', 'G003', '123', 'Maghviroh', 'admin', '../guru/foto_guru/2x3.jpg');
INSERT INTO `user` VALUES ('ID009', 'G004', '123', 'Bagus Kurniawan', 'admin', '../guru/foto_guru/pos.jpg');
INSERT INTO `user` VALUES ('ID010', 'G005', '123', 'Supri', 'admin', '../guru/foto_guru/tumblr_oedcwwBOnG1twt4dho1_540.jpg');
INSERT INTO `user` VALUES ('ID011', 'G006', '123', 'Riani  Andriyanti', 'admin', '../guru/foto_guru/depan.jpg');
INSERT INTO `user` VALUES ('ID012', 'G007', '123', 'Guntur', 'admin', '../guru/foto_guru/pos.jpg');
INSERT INTO `user` VALUES ('ID013', 'G008', '123', 'Bahtiar Galih', 'admin', '../guru/foto_guru/SiNiS.jpg');
