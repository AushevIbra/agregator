<?php

use common\models\db\RefFoods;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="ref-foods-index">
    <div class="card">
        <div class="card-header  white-text primary-color">
            <div class="d-flex justify-content-between align-items-center">
                <h3><?= Html::encode($this->title) ?></h3>

                <p>
					<?= Html::a('Добавить блюдо', ['create'],
						['class' => 'btn btn-primary  white-text primary-color']) ?>
                </p>
            </div>

        </div>

        <div class="card-body">
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel'  => $searchModel,
				'columns'      => [
					['class' => 'yii\grid\SerialColumn'],

					'id',
					'name',
					//					'img',
					//'description:ntext',
					//'ref_food_category_id',
					//'ref_restaurant_id',
					[
						'attribute' => $searchModel::ATTR_STATUS,
						'label'     => $searchModel->getAttributeLabel($searchModel::ATTR_STATUS),
						'value'     => function (RefFoods $model) {
							return $model::getStatusVariants()[$model->status];
						},
						'filter'    => RefFoods::getStatusVariants(),
					],
					//'created_at',
					//'updated_at',
					//'deleted_at',

					['class' => \common\yii\base\ActionColumn::class],
				],
			]); ?>
        </div>
    </div>


</div>
