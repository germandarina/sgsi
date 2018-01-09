<?php

class m180109_032245_alter_table_dependencias_fk_analisis extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `dependencia`
                ADD INDEX `analisis_id` (`analisis_id`),
                ADD CONSTRAINT `fk_dependencias_analisis_id` FOREIGN KEY (`analisis_id`) REFERENCES `analisis` (`id`);
            ");
	}

	public function down()
	{
		echo "m180109_032245_alter_table_dependencias_fk_analisis does not support migration down.\n";
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