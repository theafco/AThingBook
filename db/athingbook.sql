-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 20, 2012 at 04:20 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `athingbook`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `content`
-- 

CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `format_id` tinyint(4) NOT NULL default '0',
  `category_id` int(10) unsigned NOT NULL,
  `created_date` date NOT NULL,
  `created_by_id` int(10) unsigned NOT NULL,
  `is_published` char(1) NOT NULL default '0',
  `is_deleted` char(1) NOT NULL default '0',
  `rowid` binary(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- 
-- Dumping data for table `content`
-- 

INSERT INTO `content` VALUES (1, 'เรื่องราว13', '', 0, 1, '2012-02-07', 1, '0', '0', 0x4546384130423446433142303443414242393644303730304130443237343841);
INSERT INTO `content` VALUES (2, 'asdf', '', 0, 1, '2012-02-07', 1, '0', '1', 0x4136363730373739384333343439354639444233424243434244413031383339);
INSERT INTO `content` VALUES (3, 'หมื่นตาทดสอบ', '', 0, 2, '2012-02-08', 1, '0', '0', 0x3342423137333436454233463441464639313145353634414639323038303636);
INSERT INTO `content` VALUES (4, 'test', '', 0, 1, '2012-02-08', 1, '0', '1', 0x4242344339463835334635453445314641434135453235313542433435384336);
INSERT INTO `content` VALUES (5, 'test2', '', 0, 1, '2012-02-08', 1, '0', '1', 0x3439353334414438323141433437373739304245434141443045423532343533);
INSERT INTO `content` VALUES (6, 'debug', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3631463833463032363537373431373941393634363539453330433442443946);
INSERT INTO `content` VALUES (7, 'asdf', '', 0, 1, '2012-02-08', 1, '0', '1', 0x4437413245463834444638363437394141323043453334443742343031313631);
INSERT INTO `content` VALUES (8, 'teset', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3836423236383234313939453442344441454442363043453944423535394534);
INSERT INTO `content` VALUES (9, 'test123', '', 0, 1, '2012-02-08', 1, '0', '1', 0x3839373732464346434344423445384238344443383935343432363930374442);
INSERT INTO `content` VALUES (10, 'test123', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3335453843374235423633393442314239393336314439323530433339383832);
INSERT INTO `content` VALUES (11, 'test1', '', 0, 1, '2012-02-08', 1, '0', '1', 0x4637343844343238353536413438333438413432303034314539374433313242);
INSERT INTO `content` VALUES (12, '3423asdfsa', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3434373842354141444642313445453441303930464130353731393945333037);
INSERT INTO `content` VALUES (13, 'adfasdfas', '', 0, 2, '2012-02-08', 1, '0', '0', 0x3430433734393031353143433438464438454244414131413235373431333345);
INSERT INTO `content` VALUES (14, 'asdfasdf', '', 0, 2, '2012-02-08', 1, '0', '0', 0x3034454644444144384536333439353539413546363641444135433746393233);
INSERT INTO `content` VALUES (15, 'asdfasdf', '', 0, 1, '2012-02-08', 1, '0', '1', 0x3646323546393631393134323444393141464444433934363736414238423430);
INSERT INTO `content` VALUES (16, 'asdfasdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3933344235314639453031323438354642374346323341323343393644424538);
INSERT INTO `content` VALUES (17, 'asdfasd', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3844393332353346433034373443343941344641414441333641394143413333);
INSERT INTO `content` VALUES (18, 'asdfasdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x4532434546303639313531353433363938373535463937363443444433433333);
INSERT INTO `content` VALUES (19, 'asdfasdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3730383242344330463433303430454138323245433730463230393943393346);
INSERT INTO `content` VALUES (20, 'asdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3933314341444434443735443438323139354341313335324345453238323437);
INSERT INTO `content` VALUES (21, '4534', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3443364231373130424136353441413838383036453835383234334633343841);
INSERT INTO `content` VALUES (22, 'asdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3043393337344341424136443436353638303130434346424145444130394338);
INSERT INTO `content` VALUES (23, 'asdfasdf', '', 0, 1, '2012-02-08', 1, '0', '0', 0x4246443133384634354633433436433242463141453345373139374239463435);
INSERT INTO `content` VALUES (24, 'ทดสอบเรื่องราว', '', 0, 1, '2012-02-08', 1, '0', '0', 0x4543454336433342433532463442373138414131353945334131433945453930);
INSERT INTO `content` VALUES (25, 'ทดสอบเรื่องราว', '', 0, 1, '2012-02-08', 1, '0', '0', 0x3545393930394544323645433437463639454237424143454546433936444335);
INSERT INTO `content` VALUES (26, 'เรื่องราวของฉัน', '<b> ทดสอบเรื่องราว</b>', 0, 1, '2012-02-08', 1, '0', '0', 0x3546333531364533363632303436363041314341433737383033393746324441);
INSERT INTO `content` VALUES (27, 'เรื่องราวของฉัน(2)', '', 0, 1, '2012-02-08', 1, '1', '0', 0x4331333837374545373246363433443739413932384141433237364233453842);
INSERT INTO `content` VALUES (28, 'ทดสอบนะจ๊ะ', '', 0, 1, '2012-02-09', 1, '0', '0', 0x3538304543443036413535393439414341363144413931333430424538303738);
INSERT INTO `content` VALUES (29, 'test', '', 0, 1, '2012-02-13', 1, '0', '0', 0x3531333134433942303739413445423339383331303533423337393032343433);

-- --------------------------------------------------------

-- 
-- Table structure for table `content_category`
-- 

CREATE TABLE `content_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `content_category`
-- 

INSERT INTO `content_category` VALUES (1, 'บทความ');
INSERT INTO `content_category` VALUES (2, 'การ์ตูน');
INSERT INTO `content_category` VALUES (3, 'ข่าวสาร-กิจกรรม');
INSERT INTO `content_category` VALUES (4, 'อื่นๆ');

-- --------------------------------------------------------

-- 
-- Table structure for table `product`
-- 

CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` text,
  `normal_price` decimal(10,0) NOT NULL,
  `sale_price` decimal(10,0) default NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_date` date NOT NULL,
  `is_deleted` char(1) NOT NULL default '0',
  `rowid` binary(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `product`
-- 

INSERT INTO `product` VALUES (1, 'สงสัยมั้ย ? ธรรมะ', '"การทำบุญสมัยนี้ มักเป็นการทำบุญที่ลงทุนมาก แต่ได้ผลบุญน้อยนัก"', 150, 140, 1, '2011-12-26', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (2, 'ธรรมทาน A', '<b><i>ทดสอบ HTML</i></b>', 250, NULL, 2, '2011-12-27', '1', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (3, 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '"ปล่อยวางด้วยใจ ใช่คำพูด"', 180, 150, 1, '2012-02-14', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (4, 'หมื่นตา ธรรมะ เล่ม 1', '\\"หมื่นรู้ มิสู้ ปล่อยวาง\\"', 180, 150, 1, '2012-02-14', '1', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (5, 'หมื่นตา ธรรมะ เล่ม 1', '"หมื่นรู้ มิสู้ ปล่อยวาง"', 180, 150, 1, '2012-02-14', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (6, 'ธรรมะธรรมทาน: รู้-ละ ยังไงในเวลาชีวิต', 'คุณกำลังประมาทต่อเวลาของชีวิตกันอยู่รึเปล่า..?', 8, 0, 2, '2012-02-15', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (7, 'ทุกข์-สุข ยังไงในใจเรา', 'ความทุกข์-ความสุข ของคุณเกิดขึ้นที่ไหนเพราะเหตุใด.. ??', 8, 0, 2, '2012-02-15', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);
INSERT INTO `product` VALUES (8, 'จุดเทียนยังไงให้ชีวิต', 'เคยคิดไหมว่า "ทำไมคุณกำลังทุกข์เพราะลืมอะไรไปหรือเปล่า ????"', 8, 0, 2, '2012-02-15', '0', 0x0000000000000000000000000000000000000000000000000000000000000000);

-- --------------------------------------------------------

-- 
-- Table structure for table `product_category`
-- 

CREATE TABLE `product_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `product_category`
-- 

INSERT INTO `product_category` VALUES (1, 'หนังสือทั่วไป');
INSERT INTO `product_category` VALUES (2, 'หนังสือธรรมทาน');

-- --------------------------------------------------------

-- 
-- Table structure for table `product_order`
-- 

CREATE TABLE `product_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_date` datetime NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `shipping_name` varchar(100) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_subdistrict` varchar(50) NOT NULL,
  `shipping_district` varchar(50) NOT NULL,
  `shipping_province_code` tinyint(3) NOT NULL,
  `shipping_zipcode` varchar(5) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `is_deleted` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `product_order`
-- 

INSERT INTO `product_order` VALUES (1, '2012-02-16 17:36:07', 1, 'เวย์คุง', 'xxx', 'xxx', 'xxx', 10, '10210', 0, '0');
INSERT INTO `product_order` VALUES (2, '2012-02-19 02:06:26', 0, 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', 10, '10241', 0, '0');
INSERT INTO `product_order` VALUES (3, '2012-02-19 02:15:14', 2, 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', 10, '10241', 1500150, '0');
INSERT INTO `product_order` VALUES (4, '2012-02-19 02:22:46', 2, 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', 10, '10241', 1500150, '0');
INSERT INTO `product_order` VALUES (5, '2012-02-19 14:00:49', 2, 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', 10, '10241', 950, '0');

-- --------------------------------------------------------

-- 
-- Table structure for table `product_order_item`
-- 

CREATE TABLE `product_order_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_id` int(10) unsigned NOT NULL,
  `code` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `unit_price` decimal(10,0) NOT NULL,
  `unit_total_price` decimal(10,0) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `product_order_item`
-- 

INSERT INTO `product_order_item` VALUES (1, 1, '', 'รายการที่ 1', 2, 1000, 0);
INSERT INTO `product_order_item` VALUES (2, 2, '', '', 10000, 0, 0);
INSERT INTO `product_order_item` VALUES (3, 2, '', '', 1, 0, 0);
INSERT INTO `product_order_item` VALUES (4, 3, '', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', 10000, 150, 1500000);
INSERT INTO `product_order_item` VALUES (5, 3, '', 'หมื่นตา ธรรมะ เล่ม 1', 1, 150, 150);
INSERT INTO `product_order_item` VALUES (6, 4, '1-3', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', 10000, 150, 1500000);
INSERT INTO `product_order_item` VALUES (7, 4, '1-5', 'หมื่นตา ธรรมะ เล่ม 1', 1, 150, 150);
INSERT INTO `product_order_item` VALUES (8, 5, '2-8', 'จุดเทียนยังไงให้ชีวิต', 100, 8, 800);
INSERT INTO `product_order_item` VALUES (9, 5, '1-3', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', 1, 150, 150);

-- --------------------------------------------------------

-- 
-- Table structure for table `role`
-- 

CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `role`
-- 

INSERT INTO `role` VALUES (1, 'ผู้ใช้ทั่วไป');
INSERT INTO `role` VALUES (2, 'สมาชิกทั่วไป');
INSERT INTO `role` VALUES (3, 'ผู้ดูแลระบบทั่วไป');

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `id` int(6) unsigned zerofill NOT NULL auto_increment,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `gender` char(1) NOT NULL default 'm',
  `birthday` date default NULL,
  `address` varchar(255) default NULL,
  `subdistrict` varchar(50) default NULL,
  `district` varchar(50) default NULL,
  `province_code` tinyint(3) unsigned default NULL,
  `zipcode` varchar(5) default NULL,
  `telephone` varchar(10) default NULL,
  `mobilephone` varchar(10) default NULL,
  `email` varchar(100) NOT NULL,
  `password` binary(32) NOT NULL,
  `news_letter_allowed` char(1) NOT NULL default '0',
  `created_date` date NOT NULL,
  `role_id` int(11) unsigned NOT NULL default '1',
  `is_deleted` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` VALUES (000001, 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '2011-11-11', '549 <> \\'' \\"', 'ดินแดง', 'ห้วยขวาง', 10, '10240', '', '', 'root1@admin.com', 0x3231323332663239376135376135613734333839346130653461383031666333, '1', '2011-12-18', 3, '1');
INSERT INTO `user` VALUES (000002, 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '1983-11-02', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', 10, '10241', '025540616', '0865540616', 'root@admin.com', 0x3231323332663239376135376135613734333839346130653461383031666333, '1', '0000-00-00', 3, '0');
INSERT INTO `user` VALUES (000003, 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '2011-11-11', 'test', 'ดินแดง', 'ห้วยขวาง', 10, '10240', NULL, NULL, 'root@admin.com', 0x3231323332663239376135376135613734333839346130653461383031666333, '1', '2011-12-18', 3, '1');
INSERT INTO `user` VALUES (000004, 'สมคิด', 'ตั้งใจทำ', 'คิดดี', 'm', '2011-09-06', '', '', '', 10, '', NULL, NULL, 'theafco@hotmail.com', 0x3231323332663239376135376135613734333839346130653461383031666333, '1', '2012-01-04', 2, '0');
INSERT INTO `user` VALUES (000005, 'test', 'test', 'test', 'm', '2012-01-02', '', '', '', 10, '', '', '', 'test@athingbook.net', 0x3039386636626364343632316433373363616465346538333236323762346636, '1', '2012-01-05', 2, '0');
INSERT INTO `user` VALUES (000006, 'heyhey', 'hey123', 'hey', 'm', '2001-10-02', '', '', '', 10, '', '', '', 'heyhey@athingbook.net', 0x3439666665346361316635303339343437663563386534646466346235646465, '1', '2012-01-05', 2, '0');
