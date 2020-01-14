<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="user-index card">

    <div class="card-header white-text primary-color">
        <div class="d-flex justify-content-between align-items-center">
            <h3><?= Html::encode($this->title) ?></h3>

            <p>
				<?= Html::a('Добавить сотрудника', ['create'],
					['class' => 'btn btn-primary white-text primary-color']) ?>
            </p>
        </div>
    </div>


	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card-body">

		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'columns'      => [
				['class' => 'yii\grid\SerialColumn'],

				'id',
				'username',
				'email:email',
				[
					'attribute' => $searchModel::ATTR_STATUS,
					'label'     => $searchModel->getAttributeLabel($searchModel::ATTR_STATUS),
					'value'     => function (User $model) {
						return $model::getStatusVariants()[$model->status];
					},
					'filter'    => User::getStatusVariants(),
				],
				//'created_at',
				//'updated_at',
				//'verification_token',

				['class' => \common\yii\base\ActionColumn::class, 'template' => '{view} {delete}',],

			],


		]); ?>

    </div>

</div>
