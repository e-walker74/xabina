/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50171
Source Host           : localhost:3306
Source Database       : evnaby_xabina

Target Server Type    : MYSQL
Target Server Version : 50171
File Encoding         : 65001

Date: 2014-08-11 21:42:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `users_providers_google_oauth`
-- ----------------------------
DROP TABLE IF EXISTS `users_providers_google_oauth`;
CREATE TABLE `users_providers_google_oauth` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) UNSIGNED NOT NULL ,
`soc_id`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`full_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`avatar`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`login`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_providers_google_oauth_user` USING BTREE (`user_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of users_providers_google_oauth
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Auto increment value for `users_providers_google_oauth`
-- ----------------------------
ALTER TABLE `users_providers_google_oauth` AUTO_INCREMENT=1;
