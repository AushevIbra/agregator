<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form \backend\models\user\UserForm */
/* @var $htmlForm yii\widgets\ActiveForm */
?>

<div class="user-form">

	<?= $htmlForm->field($form, $form::ATTR_USERNAME)->textInput(['autofocus' => true]) ?>
	<?= $htmlForm->field($form, $form::ATTR_EMAIL) ?>
	<?= $htmlForm->field($form, $form::ATTR_ROLE)->dropDownList($form->getRoles()) ?>


</div>
