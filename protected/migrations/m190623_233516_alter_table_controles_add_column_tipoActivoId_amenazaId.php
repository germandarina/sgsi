<?php

class m190623_233516_alter_table_controles_add_column_tipoActivoId_amenazaId extends CDbMigration
{
	public function up()
	{
	    $this->execute("alter table control
	                            add amenaza_id int null after numeracion;

                            alter table control
                                add tipo_activo_id int null after amenaza_id;
                            
                            alter table control modify creaTimeStamp timestamp null after modTimeStamp;
                            
                            alter table control modify creaUserStamp varchar(50) null after creaTimeStamp;
                            
                            create index control_amenaza_id_index
                                on control (amenaza_id);
                            
                            create index control_tipo_activo_id_index
                                on control (tipo_activo_id);
                            
                            alter table control
                                add constraint control_fk_amenaza_id
                                    foreign key (amenaza_id) references amenaza (id);
                            
                            alter table control
                                add constraint control_fk_tipo_activo_id
                                    foreign key (tipo_activo_id) references tipo_activo (id);");

	}

	public function down()
	{
		echo "m190623_233516_alter_table_controles_add_column_tipoActivoId_amenazaId does not support migration down.\n";
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