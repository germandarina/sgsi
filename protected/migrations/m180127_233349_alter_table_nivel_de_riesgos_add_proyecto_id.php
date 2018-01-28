<?php

class m180127_233349_alter_table_nivel_de_riesgos_add_proyecto_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `nivel_de_riesgos`
                            ADD COLUMN `proyecto_id` INT NULL DEFAULT NULL,
                            ADD INDEX `proyecto_id` (`proyecto_id`),
                            ADD CONSTRAINT `fk_nivel_de_riesgos_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`);
                        ");
	}

	public function down()
	{
		echo "m180127_233349_alter_table_nivel_de_riesgos_add_proyecto_id does not support migration down.\n";
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