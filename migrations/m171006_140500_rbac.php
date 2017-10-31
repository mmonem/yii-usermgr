<?php

use yii\console\controllers\MigrateController;
use yii\db\Migration;

/**
 * Class m171006_140500_rbac
 */
class m171006_140500_rbac extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $migration = new MigrateController('migrate', Yii::$app);
        $migration->run('up', ['migrationPath' => '@yii/rbac/migrations']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171006140500_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006140500_rbac cannot be reverted.\n";

        return false;
    }
    */
}
