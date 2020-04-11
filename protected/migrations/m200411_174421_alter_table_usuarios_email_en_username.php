<?php

class m200411_174421_alter_table_usuarios_email_en_username extends CDbMigration
{
	public function up()
	{
	    try{

	        $transaction = Yii::app()->db->beginTransaction();
                $query = "select * from usuario";
                $command = Yii::app()->db->createCommand($query);
                $usuarios = $command->queryAll();
	            if(!empty($usuarios)){
	                foreach ($usuarios as $user){
                        if(!filter_var($user['username'], FILTER_VALIDATE_EMAIL)) {
                            $email = $user['username']."@gmail.com";
                            $queryUpdate = "update usuario set username= '".$email."' where id=".$user['id'];
                            $command = Yii::app()->db->createCommand($queryUpdate);
                            $command->execute();
                        }
                    }
                }
	        $transaction->commit();
        }catch (Exception $exception){
	        $transaction->rollback();
	        echo $exception->getMessage();
        }
	}

	public function down()
	{
		echo "m200411_174421_alter_table_usuarios_email_en_username does not support migration down.\n";
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