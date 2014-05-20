<?php

class m140513_222842_alerts extends CDbMigration
{
	public function safeUp()
	{
        $this->execute('
            CREATE TABLE IF NOT EXISTS `alerts` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(50) NOT NULL COMMENT \'уникальный код алерта\',
                `name` VARCHAR(50) NOT NULL COMMENT \'кириллическое имя алерта\',
                `desc` VARCHAR(255) NULL DEFAULT NULL COMMENT \'описание алерта\',
                `use_rules` TINYINT(1) NOT NULL DEFAULT \'1\' COMMENT \'использует ли алерт правила\',
                PRIMARY KEY (`id`),
                INDEX `use_rules` (`use_rules`)
            ) COLLATE=\'utf8_general_ci\' ENGINE=InnoDB COMMENT=\'список алертов\'');

        $this->execute('
            CREATE TABLE IF NOT EXISTS `users_alerts_rules` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT NOT NULL COMMENT \'ссылка на users\',
                `account_id` INT NULL DEFAULT NULL COMMENT \'ссылка на accounts\',
                `alert_id` INT UNSIGNED NOT NULL COMMENT \'ссылка на alerts\',
                `greater` VARCHAR(50) NULL DEFAULT NULL COMMENT \'правило "больше"\',
                `less` VARCHAR(50) NULL DEFAULT NULL COMMENT \'правило "меньше"\',
                `equal` VARCHAR(50) NULL DEFAULT NULL COMMENT \'правило "равно"\',
                PRIMARY KEY (`id`),
                CONSTRAINT `users_alerts_rules_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_rules_accounts_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_rules_alerts_alert_id` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) COMMENT=\'правила алертов пользователя\' COLLATE=\'utf8_general_ci\' ENGINE=InnoDB');

        $this->execute('
            CREATE TABLE IF NOT EXISTS `users_alerts_email` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT NOT NULL COMMENT \'ссылка на users\',
                `email_id` INT NOT NULL COMMENT \'ссылка на users_emails\',
                `alert_rule_id` INT UNSIGNED NOT NULL COMMENT \'ссылка на users_alerts_rules\',
                PRIMARY KEY (`id`),
                CONSTRAINT `users_alerts_email_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_email_users_emails_email_id` FOREIGN KEY (`email_id`) REFERENCES `users_emails` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_email_users_alerts_rules_alert_rule_id` FOREIGN KEY (`alert_rule_id`) REFERENCES `users_alerts_rules` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) COMMENT=\'email адреса пользователей для алертов\' COLLATE=\'utf8_general_ci\' ENGINE=InnoDB');

        $this->execute('
            CREATE TABLE IF NOT EXISTS `users_alerts_phone` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT NOT NULL COMMENT \'ссылка на users\',
                `phone_id` INT NOT NULL COMMENT \'ссылка на users_phones\',
                `alert_rule_id` INT UNSIGNED NOT NULL COMMENT \'ссылка на users_alerts_rules\',
                PRIMARY KEY (`id`),
                CONSTRAINT `users_alerts_phone_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_phone_users_phones_phone_id` FOREIGN KEY (`phone_id`) REFERENCES `users_phones` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `users_alerts_phone_users_alerts_rules_alert_rule_id` FOREIGN KEY (`alert_rule_id`) REFERENCES `users_alerts_rules` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) COMMENT=\'телефоны пользователей для алертов\' COLLATE=\'utf8_general_ci\' ENGINE=InnoDB');
	}

	public function safeDown()
	{
        $this->execute('DROP TABLE IF EXISTS `users_alerts_phone`');
        $this->execute('DROP TABLE IF EXISTS `users_alerts_email`');
        $this->execute('DROP TABLE IF EXISTS `users_alerts_rules`');
        $this->execute('DROP TABLE IF EXISTS `alerts`');
	}
}