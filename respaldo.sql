/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.4.7-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: vet
-- ------------------------------------------------------
-- Server version	11.4.7-MariaDB-0ubuntu0.25.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `antecedentes`
--

DROP TABLE IF EXISTS `antecedentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `antecedentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mascota_id` bigint(20) unsigned NOT NULL,
  `tipo` enum('alergia','lesion','patologia','alimentacion') NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_deteccion` date DEFAULT NULL,
  `archivos_medicos` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `antecedentes_mascota_id_foreign` (`mascota_id`),
  CONSTRAINT `antecedentes_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antecedentes`
--

LOCK TABLES `antecedentes` WRITE;
/*!40000 ALTER TABLE `antecedentes` DISABLE KEYS */;
INSERT INTO `antecedentes` VALUES
(1,1,'alergia','Alergico a la penicilina desde hace 2 meses',NULL,NULL,'2026-05-26 08:03:17','2026-05-26 08:03:17'),
(2,1,'patologia','Diabetes',NULL,'antecedentes/ZrghUkA03LUDFbmNAZcnzi6fmDXmggmRLLAS3DND.png','2026-05-26 08:06:33','2026-05-26 08:06:33'),
(3,1,'alimentacion','Su alimentación',NULL,'antecedentes/IPPAQWfseEew3diS1wG0DnUMSGsHt3O2ucasklrI.png','2026-05-26 10:47:10','2026-05-26 10:47:10');
/*!40000 ALTER TABLE `antecedentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mascota_id` bigint(20) unsigned DEFAULT NULL,
  `nombre_invitado` varchar(255) DEFAULT NULL,
  `veterinario_id` bigint(20) unsigned DEFAULT NULL,
  `motivo` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado` enum('pendiente','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citas_mascota_id_foreign` (`mascota_id`),
  KEY `citas_veterinario_id_foreign` (`veterinario_id`),
  CONSTRAINT `citas_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `citas_veterinario_id_foreign` FOREIGN KEY (`veterinario_id`) REFERENCES `veterinarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES
(2,1,NULL,1,'Vacuna','2026-05-28 22:01:00','cancelada','Test','2026-05-26 10:02:02','2026-05-26 10:54:33'),
(3,2,NULL,5,'Vacuna','2026-06-11 08:15:00','completada','Dos dosis','2026-05-26 10:54:13','2026-05-26 10:54:27'),
(4,NULL,'Juan Perro',3,'Vacuna','2026-05-29 02:59:00','pendiente','Es exporadico','2026-05-26 10:55:49','2026-05-26 10:55:49');
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mascota_id` bigint(20) unsigned NOT NULL,
  `veterinario_id` bigint(20) unsigned NOT NULL,
  `fecha_consulta` datetime NOT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `talla` decimal(5,2) DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `medicamentos` text DEFAULT NULL,
  `estado` enum('cerrada','en_seguimiento') NOT NULL DEFAULT 'cerrada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultas_mascota_id_foreign` (`mascota_id`),
  KEY `consultas_veterinario_id_foreign` (`veterinario_id`),
  CONSTRAINT `consultas_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consultas_veterinario_id_foreign` FOREIGN KEY (`veterinario_id`) REFERENCES `veterinarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES
(1,1,1,'2026-04-18 20:23:02',15.50,45.00,'Chequeo general, mascota en excelente estado de salud.','Se aplicaron vitaminas de rutina. Cita abierta para seguimiento.',NULL,'cerrada','2026-05-19 02:23:02','2026-05-19 02:23:02'),
(2,1,1,'2026-05-18 20:23:02',16.00,45.00,'Presenta leve infección en el oído derecho (Otitis).','Limpieza ótica. Aplicar gotas óticas antibióticas cada 12 horas por 7 días.',NULL,'cerrada','2026-05-19 02:23:02','2026-05-19 02:23:02'),
(3,2,1,'2026-05-18 20:52:20',4.20,25.00,'Vacunación anual y desparasitación.','Aplicación de vacuna múltiple felina. Observación por 24 horas.',NULL,'cerrada','2026-05-19 02:52:20','2026-05-19 02:52:20'),
(4,1,3,'2026-05-26 02:28:25',11.50,47.00,'Dolor\n\n--- Seguimiento (26/05/2026 03:45) ---\nMejoró','Test','Testtt','cerrada','2026-05-26 08:28:25','2026-05-26 09:45:28'),
(5,1,5,'2026-05-26 04:51:03',11.40,47.00,'Dolor\n\n--- Seguimiento (26/05/2026 04:52) ---\nSe mejoro','Pastillas c/6 hr','Amoxixilina','cerrada','2026-05-26 10:51:03','2026-05-26 10:52:00');
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duenos`
--

DROP TABLE IF EXISTS `duenos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `duenos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `redes_sociales` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duenos`
--

LOCK TABLES `duenos` WRITE;
/*!40000 ALTER TABLE `duenos` DISABLE KEYS */;
INSERT INTO `duenos` VALUES
(1,'Juan Pérez Castrp','12345678','Calle Falsa 123, Ciudad',NULL,'2026-05-19 02:23:02','2026-05-26 06:33:59'),
(2,'María López','555-987654','Avenida Siempre Viva 742',NULL,'2026-05-19 02:52:20','2026-05-19 02:52:20'),
(3,'Sam','5611971187','C6 de enero','JUkiloper','2026-05-26 06:34:53','2026-05-26 06:34:53'),
(4,'Faty','561701457','Ctest','testt','2026-05-26 10:42:27','2026-05-26 10:42:27');
/*!40000 ALTER TABLE `duenos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mascotas`
--

DROP TABLE IF EXISTS `mascotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mascotas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dueno_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `especie` varchar(255) NOT NULL,
  `raza` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` varchar(255) DEFAULT NULL,
  `tipo_sangre` varchar(255) DEFAULT NULL,
  `comportamiento` varchar(255) DEFAULT NULL,
  `es_adoptado` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `motivo_baja` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mascotas_dueno_id_foreign` (`dueno_id`),
  CONSTRAINT `mascotas_dueno_id_foreign` FOREIGN KEY (`dueno_id`) REFERENCES `duenos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mascotas`
--

LOCK TABLES `mascotas` WRITE;
/*!40000 ALTER TABLE `mascotas` DISABLE KEYS */;
INSERT INTO `mascotas` VALUES
(1,1,'Firulais','Perro','Mestizo','2020-05-10',NULL,'DEA 1.1','Tranquilo',1,1,NULL,'2026-05-19 02:23:02','2026-05-19 02:23:02'),
(2,2,'Michi','Gato','Siamés','2022-03-15',NULL,'A','Agresivo',0,1,NULL,'2026-05-19 02:52:20','2026-05-19 02:52:20'),
(3,3,'Dingo','Perro','Jack Rusell','2026-02-26','9 años','A+','Jugueton',1,0,'Fallecimiento','2026-05-26 06:39:14','2026-05-26 09:02:24'),
(4,3,'Test','Perro','Desconocida','2017-02-15','9 años','Desconocida','Bellako',1,0,'Fallecimiento','2026-05-26 06:44:07','2026-05-26 06:53:51'),
(5,3,'Test','test','test','2026-05-09','3','-','test',1,0,'Fallecimiento','2026-05-26 07:06:29','2026-05-26 07:06:41'),
(6,3,'Test4','test','test','2000-02-12','3','A','Test',1,1,NULL,'2026-05-26 09:01:57','2026-05-26 09:01:57'),
(7,4,'Pelusa','Perro','JackRussell','2026-03-05','5 meses','A','Traquiloo',0,0,'Adopción por un tercero','2026-05-26 10:42:27','2026-05-26 10:45:19');
/*!40000 ALTER TABLE `mascotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_05_18_134957_create_veterinarios_table',2),
(5,'2026_05_18_201431_create_duenos_table',3),
(6,'2026_05_18_201431_create_mascotas_table',3),
(7,'2026_05_18_201912_create_consultas_table',4),
(8,'2026_05_25_225623_add_fields_to_veterinarios_table',5),
(9,'2026_05_25_230720_add_deleted_at_to_users_and_veterinarios_tables',6),
(10,'2026_05_26_003054_add_redes_sociales_to_duenos_table',7),
(11,'2026_05_26_004103_add_edad_to_mascotas_table',8),
(12,'2026_05_26_005112_add_estado_and_motivo_to_mascotas_table',9),
(13,'2026_05_26_015310_create_antecedentes_table',10),
(14,'2026_05_26_022558_add_medicamentos_and_estado_to_consultas_table',11),
(15,'2026_05_26_030751_make_tipo_sangre_and_comportamiento_nullable_in_mascotas_table',12),
(16,'2026_05_26_035202_create_citas_table',13),
(17,'2026_05_26_035852_modify_citas_table_for_invitado',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('dZoYL8ldhWR0fpOlaCO3Wel7hM7in9XQMRI2rruh',5,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','YTo0OntzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NpdGFzIjtzOjU6InJvdXRlIjtzOjExOiJjaXRhcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJsYkFpV3FieXlkd0xUcU1aV0c2UmFWT2k2OXlmV3lPNUpHM2ZPTnc3IjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=',1779774014);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('administrador','veterinario') NOT NULL DEFAULT 'veterinario',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin','admin',NULL,'$2y$12$k.TA5RnKoYE0q/5jhBK9d.TIfBBSLBKppQbjYAw5TuOmK5xdQTbq6','administrador',NULL,'2026-05-14 19:57:08','2026-05-14 19:57:08',NULL),
(2,'veterinario','veterinario',NULL,'$2y$12$98OHgnL1uOhtyu1nLptpXeA0Wt/NTkfR6HQj4S8mYg74cvVupagmG','veterinario',NULL,'2026-05-14 19:57:09','2026-05-26 05:09:38','2026-05-26 05:09:38'),
(3,'test','test@test.com',NULL,'$2y$12$F07.ZZRHAXoLKzk295gPWOZb0XsiXqPukxxBecBoiyG3ELKJIyNAq','administrador',NULL,'2026-05-18 23:59:54','2026-05-26 04:51:44',NULL),
(4,'tester','test@tester.com',NULL,'$2y$12$hkBiEBuBmMVDWDhnv11J6eSw7cOTB0UtvSZh9J/aKaFC5JrbNOTOO','veterinario',NULL,'2026-05-19 00:18:38','2026-05-26 08:57:06','2026-05-26 08:57:06'),
(5,'vet','vet@vet.com',NULL,'$2y$12$xEM4CUFGlF4h9J6VFo0fJuuPodBe/fp8ZCKlMKcDK.yDqR4vHlWJy','veterinario',NULL,'2026-05-19 01:20:19','2026-05-19 01:20:19',NULL),
(6,'Dr. Vet','vet@example.com',NULL,'$2y$12$uQs1ZmxRaPDDVSjidbLuOuudlnQ8y2qzeVEaBuu/umlSJjld8WrrG','veterinario',NULL,'2026-05-19 02:23:02','2026-05-19 02:23:02',NULL),
(7,'Faty','faty@test.com',NULL,'$2y$12$157nA9z5q.TYgXd9NfflnetwBIPur9.tdee52lTtcoU3Vm.fOG1C.','veterinario',NULL,'2026-05-26 10:34:17','2026-05-26 10:34:17',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `veterinarios`
--

DROP TABLE IF EXISTS `veterinarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `veterinarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `especialidad` varchar(255) NOT NULL,
  `cedula_profesional` varchar(255) NOT NULL,
  `foto_firma` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `anio_antiguedad` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veterinarios_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `veterinarios_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veterinarios`
--

LOCK TABLES `veterinarios` WRITE;
/*!40000 ALTER TABLE `veterinarios` DISABLE KEYS */;
INSERT INTO `veterinarios` VALUES
(1,6,'Dr. Veterinario Prueba','General','12345678','firma.jpg','2026-05-19 02:23:02','2026-05-26 05:01:56','12345678',2,NULL),
(2,2,'Tester Example Test1','Cirujano','1111111',NULL,'2026-05-26 04:59:52','2026-05-26 05:09:38','12345678',3,'2026-05-26 05:09:38'),
(3,5,'Carlos','General','231190072',NULL,'2026-05-26 05:10:47','2026-05-26 05:10:47','11223344',5,NULL),
(4,4,'Tester Example Test1','Cirujano','1111111',NULL,'2026-05-26 08:56:49','2026-05-26 08:57:06','12345678',2,'2026-05-26 08:57:06'),
(5,7,'Fatima Sanchez','Cirujano','111111',NULL,'2026-05-26 10:35:40','2026-05-26 10:35:40','561701457',1,NULL);
/*!40000 ALTER TABLE `veterinarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-05-25 23:50:31
