<?php

class m140521_075122_create_rbac_roles_table extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `rbac_roles` (
						  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `is_system` tinyint(2) unsigned NOT NULL,
						  `create_uid` int(11) unsigned NOT NULL,
						  `parent_id` int(11) unsigned DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Roles'");
	}

	public function down()
	{
		$this->dropTable('rbac_roles');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}