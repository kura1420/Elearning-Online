/*
 Navicat Premium Data Transfer

 Source Server         : XAMPP 7.2
 Source Server Type    : MariaDB
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : db_elearning_new

 Target Server Type    : MariaDB
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 25/08/2020 11:20:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for file_uploads
-- ----------------------------
DROP TABLE IF EXISTS `file_uploads`;
CREATE TABLE `file_uploads`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `random_nama` tinyint(1) NULL DEFAULT 0,
  `tipe` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of file_uploads
-- ----------------------------
INSERT INTO `file_uploads` VALUES ('19c7e15f-fc61-43e3-8b5c-d0e735667025', 'Se5cu7XJwH_20200416-070804.jpeg', 1, 'image', 'http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/soal_pertanyaan/Se5cu7XJwH_20200416-070804.jpeg', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 00:04:08', '2020-04-16 00:04:08', NULL);
INSERT INTO `file_uploads` VALUES ('9af860b8-16a8-4e8b-946d-a3d189c40efd', 'rooti_20200416-071103.jpeg', 0, 'image', 'http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/soal_pertanyaan/rooti_20200416-071103.jpeg', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 00:03:11', '2020-04-16 02:50:01', NULL);

-- ----------------------------
-- Table structure for guru_pelajarans
-- ----------------------------
DROP TABLE IF EXISTS `guru_pelajarans`;
CREATE TABLE `guru_pelajarans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 0,
  `guru_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of guru_pelajarans
-- ----------------------------
INSERT INTO `guru_pelajarans` VALUES ('62a7582f-7ae1-48cd-9cef-cdcf03eacd40', 1, 'ab70ca01-b01b-4642-9601-269342ea82de', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:40:35', '2020-04-15 05:40:35');
INSERT INTO `guru_pelajarans` VALUES ('bf19500c-0c06-462d-b4b6-57c00f14661a', 1, 'ab70ca01-b01b-4642-9601-269342ea82de', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:40:35', '2020-04-15 05:40:35');
INSERT INTO `guru_pelajarans` VALUES ('dd1f1c09-99fc-4166-9262-6fe979ba4b17', 1, '28808e8a-7181-4292-a9f7-a55982f59df1', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-07 13:25:54', '2020-05-07 13:25:54');

-- ----------------------------
-- Table structure for gurus
-- ----------------------------
DROP TABLE IF EXISTS `gurus`;
CREATE TABLE `gurus`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_induk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('l','p') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `handphone` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telp` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_masuk` date NULL DEFAULT NULL,
  `tanggal_keluar` date NULL DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gurus
-- ----------------------------
INSERT INTO `gurus` VALUES ('28808e8a-7181-4292-a9f7-a55982f59df1', NULL, 'Guru 11', 'l', NULL, NULL, NULL, '', '1', NULL, NULL, NULL, NULL, '191a5a44-a05c-42d5-b818-98eeb543dd7f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:39:43', '2020-04-15 05:41:43', NULL);
INSERT INTO `gurus` VALUES ('49dffc43-e9bc-4440-bbf6-2063ad3c84db', '142017', 'Abdul Syakur', 'l', 'Jakarta', '1992-02-14', 'Depok', 'a.syakur14@domain.com', '081212341234', NULL, '2020-01-01', NULL, 'Kepala Lab. Komputer', '0b63fd80-8fbd-4815-9cf5-5828dfab644f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:42:43', '2020-04-15 05:42:43', NULL);
INSERT INTO `gurus` VALUES ('ab70ca01-b01b-4642-9601-269342ea82de', NULL, 'Guru 2', 'p', NULL, NULL, NULL, '', '2', NULL, NULL, NULL, NULL, '6c783b0c-2007-4c46-a17c-b473a0e0efb3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:40:35', '2020-04-15 05:40:35', NULL);
INSERT INTO `gurus` VALUES ('bd7edea4-d3be-4b20-8032-8e7aaaa90d43', '142019', 'Muhammad Khaisanu Qaddafi', 'l', 'Jakarta', '2019-06-19', 'Pasar Rebo', 'dev19@domain.com', '081212341234', '02112341234', '2019-12-31', NULL, 'Kepala Sekolah', '66a9365d-3458-4082-997e-c2f442d2e7c3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:42:43', '2020-04-15 05:42:43', NULL);

-- ----------------------------
-- Table structure for jenis_sekolahs
-- ----------------------------
DROP TABLE IF EXISTS `jenis_sekolahs`;
CREATE TABLE `jenis_sekolahs`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_sekolahs
-- ----------------------------
INSERT INTO `jenis_sekolahs` VALUES ('212540b6-de9f-470c-9afa-b26f1aebb70f', 'test', '12', '2020-05-31 17:33:17', '2020-05-31 17:55:45', NULL);
INSERT INTO `jenis_sekolahs` VALUES ('36474935-4af0-4e08-9fe7-0016382352b5', 'test123', NULL, '2020-06-01 03:38:04', '2020-06-01 03:38:04', NULL);
INSERT INTO `jenis_sekolahs` VALUES ('e903dbd0-401a-4c6e-bf76-331314c24634', 'yes', NULL, '2020-05-31 17:37:32', '2020-05-31 18:05:16', NULL);
INSERT INTO `jenis_sekolahs` VALUES ('f8ea8a29-b9e1-44af-8455-8163dac88e9a', '123', NULL, '2020-06-01 02:56:41', '2020-06-01 02:56:58', NULL);

-- ----------------------------
-- Table structure for jenis_ujians
-- ----------------------------
DROP TABLE IF EXISTS `jenis_ujians`;
CREATE TABLE `jenis_ujians`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_ujians
-- ----------------------------
INSERT INTO `jenis_ujians` VALUES ('0776fcb9-d5a1-4c5b-8521-fab36e32acd2', 'Semester', 'mingguan', '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `jenis_ujians` VALUES ('0fc8afbc-58ce-4d17-8f3a-4a3f4a177b83', 'Try Out', 'mingguan', '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `jenis_ujians` VALUES ('108691f6-711d-4739-a11b-f92792224127', 'Semester', 'mingguan', '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `jenis_ujians` VALUES ('1ed70cd7-a26b-4133-9f25-c9d3e0fbb758', 'Ulangan', 'harian', '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `jenis_ujians` VALUES ('20127132-ed85-4d54-ae1c-68d66c563e3a', 'Ulangan', 'harian', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:57', '2020-04-15 02:15:57', NULL);
INSERT INTO `jenis_ujians` VALUES ('3394f9eb-50a5-485f-892c-2d5f740235bd', 'PR', 'harian', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:57', '2020-04-15 02:15:57', NULL);
INSERT INTO `jenis_ujians` VALUES ('379bf152-6e88-4de4-9c2f-384085e7ecad', 'Try Out', 'mingguan', '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `jenis_ujians` VALUES ('49abf231-89fb-4d3b-82f4-db914a7a744e', 'PR', 'harian', '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `jenis_ujians` VALUES ('502eedae-6791-448c-8024-73e5ca8d6779', 'PR', 'harian', '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `jenis_ujians` VALUES ('5b5a58bb-16cb-4116-8cd4-31f7d596caf7', 'PR', 'harian', '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `jenis_ujians` VALUES ('5bbb47b0-8a88-4dbc-92d3-6b4a2055e511', 'Try Out', 'mingguan', '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `jenis_ujians` VALUES ('7449e88c-a591-4168-b5a9-a388497c45dc', 'Semester', 'mingguan', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:57', '2020-04-15 02:15:57', NULL);
INSERT INTO `jenis_ujians` VALUES ('8b974fe4-4a11-40bf-a875-36da131bf427', 'Try Out', 'mingguan', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:57', '2020-04-15 02:15:57', NULL);
INSERT INTO `jenis_ujians` VALUES ('9312b2a0-4fb7-4e73-b245-483e354064ca', 'Semester', 'mingguan', '53f71fde-4ca1-4479-bf67-b83e8c310dc3', '2020-04-15 03:19:10', '2020-04-15 03:19:10', NULL);
INSERT INTO `jenis_ujians` VALUES ('bf84e514-b259-465d-873d-20208461d1f9', 'Ulangan', 'harian', '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `jenis_ujians` VALUES ('d4c92635-3697-46dc-a292-685965ed4dd4', 'Semester', 'mingguan', '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `jenis_ujians` VALUES ('de0f5ccb-f0ce-4d0a-b588-a4d03c3bdac6', 'Ulangan', 'harian', '53f71fde-4ca1-4479-bf67-b83e8c310dc3', '2020-04-15 03:19:10', '2020-04-15 03:19:10', NULL);
INSERT INTO `jenis_ujians` VALUES ('e8d6ce1f-c6c9-4bff-ba37-14e70cc07635', 'Ulangan', 'harian', '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `jenis_ujians` VALUES ('f8ba51da-3ea6-404b-a3e0-e2dcf1db55fd', 'PR', 'harian', '53f71fde-4ca1-4479-bf67-b83e8c310dc3', '2020-04-15 03:19:10', '2020-04-15 03:19:10', NULL);
INSERT INTO `jenis_ujians` VALUES ('ffd8beb7-1138-4378-8937-892b1c88a064', 'Try Out', 'mingguan', '53f71fde-4ca1-4479-bf67-b83e8c310dc3', '2020-04-15 03:19:10', '2020-04-15 03:19:10', NULL);

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES ('3d6a76cf-61c5-4631-89a7-30405c7c85e1', '1b', NULL, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 04:27:44', '2020-04-15 04:27:44', NULL);
INSERT INTO `kelas` VALUES ('7f50a460-1999-46fa-8211-39a7792829b0', '1c', NULL, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 04:54:49', '2020-04-15 04:54:49', NULL);
INSERT INTO `kelas` VALUES ('d8c9a29a-3a87-45e1-8773-bf3efa43e9de', '1a', NULL, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 04:27:39', '2020-04-15 04:27:39', NULL);
INSERT INTO `kelas` VALUES ('e7165fa8-6b4e-4681-8abb-5d87ad3cce37', 'satu 11', 'keterangan', '11', NULL, NULL, NULL);
INSERT INTO `kelas` VALUES ('efdc4255-d7b6-45fb-852a-d4b57334841a', '1d', NULL, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 04:58:04', '2020-04-15 04:58:04', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2020_02_10_185430_create_sessions_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_02_11_181236_create_sekolahs_table', 2);
INSERT INTO `migrations` VALUES (6, '2020_02_11_181254_create_pic_sekolahs_table', 2);
INSERT INTO `migrations` VALUES (7, '2020_02_11_181326_create_profil_users_table', 2);
INSERT INTO `migrations` VALUES (8, '2020_02_18_023739_create_kelas_table', 3);
INSERT INTO `migrations` VALUES (9, '2020_02_18_023827_create_pelajarans_table', 3);
INSERT INTO `migrations` VALUES (10, '2020_02_18_023856_create_gurus_table', 3);
INSERT INTO `migrations` VALUES (11, '2020_02_18_023916_create_tahun_ajarans_table', 3);
INSERT INTO `migrations` VALUES (12, '2020_02_18_023933_create_tahun_ajaran_jadwals_table', 3);
INSERT INTO `migrations` VALUES (13, '2020_02_18_024002_create_siswas_table', 3);
INSERT INTO `migrations` VALUES (14, '2020_02_18_024028_create_guru_pelajarans_table', 3);
INSERT INTO `migrations` VALUES (15, '2020_02_18_024046_create_siswa_kelas_table', 3);
INSERT INTO `migrations` VALUES (16, '2020_02_18_024122_create_file_uploads_table', 3);
INSERT INTO `migrations` VALUES (17, '2020_02_21_090210_create_pelajaran_tipes_table', 4);
INSERT INTO `migrations` VALUES (18, '2020_02_21_132005_create_jenis_ujians_table', 4);
INSERT INTO `migrations` VALUES (19, '2020_02_21_132045_create_rumus_penilaian_ujians_table', 4);
INSERT INTO `migrations` VALUES (20, '2020_02_21_132133_create_soals_table', 4);
INSERT INTO `migrations` VALUES (21, '2020_02_21_132152_create_soal_pertanyaans_table', 4);
INSERT INTO `migrations` VALUES (22, '2020_02_21_132210_create_soal_pertanyaan_jawabans_table', 4);
INSERT INTO `migrations` VALUES (23, '2020_02_21_132238_create_ujian_harians_table', 4);
INSERT INTO `migrations` VALUES (24, '2020_02_21_132307_create_ujian_harian_jawaban_siswas_table', 4);
INSERT INTO `migrations` VALUES (25, '2020_02_21_132326_create_ujian_harian_hasils_table', 4);
INSERT INTO `migrations` VALUES (26, '2020_02_21_132350_create_ujian_mingguans_table', 4);
INSERT INTO `migrations` VALUES (27, '2020_02_21_132407_create_ujian_mingguan_soals_table', 4);
INSERT INTO `migrations` VALUES (28, '2020_02_21_132431_create_ujian_mingguan_jawaban_siswas_table', 4);
INSERT INTO `migrations` VALUES (29, '2020_02_21_132448_create_ujian_mingguan_hasils_table', 4);
INSERT INTO `migrations` VALUES (30, '2020_02_24_151002_create_ujian_harian_siswas_table', 5);
INSERT INTO `migrations` VALUES (31, '2020_04_12_142233_create_remedial_ujian_harians_table', 6);
INSERT INTO `migrations` VALUES (32, '2020_04_12_142329_create_remedial_ujian_harian_siswas_table', 6);
INSERT INTO `migrations` VALUES (33, '2020_04_12_142632_create_remedial_ujian_harian_jawaban_siswas_table', 6);
INSERT INTO `migrations` VALUES (34, '2020_04_12_142653_create_remedial_ujian_harian_hasils_table', 6);
INSERT INTO `migrations` VALUES (35, '2020_05_30_233351_jenis_sekolah', 7);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pelajaran_tipes
-- ----------------------------
DROP TABLE IF EXISTS `pelajaran_tipes`;
CREATE TABLE `pelajaran_tipes`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelajaran_tipes
-- ----------------------------
INSERT INTO `pelajaran_tipes` VALUES ('14438ca2-a90c-45d6-9145-c1ce516a2d40', 'Mengarang', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:17:03', '2020-04-15 05:17:28', NULL);
INSERT INTO `pelajaran_tipes` VALUES ('325a7103-cb42-4899-88a0-2a97e105b149', 'Aljabar', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:17:13', '2020-04-15 05:17:13', NULL);
INSERT INTO `pelajaran_tipes` VALUES ('a07af9ee-2ac7-41c9-8063-66e773bd5317', 'SPOK', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:15:17', '2020-04-15 05:15:17', NULL);

-- ----------------------------
-- Table structure for pelajarans
-- ----------------------------
DROP TABLE IF EXISTS `pelajarans`;
CREATE TABLE `pelajarans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelajarans
-- ----------------------------
INSERT INTO `pelajarans` VALUES ('3ff9ef0a-2a86-4e19-ab69-f00841d3b972', 'Matematika', 'Untuk kelas 1', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:03:36', '2020-04-15 05:04:11', NULL);
INSERT INTO `pelajarans` VALUES ('e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'B. Indonesia', NULL, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 05:05:03', '2020-04-15 05:05:03', NULL);

-- ----------------------------
-- Table structure for pic_sekolahs
-- ----------------------------
DROP TABLE IF EXISTS `pic_sekolahs`;
CREATE TABLE `pic_sekolahs`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `handphone` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pic_sekolahs
-- ----------------------------
INSERT INTO `pic_sekolahs` VALUES ('0173eba8-9d40-415e-8a59-eb8f92ba63da', 'Ade', '', '3', NULL, NULL, '', '987f49c1-c325-4e2a-83af-4163dcd55332', NULL, '2020-04-15 02:20:14', '2020-04-15 02:37:09', NULL);
INSERT INTO `pic_sekolahs` VALUES ('579c4b45-ecbb-47dc-ab88-bffd0f5b5250', 'Sandi', '', '2', NULL, NULL, NULL, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, '2020-04-15 04:18:55', NULL);
INSERT INTO `pic_sekolahs` VALUES ('69d3c5e8-3246-4d07-a116-4676dcc36a70', 'bbb', '', '1', NULL, NULL, NULL, '885f36dc-97dc-4330-80d7-94e341b59187', NULL, '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `pic_sekolahs` VALUES ('7577db1e-faf4-4492-ab67-39f7891a6e64', 'Joni', '', '1', NULL, NULL, NULL, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL, NULL);
INSERT INTO `pic_sekolahs` VALUES ('a072bc4a-f066-4432-88e8-071341ca4c5c', 'Tarigan', '', '1', NULL, NULL, '', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '11b83d3b-85f4-4432-84e4-18bebf8f32e6', '2020-04-15 02:15:58', '2020-04-15 03:58:30', NULL);
INSERT INTO `pic_sekolahs` VALUES ('cd72cb1d-d683-4b3e-8f32-190e27182f01', 'Kerupuk', '', '1', NULL, NULL, NULL, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL, NULL);
INSERT INTO `pic_sekolahs` VALUES ('cea366cd-d39d-4ee8-8aff-75a644736250', 'Adam', '', '2', NULL, NULL, '', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', NULL, '2020-04-15 02:15:58', '2020-04-15 02:36:22', NULL);
INSERT INTO `pic_sekolahs` VALUES ('d7664809-38ba-4f4a-82b3-2c615dd290a4', 'aa', '', '1', NULL, NULL, NULL, '885f36dc-97dc-4330-80d7-94e341b59187', NULL, '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `pic_sekolahs` VALUES ('fa4648e6-0c16-49da-becf-485ce46f6f9b', 'ccc', '', '2', NULL, NULL, NULL, '885f36dc-97dc-4330-80d7-94e341b59187', NULL, '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);

-- ----------------------------
-- Table structure for profil_users
-- ----------------------------
DROP TABLE IF EXISTS `profil_users`;
CREATE TABLE `profil_users`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `handphone` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telp` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of profil_users
-- ----------------------------
INSERT INTO `profil_users` VALUES ('2fa04000-be46-471f-9f19-c9db2a3a3272', 'Magenta', '', NULL, NULL, NULL, NULL, '84f2c028-635a-4863-bd0b-9c004dd64be0', '2020-05-05 16:58:52', '2020-06-01 20:50:40', NULL);
INSERT INTO `profil_users` VALUES ('33f90697-ec5a-4991-884f-230f6479df75', 'Dafi', 'dav@gmail.com', NULL, NULL, NULL, NULL, '415ade81-995b-4306-be86-4e22675c81fd', '2020-06-01 03:52:52', '2020-06-01 03:52:52', NULL);
INSERT INTO `profil_users` VALUES ('3669d38f-78b3-4873-867c-5964dea3d0de', 'asd', '', NULL, NULL, NULL, NULL, 'ea6eb8aa-ab83-4de4-89f8-0833969cb617', '2020-06-01 03:54:34', '2020-06-01 03:54:34', NULL);
INSERT INTO `profil_users` VALUES ('417e7497-ee5f-42b3-9a26-ab90c965d104', 'Abdul Syakur', 'syakur@gmail.com', NULL, NULL, NULL, NULL, '2e69fa2b-8e10-4720-adcf-adc248cb043a', '2020-06-01 03:52:20', '2020-06-01 03:52:20', NULL);

-- ----------------------------
-- Table structure for remedial_ujian_harian_hasils
-- ----------------------------
DROP TABLE IF EXISTS `remedial_ujian_harian_hasils`;
CREATE TABLE `remedial_ujian_harian_hasils`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  `nilai` int(11) NULL DEFAULT NULL,
  `total_pertanyaan` int(11) NOT NULL,
  `total_benar` int(11) NULL DEFAULT NULL,
  `total_salah` int(11) NULL DEFAULT NULL,
  `pertanyaan_dijawab` int(11) NOT NULL,
  `pertanyaan_tidak_dijawab` int(11) NOT NULL,
  `pertanyaan_dijawab_ragu` int(11) NOT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remedial_ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remedial_ujian_harian_siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for remedial_ujian_harian_jawaban_siswas
-- ----------------------------
DROP TABLE IF EXISTS `remedial_ujian_harian_jawaban_siswas`;
CREATE TABLE `remedial_ujian_harian_jawaban_siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `tipe` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_jawaban_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remedial_ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remedial_ujian_harian_siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for remedial_ujian_harian_siswas
-- ----------------------------
DROP TABLE IF EXISTS `remedial_ujian_harian_siswas`;
CREATE TABLE `remedial_ujian_harian_siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remedial_ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for remedial_ujian_harians
-- ----------------------------
DROP TABLE IF EXISTS `remedial_ujian_harians`;
CREATE TABLE `remedial_ujian_harians`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_habis` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_waktu_pengerjaan` int(11) NOT NULL,
  `tampilkan_nilai` tinyint(1) NOT NULL DEFAULT 0,
  `alert_simpan_jawaban` int(11) NOT NULL,
  `batas_kelulusan` int(11) NOT NULL,
  `pertanyaan_acak` tinyint(1) NOT NULL DEFAULT 0,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rumus_penilaian_ujians
-- ----------------------------
DROP TABLE IF EXISTS `rumus_penilaian_ujians`;
CREATE TABLE `rumus_penilaian_ujians`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `benar` int(11) NOT NULL,
  `salah` int(11) NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rumus_penilaian_ujians
-- ----------------------------
INSERT INTO `rumus_penilaian_ujians` VALUES ('01ec9a28-d7f5-4d56-827f-e18e38dd6133', 'Mudah', 1, 0, '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('15f03bc5-7ce3-4ecb-ab61-4d69131b2f08', 'Mudah', 1, 0, '53f71fde-4ca1-4479-bf67-b83e8c310dc3', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('171e0f68-478f-436d-bce8-caebf32b175e', 'Sedang', 2, 0, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:58', '2020-04-15 02:15:58', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('2600f64a-ca9c-4eee-bebc-8dd7a794f39c', 'Mudah', 1, 0, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('29df5277-966f-4459-acf3-b9a3025c26fc', 'Sulit', 3, 1, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:58', '2020-04-15 02:15:58', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('2b55b11e-6fae-4256-9661-a31b2e7f5785', 'Mudah', 1, 0, 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 02:15:57', '2020-04-15 02:15:57', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('35ba289f-5c39-4056-a32b-6b663727fd46', 'Sulit', 3, 1, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('4dbfdbc7-22dc-4e8a-9530-6a5d425d5e53', 'Sedang', 2, 0, '53f71fde-4ca1-4479-bf67-b83e8c310dc3', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('7ea40c44-d2a0-41f0-8944-5962e6656173', 'Sulit', 3, 1, '53f71fde-4ca1-4479-bf67-b83e8c310dc3', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('8a0214da-276d-4924-b7ab-9378c3ee0b86', 'Sulit', 3, 1, '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('8d875093-6b3e-48d6-8897-a8d3e4944257', 'Sedang', 2, 0, '30d13701-f90e-434f-a5c0-14c2de34093c', NULL, NULL, NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('8e2ab3c7-5258-4658-8dcc-01b67b886a50', 'Mudah', 1, 0, '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('9fc086c8-63fb-482a-a03b-6d69000e2eaa', 'Sulit', 3, 1, '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('ac932f93-6743-4ea2-ad97-68d3e81a1aa7', 'Sedang', 2, 0, '885f36dc-97dc-4330-80d7-94e341b59187', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `rumus_penilaian_ujians` VALUES ('efbf0e42-6170-4505-bd6d-42cc6cf81961', 'Sedang', 2, 0, '987f49c1-c325-4e2a-83af-4163dcd55332', '2020-04-15 02:17:52', '2020-04-15 02:17:52', NULL);

-- ----------------------------
-- Table structure for sekolahs
-- ----------------------------
DROP TABLE IF EXISTS `sekolahs`;
CREATE TABLE `sekolahs`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npsn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendidikan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telp` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `singkatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sekolahs_singkatan_unique`(`singkatan`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sekolahs
-- ----------------------------
INSERT INTO `sekolahs` VALUES ('30d13701-f90e-434f-a5c0-14c2de34093c', NULL, 'Cisalak 1', 'negeri', 'sd', 'kc8YvyVLc3.jpeg', 'Cisalak', 'cisalak1@domain.com', NULL, NULL, 'YUwOg', '2020-04-15 02:50:04', '2020-04-22 15:52:36', NULL);
INSERT INTO `sekolahs` VALUES ('53f71fde-4ca1-4479-bf67-b83e8c310dc3', NULL, 'aaa', 'swasta', 'sd', NULL, 'aaaaa', '', NULL, NULL, 'JvhOp', '2020-04-15 03:19:10', '2020-04-15 03:19:10', NULL);
INSERT INTO `sekolahs` VALUES ('885f36dc-97dc-4330-80d7-94e341b59187', NULL, 'bbb', 'swasta', 'sd', NULL, 'aaaa', '', NULL, NULL, 'alQ5d', '2020-04-15 03:29:59', '2020-04-15 03:29:59', NULL);
INSERT INTO `sekolahs` VALUES ('987f49c1-c325-4e2a-83af-4163dcd55332', NULL, 'Cisalak 3', 'negeri', 'sd', NULL, 'Cisalak', '', NULL, NULL, 'EHolS', '2020-04-15 02:17:51', '2020-04-15 02:37:09', NULL);
INSERT INTO `sekolahs` VALUES ('dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', NULL, 'Taruna Bhakti', 'swasta', 'smk', 'sjhetxZylE.jpeg', 'Depok', '', NULL, NULL, 'm6g7X', '2020-04-15 02:15:56', '2020-04-22 15:50:35', NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE INDEX `sessions_id_unique`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('1AbXdJBTpMLAB1MT8W6hLwqXRa45WXDqYbRbtcse', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4161.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ2g4bmpFRjgxQmFuZFZDUEZEckw0czlqdUQzZGdPdHNhN2Y1NVNSSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3QvZWxlYXJuaW5nLW5ldyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6Njoic2NoX2lkIjtzOjM2OiJkZmFhMmYwZC1jYmVlLTQzYTEtODVmYy1hMzlhNDQzYzJlZTYiO3M6Nzoic2NoX3BpYyI7czozNjoiYTA3MmJjNGEtZjA2Ni00NDMyLTg4ZTgtMDcxMzQxY2E0YzVjIjtzOjEzOiJzY2hfc2hvcnRuYW1lIjtzOjU6Im02Zzd4Ijt9', 1591067530);
INSERT INTO `sessions` VALUES ('g8txkGtYwexaoIgRpRCixJlWGFugP1uaCtxWHYOv', 'dd8da101-b488-41bb-bfd2-f2fe8ec762ad', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4160.0 Safari/537.36', 'ZXlKcGRpSTZJbE5tWVc5aWRteFRSblpUVUcxTmFVd3pTV1VyUkhjOVBTSXNJblpoYkhWbElqb2lXWGxQTjNCVU5VZHBSbXRSY0Z3dk5GUkpPVWhVVm1jNFQwSnNWbUkxVGt3d1ZucHZjbVpuY0hGUmNGVXJZakl5WEM5Vk1FODVkV3RJWW5KNlJpdHJhRXBCWjFkdlVYYzVXRUkxWW5FNWNHUTBiMDlPYWt0eU5HdGxPR05tVFVSTkt6ZFZhekZ2UkU5RlVqaDVhbkZ6VGxSTmRHOTZSRVp3U3pOSU16ZE9aVkpuZDJ4elpVaDZkSGxHY0RBMVlWTkpUbUpwVERkdmVVczRXbHd2ZEcxWVNVRTBlWFZZZFdwcGFHNHJjVzU2UmxkRU5VdFlSbU5zV1VOV1UzaEZUMWN4ZFVaNVVXRTVhbGRuTkN0bFlWSkhTWFZDVFhKdU9HNURja2htY3l0U05ITk9aMWQ1ZEVSdldFdENVblpaSzA4MldqaE9RV2x4ZDFvM01ucDZaMFpVT0haRVYwMWtiRlEwVjBNMlVXMWxSVkJETTNKdVZucDVjemxrYTFBd2JXWnNVSGROYjB0RldVMTRjM2xpWmtOQlFrUjBXVWx6WW1aSFdqZGhNU3MyUmx3dlJEVnVSbVZwUmtZM1RYZ3paV1ZSWjA1eFFrWjBSR1pjTDJOR01HRm1jbFo0VmpkQk5XdEhiRnd2WW1Gck1ISm1UVlpDSzFSUU4wSkVOM0ZtTWx3dk1IVjRWVEZVWkdzeWNUZFBaR1JYZW1VM1RrUklhMUo1TWxsRk5Vb3pVVFJJZUhSeWVIUlVaV3hOWW1ZM2QyeDNiazFCZVVwcU1tUlJia2QwZVhadVpVZHlSa05UU21kUE5sSlZTU3RrVTNwYWQwMXRXR05LT0VwNk5rVjFkMWRIUTA1alJXUnZUQ3R1TjI5bFUyeDNlSEZVZVc5MmJGSkhlRU5TUjNJelEwUnJOV1U1VEVaeU5FMTFObFpSVlZ3dk4yRlhRMmRPWlhSSmNYRmlZMFJ6U0UxNGJFOXZWa2RxYVZGNGRGaE9jMUoxVUd3NWNFNW9ZVmd3WnpsT1NIVnJOeXRNWjJaUlpETWlMQ0p0WVdNaU9pSmtaak0wT1RkaU9ESXdZMlptWkRkaU5EWTBPRFZsWWpRM01tWXhOMlZoTkdKa01EVXpPVE14Wm1KalpEZzJZelF6TjJFME16Z3hORFkxWmpNeVlqbGlJbjA9', 1590984473);
INSERT INTO `sessions` VALUES ('II22J6XUlBznt0hSniAiEjiCgdvyhoALNu0aLGSz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4161.0 Safari/537.36', 'ZXlKcGRpSTZJblJOZG1ReE1HbzVPSE5wWkZRd2NEUnJUSGhDWjJjOVBTSXNJblpoYkhWbElqb2lSREJMV1d4bk1HRlJSRGdyVkRsRUsyaGlieXRTZW1oMGJGRnJZa3N3YVRoQ2RVSmhOVEZtVkhCcmVVeEpRWFoxUmx3dllraFFia1Y1Wm5kUlpWSXhSblpCVDNWS1pVVlZXVEpYYkc5Y0wyaEVkalZDTTJGRVV6VmxaR0pVZVc5NlRGbFdSVGx5VHpZclFYSnpOVUZJVjJkT1NWYzVNMWM0ZVdsbU5GVjJlR0oyWWxnd09WSmxUVzFYSzBWUGJYbHpVRWxTVUU5YVUwZDVlRGd3U0hWWU5XOTRRa3BHYVhCaVFtWk1UVzAzWm5kcVdXWnJVMHBvWVhVd1EwaHhhVEZXVEVRek4wOXVkalZxYmt0R1NtOUhjVE5aUkdKS2MzazJTMmh5VWtodFRqTlhZMjA0U2xwb2JWbFpUVFpzTXpaUGVXNUdNeXRQWmpCd1EwaDZOR1Y0VWtkWE5uazVTV1JrUjF3dlprVmxlRTFGUVZjcmFEUk5OWGM5UFNJc0ltMWhZeUk2SW1NelpXRmlZVGhqTUdZeU1ETTJaR1U1T0dJd1pXSXdZamd6TW1FMk1qQmpabU0zWXpFMU1UaGtOemMyWXpjNE5qZGlOV0UzWkdGbE1qSm1PVGswWmpraWZRPT0=', 1591045815);

-- ----------------------------
-- Table structure for siswa_kelas
-- ----------------------------
DROP TABLE IF EXISTS `siswa_kelas`;
CREATE TABLE `siswa_kelas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 0,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tahun_ajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siswa_kelas
-- ----------------------------
INSERT INTO `siswa_kelas` VALUES ('a340be67-be6a-4181-a437-8b2af34bfec1', 0, NULL, '760cdd93-a857-4ec5-80da-0daf500e5bde', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:33:00', '2020-04-15 06:35:51');
INSERT INTO `siswa_kelas` VALUES ('ae06414a-5b3d-4f72-ae0c-06099373b1b4', 1, NULL, '760cdd93-a857-4ec5-80da-0daf500e5bde', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:33:43', '2020-04-15 06:33:43');
INSERT INTO `siswa_kelas` VALUES ('bedb04e5-c462-411a-9afd-cd4787e5aed7', 1, NULL, '3019fd4d-2bbe-41bd-abb1-6a160bb938a0', 'f170eff2-0243-4287-af83-dbcc4d55f807', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 23:24:43', '2020-04-15 23:24:43');

-- ----------------------------
-- Table structure for siswas
-- ----------------------------
DROP TABLE IF EXISTS `siswas`;
CREATE TABLE `siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_induk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('l','p') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `handphone` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telp` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `perbarui_password` datetime(0) NULL DEFAULT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siswas
-- ----------------------------
INSERT INTO `siswas` VALUES ('beea9197-493f-460a-99f4-90d22b8c7afc', '2', 'siswa 2', 'p', NULL, '2000-04-15', NULL, '', NULL, NULL, '2020-04-22 08:59:08', '99c5790d-6d71-4c61-b366-dced93461b3b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:33:43', '2020-04-22 01:59:08', NULL);
INSERT INTO `siswas` VALUES ('e32a57a4-07b6-4aec-97a9-6e55b6280ec4', '1', 'siswa 11', 'l', NULL, '2000-04-15', NULL, '', NULL, NULL, '2020-05-10 10:18:51', 'd89c4701-c03b-4c46-b664-8a4196622ac9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:33:00', '2020-05-10 03:18:51', NULL);
INSERT INTO `siswas` VALUES ('f170eff2-0243-4287-af83-dbcc4d55f807', '192019', 'Diyah Mardiana', 'p', 'Kebumen', '1994-06-20', 'Depok', 'dyahm60@gmail.com', '081212341234', NULL, NULL, '1c3e9463-fc4d-4e9b-85db-8437c9b12623', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 23:24:43', '2020-04-15 23:24:43', NULL);

-- ----------------------------
-- Table structure for soal_pertanyaan_jawabans
-- ----------------------------
DROP TABLE IF EXISTS `soal_pertanyaan_jawabans`;
CREATE TABLE `soal_pertanyaan_jawabans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `benar` tinyint(1) NOT NULL DEFAULT 0,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of soal_pertanyaan_jawabans
-- ----------------------------
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('00c9c008-5cd8-474f-9479-715b87da5946', 'b', '<p>2</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '8361f3fa-baac-46d4-bb9f-aa540c77f291', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('01757743-f86d-4271-a7b9-96158b698a7a', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '06474744-22f7-44dc-841d-3b78c84a96e2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('01b584c6-be56-4866-8c72-461a1a7a5f63', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '2bcc8209-d47d-42df-b98d-34e63b5e7bb9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:23', '2020-04-16 03:00:23', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('0205834f-1703-45a6-823d-68724a6ff1cd', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'f0fb6f85-7922-456c-b780-693d6300e60f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('029a7a49-9ee6-4ab8-9634-65d7330f1e94', 'd', '<p>4</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '0cf43e60-f65c-4323-a844-56872e5622c9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:24', '2020-04-17 04:21:24', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('0446c0b2-ff70-4d7a-9807-3d15778b3076', 'd', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '6256d2c9-58b0-4360-8c6f-71f8de74d885', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('070c7102-404b-4085-ac95-5a103eff4d08', 'b', '<p>2</p>', 1, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'b20e3489-9304-45b1-afb8-340ee5be0a7b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('07fdcb5b-861f-4c70-bb6c-d6da151d93b8', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a2ed1279-e716-44c7-b8c8-db6aa97a65ce', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('08b78597-42fd-453a-8aea-636942f28b21', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e242e287-eb14-4c9f-a868-ca7841cef8cf', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('093bc56d-8d18-4d53-b4d9-8fee3bbe4340', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '16bb8b7d-fc71-4b2a-a6e6-eec7848f3f20', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('0b63530d-02a8-47f7-b2b5-523fab3d9e4e', 'a', '<p>q</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '8aca2738-bb32-4f36-93e1-81069137e482', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('0d003bfa-6808-47dc-8e66-e85c045332e0', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '788af05f-02fe-4066-b2f6-f30f4d0e00cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('0f7b33b7-335d-4556-9810-a1e827078743', 'b', '<p>w</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '517cd024-58f4-44bb-a639-71a970c9a13e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:37', '2020-04-17 04:21:37', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('12b87654-e1a6-42c9-b1c3-2162b4395a34', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '32845fae-d89a-4087-8fda-c0aa949b8586', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('133eb022-3dff-4d3c-ba3d-3c83cef8742e', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '194d40cd-2897-4a9d-b783-dddf089945a1', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('141bb4f6-0628-4810-945a-8b9f43f6a434', 'c', '<p>d</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '3aeba248-ae98-4a78-b60f-58b2f4eadc6d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('14887d7b-6d41-497f-b53e-c54bc5b829fb', 'b', '<p>2</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'fc50f567-5db7-41a8-99c3-faeb2c4f6a49', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('14a89c2c-031d-4854-ba8e-5b1edcb51549', 'd', '<p>4</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '8361f3fa-baac-46d4-bb9f-aa540c77f291', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('165a3abe-0a99-4c97-94b7-6906b492eced', 'b', '2b', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('167d5cbc-fcd2-4eb2-bc39-ddff7612e175', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '6256d2c9-58b0-4360-8c6f-71f8de74d885', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('16df2f72-58ea-4814-8495-756b26038c24', 'e', '5e', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'da8f5923-1892-4405-baee-b070407e698b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1772b22b-465b-4cba-9ed8-a4ddede888c5', 'b', '<p>s</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7937125e-727c-4a7b-945a-4ffab2727190', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1832b29f-acab-44cf-8e25-a12985f604bc', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'f0fb6f85-7922-456c-b780-693d6300e60f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1c5fabb5-c41e-4eb9-91fd-bd8c8a337f1f', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '95ace29c-d86c-45dd-a851-d23e468298de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1da306b9-dc15-450d-87c7-23d5da46425e', 'd', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfea5b6e-05a0-41f8-a591-9a2e4e94ee4f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1dac7a39-efab-47c9-b2a9-06920b9a70ad', 'b', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '95ace29c-d86c-45dd-a851-d23e468298de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1e71a776-e3c5-4b29-af17-cae17938439e', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dc00be62-7284-43cb-baac-8583f9066bb8', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1ee2bdde-cb4f-42e7-95b1-16e1a21abd84', 'b', '1b', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'd1d6f106-9c64-405e-a7b9-75c77e3f6657', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1f55e557-f95c-4024-9bc6-cd65ec9b7537', 'b', '3b', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1fb0c51d-faa2-4978-be0b-fa7c6a5f42ea', 'a', '<p>a</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c11c5873-0ce1-4a72-90ac-b4daa352d118', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:50', '2020-04-17 04:21:50', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('1ff04cad-e199-42ba-95e4-272a3af9f91e', 'd', '<p>c</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '3aeba248-ae98-4a78-b60f-58b2f4eadc6d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('230258df-c271-49d2-af8e-ce3fdaf34be9', 'c', '<p>d</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c0db6565-9d79-4f1f-b7b4-ef3858aa95da', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:25', '2020-04-17 04:22:25', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('23cfebc1-2345-410b-bf40-d8f716696bb2', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4db75e9f-97a3-4505-aa6b-fc09df4e63c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('23d9899b-4db5-4238-b7dd-50998755f121', 'c', '3c', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('240cfaf6-ab9d-4b61-be05-270f3e07d043', 'c', '<p>d</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c11c5873-0ce1-4a72-90ac-b4daa352d118', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:50', '2020-04-17 04:21:50', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('24837136-0a1c-41dd-87ad-a88e0eeeb017', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfe6daf3-b634-4547-b260-bf8659632547', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('27838ed0-b57d-485e-850a-b8224765f693', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '6256d2c9-58b0-4360-8c6f-71f8de74d885', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('29953952-39a3-4b26-a1af-741d58ba80a8', 'd', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a2ed1279-e716-44c7-b8c8-db6aa97a65ce', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('29a70c12-8a93-47da-aed0-0edbf8ddf8cd', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'f0fb6f85-7922-456c-b780-693d6300e60f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2a920132-e4b9-441f-8945-0736813bbe53', 'b', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '8aca2738-bb32-4f36-93e1-81069137e482', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2c1bbcd2-2498-43fa-bfa2-3ed8fca399f1', 'a', '<p>q</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'd29c6c12-c31f-4f67-93e4-4e9426ed420a', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:41', '2020-04-17 04:22:41', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2c5f6c6b-7faa-4948-af04-ca6c852291e1', 'a', '<p>1</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '151c7331-49d5-46ba-9b44-52e3d1e578f3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:41', '2020-04-17 05:38:16', '2020-04-17 05:38:16');
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2ca506c1-1e58-4450-8a43-b276b2b9e210', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dc00be62-7284-43cb-baac-8583f9066bb8', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2e134959-7f9a-4bc6-abcc-0c826ab10c47', 'd', '<p>4</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', '4975b319-5b0c-4d07-9728-891a5364e24d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2f1becc7-c8e9-4735-a4a4-2b8517303f06', 'a', '<p>a</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dcdc7c7e-14ff-411c-9a09-697f51c7320d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:10', '2020-04-17 04:22:10', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2f4d0f02-4b6c-4dcc-a0b3-a97965e81f7e', 'c', '5c', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'da8f5923-1892-4405-baee-b070407e698b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('2f7df9fc-5cc6-4af5-8ced-65a66af16bec', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '30e330c3-ca27-4385-be2e-2c7bd5fb68ac', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:02', '2020-04-16 03:00:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('300f968b-63f4-472b-bc25-0064e7596197', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b3a89b67-509d-4066-b4d2-9f483543a649', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3194c7dd-be1f-437b-8367-9d104ee63ddf', 'b', '<p>2</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '19167da4-c861-40be-bf6e-c625eda5f59c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-17 05:51:33', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('34adb9b2-05cd-4631-a7f7-4c01fb9d5853', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4bdcc04b-e4a7-49aa-be57-40da71381b40', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('35a7efeb-0fc6-4fdd-9f35-0858a7d9f4c7', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '33dd2183-4ab4-4ef4-be44-64fdd61c07cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('36341356-b1df-4b8b-8921-5a8956ba5b86', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '194d40cd-2897-4a9d-b783-dddf089945a1', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('36585374-ad08-4111-9d9b-354efbb437c0', 'b', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '194d40cd-2897-4a9d-b783-dddf089945a1', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('36c9fb49-9f4a-4fd5-9ab0-dc698edfd8b9', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dc00be62-7284-43cb-baac-8583f9066bb8', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('37334b17-8a6f-47d4-a6ba-4a52640f92ce', 'b', '<p>2</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '151c7331-49d5-46ba-9b44-52e3d1e578f3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:41', '2020-04-17 05:38:16', '2020-04-17 05:38:16');
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('396d89b9-5f49-498a-93e3-ef09e94acdc6', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e242e287-eb14-4c9f-a868-ca7841cef8cf', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3bc731cb-1f1f-4f19-a880-c54a01d2e208', 'b', '<p>s</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4c0568d8-3d5b-425d-8044-2db8d6a27a70', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3c88f6e1-2ad6-4b40-b708-9735788eb8bb', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4bdcc04b-e4a7-49aa-be57-40da71381b40', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3d11949f-7b3d-4e4f-8b16-0f568fe09a4c', 'b', '<p>2</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', '0cf43e60-f65c-4323-a844-56872e5622c9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:24', '2020-04-17 04:21:24', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3e31fa75-59aa-46cd-94d3-1e1f191e917f', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3e786882-8437-419c-a5ad-d1c23a472436', 'a', '<p>q</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', '517cd024-58f4-44bb-a639-71a970c9a13e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:37', '2020-04-17 04:21:37', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3e8a61c9-c031-4989-aedf-1188ccfb1746', 'c', '<p>3</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '30e330c3-ca27-4385-be2e-2c7bd5fb68ac', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:02', '2020-04-16 03:00:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('3e98c92d-7d4e-4b69-987d-3c0410054c9e', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7d5a9eea-43a9-4a2e-ba19-cb8560105384', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('40fed0ff-6a9d-4ea3-a426-49ee7020bfe3', 'b', '<p>w</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'd29c6c12-c31f-4f67-93e4-4e9426ed420a', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:41', '2020-04-17 04:22:41', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('41377918-3ba3-4087-8fc5-24b617a3e47e', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'fc50f567-5db7-41a8-99c3-faeb2c4f6a49', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('41852a25-f500-493e-ae81-56b549a1bd89', 'a', '<p>1</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', '19167da4-c861-40be-bf6e-c625eda5f59c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-17 05:51:33', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('47b2e54c-fc0a-4551-8ba7-c676e2fb4d4e', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cf069dde-f212-4054-b54b-f9abd7f2c1d6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('48ab3825-cde9-4143-809e-8a7a2983ce3d', 'd', '4d', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '74047c04-d3ef-4b1b-a722-f7195ce9744b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('48e8b430-82ca-41a2-b196-23304e889172', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'fc50f567-5db7-41a8-99c3-faeb2c4f6a49', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('4a79d2db-8b49-4d9b-b516-5ff025e29143', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '3aeba248-ae98-4a78-b60f-58b2f4eadc6d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('4b082932-aa72-4e1e-8170-6966cc27562a', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cf069dde-f212-4054-b54b-f9abd7f2c1d6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('4d5165e4-981e-4d94-8145-ac6c1ece2749', 'b', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b3a89b67-509d-4066-b4d2-9f483543a649', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('4ec9bc7f-c482-4f82-9797-8d8755ef39bc', 'd', '<p>4</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'b20e3489-9304-45b1-afb8-340ee5be0a7b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('525c5dce-c62b-4067-bdcb-99678f352dd2', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'fc50f567-5db7-41a8-99c3-faeb2c4f6a49', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('53387461-25b5-4fbf-9883-8366951e36b0', 'd', '1d', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'd1d6f106-9c64-405e-a7b9-75c77e3f6657', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('537959c9-d2b7-43b8-8370-3af3c8352cbf', 'c', '<p>3</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'a7489df9-2be8-477d-8e08-36a5de822dd4', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5413af33-069f-49df-ace9-aaf34bcd1d03', 'b', '<p>s</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dcdc7c7e-14ff-411c-9a09-697f51c7320d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:10', '2020-04-17 04:22:10', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('546619cf-fd14-49a9-83dd-2c9ea92746a8', 'd', '<p>c</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c11c5873-0ce1-4a72-90ac-b4daa352d118', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:50', '2020-04-17 04:21:50', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('54894777-d533-4673-b893-e17dc3e38a0b', 'd', '<p>c</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7d5a9eea-43a9-4a2e-ba19-cb8560105384', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('549eac40-e4b8-49e8-9c02-7095fd1933aa', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '34582cfd-4247-4f67-adc0-b55d59c52fa9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('54cd66c9-40dd-4e46-a064-bf10e6eb62da', 'b', '<p>2</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'af113529-b6f3-4e72-9dc2-8e93424e0925', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5539da18-80f8-44e7-aa39-33d43ab3ec23', 'b', '<p>2</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1c549986-3899-439e-8284-6232501cfa5d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5590a3dc-1556-4fdb-b3e9-261b47ff9bb5', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '6256d2c9-58b0-4360-8c6f-71f8de74d885', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('55e1a622-652c-4866-9d3f-a6a898ceefaf', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfea5b6e-05a0-41f8-a591-9a2e4e94ee4f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('57d64335-7fa4-42fa-ac9a-195418524d77', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfe6daf3-b634-4547-b260-bf8659632547', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('57d7e59b-0695-468e-8c50-f1fd91803241', 'b', '<p>2</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'c132d07b-e766-4d35-94b0-289d59bb80a6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5c9d568f-5766-4066-a0f9-e0f3733a8f3b', 'd', '3d', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5dd2a8ec-620f-445d-a5d3-b730aee34a59', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4c0568d8-3d5b-425d-8044-2db8d6a27a70', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5ec25d70-e953-412d-8528-8d64cfbe949e', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '06474744-22f7-44dc-841d-3b78c84a96e2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5fd3cfd8-c344-4a3f-8265-f0e8a1ee2ecc', 'a', '<p>1</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '0cf43e60-f65c-4323-a844-56872e5622c9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:24', '2020-04-17 04:21:24', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('5fe66237-c284-43fb-917d-71a7a6796744', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1dee5b82-c82c-4f4e-bdab-3723960109b0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('610f9c70-9acd-45b2-ad5f-88d20487fc4e', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1dee5b82-c82c-4f4e-bdab-3723960109b0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6124c037-29f1-4dc4-8c6a-4f081ecf71aa', 'd', '<p>w</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c0db6565-9d79-4f1f-b7b4-ef3858aa95da', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:25', '2020-04-17 04:22:25', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('61c16b5b-c0e4-4daa-8a92-e62ed41816fe', 'b', '<p>s</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '3aeba248-ae98-4a78-b60f-58b2f4eadc6d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('61cc31d2-58b8-4951-adbe-eb7500eaba61', 'a', '<p>q</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '951a7085-1ff0-4a04-9ca5-892a23ad880b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('61e27779-655a-46f5-850a-a6290c2974f2', 'a', '<p>q</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '194d40cd-2897-4a9d-b783-dddf089945a1', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('629a1ff7-7fb9-4c89-994f-7ee7a635554a', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('672ac856-77cf-4c72-a8b2-2da9acb2586d', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '38b871a3-756e-4c0c-a349-95f050060f59', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('68f37ea5-73de-4b12-90c8-b154f1b34e7e', 'e', '4e', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '74047c04-d3ef-4b1b-a722-f7195ce9744b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('69efd5e6-31ef-4229-8b0a-13f08bd19e64', 'a', '<p>q</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '19cb1705-a3b6-4a77-9d66-3975d3b06de6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6a733b71-52e9-42f4-8439-2ee930482cc1', 'a', '<p>1</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '8361f3fa-baac-46d4-bb9f-aa540c77f291', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6af508e1-3ed8-4d59-8459-60282bf904d0', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1c549986-3899-439e-8284-6232501cfa5d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6b231de1-44d1-48d2-a163-1b132b8e328a', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'ef896f56-a27f-4eeb-9612-34d449b42011', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:52', '2020-04-22 15:48:14', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6c574a3f-48d2-4829-be39-e93ae2278448', 'd', '2d', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6d1735b3-1c09-442f-a04c-784c50417486', 'b', '<p>2</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '30e330c3-ca27-4385-be2e-2c7bd5fb68ac', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:02', '2020-04-16 03:00:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6d3c2052-2b5d-435c-8147-b768b21fe577', 'c', '<p>3</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'b20e3489-9304-45b1-afb8-340ee5be0a7b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6d67ad5d-8450-4b4b-aff7-d9494f05e70d', 'b', '<p>w</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '951a7085-1ff0-4a04-9ca5-892a23ad880b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6e32f378-9efe-425f-8308-2e519d036c62', 'd', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '788af05f-02fe-4066-b2f6-f30f4d0e00cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6e7f0bd5-0f33-493a-8351-5763a10de6c5', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '34582cfd-4247-4f67-adc0-b55d59c52fa9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6f49c7bb-d45c-4123-b973-4b5130d2f3b7', 'a', '<p>1</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'a7489df9-2be8-477d-8e08-36a5de822dd4', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('6fb6e8d4-c8d0-408e-a75f-8325f48569d8', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b04b3c54-aa3c-4d66-936c-c8452af45605', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('719dbad2-56a9-4732-a5cc-1bd1e7568c86', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cf069dde-f212-4054-b54b-f9abd7f2c1d6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('746f1bf7-85a2-4151-a0f7-1706065b7ea1', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1dee5b82-c82c-4f4e-bdab-3723960109b0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7478f32d-b2e0-4a66-a5ce-e04ef37b45ba', 'b', '<p>2</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '38b871a3-756e-4c0c-a349-95f050060f59', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7589cc2c-9d7d-49ed-8ba6-d054450ebbd5', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'c132d07b-e766-4d35-94b0-289d59bb80a6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('79d16c18-55e4-42e9-9816-67e3e2b79be6', 'c', '<p>d</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dcdc7c7e-14ff-411c-9a09-697f51c7320d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:10', '2020-04-17 04:22:10', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7a4cc65a-c6ad-4df9-ac9f-a8be9af08dcb', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7b42dc2f-036e-465d-a52b-95cab776d3cc', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '19cb1705-a3b6-4a77-9d66-3975d3b06de6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7d05e6f7-ad3f-43e9-b8d9-a4aba94f28e8', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '32845fae-d89a-4087-8fda-c0aa949b8586', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7d57f174-17dd-4393-87cc-b42b29623d72', 'b', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '16bb8b7d-fc71-4b2a-a6e6-eec7848f3f20', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7f4e2d7b-b8ee-40fd-bfc2-18b3d6af4cbb', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '151c7331-49d5-46ba-9b44-52e3d1e578f3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:41', '2020-04-17 05:38:16', '2020-04-17 05:38:16');
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('7f70a20d-89d2-4522-9892-b3d240272295', 'b', '<p>s</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7d5a9eea-43a9-4a2e-ba19-cb8560105384', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('80e72e6c-aff2-4e37-ba11-83808a55f34b', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '33dd2183-4ab4-4ef4-be44-64fdd61c07cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('82098151-758c-4647-8b4d-ba783ef1de1f', 'a', '<p>a</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c0db6565-9d79-4f1f-b7b4-ef3858aa95da', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:25', '2020-04-17 04:22:25', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('820b3396-22b1-4681-baaa-1f57672cda94', 'c', '<p>3</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '0cf43e60-f65c-4323-a844-56872e5622c9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:24', '2020-04-17 04:21:24', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('83d821f2-9375-476f-8b21-d946d59f2de6', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a3401223-abcd-4f95-a02c-bcf24960d240', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:13', '2020-04-16 03:00:13', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('844a390d-f07b-4929-b1a7-9220929d31c4', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a3401223-abcd-4f95-a02c-bcf24960d240', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:13', '2020-04-16 03:00:13', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('84971789-8612-4ed6-b6fb-31cd076fef06', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '06474744-22f7-44dc-841d-3b78c84a96e2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('84b4243d-dcc5-49c1-be46-fe19481f1d3d', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4bdcc04b-e4a7-49aa-be57-40da71381b40', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('87e297a3-3d41-4ddf-8d94-78e985960ba9', 'c', '<p>3</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '19167da4-c861-40be-bf6e-c625eda5f59c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-17 05:51:33', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('883ed6ab-6416-406f-ac48-312bf6bfe792', 'a', '<p>q</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b3a89b67-509d-4066-b4d2-9f483543a649', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('89911780-f972-4c97-8eaa-39ce6904e4b1', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '34582cfd-4247-4f67-adc0-b55d59c52fa9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('8b0bd74e-2ae3-485b-87cc-563c757dea57', 'c', '<p>3</p>', 1, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', '4975b319-5b0c-4d07-9728-891a5364e24d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('8b5b8144-5d9e-4b48-b86e-ca7ab84bc3b5', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '32845fae-d89a-4087-8fda-c0aa949b8586', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('8b6599e4-c625-4dd1-9943-75f25ee30d1c', 'a', '3a', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('8bc8de58-e8de-4414-af56-e7dc4156bfc0', 'd', '5d', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'da8f5923-1892-4405-baee-b070407e698b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('8fe77601-7da7-477b-881e-6a99aad04a22', 'c', '<p>d</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7d5a9eea-43a9-4a2e-ba19-cb8560105384', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('90e0bae4-521a-4323-a5e3-d870f0a41203', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4db75e9f-97a3-4505-aa6b-fc09df4e63c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('91c61dcd-53a4-4d7f-aa81-7817659422b0', 'b', '<p>w</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '19cb1705-a3b6-4a77-9d66-3975d3b06de6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9339d079-56bd-43a5-9760-96f090c273f7', 'c', '2c', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('937c7915-ba92-429f-a159-5e2dc552f05a', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cf069dde-f212-4054-b54b-f9abd7f2c1d6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('948aee43-2242-4003-8d0f-7cb2efd3fac3', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'c132d07b-e766-4d35-94b0-289d59bb80a6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9771601c-df3a-4306-99f3-39f509dd4f76', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '151c7331-49d5-46ba-9b44-52e3d1e578f3', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:41', '2020-04-17 05:38:16', '2020-04-17 05:38:16');
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('97ee503f-e5ac-4e55-a59e-63dae1faeeb2', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a2ed1279-e716-44c7-b8c8-db6aa97a65ce', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('984ef21a-135e-4f80-9393-229e9a9dc63f', 'b', '<p>s</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c0db6565-9d79-4f1f-b7b4-ef3858aa95da', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:25', '2020-04-17 04:22:25', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('98b77279-dac0-42a4-9934-5b2e63cd9130', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '38b871a3-756e-4c0c-a349-95f050060f59', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('99110113-c729-4340-9196-04e116b93702', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7937125e-727c-4a7b-945a-4ffab2727190', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9a9790a7-14ee-46fd-beb2-ef5aaac78f83', 'd', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dc00be62-7284-43cb-baac-8583f9066bb8', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9be83d79-44b4-42b7-b07b-bcf6424e9741', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfea5b6e-05a0-41f8-a591-9a2e4e94ee4f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9c112186-4033-47f8-8f53-0ae8baa83190', 'd', '<p>r</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'd29c6c12-c31f-4f67-93e4-4e9426ed420a', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:41', '2020-04-17 04:22:41', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9d00ffb0-34c5-40e4-9441-556c7c13b631', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '8aca2738-bb32-4f36-93e1-81069137e482', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9d373223-a29c-4200-a228-9d802a295f8f', 'b', '4b', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '74047c04-d3ef-4b1b-a722-f7195ce9744b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('9d686dff-273b-43d1-bea3-1b6681bed271', 'e', '1e', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'd1d6f106-9c64-405e-a7b9-75c77e3f6657', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a00bb263-fd6a-49c3-86a4-d69c95c88816', 'c', '4c', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '74047c04-d3ef-4b1b-a722-f7195ce9744b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a050d0be-fffb-47be-a69c-4f88d47ff288', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'ef896f56-a27f-4eeb-9612-34d449b42011', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:52', '2020-04-22 15:48:14', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a058ca69-6526-40b0-83c5-52470b4417d9', 'd', '<p>e</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dcdc7c7e-14ff-411c-9a09-697f51c7320d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:10', '2020-04-17 04:22:10', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a0882bc9-d089-4ec8-a86e-26e9ce628666', 'a', '<p>1</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'af113529-b6f3-4e72-9dc2-8e93424e0925', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a1fb8579-7747-4351-aad9-fc3ca5da173b', 'c', '<p>e</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'd29c6c12-c31f-4f67-93e4-4e9426ed420a', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:41', '2020-04-17 04:22:41', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a2ba83fe-afde-4297-921f-441a9958a26c', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '30e330c3-ca27-4385-be2e-2c7bd5fb68ac', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:02', '2020-04-16 03:00:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a4777165-545d-48ae-b9c1-48b3429011f6', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '06474744-22f7-44dc-841d-3b78c84a96e2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a7d21726-e00d-453c-ad2b-4cf19d4e229c', 'a', '<p>q</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '33dd2183-4ab4-4ef4-be44-64fdd61c07cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a7d5e97c-cfc4-4ed9-b8f1-4f012aa90cc0', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '788af05f-02fe-4066-b2f6-f30f4d0e00cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('a9b8fd59-ccfb-4b0d-ab14-c9b8e0b7ecea', 'd', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('aa9286b3-5fe4-4617-b622-e222a71eb33b', 'c', '1c', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'd1d6f106-9c64-405e-a7b9-75c77e3f6657', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ad7c17d3-ef72-47eb-9d72-4be49b327489', 'b', '<p>2</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '2bcc8209-d47d-42df-b98d-34e63b5e7bb9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:23', '2020-04-16 03:00:23', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ae306378-5d91-4bcc-9d66-ca834538265d', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '16bb8b7d-fc71-4b2a-a6e6-eec7848f3f20', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('aec4c838-c02b-42f4-8138-df90b22ae3a9', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfea5b6e-05a0-41f8-a591-9a2e4e94ee4f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b05818c4-e65e-4a02-8797-29e146680622', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b1141910-2704-4434-8db9-c1341e682b37', 'd', '<p>4</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a3401223-abcd-4f95-a02c-bcf24960d240', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:13', '2020-04-16 03:00:13', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b11dc546-aebd-4078-a1b6-9f444580acd8', 'b', '<p>2</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a3401223-abcd-4f95-a02c-bcf24960d240', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:13', '2020-04-16 03:00:13', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b1318a17-ee11-40fb-95d9-b981f3378e2c', 'c', '<p>d</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7937125e-727c-4a7b-945a-4ffab2727190', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b4125962-22a0-4954-ad63-4d573c771e5b', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b4c41ac2-d4e5-456d-9014-b787d77520e5', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'ef896f56-a27f-4eeb-9612-34d449b42011', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:52', '2020-04-22 15:48:14', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b611ea0c-af9e-40a9-9cdb-83b77121b388', 'd', '<p>4</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '19167da4-c861-40be-bf6e-c625eda5f59c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-17 05:51:33', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b665b1f9-6973-428a-a51b-b2ba3bef167d', 'e', '3e', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b77616e5-ebe8-4b36-ac42-2168425dc30f', 'd', '<p>c</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4c0568d8-3d5b-425d-8044-2db8d6a27a70', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b86e2ca3-340f-4a93-aff0-d56ae4f249fe', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1c549986-3899-439e-8284-6232501cfa5d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('b95ab9a6-0440-4407-b99f-89adab7b4d98', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b04b3c54-aa3c-4d66-936c-c8452af45605', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ba1297d6-2c61-42d4-a961-213ff7ff6aa8', 'a', '<p>1</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'b20e3489-9304-45b1-afb8-340ee5be0a7b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bac101c8-daea-4c20-90d3-79e4dba3ff11', 'a', '4a', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '74047c04-d3ef-4b1b-a722-f7195ce9744b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bacf2f0b-5123-4884-85a5-a3db80e1e1c9', 'b', '<p>2</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'a7489df9-2be8-477d-8e08-36a5de822dd4', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bae3a8c9-6799-4cb2-85fa-407d9cc42b06', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b04b3c54-aa3c-4d66-936c-c8452af45605', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bb3a58e0-502b-4393-b5db-02051f9a574b', 'b', '<p>2</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', '4975b319-5b0c-4d07-9728-891a5364e24d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bc6b502f-572a-4521-a9b6-8785830ecc4e', 'c', '<p>d</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4c0568d8-3d5b-425d-8044-2db8d6a27a70', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bd88d86e-f6c5-457a-9a98-a78aff9a12d3', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '38b871a3-756e-4c0c-a349-95f050060f59', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('be56aa26-2e2e-4936-abef-78029bc561a9', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'f0fb6f85-7922-456c-b780-693d6300e60f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bf52f636-a63d-4150-9e21-7ab7a092755c', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '8aca2738-bb32-4f36-93e1-81069137e482', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('bf742a56-7974-4e46-91e0-2282104f98dc', 'b', '<p>2</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'ef896f56-a27f-4eeb-9612-34d449b42011', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:52', '2020-04-22 15:48:14', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c0960b1a-cf98-4928-92ae-e55427d45739', 'a', '<p>q</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfe6daf3-b634-4547-b260-bf8659632547', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c18c7244-ba27-4b84-a744-c149014a1550', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '951a7085-1ff0-4a04-9ca5-892a23ad880b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c22826a1-426c-4727-a573-ffceca05955d', 'a', '1a', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'd1d6f106-9c64-405e-a7b9-75c77e3f6657', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c2ce865e-cb4b-4db9-b134-aa2219ed7aed', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '32845fae-d89a-4087-8fda-c0aa949b8586', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c5d19dda-1f84-477f-a76c-399fea234d3b', 'a', '<p>1</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '2bcc8209-d47d-42df-b98d-34e63b5e7bb9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:23', '2020-04-16 03:00:23', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c6345812-b6ed-4f41-96de-56b2223eb43d', 'd', '<p>c</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '7937125e-727c-4a7b-945a-4ffab2727190', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c855531f-dc7d-41f2-a3ec-d7c5655f3a62', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '34582cfd-4247-4f67-adc0-b55d59c52fa9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c8d1fbff-a0a4-4a36-a431-272dc6b4a8d5', 'd', '<p>4</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', 'a7489df9-2be8-477d-8e08-36a5de822dd4', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('c9f64dcc-6bc0-4978-a747-287ac2529f27', 'd', '<p>4</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'af113529-b6f3-4e72-9dc2-8e93424e0925', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('cd7c3850-fbb3-4389-b4a1-daf4107d81e3', 'a', '5a', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'da8f5923-1892-4405-baee-b070407e698b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('cd8a53c2-ab06-49c1-9486-7aa8c642c738', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ce5c1a72-add1-4042-aeee-103636b7d2b6', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b04b3c54-aa3c-4d66-936c-c8452af45605', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ce8221d7-9e45-4ea3-8159-a4ba1908f04e', 'e', '2e', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('cfe263db-269a-49da-9ed6-e974d024ef6e', 'b', '<p>w</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cfe6daf3-b634-4547-b260-bf8659632547', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('cff34e60-b8fa-46a9-8b73-b3af89dd4c81', 'c', '<p>3</p>', 1, '578ed726-f775-4e4b-ab41-2a1c83981325', '8361f3fa-baac-46d4-bb9f-aa540c77f291', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d02c163d-bab4-42ea-9f64-633928476e09', 'c', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '16bb8b7d-fc71-4b2a-a6e6-eec7848f3f20', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d1960960-1e81-4822-947d-5737aba78838', 'd', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e242e287-eb14-4c9f-a868-ca7841cef8cf', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d27a244e-e36c-4c9c-9cdb-9262f265167e', 'c', '<p>3</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '2bcc8209-d47d-42df-b98d-34e63b5e7bb9', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:23', '2020-04-16 03:00:23', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d3ab5f9a-2bea-40d5-a200-ce3491275542', 'c', '<p>3</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'af113529-b6f3-4e72-9dc2-8e93424e0925', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d4bd71d9-b880-4970-856b-edc3924e2cb2', 'd', '<p>w</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4db75e9f-97a3-4505-aa6b-fc09df4e63c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('d908e51d-419c-495b-a87f-43c303c823ea', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '95ace29c-d86c-45dd-a851-d23e468298de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('dc18ccb6-5a1f-425d-8415-08f02b4b3d37', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '951a7085-1ff0-4a04-9ca5-892a23ad880b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e0251e06-b44a-4078-b116-375ede8e5d73', 'c', '<p>e</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '517cd024-58f4-44bb-a639-71a970c9a13e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:37', '2020-04-17 04:21:37', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e21b7fc1-af09-414c-96e5-ede3fd390c15', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4db75e9f-97a3-4505-aa6b-fc09df4e63c2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e337957a-0f02-4994-844e-b647abf86005', 'd', '<p>4</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1c549986-3899-439e-8284-6232501cfa5d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e3e7f048-ab2a-4f32-948a-b0f35fa8c17a', 'd', '<p>r</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', '517cd024-58f4-44bb-a639-71a970c9a13e', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:37', '2020-04-17 04:21:37', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e530e9df-0346-4fce-b7a5-eae8d05007ba', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e242e287-eb14-4c9f-a868-ca7841cef8cf', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e7293734-f0c1-4472-83ef-baf88cd1e7d5', 'd', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '1dee5b82-c82c-4f4e-bdab-3723960109b0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:56', '2020-04-17 15:41:56', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e8ce8d01-df53-4fb5-988c-add3e6bb4b0b', 'c', '<p>3</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'c132d07b-e766-4d35-94b0-289d59bb80a6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:31:36', '2020-04-17 15:31:36', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('e9fc60f3-d36d-47bc-90ee-d43bc0d6dd72', 'a', '2a', 0, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', '8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('ee2ecc4b-62e2-4dee-841b-ff161e664d34', 'a', '<p>q</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '95ace29c-d86c-45dd-a851-d23e468298de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f0ce24da-5e97-428c-8ed8-f9d686e6c23c', 'c', '<p>e</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'b3a89b67-509d-4066-b4d2-9f483543a649', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f1f8a65e-4028-44fa-bbd7-1976976d5258', 'a', '<p>a</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f3277fe3-f826-4853-ba6c-43e005f78f52', 'b', '<p>s</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a2ed1279-e716-44c7-b8c8-db6aa97a65ce', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f3303aaa-72ca-433a-a258-ab96c6cfccbc', 'b', '5b', 1, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'da8f5923-1892-4405-baee-b070407e698b', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:34:02', '2020-05-05 17:34:02', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f41781b0-587d-4ac0-b720-36d7c9e4dc2d', 'd', '<p>r</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '19cb1705-a3b6-4a77-9d66-3975d3b06de6', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f85c4701-c09e-4d18-b329-80f0f33abfad', 'a', '<p>1</p>', 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', '4975b319-5b0c-4d07-9728-891a5364e24d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('f873a0d8-50eb-470b-9765-f7926c86c2f4', 'c', '<p>d</p>', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '788af05f-02fe-4066-b2f6-f30f4d0e00cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:41:21', '2020-04-17 15:41:21', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('fa955eff-9036-4855-99b2-3f0387a1d045', 'b', '<p>w</p>', 1, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '33dd2183-4ab4-4ef4-be44-64fdd61c07cb', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:34:51', '2020-04-17 15:34:51', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('fbafc704-274a-4d55-b8ee-62e551247494', 'a', '-', 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4bdcc04b-e4a7-49aa-be57-40da71381b40', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaan_jawabans` VALUES ('fe8f6753-f9b4-43e2-9595-726dc72cea4e', 'b', '<p>s</p>', 0, '578ed726-f775-4e4b-ab41-2a1c83981325', 'c11c5873-0ce1-4a72-90ac-b4daa352d118', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:50', '2020-04-17 04:21:50', NULL);

-- ----------------------------
-- Table structure for soal_pertanyaans
-- ----------------------------
DROP TABLE IF EXISTS `soal_pertanyaans`;
CREATE TABLE `soal_pertanyaans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_jawaban` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of soal_pertanyaans
-- ----------------------------
INSERT INTO `soal_pertanyaans` VALUES ('04b73df5-4d57-4950-ae48-126701d2187e', '20', '<p>es 5</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:27:24', '2020-04-17 15:27:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('06474744-22f7-44dc-841d-3b78c84a96e2', '15', '<p>es 4</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('0cf43e60-f65c-4323-a844-56872e5622c9', '5', '<p>copy pg5</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:24', '2020-04-17 04:21:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('151c7331-49d5-46ba-9b44-52e3d1e578f3', '1', '<p>pg 1</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:41', '2020-04-17 05:38:16', '2020-04-17 07:50:38');
INSERT INTO `soal_pertanyaans` VALUES ('19167da4-c861-40be-bf6e-c625eda5f59c', '1', '<p>pg 1</p>\n<p><img src=\"../../../uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/soal_pertanyaan/rooti_20200416-071103.jpeg\" alt=\"\" width=\"100\" height=\"63\" /></p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-17 05:51:33', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('194d40cd-2897-4a9d-b783-dddf089945a1', '7', '<p>copy pg 6</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('196015a7-4a90-41c9-ba7a-bbc9f9ea6f8b', '8', '<p>copy es 8</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:42', '2020-04-17 04:23:42', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('19cb1705-a3b6-4a77-9d66-3975d3b06de6', '11', '<p>copy pg 10</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('1c50801c-7366-44db-bf19-287cd46aff56', '2', '<p>es 2</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 06:13:46', '2020-04-16 06:13:46', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('1f6136ab-8ec2-45a1-8cde-ba3d7c266c3a', '1', '<p>es 1</p>\n<p><img src=\"http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/tinymce/l0fIDOf30v.jpeg\" alt=\"\" width=\"100\" height=\"63\" /></p>\n<p><img src=\"http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/tinymce/F113Ve9eAj.png\" width=\"100\" height=\"50\" /></p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:44:40', '2020-04-22 15:40:21', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('1fae6aa9-953c-43d9-a0d5-66a26824932a', '1', '<p>es 1</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 06:13:46', '2020-04-16 06:13:46', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('20e88a07-492a-44d3-a9e7-14c7f8c6afc6', '10', '<p>copy es 10</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:52', '2020-04-17 04:23:52', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('21d60253-2835-47bd-9858-176b992b5789', '6', '<p>copy es 6</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', '14', '<p>es 3</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('2bcc8209-d47d-42df-b98d-34e63b5e7bb9', '5', '<p>pg 5</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:23', '2020-04-16 03:00:23', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('2e118112-b250-40d3-8a66-87b1f976ae18', '2', '<p>es 2</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:44:40', '2020-04-17 07:44:40', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('30e330c3-ca27-4385-be2e-2c7bd5fb68ac', '3', '<p>pg 3</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:02', '2020-04-16 03:00:02', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('3aeba248-ae98-4a78-b60f-58b2f4eadc6d', '8', '<p>copy pg 7</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('4396a3de-6583-406a-92ed-e1db8bc23a1e', '4', '<p>copy es 4</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:12', '2020-04-17 04:23:12', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('46ce13b7-5a6e-4b40-9a4d-8f55e01668d6', '19', '<p>es 4</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:27:24', '2020-04-17 15:27:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('4851001b-11b6-4cb3-8b09-c715105e4afe', '2', '<p>es 2</p>', 'es', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:16:54', '2020-04-16 03:16:54', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('48784834-600f-4373-81f4-880604fb9f54', '3', '<p>es 3</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 06:13:46', '2020-04-16 06:13:46', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('4975b319-5b0c-4d07-9728-891a5364e24d', '2', '<p>pg 3</p>', 'pg', NULL, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('4bdcc04b-e4a7-49aa-be57-40da71381b40', '16', '<p>es 5</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('4e073205-e5bf-4b74-b43f-1463cec88575', '21', '<p><img src=\"http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/tinymce/29JkxexQ0v.jpeg\" alt=\"\" width=\"200\" height=\"105\" /></p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 15:45:18', '2020-04-22 15:45:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('517cd024-58f4-44bb-a639-71a970c9a13e', '6', '<p>copy pg 6</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:37', '2020-04-17 04:21:37', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('51d240e1-29ab-4f7c-8cd1-07d1476ef8c2', '3', 'c', 'pg', NULL, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:36', '2020-05-05 17:31:36', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('5e2a0acc-9565-4007-9bcc-707315dd3b80', '9', '<p>copy es 9</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('74047c04-d3ef-4b1b-a722-f7195ce9744b', '4', 'd', 'pg', NULL, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:36', '2020-05-05 17:31:36', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('8361f3fa-baac-46d4-bb9f-aa540c77f291', '3', '<p>pg 3</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('8cc901d7-afa4-4bb8-9649-1bf3a91f8b67', '2', 'b', 'pg', NULL, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:36', '2020-05-05 17:31:36', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('96ad4f9c-d757-452a-8bd3-be3773f04843', '1', '<p>es 1</p>', 'es', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:16:45', '2020-04-16 03:16:45', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('9824293a-898e-40b5-bb17-82eabd6c8970', '10', '<p>copy es 10</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('9df3b522-b721-4048-bfb2-51cbbab40bca', '12', '<p>es 4</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:57', '2020-04-17 15:25:57', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('a2ed1279-e716-44c7-b8c8-db6aa97a65ce', '9', '<p>copy pg 8</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('a3401223-abcd-4f95-a02c-bcf24960d240', '4', '<p>pg 4</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:00:13', '2020-04-16 03:00:13', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('a7489df9-2be8-477d-8e08-36a5de822dd4', '4', '<p>pg 4</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('a76af5d1-4117-4cd5-9243-06673b5d2500', '5', '<p>copy es 5</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('af113529-b6f3-4e72-9dc2-8e93424e0925', '2', '<p>pg 2</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:06', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('b20e3489-9304-45b1-afb8-340ee5be0a7b', '1', '<p>pg 2</p>', 'pg', NULL, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('b36b4ca2-b281-4926-a938-31e3dc96b195', '4', '<p>copy es 4</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('b70a1ad1-ce49-4a7f-bfef-6cd42b3e600c', '5', '<p>es 5</p>', 'es', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:18:52', '2020-04-16 03:18:52', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('b9727f5c-b1bf-4a89-850e-e2d0e05129aa', '13', '<p>es 5</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:57', '2020-04-17 15:25:57', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', '10', '<p>copy pg 9</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('c0cfbde1-d63c-4060-be6c-b56b4ffb015d', '9', '<p>copy es 9</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:47', '2020-04-17 04:23:47', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('c0db6565-9d79-4f1f-b7b4-ef3858aa95da', '9', '<p>copy pg 9</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:25', '2020-04-17 04:22:25', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('c11c5873-0ce1-4a72-90ac-b4daa352d118', '7', '<p>copy pg 7</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:21:49', '2020-04-17 04:21:49', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('c839228a-2208-433a-8804-06f1a65c7c61', '5', '<p>copy es 5</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:19', '2020-04-17 04:23:19', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('c9621ea3-dfc7-4acb-93cb-6ae6bfb8ec53', '3', '<p>es 3</p>', 'es', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:16:58', '2020-04-16 03:16:58', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('cf069dde-f212-4054-b54b-f9abd7f2c1d6', '12', '<p>es 1</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('d1d6f106-9c64-405e-a7b9-75c77e3f6657', '1', 'a', 'pg', NULL, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:36', '2020-05-05 17:31:36', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('d29c6c12-c31f-4f67-93e4-4e9426ed420a', '10', '<p>copy pg 10</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:41', '2020-04-17 04:22:41', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('da8f5923-1892-4405-baee-b070407e698b', '5', 'e', 'pg', NULL, 'ff81c453-1c7d-4c5f-9efa-3645063de35d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:36', '2020-05-05 17:31:36', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('dcdc7c7e-14ff-411c-9a09-697f51c7320d', '8', '<p>copy pg 8</p>', 'pg', NULL, '578ed726-f775-4e4b-ab41-2a1c83981325', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:22:09', '2020-04-17 04:22:09', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('dfe814dc-ecc3-42b2-a26f-51e278cf9a2f', '4', '<p>es 4</p>', 'es', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:18:41', '2020-04-16 03:18:41', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('e0aa3f12-896e-4d59-afaa-d8f8e3e53e73', '6', '<p>copy es 6</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:27', '2020-04-17 04:23:27', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('e143d479-0c53-428c-a920-1ac20bd0cc4c', '8', '<p>copy es 8</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('e5ed230e-a661-4409-a239-e955727a6a76', '7', '<p>copy es 7</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:16', '2020-04-17 15:25:16', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('e66fc4ab-8d34-4658-a260-75316971a617', '11', '<p>es 3</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:25:57', '2020-04-17 15:25:57', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('ec848da7-d942-48b8-b98f-c8c86389767c', '17', '<p>es 2</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:27:24', '2020-04-17 15:27:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('ee0ed903-ae87-4c95-a7d3-5cbce3247196', '18', '<p>es 3</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:27:24', '2020-04-17 15:27:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('ef896f56-a27f-4eeb-9612-34d449b42011', '2', '<p><img src=\"http://localhost/elearning-new/uploads/files/dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6/image/tinymce/DVjn7GrL9d.jpeg\" alt=\"\" width=\"865\" height=\"606\" />pg 2</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:52', '2020-04-22 15:48:14', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('efbc9132-ae42-46e9-944c-4b6a877a014c', '7', '<p>copy es 7</p>', 'es', NULL, '4334a84d-5f99-4404-a8c4-2f272c517a9c', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 04:23:33', '2020-04-17 04:23:33', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('f0fb6f85-7922-456c-b780-693d6300e60f', '13', '<p>es 2</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:48:35', '2020-04-17 15:48:35', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('f15bd451-ac58-43cb-8c2e-7ffa16fa550c', '16', '<p>es 1</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:27:24', '2020-04-17 15:27:24', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('f5b6b5cc-48f7-494c-888b-7b3d48fe57ee', '14', '<p>pg 2</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:26:31', '2020-04-17 15:26:31', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('f7c206c1-47ca-4899-a284-e2f19b09827d', '15', '<p>pg 3</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:26:31', '2020-04-17 15:26:31', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('fc50f567-5db7-41a8-99c3-faeb2c4f6a49', '6', '<p>copy pg5</p>', 'pg', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 15:47:18', '2020-04-17 15:47:18', NULL);
INSERT INTO `soal_pertanyaans` VALUES ('fd38c4f5-da99-4303-ad53-e1c9a653500e', '3', '<p>es 3</p>', 'es', NULL, '9b59b921-4ffe-47f5-bd4f-f7deef084293', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:44:40', '2020-04-17 07:44:40', NULL);

-- ----------------------------
-- Table structure for soals
-- ----------------------------
DROP TABLE IF EXISTS `soals`;
CREATE TABLE `soals`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruksi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipe` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_pilihan_ganda` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rumus_penilaian_ujian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of soals
-- ----------------------------
INSERT INTO `soals` VALUES ('3e9964f1-6d96-413c-98ba-d2b551d18120', 'pusing', '<p>asd</p>', 'es', NULL, 0, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', '171e0f68-478f-436d-bce8-caebf32b175e', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 03:16:21', '2020-04-16 03:16:21', NULL);
INSERT INTO `soals` VALUES ('4334a84d-5f99-4404-a8c4-2f272c517a9c', 'pusing banget', '<p>test copy soal</p>', 'es', NULL, 0, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', '171e0f68-478f-436d-bce8-caebf32b175e', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 06:13:45', '2020-04-16 06:13:45', NULL);
INSERT INTO `soals` VALUES ('578ed726-f775-4e4b-ab41-2a1c83981325', 'mengarang biji copy', '<p>test pg copy</p>', 'pg', 'a-d', 0, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', '2b55b11e-6fae-4256-9661-a31b2e7f5785', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 07:19:06', '2020-04-16 07:19:44', NULL);
INSERT INTO `soals` VALUES ('9b59b921-4ffe-47f5-bd4f-f7deef084293', 'pusing ok', '<p>asdadasdad</p>', 'es', NULL, 0, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', '171e0f68-478f-436d-bce8-caebf32b175e', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:44:40', '2020-04-17 07:44:40', NULL);
INSERT INTO `soals` VALUES ('cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'mengarang ok', '<p>test</p>', 'pg', 'a-d', 0, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', '2b55b11e-6fae-4256-9661-a31b2e7f5785', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-17 07:49:49', '2020-04-17 07:49:49', NULL);
INSERT INTO `soals` VALUES ('cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'mengarang biji', '<p>test</p>', 'pg', 'a-d', 0, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', '2b55b11e-6fae-4256-9661-a31b2e7f5785', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-16 02:59:19', '2020-04-16 02:59:19', NULL);
INSERT INTO `soals` VALUES ('ff81c453-1c7d-4c5f-9efa-3645063de35d', '123', '<p>asd</p>', 'pg', 'a-e', 0, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', '2b55b11e-6fae-4256-9661-a31b2e7f5785', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'a072bc4a-f066-4432-88e8-071341ca4c5c', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 17:31:13', '2020-05-05 17:31:13', NULL);

-- ----------------------------
-- Table structure for tahun_ajaran_jadwals
-- ----------------------------
DROP TABLE IF EXISTS `tahun_ajaran_jadwals`;
CREATE TABLE `tahun_ajaran_jadwals`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tahun_ajaran_jadwals
-- ----------------------------
INSERT INTO `tahun_ajaran_jadwals` VALUES ('10f48eaf-ea22-4fea-a162-7f8372e55d5f', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'ab70ca01-b01b-4642-9601-269342ea82de', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:14:27', '2020-04-15 06:14:27', NULL);
INSERT INTO `tahun_ajaran_jadwals` VALUES ('79455041-d878-43b9-b5c6-f95a958fff68', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'ab70ca01-b01b-4642-9601-269342ea82de', '3019fd4d-2bbe-41bd-abb1-6a160bb938a0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:14:42', '2020-04-15 06:14:42', NULL);
INSERT INTO `tahun_ajaran_jadwals` VALUES ('ad67bf9c-9902-4cbe-b23c-50060c81e03f', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '28808e8a-7181-4292-a9f7-a55982f59df1', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:14:27', '2020-04-15 06:14:27', NULL);
INSERT INTO `tahun_ajaran_jadwals` VALUES ('b336d5ba-8c28-43b4-ac8c-f5e6d16d098e', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '3d6a76cf-61c5-4631-89a7-30405c7c85e1', 'ab70ca01-b01b-4642-9601-269342ea82de', '3019fd4d-2bbe-41bd-abb1-6a160bb938a0', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:15:07', '2020-04-15 06:15:07', NULL);

-- ----------------------------
-- Table structure for tahun_ajarans
-- ----------------------------
DROP TABLE IF EXISTS `tahun_ajarans`;
CREATE TABLE `tahun_ajarans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_awal` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_akhir` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merge_periode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tahun_ajarans
-- ----------------------------
INSERT INTO `tahun_ajarans` VALUES ('3019fd4d-2bbe-41bd-abb1-6a160bb938a0', '2020', '2021', '2020-2021', 'genap', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:14:41', '2020-04-15 06:14:41', NULL);
INSERT INTO `tahun_ajarans` VALUES ('760cdd93-a857-4ec5-80da-0daf500e5bde', '2020', '2021', '2020-2021', 'ganjil', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-15 06:14:27', '2020-04-15 06:14:27', NULL);

-- ----------------------------
-- Table structure for ujian_harian_hasils
-- ----------------------------
DROP TABLE IF EXISTS `ujian_harian_hasils`;
CREATE TABLE `ujian_harian_hasils`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  `nilai` int(11) NULL DEFAULT NULL,
  `total_pertanyaan` int(11) NOT NULL,
  `total_benar` int(11) NULL DEFAULT NULL,
  `total_salah` int(11) NULL DEFAULT NULL,
  `pertanyaan_dijawab` int(11) NOT NULL,
  `pertanyaan_tidak_dijawab` int(11) NOT NULL,
  `pertanyaan_dijawab_ragu` int(11) NOT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ujian_harian_hasils
-- ----------------------------
INSERT INTO `ujian_harian_hasils` VALUES ('09169d6d-7d9b-46fb-9b02-fe1f13ae5b8a', '2020-05-05 23:56:37', NULL, 50, 2, 1, 1, 2, 0, 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'f11fd581-adac-4c81-9be9-6ed5623ca904', 'c5f1ca79-eccb-4fee-ac3e-ad02766a8d7d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:56:37', '2020-05-05 16:56:37', NULL);
INSERT INTO `ujian_harian_hasils` VALUES ('57389f68-1339-4f2d-8076-c6422d9d233b', '2020-04-22 20:57:32', NULL, 7, 15, 1, 14, 2, 11, 2, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_hasils` VALUES ('fb69a982-5d6f-47fe-81ea-c7c7dfd641d1', '2020-04-22 21:36:51', NULL, 160, 5, 4, 1, 2, 1, 2, '3e9964f1-6d96-413c-98ba-d2b551d18120', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', NULL, '2020-04-22 14:39:35', NULL);

-- ----------------------------
-- Table structure for ujian_harian_jawaban_siswas
-- ----------------------------
DROP TABLE IF EXISTS `ujian_harian_jawaban_siswas`;
CREATE TABLE `ujian_harian_jawaban_siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `tipe` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_jawaban_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ujian_harian_jawaban_siswas
-- ----------------------------
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('143a1ce7-62ce-4b9c-a843-21b24350866b', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '19cb1705-a3b6-4a77-9d66-3975d3b06de6', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('1948fecd-4162-4844-b5f5-34108e9ba708', '2020-04-22 21:36:50', 'ok', '<p>1</p>', '3e9964f1-6d96-413c-98ba-d2b551d18120', '96ad4f9c-d757-452a-8bd3-be3773f04843', NULL, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:36:50', '2020-04-22 14:36:50', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('2525efd4-5d69-420a-85b0-82866e459d8b', '2020-05-05 23:56:36', 'ok', NULL, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', '4975b319-5b0c-4d07-9728-891a5364e24d', 'bb3a58e0-502b-4393-b5db-02051f9a574b', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'f11fd581-adac-4c81-9be9-6ed5623ca904', 'c5f1ca79-eccb-4fee-ac3e-ad02766a8d7d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:56:36', '2020-05-05 16:56:36', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('3f19a75b-6613-4b98-9127-e37405288f2f', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '30e330c3-ca27-4385-be2e-2c7bd5fb68ac', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('451d8d03-3b25-43d5-a4a2-2bad8d2e363f', '2020-04-22 20:57:31', 'ok', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '2bcc8209-d47d-42df-b98d-34e63b5e7bb9', 'd27a244e-e36c-4c9c-9cdb-9262f265167e', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:31', '2020-04-22 13:57:31', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('52423bd9-5b66-42a4-863b-7e533a3d9a8c', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '194d40cd-2897-4a9d-b783-dddf089945a1', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('593d9680-c20c-4c4d-a1ab-0f81b57b5c99', '2020-04-22 21:36:50', 'ok', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', 'dfe814dc-ecc3-42b2-a26f-51e278cf9a2f', NULL, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:36:50', '2020-04-22 14:36:50', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('5e28050e-9ce9-454c-964f-a3e7734a5ffc', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'bbca58a1-eabe-4ad7-a78e-f1dd7d7030de', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('621c02ba-334a-434c-a852-8fa9baf92ae7', '2020-04-22 20:57:32', 'ok', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '4bdcc04b-e4a7-49aa-be57-40da71381b40', '34adb9b2-05cd-4631-a7f7-4c01fb9d5853', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('69be6c2b-b7d1-40c0-8a6e-58f0cb0c14da', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'f0fb6f85-7922-456c-b780-693d6300e60f', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('6bb11491-4396-44f9-99cb-f93877b3e578', '2020-04-22 21:36:50', 'tdk', NULL, '3e9964f1-6d96-413c-98ba-d2b551d18120', '4851001b-11b6-4cb3-8b09-c715105e4afe', NULL, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:36:50', '2020-04-22 14:36:50', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('868b5cf2-e81f-4753-9698-0ecdd347e835', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'fc50f567-5db7-41a8-99c3-faeb2c4f6a49', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('98644391-3c40-4914-97cd-3b2cc0375dcc', '2020-04-22 20:57:32', 'ragu', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '06474744-22f7-44dc-841d-3b78c84a96e2', '01757743-f86d-4271-a7b9-96158b698a7a', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('999bea8b-416d-4a04-b8fe-163c0407b260', '2020-04-22 20:57:32', 'ragu', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'cf069dde-f212-4054-b54b-f9abd7f2c1d6', '47b2e54c-fc0a-4551-8ba7-c676e2fb4d4e', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('aad74fdf-4a47-464a-a751-ad703f24fef6', '2020-04-22 21:36:50', 'ragu', '<p>1</p>', '3e9964f1-6d96-413c-98ba-d2b551d18120', 'b70a1ad1-ce49-4a7f-bfef-6cd42b3e600c', NULL, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:36:50', '2020-04-22 14:36:50', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('be7586d0-df6d-46de-8912-ce0bf56f8f9b', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a2ed1279-e716-44c7-b8c8-db6aa97a65ce', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('cd634b04-e29e-4aa4-abcd-b4427bb96d31', '2020-04-22 21:36:50', 'ragu', '<p>3</p>', '3e9964f1-6d96-413c-98ba-d2b551d18120', 'c9621ea3-dfc7-4acb-93cb-6ae6bfb8ec53', NULL, '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', '9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:36:50', '2020-04-22 14:36:50', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('e47f29f4-1e32-4a54-91e6-a0ff3c0b7805', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'ef896f56-a27f-4eeb-9612-34d449b42011', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('f0324af5-e4b6-4827-8097-2be914c192ac', '2020-05-05 23:56:36', 'ok', NULL, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'b20e3489-9304-45b1-afb8-340ee5be0a7b', '070c7102-404b-4085-ac95-5a103eff4d08', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'f11fd581-adac-4c81-9be9-6ed5623ca904', 'c5f1ca79-eccb-4fee-ac3e-ad02766a8d7d', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:56:36', '2020-05-05 16:56:36', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('f9ec90a9-73fa-4d96-a491-86b61d40e0a9', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'a3401223-abcd-4f95-a02c-bcf24960d240', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('fa7c7be2-9e43-4243-b6f2-6c080299576c', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '3aeba248-ae98-4a78-b60f-58b2f4eadc6d', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_jawaban_siswas` VALUES ('fc9615b5-77e0-4c74-a9fa-45f3cf483db9', '2020-04-22 20:57:32', 'tdk', NULL, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', '22bd8a77-bbba-49d3-95b3-3d1c0c2d4f9e', NULL, 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', '9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 13:57:32', '2020-04-22 13:57:32', NULL);

-- ----------------------------
-- Table structure for ujian_harian_siswas
-- ----------------------------
DROP TABLE IF EXISTS `ujian_harian_siswas`;
CREATE TABLE `ujian_harian_siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `tahun_ajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_harian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ujian_harian_siswas
-- ----------------------------
INSERT INTO `ujian_harian_siswas` VALUES ('9dd09357-d4c4-450d-a6dc-5d1016cd4fcd', 'FN', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'beea9197-493f-460a-99f4-90d22b8c7afc', '07aa84e5-04f3-44a5-a48a-b1f523498f89', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 00:18:21', '2020-04-22 13:57:32', NULL);
INSERT INTO `ujian_harian_siswas` VALUES ('9df1a3ae-8dcb-4f14-87d2-5ff7424f00d2', 'FN', '760cdd93-a857-4ec5-80da-0daf500e5bde', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '3e9964f1-6d96-413c-98ba-d2b551d18120', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:27:40', '2020-04-22 14:36:51', NULL);
INSERT INTO `ujian_harian_siswas` VALUES ('9f681452-ce32-4400-9cb0-a85f53ba28f2', 'BR', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', '07aa84e5-04f3-44a5-a48a-b1f523498f89', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 00:18:21', '2020-04-22 00:18:21', NULL);
INSERT INTO `ujian_harian_siswas` VALUES ('afd41902-522b-46d6-a244-563677822e24', 'BR', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'beea9197-493f-460a-99f4-90d22b8c7afc', 'f11fd581-adac-4c81-9be9-6ed5623ca904', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:50:43', '2020-05-05 16:50:43', NULL);
INSERT INTO `ujian_harian_siswas` VALUES ('c5f1ca79-eccb-4fee-ac3e-ad02766a8d7d', 'FN', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'f11fd581-adac-4c81-9be9-6ed5623ca904', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:50:43', '2020-05-05 16:56:37', NULL);
INSERT INTO `ujian_harian_siswas` VALUES ('dc742af0-56d9-46fe-b085-636f92c8ad56', 'BR', '760cdd93-a857-4ec5-80da-0daf500e5bde', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '3e9964f1-6d96-413c-98ba-d2b551d18120', 'e32a57a4-07b6-4aec-97a9-6e55b6280ec4', 'f6e4547e-82c6-48f6-a1c9-d975f6a02821', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:27:40', '2020-04-22 14:27:40', NULL);

-- ----------------------------
-- Table structure for ujian_harians
-- ----------------------------
DROP TABLE IF EXISTS `ujian_harians`;
CREATE TABLE `ujian_harians`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_habis` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_waktu_pengerjaan` int(11) NOT NULL,
  `tampilkan_nilai` tinyint(1) NULL DEFAULT 0,
  `alert_simpan_jawaban` tinyint(1) NOT NULL DEFAULT 0,
  `batas_kelulusan` int(11) NULL DEFAULT NULL,
  `pertanyaan_acak` tinyint(1) NOT NULL DEFAULT 0,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_ujian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rumus_penilaian_ujian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ujian_harians
-- ----------------------------
INSERT INTO `ujian_harians` VALUES ('07aa84e5-04f3-44a5-a48a-b1f523498f89', NULL, '2020-04-22', '20:00', '20:58', 90, 0, 10, NULL, 0, 'cd5757d5-2371-4c92-8cc6-c6ec131df08f', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '3394f9eb-50a5-485f-892c-2d5f740235bd', '2b55b11e-6fae-4256-9661-a31b2e7f5785', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 00:18:20', '2020-04-22 00:18:20', NULL);
INSERT INTO `ujian_harians` VALUES ('f11fd581-adac-4c81-9be9-6ed5623ca904', NULL, '2020-05-05', '23:53', '23:59', 3, 1, 10, NULL, 0, 'cc871a5b-9ab3-41f4-b561-15e54cc31bd5', 'e4acaab9-753f-4b67-afa9-1153e2fbd2c0', '14438ca2-a90c-45d6-9145-c1ce516a2d40', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '3394f9eb-50a5-485f-892c-2d5f740235bd', '2b55b11e-6fae-4256-9661-a31b2e7f5785', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-05-05 16:50:43', '2020-05-05 16:50:43', NULL);
INSERT INTO `ujian_harians` VALUES ('f6e4547e-82c6-48f6-a1c9-d975f6a02821', NULL, '2020-04-22', '21:30', '23:00', 90, 1, 90, 80, 0, '3e9964f1-6d96-413c-98ba-d2b551d18120', '3ff9ef0a-2a86-4e19-ab69-f00841d3b972', '325a7103-cb42-4899-88a0-2a97e105b149', 'd8c9a29a-3a87-45e1-8773-bf3efa43e9de', '3394f9eb-50a5-485f-892c-2d5f740235bd', '171e0f68-478f-436d-bce8-caebf32b175e', '760cdd93-a857-4ec5-80da-0daf500e5bde', 'dfaa2f0d-cbee-43a1-85fc-a39a443c2ee6', '2020-04-22 14:27:40', '2020-04-22 14:27:40', NULL);

-- ----------------------------
-- Table structure for ujian_mingguan_hasils
-- ----------------------------
DROP TABLE IF EXISTS `ujian_mingguan_hasils`;
CREATE TABLE `ujian_mingguan_hasils`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `nilai` int(11) NOT NULL,
  `total_pertanyaan` int(11) NOT NULL,
  `total_benar` int(11) NOT NULL,
  `total_salah` int(11) NOT NULL,
  `pertanyaan_dijawab` int(11) NOT NULL,
  `pertanyaan_tidak_dijawab` int(11) NOT NULL,
  `pertanyaan_dijawab_ragu` int(11) NOT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_mingguan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_mingguan_soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ujian_mingguan_jawaban_siswas
-- ----------------------------
DROP TABLE IF EXISTS `ujian_mingguan_jawaban_siswas`;
CREATE TABLE `ujian_mingguan_jawaban_siswas`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime(0) NOT NULL,
  `tipe` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal_pertanyaan_jawaban_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_mingguan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ujian_mingguan_soals
-- ----------------------------
DROP TABLE IF EXISTS `ujian_mingguan_soals`;
CREATE TABLE `ujian_mingguan_soals`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_habis` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_waktu_perngerjaan` int(11) NOT NULL,
  `alert_simpan_jawaban` tinyint(1) NOT NULL DEFAULT 0,
  `batas_kelulusan` int(11) NULL DEFAULT NULL,
  `soal_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelajaran_tipe_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rumus_penilaian_ujian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_mingguan_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ujian_mingguans
-- ----------------------------
DROP TABLE IF EXISTS `ujian_mingguans`;
CREATE TABLE `ujian_mingguans`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_habis` date NOT NULL,
  `jenis_ujian_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_sch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `type` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('0b63fd80-8fbd-4815-9cf5-5828dfab644f', 'Abdul Syakur', 'a.syakur14@domain.com', NULL, 'm6g7x_kura1420', 'kura1420', '$2y$10$iXNbydPD5URWgKeCxkV/yuIirdQEO5XKbUlhBmHvI8ERxpINFhH/y', 'gr', 1, 'sch', NULL, '2020-04-15 05:42:43', '2020-04-15 05:42:43');
INSERT INTO `users` VALUES ('11b83d3b-85f4-4432-84e4-18bebf8f32e6', 'Tarigan', '', NULL, 'm6g7x_tarigan', 'tarigan', '$2y$10$cz6VKemfra/XIPR8VaETru7daMvjXeE/mqfsa/mmMJD9rYRsETNu2', 'asc', 1, 'sch', NULL, '2020-04-15 03:58:30', '2020-04-15 04:02:18');
INSERT INTO `users` VALUES ('191a5a44-a05c-42d5-b818-98eeb543dd7f', 'Guru 11', '', NULL, 'm6g7x_guru1', 'guru1', '$2y$10$Wci0pUBve4lL3Ol8.qNbLODUCaZhlDhgIKVHvGOLlsRU5x6PqRRVi', 'gr', 1, 'sch', NULL, '2020-04-15 05:39:43', '2020-05-07 13:25:53');
INSERT INTO `users` VALUES ('1c3e9463-fc4d-4e9b-85db-8437c9b12623', 'Diyah Mardiana', 'dyahm60@gmail.com', NULL, 'm6g7x_192019', '192019', '$2y$10$TIlM0CoaYjA1EESl.trIaOgwT9uphXG1lwRnz3K9lLbSK5dhvoCTa', 'ss', 1, 'sch', NULL, '2020-04-15 23:24:43', '2020-04-15 23:24:43');
INSERT INTO `users` VALUES ('66a9365d-3458-4082-997e-c2f442d2e7c3', 'Muhammad Khaisanu Qaddafi', 'dev19@domain.com', NULL, 'm6g7x_dev19', 'dev19', '$2y$10$iHSeErBzSyZSvUMt3rSvHubf7/urYPm.jCh52MYWuOaRjPLAvpltm', 'gr', 1, 'sch', NULL, '2020-04-15 05:42:43', '2020-04-15 05:42:43');
INSERT INTO `users` VALUES ('6c783b0c-2007-4c46-a17c-b473a0e0efb3', 'Guru 2', '', NULL, 'm6g7x_guru2', 'guru2', '$2y$10$8Hp1mwVikaW0wwKdEssPPu4Rh/vNjiABNoZDRor4Ix9.7YG2Y/C8m', 'gr', 1, 'sch', NULL, '2020-04-15 05:40:35', '2020-04-15 05:40:35');
INSERT INTO `users` VALUES ('84f2c028-635a-4863-bd0b-9c004dd64be0', 'Magenta', '', NULL, 'magenta', NULL, '$2y$10$1dqSdqAOxipw1eX1DHhUu.A4KnebF9A7DlgS00W4B3TcooZf6H47a', 'mkt', 1, 'mgt', NULL, '2020-05-05 16:58:52', '2020-06-01 21:09:14');
INSERT INTO `users` VALUES ('99c5790d-6d71-4c61-b366-dced93461b3b', 'siswa 2', '', NULL, 'm6g7x_2', '2', '$2y$10$fn42ACx/Bs1Jel9DRFaGduLfmbgL0TUbJSr5XFbFt4o6x9417wuee', 'ss', 1, 'sch', NULL, '2020-04-15 06:33:43', '2020-05-05 04:29:46');
INSERT INTO `users` VALUES ('d89c4701-c03b-4c46-b664-8a4196622ac9', 'siswa 11', '', NULL, 'm6g7x_1', '1', '$2y$10$ycjUJEcPF15Q/WWAL.CIuubT0GtwdlzQibvx7VaQiqNc4dKDwIEIe', 'ss', 1, 'sch', NULL, '2020-04-15 06:33:00', '2020-05-10 03:18:51');
INSERT INTO `users` VALUES ('dd8da101-b488-41bb-bfd2-f2fe8ec762ad', 'Root Application', 'root@domain.com', NULL, 'root', NULL, '$2y$10$Yf5eGZnA8WiLPj0y4x6jEuOO23hXBUIu7RXnp6hqERy5AhfPeCqYq', 'rot', 1, 'mgt', NULL, '2020-04-15 02:14:07', '2020-04-15 02:14:07');

SET FOREIGN_KEY_CHECKS = 1;
