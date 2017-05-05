ALTER TABLE `axis_report_2012`.`tbl_gplus_daily` CHANGE `date` `date` DATE NOT NULL; 
ALTER TABLE `axis_report_2012`.`tbl_gplus_top_post` DROP `date`;
ALTER TABLE `axis_report_2012`.`tbl_gplus_top_post` ADD UNIQUE INDEX `IDX_feed_id` (`gplus_feeds_id`); 
CREATE TABLE `tbl_twitter_author_feeds` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `author_id` varchar(140) DEFAULT NULL,
  `feed_id` bigint(21) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `content` varchar(140) DEFAULT NULL,
  `impression` bigint(21) DEFAULT '0',
  `rt` bigint(21) DEFAULT '0',
  `rt_impression` bigint(21) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`author_id`,`feed_id`)
) ENGINE=InnoDB AUTO_INCREMENT=591 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_twitter_daily_stats` */

CREATE TABLE `tbl_twitter_daily_stats` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(21) DEFAULT NULL,
  `author_id` varchar(140) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `mentions` int(11) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `rt_impressions` int(11) DEFAULT NULL,
  `rt` int(11) DEFAULT NULL,
  `sentiment` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`topic_id`,`author_id`,`post_date`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_twitter_feeds_job` */

CREATE TABLE `tbl_twitter_feeds_job` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(140) DEFAULT NULL,
  `last_id` bigint(21) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNQ` (`twitter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_twitter_wordcloud` */

CREATE TABLE `tbl_twitter_wordcloud` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(140) DEFAULT NULL,
  `keyword` varchar(140) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`twitter_id`,`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8;

/*Article contextual */
CREATE TABLE `article_contextual_category` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `content_id` bigint(21) DEFAULT NULL,
  `category_id` bigint(21) DEFAULT NULL,
  `weight` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`content_id`,`category_id`),
  KEY `IDX_WEIGHT` (`content_id`,`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8

CREATE TABLE `bot_job` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `job_id` varchar(140) DEFAULT NULL,
  `last_id` bigint(21) DEFAULT '0',
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bot_job` */

insert  into `bot_job`(`id`,`job_id`,`last_id`,`last_update`) values (1,'article_contextual',0,NULL),(2,'user_preference_tracking',0,NULL);


CREATE TABLE `job_content_preference` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(21) DEFAULT NULL,
  `content_id` bigint(21) DEFAULT NULL,
  `n_status` tinyint(3) DEFAULT '0' COMMENT '0->queue, 1-> done',
  PRIMARY KEY (`id`),
  KEY `IDX_status` (`n_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `category_keywords` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(140) DEFAULT NULL,
  `keyword` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE` (`category_id`,`keyword`),
  KEY `IDX_Keyword` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `category_keywords` */

insert  into `category_keywords`(`id`,`category_id`,`category_name`,`keyword`) values (1,1,'music','music'),(2,1,'music','gitar'),(3,1,'music','vokalis'),(4,1,'music','pemain gitar'),(5,1,'music','bass'),(6,1,'music','pemain bass'),(7,1,'music','drum'),(8,1,'music','penabuh drum'),(9,1,'music','drummer'),(10,1,'music','musik'),(11,1,'music','pemain musik'),(12,1,'music','penyanyi'),(13,1,'music','penyanyi band'),(14,1,'music','band musik'),(15,1,'music','rock star'),(16,1,'music','rockstar'),(17,2,'sport','soccer'),(18,2,'sport','football'),(19,2,'sport','tenis'),(20,2,'sport','tennis'),(21,2,'sport','sepak bola'),(22,2,'sport','sepakbola'),(23,2,'sport','kiper'),(24,2,'sport','striker'),(25,2,'sport','sepatu bola'),(26,2,'sport','gawang'),(27,2,'sport','penjaga gawang'),(28,2,'sport','goal'),(29,2,'sport','gol'),(30,2,'sport','mencetak gol'),(31,3,'lifestyle','fashion'),(32,3,'lifestyle','sepatu'),(33,3,'lifestyle','sepatu baru'),(34,3,'lifestyle','sepatu merah'),(35,3,'lifestyle','travel'),(36,3,'lifestyle','makan'),(37,4,'mobile','sms'),(38,4,'mobile','pulsa'),(39,4,'mobile','internet');
