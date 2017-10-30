<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'uuid',
            'email:email',
            'name',
            [
                'class' => 'yii\grid\ActionColumn', 'template'=>'{view} {update} {roles} {password} {delete}',
                'buttons'=> [
                    'password' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock']), Url::to(["/usersadmin/users/change-password", "id"=>$model->uuid]));
                    },
                    'roles' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']), Url::to(["/usersadmin/users/roles", "id"=>$model->uuid]));
                    },
                ],
            ],
        ],
    ]); ?>
</div>
