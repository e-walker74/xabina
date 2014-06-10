<?php

class m140603_184324_dialogues extends CDbMigration
{
	public function up()
	{
		$this->execute('
			CREATE  TABLE IF NOT EXISTS `dialogues_messages` (
			  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
			  `dialog_id` INT UNSIGNED NOT NULL ,
			  `user_id` INT UNSIGNED NULL ,
			  `status` TINYINT(2) UNSIGNED NOT NULL ,
			  `category_id` INT NULL ,
			  `read_at` INT UNSIGNED NULL ,
			  `message` TEXT(1023) NOT NULL ,
			  `created_at` INT UNSIGNED NOT NULL ,
			  `updated_at` INT UNSIGNED NOT NULL ,
			  PRIMARY KEY (`id`) )
			ENGINE = InnoDB
			COMMENT = "Messages. If user_id is null, this message from administration";
		');
		
		$this->execute('
			CREATE  TABLE IF NOT EXISTS `dialogues_users` (
			  `id` INT NOT NULL AUTO_INCREMENT ,
			  `dialog_id` INT UNSIGNED NOT NULL ,
			  `user_id` INT UNSIGNED NULL ,
			  PRIMARY KEY (`id`))
			ENGINE = InnoDB
			COMMENT = "Users in dialog";
		');
		
		$this->execute('
			CREATE  TABLE IF NOT EXISTS `dialogues_messages_categories` (
			  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
			  `user_id` INT UNSIGNED NOT NULL ,
			  `category` VARCHAR(45) NOT NULL ,
			  PRIMARY KEY (`id`))
			ENGINE = InnoDB
			COMMENT = "Пользователи в будущем смогут добавлять свои категории к сообщениям";
		');

		$this->execute('
			CREATE  TABLE IF NOT EXISTS `dialogues` (
			  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
			  `owner_id` INT UNSIGNED NOT NULL ,
			  `entity_type` VARCHAR(45) NOT NULL ,
			  `entity_id` INT UNSIGNED NULL ,
			  `type` ENUM("user","admin") NULL ,
			  PRIMARY KEY (`id`) )
			ENGINE = InnoDB;
		');
		
		$this->execute('
			CREATE  TABLE IF NOT EXISTS `dialogues_messages_links` (
			  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
			  `message_id` INT UNSIGNED NOT NULL ,
			  `user_id` INT UNSIGNED NOT NULL ,
			  PRIMARY KEY (`id`))
			ENGINE = InnoDB
			COMMENT = "Пользователь которого удалили из диалога видит часть в которой он присутствовал, \nесли его вернули, он не видит часть в которой он отсутствовал";
		');
		
	}

	public function down()
	{
		echo "m140603_184324_dialogues does not support migration down.\n";
		return false;
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