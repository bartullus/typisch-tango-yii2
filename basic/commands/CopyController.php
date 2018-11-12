<?php
namespace app\commands;
/**
 * Copies data from old application with Yii 1 to new Yii 2 app
 *
 *
 * @author Herbert
 * @since 2.0
 */

use yii\console\Controller;

class CopyController 
	extends Controller
{
	var $db_old;
	var $dsn = 'mysql:host=localhost;dbname=typisch_tango_yii';
	var $username = 'root';
	var $password = 'asdfcv';
	var $charset = 'utf8';
	
	/**
	 * copies all objects
   */
  public function actionIndex()
	{
		$this->db_old = $this->openConnection();
		$this->copyTables();
		$this->db_old->close ();
  }
	
	/**
	 * open connection to old database
   */
	private function openConnection() {
					
		$db = new \yii\db\Connection([
			'dsn' => $this->dsn,
			'username' => $this->username,
			'password' => $this->password,
			'charset' => $this->charset,
		]);
		$db->open();		
		return $db;
	}
	
	/**
	 * copies the menus
   */
	protected function copyTables() 
	{

		$this->copyTable(
			'tt_user_group', 
			'\app\models\BaseUserGroup',
			[
				'id', 'name', 'description',
			]
		);

		$this->copyTable(
			'tt_user', 
			'\app\models\BaseUser',
			[
				'id', 'active', 'email', 
				'username', 'password', 'last_login_time',
			]
		);

		$this->copyTable(
			'tt_menu', 
			'\app\models\BaseMenu',
			[
				'id', 'name', 'restricted', 'description',
			]
		);
		
		$this->copyTable(
			'tt_menu_item', 
			'\app\models\BaseMenuItem',
			[
				'id', 'name', 'menu_id', 'parent_id',
				'icon', 'description', 'website', 'params',
				'subitems_controller', 'css_class', 'order', 'restricted',
				'visible', 'change_freq', 'in_sitemap',
			]
		);
	
		$this->copyTable(
			'tt_article_status', 
			'\app\modules\blog\models\BlogArticleStatus',
			[
				'id', 
				'name', 
				'description',
			]
		);
		
		$this->copyTable(
			'tt_article_category', 
			'\app\modules\blog\models\BlogArticleCategory',
			[
				'id', 
				'name', 
				'description',
			]
		);
		
		$this->copyTable(
			'tt_article_keyword', 
			'\app\modules\blog\models\BlogArticleKeyword',
			[
				'id', 
				'name', 
				//'description',
			]
		);
		
		$this->copyTable(
			'tt_article', 
			'\app\modules\blog\models\BlogArticle',
			[
				'id', 'pub_date', 'category_id', 'status_id',
				'title', 'url', 'content', 'description',
			]
		);
		
		$this->copyTable(
			'tt_article_keyword_rel', 
			'\app\modules\blog\models\BlogArticleKeywordRel',
			[
				'article_id', 'keyword_id',
			]
		);

		$this->copyTable(
			'tt_newsletter', 
			'\app\modules\blog\models\BlogReceiver',
			[
				'id', 'name', 'prename', 'email',
				'info', 'member', 'valid', 'birthdate',
			]
		);
		
		$this->copyTable(
			'tt_newsletter_send', 
			'\app\modules\blog\models\BlogReceiverArticle',
			[
				'id', 
				'newsletter_id' => 'receiver_id', 
				'article_id', 
				'result',
			],
			[ 'receiver_id', 'article_id' ]
		);
		
		$this->copyTable(
			'tt_newsletter_code', 
			'\app\modules\blog\models\BlogReceiverCode',
			[
				'id', 'code', 'name', 'prename', 'email', 'verified', 'ip_addr',
			]
		);
		
		$this->copyTable(
			'tt_newsletter_blacklist', 
			'\app\modules\blog\models\BlogReceiverBlacklist',
			[
				'id', 'email', 'description',
			]
		);
		
		$this->copyTable(
			'tt_map_state', 
			'\app\modules\map\models\MapState',
			[
					'id', 'shortcut', 'name', 'url',
					'latitude', 'longitude', 'mapZoomLevel',
			]
		);

		$this->copyTable(
			'tt_map_region', 
			'\app\modules\map\models\MapRegion',
			[
					'id', 'state_id', 'shortcut', 'name', 'url',
					'latitude', 'longitude', 'mapZoomLevel',
			]
		);

		$this->copyTable(
			'tt_map_city', 
			'\app\modules\map\models\MapCity',
			[
					'id', 'region_id', 'shortcut', 'name', 'url',
					'latitude', 'longitude', 'mapZoomLevel',
			]
		);

		$this->copyTable(
			'tt_calendar_category', 
			'\app\modules\cal\models\CalendarEventCategory',
			[
					'id', 'name', 'plural', 
					'shortname', 'shema_type', 'description',
					
					'importance', 'is_class',
					'can_be_parent', 'user_group_id',
			]
		);
		
		$this->copyTable(
			'tt_calendar_event_offer_category', 
			'\app\modules\cal\models\CalendarEventOfferCategory',
			[
					'id', 'name', 'plural', 
					'shortname', 'shema_type', 'description',
					
					'importance', 'is_class',
					'can_be_parent', 'user_group_id',
			]
		);
		
		$this->copyTable(
			'tt_calendar_event_offer_discounted', 
			'\app\modules\cal\models\CalendarEventOfferDiscounted',
			[
					'id', 'short', 'name', 
					'description', 'foruser', 
			]
		);
		
		$this->copyTable(
			'tt_calendar_specialdays_type', 
			'\app\modules\cal\models\CalendarSpecialdayType',
			[
				'id', 'name', 'description',
			]
		);
		
		$this->copyTable(
			'tt_calendar_specialdays', 
			'\app\modules\cal\models\CalendarSpecialday',
			[
				'id', 'name', 'free',
				'type_id', 
				'month', 'day', 'relative'
			]
		);
				
		$this->copyTable(
			'tt_calendar_location', 
			'\app\modules\cal\models\CalendarLocatoin',
			[
					'id', 'name', 'loc_name', 'url', 'description',
					'location_valid', 'is_loc', 'is_org', 'person', 
					'email', 'website', 'telephone',
					'city_id', 'city', 'district',
					'postcode', 'address', 
					'colour', 
					'latitude', 'longitude', 'mapZoomLevel',
					'album_id',
			]
		);
		
		$this->copyTable(
			'tt_calendar_event', 
			'\app\modules\cal\models\CalendarEvent',
			[
					'id', 'title', 'url', 
					'description', 'event_website', 
					'parent_id', 'category_id', 
					'event_valid', 'visible',
					'start_date', 'end_date', 
					'start_time', 'end_time',
					'terms', 'terms_details',
					'price', 'max_number',
					'location_id', 'location_city', 
					'location_address', 'location_name',
					'organisator_name', 'organisator_website', 
					'organsiator_email', 'organisator_website', 
					'album_id', 'submitter_id',
			]
		);
		
		$this->copyTable(
			'tt_calendar_event_singledate', 
			'\app\modules\cal\models\CalendarEventSingledate',
			[
					'id',
					'event_id',
					'no', 'date', 'timestamp',
					'start_time', 'end_time',
					'active', 'manual',
			]
		);
		
		$this->copyTable(
			'tt_calendar_event_offer', 
			'\app\modules\cal\models\CalendarEventOffer',
			[
					'id', 'name', 'amount', 
					'event_id', 'category_id', 'discounted_id', 
			]
		);
		
	}
		
	private function copyTable(
					$oldTableName, 
					$newClassName, 
					$fieldNames,
					$checkDuplicateFields = null)
	{
		echo "Start Copy $oldTableName\r\n";
		
		$command = $this->db_old->createCommand("SELECT * FROM $oldTableName");
		$oldRecords = $command->queryAll();
		$oldCnt = count($oldRecords);
		echo "\tCopy: $oldCnt\r\n";
		//echo print_r($oldMenus, true);
		
		$newClass = new \ReflectionClass($newClassName);
		$deleteAllMethod = $newClass->getMethod('deleteAll');
		$deleteAllMethod->invoke(null);		
		
		foreach($oldRecords as $oldRec) {
			
			$newRec = $newClass->newInstance();
			$newRecT = $this->copyFields($newRec, $oldRec, $fieldNames);
			if (!$this->checkDuplicates($checkDuplicateFields, $newRec, $newClass)) {
				continue;
			}	
			$newRecT->save(false);		
		}
		
		$findMethod = $newClass->getMethod('find');
		$cnt = $findMethod->invoke(null)->count();
		echo "\tCopied: $cnt/$oldCnt\r\n";
		
		echo "End Copy $oldTableName\r\n";
	}
	
	private function copyFields($newRec, $oldRec, $fieldNames) {
		
		foreach ($fieldNames as $oldName => $newName) {
			if(array_key_exists($oldName, $oldRec)) {
				$value = $oldRec[$oldName];
			} elseif (array_key_exists($newName, $oldRec)) {
				$value = $oldRec[$newName];
			} else {
				echo "ERROR missing field $oldName/$newName in old record!";
				continue;
			}
			
			if ($newRec->hasAttribute($newName)) {
				$newRec->$newName = $value;
			} else {
				echo "ERROR missing field $newName in new record!\r\n";
			}
		}
	
		return $this->copyTimestamp($newRec, $oldRec);		
	}
	
	private function checkDuplicates($fieldNames, $newRec, $newClass) {
	
		if (!isset($fieldNames)) {
			return true;
		}
			
		$findParams = [];
		$findParamsStr = "";
		foreach($fieldNames as $fldName) {
			$value = $newRec->$fldName;
			$findParams[$fldName] = $value;
			$findParamsStr.= "$fldName=$value, ";
		}

		$findAllMethod = $newClass->getMethod('findAll');
		$otherRecs = $findAllMethod->invoke($newRec, $findParams);
		if (count($otherRecs) > 0) {
			echo "WARNING other records found cnt: ".count($otherRecs)." $findParamsStr\r\n";
			return false;
		}
		return true;
	}
	
	private function copyTimestamp($newRec, $oldRec) {
		
		$timestampFields = [
				'create_time',
				'create_user_id',
				'update_time',
				'update_user_id',
		];
		
		foreach($timestampFields as $fldName) {
			if ($newRec->hasAttribute($fldName)) {
				$newRec->$fldName = $oldRec[$fldName];
			}
		}
		return $newRec;
	}
}
