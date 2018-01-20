<?php

class m180119_234552_alter_table_relacionales_analisis_drop_grupo_id extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `analisis_vulnerabilidad`
                            DROP COLUMN `grupo_id`,
                            DROP INDEX `grupo_id`,
                            DROP FOREIGN KEY `fk_analisis_vulnerabilidad_grupo_id`;");

        $this->execute("ALTER TABLE `analisis_control`
                            DROP COLUMN `grupo_id`,
                            DROP INDEX `grupo_id`,
                            DROP FOREIGN KEY `fk_analisis_control_grupo_id`;");

        $this->execute("ALTER TABLE `analisis_amenaza`
                            DROP COLUMN `grupo_id`,
                            DROP INDEX `grupo_id`,
                            DROP FOREIGN KEY `fk_analisis_amenaza_grupo_id`;");
	}

	public function down()
	{
		echo "m180119_234552_alter_table_relacionales_analisis_drop_grupo_id does not support migration down.\n";
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