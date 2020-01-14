<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\db\RefFoodCategories;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FoodCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="ref-food-categories-index card">

    <div class="card-header white-text primary-color">
        <div class="d-flex justify-content-between align-items-center">
            <h3><?= Html::encode($this->title) ?></h3>
			<?= Html::a('Добавить категорию', ['create'],
				['class' => 'btn btn-primary white-text primary-color']) ?>
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
				//				'icon',
				//				'img',
				[
					'attribute' => $searchModel::ATTR_STATUS,
					'label'     => $searchModel->getAttributeLabel($searchModel::ATTR_STATUS),
					'value'     => function (RefFoodCategories $model) {
						return $model::getStatusVariants()[$model->status];
					},
					'filter'    => RefFoodCategories::getStatusVariants(),
				],
				//'ref_restaurant_id',
				//'created_at',
				//'updated_at',
				//'deleted_at',

				['class' => \common\yii\base\ActionColumn::class],
			],
		]); ?>
    </div>


</div>
