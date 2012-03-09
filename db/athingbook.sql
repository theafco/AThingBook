/*
Navicat MySQL Data Transfer

Source Server         : sp-vm
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : athingbook

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2012-03-09 12:59:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(6) unsigned zerofill NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by_id` int(10) unsigned NOT NULL,
  `is_published` char(1) NOT NULL default '0',
  `is_deleted` char(1) NOT NULL default '0',
  `rowid` binary(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('000001', 'เรื่องราว13', '', '<p>hello</p>', '1', '2012-02-07 00:00:00', '1', '0', '0', 'EF8A0B4FC1B04CABB96D0700A0D2748A');
INSERT INTO `article` VALUES ('000002', 'asdf', '', '', '1', '2012-02-07 00:00:00', '1', '0', '1', 'A66707798C34495F9DB3BBCCBDA01839');
INSERT INTO `article` VALUES ('000003', 'หมื่นตาทดสอบ', '', '', '2', '2012-02-08 00:00:00', '1', '0', '0', '3BB17346EB3F4AFF911E564AF9208066');
INSERT INTO `article` VALUES ('000004', 'test', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', 'BB4C9F853F5E4E1FACA5E2515BC458C6');
INSERT INTO `article` VALUES ('000005', 'test2', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '49534AD821AC477790BECAAD0EB52453');
INSERT INTO `article` VALUES ('000006', 'พู่กันเดียว - อันนำไปสู่การแตกหัก', '', '', '2', '2012-02-08 00:00:00', '1', '0', '0', '61F83F0265774179A964659E30C4BD9F');
INSERT INTO `article` VALUES ('000007', 'asdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', 'D7A2EF84DF86479AA20CE34D7B401161');
INSERT INTO `article` VALUES ('000008', 'เทวดาราฟาเอล - ปัญญาและการเรียนรู้', '', '', '2', '2012-02-08 00:00:00', '1', '0', '0', '86B26824199E4B4DAEDB60CE9DB559E4');
INSERT INTO `article` VALUES ('000009', 'test123', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '89772FCFCCDB4E8B84DC8954426907DB');
INSERT INTO `article` VALUES ('000010', 'รายการ ชีวิตสดใส กับเรื่องราวของ หมื่นตาธรรมะ', '', '', '3', '2012-02-08 00:00:00', '1', '0', '0', '35E8C7B5B6394B1B99361D9250C39882');
INSERT INTO `article` VALUES ('000011', 'test1', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', 'F748D428556A48348A420041E97D312B');
INSERT INTO `article` VALUES ('000012', '3423asdfsa', '', '', '1', '2012-02-08 00:00:00', '1', '0', '0', '4478B5AADFB14EE4A090FA057199E307');
INSERT INTO `article` VALUES ('000013', 'เทวดาราฟาเอล - ไม่รู้บ้างก็ได้', '', '', '2', '2012-02-08 00:00:00', '1', '0', '0', '40C7490151CC48FD8EBDAA1A2574133E');
INSERT INTO `article` VALUES ('000014', 'เทวดาราฟาเอล - ดอกไม้หลากสีสัน', '', '', '2', '2012-02-08 00:00:00', '1', '0', '0', '04EFDDAD8E6349559A5F66ADA5C7F923');
INSERT INTO `article` VALUES ('000015', 'asdfasdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '6F25F96191424D91AFDDC94676AB8B40');
INSERT INTO `article` VALUES ('000016', 'asdfasdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '0', '934B51F9E012485FB7CF23A23C96DBE8');
INSERT INTO `article` VALUES ('000017', 'กะก๋า ณ ศาลายา', '', '', '3', '2012-02-08 00:00:00', '1', '0', '0', '8D93253FC0474C49A4FAADA36A9ACA33');
INSERT INTO `article` VALUES ('000018', 'ปัจฉิมนิเทศที่เทคนิคเชียงใหม่', '', '<p style=\\\\\\\"text-align: center; \\\\\\\">&nbsp;<span style=\\\\\\\"color: rgb(0, 0, 205); font-size: 18px; font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">ขณะนี้เราเรียนอยู่ในรั้วการศึกษา</span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">แต่เราไม่ได้เชื่อมโยงตัวเรากับโลกภายนอกเลย</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">เคยรู้ไหมว่าคนอื่นเขาคิดอย่างไร</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">โลกจริงๆไม่ใช่แค่เรื่องที่ว่าวัยรุ่นดาราแต่งตัวยังไง</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">แต่เป็นเรื่องของ &ldquo;วิธีคิด&rdquo;</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ว่าเวลาที่เราเจอคนแบบนี้เราจะรับมืออย่างไร</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">และ &ldquo;วิธีคิด&rdquo; สำคัญกับทุกเรื่อง</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">เช่น ถ้าเรามีคนรักเราจะดูแลคนรักของเราอย่างไร</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ไม่ใช่ความรักแบบหวานแหววที่เดินจูงมือกันในโรงเรียน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">แต่เป็นความรักแบบชีวิตจริงที่เป็นชีวิตคู่</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">&ldquo;วิธีคิด&rdquo;&nbsp; จะทำให้เรารู้ว่าเราจะดูแลคนรักของเราอย่างไร</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">โลกของการทำงานจริงกับโลกของการเรียนนั้นแตกต่างกัน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">เราจะไม่มีครูมาคอยจ้ำจี้จำไชอีกแล้ว</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ว่าเธอต้องส่งงาน&nbsp;</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ถ้าไม่ส่งงาน เธอจะไม่จบ</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">บางสำนักงานถ้าน้องไปทำแล้วงานไม่ผ่านสักสามครั้ง</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ผู้จัดการหรือเจ้าของจะเรียกน้องมานั่งที่โต๊ะ</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ยื่นซองขาวแล้วก็บอกว่า....&nbsp; &ldquo;ออกไป&rdquo;</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ที่ร้านของพี่...ในการรับพนักงานเข้ามาทำงาน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">จะมีคำว่า &ldquo;ทดลองงานสามเดือน&rdquo; เขียนไว้ในใบสมัครงาน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">แล้วก็มีคนที่ไม่ผ่านงาน&hellip;.</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ตอนนี้น้องๆอาจจะคิดว่าทำไมเรียนหนักจัง</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">มีโปรเจ็คเยอะแยะมากมายจนทำไม่ทัน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">แต่เวลาคุณจบออกไปแล้วทำงานในสำนักงาน</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">คุณไม่มีสิทธิ์บ่น...</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ถ้าเจ้านายสั่งงานชิ้นนี้แล้วบอกว่า &ldquo;ขอก่อนห้าโมงเย็น&rdquo;</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ก็ต้องส่งงานก่อนห้าโมงเย็น</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">เพราะถ้าน้องทำไม่ได้</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">ก็จะมีคนอื่นที่ทำได้&nbsp; แล้วเขาจะเข้ามาทำงานแทนที่เรา</span></span></p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\">&nbsp;</p>\n<p style=\\\\\\\"color: rgb(102, 102, 102); font-family: Verdana, Arial, Helvetica, sans-serif; text-align: center; \\\\\\\"><span style=\\\\\\\"color: rgb(0, 0, 205); \\\\\\\"><span style=\\\\\\\"font-size: 18px; \\\\\\\">นี่คือความแตกต่างของโลกการทำงานกับโลกของการเรียน</span></span></p>', '3', '2012-02-08 00:00:00', '1', '0', '0', 'E2CEF069151543698755F9764CDD3C33');
INSERT INTO `article` VALUES ('000019', 'asdfasdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '0', '7082B4C0F43040EA822EC70F2099C93F');
INSERT INTO `article` VALUES ('000020', 'asdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '931CADD4D75D482195CA1352CEE28247');
INSERT INTO `article` VALUES ('000021', '4534', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '4C6B1710BA654AA88806E858243F348A');
INSERT INTO `article` VALUES ('000022', 'asdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', '0C9374CABA6D46568010CCFBAEDA09C8');
INSERT INTO `article` VALUES ('000023', 'asdfasdf', '', '', '1', '2012-02-08 00:00:00', '1', '0', '1', 'BFD138F45F3C46C2BF1AE3E7197B9F45');
INSERT INTO `article` VALUES ('000024', 'ทดสอบเรื่องราว', '', '', '1', '2012-02-08 00:00:00', '1', '0', '0', 'ECEC6C3BC52F4B718AA159E3A1C9EE90');
INSERT INTO `article` VALUES ('000025', 'ทดสอบเรื่องราว', '', '', '1', '2012-02-08 00:00:00', '1', '0', '0', '5E9909ED26EC47F69EB7BACEEFC96DC5');
INSERT INTO `article` VALUES ('000026', 'เรื่องราวของฉัน', '', '<b> ทดสอบเรื่องราว</b>', '1', '2012-02-08 00:00:00', '1', '0', '0', '5F3516E366204660A1CAC7780397F2DA');
INSERT INTO `article` VALUES ('000027', 'เรื่องราวของฉัน(2)', '', '', '1', '2012-02-08 00:00:00', '1', '1', '0', 'C13877EE72F643D79A928AAC276B3E8B');
INSERT INTO `article` VALUES ('000028', 'ทดสอบนะจ๊ะ', '', '', '1', '2012-02-09 00:00:00', '1', '0', '0', '580ECD06A55949ACA61DA91340BE8078');
INSERT INTO `article` VALUES ('000029', 'test', '', '', '1', '2012-02-13 00:00:00', '1', '0', '1', '51314C9B079A4EB39831053B37902443');
INSERT INTO `article` VALUES ('000030', 'ทดสอบใหม่', '', '<p>\r\n	vtwias<strong>dfไม่รู้ว่ะ</strong></p>\r\n', '1', '2012-02-26 22:10:31', '1', '1', '0', '0DB4F059EC3345319578DBAA9BB4D86F');
INSERT INTO `article` VALUES ('000031', 'ร่วมถวายหินศิลาแลง เพื่อสร้างเมรุถวายเพลิงสรีระองค์หลวงตามหาบัว', '\"ร่วมถวายหินศิลาแลง\" เพื่อสร้างเมรุถวายเพลิงสรีระองค์หลวงตามหาบัว', '', '3', '2012-03-01 15:26:56', '1', '0', '0', '05D651FD92AF45A597829F48ECF94971');
INSERT INTO `article` VALUES ('000032', 'แง่มๆ', 'บทความทดสอบอะไรก็ได้อ่ะฟหกดฟหกดฟหกดฟหกดฟหกดฟหกดีฟหก่ดไดฟหกัเฟห่กดาฟบกด่ฟหวสกดัฟหกด่ฟหกสาดฟหกวดรฟัหกดวฟห่กาดฟหกัดวฟหก่ดสืไสดฟหกดฟหกดฟหกดฟหกด', '', '1', '2012-03-05 00:08:36', '0', '0', '0', 'ECEC6C3BC52F4B718AA159E3A1C9EE90');
INSERT INTO `article` VALUES ('000033', 'บทความใหม่', 'ฟฟหกดฟหกดหฟกดฟหกดฟหกด', '', '1', '2012-03-05 00:21:40', '0', '0', '0', 'ECEC6C3BC52F4B718AA159E3A1C9EE96');
INSERT INTO `article` VALUES ('000034', 'ทดสอบ', 'ทดสอบหัวข้อใหม่ว่าใช้ได้ดีหรือไม่', 'บันทึกบทความใหม่นะ', '1', '2012-03-05 00:39:57', '0', '0', '0', '05D651FD92AF45A597829F48ECF94973');
INSERT INTO `article` VALUES ('000035', 'asteadsf', 'asdfasdf', '', '1', '2012-03-05 10:10:23', '1', '1', '0', '6532F43068204F81979D0B9795F93EF0');

-- ----------------------------
-- Table structure for `article_category`
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_category
-- ----------------------------
INSERT INTO `article_category` VALUES ('1', 'บทความ');
INSERT INTO `article_category` VALUES ('2', 'การ์ตูน');
INSERT INTO `article_category` VALUES ('3', 'ข่าวสาร-กิจกรรม');
INSERT INTO `article_category` VALUES ('4', 'อื่นๆ');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(6) unsigned zerofill NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `normal_price` decimal(10,0) NOT NULL default '0',
  `sale_price` decimal(10,0) NOT NULL default '0',
  `category_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `is_released` char(1) NOT NULL default '0',
  `is_deleted` char(1) NOT NULL default '0',
  `rowid` binary(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('000001', 'สงสัยมั้ย ? ธรรมะ', '\"การทำบุญสมัยนี้ มักเป็นการทำบุญที่ลงทุนมาก แต่ได้ผลบุญน้อยนัก\"', '', '150', '140', '1', '2011-12-26 00:00:00', '0', '0', '86F0839BAB114c26913E0997CCF1D677');
INSERT INTO `product` VALUES ('000002', 'ธรรมทาน A', '<b><i>ทดสอบ HTML</i></b>', '', '250', '0', '2', '2011-12-27 00:00:00', '0', '1', '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0');
INSERT INTO `product` VALUES ('000003', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '\"ปล่อยวางด้วยใจ ใช่คำพูด\"', '', '180', '150', '1', '2012-02-14 00:00:00', '0', '0', '2BABC8C9DC304fb19F81FEA512FD765D');
INSERT INTO `product` VALUES ('000004', 'หมื่นตา ธรรมะ เล่ม 1', '\\\"หมื่นรู้ มิสู้ ปล่อยวาง\\\"', '', '180', '150', '1', '2012-02-14 00:00:00', '0', '1', '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0');
INSERT INTO `product` VALUES ('000005', 'หมื่นตา ธรรมะ เล่ม 1', '\"หมื่นรู้ มิสู้ ปล่อยวาง\"', '', '180', '150', '1', '2012-02-14 00:00:00', '0', '0', 'EAE0BC4BC3A04ace97850D66CE6B1E39');
INSERT INTO `product` VALUES ('000006', 'ธรรมะธรรมทาน: รู้-ละ ยังไงในเวลาชีวิต', 'คุณกำลังประมาทต่อเวลาของชีวิตกันอยู่รึเปล่า..?', '', '8', '0', '2', '2012-02-15 00:00:00', '0', '0', '1054AE87F1754d83-904AD3D221B63F5');
INSERT INTO `product` VALUES ('000007', 'ทุกข์-สุข ยังไงในใจเรา', 'ความทุกข์-ความสุข ของคุณเกิดขึ้นที่ไหนเพราะเหตุใด.. ??', '', '8', '0', '2', '2012-02-15 00:00:00', '0', '0', '6845F2138957443aB9059D718E3BA7B7');
INSERT INTO `product` VALUES ('000008', 'จุดเทียนยังไงให้ชีวิต', 'เคยคิดไหมว่า \"ทำไมคุณกำลังทุกข์เพราะลืมอะไรไปหรือเปล่า ????\"', '', '8', '10', '2', '2012-02-15 00:00:00', '0', '0', '7F74785B4B7748fe847C33A5B63E678D');
INSERT INTO `product` VALUES ('000009', 'หนังสือทดสอบ1', 'ทดสอบนะจ๊ะ', '', '190', '0', '1', '2012-02-26 03:36:47', '0', '1', '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0');
INSERT INTO `product` VALUES ('000010', 'ประวัติหมีโคอะล่า', 'รายละเอียดคร่าวๆๆๆๆๆ', '<p>\r\n	tea<strong>asdfasdfsadfa123<img alt=\"\" src=\"/kcfinder/upload/images/Koala.jpg\" style=\"width: 100px; height: 75px; \" />&nbsp;teasdfasdf&nbsp;</strong><span style=\"background-color:#000080;\">adfasdfasdf asdfasdf123ppp000000<img alt=\"\" src=\"/kcfinder/upload/images/Penguins.jpg\" style=\"width: 100px; height: 75px; \" />asdfasdfaf</span></p>', '6000', '0', '1', '2012-03-05 11:16:37', '1', '0', '1B56DFD1ACA64F51AE8093DA30981B05');
INSERT INTO `product` VALUES ('000011', 'test', 'tste', '<p>\n	test123tttt190xxxtg</p>', '12', '0', '1', '2012-03-05 15:00:00', '0', '0', '098C326864D54DAC9A44D9461754FAA3');

-- ----------------------------
-- Table structure for `product_category`
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `code` char(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category
-- ----------------------------
INSERT INTO `product_category` VALUES ('1', 'หนังสือทั่วไป', 'DH');
INSERT INTO `product_category` VALUES ('2', 'หนังสือธรรมทาน', 'DE');

-- ----------------------------
-- Table structure for `product_unit_promotion`
-- ----------------------------
DROP TABLE IF EXISTS `product_unit_promotion`;
CREATE TABLE `product_unit_promotion` (
  `id` binary(32) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `in_type_id` int(10) unsigned NOT NULL,
  `in_value` decimal(10,0) NOT NULL,
  `out_type_id` int(10) unsigned NOT NULL,
  `out_value` decimal(10,0) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_unit_promotion
-- ----------------------------
INSERT INTO `product_unit_promotion` VALUES ('2D5F4B8D50E9444483CCF51F6193FFD5', '11', '0', '1000', '2', '10000');
INSERT INTO `product_unit_promotion` VALUES ('2D5F4B8D50E9444483CCF51F6193FFD7', '11', '0', '100', '2', '1000');

-- ----------------------------
-- Table structure for `purchase_order`
-- ----------------------------
DROP TABLE IF EXISTS `purchase_order`;
CREATE TABLE `purchase_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_date` datetime NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `shipping_name` varchar(100) NOT NULL,
  `shipping_address1` varchar(255) NOT NULL,
  `shipping_subdistrict` varchar(50) NOT NULL,
  `shipping_district` varchar(50) NOT NULL,
  `shipping_province_code` tinyint(3) NOT NULL,
  `shipping_zipcode` varchar(5) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `status_id` tinyint(3) NOT NULL,
  `is_deleted` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchase_order
-- ----------------------------
INSERT INTO `purchase_order` VALUES ('1', '2012-02-16 17:36:07', '1', 'เวย์คุง', 'xxx', 'xxx', 'xxx', '10', '10210', '0', '0', '0');
INSERT INTO `purchase_order` VALUES ('2', '2012-02-19 02:06:26', '0', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '0', '0', '0');
INSERT INTO `purchase_order` VALUES ('3', '2012-02-19 02:15:14', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '1500150', '0', '1');
INSERT INTO `purchase_order` VALUES ('4', '2012-02-19 02:22:46', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '1500150', '0', '1');
INSERT INTO `purchase_order` VALUES ('5', '2012-02-19 14:00:49', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '950', '0', '0');
INSERT INTO `purchase_order` VALUES ('6', '2012-02-22 02:48:23', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '8000', '0', '0');
INSERT INTO `purchase_order` VALUES ('7', '2012-02-22 03:01:26', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '800', '0', '0');
INSERT INTO `purchase_order` VALUES ('8', '2012-02-22 22:04:33', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '150', '0', '0');
INSERT INTO `purchase_order` VALUES ('9', '2012-03-03 01:18:50', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '60', '0', '0');
INSERT INTO `purchase_order` VALUES ('10', '2012-03-03 01:49:28', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '450', '0', '0');
INSERT INTO `purchase_order` VALUES ('11', '2012-03-03 02:04:12', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '20', '0', '0');
INSERT INTO `purchase_order` VALUES ('12', '2012-03-03 02:21:15', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '140', '0', '0');
INSERT INTO `purchase_order` VALUES ('13', '2012-03-06 10:59:01', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '60', '0', '0');
INSERT INTO `purchase_order` VALUES ('14', '2012-03-06 11:01:59', '2', 'ฐิติกร วงศ์ลังกา', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '12000', '1', '0');

-- ----------------------------
-- Table structure for `purchase_order_item`
-- ----------------------------
DROP TABLE IF EXISTS `purchase_order_item`;
CREATE TABLE `purchase_order_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_id` int(10) unsigned NOT NULL,
  `code` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `unit_price` decimal(10,0) NOT NULL,
  `unit_total_price` decimal(10,0) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchase_order_item
-- ----------------------------
INSERT INTO `purchase_order_item` VALUES ('1', '1', '', 'รายการที่ 1', '2', '1000', '0');
INSERT INTO `purchase_order_item` VALUES ('2', '2', '', '', '10000', '0', '0');
INSERT INTO `purchase_order_item` VALUES ('3', '2', '', '', '1', '0', '0');
INSERT INTO `purchase_order_item` VALUES ('4', '3', '', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '10000', '150', '1500000');
INSERT INTO `purchase_order_item` VALUES ('5', '3', '', 'หมื่นตา ธรรมะ เล่ม 1', '1', '150', '150');
INSERT INTO `purchase_order_item` VALUES ('6', '4', '1-3', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '10000', '150', '1500000');
INSERT INTO `purchase_order_item` VALUES ('7', '4', '1-5', 'หมื่นตา ธรรมะ เล่ม 1', '1', '150', '150');
INSERT INTO `purchase_order_item` VALUES ('8', '5', '2-8', 'จุดเทียนยังไงให้ชีวิต', '100', '8', '800');
INSERT INTO `purchase_order_item` VALUES ('9', '5', '1-3', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '1', '150', '150');
INSERT INTO `purchase_order_item` VALUES ('10', '6', '2-7', 'ทุกข์-สุข ยังไงในใจเรา', '1000', '8', '8000');
INSERT INTO `purchase_order_item` VALUES ('11', '7', '2-7', 'ทุกข์-สุข ยังไงในใจเรา', '100', '8', '800');
INSERT INTO `purchase_order_item` VALUES ('12', '8', '1-5', 'หมื่นตา ธรรมะ เล่ม 1', '1', '150', '150');
INSERT INTO `purchase_order_item` VALUES ('13', '9', '7F74785B4B7748fe847C33A5B', 'จุดเทียนยังไงให้ชีวิต', '6', '10', '60');
INSERT INTO `purchase_order_item` VALUES ('14', '10', '2BABC8C9DC304fb19F81FEA51', 'หมื่นตาธรรมะ กับความจริงแห่งทุกข์', '3', '150', '450');
INSERT INTO `purchase_order_item` VALUES ('15', '11', '7F74785B4B7748fe847C33A5B', 'จุดเทียนยังไงให้ชีวิต', '2', '10', '20');
INSERT INTO `purchase_order_item` VALUES ('16', '12', 'DH1', 'สงสัยมั้ย ? ธรรมะ', '1', '140', '140');
INSERT INTO `purchase_order_item` VALUES ('17', '13', 'DH000011', 'test', '5', '12', '60');
INSERT INTO `purchase_order_item` VALUES ('18', '14', 'DH000010', 'ประวัติหมีโคอะล่า', '2', '6000', '12000');

-- ----------------------------
-- Table structure for `purchase_order_status`
-- ----------------------------
DROP TABLE IF EXISTS `purchase_order_status`;
CREATE TABLE `purchase_order_status` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchase_order_status
-- ----------------------------
INSERT INTO `purchase_order_status` VALUES ('1', 'รอการจัดส่ง');
INSERT INTO `purchase_order_status` VALUES ('2', 'จัดส่งแล้ว');

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `is_admin` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'สมาชิกทั่วไป', '0');
INSERT INTO `role` VALUES ('2', 'ผู้ดูแลระบบ', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(6) unsigned zerofill NOT NULL auto_increment,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `gender` char(1) NOT NULL default 'm',
  `birthday` date NOT NULL,
  `address1` varchar(255) NOT NULL,
  `subdistrict` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `province_code` tinyint(3) unsigned NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `telephone` varchar(10) default NULL,
  `mobilephone` varchar(10) default NULL,
  `email` varchar(100) NOT NULL,
  `password` binary(32) NOT NULL,
  `news_letter_allowed` char(1) NOT NULL default '0',
  `created_date` datetime NOT NULL,
  `role_id` int(11) unsigned NOT NULL default '1',
  `is_deleted` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('000001', 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '2011-11-11', '549 <> \\\' \\\"', 'ดินแดง', 'ห้วยขวาง', '10', '10240', '', '', 'root1@admin.com', '21232f297a57a5a743894a0e4a801fc3', '1', '2011-12-18 00:00:00', '2', '1');
INSERT INTO `user` VALUES ('000002', 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '1983-11-03', '549 สมานจิตอพาร์ทเม้น ห้อง 101 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ห้วยขวาง', '10', '10241', '025540616', '0865540616', 'root@admin.com', '79e0b37bc2df0060011da08478954684', '1', '0000-00-00 00:00:00', '2', '0');
INSERT INTO `user` VALUES ('000003', 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '2011-11-11', 'test', 'ดินแดง', 'ห้วยขวาง', '10', '10240', null, null, 'root2@admin.com', '21232f297a57a5a743894a0e4a801fc3', '1', '2011-12-18 00:00:00', '2', '1');
INSERT INTO `user` VALUES ('000004', 'สมคิด', 'ตั้งใจทำ', 'คิดดี1', 'f', '2011-09-07', '123 หอพัก ห้อง 101', 'ดินแดง', 'ดินแดง', '10', '12333', null, null, 'theafco1@hotmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', '2012-01-04 00:00:00', '1', '0');
INSERT INTO `user` VALUES ('000005', 'test', 'test', 'test', 'm', '2012-01-02', '', '', '', '10', '', '', '', 'test@athingbook.net', '098f6bcd4621d373cade4e832627b4f6', '1', '2012-01-05 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000006', 'heyhey', 'hey123', 'hey', 'm', '2001-10-02', '', '', '', '10', '', '', '', 'heyhey@athingbook.net', '49ffe4ca1f5039447f5c8e4ddf4b5dde', '1', '2012-01-05 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000007', 'asdf', 'asdf', 'asdf', 'm', '0000-00-00', 'asdf', 'asdf', 'asdf', '10', '12345', '', '', 'test@asdf.com', '912ec803b2ce49e4a541068d495ab570', '1', '2012-02-25 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000008', 'asdf', 'asdf', 'asdf', 'm', '0000-00-00', 'asdf', 'asdf', 'asdf', '10', '12333', '', '', 'asdf@asdf.com', '912ec803b2ce49e4a541068d495ab570', '1', '2012-02-25 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000009', 'asdf', 'asdf', 'asdfasdf', 'm', '0000-00-00', 'asdfsadf', 'asdf', 'f', '10', '12333', '', '', 'asdf@asfd.com', '912ec803b2ce49e4a541068d495ab570', '1', '2012-02-25 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000010', 'asdf1', 'asdf', 'asdf', 'm', '0000-00-00', 'asdfd', 'asdf', 'asdf', '10', '12344', '', '', 'asdf@adf.com', '8d0c8f9d1a9539021fda006427b993b9', '1', '2012-02-25 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000011', 'test', '...a1', 'test1', 'f', '2000-11-02', 'test1', 'teset', 'test', '10', '10240', '0255401233', '3534534534', 'tes1t@test.com', '21232f297a57a5a743894a0e4a801fc3', '1', '2012-02-25 00:00:00', '1', '0');
INSERT INTO `user` VALUES ('000012', 'asdf', 'dfd', 'fdfd', 'm', '0000-00-00', 'asdf', 'asdfd', 'asdfasd', '10', '12333', '', '', 'tes@asdf.com', '6a204bd89f3c8348afd5c77c717a097a', '1', '0000-00-00 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000013', 'asdfdf', 'asdf', 'asdf', 'm', '0000-00-00', 'asdf', 'sdf', 'asdf', '10', '12333', '', '', 'asdf@af.com', '60474c9c10d7142b7508ce7a50acf414', '1', '0000-00-00 00:00:00', '1', '1');
INSERT INTO `user` VALUES ('000014', 'adsf', 'asdf', 'asdf', 'm', '0000-00-00', 'asdf', 'asdf', 'asdf', '10', '12333', '', '', 'test@test.com', 'cc03e747a6afbbcbf8be7668acfebee5', '1', '2012-02-25 19:27:10', '1', '1');
INSERT INTO `user` VALUES ('000015', 'asdf', 'adsf', 'adsf', 'm', '2012-02-02', 'asdf', 'adsf', 'adsf', '10', '12323', '', '', 'test@adsf.com', '6a204bd89f3c8348afd5c77c717a097a', '1', '2012-02-25 19:41:05', '1', '1');
INSERT INTO `user` VALUES ('000016', 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '1983-01-18', '257 PS House ถ.ประชาสงเคราะห์ ซ.ชานเมือง7', 'ดินแดง', 'ดินแดง', '10', '10400', '', '', 'theafc2o@hotmail.com', '79e0b37bc2df0060011da08478954684', '1', '2012-03-04 14:08:39', '2', '0');
INSERT INTO `user` VALUES ('000017', 'ฐิติกร', 'วงศ์ลังกา', 'สเปน', 'm', '1983-01-18', '123 พีเอสเฮาส์ ซ.ชานเมือง7 ถ.ประชาสงเคราะห์', 'ดินแดง', 'ดินแดง', '10', '10240', '0865540616', '', 'theafco@hotmail.com', '79e0b37bc2df0060011da08478954684', '1', '2012-03-04 14:18:28', '2', '0');
INSERT INTO `user` VALUES ('000018', 'asdfa', 'asdfasdf', 'asdfas', 'm', '2012-03-10', 'asdf', 'asdf', 'asdf', '10', '11111', '', '', 'awdf@adsf.com', '0192023a7bbd73250516f069df18b500', '1', '0000-00-00 00:00:00', '1', '0');
INSERT INTO `user` VALUES ('000019', 'dfadsf', 'asdfasdf', 'asdfasdf', 'm', '2000-01-12', 'asdfas', 'asdfasdf', 'asdfasdf', '10', '33333', '', '', 'yasdfa@asdf.com', '0192023a7bbd73250516f069df18b500', '1', '0000-00-00 00:00:00', '1', '0');
INSERT INTO `user` VALUES ('000020', 'adsfasdf', 'asdfasfd', 'asdfasdf', 'm', '2012-03-16', '123', 'asdfasfd', 'asdfasdf', '10', '12345', '', '', 'theafco@adsf.com', '79e0b37bc2df0060011da08478954684', '1', '2012-03-04 23:46:43', '1', '1');
