<?php

namespace backend\controllers;

use backend\models\foodCategory\FoodCategoryForm;
use common\models\User;
use Yii;
use common\models\db\RefFoodCategories;
use backend\models\search\FoodCategoriesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FoodCategoryController implements the CRUD actions for RefFoodCategories model.
 */
class FoodCategoryController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs'  => [
				'class'   => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
				],
			],
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow'         => true,
						'matchCallback' => function ($rule, $action) {
							return Yii::$app->user->can(User::PERMISSION_CATEGORY);
						}
					],
				],
			],
		];
	}

	/**
	 * Lists all RefFoodCategories models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel  = new FoodCategoriesSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$this->view->title = "Категории";

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single RefFoodCategories model.
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
	 * Creates a new RefFoodCategories model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RefFoodCategories();
		$form  = new FoodCategoryForm($model);
		if ($form->load(Yii::$app->request->post()) && $form->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'form' => $form,
		]);
	}

	/**
	 * Updates an existing RefFoodCategories model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$form  = new FoodCategoryForm($model);
		if ($form->load(Yii::$app->request->post()) && $form->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'form' => $form,
		]);
	}

	/**
	 * Deletes an existing RefFoodCategories model.
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
	 * Finds the RefFoodCategories model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return RefFoodCategories the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = RefFoodCategories::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
