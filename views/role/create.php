<?php

use app\modules\usersadmin\models\ServiceFormModel;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model ServiceFormModel */

$this->title = Yii::t('unr', 'Create Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('unr', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
