/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50171
Source Host           : localhost:3306
Source Database       : evnaby_xabina

Target Server Type    : MYSQL
Target Server Version : 50171
File Encoding         : 65001

Date: 2014-08-12 15:49:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zone`
-- ----------------------------
DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
`zone_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`country_code`  char(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`zone_name`  varchar(35) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`offset`  varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`offset_time`  int(11) NOT NULL ,
PRIMARY KEY (`zone_id`),
INDEX `idx_zone_name` USING BTREE (`zone_name`) 
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_bin
AUTO_INCREMENT=417

;

-- ----------------------------
-- Records of zone
-- ----------------------------
BEGIN;
INSERT INTO `zone` VALUES ('1', 'AD', 'Europe/Andorra', '+02:00', '7200'), ('2', 'AE', 'Asia/Dubai', '+04:00', '14400'), ('3', 'AF', 'Asia/Kabul', '+04:30', '16200'), ('4', 'AG', 'America/Antigua', '-04:00', '-14400'), ('5', 'AI', 'America/Anguilla', '-04:00', '-14400'), ('6', 'AL', 'Europe/Tirane', '+02:00', '7200'), ('7', 'AM', 'Asia/Yerevan', '+04:00', '14400'), ('8', 'AO', 'Africa/Luanda', '+01:00', '3600'), ('9', 'AQ', 'Antarctica/McMurdo', '+12:00', '43200'), ('10', 'AQ', 'Antarctica/Rothera', '-03:00', '-10800'), ('11', 'AQ', 'Antarctica/Palmer', '-04:00', '-14400'), ('12', 'AQ', 'Antarctica/Mawson', '+05:00', '18000'), ('13', 'AQ', 'Antarctica/Davis', '+07:00', '25200'), ('14', 'AQ', 'Antarctica/Casey', '+08:00', '28800'), ('15', 'AQ', 'Antarctica/Vostok', '+06:00', '21600'), ('16', 'AQ', 'Antarctica/DumontDUrville', '+10:00', '36000'), ('17', 'AQ', 'Antarctica/Syowa', '+03:00', '10800'), ('19', 'AR', 'America/Argentina/Buenos_Aires', '-03:00', '-10800'), ('20', 'AR', 'America/Argentina/Cordoba', '-03:00', '-10800'), ('21', 'AR', 'America/Argentina/Salta', '-03:00', '-10800'), ('22', 'AR', 'America/Argentina/Jujuy', '-03:00', '-10800'), ('23', 'AR', 'America/Argentina/Tucuman', '-03:00', '-10800'), ('24', 'AR', 'America/Argentina/Catamarca', '-03:00', '-10800'), ('25', 'AR', 'America/Argentina/La_Rioja', '-03:00', '-10800'), ('26', 'AR', 'America/Argentina/San_Juan', '-03:00', '-10800'), ('27', 'AR', 'America/Argentina/Mendoza', '-03:00', '-10800'), ('28', 'AR', 'America/Argentina/San_Luis', '-03:00', '-10800'), ('29', 'AR', 'America/Argentina/Rio_Gallegos', '-03:00', '-10800'), ('30', 'AR', 'America/Argentina/Ushuaia', '-03:00', '-10800'), ('31', 'AS', 'Pacific/Pago_Pago', '-11:00', '-39600'), ('32', 'AT', 'Europe/Vienna', '+02:00', '7200'), ('33', 'AU', 'Australia/Lord_Howe', '+10:30', '37800'), ('34', 'AU', 'Antarctica/Macquarie', '+11:00', '39600'), ('35', 'AU', 'Australia/Hobart', '+10:00', '36000'), ('36', 'AU', 'Australia/Currie', '+10:00', '36000'), ('37', 'AU', 'Australia/Melbourne', '+10:00', '36000'), ('38', 'AU', 'Australia/Sydney', '+10:00', '36000'), ('39', 'AU', 'Australia/Broken_Hill', '+09:30', '34200'), ('40', 'AU', 'Australia/Brisbane', '+10:00', '36000'), ('41', 'AU', 'Australia/Lindeman', '+10:00', '36000'), ('42', 'AU', 'Australia/Adelaide', '+09:30', '34200'), ('43', 'AU', 'Australia/Darwin', '+09:30', '34200'), ('44', 'AU', 'Australia/Perth', '+08:00', '28800'), ('45', 'AU', 'Australia/Eucla', '+08:45', '31500'), ('46', 'AW', 'America/Aruba', '-04:00', '-14400'), ('47', 'AX', 'Europe/Mariehamn', '+03:00', '10800'), ('48', 'AZ', 'Asia/Baku', '+05:00', '18000'), ('49', 'BA', 'Europe/Sarajevo', '+02:00', '7200'), ('50', 'BB', 'America/Barbados', '-04:00', '-14400'), ('51', 'BD', 'Asia/Dhaka', '+06:00', '21600'), ('52', 'BE', 'Europe/Brussels', '+02:00', '7200'), ('53', 'BF', 'Africa/Ouagadougou', '+00:00', '0'), ('54', 'BG', 'Europe/Sofia', '+03:00', '10800'), ('55', 'BH', 'Asia/Bahrain', '+03:00', '10800'), ('56', 'BI', 'Africa/Bujumbura', '+02:00', '7200'), ('57', 'BJ', 'Africa/Porto-Novo', '+01:00', '3600'), ('58', 'BL', 'America/St_Barthelemy', '-04:00', '-14400'), ('59', 'BM', 'Atlantic/Bermuda', '-03:00', '-10800'), ('60', 'BN', 'Asia/Brunei', '+08:00', '28800'), ('61', 'BO', 'America/La_Paz', '-04:00', '-14400'), ('62', 'BQ', 'America/Kralendijk', '-04:00', '-14400'), ('63', 'BR', 'America/Noronha', '-02:00', '-7200'), ('64', 'BR', 'America/Belem', '-03:00', '-10800'), ('65', 'BR', 'America/Fortaleza', '-03:00', '-10800'), ('66', 'BR', 'America/Recife', '-03:00', '-10800'), ('67', 'BR', 'America/Araguaina', '-03:00', '-10800'), ('68', 'BR', 'America/Maceio', '-03:00', '-10800'), ('69', 'BR', 'America/Bahia', '-03:00', '-10800'), ('70', 'BR', 'America/Sao_Paulo', '-03:00', '-10800'), ('71', 'BR', 'America/Campo_Grande', '-04:00', '-14400'), ('72', 'BR', 'America/Cuiaba', '-04:00', '-14400'), ('73', 'BR', 'America/Santarem', '-03:00', '-10800'), ('74', 'BR', 'America/Porto_Velho', '-04:00', '-14400'), ('75', 'BR', 'America/Boa_Vista', '-04:00', '-14400'), ('76', 'BR', 'America/Manaus', '-04:00', '-14400'), ('77', 'BR', 'America/Eirunepe', '-04:00', '-14400'), ('78', 'BR', 'America/Rio_Branco', '-04:00', '-14400'), ('79', 'BS', 'America/Nassau', '-04:00', '-14400'), ('80', 'BT', 'Asia/Thimphu', '+06:00', '21600'), ('81', 'BW', 'Africa/Gaborone', '+02:00', '7200'), ('82', 'BY', 'Europe/Minsk', '+03:00', '10800'), ('83', 'BZ', 'America/Belize', '-06:00', '-21600'), ('84', 'CA', 'America/St_Johns', '-02:30', '-9000'), ('85', 'CA', 'America/Halifax', '-03:00', '-10800'), ('86', 'CA', 'America/Glace_Bay', '-03:00', '-10800'), ('87', 'CA', 'America/Moncton', '-03:00', '-10800'), ('88', 'CA', 'America/Goose_Bay', '-03:00', '-10800'), ('89', 'CA', 'America/Blanc-Sablon', '-04:00', '-14400'), ('90', 'CA', 'America/Toronto', '-04:00', '-14400'), ('91', 'CA', 'America/Nipigon', '-04:00', '-14400'), ('92', 'CA', 'America/Thunder_Bay', '-04:00', '-14400'), ('93', 'CA', 'America/Iqaluit', '-04:00', '-14400'), ('94', 'CA', 'America/Pangnirtung', '-04:00', '-14400'), ('95', 'CA', 'America/Resolute', '-05:00', '-18000'), ('96', 'CA', 'America/Atikokan', '-05:00', '-18000'), ('97', 'CA', 'America/Rankin_Inlet', '-05:00', '-18000'), ('98', 'CA', 'America/Winnipeg', '-05:00', '-18000'), ('99', 'CA', 'America/Rainy_River', '-05:00', '-18000'), ('100', 'CA', 'America/Regina', '-06:00', '-21600'), ('101', 'CA', 'America/Swift_Current', '-06:00', '-21600');
INSERT INTO `zone` VALUES ('102', 'CA', 'America/Edmonton', '-06:00', '-21600'), ('103', 'CA', 'America/Cambridge_Bay', '-06:00', '-21600'), ('104', 'CA', 'America/Yellowknife', '-06:00', '-21600'), ('105', 'CA', 'America/Inuvik', '-06:00', '-21600'), ('106', 'CA', 'America/Creston', '-07:00', '-25200'), ('107', 'CA', 'America/Dawson_Creek', '-07:00', '-25200'), ('108', 'CA', 'America/Vancouver', '-07:00', '-25200'), ('109', 'CA', 'America/Whitehorse', '-07:00', '-25200'), ('110', 'CA', 'America/Dawson', '-07:00', '-25200'), ('111', 'CC', 'Indian/Cocos', '+06:30', '23400'), ('112', 'CD', 'Africa/Kinshasa', '+01:00', '3600'), ('113', 'CD', 'Africa/Lubumbashi', '+02:00', '7200'), ('114', 'CF', 'Africa/Bangui', '+01:00', '3600'), ('115', 'CG', 'Africa/Brazzaville', '+01:00', '3600'), ('116', 'CH', 'Europe/Zurich', '+02:00', '7200'), ('117', 'CI', 'Africa/Abidjan', '+00:00', '0'), ('118', 'CK', 'Pacific/Rarotonga', '-10:00', '-36000'), ('119', 'CL', 'America/Santiago', '-04:00', '-14400'), ('120', 'CL', 'Pacific/Easter', '-06:00', '-21600'), ('121', 'CM', 'Africa/Douala', '+01:00', '3600'), ('122', 'CN', 'Asia/Shanghai', '+08:00', '28800'), ('123', 'CN', 'Asia/Harbin', '+08:00', '28800'), ('124', 'CN', 'Asia/Chongqing', '+08:00', '28800'), ('125', 'CN', 'Asia/Urumqi', '+08:00', '28800'), ('126', 'CN', 'Asia/Kashgar', '+08:00', '28800'), ('127', 'CO', 'America/Bogota', '-05:00', '-18000'), ('128', 'CR', 'America/Costa_Rica', '-06:00', '-21600'), ('129', 'CU', 'America/Havana', '-04:00', '-14400'), ('130', 'CV', 'Atlantic/Cape_Verde', '-01:00', '-3600'), ('131', 'CW', 'America/Curacao', '-04:00', '-14400'), ('132', 'CX', 'Indian/Christmas', '+07:00', '25200'), ('133', 'CY', 'Asia/Nicosia', '+03:00', '10800'), ('134', 'CZ', 'Europe/Prague', '+02:00', '7200'), ('135', 'DE', 'Europe/Berlin', '+02:00', '7200'), ('136', 'DE', 'Europe/Busingen', '+02:00', '7200'), ('137', 'DJ', 'Africa/Djibouti', '+03:00', '10800'), ('138', 'DK', 'Europe/Copenhagen', '+02:00', '7200'), ('139', 'DM', 'America/Dominica', '-04:00', '-14400'), ('140', 'DO', 'America/Santo_Domingo', '-04:00', '-14400'), ('141', 'DZ', 'Africa/Algiers', '+01:00', '3600'), ('142', 'EC', 'America/Guayaquil', '-05:00', '-18000'), ('143', 'EC', 'Pacific/Galapagos', '-06:00', '-21600'), ('144', 'EE', 'Europe/Tallinn', '+03:00', '10800'), ('145', 'EG', 'Africa/Cairo', '+02:00', '7200'), ('146', 'EH', 'Africa/El_Aaiun', '+00:00', '0'), ('147', 'ER', 'Africa/Asmara', '+03:00', '10800'), ('148', 'ES', 'Europe/Madrid', '+02:00', '7200'), ('149', 'ES', 'Africa/Ceuta', '+02:00', '7200'), ('150', 'ES', 'Atlantic/Canary', '+01:00', '3600'), ('151', 'ET', 'Africa/Addis_Ababa', '+03:00', '10800'), ('152', 'FI', 'Europe/Helsinki', '+03:00', '10800'), ('153', 'FJ', 'Pacific/Fiji', '+12:00', '43200'), ('154', 'FK', 'Atlantic/Stanley', '-03:00', '-10800'), ('155', 'FM', 'Pacific/Chuuk', '+10:00', '36000'), ('156', 'FM', 'Pacific/Pohnpei', '+11:00', '39600'), ('157', 'FM', 'Pacific/Kosrae', '+11:00', '39600'), ('158', 'FO', 'Atlantic/Faroe', '+01:00', '3600'), ('159', 'FR', 'Europe/Paris', '+02:00', '7200'), ('160', 'GA', 'Africa/Libreville', '+01:00', '3600'), ('161', 'GB', 'Europe/London', '+01:00', '3600'), ('162', 'GD', 'America/Grenada', '-04:00', '-14400'), ('163', 'GE', 'Asia/Tbilisi', '+04:00', '14400'), ('164', 'GF', 'America/Cayenne', '-03:00', '-10800'), ('165', 'GG', 'Europe/Guernsey', '+01:00', '3600'), ('166', 'GH', 'Africa/Accra', '+00:00', '0'), ('167', 'GI', 'Europe/Gibraltar', '+02:00', '7200'), ('168', 'GL', 'America/Godthab', '-02:00', '-7200'), ('169', 'GL', 'America/Danmarkshavn', '+00:00', '0'), ('170', 'GL', 'America/Scoresbysund', '+00:00', '0'), ('171', 'GL', 'America/Thule', '-03:00', '-10800'), ('172', 'GM', 'Africa/Banjul', '+00:00', '0'), ('173', 'GN', 'Africa/Conakry', '+00:00', '0'), ('174', 'GP', 'America/Guadeloupe', '-04:00', '-14400'), ('175', 'GQ', 'Africa/Malabo', '+01:00', '3600'), ('176', 'GR', 'Europe/Athens', '+03:00', '10800'), ('177', 'GS', 'Atlantic/South_Georgia', '-02:00', '-7200'), ('178', 'GT', 'America/Guatemala', '-06:00', '-21600'), ('179', 'GU', 'Pacific/Guam', '+10:00', '36000'), ('180', 'GW', 'Africa/Bissau', '+00:00', '0'), ('181', 'GY', 'America/Guyana', '-04:00', '-14400'), ('182', 'HK', 'Asia/Hong_Kong', '+08:00', '28800'), ('183', 'HN', 'America/Tegucigalpa', '-06:00', '-21600'), ('184', 'HR', 'Europe/Zagreb', '+02:00', '7200'), ('185', 'HT', 'America/Port-au-Prince', '-04:00', '-14400'), ('186', 'HU', 'Europe/Budapest', '+02:00', '7200'), ('187', 'ID', 'Asia/Jakarta', '+07:00', '25200'), ('188', 'ID', 'Asia/Pontianak', '+07:00', '25200'), ('189', 'ID', 'Asia/Makassar', '+08:00', '28800'), ('190', 'ID', 'Asia/Jayapura', '+09:00', '32400'), ('191', 'IE', 'Europe/Dublin', '+01:00', '3600'), ('192', 'IL', 'Asia/Jerusalem', '+03:00', '10800'), ('193', 'IM', 'Europe/Isle_of_Man', '+01:00', '3600'), ('194', 'IN', 'Asia/Kolkata', '+05:30', '19800'), ('195', 'IO', 'Indian/Chagos', '+06:00', '21600'), ('196', 'IQ', 'Asia/Baghdad', '+03:00', '10800'), ('197', 'IR', 'Asia/Tehran', '+04:30', '16200'), ('198', 'IS', 'Atlantic/Reykjavik', '+00:00', '0'), ('199', 'IT', 'Europe/Rome', '+02:00', '7200'), ('200', 'JE', 'Europe/Jersey', '+01:00', '3600'), ('201', 'JM', 'America/Jamaica', '-05:00', '-18000');
INSERT INTO `zone` VALUES ('202', 'JO', 'Asia/Amman', '+03:00', '10800'), ('203', 'JP', 'Asia/Tokyo', '+09:00', '32400'), ('204', 'KE', 'Africa/Nairobi', '+03:00', '10800'), ('205', 'KG', 'Asia/Bishkek', '+06:00', '21600'), ('206', 'KH', 'Asia/Phnom_Penh', '+07:00', '25200'), ('207', 'KI', 'Pacific/Tarawa', '+12:00', '43200'), ('208', 'KI', 'Pacific/Enderbury', '+13:00', '46800'), ('209', 'KI', 'Pacific/Kiritimati', '+14:00', '50400'), ('210', 'KM', 'Indian/Comoro', '+03:00', '10800'), ('211', 'KN', 'America/St_Kitts', '-04:00', '-14400'), ('212', 'KP', 'Asia/Pyongyang', '+09:00', '32400'), ('213', 'KR', 'Asia/Seoul', '+09:00', '32400'), ('214', 'KW', 'Asia/Kuwait', '+03:00', '10800'), ('215', 'KY', 'America/Cayman', '-05:00', '-18000'), ('216', 'KZ', 'Asia/Almaty', '+06:00', '21600'), ('217', 'KZ', 'Asia/Qyzylorda', '+06:00', '21600'), ('218', 'KZ', 'Asia/Aqtobe', '+05:00', '18000'), ('219', 'KZ', 'Asia/Aqtau', '+05:00', '18000'), ('220', 'KZ', 'Asia/Oral', '+05:00', '18000'), ('221', 'LA', 'Asia/Vientiane', '+07:00', '25200'), ('222', 'LB', 'Asia/Beirut', '+03:00', '10800'), ('223', 'LC', 'America/St_Lucia', '-04:00', '-14400'), ('224', 'LI', 'Europe/Vaduz', '+02:00', '7200'), ('225', 'LK', 'Asia/Colombo', '+05:30', '19800'), ('226', 'LR', 'Africa/Monrovia', '+00:00', '0'), ('227', 'LS', 'Africa/Maseru', '+02:00', '7200'), ('228', 'LT', 'Europe/Vilnius', '+03:00', '10800'), ('229', 'LU', 'Europe/Luxembourg', '+02:00', '7200'), ('230', 'LV', 'Europe/Riga', '+03:00', '10800'), ('231', 'LY', 'Africa/Tripoli', '+02:00', '7200'), ('232', 'MA', 'Africa/Casablanca', '+01:00', '3600'), ('233', 'MC', 'Europe/Monaco', '+02:00', '7200'), ('234', 'MD', 'Europe/Chisinau', '+03:00', '10800'), ('235', 'ME', 'Europe/Podgorica', '+02:00', '7200'), ('236', 'MF', 'America/Marigot', '-04:00', '-14400'), ('237', 'MG', 'Indian/Antananarivo', '+03:00', '10800'), ('238', 'MH', 'Pacific/Majuro', '+12:00', '43200'), ('239', 'MH', 'Pacific/Kwajalein', '+12:00', '43200'), ('240', 'MK', 'Europe/Skopje', '+02:00', '7200'), ('241', 'ML', 'Africa/Bamako', '+00:00', '0'), ('242', 'MM', 'Asia/Rangoon', '+06:30', '23400'), ('243', 'MN', 'Asia/Ulaanbaatar', '+08:00', '28800'), ('244', 'MN', 'Asia/Hovd', '+07:00', '25200'), ('245', 'MN', 'Asia/Choibalsan', '+08:00', '28800'), ('246', 'MO', 'Asia/Macau', '+08:00', '28800'), ('247', 'MP', 'Pacific/Saipan', '+10:00', '36000'), ('248', 'MQ', 'America/Martinique', '-04:00', '-14400'), ('249', 'MR', 'Africa/Nouakchott', '+00:00', '0'), ('250', 'MS', 'America/Montserrat', '-04:00', '-14400'), ('251', 'MT', 'Europe/Malta', '+02:00', '7200'), ('252', 'MU', 'Indian/Mauritius', '+04:00', '14400'), ('253', 'MV', 'Indian/Maldives', '+05:00', '18000'), ('254', 'MW', 'Africa/Blantyre', '+02:00', '7200'), ('255', 'MX', 'America/Mexico_City', '-05:00', '-18000'), ('256', 'MX', 'America/Cancun', '-05:00', '-18000'), ('257', 'MX', 'America/Merida', '-05:00', '-18000'), ('258', 'MX', 'America/Monterrey', '-05:00', '-18000'), ('259', 'MX', 'America/Matamoros', '-05:00', '-18000'), ('260', 'MX', 'America/Mazatlan', '-06:00', '-21600'), ('261', 'MX', 'America/Chihuahua', '-06:00', '-21600'), ('262', 'MX', 'America/Ojinaga', '-06:00', '-21600'), ('263', 'MX', 'America/Hermosillo', '-07:00', '-25200'), ('264', 'MX', 'America/Tijuana', '-07:00', '-25200'), ('265', 'MX', 'America/Santa_Isabel', '-07:00', '-25200'), ('266', 'MX', 'America/Bahia_Banderas', '-05:00', '-18000'), ('267', 'MY', 'Asia/Kuala_Lumpur', '+08:00', '28800'), ('268', 'MY', 'Asia/Kuching', '+08:00', '28800'), ('269', 'MZ', 'Africa/Maputo', '+02:00', '7200'), ('270', 'NA', 'Africa/Windhoek', '+01:00', '3600'), ('271', 'NC', 'Pacific/Noumea', '+11:00', '39600'), ('272', 'NE', 'Africa/Niamey', '+01:00', '3600'), ('273', 'NF', 'Pacific/Norfolk', '+11:30', '41400'), ('274', 'NG', 'Africa/Lagos', '+01:00', '3600'), ('275', 'NI', 'America/Managua', '-06:00', '-21600'), ('276', 'NL', 'Europe/Amsterdam', '+02:00', '7200'), ('277', 'NO', 'Europe/Oslo', '+02:00', '7200'), ('278', 'NP', 'Asia/Kathmandu', '+05:45', '20700'), ('279', 'NR', 'Pacific/Nauru', '+12:00', '43200'), ('280', 'NU', 'Pacific/Niue', '-11:00', '-39600'), ('281', 'NZ', 'Pacific/Auckland', '+12:00', '43200'), ('282', 'NZ', 'Pacific/Chatham', '+12:45', '45900'), ('283', 'OM', 'Asia/Muscat', '+04:00', '14400'), ('284', 'PA', 'America/Panama', '-05:00', '-18000'), ('285', 'PE', 'America/Lima', '-05:00', '-18000'), ('286', 'PF', 'Pacific/Tahiti', '-10:00', '-36000'), ('287', 'PF', 'Pacific/Marquesas', '-09:30', '-34200'), ('288', 'PF', 'Pacific/Gambier', '-09:00', '-32400'), ('289', 'PG', 'Pacific/Port_Moresby', '+10:00', '36000'), ('290', 'PH', 'Asia/Manila', '+08:00', '28800'), ('291', 'PK', 'Asia/Karachi', '+05:00', '18000'), ('292', 'PL', 'Europe/Warsaw', '+02:00', '7200'), ('293', 'PM', 'America/Miquelon', '-02:00', '-7200'), ('294', 'PN', 'Pacific/Pitcairn', '-08:00', '-28800'), ('295', 'PR', 'America/Puerto_Rico', '-04:00', '-14400'), ('296', 'PS', 'Asia/Gaza', '+03:00', '10800'), ('297', 'PS', 'Asia/Hebron', '+03:00', '10800'), ('298', 'PT', 'Europe/Lisbon', '+01:00', '3600'), ('299', 'PT', 'Atlantic/Madeira', '+01:00', '3600'), ('300', 'PT', 'Atlantic/Azores', '+00:00', '0'), ('301', 'PW', 'Pacific/Palau', '+09:00', '32400');
INSERT INTO `zone` VALUES ('302', 'PY', 'America/Asuncion', '-04:00', '-14400'), ('303', 'QA', 'Asia/Qatar', '+03:00', '10800'), ('304', 'RE', 'Indian/Reunion', '+04:00', '14400'), ('305', 'RO', 'Europe/Bucharest', '+03:00', '10800'), ('306', 'RS', 'Europe/Belgrade', '+02:00', '7200'), ('307', 'RU', 'Europe/Kaliningrad', '+03:00', '10800'), ('308', 'RU', 'Europe/Moscow', '+04:00', '14400'), ('309', 'RU', 'Europe/Volgograd', '+04:00', '14400'), ('310', 'RU', 'Europe/Samara', '+04:00', '14400'), ('311', 'RU', 'Europe/Simferopol', '+03:00', '10800'), ('312', 'RU', 'Asia/Yekaterinburg', '+06:00', '21600'), ('313', 'RU', 'Asia/Omsk', '+07:00', '25200'), ('314', 'RU', 'Asia/Novosibirsk', '+07:00', '25200'), ('315', 'RU', 'Asia/Novokuznetsk', '+07:00', '25200'), ('316', 'RU', 'Asia/Krasnoyarsk', '+08:00', '28800'), ('317', 'RU', 'Asia/Irkutsk', '+09:00', '32400'), ('318', 'RU', 'Asia/Yakutsk', '+10:00', '36000'), ('319', 'RU', 'Asia/Khandyga', '+10:00', '36000'), ('320', 'RU', 'Asia/Vladivostok', '+11:00', '39600'), ('321', 'RU', 'Asia/Sakhalin', '+11:00', '39600'), ('322', 'RU', 'Asia/Ust-Nera', '+11:00', '39600'), ('323', 'RU', 'Asia/Magadan', '+12:00', '43200'), ('324', 'RU', 'Asia/Kamchatka', '+12:00', '43200'), ('325', 'RU', 'Asia/Anadyr', '+12:00', '43200'), ('326', 'RW', 'Africa/Kigali', '+02:00', '7200'), ('327', 'SA', 'Asia/Riyadh', '+03:00', '10800'), ('328', 'SB', 'Pacific/Guadalcanal', '+11:00', '39600'), ('329', 'SC', 'Indian/Mahe', '+04:00', '14400'), ('330', 'SD', 'Africa/Khartoum', '+03:00', '10800'), ('331', 'SE', 'Europe/Stockholm', '+02:00', '7200'), ('332', 'SG', 'Asia/Singapore', '+08:00', '28800'), ('333', 'SH', 'Atlantic/St_Helena', '+00:00', '0'), ('334', 'SI', 'Europe/Ljubljana', '+02:00', '7200'), ('335', 'SJ', 'Arctic/Longyearbyen', '+02:00', '7200'), ('336', 'SK', 'Europe/Bratislava', '+02:00', '7200'), ('337', 'SL', 'Africa/Freetown', '+00:00', '0'), ('338', 'SM', 'Europe/San_Marino', '+02:00', '7200'), ('339', 'SN', 'Africa/Dakar', '+00:00', '0'), ('340', 'SO', 'Africa/Mogadishu', '+03:00', '10800'), ('341', 'SR', 'America/Paramaribo', '-03:00', '-10800'), ('342', 'SS', 'Africa/Juba', '+03:00', '10800'), ('343', 'ST', 'Africa/Sao_Tome', '+00:00', '0'), ('344', 'SV', 'America/El_Salvador', '-06:00', '-21600'), ('345', 'SX', 'America/Lower_Princes', '-04:00', '-14400'), ('346', 'SY', 'Asia/Damascus', '+03:00', '10800'), ('347', 'SZ', 'Africa/Mbabane', '+02:00', '7200'), ('348', 'TC', 'America/Grand_Turk', '-04:00', '-14400'), ('349', 'TD', 'Africa/Ndjamena', '+01:00', '3600'), ('350', 'TF', 'Indian/Kerguelen', '+05:00', '18000'), ('351', 'TG', 'Africa/Lome', '+00:00', '0'), ('352', 'TH', 'Asia/Bangkok', '+07:00', '25200'), ('353', 'TJ', 'Asia/Dushanbe', '+05:00', '18000'), ('354', 'TK', 'Pacific/Fakaofo', '+13:00', '46800'), ('355', 'TL', 'Asia/Dili', '+09:00', '32400'), ('356', 'TM', 'Asia/Ashgabat', '+05:00', '18000'), ('357', 'TN', 'Africa/Tunis', '+01:00', '3600'), ('358', 'TO', 'Pacific/Tongatapu', '+13:00', '46800'), ('359', 'TR', 'Europe/Istanbul', '+03:00', '10800'), ('360', 'TT', 'America/Port_of_Spain', '-04:00', '-14400'), ('361', 'TV', 'Pacific/Funafuti', '+12:00', '43200'), ('362', 'TW', 'Asia/Taipei', '+08:00', '28800'), ('363', 'TZ', 'Africa/Dar_es_Salaam', '+03:00', '10800'), ('364', 'UA', 'Europe/Kiev', '+03:00', '10800'), ('365', 'UA', 'Europe/Uzhgorod', '+03:00', '10800'), ('366', 'UA', 'Europe/Zaporozhye', '+03:00', '10800'), ('367', 'UG', 'Africa/Kampala', '+03:00', '10800'), ('368', 'UM', 'Pacific/Johnston', '-10:00', '-36000'), ('369', 'UM', 'Pacific/Midway', '-11:00', '-39600'), ('370', 'UM', 'Pacific/Wake', '+12:00', '43200'), ('371', 'US', 'America/New_York', '-04:00', '-14400'), ('372', 'US', 'America/Detroit', '-04:00', '-14400'), ('373', 'US', 'America/Kentucky/Louisville', '-04:00', '-14400'), ('374', 'US', 'America/Kentucky/Monticello', '-04:00', '-14400'), ('375', 'US', 'America/Indiana/Indianapolis', '-04:00', '-14400'), ('376', 'US', 'America/Indiana/Vincennes', '-04:00', '-14400'), ('377', 'US', 'America/Indiana/Winamac', '-04:00', '-14400'), ('378', 'US', 'America/Indiana/Marengo', '-04:00', '-14400'), ('379', 'US', 'America/Indiana/Petersburg', '-04:00', '-14400'), ('380', 'US', 'America/Indiana/Vevay', '-04:00', '-14400'), ('381', 'US', 'America/Chicago', '-05:00', '-18000'), ('382', 'US', 'America/Indiana/Tell_City', '-05:00', '-18000'), ('383', 'US', 'America/Indiana/Knox', '-05:00', '-18000'), ('384', 'US', 'America/Menominee', '-05:00', '-18000'), ('385', 'US', 'America/North_Dakota/Center', '-05:00', '-18000'), ('386', 'US', 'America/North_Dakota/New_Salem', '-05:00', '-18000'), ('387', 'US', 'America/North_Dakota/Beulah', '-05:00', '-18000'), ('388', 'US', 'America/Denver', '-06:00', '-21600'), ('389', 'US', 'America/Boise', '-06:00', '-21600'), ('390', 'US', 'America/Phoenix', '-07:00', '-25200'), ('391', 'US', 'America/Los_Angeles', '-07:00', '-25200'), ('392', 'US', 'America/Anchorage', '-08:00', '-28800'), ('393', 'US', 'America/Juneau', '-08:00', '-28800'), ('394', 'US', 'America/Sitka', '-08:00', '-28800'), ('395', 'US', 'America/Yakutat', '-08:00', '-28800'), ('396', 'US', 'America/Nome', '-08:00', '-28800'), ('397', 'US', 'America/Adak', '-09:00', '-32400'), ('398', 'US', 'America/Metlakatla', '-08:00', '-28800'), ('399', 'US', 'Pacific/Honolulu', '-10:00', '-36000'), ('400', 'UY', 'America/Montevideo', '-03:00', '-10800'), ('401', 'UZ', 'Asia/Samarkand', '+05:00', '18000');
INSERT INTO `zone` VALUES ('402', 'UZ', 'Asia/Tashkent', '+05:00', '18000'), ('403', 'VA', 'Europe/Vatican', '+02:00', '7200'), ('404', 'VC', 'America/St_Vincent', '-04:00', '-14400'), ('405', 'VE', 'America/Caracas', '-04:30', '-16200'), ('406', 'VG', 'America/Tortola', '-04:00', '-14400'), ('407', 'VI', 'America/St_Thomas', '-04:00', '-14400'), ('408', 'VN', 'Asia/Ho_Chi_Minh', '+07:00', '25200'), ('409', 'VU', 'Pacific/Efate', '+11:00', '39600'), ('410', 'WF', 'Pacific/Wallis', '+12:00', '43200'), ('411', 'WS', 'Pacific/Apia', '+13:00', '46800'), ('412', 'YE', 'Asia/Aden', '+03:00', '10800'), ('413', 'YT', 'Indian/Mayotte', '+03:00', '10800'), ('414', 'ZA', 'Africa/Johannesburg', '+02:00', '7200'), ('415', 'ZM', 'Africa/Lusaka', '+02:00', '7200'), ('416', 'ZW', 'Africa/Harare', '+02:00', '7200');
COMMIT;

-- ----------------------------
-- Auto increment value for `zone`
-- ----------------------------
ALTER TABLE `zone` AUTO_INCREMENT=417;