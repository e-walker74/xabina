<?php

class m140709_203922_contact_categories extends CDbMigration
{
    public function up()
    {
        $this->execute('
            CREATE TABLE IF NOT EXISTS `users_contacts_categories` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned NOT NULL,
              `section` varchar(255) NOT NULL,
              `description` varchar(255) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_contacts_categories_user_owner` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

            -- --------------------------------------------------------

            --
            -- Структура таблицы `users_contacts_categories_links`
            --

            CREATE TABLE IF NOT EXISTS `users_contacts_categories_links` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `category_id` int(11) unsigned NOT NULL,
              `contact_id` int(11) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_contacts_category` (`category_id`),
              KEY `fk_contacts_contact` (`contact_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

            -- --------------------------------------------------------

            --
            -- Структура таблицы `users_contacts_data_categories`
            --

            CREATE TABLE IF NOT EXISTS `users_contacts_data_categories` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned DEFAULT NULL,
              `data_type` varchar(30) NOT NULL,
              `value` text NOT NULL,
              `language` varchar(2) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_contacts_categories_data_user` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

            --
            -- Ограничения внешнего ключа сохраненных таблиц
            --

            --
            -- Ограничения внешнего ключа таблицы `users_contacts_categories`
            --
            ALTER TABLE `users_contacts_categories`
              ADD CONSTRAINT `fk_contacts_categories_user_owner` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

            --
            -- Ограничения внешнего ключа таблицы `users_contacts_categories_links`
            --
            ALTER TABLE `users_contacts_categories_links`
              ADD CONSTRAINT `fk_contacts_category` FOREIGN KEY (`category_id`) REFERENCES `users_contacts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `fk_contacts_contact` FOREIGN KEY (`contact_id`) REFERENCES `users_contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

            --
            -- Ограничения внешнего ключа таблицы `users_contacts_data_categories`
            --
            ALTER TABLE `users_contacts_data_categories`
              ADD CONSTRAINT `fk_contacts_categories_data_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

            ALTER TABLE `users_contacts` CHANGE `xabina_id` `xabina_id` VARCHAR(20) NULL DEFAULT NULL;

        ');
    }

	public function down()
	{
		echo "m140709_203922_contact_categories does not support migration down.\n";
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