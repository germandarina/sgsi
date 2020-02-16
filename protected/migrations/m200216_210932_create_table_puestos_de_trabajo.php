<?php

class m200216_210932_create_table_puestos_de_trabajo extends CDbMigration
{
	public function up()
	{
	    $this->execute("create table puestos_de_trabajo
                            (
                                id int auto_increment,
                                area_id int not null,
                                nombre varchar(255) not null,
                                `creaUserStamp` VARCHAR(50) NULL,
                                `creaTimeStamp` TIMESTAMP NULL,
                                `modUserStamp` VARCHAR(50) NULL,
                                `modTimeStamp` TIMESTAMP NULL,
                                constraint puestos_de_trabajo_pk
                                    primary key (id),
                                constraint puestos_de_trabajo_area_id_fk
                                    foreign key (area_id) references area (id)
                            );
                            
                            create index puestos_de_trabajo_area_id_index
                                on puestos_de_trabajo (area_id);");
	}

	public function down()
	{
		echo "m200216_210932_create_table_puestos_de_trabajo does not support migration down.\n";
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