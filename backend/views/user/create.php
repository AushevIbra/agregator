<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title                   = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php $htmlForm = \yii\widgets\ActiveForm::begin([
		'options' => [
			'enctype' => 'multipart/form-data',
		],
	]) ?>
	<?= $this->render('_form', [
		'form'     => $form,
		'htmlForm' => $htmlForm
	]) ?>

    <div class="form-group">
		<?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php $htmlForm::end(); ?>
</div>
