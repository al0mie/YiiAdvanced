<?php

use yii\db\Migration;

class m170305_184431_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'password' => $this->string(),
            'email' => $this->string(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'middle_name' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
