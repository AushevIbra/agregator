<?php

use common\models\db\RefFoods;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\db\RefFoods */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ref Foods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="ref-foods-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
					<?= Html::img($model->getUploadedFileUrl($model::ATTR_IMG),
						['width' => '100%', 'class' => 'img-thumbnail']) ?>
                    <div id="controls" class="mt-1">

						<?= Html::a('Редактировать', ['update', 'id' => $model->id], [
							'class' => 'btn btn-block btn-sm btn-primary'
						]) ?>

						<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
							'class' => 'btn btn-block btn-sm btn-danger mt-1',
							'data'  => [
								'method'  => 'post',
								'confirm' => 'Вы действительно хотите удалить эту аудиосказку?'
							]
						]) ?>
                    </div>
                </div>
                <div class="col-md-8">
					<?= DetailView::widget([
						'model'      => $model,
						'attributes' => [
							'id',
							'name',
							'price',
							'old_price',
							'description:ntext',
							[
								'label' => 'Категория',
								'value' => function (RefFoods $model) {
									return $model->category->name;
								},
							],
							[
								'attribute' => $model::ATTR_STATUS,
								'label'     => $model->getAttributeLabel($model::ATTR_STATUS),
								'value'     => function (RefFoods $model) {
									return $model::getStatusVariants()[$model->status];
								},
							],
							'created_at',
							'updated_at',
							'deleted_at',
						],
					]) ?>
                </div>
            </div>
        </div>
    </div>


</div>
