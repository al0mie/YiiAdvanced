<?php

use yii\db\Migration;

class m170305_184445_user_subscribtion_table extends Migration
{
    public function up()
    {
        $this->createTable('user_subscription', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'end_date' => $this->integer(11)->null()->unSigned()
        ]);

        $this->createIndex(
            'idx-user_subscription-user_id',
            'user_subscription',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_subscription-user_id',
            'user_subscription',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-user_subscription-user_id',
            'user_subscription'
        );

        $this->dropIndex(
            'idx-user_subscription-user_id',
            'user_subscription'
        );

        $this->dropTable('user_subscription');
    }
}
