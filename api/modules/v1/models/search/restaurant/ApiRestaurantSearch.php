<?php


namespace app\modules\v1\models\search\restaurant;


use app\modules\v1\models\pagination\Pagination;
use app\modules\v1\models\pagination\Result;
use app\modules\v1\models\search\restaurant\models\ApiRestaurantItem;
use app\modules\v1\models\views\foodCategory\FoodCategoryItem;
use common\models\db\RefRestaurant;
use yii\base\Model;
use yii\validators\NumberValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

class ApiRestaurantSearch extends Model
{

	/**
	 * @var string
	 */
	public $name = '';
	const ATTR_NAME = 'name';

	/**
	 * @var int
	 */
	public $categoryId;
	const ATTR_CATEGORY_ID = 'categoryId';

	/**
	 * @var int
	 */
	public $page;
	const ATTR_PAGE = 'page';

	public function rules()
	{
		return [
			[static::ATTR_NAME, StringValidator::class],
			[static::ATTR_CATEGORY_ID, SafeValidator::class],
			[static::ATTR_PAGE, NumberValidator::class],
		];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return string
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function formName()
	{
		return '';
	}

	public function search(array $params = [])
	{
		$this->load($params);

		$query = RefRestaurant::find();

//		$query->andFilterWhere(
//			['=', static::ATTR_CATEGORY_ID, $this->categoryId]
//		);

		if (null !== $this->categoryId) {
			$query->joinRestaurantCategories(['id' => $this->categoryId]);
		}

		$result = new Result;

		if (false === $this->validate()) {
			return $result;
		}
		// -- Инициализируем пагинацию
		$result->pagination               = new Pagination;
		$result->pagination->count        = (int)$query->count();
		$result->pagination->page         = $this->page;
		$result->pagination->pageSize     = 10;
		$result->pagination->pages        = intval(ceil($result->pagination->count / $result->pagination->pageSize));
		$result->pagination->prevPage     = null;
		$result->pagination->nextPage     = null;
		$result->pagination->prevPageLink = null;
		$result->pagination->nextPageLink = null;
		if ($result->pagination->page > 1) {
			$result->pagination->prevPage     = $result->pagination->page - 1;
			$queryParams['page']              = $result->pagination->prevPage;
			$result->pagination->prevPageLink = http_build_query($queryParams);
		}
		if ($result->pagination->page < $result->pagination->pages) {
			$result->pagination->nextPage     = $result->pagination->page + 1;
			$queryParams['page']              = $result->pagination->nextPage;
			$result->pagination->nextPageLink = http_build_query($queryParams);
		}
		if ($result->pagination->pages >= $result->pagination->page && $result->pagination->page > 1) {
			$offset = $result->pagination->pageSize * ($result->pagination->page - 1);
		}


		$query
			->offset($offset ?? 0)
			->limit($result->pagination->pageSize);
		// -- -- -- --

		// -- Получаем данные
		$rows = $query->all();

		foreach ($rows as $row) {
			$item                  = new  ApiRestaurantItem;
			$item->id              = $row->id;
			$item->name            = $row->name;
			$item->description     = $row->description;
			$item->img             = $row->getUploadedFileUrl(RefRestaurant::ATTR_IMG);
			$item->min_amount      = $row->min_amount;
			$item->minDeliveryTime = $row->min_delivery_time;
			$item->maxDeliveryTime = $row->max_delivery_time;
			$item->slug            = $row->slug;

			$categories = $row->restaurantCategories;

			foreach ($categories as $category) {
				$categoryItem       = new FoodCategoryItem;
				$categoryItem->name = $category->name;
				$categoryItem->id   = $category->id;
				$item->categories[] = $categoryItem;
			}

			$result->items[] = $item;
		}

		return $result;

	}
}