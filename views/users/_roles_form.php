<?php

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model User */
/* @var $form ActiveForm */

$roles = [];
$roles2 = Yii::$app->authManager->getRoles();
array_walk($roles2, function($x) use(&$roles) {
    $roles[$x->name] = Yii::t('app', $x->description);
});
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serviceids')->inline(false)->checkboxList($roles); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
