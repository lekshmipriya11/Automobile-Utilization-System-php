-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: automobile
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `addservice`
--

DROP TABLE IF EXISTS `addservice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addservice` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(324) NOT NULL,
  `service_price` varchar(445) NOT NULL,
  `service_description` varchar(445) NOT NULL,
  `features` varchar(445) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addservice`
--

LOCK TABLES `addservice` WRITE;
/*!40000 ALTER TABLE `addservice` DISABLE KEYS */;
/*!40000 ALTER TABLE `addservice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin login`
--

DROP TABLE IF EXISTS `admin login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin login` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin login`
--

LOCK TABLES `admin login` WRITE;
/*!40000 ALTER TABLE `admin login` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts_ and_notifications`
--

DROP TABLE IF EXISTS `alerts_ and_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts_ and_notifications` (
  `alert_id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `alert_type` varchar(45) NOT NULL,
  `meassage` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `notification_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`alert_id`,`vehicle_id`,`notification_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts_ and_notifications`
--

LOCK TABLES `alerts_ and_notifications` WRITE;
/*!40000 ALTER TABLE `alerts_ and_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `alerts_ and_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_and_reports`
--

DROP TABLE IF EXISTS `analytics_and_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_and_reports` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `start_time` varchar(45) NOT NULL,
  `end_time` varchar(45) NOT NULL,
  `distance_km` varchar(45) NOT NULL,
  `fuel_consumed` varchar(45) NOT NULL,
  `customer_id` int NOT NULL,
  `report_id` int NOT NULL,
  `generated_by` varchar(45) NOT NULL,
  PRIMARY KEY (`log_id`,`vehicle_id`,`customer_id`,`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_and_reports`
--

LOCK TABLES `analytics_and_reports` WRITE;
/*!40000 ALTER TABLE `analytics_and_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_and_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_details`
--

DROP TABLE IF EXISTS `customer_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_details` (
  `costumer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(45) NOT NULL,
  `user_id` int NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  PRIMARY KEY (`costumer_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_details`
--

LOCK TABLES `customer_details` WRITE;
/*!40000 ALTER TABLE `customer_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard`
--

DROP TABLE IF EXISTS `dashboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dashboard` (
  `widget_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `log_id` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`widget_id`,`user_id`,`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard`
--

LOCK TABLES `dashboard` WRITE;
/*!40000 ALTER TABLE `dashboard` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department_details`
--

DROP TABLE IF EXISTS `department_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department_details` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(45) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department_details`
--

LOCK TABLES `department_details` WRITE;
/*!40000 ALTER TABLE `department_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `department_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `feature_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `service_price` varchar(255) NOT NULL,
  `service_description` varchar(245) NOT NULL,
  `features` varchar(255) NOT NULL,
  `service_id` varchar(245) NOT NULL,
  PRIMARY KEY (`feature_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_signup`
--

DROP TABLE IF EXISTS `staff_signup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_signup` (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) NOT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_signup`
--

LOCK TABLES `staff_signup` WRITE;
/*!40000 ALTER TABLE `staff_signup` DISABLE KEYS */;
INSERT INTO `staff_signup` VALUES (1,'','','','$2y$10$RXgtZK.LuAARLNnOgqQLZOB3XxzdU8UvDcis06a3RBPvvxrWCh7Ze',''),(2,'','','','$2y$10$n4WlkrEvqbAfZOC5q0Jkge1Png9qBOcbd5lUbRaqQflekdXA0us2q',''),(3,'','','','$2y$10$wKsKMKpi3SzpQWXj.rKmCOURl5LeQU35g80sXLz9MQQFjx4m/Boaq',''),(4,'abcd','','','$2y$10$2xhveuP.S/s/ulAIJJZjsuC4NXNYSpwArBjpWRPEIJyzlJG4a6Z3C','sales'),(5,'abcd','','','$2y$10$YFTmrJDmHdT8xvPVVeJvYOR4mN3hKD9.63Hf.S3P04W6jzpP9lxBW','sales'),(6,'abcde','','','$2y$10$ctY8J0RN32MlwZdLnzg3BemR0w3yyB3dddCqUC8q66HQ9t3gz/jua','sales'),(7,'abcdef','','','$2y$10$fHnJfjP9Y/RJBCNot4ZXte.bdyf5ZXUR9b/1ux9tPsjBIpKUucGdu','sales'),(8,'abcd','','','$2y$10$Q8d3WZejzBJE5Yg0OjrSV.74EAGuDij.L.o7BzK4EGgMjKhrgcoRe','sales'),(9,'abcd','','','$2y$10$p7/.65bY0ZmZDcxMUiMPMegeSZG66j5mnwWY6p32AFlAv2EsvOZeG','sales'),(10,'adghj','','','$2y$10$ijZISaQibl71pfZZZUbtteK4xJUcD2fBytrSbnZ/V9kBMq0nZfQBi','sales'),(11,'adghj','abcde@gmail.com','','$2y$10$l.KFG2olRkGweG/3qYgIKetG6Rfm9T9CHxl4rJTf4j7czPgnSFMcy','sales'),(12,'adghje','abcde@gmail.com','','$2y$10$lfqVUKK0IupqxjpdJevKM.RP9rj1oxKsuk6biR2GGvMWTFj4EJJBi','sales'),(13,'adghje','abcde@gmail.com','','$2y$10$NJKNb.coc.YCe/OB/vszeOixjs1N0nk0NOVb8ILom9MUYa8aJr5R.','sales'),(14,'babumon','babuttan@gmail.com','7561094095','$2y$10$/jp6dXDNKia/.TWo/rHiquHi3WgzuRwJIHwF1vHQspSH8TLfj3tpq','firedancer'),(15,'babumon','babuttan@gmail.com','7561094095','$2y$10$wjv8t.WcoQobR7QtzdbboO2UJVletYNUP68dTE7xlACJUmasNCwJK','firedancer'),(16,'babu','Muhammedismail15@gmail.com','9874563210','$2y$10$ru3AvEJpezUQ6SeRXmhjxeIVuog8Im0ep2hXRB5gNcprO7EAuXp5u','babu');
/*!40000 ALTER TABLE `staff_signup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_registration`
--

DROP TABLE IF EXISTS `user_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_registration` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_registration`
--

LOCK TABLES `user_registration` WRITE;
/*!40000 ALTER TABLE `user_registration` DISABLE KEYS */;
INSERT INTO `user_registration` VALUES (1,'MOHAMMED','$2y$10$qc8BIpPs6SyVwsC86yX6SuLrto17WwcFL5PceNnVRbHGEVsktXBqO','Madathil house','7561094095','Muhammedismail15@gmail.com'),(2,'MOHAMMED','$2y$10$AovqXTPvSyMHSlVBEFSqHOa9t4V5tZiGMp6RhH0NX/bw1VsSVQQle','Madathil house','7561094095','Muhammedismail15@gmail.com'),(3,'salman','$2y$10$HKzOTMyXfBgZZdtX2KoVA.m0mndYEUVFZjATlhpLy7U9ptixlN.a.','Madathilhouse','7561094092','salman@gmail.com'),(4,'anupama','$2y$10$PQIIGg3ky9UbIbGMKrG4rOS.1JZ0bdhT88Dv85tMZ2p2xNIiFvEE.','kuttakatt','7895425522','anuparu@gmail.com'),(5,'anupama','$2y$10$VffWXmxi9sLfTif9apKh3et1T2qg06Nc.F0mrl4H8UJEATpeGA5ky','kuttakatt','7895425522','anuparu@gmail.com'),(6,'anupama','$2y$10$6enWofYUFDUm43b0zGzMGOLedGV.6ZvcpMjxB7m6IGfivOxsLDFlG','kuttakatt','7895425522','anuparu@gmail.com'),(7,'anupama','$2y$10$.nS3uVyOHpSbv1YfnpgGnOI/sArUiNET/Fasd2m2iZdZ0k3J.pztK','kuttakatt','7895425522','anuparu@gmail.com'),(8,'hrithin','$2y$10$WvVUX9YTa7il5SSPgiBUieLCtpfPN3N1o4l7LJ83zpToYxFBdcuHW','kinattukattam','9874563210','hrithin@gmail.com');
/*!40000 ALTER TABLE `user_registration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-04 13:03:55
