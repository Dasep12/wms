-- MariaDB dump 10.19  Distrib 10.6.7-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bit.wms
-- ------------------------------------------------------
-- Server version	10.6.7-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_mst_categories`
--

DROP TABLE IF EXISTS `tbl_mst_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_categories` (
  `id` int(11) NOT NULL,
  `name_categories` varchar(100) DEFAULT NULL,
  `code_categories` varchar(10) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_categories`
--

LOCK TABLES `tbl_mst_categories` WRITE;
/*!40000 ALTER TABLE `tbl_mst_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mst_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_child_units`
--

DROP TABLE IF EXISTS `tbl_mst_child_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_child_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) DEFAULT NULL,
  `unit_code` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `headers_unit_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_child_units_unique` (`unit_name`),
  UNIQUE KEY `tbl_mst_child_units_unique_1` (`unit_code`),
  KEY `tbl_mst_child_units_tbl_mst_units_FK` (`headers_unit_id`),
  CONSTRAINT `tbl_mst_child_units_tbl_mst_units_FK` FOREIGN KEY (`headers_unit_id`) REFERENCES `tbl_mst_units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_child_units`
--

LOCK TABLES `tbl_mst_child_units` WRITE;
/*!40000 ALTER TABLE `tbl_mst_child_units` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mst_child_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_customers`
--

DROP TABLE IF EXISTS `tbl_mst_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_customers` varchar(100) DEFAULT NULL,
  `code_customers` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_customer` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_customers_unique` (`code_customers`),
  UNIQUE KEY `tbl_mst_customers_unique_1` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_customers`
--

LOCK TABLES `tbl_mst_customers` WRITE;
/*!40000 ALTER TABLE `tbl_mst_customers` DISABLE KEYS */;
INSERT INTO `tbl_mst_customers` VALUES (1,'PT. TOYOTA BOSHOKU','TBINA','Kawasan MM2100, Jl. Selayar IV No.1, Cikedokan, West Cikarang, Bekasi, West Java 17530',NULL,'021-99','test@mail.com',1,'2024-07-27 10:33:41',NULL,'2024-08-06 08:38:22','1');
/*!40000 ALTER TABLE `tbl_mst_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_handling`
--

DROP TABLE IF EXISTS `tbl_mst_handling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` double NOT NULL DEFAULT 0,
  `nameHandling` varchar(100) DEFAULT NULL,
  `status_handling` int(11) DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_handling`
--

LOCK TABLES `tbl_mst_handling` WRITE;
/*!40000 ALTER TABLE `tbl_mst_handling` DISABLE KEYS */;
INSERT INTO `tbl_mst_handling` VALUES (1,15000,'Loading',1,'TES','2024-07-28 10:28:00','1',NULL,NULL);
/*!40000 ALTER TABLE `tbl_mst_handling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_locationwarehouse`
--

DROP TABLE IF EXISTS `tbl_mst_locationwarehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_locationwarehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status_location` int(1) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_mst_locationwarehouse_tbl_mst_warehouse_FK` (`warehouse_id`),
  CONSTRAINT `tbl_mst_locationwarehouse_tbl_mst_warehouse_FK` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_mst_warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_locationwarehouse`
--

LOCK TABLES `tbl_mst_locationwarehouse` WRITE;
/*!40000 ALTER TABLE `tbl_mst_locationwarehouse` DISABLE KEYS */;
INSERT INTO `tbl_mst_locationwarehouse` VALUES (1,'RAK-01',1,1,'TESTER','2024-06-12 10:00:00','1','2024-08-04 09:50:23','1'),(2,'RAK-02',1,1,NULL,'2024-08-04 08:50:10','1','2024-08-04 09:50:35','1');
/*!40000 ALTER TABLE `tbl_mst_locationwarehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_material`
--

DROP TABLE IF EXISTS `tbl_mst_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_material` varchar(100) DEFAULT NULL,
  `name_material` varchar(100) DEFAULT NULL,
  `uniqueId` varchar(100) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `packaging_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `parentUnitId` int(11) DEFAULT NULL,
  `QtyPerUnit` double DEFAULT NULL,
  `status_material` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_material_unique_2` (`uniqueId`),
  UNIQUE KEY `tbl_mst_material_unique` (`no_material`),
  UNIQUE KEY `tbl_mst_material_unique_1` (`name_material`,`customers_id`),
  KEY `tbl_mst_material_tbl_mst_customers_FK` (`customers_id`),
  KEY `tbl_mst_material_tbl_mst_units_FK` (`unit_id`),
  KEY `tbl_mst_material_tbl_mst_units_FK_1` (`parentUnitId`),
  KEY `tbl_mst_material_tbl_mst_packingstorage_FK` (`packaging_id`),
  KEY `tbl_mst_material_tbl_mst_locationwarehouse_FK` (`location_id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_customers_FK` FOREIGN KEY (`customers_id`) REFERENCES `tbl_mst_customers` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_locationwarehouse_FK` FOREIGN KEY (`location_id`) REFERENCES `tbl_mst_locationwarehouse` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_packingstorage_FK` FOREIGN KEY (`packaging_id`) REFERENCES `tbl_mst_packaging` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_units_FK` FOREIGN KEY (`unit_id`) REFERENCES `tbl_mst_units` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_units_FK_1` FOREIGN KEY (`parentUnitId`) REFERENCES `tbl_mst_units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_material`
--

LOCK TABLES `tbl_mst_material` WRITE;
/*!40000 ALTER TABLE `tbl_mst_material` DISABLE KEYS */;
INSERT INTO `tbl_mst_material` VALUES (49,'HK284-0W104-00','PAPER 104','FES1',1,1,21,2,19,NULL,1,'2024-08-04 09:49:49','1','1','2024-08-04 09:49:49'),(50,'HK284-0W218-00','PAPER 218','FES2',1,1,21,2,19,NULL,1,'2024-08-04 09:51:19','1','1','2024-08-04 09:51:19');
/*!40000 ALTER TABLE `tbl_mst_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_packaging`
--

DROP TABLE IF EXISTS `tbl_mst_packaging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_packaging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_packaging` varchar(100) DEFAULT NULL,
  `status_packaging` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_packaging`
--

LOCK TABLES `tbl_mst_packaging` WRITE;
/*!40000 ALTER TABLE `tbl_mst_packaging` DISABLE KEYS */;
INSERT INTO `tbl_mst_packaging` VALUES (1,'SKID',1,'2024-07-29 13:00:00','1','2024-08-04 09:48:48','1'),(3,'KANBAN',1,'2024-07-31 08:12:49','1','2024-08-02 14:54:28','1');
/*!40000 ALTER TABLE `tbl_mst_packaging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_role`
--

DROP TABLE IF EXISTS `tbl_mst_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(100) DEFAULT NULL,
  `code_role` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_role` int(1) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_role_unique` (`code_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_role`
--

LOCK TABLES `tbl_mst_role` WRITE;
/*!40000 ALTER TABLE `tbl_mst_role` DISABLE KEYS */;
INSERT INTO `tbl_mst_role` VALUES (1,'Admninistrator','ADM','2024-08-04 09:49:49','2024-08-04 09:49:49',1,'1',NULL),(2,'Customers','CST','2024-08-04 09:49:49','2024-08-04 09:49:49',1,'1',NULL),(3,'Operator','OPR','2024-08-04 09:49:49','2024-08-04 09:49:49',1,'1',NULL);
/*!40000 ALTER TABLE `tbl_mst_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_units`
--

DROP TABLE IF EXISTS `tbl_mst_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_unit` varchar(100) DEFAULT NULL,
  `code_unit` varchar(100) DEFAULT NULL,
  `status_unit` int(11) DEFAULT 1 COMMENT '1 AKTIF , 0 INACTIVE',
  `unit_level` int(3) DEFAULT NULL,
  `parent_id` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_units_unique` (`name_unit`),
  UNIQUE KEY `tbl_mst_units_unique_1` (`code_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_units`
--

LOCK TABLES `tbl_mst_units` WRITE;
/*!40000 ALTER TABLE `tbl_mst_units` DISABLE KEYS */;
INSERT INTO `tbl_mst_units` VALUES (17,'BALE','BAL',1,1,'*',NULL,'2024-07-30 13:26:27','1','2024-07-31 07:54:58','1'),(18,'DRUMS','DRUMS',1,1,'*',NULL,'2024-07-30 13:26:49','1','2024-07-31 07:54:52','1'),(19,'ROLLS','ROLLS',1,1,'*',NULL,'2024-07-30 13:28:43','1','2024-07-31 07:54:49','1'),(20,'PIECES','PCS',1,1,'*','FRE','2024-07-30 13:28:56','1','2024-08-06 14:00:36','1'),(21,'METER','MTR',1,2,'19',NULL,'2024-07-30 13:31:06','1','2024-08-05 14:49:49','1'),(23,'PIECE','PC',1,2,'20',NULL,'2024-07-30 13:38:51','1','2024-07-31 07:55:22','1'),(25,'LITER','LT',1,2,'18',NULL,'2024-07-30 13:41:56','1','2024-07-31 07:56:12','1'),(26,'KILOGRAM','KG',1,2,'17',NULL,'2024-07-30 13:42:19','1','2024-07-31 07:56:06','1');
/*!40000 ALTER TABLE `tbl_mst_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_users`
--

DROP TABLE IF EXISTS `tbl_mst_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_mst_users_tbl_mst_role_FK` (`role_id`),
  CONSTRAINT `tbl_mst_users_tbl_mst_role_FK` FOREIGN KEY (`role_id`) REFERENCES `tbl_mst_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_users`
--

LOCK TABLES `tbl_mst_users` WRITE;
/*!40000 ALTER TABLE `tbl_mst_users` DISABLE KEYS */;
INSERT INTO `tbl_mst_users` VALUES (1,'admin','123',1),(2,'customer','123',2);
/*!40000 ALTER TABLE `tbl_mst_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mst_warehouse`
--

DROP TABLE IF EXISTS `tbl_mst_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mst_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NameWarehouse` varchar(100) DEFAULT NULL,
  `Area` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `status_warehouse` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mst_warehouse`
--

LOCK TABLES `tbl_mst_warehouse` WRITE;
/*!40000 ALTER TABLE `tbl_mst_warehouse` DISABLE KEYS */;
INSERT INTO `tbl_mst_warehouse` VALUES (1,'RIM KIMO 1','Cibitung','Jl Raya Bekasi',1,'2022-04-12 13:00:00','1','2024-08-04 08:28:14','1'),(3,'DC JKT  2','Jakarta Utara','TESTER',1,'2024-08-04 08:49:57','1','2024-08-04 08:49:57','1');
/*!40000 ALTER TABLE `tbl_mst_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sys_accesmenu`
--

DROP TABLE IF EXISTS `tbl_sys_accesmenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sys_accesmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `add` int(1) DEFAULT NULL,
  `edit` int(1) DEFAULT NULL,
  `delete` int(1) DEFAULT NULL,
  `showAll` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_sys_accesmenu_tbl_sys_menu_FK` (`menu_id`),
  KEY `tbl_sys_accesmenu_tbl_mst_role_FK` (`role_id`),
  KEY `tbl_sys_accesmenu_tbl_mst_users_FK` (`user_id`),
  CONSTRAINT `tbl_sys_accesmenu_tbl_mst_role_FK` FOREIGN KEY (`role_id`) REFERENCES `tbl_mst_role` (`id`),
  CONSTRAINT `tbl_sys_accesmenu_tbl_mst_users_FK` FOREIGN KEY (`user_id`) REFERENCES `tbl_mst_users` (`id`),
  CONSTRAINT `tbl_sys_accesmenu_tbl_sys_menu_FK` FOREIGN KEY (`menu_id`) REFERENCES `tbl_sys_menu` (`Menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sys_accesmenu`
--

LOCK TABLES `tbl_sys_accesmenu` WRITE;
/*!40000 ALTER TABLE `tbl_sys_accesmenu` DISABLE KEYS */;
INSERT INTO `tbl_sys_accesmenu` VALUES (1,1,'MN-1',1,0,0,0,1),(2,1,'MN-2',1,1,1,1,1),(3,1,'MN-3',1,1,1,1,1),(4,1,'MN-4',1,1,1,1,1),(5,1,'MN-5',1,1,1,1,1),(6,1,'MN-6',1,1,1,1,1),(7,1,'MN-7',1,1,1,1,1),(8,1,'MN-8',1,1,1,1,1),(9,1,'MN-9',1,0,0,0,1),(10,1,'MN-10',1,0,0,0,1),(11,1,'MN-12',1,0,0,1,1),(12,1,'MN-13',1,1,1,1,1),(13,1,'MN-14',1,0,0,1,1),(14,1,'MN-15',1,0,0,1,1),(15,1,'MN-16',1,1,1,1,1),(16,1,'MN-17',1,1,1,1,1),(17,1,'MN-18',1,1,1,1,1),(18,1,'MN-19',1,1,1,1,1),(19,1,'MN-11',1,1,1,1,1),(20,2,'MN-1',2,1,0,0,1),(21,2,'MN-2',2,1,1,0,1),(22,2,'MN-3',2,1,1,1,1),(23,2,'MN-4',2,1,1,1,1);
/*!40000 ALTER TABLE `tbl_sys_accesmenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sys_menu`
--

DROP TABLE IF EXISTS `tbl_sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sys_menu` (
  `Menu_id` varchar(100) NOT NULL,
  `MenuLevel` varchar(100) DEFAULT NULL,
  `LevelNumber` varchar(100) DEFAULT NULL,
  `ParentMenu` varchar(100) DEFAULT NULL,
  `MenuName` varchar(100) DEFAULT NULL,
  `MenuIcon` varchar(100) DEFAULT NULL,
  `MenuUrl` varchar(100) DEFAULT NULL,
  `StatusMenu` int(1) DEFAULT 0,
  PRIMARY KEY (`Menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sys_menu`
--

LOCK TABLES `tbl_sys_menu` WRITE;
/*!40000 ALTER TABLE `tbl_sys_menu` DISABLE KEYS */;
INSERT INTO `tbl_sys_menu` VALUES ('MN-1','Top Menu','0','*','Dashboard','fa fa-dashboard','administrator/dashboard',1),('MN-10','Sub Menu','2','MN-9','Inbound','#','administrator/inbound',1),('MN-11','Sub Menu','2','MN-9','Outbound','#','administrator/outbound',1),('MN-12','Main Menu','1','*','Control Stock','fa fa-outdent','#',1),('MN-13','Sub Menu','2','MN-12','Summary Stock','#','administrator/summary',1),('MN-14','Main Menu','1','*','Reporting','fa fa-file-pdf-o','#',1),('MN-15','Sub Menu','2','MN-14','Inbound','#','#',1),('MN-16','Sub Menu','2','MN-14','Outbound','#','#',1),('MN-17','Main Menu','1','*','Tools','fa fa-cogs','#',1),('MN-18','Sub Menu','2','MN-17','Roles Manajemen','#','administrator/roles',1),('MN-19','Sub Menu','2','MN-17','Users Manajemen','#','#',1),('MN-2','Main Menu','1','*','Catalog','fa fa-cube','#',1),('MN-3','Sub Menu','2','MN-2','Warehouse','#','administrator/warehouse',1),('MN-4','Sub Menu','2','MN-2','Location','#','administrator/location',1),('MN-5','Sub Menu','2','MN-2','Units','#','administrator/units',1),('MN-6','Sub Menu','2','MN-2','Packaging','#','administrator/packaging',1),('MN-7','Sub Menu','2','MN-2','Customers','#','administrator/customers',1),('MN-8','Sub Menu','2','MN-2','Material','#','administrator/material',1),('MN-9','Main Menu','1','*','Manage Stock','fa fa-exchange','#',1);
/*!40000 ALTER TABLE `tbl_sys_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_trn_detailshipingmaterial`
--

DROP TABLE IF EXISTS `tbl_trn_detailshipingmaterial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_trn_detailshipingmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headers_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `no_material` varchar(100) DEFAULT NULL,
  `name_material` varchar(100) DEFAULT NULL,
  `uniqid` varchar(100) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `units` varchar(100) DEFAULT NULL,
  `packaging` varchar(100) DEFAULT NULL,
  `qtyUnit` double DEFAULT 0,
  `qtyUnits` double DEFAULT 0,
  `qtyPackaging` double DEFAULT 0,
  `begin_stock_unit` double DEFAULT 0,
  `begin_stock_units` double DEFAULT 0,
  `begin_stock_packaging` double DEFAULT 0,
  `details_unit` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_trn_detailshipingmaterial_tbl_mst_material_FK` (`material_id`),
  KEY `tbl_trn_detailshipingmaterial_tbl_trn_shipingmaterial_FK` (`headers_id`),
  CONSTRAINT `tbl_trn_detailshipingmaterial_tbl_mst_material_FK` FOREIGN KEY (`material_id`) REFERENCES `tbl_mst_material` (`id`),
  CONSTRAINT `tbl_trn_detailshipingmaterial_tbl_trn_shipingmaterial_FK` FOREIGN KEY (`headers_id`) REFERENCES `tbl_trn_shipingmaterial` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_trn_detailshipingmaterial`
--

LOCK TABLES `tbl_trn_detailshipingmaterial` WRITE;
/*!40000 ALTER TABLE `tbl_trn_detailshipingmaterial` DISABLE KEYS */;
INSERT INTO `tbl_trn_detailshipingmaterial` VALUES (132,140,50,'HK284-0W218-00','PAPER 218','FES2','ROLLS','METER','SKID',12,120,3,0,0,0,NULL,'2024-08-05 10:28:52','1','2024-08-05 10:29:37'),(137,144,50,'HK284-0W218-00','PAPER 218','FES2','ROLLS','METER','SKID',16,160,4,0,0,0,NULL,'2024-08-05 10:36:23','1','2024-08-05 10:36:36'),(140,147,49,'HK284-0W104-00','PAPER 104','FES1','ROLLS','METER','SKID',12,120,3,0,0,0,NULL,'2024-08-06 08:53:53','1','2024-08-06 08:53:57'),(141,148,49,'HK284-0W104-00','PAPER 104','FES1','ROLLS','METER','SKID',4,20,1,12,120,3,'5,5,5,5','2024-08-06 08:57:58','1','2024-08-06 08:59:16'),(142,148,50,'HK284-0W218-00','PAPER 218','FES2','ROLLS','METER','SKID',4,40,1,28,280,7,'10,10,10,10','2024-08-06 08:57:58','1','2024-08-06 08:59:16');
/*!40000 ALTER TABLE `tbl_trn_detailshipingmaterial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_trn_shipingmaterial`
--

DROP TABLE IF EXISTS `tbl_trn_shipingmaterial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_trn_shipingmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `no_surat_jalan` varchar(100) DEFAULT NULL,
  `no_reference` varchar(100) DEFAULT NULL,
  `include_handling` enum('yes','no') DEFAULT NULL,
  `ship_to` varchar(255) DEFAULT NULL,
  `driver` varchar(100) DEFAULT NULL,
  `no_truck` varchar(100) DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime DEFAULT NULL,
  `types` enum('in','out') DEFAULT NULL,
  `date_trans` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_trn_shipingmaterial_unique` (`no_surat_jalan`),
  KEY `tbl_trn_shipingmaterial_tbl_mst_customers_FK` (`customer_id`),
  CONSTRAINT `tbl_trn_shipingmaterial_tbl_mst_customers_FK` FOREIGN KEY (`customer_id`) REFERENCES `tbl_mst_customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_trn_shipingmaterial`
--

LOCK TABLES `tbl_trn_shipingmaterial` WRITE;
/*!40000 ALTER TABLE `tbl_trn_shipingmaterial` DISABLE KEYS */;
INSERT INTO `tbl_trn_shipingmaterial` VALUES (140,1,'DN-01',NULL,NULL,'Jl Raya Bekasi','Dasep','BU 23 UI','close','2024-08-05 10:29:37',NULL,'in','2024-08-05 10:27:11',NULL,'2024-08-05 10:28:52','2024-08-05 10:29:37'),(144,1,'DN-02',NULL,NULL,'JL RAYA BEKASI','Dasep','BU 23 UI','close','2024-08-05 10:36:36',NULL,'in','2024-08-05 10:36:23',NULL,'2024-08-05 10:36:23','2024-08-05 10:36:36'),(147,1,'DN-004',NULL,NULL,'JL RAYA BEKASI','Dasep','BU 23 UI','close','2024-08-06 08:53:57',NULL,'in','2024-08-06 08:53:53',NULL,'2024-08-06 08:53:53','2024-08-06 08:53:57'),(148,1,'0001/SJ/RIM/TBINA/VIII/2024',NULL,NULL,'JL RAYA BEKASI','Dasep','BU 23 UI','close',NULL,'2024-08-06 08:59:16','out','2024-08-06 08:57:58',NULL,'2024-08-06 08:57:58','2024-08-06 08:59:16');
/*!40000 ALTER TABLE `tbl_trn_shipingmaterial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_trn_summarystock`
--

DROP TABLE IF EXISTS `tbl_trn_summarystock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_trn_summarystock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) DEFAULT NULL,
  `headers_detail_id` int(11) DEFAULT NULL,
  `begin_stock` double DEFAULT 0,
  `inbound_stock` double DEFAULT 0,
  `outbound_stock` double DEFAULT 0,
  `end_stock` double DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_trn_summarystock_tbl_mst_material_FK` (`material_id`),
  CONSTRAINT `tbl_trn_summarystock_tbl_mst_material_FK` FOREIGN KEY (`material_id`) REFERENCES `tbl_mst_material` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_trn_summarystock`
--

LOCK TABLES `tbl_trn_summarystock` WRITE;
/*!40000 ALTER TABLE `tbl_trn_summarystock` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_trn_summarystock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_trn_tagihan`
--

DROP TABLE IF EXISTS `tbl_trn_tagihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_trn_tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) DEFAULT NULL,
  `tanggal_tagihan` date DEFAULT NULL,
  `status_tagihan` varchar(100) DEFAULT NULL,
  `tanggal_pembayaran` varchar(100) DEFAULT NULL,
  `tagihan_warehouse` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_trn_tagihan_tbl_mst_customers_FK` (`customers_id`),
  CONSTRAINT `tbl_trn_tagihan_tbl_mst_customers_FK` FOREIGN KEY (`customers_id`) REFERENCES `tbl_mst_customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_trn_tagihan`
--

LOCK TABLES `tbl_trn_tagihan` WRITE;
/*!40000 ALTER TABLE `tbl_trn_tagihan` DISABLE KEYS */;
INSERT INTO `tbl_trn_tagihan` VALUES (1,1,'2024-07-30','Belum Bayar',NULL,300000);
/*!40000 ALTER TABLE `tbl_trn_tagihan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vw_sys_menu`
--

DROP TABLE IF EXISTS `vw_sys_menu`;
/*!50001 DROP VIEW IF EXISTS `vw_sys_menu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_sys_menu` (
  `roleName` tinyint NOT NULL,
  `role_id` tinyint NOT NULL,
  `user_id` tinyint NOT NULL,
  `menu_id` tinyint NOT NULL,
  `MenuLevel` tinyint NOT NULL,
  `LevelNumber` tinyint NOT NULL,
  `MenuName` tinyint NOT NULL,
  `MenuIcon` tinyint NOT NULL,
  `ParentMenu` tinyint NOT NULL,
  `MenuUrl` tinyint NOT NULL,
  `delete` tinyint NOT NULL,
  `edit` tinyint NOT NULL,
  `add` tinyint NOT NULL,
  `showAll` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_control_stock`
--

DROP TABLE IF EXISTS `vw_tbl_control_stock`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_control_stock`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_control_stock` (
  `id` tinyint NOT NULL,
  `customers_id` tinyint NOT NULL,
  `uniqueId` tinyint NOT NULL,
  `units` tinyint NOT NULL,
  `unit` tinyint NOT NULL,
  `packaging` tinyint NOT NULL,
  `no_material` tinyint NOT NULL,
  `name_material` tinyint NOT NULL,
  `QtyUnit` tinyint NOT NULL,
  `QtyUnits` tinyint NOT NULL,
  `QtyPackaging` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_control_stock_detail`
--

DROP TABLE IF EXISTS `vw_tbl_control_stock_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_control_stock_detail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_control_stock_detail` (
  `id` tinyint NOT NULL,
  `types` tinyint NOT NULL,
  `material_id` tinyint NOT NULL,
  `unit` tinyint NOT NULL,
  `units` tinyint NOT NULL,
  `packaging` tinyint NOT NULL,
  `QtyUnit` tinyint NOT NULL,
  `QtyUnits` tinyint NOT NULL,
  `QtyPackaging` tinyint NOT NULL,
  `begin_stock_unit` tinyint NOT NULL,
  `begin_stock_units` tinyint NOT NULL,
  `begin_stock_packaging` tinyint NOT NULL,
  `EndStockUnit` tinyint NOT NULL,
  `EndStockUnits` tinyint NOT NULL,
  `EndStockPackaging` tinyint NOT NULL,
  `dates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_inbound`
--

DROP TABLE IF EXISTS `vw_tbl_inbound`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_inbound`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_inbound` (
  `id` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `types` tinyint NOT NULL,
  `customer_id` tinyint NOT NULL,
  `name_customers` tinyint NOT NULL,
  `code_customers` tinyint NOT NULL,
  `no_surat_jalan` tinyint NOT NULL,
  `no_reference` tinyint NOT NULL,
  `ship_to` tinyint NOT NULL,
  `driver` tinyint NOT NULL,
  `no_truck` tinyint NOT NULL,
  `date_trans` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_inbound_detail`
--

DROP TABLE IF EXISTS `vw_tbl_inbound_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_inbound_detail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_inbound_detail` (
  `id` tinyint NOT NULL,
  `headers_id` tinyint NOT NULL,
  `material_id` tinyint NOT NULL,
  `no_material` tinyint NOT NULL,
  `name_material` tinyint NOT NULL,
  `uniqid` tinyint NOT NULL,
  `unit` tinyint NOT NULL,
  `units` tinyint NOT NULL,
  `packaging` tinyint NOT NULL,
  `qtyUnit` tinyint NOT NULL,
  `qtyUnits` tinyint NOT NULL,
  `qtyPackaging` tinyint NOT NULL,
  `begin_stock_unit` tinyint NOT NULL,
  `begin_stock_units` tinyint NOT NULL,
  `begin_stock_packaging` tinyint NOT NULL,
  `details_unit` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_outbound`
--

DROP TABLE IF EXISTS `vw_tbl_outbound`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_outbound`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_outbound` (
  `id` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `types` tinyint NOT NULL,
  `customer_id` tinyint NOT NULL,
  `name_customers` tinyint NOT NULL,
  `code_customers` tinyint NOT NULL,
  `no_surat_jalan` tinyint NOT NULL,
  `no_reference` tinyint NOT NULL,
  `ship_to` tinyint NOT NULL,
  `driver` tinyint NOT NULL,
  `no_truck` tinyint NOT NULL,
  `date_trans` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_tbl_sj`
--

DROP TABLE IF EXISTS `vw_tbl_sj`;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_sj`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_tbl_sj` (
  `headers_id` tinyint NOT NULL,
  `no_surat_jalan` tinyint NOT NULL,
  `name_material` tinyint NOT NULL,
  `no_material` tinyint NOT NULL,
  `qtyUnits` tinyint NOT NULL,
  `qtyPackaging` tinyint NOT NULL,
  `units` tinyint NOT NULL,
  `packaging` tinyint NOT NULL,
  `details_unit` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'bit.wms'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_tbl_checkstock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tbl_checkstock`(IN material_id_param INT)
begin
	select a.id  ,  a.name_material ,  
	(IFNULL(X.qtyUnit,0) - IFNULL(Y.qtyUnit,0)) qtyUnitBeginStock ,
	(IFNULL(X.qtyUnits,0) - IFNULL(Y.qtyUnits,0)) qtyUnitsBeginStock,
	(IFNULL(X.qtyPackaging,0) - IFNULL(Y.qtyPackaging,0)) qtyPackagingBeginStock
	from tbl_mst_material a 
	left join (
	 	select a.material_id,  sum(a.qtyUnit)qtyUnit , 
		sum(a.qtyUnits)qtyUnits , sum(a.qtyPackaging) qtyPackaging 
		from tbl_trn_detailshipingmaterial a 
		left join tbl_trn_shipingmaterial b on b.id  = a.headers_id  
		where  b.status in ("close") and b.date_in <= now() and b.types = ("in")
		group by  a.material_id 
	)X on X.material_id = a.id 	
	left join (
	 	select a.material_id,  sum(a.qtyUnit) qtyUnit , 
		sum(a.qtyUnits) qtyUnits , sum(a.qtyPackaging) qtyPackaging 
		from tbl_trn_detailshipingmaterial a 
		left join tbl_trn_shipingmaterial b on b.id  = a.headers_id  
		where  b.status in ("close") and b.date_out <= now() and b.types = ("out")
		group by  a.material_id 
	)Y on Y.material_id = a.id 	
	where a.id  = material_id_param ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vw_sys_menu`
--

/*!50001 DROP TABLE IF EXISTS `vw_sys_menu`*/;
/*!50001 DROP VIEW IF EXISTS `vw_sys_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sys_menu` AS select `c`.`roleName` AS `roleName`,`a`.`role_id` AS `role_id`,`a`.`user_id` AS `user_id`,`a`.`menu_id` AS `menu_id`,`b`.`MenuLevel` AS `MenuLevel`,`b`.`LevelNumber` AS `LevelNumber`,`b`.`MenuName` AS `MenuName`,`b`.`MenuIcon` AS `MenuIcon`,`b`.`ParentMenu` AS `ParentMenu`,`b`.`MenuUrl` AS `MenuUrl`,`a`.`delete` AS `delete`,`a`.`edit` AS `edit`,`a`.`add` AS `add`,`a`.`showAll` AS `showAll` from ((`tbl_sys_accesmenu` `a` join `tbl_sys_menu` `b` on(`b`.`Menu_id` = `a`.`menu_id`)) join `tbl_mst_role` `c` on(`c`.`id` = `a`.`role_id`)) where `b`.`StatusMenu` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_control_stock`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_control_stock`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_control_stock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_control_stock` AS select `a`.`id` AS `id`,`a`.`customers_id` AS `customers_id`,`a`.`uniqueId` AS `uniqueId`,`b`.`name_unit` AS `units`,`c`.`name_unit` AS `unit`,`d`.`name_packaging` AS `packaging`,`a`.`no_material` AS `no_material`,`a`.`name_material` AS `name_material`,ifnull(`x`.`QtyUnit`,0) - ifnull(`y`.`QtyUnit`,0) AS `QtyUnit`,ifnull(`x`.`QtyUnits`,0) - ifnull(`y`.`QtyUnits`,0) AS `QtyUnits`,ifnull(`x`.`QtyPackaging`,0) - ifnull(`y`.`QtyPackaging`,0) AS `QtyPackaging`,`x`.`updated_at` AS `updated_at` from (((((`bit.wms`.`tbl_mst_material` `a` left join `bit.wms`.`tbl_mst_units` `b` on(`b`.`id` = `a`.`unit_id`)) left join `bit.wms`.`tbl_mst_units` `c` on(`c`.`id` = `a`.`parentUnitId`)) left join `bit.wms`.`tbl_mst_packaging` `d` on(`d`.`id` = `a`.`packaging_id`)) left join (select `ttd`.`material_id` AS `material_id`,sum(`ttd`.`qtyUnits`) AS `QtyUnits`,sum(`ttd`.`qtyUnit`) AS `QtyUnit`,sum(`ttd`.`qtyPackaging`) AS `QtyPackaging`,max(`tts`.`updated_at`) AS `updated_at` from (`bit.wms`.`tbl_trn_detailshipingmaterial` `ttd` left join `bit.wms`.`tbl_trn_shipingmaterial` `tts` on(`tts`.`id` = `ttd`.`headers_id`)) where `tts`.`status` = 'close' and `tts`.`types` = 'in' group by `ttd`.`material_id`) `x` on(`x`.`material_id` = `a`.`id`)) left join (select `ttd`.`material_id` AS `material_id`,ifnull(sum(`ttd`.`qtyUnits`),0) AS `QtyUnits`,sum(`ttd`.`qtyUnit`) AS `QtyUnit`,sum(`ttd`.`qtyPackaging`) AS `QtyPackaging` from (`bit.wms`.`tbl_trn_detailshipingmaterial` `ttd` left join `bit.wms`.`tbl_trn_shipingmaterial` `tts` on(`tts`.`id` = `ttd`.`headers_id`)) where `tts`.`status` = 'close' and `tts`.`types` = 'out' group by `ttd`.`material_id`) `y` on(`y`.`material_id` = `a`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_control_stock_detail`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_control_stock_detail`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_control_stock_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_control_stock_detail` AS select `ttd`.`id` AS `id`,`tts`.`types` AS `types`,`ttd`.`material_id` AS `material_id`,`ttd`.`unit` AS `unit`,`ttd`.`units` AS `units`,`ttd`.`packaging` AS `packaging`,`ttd`.`qtyUnit` AS `QtyUnit`,`ttd`.`qtyUnits` AS `QtyUnits`,`ttd`.`qtyPackaging` AS `QtyPackaging`,`ttd`.`begin_stock_unit` AS `begin_stock_unit`,`ttd`.`begin_stock_units` AS `begin_stock_units`,`ttd`.`begin_stock_packaging` AS `begin_stock_packaging`,if(`tts`.`types` = 'in',`ttd`.`begin_stock_unit` + `ttd`.`qtyUnit`,`ttd`.`begin_stock_unit` - `ttd`.`qtyUnit`) AS `EndStockUnit`,if(`tts`.`types` = 'in',`ttd`.`begin_stock_units` + `ttd`.`qtyUnits`,`ttd`.`begin_stock_units` - `ttd`.`qtyUnits`) AS `EndStockUnits`,if(`tts`.`types` = 'in',`ttd`.`begin_stock_packaging` + `ttd`.`qtyPackaging`,`ttd`.`begin_stock_packaging` - `ttd`.`qtyPackaging`) AS `EndStockPackaging`,if(`tts`.`types` = 'in',`tts`.`date_in`,`tts`.`date_out`) AS `dates` from (`tbl_trn_detailshipingmaterial` `ttd` left join `tbl_trn_shipingmaterial` `tts` on(`ttd`.`headers_id` = `tts`.`id`)) where `tts`.`status` = 'close' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_inbound`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_inbound`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_inbound`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_inbound` AS select `a`.`id` AS `id`,`a`.`status` AS `status`,`a`.`types` AS `types`,`a`.`customer_id` AS `customer_id`,`b`.`name_customers` AS `name_customers`,`b`.`code_customers` AS `code_customers`,`a`.`no_surat_jalan` AS `no_surat_jalan`,`a`.`no_reference` AS `no_reference`,`a`.`ship_to` AS `ship_to`,`a`.`driver` AS `driver`,`a`.`no_truck` AS `no_truck`,`a`.`date_trans` AS `date_trans` from (`tbl_trn_shipingmaterial` `a` left join `tbl_mst_customers` `b` on(`b`.`id` = `a`.`customer_id`)) where `a`.`types` = 'in' order by `a`.`date_trans` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_inbound_detail`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_inbound_detail`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_inbound_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_inbound_detail` AS select `a`.`id` AS `id`,`a`.`headers_id` AS `headers_id`,`a`.`material_id` AS `material_id`,`a`.`no_material` AS `no_material`,`a`.`name_material` AS `name_material`,`a`.`uniqid` AS `uniqid`,`a`.`unit` AS `unit`,`a`.`units` AS `units`,`a`.`packaging` AS `packaging`,`a`.`qtyUnit` AS `qtyUnit`,`a`.`qtyUnits` AS `qtyUnits`,`a`.`qtyPackaging` AS `qtyPackaging`,`a`.`begin_stock_unit` AS `begin_stock_unit`,`a`.`begin_stock_units` AS `begin_stock_units`,`a`.`begin_stock_packaging` AS `begin_stock_packaging`,`a`.`details_unit` AS `details_unit` from (((`tbl_trn_detailshipingmaterial` `a` left join `tbl_mst_material` `b` on(`b`.`id` = `a`.`material_id`)) left join `tbl_mst_units` `c` on(`c`.`id` = `b`.`unit_id`)) left join `tbl_mst_packaging` `d` on(`d`.`id` = `b`.`packaging_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_outbound`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_outbound`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_outbound`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_outbound` AS select `a`.`id` AS `id`,`a`.`status` AS `status`,`a`.`types` AS `types`,`a`.`customer_id` AS `customer_id`,`b`.`name_customers` AS `name_customers`,`b`.`code_customers` AS `code_customers`,`a`.`no_surat_jalan` AS `no_surat_jalan`,`a`.`no_reference` AS `no_reference`,`a`.`ship_to` AS `ship_to`,`a`.`driver` AS `driver`,`a`.`no_truck` AS `no_truck`,`a`.`date_trans` AS `date_trans` from (`tbl_trn_shipingmaterial` `a` left join `tbl_mst_customers` `b` on(`b`.`id` = `a`.`customer_id`)) where `a`.`types` = 'out' order by `a`.`date_trans` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_tbl_sj`
--

/*!50001 DROP TABLE IF EXISTS `vw_tbl_sj`*/;
/*!50001 DROP VIEW IF EXISTS `vw_tbl_sj`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_tbl_sj` AS select `b`.`id` AS `headers_id`,`b`.`no_surat_jalan` AS `no_surat_jalan`,`a`.`name_material` AS `name_material`,`a`.`no_material` AS `no_material`,`a`.`qtyUnits` AS `qtyUnits`,`a`.`qtyPackaging` AS `qtyPackaging`,`a`.`units` AS `units`,`a`.`packaging` AS `packaging`,`a`.`details_unit` AS `details_unit` from (`tbl_trn_detailshipingmaterial` `a` left join `tbl_trn_shipingmaterial` `b` on(`b`.`id` = `a`.`headers_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-06 15:46:24
