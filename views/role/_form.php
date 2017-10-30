<?php

use app\modules\usersadmin\models\ServiceFormModel;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model ServiceFormModel */
/* @var $form ActiveForm */

$permissions = [];
$perms = Yii::$app->authManager->getPermissions();
array_map(function($x) use(&$permissions) {
    $permissions[$x->name] = $x->description;
}, $perms);

?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dbs')->inline(false)->checkboxList($permissions); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
