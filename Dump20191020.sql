-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: nomina
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish2_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Badak_2','Nacho Badak_6000','REPS890903975','921 304 36 70','2019-09-26 12:00:00','2019-10-16 22:47:14',NULL),(2,'Badak','Nacho Badak','REPS890903975','921 304 36 70','2019-10-01 22:51:59','2019-10-01 22:51:59',NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_users`
--

DROP TABLE IF EXISTS `company_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `company_user_user_id_fk_idx` (`user_id`),
  KEY `company_user_company_id_idx` (`company_id`),
  CONSTRAINT `company_user_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `company_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_users`
--

LOCK TABLES `company_users` WRITE;
/*!40000 ALTER TABLE `company_users` DISABLE KEYS */;
INSERT INTO `company_users` VALUES (2,1,2,'2019-10-01 23:34:42','2019-10-01 23:56:52',NULL);
/*!40000 ALTER TABLE `company_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_types`
--

DROP TABLE IF EXISTS `contract_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `contract_types_company_id_fk_idx` (`company_id`),
  CONSTRAINT `contract_types_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_types`
--

LOCK TABLES `contract_types` WRITE;
/*!40000 ALTER TABLE `contract_types` DISABLE KEYS */;
INSERT INTO `contract_types` VALUES (11,'dsfvsvd',2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `contract_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contribution_bases`
--

DROP TABLE IF EXISTS `contribution_bases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contribution_bases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `contribution_bases_company_id_fk_idx` (`company_id`),
  CONSTRAINT `contribution_bases_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contribution_bases`
--

LOCK TABLES `contribution_bases` WRITE;
/*!40000 ALTER TABLE `contribution_bases` DISABLE KEYS */;
/*!40000 ALTER TABLE `contribution_bases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `departments_company_id_fk_idx` (`company_id`),
  CONSTRAINT `departments_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Departamento 1 old',1,'2019-10-07 23:11:43','2019-10-07 23:14:39',NULL),(2,'Departamento 2',1,'2019-10-07 23:12:04','2019-10-07 23:12:04',NULL),(3,'departamento',1,NULL,NULL,NULL),(4,'departamento nueevo',2,NULL,'2019-10-19 23:02:27','2019-10-19 23:02:27');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount_types`
--

DROP TABLE IF EXISTS `discount_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `discount_types_company_id_fk_idx` (`company_id`),
  CONSTRAINT `discount_types_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount_types`
--

LOCK TABLES `discount_types` WRITE;
/*!40000 ALTER TABLE `discount_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentations`
--

DROP TABLE IF EXISTS `documentations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentations`
--

LOCK TABLES `documentations` WRITE;
/*!40000 ALTER TABLE `documentations` DISABLE KEYS */;
INSERT INTO `documentations` VALUES (1,'Acta de nacimiento\n','2019-09-27 12:00:00',NULL,NULL),(2,'Comprobante de domicilio\n','2019-09-27 12:00:00',NULL,NULL),(3,'INE','2019-09-27 12:00:00',NULL,NULL),(4,'CURP','2019-09-27 12:00:00',NULL,NULL),(5,'RFC','2019-09-27 12:00:00',NULL,NULL);
/*!40000 ALTER TABLE `documentations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_types`
--

DROP TABLE IF EXISTS `employee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `employee_types_company_id_idx` (`company_id`),
  CONSTRAINT `employee_types_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_types`
--

LOCK TABLES `employee_types` WRITE;
/*!40000 ALTER TABLE `employee_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Administrador','administration','2019-09-26 12:00:00','2019-09-26 12:00:00',NULL),(2,'Patrón','patron','2019-09-26 12:00:00','2019-09-26 12:00:00',NULL),(3,'Ejecutivo','executive','2019-09-26 12:00:00','2019-09-26 12:00:00',NULL),(4,'root','root','2019-09-26 12:00:00','2019-09-26 12:00:00',NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `department_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `jobs_department_id_fk_idx` (`department_id`),
  KEY `jobs_company_id_fk_idx` (`company_id`),
  CONSTRAINT `jobs_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `jobs_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (5,'puesto 1',1,2,NULL,NULL,NULL),(6,'dcsdcdsc',3,2,NULL,NULL,NULL),(7,'acvwvd cdscvwefq wwe ef',3,2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',1),(4,'2016_06_01_000002_create_oauth_access_tokens_table',1),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(6,'2016_06_01_000004_create_oauth_clients_table',1),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('0210c0a25c0859d7c648ede6b28e5ec61614f9e0dcbd348146415c16685070edf112b3508bf0af4c',1,1,'Personal Access Token','[]',0,'2019-10-17 02:27:47','2019-10-17 02:27:47','2020-10-16 21:27:47'),('04c0cc8ebcf90403db3c698c1553b003c359bb7b50538a7c0d257d047dac92ba67ffb06c49acd188',1,1,'Personal Access Token','[]',0,'2019-10-19 22:10:58','2019-10-19 22:10:58','2020-10-19 17:10:58'),('084bf432c0c4c7562ecb006e44a316d0f47de10f007c192f9c449277a2fac63c075e1ebcd5ba678f',1,1,'Personal Access Token','[]',0,'2019-10-01 04:15:33','2019-10-01 04:15:33','2020-09-30 23:15:33'),('092346046f299046c392ca50749c5dd8fd8c76143c0af50c81a8c55c75fc74f224b322bbf993cdcc',1,1,'Personal Access Token','[]',0,'2019-10-19 22:09:28','2019-10-19 22:09:28','2020-10-19 17:09:28'),('18d0a186f30aac118e3575217fcacb63427c3f5520dd2abb3e1726297fd3f3d517f89a6dfee708a0',1,1,'Personal Access Token','[]',0,'2019-10-19 21:58:03','2019-10-19 21:58:03','2020-10-19 16:58:03'),('2c52340407246d6b4d383e91907d91e00a07252a8b79215d6b1ab8ff19534b4c7f62a71382181f9e',1,1,'Personal Access Token','[]',0,'2019-10-19 22:05:39','2019-10-19 22:05:39','2020-10-19 17:05:39'),('363e84527072ca6351d0755fdf64bfcb483bf68666b174ac2f3ca3c3b61fa53012415721b286a6cc',1,1,'Personal Access Token','[]',0,'2019-10-12 21:33:14','2019-10-12 21:33:14','2020-10-12 16:33:14'),('444541f2c2dd5e4d83ad248780ecdbf0679743117d76e607551968b85126ca164c85b48794297286',1,1,'Personal Access Token','[]',0,'2019-10-19 21:58:29','2019-10-19 21:58:29','2020-10-19 16:58:29'),('4b48290b1ba4fe14a91b3c79244ee55df679b422c702d223dd628e012973bed2d712f0e340cfa6ba',1,1,'Personal Access Token','[]',0,'2019-10-19 22:09:04','2019-10-19 22:09:04','2020-10-19 17:09:04'),('50c24c2748c51f5c4cb0d69df7b9bad939b4ca4145020b4bdd9b2bda5e5ebf68dd3568b1ae6a5586',1,1,'Personal Access Token','[]',0,'2019-10-16 04:23:11','2019-10-16 04:23:11','2020-10-15 23:23:11'),('545092440429b682cc5875eff548a85b6e4a081f29fca9009c6bfc0f084e30f4f1a75b9111a8d60c',1,1,'Personal Access Token','[]',0,'2019-10-19 22:10:14','2019-10-19 22:10:14','2020-10-19 17:10:14'),('556d93ca1935186ba3cbfb3ad53654dbf75da33ed7b6d7a1db1d52280a8b5bba92171ffcfc122fa4',1,1,'Personal Access Token','[]',0,'2019-10-19 23:25:51','2019-10-19 23:25:51','2020-10-19 18:25:51'),('587a7021f4a1799080be1afd7a2d350d60ef8c0231a6c6c455f0a04760a363e346500a6bd1eb1984',1,1,'Personal Access Token','[]',0,'2019-10-19 22:06:13','2019-10-19 22:06:13','2020-10-19 17:06:13'),('5cad29189559635f140dcddedf64fdb42b3f075bfc62fde4c7a8abc5346d42f596f3a68536f32de5',1,1,'Personal Access Token','[]',0,'2019-10-19 20:25:45','2019-10-19 20:25:45','2020-10-19 15:25:45'),('866af9b515f3fce3c373b4b14f47feff59c74b9afd6c600a004c7ec2b47b8bf3c5dad56196ec6011',1,1,'Personal Access Token','[]',0,'2019-10-20 15:28:10','2019-10-20 15:28:10','2020-10-20 10:28:10'),('8e736948ffe348235190d605221d38d0266a2ab5bb0ed78b44a4d2da028e976278ba98e607771b4a',1,1,'Personal Access Token','[]',0,'2019-10-19 22:10:26','2019-10-19 22:10:26','2020-10-19 17:10:26'),('9094b5dcbedaeb6a9d9ffdfe8aa57d2671d69b3041403ba1bdee28dbdfe7ada3fd5ace2a9dc228f9',1,1,'Personal Access Token','[]',0,'2019-10-19 21:53:42','2019-10-19 21:53:42','2020-10-19 16:53:42'),('966a28159485b8e11672e19ab45e201cb58974f66ccaa4c1f303f2d2c190452dbfd80e9e9bc806ed',1,1,'Personal Access Token','[]',0,'2019-10-19 21:53:14','2019-10-19 21:53:14','2020-10-19 16:53:14'),('990b1e901660e77d972a1c00b05bb7fd4ace86cc0e76ffa68e2d1cc0a913b28de14a06bcab2f5911',1,1,'Personal Access Token','[]',0,'2019-10-03 02:24:03','2019-10-03 02:24:03','2020-10-02 21:24:03'),('9be0058a0c2b368d8d59bd1eeae138708b8c528be3e6ab323685c964f1fda41bec0dbc2b77a2a029',1,1,'Personal Access Token','[]',0,'2019-10-19 21:52:29','2019-10-19 21:52:29','2020-10-19 16:52:29'),('a4dfb0e12b156fa92a7be7becbdf9fbd4349c031cbe57835ecea2c065e3195c35ad08eb87f57fe3f',1,1,'Personal Access Token','[]',0,'2019-10-20 18:58:05','2019-10-20 18:58:05','2020-10-20 13:58:05'),('a8454c104eecc203e00b47aaa24f60432ae5785e950b07b1b3f76f055ee65994f478ee1c763fd884',1,1,'Personal Access Token','[]',0,'2019-10-20 04:19:21','2019-10-20 04:19:21','2020-10-19 23:19:21'),('b0ba372056e71bffe9a4648386c5fa00e1a22c6b9cdff38eff0a3286d9339cb0e0e53aad2cd3e2bd',1,1,'Personal Access Token','[]',0,'2019-10-19 23:23:41','2019-10-19 23:23:41','2020-10-19 18:23:41'),('c272d91b9821635826c85da13206b0235ea7c2f734360e233a65d3574631e203edfc403cef9551c1',1,1,'Personal Access Token','[]',0,'2019-10-19 21:56:41','2019-10-19 21:56:41','2020-10-19 16:56:41'),('ce7b79990ced2ea13f976b816b3ca8cacc9d36f3c4173d167c58dad93bdcbad1d2f5fad46b8c0f96',1,1,'Personal Access Token','[]',0,'2019-10-19 22:08:29','2019-10-19 22:08:29','2020-10-19 17:08:29'),('dea4841e34b24ad6156b616ef838c9b91ea55afda7193b9b5463390369c15d2945e76e7952863b93',1,1,'Personal Access Token','[]',0,'2019-10-16 02:32:07','2019-10-16 02:32:07','2020-10-15 21:32:07'),('ec5179ede1c7de0759321dda2de5557639446b410c7141f2756f84e7b517fabdc5260585bc4aa936',1,1,'Personal Access Token','[]',0,'2019-10-19 01:17:59','2019-10-19 01:17:59','2020-10-18 20:17:59'),('f219631518e88aab1c44e49e3566ab24b66aee23a59b158d95df22ee3842f70cdc6028388dfac5a8',1,1,'Personal Access Token','[]',0,'2019-10-19 21:58:49','2019-10-19 21:58:49','2020-10-19 16:58:49');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','2ekSXJVoXhyjROl4auzQAXjXn9u21q2UJZzMx7HR','http://localhost',1,0,0,'2019-09-29 08:24:19','2019-09-29 08:24:19'),(2,NULL,'Laravel Password Grant Client','RslPYXiBvZFosvxJY8Zs7oSQp3Bd73B0aKe6rOrb','http://localhost',0,1,0,'2019-09-29 08:24:19','2019-09-29 08:24:19');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2019-09-29 08:24:19','2019-09-29 08:24:19');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `payment_methods_company_id_fk_idx` (`company_id`),
  CONSTRAINT `payment_methods_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `period_types`
--

DROP TABLE IF EXISTS `period_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `period_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `period_types_company_id_fk_idx` (`company_id`),
  CONSTRAINT `period_types_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `period_types`
--

LOCK TABLES `period_types` WRITE;
/*!40000 ALTER TABLE `period_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `period_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexs`
--

DROP TABLE IF EXISTS `sexs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sexs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `sexs_company_id_fk_idx` (`company_id`),
  CONSTRAINT `sexs_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexs`
--

LOCK TABLES `sexs` WRITE;
/*!40000 ALTER TABLE `sexs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sexs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_company_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_group_id_fk_idx` (`group_id`),
  KEY `uers_company_id_fk_idx` (`default_company_id`),
  CONSTRAINT `uers_company_id_fk` FOREIGN KEY (`default_company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `users_group_id_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Samuel Regino Placido','samuel.regino@next-io.com',NULL,'$2y$10$lhfiQ4PxkL50BCPU4eYSS.JjkDom9MyeDDJcx1OtkZwnZFPzuc5aO',NULL,4,'avatar.png',1,1,'2019-10-01 03:22:22','2019-10-20 05:15:35',NULL),(4,'Esau Munive','esau.munive@next-io.com',NULL,'$2y$10$utodZo6VSY3VPpGyCQ7tcOIworcs/IHm9vPeWMOmORPNygciUnMX.',NULL,2,'avatar.png',NULL,1,'2019-10-02 04:34:42','2019-10-02 04:56:52',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_documentations`
--

DROP TABLE IF EXISTS `work_documentations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_documentations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` int(11) unsigned NOT NULL,
  `document_id` int(11) unsigned NOT NULL,
  `other_name` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `worker_documentarion_worker_id_fk_idx` (`work_id`),
  KEY `worker_documentation_documentation_id_fk_idx` (`document_id`),
  CONSTRAINT `worker_documentarion_worker_id_fk` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`),
  CONSTRAINT `worker_documentation_documentation_id_fk` FOREIGN KEY (`document_id`) REFERENCES `documentations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_documentations`
--

LOCK TABLES `work_documentations` WRITE;
/*!40000 ALTER TABLE `work_documentations` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_documentations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_shifts`
--

DROP TABLE IF EXISTS `work_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `work_shifts_company_id_fk_idx` (`company_id`),
  CONSTRAINT `work_shifts_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_shifts`
--

LOCK TABLES `work_shifts` WRITE;
/*!40000 ALTER TABLE `work_shifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_states`
--

DROP TABLE IF EXISTS `work_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_states`
--

LOCK TABLES `work_states` WRITE;
/*!40000 ALTER TABLE `work_states` DISABLE KEYS */;
INSERT INTO `work_states` VALUES (1,'En proceso de alta','2019-09-27 12:00:00',NULL,NULL),(2,'Proceso de reingreso','2019-09-27 12:00:00',NULL,NULL),(3,'Activo','2019-09-27 12:00:00',NULL,NULL),(4,'Proceso de baja','2019-09-27 12:00:00',NULL,NULL),(5,'Dado de baja','2019-09-27 12:00:00',NULL,NULL);
/*!40000 ALTER TABLE `work_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `works` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `code` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `discharge_date` date NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `contract_type_id` int(10) unsigned NOT NULL,
  `period_type_id` int(10) unsigned NOT NULL,
  `real_daily_salary` decimal(20,2) NOT NULL,
  `imss_daily_salary` decimal(20,2) NOT NULL,
  `contribution_base_salary` decimal(20,2) NOT NULL,
  `contribution_base_id` int(11) unsigned NOT NULL,
  `department_id` int(10) unsigned DEFAULT NULL,
  `job_id` int(10) unsigned DEFAULT NULL,
  `employee_type_id` int(10) unsigned NOT NULL,
  `payment_method_id` int(10) unsigned NOT NULL,
  `work_shift_id` int(10) unsigned NOT NULL,
  `number_afore` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `social_security_number` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish2_ci NOT NULL,
  `curp` varchar(22) COLLATE utf8_spanish2_ci NOT NULL,
  `sex_id` int(11) unsigned NOT NULL,
  `birth_city` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `birth_date` date NOT NULL,
  `umf` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fathers_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mothers_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `current_address` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `current_population` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `current_state` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cp` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `back_electronic_payment` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `acount_number` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `branch_office` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fonacot_number` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `key_account` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `infonavit_credit_number` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `discount_type_id` int(10) unsigned DEFAULT NULL,
  `monthly_factor` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `workers_contact_type_id_fk_idx` (`contract_type_id`),
  KEY `workers_period_type_id_fk_idx` (`period_type_id`),
  KEY `workers_contribution_base_id_fk_idx` (`contribution_base_id`),
  KEY `workers_department_id_fk_idx` (`department_id`),
  KEY `workers_job_id_fk_idx` (`job_id`),
  KEY `workers_employee_type_id_fk_idx` (`employee_type_id`),
  KEY `workers_payment_id_fk_idx` (`payment_method_id`),
  KEY `workers_work_shift_id_fk_idx` (`work_shift_id`),
  KEY `workers_sex_id_fk_idx` (`sex_id`),
  KEY `workers_discount_type_id_fk_idx` (`discount_type_id`),
  KEY `works_company_id_fk_idx` (`company_id`),
  CONSTRAINT `workers_contact_type_id_fk` FOREIGN KEY (`contract_type_id`) REFERENCES `contract_types` (`id`),
  CONSTRAINT `workers_contribution_base_id_fk` FOREIGN KEY (`contribution_base_id`) REFERENCES `contribution_bases` (`id`),
  CONSTRAINT `workers_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `workers_discount_type_id_fk` FOREIGN KEY (`discount_type_id`) REFERENCES `discount_types` (`id`),
  CONSTRAINT `workers_employee_type_id_fk` FOREIGN KEY (`employee_type_id`) REFERENCES `employee_types` (`id`),
  CONSTRAINT `workers_job_id_fk` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  CONSTRAINT `workers_payment_id_fk` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `workers_period_type_id_fk` FOREIGN KEY (`period_type_id`) REFERENCES `period_types` (`id`),
  CONSTRAINT `workers_sex_id_fk` FOREIGN KEY (`sex_id`) REFERENCES `sexs` (`id`),
  CONSTRAINT `workers_work_shift_id_fk` FOREIGN KEY (`work_shift_id`) REFERENCES `work_shifts` (`id`),
  CONSTRAINT `works_company_id_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-20 19:32:35
