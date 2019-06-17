<?php

class m190616_235054_create_table_amenaza_vulnerabilidad extends CDbMigration
{
	public function up()
	{
	    $this->execute("CREATE TABLE `dime-100`.amenaza_vulnerabilidad (
                            id INT NOT NULL AUTO_INCREMENT,
                            amenaza_id INT NOT NULL,
                            vulnerabilidad_id INT NOT NULL,
                            `creaUserStamp` VARCHAR(50) NULL,
                            `creaTimeStamp` TIMESTAMP NULL,
                            `modUserStamp` VARCHAR(50) NULL,
                            `modTimeStamp` TIMESTAMP NULL,
                            CONSTRAINT amenaza_vulnerabilidad_PK PRIMARY KEY (id),
                            CONSTRAINT amenaza_vulnerabilidad_FK FOREIGN KEY (amenaza_id) REFERENCES `dime-100`.amenaza(id),
                            CONSTRAINT amenaza_vulnerabilidad_FK_1 FOREIGN KEY (vulnerabilidad_id) REFERENCES `dime-100`.vulnerabilidad(id)
                            )
                            ENGINE=InnoDB
                            DEFAULT CHARSET=utf8
                            COLLATE=utf8_spanish_ci;
                            CREATE INDEX amenaza_vulnerabilidad_id_IDX USING BTREE ON `dime-100`.amenaza_vulnerabilidad (id);
                            CREATE INDEX amenaza_vulnerabilidad_amenaza_id_IDX USING BTREE ON `dime-100`.amenaza_vulnerabilidad (amenaza_id);
                            CREATE INDEX amenaza_vulnerabilidad_vulnerabilidad_id_IDX USING BTREE ON `dime-100`.amenaza_vulnerabilidad (vulnerabilidad_id);
        ");
	}

	public function down()
	{
		echo "m190616_235054_create_table_amenaza_vulnerabilidad does not support migration down.\n";
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