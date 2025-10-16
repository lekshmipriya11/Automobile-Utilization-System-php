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
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `appointment_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `vehicle_model` varchar(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `appointment_date` date NOT NULL,
  `message` text NOT NULL,
  `user_id` varchar(45) NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,'Lekshmi Shaji','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Car Wash','2025-10-10','Complete immediately.',''),(2,'Lekshmi Arun','arun@gmail.com','09747332510','Toyota Fortuner  2025','Oil Change','2025-10-10','Complete immediately.',''),(3,'Arunkumar','arunkem@gmail.com','01234567890','Innova Crysta 2022','Car Wash','2025-10-11','gsshkllk',''),(4,'ddjsjd','arunkem@gmail.com','01234567890','Innova Crysta 2022','Engine Repair','2025-10-11','jdwkmldkwd',''),(5,'xsxs','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Painting','3333-02-11','sdc','guest'),(7,'scsc','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Engine Repair','3333-02-11','dcsc','guest'),(8,'s','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Engine Repair','3333-02-11','bv','guest'),(9,'q','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Oil Change','3333-02-11','s','guest'),(10,'q','lekshmipriyashaji@gmail.com','09747332510','Hyundai i20','Oil Change','3333-02-11','s','guest');
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
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
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `appointment_id` varchar(45) NOT NULL,
  `amount` varchar(45) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `used_id` varchar(45) NOT NULL,
  `payment_date` varchar(45) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'5','500','Credit Card','',''),(2,'6','500','Debit Card','',''),(3,'6','500','Debit Card','','');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) NOT NULL,
  `description` varchar(225) NOT NULL,
  `price` varchar(45) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'General Services','Full vehicle inspection, oil check, tire & brakes check','1500.00'),(2,'Engine Repair','Repair or replace engine parts to ensure optimal performance','5000'),(3,'Oil Change','Replace engine oil and oil filter','800'),(4,'Car Wash','Complete exterior and interior car cleaning','500'),(5,'AC Repair','Air conditioning inspection, repair, and recharge','2500'),(6,'Pinting','Vehicle painting for scratches, dents, or full body','7000'),(7,'Brake Service','Brake pad replacement and brake system inspection','1200'),(8,'Battery Replacement','Replace old battery with new, check electrical system','2000'),(9,'Wheel Alignment','Adjust wheel angles to manufacturer specifications','1000'),(10,'Tire Replacement','Replace old tires with new ones','3000'),(11,'Suspension Repair','Inspect and repair shocks, struts, and suspension system','4000'),(12,'Transmission Service','Full transmission check, repair, or fluid replacement','4500');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_signup`
--

LOCK TABLES `staff_signup` WRITE;
/*!40000 ALTER TABLE `staff_signup` DISABLE KEYS */;
INSERT INTO `staff_signup` VALUES (14,'Babumon','babuttan@gmail.com','7561094095','$2y$10$/jp6dXDNKia/.TWo/rHiquHi3WgzuRwJIHwF1vHQspSH8TLfj3tpq','firedancer'),(15,'babumon','babuttan@gmail.com','7561094095','$2y$10$wjv8t.WcoQobR7QtzdbboO2UJVletYNUP68dTE7xlACJUmasNCwJK','firedancer'),(16,'babu','Muhammedismail15@gmail.com','9874563210','$2y$10$ru3AvEJpezUQ6SeRXmhjxeIVuog8Im0ep2hXRB5gNcprO7EAuXp5u','babu'),(17,'Lekshmi','lekshmipriyashaji@gmail.com','1234567890','$2y$10$H/TMP9vQnoIRlm0ofyj5deBStpIY/81iyS2oJB7k7AznMQLQ6rgeC','HR');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_registration`
--

LOCK TABLES `user_registration` WRITE;
/*!40000 ALTER TABLE `user_registration` DISABLE KEYS */;
INSERT INTO `user_registration` VALUES (1,'MOHAMMED','$2y$10$qc8BIpPs6SyVwsC86yX6SuLrto17WwcFL5PceNnVRbHGEVsktXBqO','Madathil house','7561094095','Muhammedismail15@gmail.com'),(2,'MOHAMMED','$2y$10$AovqXTPvSyMHSlVBEFSqHOa9t4V5tZiGMp6RhH0NX/bw1VsSVQQle','Madathil house','7561094095','Muhammedismail15@gmail.com'),(3,'salman','$2y$10$HKzOTMyXfBgZZdtX2KoVA.m0mndYEUVFZjATlhpLy7U9ptixlN.a.','Madathilhouse','7561094092','salman@gmail.com'),(4,'anupama','$2y$10$PQIIGg3ky9UbIbGMKrG4rOS.1JZ0bdhT88Dv85tMZ2p2xNIiFvEE.','kuttakatt','7895425522','anuparu@gmail.com'),(5,'anupama','$2y$10$VffWXmxi9sLfTif9apKh3et1T2qg06Nc.F0mrl4H8UJEATpeGA5ky','kuttakatt','7895425522','anuparu@gmail.com'),(6,'anupama','$2y$10$6enWofYUFDUm43b0zGzMGOLedGV.6ZvcpMjxB7m6IGfivOxsLDFlG','kuttakatt','7895425522','anuparu@gmail.com'),(7,'anupama','$2y$10$.nS3uVyOHpSbv1YfnpgGnOI/sArUiNET/Fasd2m2iZdZ0k3J.pztK','kuttakatt','7895425522','anuparu@gmail.com'),(8,'hrithin','$2y$10$WvVUX9YTa7il5SSPgiBUieLCtpfPN3N1o4l7LJ83zpToYxFBdcuHW','kinattukattam','9874563210','hrithin@gmail.com'),(9,'Lekshmi','$2y$10$rKvyRP7GMTKvO8aw9GuvhuGjfCjD/4d1b6Kc3LFsCMiwBK4KGiRJq','gfhkmknn','9747332510','lekshmipriyashaji@gmail.com');
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

-- Dump completed on 2025-10-11 11:07:27
