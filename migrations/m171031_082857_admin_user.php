<?php

use app\modules\usersadmin\models\User;
use yii\db\Migration;

/**
 * Class m171031_082857_admin_user
 */
class m171031_082857_admin_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $u = new User();
        $u->email = "admin@example.com";
       $u->name = "Administrator";
        $u->password = md5("Password");
        if (!$u->save()) {
            print_r($u->errors);
            return false;
        }

        $auth = Yii::$app->authManager;

        $root = $auth->createRole('root');
        $auth->add($root);
        $auth->assign($root, $u->getId());

        $usersManage = $auth->createRole('users.manage');
        $auth->add($usersManage);
        $auth->addChild($root, $usersManage);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171031_082857_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171031_082857_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
