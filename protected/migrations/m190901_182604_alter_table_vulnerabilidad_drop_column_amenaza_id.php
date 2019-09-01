<?php

class m190901_182604_alter_table_vulnerabilidad_drop_column_amenaza_id extends CDbMigration
{
	public function up()
	{
	    $this->execute("ALTER TABLE `dime-sgsi`.vulnerabilidad DROP FOREIGN KEY fk_vulnerabilidad_amenaza_id;
                             ALTER TABLE `dime-sgsi`.vulnerabilidad DROP COLUMN amenaza_id;
                             ALTER TABLE `dime-sgsi`.vulnerabilidad DROP INDEX amenaza_id;
                            ");
	}

	public function down()
	{
		echo "m190901_182604_alter_table_vulnerabilidad_drop_column_amenaza_id does not support migration down.\n";
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