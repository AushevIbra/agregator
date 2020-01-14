<?php

namespace backend\controllers;

use backend\models\food\FoodForm;
use Yii;
use common\models\db\RefFoods;
use backend\models\search\FoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FoodController implements the CRUD actions for RefFoods model.
 */
class FoodController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all RefFoods models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel  = new FoodsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$this->view->title = 'Меню ресторана';

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single RefFoods model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new RefFoods model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RefFoods();
		$form  = new FoodForm($model);
		if ($form->load(Yii::$app->request->post()) && $form->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		$this->view->title = 'Добавить блюдо';

		return $this->render('create', [
			'form' => $form,
		]);
	}

	/**
	 * Updates an existing RefFoods model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$form  = new FoodForm($model);

		if ($form->load(Yii::$app->request->post()) && $form->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		$this->view->title = 'Редактировать блюдо';

		return $this->render('update', [
			'form' => $form,
		]);
	}

	/**
	 * Deletes an existing RefFoods model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the RefFoods model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return RefFoods the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = RefFoods::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
