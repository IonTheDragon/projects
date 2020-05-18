<?php

use yii\db\Migration;

/**
 * Class m200518_135431_mysql_deploy
 */
class m200518_135431_mysql_deploy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/init.sql');
        $command = Yii::$app->db->createCommand($sql);
        $command->execute();

        // Make sure, we fetch all errors
        while ($command->pdoStatement->nextRowSet()) {}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200518_135431_mysql_deploy cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200518_135431_mysql_deploy cannot be reverted.\n";

        return false;
    }
    */
}
