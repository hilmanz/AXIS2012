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
/*Table structure for table `tbl_fb_wordcloud` */

DROP TABLE IF EXISTS `tbl_fb_wordcloud`;

CREATE TABLE `tbl_fb_wordcloud` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(140) DEFAULT NULL,
  `total` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=1064 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_fb_wordcloud` */

insert  into `tbl_fb_wordcloud`(`id`,`keyword`,`total`) values (1,'hayo',1),(2,'siapa',5),(3,'yang',26),(4,'bau',2),(5,'badan',2),(6,'jangan',4),(7,'sampe',1),(8,'dijauhin',1),(9,'orang',2),(10,'gara',2),(14,'baru',2),(16,'ini',11),(17,'sebuah',4),(18,'perusahaan',1),(19,'jepang',1),(20,'menemukan',1),(21,'cara',1),(22,'membawa',1),(23,'panca',1),(24,'indera',1),(25,'lain',4),(26,'dalam',6),(27,'interaksi',1),(28,'pengguna',1),(29,'dengan',17),(30,'gadgetnya',1),(31,'chaku',1),(32,'perfume',1),(33,'telah',3),(34,'merilis',1),(36,'kombinasi',1),(37,'aplikasi',2),(38,'dan',24),(39,'asesoris',1),(41,'memungkinkan',2),(42,'smartphone',1),(43,'anda',1),(44,'menentukan',1),(45,'kapan',1),(46,'saatnya',2),(47,'menyemburkan',1),(48,'aroma',1),(49,'wewangian',1),(50,'info',8),(51,'lengkapnya',2),(52,'bisa',8),(53,'cek',6),(54,'www',1),(55,'selular',1),(56,'ngulikgadget',2),(57,'sekarang',3),(58,'udah',1),(59,'banyak',1),(60,'banget',2),(61,'konten',4),(62,'multimedia',1),(64,'berbasis',3),(65,'internet',5),(66,'tapi',1),(69,'suara',3),(70,'gak',2),(71,'ada',9),(72,'matinya',1),(73,'buktinya',1),(74,'seperti',1),(75,'fitur',5),(76,'ring',1),(77,'back',1),(78,'tone',1),(79,'nah',3),(82,'lagi',6),(84,'apik',1),(88,'sentuhan',1),(89,'beda',1),(90,'yakni',1),(91,'axis',19),(92,'voice',1),(93,'portal',1),(96,'digadang',1),(97,'awal',1),(98,'oktober',3),(99,'lalu',2),(101,'menyajikan',1),(104,'seru',2),(107,'bentuk',1),(109,'penasaran',1),(110,'kan',1),(111,'baca',1),(114,'tingtong',1),(115,'kesempatan',2),(116,'buat',5),(117,'vote',2),(118,'blogger',1),(119,'favorite',2),(120,'masih',1),(121,'dibuka',1),(122,'loh',1),(123,'buruan',2),(124,'dukung',1),(125,'blog',4),(126,'dari',5),(127,'indonesia',12),(128,'axisblogawards',3),(130,'lebih',5),(131,'lengkap',2),(133,'kategori',1),(134,'nominasinya',1),(136,'kamu',17),(138,'semua',3),(139,'nominasi',1),(141,'merupakan',2),(144,'favorit',2),(147,'dinilai',1),(149,'konsisten',1),(150,'serta',1),(152,'memiliki',3),(153,'pembaca',1),(154,'setia',1),(156,'nyari',1),(157,'sim',1),(158,'nano',4),(159,'dapatkan',4),(160,'axispro',4),(162,'untuk',8),(163,'gadget',2),(164,'terbarumu',1),(166,'shop',1),(167,'terdekat',1),(168,'hanya',5),(170,'rp1',1),(171,'500',1),(174,'membeli',1),(179,'langsung',3),(181,'gunakan',1),(183,'mengaktifkan',1),(184,'paket',2),(186,'unlimited',2),(187,'basic',1),(188,'senilai',1),(189,'rp49',1),(190,'000',1),(194,'tetap',1),(195,'ingin',3),(196,'menggunakan',2),(197,'nomor',2),(198,'axismu',2),(201,'tinggal',1),(202,'menukar',1),(203,'simcard',1),(208,'bebas',1),(209,'biaya',1),(210,'klik',2),(211,'pssstt',1),(213,'menawarkan',1),(215,'dahsyat',1),(217,'htc',1),(218,'sensation',1),(219,'light',1),(220,'edition',1),(225,'terbaik',1),(228,'kebutuhanmu',1),(230,'kartu',3),(231,'perdana',1),(233,'pro',1),(235,'gratis',2),(238,'selama',2),(239,'hari',7),(241,'akan',4),(242,'makin',1),(243,'puas',1),(246,'barumu',1),(248,'perlu',2),(249,'bukti',1),(251,'disini',1),(253,'penawaran',1),(254,'terbatas',1),(255,'selamat',9),(256,'pagi',2),(260,'special',1),(261,'memberikan',1),(262,'review',2),(265,'terbaru',1),(268,'membantu',1),(269,'mempermudah',1),(270,'hidup',2),(271,'kita',5),(272,'sehari',1),(275,'tau',1),(276,'salah',2),(277,'satunya',1),(278,'adalah',1),(281,'tunggu',2),(284,'terus',3),(285,'update',1),(289,'beraktivitas',2),(291,'malam',1),(292,'menurut',1),(294,'film',4),(295,'apa',1),(296,'sih',1),(298,'musik',2),(299,'soundtrack',2),(300,'nya',3),(301,'keren',3),(303,'kamusmusik',4),(304,'penyanyi',2),(305,'nyentrik',1),(306,'lady',1),(307,'gaga',1),(308,'kabarnya',1),(310,'menulis',1),(311,'lagu',2),(313,'dijadikan',2),(315,'resmi',1),(317,'the',3),(318,'great',1),(319,'gatsby',1),(320,'berita',1),(321,'itu',3),(322,'datang',3),(325,'seorang',1),(326,'pemeran',2),(328,'tersebut',2),(329,'adelaide',2),(330,'clemens',1),(332,'ialah',1),(334,'catherine',1),(335,'wilson',1),(338,'adaptasi',1),(340,'novel',1),(341,'berjudul',1),(342,'sama',5),(345,'waw',1),(348,'bikin',1),(349,'heboh',1),(350,'nih',1),(351,'acara',1),(352,'hai',2),(353,'day',2),(354,'tanggal',1),(355,'â€“',1),(357,'parkir',2),(358,'timur',2),(359,'senayan',2),(361,'bagi',2),(363,'hadiah',2),(364,'android',2),(365,'buah',2),(366,'modem',2),(367,'isi',5),(368,'ulang',4),(371,'souvenir',1),(373,'setiap',1),(374,'harinya',1),(376,'stand',5),(377,'â€œaxis',1),(379,'raceâ€',1),(380,'ikutan',2),(381,'permainannya',1),(383,'kupon',3),(384,'sebanyak',1),(385,'banyaknya',1),(387,'raih',1),(388,'hadiahnya',1),(389,'caranya',3),(390,'gampang',1),(392,'lakukan',1),(393,'minimal',1),(395,'pilihan',2),(396,'dibawah',1),(401,'tiap',1),(403,'ikuti',1),(404,'semuanya',1),(407,'ketiga',1),(408,'kuponnya',2),(409,'â€˜likeâ€™',1),(410,'fanpage',2),(414,'komunitas',1),(415,'sekolah',1),(417,'atau',6),(418,'follow',1),(419,'twitter',3),(420,'@axisgsm',1),(422,'@sekolahaxis',1),(424,'check',1),(425,'via',1),(426,'foursquare',1),(431,'2012',2),(432,'share',4),(433,'aktifitas',1),(435,'status',2),(438,'upload',1),(439,'foto',1),(440,'facebook',2),(444,'hashtag',1),(445,'haiaxis',3),(449,'masukan',1),(451,'box',1),(456,'kalau',3),(458,'mau',3),(459,'nambah',1),(462,'cukup',1),(463,'beli',1),(466,'5ribu',1),(467,'tunjukin',1),(468,'nota',1),(469,'belanjanya',1),(470,'crew',1),(484,'belum',2),(487,'besok',2),(488,'voting',1),(489,'kami',1),(490,'tutup',1),(491,'lho',1),(492,'cepet',1),(493,'beri',1),(494,'dukungan',1),(496,'blog2',1),(498,'kalian',1),(499,'kalo',1),(501,'berinteraksi',2),(503,'musisi',3),(506,'pilih',1),(508,'soalnya',1),(509,'jejaring',1),(510,'sosial',1),(511,'google+',1),(512,'membuat',2),(513,'halaman',1),(514,'khusus',2),(515,'bernama',1),(516,'google',2),(519,'stage',2),(522,'para',3),(527,'berekspresi',1),(530,'penggemarnya',1),(532,'proyek',1),(535,'bekerja',1),(538,'tujuh',1),(539,'label',1),(542,'yaitu',1),(543,'warner',1),(544,'music',2),(545,'musica',1),(546,'studio',1),(547,'sony',1),(549,'entertainment',1),(550,'digital',1),(551,'rantai',1),(552,'maya',1),(553,'aquarius',1),(554,'musikindo',1),(555,'alfa',1),(556,'kreasitama',1),(558,'trinity',1),(559,'optima',1),(560,'production',1),(561,'sementara',2),(566,'grup',1),(567,'band',4),(569,'berpartisipasi',1),(575,'antara',1),(577,'kotak',1),(578,'saykoji',1),(579,'smash',1),(580,'rocks',1),(581,'afgan',1),(582,'vidi',1),(583,'aldiano',1),(584,'alexa',1),(585,'lyla',1),(586,'pee',1),(587,'wee',1),(588,'gaskins',1),(589,'masiv',1),(590,'hingga',1),(591,'nidji',1),(592,'zonamusik',1),(594,'siang',1),(595,'sudah',3),(603,'5000',1),(606,'seminggu',1),(607,'berlaku',1),(608,'sampai',1),(609,'akhir',1),(610,'2013',1),(614,'register',3),(617,'ketik',2),(618,'123',2),(620,'kali',1),(622,'diawal',1),(623,'sebelum',1),(624,'desember',1),(628,'lanjut',3),(631,'liat',1),(632,'videonya',1),(633,'axisbigsale',2),(636,'suka',3),(639,'noah',3),(640,'ayo',2),(641,'berlangganan',1),(642,'content',2),(648,'kirim',4),(649,'9388',1),(651,'tarif',1),(652,'2000',1),(653,'minggu',1),(657,'dapat',3),(658,'sms',6),(659,'berisi',2),(663,'berupa',1),(664,'fulltrack',1),(665,'rbt',1),(666,'video',1),(668,'wallpaper',1),(669,'profile',1),(671,'juga',6),(672,'updates',1),(674,'good',1),(675,'morning',1),(676,'pernah',1),(677,'berkhayal',1),(678,'pengen',1),(680,'berinterasi',1),(687,'khawatir',1),(690,'solusinya',1),(691,'nanti',1),(693,'bahas',1),(700,'pada',1),(702,'1928',1),(703,'pemuda',7),(705,'bertekad',1),(707,'berikrar',1),(708,'demi',1),(709,'mengangkat',1),(710,'harkat',1),(712,'martabat',1),(716,'asli',2),(717,'tekad',1),(718,'inilah',1),(720,'menjadi',3),(721,'komitmen',1),(722,'perjuangan',1),(723,'rakyat',1),(725,'era',1),(726,'modern',1),(732,'berjuang',1),(735,'bangsa',1),(738,'berkarya',2),(739,'secara',1),(740,'positif',1),(742,'perkembangan',1),(744,'sendiri',1),(747,'sumpah',3),(749,'yah',1),(750,'minggusantai',4),(751,'edisi',1),(752,'long',1),(753,'weekend',1),(757,'berakhir',1),(759,'emosi',3),(761,'inget',1),(763,'harus',2),(764,'masuk',1),(765,'kerja',1),(767,'senyang',1),(768,'china',1),(771,'toko',2),(772,'unik',2),(773,'tempat',3),(774,'meluapkan',2),(782,'berada',4),(784,'pusat',1),(785,'perbelanjaan',1),(788,'area',1),(791,'barang',2),(793,'elektronik',1),(795,'alat',1),(796,'rumah',1),(797,'tangga',1),(799,'boleh',1),(800,'dirusak',1),(801,'dipecahkan',1),(803,'dihancurkan',1),(804,'oleh',5),(805,'konsumen',1),(806,'namun',1),(807,'tentu',1),(808,'saja',1),(810,'harga',1),(813,'dibayar',1),(815,'konsumennya',1),(816,'meskipun',1),(817,'begitu',1),(818,'sayangnya',1),(822,'khususkan',1),(824,'wanita',1),(827,'meredakan',1),(828,'stress',1),(830,'amarah',1),(833,'keluarkan',1),(837,'suatu',1),(838,'kalimat',1),(840,'berbagai',1),(841,'bahasa',1),(843,'punya',1),(845,'penerjemah',1),(848,'100',1),(852,'9855',2),(854,'ikutin',1),(855,'aja',2),(856,'format',1),(859,'spasi',1),(860,'contoh',1),(861,'saya',1),(862,'cinta',1),(863,'bebeb',1),(871,'silahkan',1),(872,'mencoba',1),(875,'khas',1),(876,'daerah',2),(877,'mana',1),(879,'paling',1),(882,'beberapa',1),(884,'sumatera',1),(885,'durian',2),(886,'diolah',1),(888,'lauk',2),(889,'alias',1),(890,'dimakan',2),(892,'nasi',2),(894,'lampung',4),(895,'tampoyak',4),(897,'hal',1),(898,'lazim',1),(900,'masyarakat',2),(908,'difermentasi',1),(917,'ataupun',1),(918,'bumbu',1),(919,'masakan',1),(920,'selain',1),(922,'sebagai',1),(923,'campuran',1),(924,'sambal',1),(926,'berkesempatan',1),(927,'mampir',3),(929,'maka',1),(931,'lewatkan',1),(933,'mencicipi',1),(935,'jalansore',1),(939,'salahnya',1),(942,'ucapan',1),(947,'teman',4),(950,'karena',1),(953,'bayar',1),(954,'1000',2),(959,'operator',1),(960,'seharian',1),(969,'ibadah',1),(970,'nyaman',1),(971,'tak',1),(973,'ganti',1),(975,'nikmati',1),(976,'hematnya',1),(977,'layanan',1),(979,'saat',1),(981,'arab',3),(982,'saudi',3),(983,'sehingga',1),(986,'terhubung',1),(988,'keluarga',1),(993,'aktifkan',1),(996,'lokal',1),(1001,'pastikan',1),(1004,'jaringan',1),(1005,'stc',1),(1006,'aljawal',1),(1007,'ksa',1),(1029,'lupa',1),(1036,'haiday',1),(1042,'race',1),(1055,'ajakin',1),(1057,'temen',2),(1061,'ketemu',1),(1062,'disana',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;