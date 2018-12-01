<?php
namespace app\commands;

/**
 * Description of RbacController
 *
 * @author herbert
 */

use yii\console\Controller;

class RbacController 
	extends Controller
{
	public function actionInit()
	{
		if (!$this->confirm("Are you sure? It will re-create permissions tree.")) 
		{
			return self::EXIT_CODE_NORMAL;
		}

		$auth = Yii::$app->authManager;
		$auth->removeAll();

		$manageArticles = $auth->createPermission('manageArticles');
		$manageArticles->description = 'Manage articles';
		$auth->add($manageArticles);

		$manageUsers = $auth->createPermission('manageUsers');
		$manageUsers->description = 'Manage users';
		$auth->add($manageUsers);

		$moderator = $auth->createRole('moderator');
		$moderator->description = 'Moderator';
		$auth->add($moderator);
		$auth->addChild($moderator, $manageArticles);

		$admin = $auth->createRole('admin');
		$admin->description = 'Administrator';
		$auth->add($admin);
		$auth->addChild($admin, $moderator);
		$auth->addChild($admin, $manageUsers);
	}
}
