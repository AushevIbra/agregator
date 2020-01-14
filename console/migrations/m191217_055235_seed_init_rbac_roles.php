<?php

use yii\db\Migration;

/**
 * Class m191217_055235_seed_init_rbac_roles
 */
class m191217_055235_seed_init_rbac_roles extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$auth = Yii::$app->authManager;

		$admin     = $auth->createRole('admin');
		$moderator = $auth->createRole('moderator');
		$courier   = $auth->createRole('courier');

		$auth->add($admin);
		$auth->add($moderator);
		$auth->add($courier);

		// Права модератора

		// ====== Категории
		$createCategory              = $auth->createPermission('category');
		$createCategory->description = "Работа с категориями";
		$auth->add($createCategory);


		// ===== Блюда
		$foodPermission              = $auth->createPermission("food");
		$foodPermission->description = "Работа с блюдами";
		$auth->add($foodPermission);

		// ====== Ресторан
		$restaurantPermission              = $auth->createPermission('restaurant');
		$restaurantPermission->description = "Работа с рестораном";
		$auth->add($restaurantPermission);

		// Привязка ролей

		$auth->addChild($moderator, $createCategory);
		$auth->addChild($moderator, $foodPermission);
		$auth->addChild($admin, $moderator);


	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->delete('auth_item', ['name' => ['category', 'food', 'restaurant']]);
		$this->delete('auth_rule', ['name' => ['admin', 'moderator', 'courier']]);

	}

}
