<?php

class m200107_030950_create_table_proyecto_usuario extends CDbMigration
{
	public function up()
	{
	    $this->execute("create table proyecto_usuario
                            (
                                id int auto_increment,
                                proyecto_id int not null,
                                usuario_id int not null,
                                `creaUserStamp` VARCHAR(50) NULL,
                                `creaTimeStamp` TIMESTAMP NULL,
                                `modUserStamp` VARCHAR(50) NULL,
                                `modTimeStamp` TIMESTAMP NULL,
                                constraint proyecto_usuario_pk
                                    primary key (id),
                                constraint proyecto_usuario_proyecto_id_fk
                                    foreign key (proyecto_id) references proyecto (id),
                                constraint proyecto_usuario_usuario_id_fk
                                    foreign key (usuario_id) references usuario (id)
                            );
                            
                            create index proyecto_usuario_proyecto_id_index
                                on proyecto_usuario (proyecto_id);
                            
                            create index proyecto_usuario_usuario_id_index
                                on proyecto_usuario (usuario_id);
                            ");
	}

	public function down()
	{
		echo "m200107_030950_create_table_proyecto_usuario does not support migration down.\n";
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