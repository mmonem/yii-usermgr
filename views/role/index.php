<?php

use app\modules\usersadmin\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Service'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'header' => Yii::t('app', 'Permissions'),
                'format' => 'raw',
                'value' => function($model) {
                    $html = "<ul>";
                    $perms = Yii::$app->authManager->getPermissionsByRole($model->name);
                    foreach ($perms as $perm)
                    {
                        $html .= "<li>" . Yii::t('app', $perm->name) . "</li>";
                    }
                    $html .= "</ul>";
                    return $html;
                },
            ],
            [
                'header' => Yii::t('app', 'Users'),
                'format' => 'raw',
                'value' => function($model) {
                    $html = "<ul>";
                    $usersIds = Yii::$app->authManager->getUserIdsByRole($model->name);
                    foreach ($usersIds as $userId)
                    {
                        $user = User::findOne(['uuid' => $userId]);
                        $html .= "<li>" . ($user ? $user->name : "?") . "</li>";
                    }
                    $html .= "</ul>";
                    return $html;
                },
            ],

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
