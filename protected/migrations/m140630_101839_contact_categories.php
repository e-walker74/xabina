<?php

class m140630_101839_contact_categories extends CDbMigration
{
	public function up()
	{
        $this->execute('CREATE TABLE IF NOT EXISTS `users_contacts_categories` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) unsigned NOT NULL,
          `section` varchar(255) NOT NULL,
          `description` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_contacts_categories_user_owner` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
          ADD CONSTRAINT `fk_contacts_contact` FOREIGN KEY (`contact_id`) REFERENCES `users_contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `fk_contacts_category` FOREIGN KEY (`category_id`) REFERENCES `users_contacts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ');
	}

	public function down()
	{
		echo "m140630_101839_contact_categories does not support migration down.\n";
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