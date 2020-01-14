<?php

/* @var $this yii\web\View */

/* @var $form \frontend\models\RestaurantFrontendForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
			<?php $htmlForm = ActiveForm::begin(['id' => 'restaurant-form']); ?>

			<?= $htmlForm->field($form, $form::ATTR_NAME)->textInput(['autofocus' => true]) ?>

			<?= $htmlForm->field($form, $form::ATTR_DESCRIPTION)->textarea() ?>

            <div class="form-group">
				<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'restaurant-button']) ?>
            </div>

			<?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
