<?php

class m171229_030501_alter_table_personal_add_proceso_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `personal`
                        ADD COLUMN `proceso_id` INT(11) NULL AFTER `area_id`,
                        ADD INDEX `proceso_id` (`proceso_id`),
                        ADD CONSTRAINT `fk_personal_proceso_id` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`);
                    ");
	}

	public function down()
	{
		echo "m171229_030501_alter_table_personal_add_proceso_id does not support migration down.\n";
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