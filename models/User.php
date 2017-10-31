<?php

namespace app\modules\usersadmin\models;
use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $uuid
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public function getUsername() {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 100, 'min' => 3],
            ['email', 'email'],
            ['password', 'string', 'max' => 100, 'on' => ['create', 'change-password']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uuid' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'E-Mail'),
            'password' => Yii::t('app', 'Password'),
            'name' => Yii::t('app', 'Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord)
            {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString(255);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['uuid' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->uuid;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $md5GivenPassword = md5($password);
        return $this->password === $md5GivenPassword;
    }

    public function getAllowedServiceNames($glue = null)
    {
        $ret = [];
        $models = $this->getAllowedServices();
        foreach ($models as $model)
        {
            $ret[] = Yii::t('unr', $model->description);
        }
        if (empty($glue))
        {
            return $ret;
        }
        return implode($glue, $ret);
    }

    private function getAllowedServices()
    {
        return Yii::$app->authManager->getRolesByUser($this->uuid);
    }

}
