-- MySQL dump 10.13  Distrib 5.6.40, for Win64 (x86_64)
--
-- Host: localhost    Database: sefora
-- ------------------------------------------------------
-- Server version	5.6.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bransoletki`
--

DROP TABLE IF EXISTS `bransoletki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bransoletki` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nazwa` varchar(100) NOT NULL,
  `Sex` varchar(1) DEFAULT NULL,
  `Opis` text,
  `Cena` int(4) DEFAULT NULL,
  `Kolor` varchar(20) DEFAULT NULL,
  `Images` varchar(30) DEFAULT NULL,
  `Para` int(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bransoletki`
--

LOCK TABLES `bransoletki` WRITE;
/*!40000 ALTER TABLE `bransoletki` DISABLE KEYS */;
INSERT INTO `bransoletki` VALUES (1,'Bransoletka czarna skóra 5mm','u','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości potrójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne, wykonane z cyny w kolorze antycznego srebra. \r\nSzerokość rzemienia 5 mm. \r\nKolor czarny. \r\nJeśli wolisz w innym kolorze napisz do mnie. \r\nMateriały, z których wykonane są bransoletki zostały wyprodukowane w UE.',55,'czarna','1_1.1_2.',0),(2,'Bransoletka stal skóra 2x5mm','u','Elegancka bransoletka w formie minimalistycznej ze skórzanych płaskich rzemieni, doskonałej jakości, podwójnie oplata nadgarstek. \r\nDodatkowym atutem jest rewelacyjne zapięcie magnesowe, wykonane ze stali chirurgicznej. \r\nStal szlachetna, zwana również chirurgiczną jest odporna na korozje, nie zmienia barwy, jest hipoalergiczna - nie powoduje uczuleń. \r\nSzerokość rzemienia 5 mm. \r\nSzerokość bransoletki 10 mm. \r\nKolor granat i błękit turkusowy. \r\nBransoletka jest idealna zarówno dla kobiety, jak i dla mężczyzny. ',80,'niebieska','2_1.2_2.',0),(3,'Bransoletka stal skóra 2x5mm','u','Elegancka bransoletka w formie minimalistycznej ze skórzanych płaskich rzemieni, doskonałej jakości, podwójnie oplata nadgarstek. \r\nDodatkowym atutem jest rewelacyjne zapięcie magnesowe, wykonane ze stali chirurgicznej. \r\nStal szlachetna, zwana również chirurgiczną jest odporna na korozje, nie zmienia barwy, jest hipoalergiczna - nie powoduje uczuleń. \r\nSzerokość rzemienia 5 mm. \r\nSzerokość bransoletki 10 mm. \r\nKolor brąz. ',80,'brązowa','3_1.3_2.',0),(4,'Bransoletka skórzana 5mm monstera','u','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości podwójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i element ozdobny kompas, wykonane z cyny w kolorze antycznego srebra. \r\nSzerokość rzemienia 5 mm. \r\nKolor czerwony. \r\nJeśli wolisz bransoletkę w innym kolorze skontaktuj się ze mną. \r\nMateriały, z których wykonane są bransoletki zostały wyprodukowane w UE. \r\nBransoletka jest idealna zarówno dla kobiety, jak i dla mężczyzny. ',60,'czerwona','4_1.4_2.',0),(5,'Naszyjnik stal + rzemień skórzany','u','Elegancki naszyjnik/obroża z czarnego ręcznie plecionego rzemienia skórzanego gr.6mm. \r\nDodatkowym atutem jest niezwykle solidne zapięcie magnetyczne z blokadą i piękna przekładka. \r\nZapięcie i przekładka wykonane są ze stali nierdzewnej. \r\nStal szlachetna, zwana również chirurgiczną jest odporna na korozje, nie zmienia barwy, jest hipoalergiczna - nie powoduje uczuleń. \r\nDługość 50 cm. Na życzenie mogę skrócić naszyjnik. \r\nJest idealny zarówno dla mężczyzny, jak i dla kobiety. ',69,'czarny','5_1.5_2.',0),(6,'Bransoletka monster skórzana 5mm','u','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości podwójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i element ozdobny kompas, wykonane z cyny w kolorze antycznego srebra. \r\nSzerokość rzemienia 5 mm. ',60,'turkus morski','6_1.6_2.',0),(7,'Bransoletka skórzana 5mm piórko','u','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości potrójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i 2 elementy ozdobne, wykonane z cyny w kolorze antycznego srebra. Szerokość rzemienia 5 mm. ',69,'błękitna','7_1.7_2.',0),(8,'Naszyjnik stal + zawieszka','u','Naszyjnik w formie minimalistycznej. Łańcuszek ze stali nierdzewnej PANCERKA + piękna, oryginalna i bardzo solidna zawieszka 16x45mm, \r\nwykonana z cyny srebrzonej w kolorze antycznego srebra. \r\nCałkowita długość 50 cm. Na życzenie mogę skrócić łańcuszek. \r\nNaszyjnik z zawieszką pięknie prezentuje się na szyi. ',59,'srebrny','8_1.8_2.',0),(9,'Bransoletka skóra 5mm','d','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości potrójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i 3 elementy ozdobne, wykonane z cyny w kolorze antycznego srebra. Szerokość rzemienia 5 mm. ',69,'fioletowa','9_1.9_2.',0),(10,'Bransoletka skóra 5mm łapki','d','Piękna i elegancka bransoletka w formie minimalistycznej ze skórzanego, płaskiego rzemienia doskonałej jakości potrójnie oplata nadgarstek. Dodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i 3 elementy ozdobne, wykonane z cyny w kolorze antycznego srebra. Szerokość rzemienia 5 mm. ',69,'czekoladowy brąz','10_1.10_2',0),(11,'Bransoletka skórzana 10mm serce','d','Piękna i elegancka bransoletka w formie minimalistycznej z bordowego skórzanego płaskiego rzemienia, doskonałej jakości podwójnie oplata nadgarstek. \r\nDodatkowym atutem jest oryginalne i bardzo solidne zapięcie magnetyczne i przekładka ozdobna, wykonane z cyny w kolorze antycznego srebra \r\nSzerokość rzemienia 10 mm. ',68,'czerwony','11_1.',0),(12,'Bransoletka skórzana + stal','u','Elegancka bransoletka ze skórzanego, ręcznie plecionego rzemienia, o grubości 6 mm. \r\nDodatkowym atutem jest piękne i niezwykle solidne zapięcie ze stali chirurgicznej. \r\nStal szlachetna, zwana również chirurgiczną jest odporna na korozje, nie zmienia barwy, jest hipoalergiczna - nie powoduje uczuleń. ',49,'czerwony','12_1.',0),(13,'Infinity 2 bransoletki skórzane','d','Komplet 2 bransoletek dla zakochanych :) \r\nDo wykonania bransoletek użyłam 2 płaskich, skórzanych rzemieni doskonałej jakości o szerokości 5mm ,elementu ozdobnego infinity i bardzo solidnego zapięcia magnetycznego. \r\nKolor czarny i czerwony. \r\nWszystkie elementy wykonane są z cyny w kolorze antycznego srebra. \r\nMateriały, z których wykonane są bransoletki zostały wyprodukowane w UE. \r\nPierwsza bransoletka wykonana z czarnego rzemienia o szerokości 5 mm podwójnie oplata nadgarstek. \r\nDruga bransoletka wykonana z czerwonego rzemienia o szerokości 5 mm podwójnie oplata nadgarstek. ',119,'czarna  czerwona','13_1.13_2.13_3.',1);
/*!40000 ALTER TABLE `bransoletki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bransoletkizamowienia`
--

DROP TABLE IF EXISTS `bransoletkizamowienia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bransoletkizamowienia` (
  `BransoletkaId` int(11) NOT NULL,
  `ZamowienieId` int(11) NOT NULL,
  `Ile` int(11) NOT NULL,
  `cena` int(4) DEFAULT NULL,
  PRIMARY KEY (`BransoletkaId`,`ZamowienieId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bransoletkizamowienia`
--

LOCK TABLES `bransoletkizamowienia` WRITE;
/*!40000 ALTER TABLE `bransoletkizamowienia` DISABLE KEYS */;
INSERT INTO `bransoletkizamowienia` VALUES (2,13,1,80),(2,18,1,80),(4,12,1,60),(7,11,1,69),(7,13,1,69),(8,11,1,59),(8,18,2,59),(9,11,1,69),(9,18,1,69),(10,16,1,69),(11,12,1,68),(11,14,1,68),(11,16,1,68),(12,11,1,49),(12,14,1,49),(12,16,1,49),(12,19,1,49),(13,11,1,119),(13,13,1,119),(13,15,2,119),(13,16,1,119);
/*!40000 ALTER TABLE `bransoletkizamowienia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klienci`
--

DROP TABLE IF EXISTS `klienci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klienci` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(245) DEFAULT NULL,
  `Haslo` varchar(100) NOT NULL,
  `Imie` varchar(45) NOT NULL,
  `Nazwisko` varchar(45) NOT NULL,
  `Ulica` varchar(80) NOT NULL,
  `Nr_domu` varchar(5) NOT NULL,
  `Nr_mieszkania` varchar(5) DEFAULT NULL,
  `Miejscowosc` varchar(60) NOT NULL,
  `Kod` varchar(6) NOT NULL,
  `Kraj` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klienci`
--

LOCK TABLES `klienci` WRITE;
/*!40000 ALTER TABLE `klienci` DISABLE KEYS */;
INSERT INTO `klienci` VALUES (1,'damian.wieczorek99@gmail.com','5oAAzu5R10l8M','Damian','Wieczorek','','0','0','','',''),(9,'asdd@gmail.com','5opGxgmeHRAv.','Franek','Szczypawa','','','','Warszawa','01-234',''),(11,'asd@gmail.com','5o2qnJYKkUp0A','Franek','Szczypawa','','','','','',''),(12,'asdss@gmail.com','5opGxgmeHRAv.','Adam','Kruszwil','Elbląska','123','23','Poznań','02-797','Polska'),(14,'asdasd@gmail.com','5opGxgmeHRAv.','Maciek','Wawrzyniak','','','','','',''),(15,'kinga.szczypior@gmail.com','5okgPeC9BFMTk','KINGA','SZCZYPIOR','ENCYKLOPEDYCZNA ','16','89','Warszawa','01-990','Polska'),(16,'benio@gmail.com','5opGxgmeHRAv.','Franek','Szczypawa','dasda','12','23','Warszawa','01-232','Polska'),(17,'sebastian.wieczorek11@gmail.com','5opGxgmeHRAv.','Adam','Szczypawa','da','','','','',''),(18,'asddd@gmail.com','5opGxgmeHRAv.','Franek','Ten','dasda','123','12','Warszawa','01-232','Polska'),(19,'pracowniasefory@gmail.com','5oIKLqarERW7M','Lidia','Szczypior','','','','','','');
/*!40000 ALTER TABLE `klienci` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klienci_przywileje`
--

DROP TABLE IF EXISTS `klienci_przywileje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klienci_przywileje` (
  `UserId` int(11) NOT NULL,
  `PrzywilejeId` int(11) NOT NULL,
  PRIMARY KEY (`UserId`,`PrzywilejeId`),
  KEY `Przywileje` (`PrzywilejeId`),
  CONSTRAINT `Klienci` FOREIGN KEY (`UserId`) REFERENCES `klienci` (`Id`),
  CONSTRAINT `Przywileje` FOREIGN KEY (`PrzywilejeId`) REFERENCES `przywileje` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klienci_przywileje`
--

LOCK TABLES `klienci_przywileje` WRITE;
/*!40000 ALTER TABLE `klienci_przywileje` DISABLE KEYS */;
INSERT INTO `klienci_przywileje` VALUES (1,1),(19,1);
/*!40000 ALTER TABLE `klienci_przywileje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opinie`
--

DROP TABLE IF EXISTS `opinie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opinie` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `BransoletkaId` int(11) NOT NULL,
  `KlientId` int(11) NOT NULL,
  `Ocena` enum('1','2','3','4','5') DEFAULT NULL,
  `Opinia` text,
  PRIMARY KEY (`Id`),
  KEY `OpinieBransoletkaId` (`BransoletkaId`),
  KEY `OpinieKlientId` (`KlientId`),
  CONSTRAINT `OpinieBransoletkaId` FOREIGN KEY (`BransoletkaId`) REFERENCES `bransoletki` (`Id`),
  CONSTRAINT `OpinieKlientId` FOREIGN KEY (`KlientId`) REFERENCES `klienci` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opinie`
--

LOCK TABLES `opinie` WRITE;
/*!40000 ALTER TABLE `opinie` DISABLE KEYS */;
/*!40000 ALTER TABLE `opinie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `przywileje`
--

DROP TABLE IF EXISTS `przywileje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `przywileje` (
  `Id` int(11) NOT NULL,
  `Nazwa` varchar(25) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nazwa` (`Nazwa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `przywileje`
--

LOCK TABLES `przywileje` WRITE;
/*!40000 ALTER TABLE `przywileje` DISABLE KEYS */;
INSERT INTO `przywileje` VALUES (1,'Administrator');
/*!40000 ALTER TABLE `przywileje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zamowienia`
--

DROP TABLE IF EXISTS `zamowienia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zamowienia` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `KlientId` int(11) NOT NULL,
  `Data_wprowadzenia` datetime NOT NULL,
  `Data_realizacji` date DEFAULT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ZamowieniaKlientId` (`KlientId`),
  CONSTRAINT `ZamowieniaKlientId` FOREIGN KEY (`KlientId`) REFERENCES `klienci` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zamowienia`
--

LOCK TABLES `zamowienia` WRITE;
/*!40000 ALTER TABLE `zamowienia` DISABLE KEYS */;
INSERT INTO `zamowienia` VALUES (11,1,'2018-09-24 23:16:58',NULL,0),(12,1,'2018-09-24 23:17:09','2018-09-25',1),(13,9,'2018-09-24 23:19:53','2018-09-25',1),(14,1,'2018-09-25 16:54:59',NULL,0),(15,1,'2018-09-25 16:55:26',NULL,0),(16,1,'2018-09-25 17:20:00',NULL,0),(18,1,'2018-09-25 17:53:39','2018-09-25',1),(19,1,'2018-09-27 22:38:17',NULL,0);
/*!40000 ALTER TABLE `zamowienia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zyczenia`
--

DROP TABLE IF EXISTS `zyczenia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zyczenia` (
  `userId` int(11) DEFAULT NULL,
  `bransoletId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zyczenia`
--

LOCK TABLES `zyczenia` WRITE;
/*!40000 ALTER TABLE `zyczenia` DISABLE KEYS */;
/*!40000 ALTER TABLE `zyczenia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-01 13:46:06
