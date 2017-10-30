<?php

namespace app\modules\usersadmin\models;

use Yii;
use yii\base\Model;
use yii\rbac\Role;

/**
 * Description of ServiceFormModel
 *
 * @author monem
 */
class ServiceFormModel extends Model
{
    /**
     *
     * @var string the name of the role 
     */
    public $name;

    /**
     *
     * @var string the description of the role 
     */
    public $description;
    
    /**
     *
     * @var array the array of databases associated with this service 
     */
    public $dbs;
    
    protected $oldName;

	/**
     *
     * @var boolean if the model is loaded from a model it is true, otherwise
     * it remains false meaning that it is used to hold data for new creation of
     * the ActicveRecord database model
     */
    protected $loadedFromModel;

    
    function __construct($config = array()) {
        $this->name = 'SERVICE NAME';
        $this->description = 'SERVICE DESCRIPTION';
        $this->dbs = [];
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'dbs'], 'required'],
            ['description', 'string', 'max' => 100],
            [['name'], 'string', 'max' => 64],
//            ['name', 'unique', 'targetClass' => 'app\models\Service', 'targetAttribute' => 'NAME',
//				'when' => function ($model, $attribute) {
//					return $model->name !== $model->oldName;
//				},
//			],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'dbs' => Yii::t('app', 'Databases'),
        ];
    }
    
    
    /**
     * Load data from the specified database ActiveRecord model into this
     * @param Role $role
     */
    public function loadFromModel($role)
    {
        $this->name = $role->name;
        $this->description = $role->description;
        $this->dbs = array_map(function ($x) {return $x->name;}, Yii::$app->authManager->getPermissionsByRole($this->name));
        $this->loadedFromModel = true;
		$this->oldName = $role->name;
    }
    
    /**
     * Save the internal data into the specified database ActiveRecord model
     * @return Role the role
     */
    public function saveToNewModel()
    {
        $role = new Role();
        $role->name = $this->name;
        $role->description = $this->description;
        Yii::$app->authManager->add($role);
        
        foreach ($this->dbs as $permName)
        {
            $perm = Yii::$app->authManager->getPermission($permName);
            if (isset($perm))
            {
                Yii::$app->authManager->addChild($role, $perm);
            }
        }
        return $role;
    }
    
    public function saveToModel($role)
    {
        $role->description = $this->description;
        Yii::$app->authManager->update($role->name, $role);
        
        $oldRoles = Yii::$app->authManager->getPermissionsByRole($role->name);
        $oldNames = array_map(function ($x) {
            return $x->name;
        }, $oldRoles);
        $toDelete = array_diff($oldNames, $this->dbs);
        $toAdd = array_diff($this->dbs, $oldNames);
        
        foreach ($toDelete as $x)
        {
            $perm = Yii::$app->authManager->getPermission($x);
            if (isset($perm))
            {
                $role = Yii::$app->authManager->removeChild($role, $perm);
            }
        }        
        foreach ($toAdd as $x)
        {
            $perm = Yii::$app->authManager->getPermission($x);
            if (isset($perm))
            {
                $role = Yii::$app->authManager->addChild($role, $perm);
            }
        }        
    }
    
    /**
     * This function is used mainly by views to see if we should make the caption
     * of the button 'Create' or 'Update'.
     */
    public function getIsNewRecord() {
        return !$this->loadedFromModel;
    }
}
