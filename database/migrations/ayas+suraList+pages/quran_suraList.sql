-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: quran
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `suraList`
--

DROP TABLE IF EXISTS `suraList`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suraList` (
  `id` int(11) NOT NULL COMMENT '	',
  `alphabetical` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `verses` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `place` varchar(45) DEFAULT NULL,
  `noldeke` int(11) DEFAULT NULL,
  `start` int(6) DEFAULT NULL,
  `end` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suraList`
--

LOCK TABLES `suraList` WRITE;
/*!40000 ALTER TABLE `suraList` DISABLE KEYS */;
INSERT INTO `suraList` VALUES (1,63,'فاتحه',7,5,'مکه',48,1,1),(2,18,'بقره',286,87,'مدینه',91,2,49),(3,1,'آل عمران',200,89,'مدینه',97,50,76),(4,104,'نساء',176,92,'مدینه',100,77,106),(5,85,'مائده',120,113,'مدینه',114,106,127),(6,14,'انعام',165,55,'مکه',89,128,150),(7,7,'اعراف',206,39,'مکه',87,151,176),(8,15,'انفال',75,88,'مدینه',95,177,186),(9,23,'توبه',129,114,'مدینه',113,187,207),(10,114,'یونس',109,51,'مکه',84,208,221),(11,110,'هود',123,52,'مکه',75,221,235),(12,113,'یوسف',111,53,'مکه',77,235,248),(13,10,'الرعد',43,96,'مدینه',90,249,255),(14,2,'ابراهیم',52,72,'مکه',76,255,261),(15,32,'حجر',99,54,'مکه',57,262,267),(16,103,'نحل',128,70,'مکه',73,267,281),(17,6,'اسراء',111,50,'مکه',67,282,293),(18,80,'کهف',110,69,'مکه',69,293,304),(19,91,'مریم',98,44,'مکه',58,305,312),(20,54,'طه',135,45,'مکه',55,312,321),(21,11,'انبیاء',112,73,'مکه',65,322,331),(22,31,'حج',78,104,'مدینه',107,332,341),(23,84,'مؤمنون',118,74,'مکه',64,342,349),(24,108,'نور',64,103,'مدینه',105,350,359),(25,67,'فرقان',77,42,'مکه',66,359,366),(26,45,'شعراء',227,47,'مکه',56,367,376),(27,106,'نمل',93,48,'مکه',68,377,385),(28,75,'قصص',88,49,'مکه',79,385,396),(29,60,'عنکبوت',69,85,'مکه',81,396,404),(30,38,'روم',60,84,'مکه',74,404,410),(31,82,'لقمان',34,57,'مکه',82,411,414),(32,43,'سجدة',30,75,'مکه',70,415,417),(33,3,'احزاب',73,90,'مدینه',103,418,427),(34,42,'سبأ',54,58,'مکه',85,428,434),(35,64,'فاطر',45,43,'مکه',86,434,440),(36,112,'یس',83,41,'مکه',60,440,445),(37,49,'صافات',182,56,'مکه',50,446,452),(38,48,'ص',88,38,'مکه',59,453,458),(39,41,'زمر',75,59,'مکه',80,458,467),(40,62,'غافر',85,60,'مکه',78,467,476),(41,68,'فصلت',54,61,'مکه',71,477,482),(42,47,'شوری',53,62,'مکه',83,483,489),(43,39,'زخرف',89,63,'مکه',61,489,495),(44,36,'دخان',59,64,'مکه',53,496,498),(45,27,'جاثیة',37,65,'مکه',72,499,502),(46,4,'احقاف',35,66,'مکه',88,502,506),(47,88,'محمد',38,95,'مدینه',96,507,510),(48,65,'فتح',29,112,'مدینه',108,511,515),(49,33,'حجرات',18,107,'مدینه',112,515,517),(50,71,'ق',45,34,'مکه',54,518,520),(51,37,'ذاریات',60,67,'مکه',39,520,523),(52,55,'طور',49,76,'مکه',40,523,525),(53,102,'نجم',62,23,'مکه',28,526,528),(54,77,'قمر',55,37,'مکه',49,528,531),(55,9,'الرحمن',78,97,'مدینه',43,531,534),(56,111,'واقعه',96,46,'مکه',41,534,537),(57,34,'حدید',29,94,'مدینه',99,537,541),(58,87,'مجادله',22,106,'مدینه',106,542,545),(59,35,'حشر',24,101,'مدینه',102,545,548),(60,97,'ممتحنه',13,91,'مدینه',110,549,551),(61,50,'صف',14,111,'مدینه',98,551,552),(62,28,'جمعه',11,109,'مدینه',94,553,554),(63,98,'منافقون',11,105,'مدینه',104,554,555),(64,22,'تغابن',18,110,'مدینه',93,556,557),(65,53,'طلاق',12,99,'مدینه',101,558,559),(66,21,'تحریم',12,108,'مدینه',109,560,561),(67,96,'ملک',30,77,'مکه',63,562,564),(68,76,'قلم',52,2,'مکه',18,564,566),(69,30,'حاقه',52,78,'مکه',38,566,568),(70,95,'معارج',44,79,'مکه',42,568,570),(71,107,'نوح',28,71,'مکه',51,570,571),(72,29,'جن',28,40,'مکه',62,572,573),(73,92,'مزمل',20,3,'مکه',23,574,575),(74,89,'مدثر',56,4,'مکه',2,575,577),(75,78,'قیامه',40,31,'مکه',36,577,578),(76,12,'انسان',31,98,'مدینه',52,578,580),(77,90,'مرسلات',50,33,'مکه',32,580,581),(78,101,'نبأ',40,80,'مکه',33,582,583),(79,99,'نازعات',46,81,'مکه',31,583,584),(80,57,'عبس',42,24,'مکه',17,585,585),(81,25,'تکویر',29,7,'مکه',27,586,586),(82,16,'انفطار',19,82,'مکه',26,587,587),(83,94,'مطففین',36,86,'مکه',37,587,589),(84,13,'انشقاق',25,83,'مکه',29,589,589),(85,17,'بروج',22,27,'مکه',22,590,590),(86,52,'طارق',17,36,'مکه',15,591,591),(87,8,'اعلی',19,8,'مکه',19,591,592),(88,61,'غاشیه',26,68,'مکه',34,592,592),(89,66,'فجر',30,10,'مکه',35,593,594),(90,19,'بلد',20,35,'مکه',11,594,594),(91,46,'شمس',15,26,'مکه',16,595,595),(92,83,'لیل',21,9,'مکه',10,595,596),(93,51,'ضحی',11,11,'مکه',13,596,596),(94,44,'انشراح',8,12,'مکه',12,596,596),(95,26,'تین',8,28,'مکه',20,597,597),(96,59,'علق',19,1,'مکه',1,597,597),(97,73,'قدر',5,25,'مکه',14,598,598),(98,20,'بینه',8,100,'مدینه',92,598,599),(99,40,'زلزال',8,93,'مدینه',25,599,599),(100,56,'عادیات',11,14,'مکه',30,599,600),(101,72,'قارعة',11,30,'مکه',24,600,600),(102,24,'تکاثر',8,16,'مکه',8,600,600),(103,58,'عصر',3,13,'مکه',21,601,601),(104,109,'همزه',9,32,'مکه',6,601,601),(105,70,'فیل',5,19,'مکه',9,601,601),(106,74,'قریش',4,29,'مکه',4,602,602),(107,86,'ماعون',7,17,'مکه',7,602,602),(108,81,'کوثر',3,15,'مکه',5,602,602),(109,79,'کافرون',6,18,'مکه',45,603,603),(110,105,'نصر',3,102,'مدینه',111,603,603),(111,93,'مسد',5,6,'مکه',3,603,603),(112,5,'اخلاص',4,22,'مکه',44,604,604),(113,69,'فلق',5,20,'مکه',46,604,604),(114,100,'ناس',6,21,'مکه',47,604,604);
/*!40000 ALTER TABLE `suraList` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-05 13:12:17
