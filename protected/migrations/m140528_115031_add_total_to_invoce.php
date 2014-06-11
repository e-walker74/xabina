<?php

class m140528_115031_add_total_to_invoce extends CDbMigration
{
	public function up()
	{
		$this->execute('
			ALTER TABLE `invoices` 
				ADD `subtotal` DOUBLE NOT NULL , 
				ADD `total` DOUBLE NOT NULL , 
				ADD `created_at` INT NOT NULL , 
				ADD `updated_at` INT NOT NULL ;
		');
		
		$this->execute('
			ALTER TABLE `invoices` CHANGE `date` `invoice_date` INT NULL;
			ALTER TABLE `invoices` CHANGE `due_date` `due_date` INT NULL;
		');
		
	}

	public function down()
	{
		$this->execute('
			ALTER TABLE `invoices`
			  DROP `subtotal`,
			  DROP `total`,
			  DROP `created_at`,
			  DROP `updated_at`;
		');
		return false;
	}
}