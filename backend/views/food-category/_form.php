<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var \backend\models\foodCategory\FoodCategoryForm $form */
/* @var ActiveForm $htmlForm */
?>

<div class="ref-food-categories-form">


	<?= $htmlForm->field($form, $form::ATTR_NAME)->textInput(['maxlength' => true]) ?>

	<?= $htmlForm->field($form, $form::ATTR_STATUS)->dropDownList($form->getStatuses(), ['class' => 'browser-default custom-select']) ?>


</div>
