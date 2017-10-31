<?php

use yii\db\Migration;

/**
 * Class m171007_120635_users_table
 */
class m171007_120635_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%user}}', [
            'uuid' => $this->string(36)->notNull(),
            'email' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'PRIMARY KEY(uuid)',
        ], $tableOptions);

        $this->execute('
        CREATE TRIGGER before_insert_user
          BEFORE INSERT ON user
          FOR EACH ROW
          SET new.uuid = uuid();');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171007_120635_users_table cannot be reverted.\n";

        return false;
    }
    */
}
