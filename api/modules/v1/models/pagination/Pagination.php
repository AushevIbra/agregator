<?php


namespace app\modules\v1\models\pagination;

/**
 * Class Pagination
 *
 * @author Aushev Ibra <aushevibra@yandex.ru>
 */
class Pagination
{
	/** @var int Всего найдено. */
	public $count;

	/** @var int Текущая страница. */
	public $page;

	/** @var int Размер страницы. */
	public $pageSize;

	/** @var int Общее количество страниц. */
	public $pages;

	/** @var int следующая страница. */
	public $nextPage;

	/** @var int предыдущая страница. */
	public $prevPage;

	/** @var string Ссылка на следующую страницу. */
	public $nextPageLink;

	/** @var string Ссылка на предыдущую страницу. */
	public $prevPageLink;
}