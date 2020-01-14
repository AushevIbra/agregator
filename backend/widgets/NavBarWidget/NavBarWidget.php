<?php


namespace backend\widgets\NavBarWidget;


use yii\base\Widget;

class NavBarWidget extends Widget
{
	/**
	 * @var array
	 */
	public $items;

	public function run()
	{
		return $this->render('index', ['items' => $this->items]);
	}
}