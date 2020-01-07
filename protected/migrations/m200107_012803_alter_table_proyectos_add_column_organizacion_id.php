<?php

class m200107_012803_alter_table_proyectos_add_column_organizacion_id extends CDbMigration
{
	public function up()
	{
	    $this->execute("alter table proyecto
                                add organizacion_id int default null null;
                            
                            create index proyecto_organizacion_id_index
                                on proyecto (organizacion_id);
                            
                            alter table proyecto
                                add constraint proyecto_organizacion_id_fk
                                    foreign key (organizacion_id) references organizacion (id);");
	}

	public function down()
	{
		echo "m200107_012803_alter_table_proyectos_add_column_organizacion_id does not support migration down.\n";
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