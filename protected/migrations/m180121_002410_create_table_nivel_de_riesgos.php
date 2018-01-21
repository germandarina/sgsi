<?php

class m180121_002410_create_table_nivel_de_riesgos extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `nivel_de_riesgos` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `valor_minimo` INT NOT NULL,
                            `valor_maximo` INT NOT NULL,
                            `concepto` INT NOT NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            PRIMARY KEY (`id`)
                        )
                        COLLATE='utf8_spanish2_ci'
                        ENGINE=InnoDB
                        ;
                        ");
	}

	public function down()
	{
		echo "m180121_002410_create_table_nivel_de_riesgos does not support migration down.\n";
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