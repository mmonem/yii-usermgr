<?php

namespace app\modules\usersadmin\controllers;


use app\modules\usersadmin\models\ServiceFormModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class RoleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'change-password', 'delete', 'roles'],
                        'roles' => ['users.manage'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Roles.
     * @return mixed
     */
    public function actionIndex()
    {
        $a = Yii::$app->authManager->getRoles();
        $dataProvider = new ArrayDataProvider([
            'allModels' => Yii::$app->authManager->getRoles(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Role.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $formModel = new ServiceFormModel();
        if ($formModel->load(Yii::$app->request->post()))
        {
            if ($formModel->validate())
            {
                $role = $formModel->saveToNewModel();
                $perms = Yii::$app->authManager->getPermissionsByRole($role->name);
                $dbs = implode(', ', array_map(function ($x) {
                    return $x->name;
                }, $perms));
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $formModel,
        ]);
    }

    /**
     * Updates an existing Role.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $role = Yii::$app->authManager->getRole($id);
        $formModel = new ServiceFormModel();
        $formModel->loadFromModel($role);

        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate())
        {
            $formModel->saveToModel($role);
            $perms = Yii::$app->authManager->getPermissionsByRole($role->name);
            $dbs = implode(', ', array_map(function ($x) {
                return $x->name;
            }, $perms));
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', [
                'model' => $formModel,
                'id' => $role->name
            ]);
        }
    }

    /**
     * Deletes an existing user role.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $role = Yii::$app->authManager->getRole($id);
        Yii::$app->authManager->remove($role);
        return $this->redirect(['index']);
    }
}