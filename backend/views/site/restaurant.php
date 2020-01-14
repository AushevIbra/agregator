<?php

use common\widgets\Alert;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form \backend\models\restaurant\RestaurantForm */
/* @var $htmlForm ActiveForm */
?>
<div class="restaurant-_form">
	<?= Alert::widget() ?>
	<?php $htmlForm = ActiveForm::begin(); ?>

	<?= $htmlForm->field($form, $form::ATTR_NAME) ?>
	<?= $htmlForm->field($form, $form::ATTR_SLUG) ?>
	<?= $htmlForm->field($form, $form::ATTR_DESCRIPTION)->textarea() ?>
	<?= $htmlForm->field($form, $form::ATTR_STATUS)->dropDownList($form->getStatuses()) ?>
	<?= $htmlForm->field($form, $form::ATTR_MIN_AMOUNT) ?>
	<?= $htmlForm->field($form, $form::ATTR_MIN_DELIVERY_TIME) ?>
	<?= $htmlForm->field($form, $form::ATTR_MAX_DELIVERY_TIME) ?>
	<?= $htmlForm->field($form, $form::ATTR_FREE_FROM) ?>

	<?= $htmlForm->field($form, $form::ATTR_IMG)->widget(FileInput::class, [
		'language' => 'ru',
		'options'  => [
			'accept'   => 'image/*',
			'multiple' => false,
		],
	]) ?>

	<?= $htmlForm->field($form->categories, $form->categories::ATTR_CATEGORIES)->widget(Select2::class, [
		'data'          => $form->categories->getCategoriesList(),
		'theme'         => Select2::THEME_BOOTSTRAP,
		'language'      => Yii::$app->language,
		'options'       => ['placeholder' => 'Выберите категории...'],
		'pluginOptions' => [
			'allowClear' => true,
			'tags'       => true,
			'multiple'   => true,
		],
	]); ?>


    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
	<?php ActiveForm::end(); ?>

</div><!-- restaurant-_form -->
