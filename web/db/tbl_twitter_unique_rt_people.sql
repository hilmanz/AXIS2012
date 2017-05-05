/*
SQLyog Community v10.12 
MySQL - 5.5.21-55 : Database - axis_report_2012
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tbl_twitter_unique_rt_people` */

DROP TABLE IF EXISTS `tbl_twitter_unique_rt_people`;

CREATE TABLE `tbl_twitter_unique_rt_people` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(140) DEFAULT NULL,
  `dtreport` date DEFAULT NULL,
  `total` bigint(21) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`twitter_id`,`dtreport`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_twitter_unique_rt_people` */

insert  into `tbl_twitter_unique_rt_people`(`id`,`twitter_id`,`dtreport`,`total`) values (1,'JavaSoulnation','2011-09-22',1),(2,'JavaSoulnation','2011-09-23',160),(3,'JavaSoulnation','2011-09-24',256),(4,'JavaSoulnation','2011-09-25',121),(5,'JavaSoulnation','2011-09-26',7),(6,'JavaSoulnation','2011-09-27',1),(7,'vidialdiano','2011-09-23',17),(8,'vidialdiano','2011-09-24',36),(9,'vidialdiano','2011-09-25',80),(10,'vidialdiano','2011-09-26',2),(11,'vidialdiano','2011-10-01',1),(12,'detikcom','2011-09-23',44),(13,'detikcom','2011-09-24',53),(14,'detikcom','2011-09-25',13),(15,'detikcom','2011-09-26',54);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
