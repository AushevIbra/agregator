<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form \backend\models\food\FoodForm */
/* @var $htmlForm yii\widgets\ActiveForm */
?>

<div class="ref-foods-form">

    <div class="card">
        <div class="card-header text-white">
            Основная информация
        </div>
        <div class="card-body">
			<?= $htmlForm->field($form, $form::ATTR_NAME)->textInput(['maxlength' => true]) ?>

			<?= $htmlForm->field($form, $form::ATTR_PRICE)->textInput() ?>

			<?= $htmlForm->field($form, $form::ATTR_OLD_PRICE)->textInput() ?>

			<?= $htmlForm->field($form, $form::ATTR_DESCRIPTION)->textarea(['rows' => 6]) ?>

			<?= $htmlForm->field($form, $form::ATTR_REF_FOOD_CATEGORY_ID)->dropDownList($form->getCategories()) ?>

			<?= $htmlForm->field($form, $form::ATTR_STATUS)->dropDownList($form->getStatuses()) ?>

			<?= $htmlForm->field($form, $form::ATTR_IMG)->widget(FileInput::class, [
				'language' => 'ru',
				'options'  => [
					'accept'   => 'image/*',
					'multiple' => false,
				],
			]) ?>
        </div>
    </div>


</div>
