<?php

declare(strict_types=1);

namespace backend\views\foodCategory;

use backend\models\foodCategory\FoodCategoryForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var FoodCategoryForm $form
 * @var View $this
 *
 * @author Ibra Aushev <aushevibra@yandex.ru>
 */
?>
	<?php $htmlForm = ActiveForm::begin([
	'options' => [
		'enctype' => 'multipart/form-data',
	],
]) ?>

<?= $this->render('_form', [
	'htmlForm' => $htmlForm,
	'form'     => $form,
]) ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-sm btn-success']) ?>

	<?php $htmlForm::end() ?>