<?php

class m171230_205703_alter_table_area_organizacion_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `area`
                        ADD COLUMN `organizacion_id` INT(11) NULL AFTER `descripcion`,
                        ADD INDEX `organizacion_id` (`organizacion_id`),
                        ADD CONSTRAINT `fk_area_organizacion_id` FOREIGN KEY (`organizacion_id`) REFERENCES `organizacion` (`id`);
                    ");
	}

	public function down()
	{
		echo "m171230_205703_alter_table_area_organizacion_id does not support migration down.\n";
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