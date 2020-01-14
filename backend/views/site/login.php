<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title                   = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login d-flex justify-content-center w-100 h-100">
    <div>
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Пожалуйста, заполните следующие поля для входа:</p>

        <div class="row">
            <div class="col-lg-12">
				<?php $form = ActiveForm::begin([
					'id'            => 'login-form',
					'errorCssClass' => 'error',
					'fieldConfig'   => [
						'horizontalCssClasses' => "md-form"
					],
				]); ?>

				<?= $form->field($model,
					'username')->textInput(['autofocus' => true])->error(['class' => 'help-block help-block-error text-danger'])->label('Логин') ?>

				<?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

				<?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

                <div class="form-group">
					<?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

				<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
