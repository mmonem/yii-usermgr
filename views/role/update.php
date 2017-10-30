<?php

use app\modules\usersadmin\models\ServiceFormModel;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ServiceFormModel */

$this->title = Yii::t('app', 'Update Service:') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
