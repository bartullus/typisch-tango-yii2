<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property string $event_website
 * @property integer $parent_id
 * @property integer $category_id
 * @property integer $event_valid
 * @property integer $visible
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property integer $terms
 * @property string $terms_details
 * @property string $price
 * @property integer $max_number
 * @property integer $location_id
 * @property string $location_city
 * @property string $location_address
 * @property string $location_name
 * @property integer $organisator_id
 * @property string $organisator_name
 * @property string $organisator_website
 * @property string $organisator_email
 * @property string $organisator_telephone
 * @property integer $album_id
 * @property string $submitter_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventCategory $category
 * @property CalLocation $location
 * @property CalLocation $organisator
 * @property CalendarEvent $parent
 * @property CalendarEvent[] $calendarEvents
 * @property CalEventOffer[] $calEventOffers
 * @property CalEventSingledate[] $calEventSingledates
 */
class CalendarEvent extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'start_date', 'location_city'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'category_id', 'event_valid', 'visible', 'terms', 'max_number', 'location_id', 'organisator_id', 'album_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['start_date', 'end_date', 'start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['title', 'url', 'event_website', 'terms_details', 'price', 'location_city', 'location_address', 'location_name', 'organisator_name', 'organisator_website', 'organisator_email', 'organisator_telephone', 'submitter_id'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalLocation::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['organisator_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalLocation::className(), 'targetAttribute' => ['organisator_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarEvent::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event', 'ID'),
            'title' => Yii::t('cal_event', 'Title'),
            'url' => Yii::t('cal_event', 'Url'),
            'description' => Yii::t('cal_event', 'Description'),
            'event_website' => Yii::t('cal_event', 'Event Website'),
            'parent_id' => Yii::t('cal_event', 'Parent'),
            'category_id' => Yii::t('cal_event', 'Category'),
            'event_valid' => Yii::t('cal_event', 'Event Valid'),
            'visible' => Yii::t('cal_event', 'Visible'),
            'start_date' => Yii::t('cal_event', 'Start Date'),
            'end_date' => Yii::t('cal_event', 'End Date'),
            'start_time' => Yii::t('cal_event', 'Start Time'),
            'end_time' => Yii::t('cal_event', 'End Time'),
            'terms' => Yii::t('cal_event', 'Terms'),
            'terms_details' => Yii::t('cal_event', 'Terms Details'),
            'price' => Yii::t('cal_event', 'Price'),
            'max_number' => Yii::t('cal_event', 'Max Number'),
            'location_id' => Yii::t('cal_event', 'Location'),
            'location_city' => Yii::t('cal_event', 'Location City'),
            'location_address' => Yii::t('cal_event', 'Location Address'),
            'location_name' => Yii::t('cal_event', 'Location Name'),
            'organisator_id' => Yii::t('cal_event', 'Organisator'),
            'organisator_name' => Yii::t('cal_event', 'Organisator Name'),
            'organisator_website' => Yii::t('cal_event', 'Organisator Website'),
            'organisator_email' => Yii::t('cal_event', 'Organisator Email'),
            'organisator_telephone' => Yii::t('cal_event', 'Organisator Telephone'),
            'album_id' => Yii::t('cal_event', 'Album'),
            'submitter_id' => Yii::t('cal_event', 'Submitter'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CalEventCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(CalLocation::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisator()
    {
        return $this->hasOne(CalLocation::className(), ['id' => 'organisator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CalendarEvent::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarEvents()
    {
        return $this->hasMany(CalendarEvent::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventOffers()
    {
        return $this->hasMany(CalEventOffer::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventSingledates()
    {
        return $this->hasMany(CalEventSingledate::className(), ['event_id' => 'id']);
    }
		
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(\app\models\BaseUser::className(), ['id' => 'create_user_id']);
    }
		
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(\app\models\BaseUser::className(), ['id' => 'update_user_id']);
    }

	public function attributeValue($attr_name, $attr_params = array()) {
		
		switch($attr_name) {

			case 'name':
				return $this->title;
			
			case 'parent_id':
				$parent = $this->ParentEvent;
				if (isset($parent)) {
					return $this->_getValueRoute($parent->title, $attr_params, $parent->id, $parent->getUrl());
				} else {
					return null;
				}
				
			case 'title_description':
				return $this->_getTitleDescription($attr_params);
				
			case 'location_full':
				return $this->_getLocationFull($attr_params);
							
			case 'location_id':
				$loc = $this->Location;
				if (isset($loc)) {
					return $this->_getValueRoute($loc->loc_name, $attr_params, $loc->id, $loc->getUrl());
				} else {
					return $this->location_name;
				}
				
			case 'location_city':
				$city_name = $this->location_city;
				$attr = array('name' => $city_name);
				$city = MapCity::model()->findByAttributes($attr);
				if (isset($city)) {
					return $this->_getValueRoute($city->name, $attr_params, $city->id, $city->getUrl());
				} else {
					return $city_name;
				}

			case 'location_region':
				$loc = $this->Location;
				if (!isset($loc)) {
					return null;
				}
				$city = $loc->City;
				if (!isset($city)) {
					return null;
				}
				$region = $city->Region;
				if (!isset($region)) {
					return null;
				}
				return $this->_getValueRoute($region->name, $attr_params, $region->id, $region->getUrl());
				
			case 'location_postcode':
				$loc = $this->Location;
				if (isset($loc)) {
					return $loc->postcode;
				}
				return null;
				
			case 'organisator_id':
				$org = $this->Organisator;
				if (isset($org)) {
					return $this->_getValueRoute($org->name, $attr_params, $org->id, $org->getUrl());
				} else {
					return $this->organisator_name;
				}
							
			case 'category_id':
				$cat = $this->Category;
				if (isset($cat)) {
					return $cat->name;
				} else {
					return '[keine Kategorie]';
				}
				
			case 'album_id':
				$album = $this->Album;
				if (isset($album)) {
					return $this->_getValueRoute($album->name, $attr_params, $album->id, $album->getUrl());
				}
				return null;				
				
			case 'date':	
				$txt = $this->getTermsText();
				if (strlen($txt)) {
					$txt.= CHtml::tag('br');
				}
				$start_date = strftime($this->dateformat, strtotime($this->start_date));
				$start_route = array($attr_params['viewRoute'], 'day' => $this->start_date);
				$txt.= CHtml::tag('b', array(), CHtml::link(CHtml::encode($start_date), $start_route));
				if (isset($this->end_date)) {
					$end_date = strftime($this->dateformat, strtotime($this->end_date));
					$end_route = array($attr_params['viewRoute'], 'day' => $this->end_date);
					$txt.= ' - '.CHtml::link(CHtml::encode($end_date), $end_route);
				}
				$txt.= CHtml::tag('br').' ('.$this->dayDiffString($attr_params['today']).')';
				
				return $txt;

			case 'start_date':	
				$start_date = strftime($this->dateformat, strtotime($this->start_date));
				if (array_key_exists('viewRoute', $attr_params)) {
					$start_route = array($attr_params['viewRoute'], 'day' => $this->start_date);
					$start_date = CHtml::link($start_date, $start_route);
				}
				return CHtml::tag('b', array(), $start_date);
				
			case 'time':
				$txt = '';
				if (isset($this->start_time)) {
					$txt.= CHtml::encode(strftime($this->timeformat, strtotime($this->start_time)));
				}
				if (isset($this->end_time)) {
					$txt.= ' - '.CHtml::encode(strftime($this->timeformat, strtotime($this->end_time)));
				}
				if (strlen($txt)) {
					return $txt;
				} else {
					return null;
				}
				
			case 'visible': 
				if ($this->visible == 1) { return 'Ja'; }
				else { return 'NEIN'; }
		
			case 'description':
				return $this->description;				
				
			case 'prices':
				$offers = array();
				foreach ($this->Offers as $offer) {
					$offers[] = $offer->priceInfo();
				}
				if (count($offers) > 0) {
					$price_txt = implode(' | ', $offers);
					if (isset($this->price) && (strlen($this->price) > 0)) {
						$price_txt.= ' | '.$this->price;
					}
				} else {
					$price_txt = $this->price;
				}
				return $price_txt;
								
			case 'bookings':
				$cntBookings = $this->cntBookedItems;
				$cntLeadBookings = $this->cntLeadBookedItems;
				$cntFollowBookings = $this->cntFollowBookedItems;
		
				$list = array();
				if (($cntBookings > 0) && ($cntLeadBookings == 0) && ($cntFollowBookings == 0)) {
					$txt = $cntBookings." gesamt";
					$attr = array('style' => $this->_getBookingStyle($cntBookings, $this->max_number));
					$list[] = Html::tag('span', $txt, $attr);
				}

				if ($cntLeadBookings > 0) {
					$txt = $cntLeadBookings." FÃ¼hrende";
					$attr = array('style' => $this->_getBookingStyle($cntLeadBookings, $this->max_number));
					$list[] = Html::tag('span', $txt, $attr);
				}
		
				if ($cntFollowBookings > 0) {
					$txt = $cntFollowBookings." Folgende";
					$attr = array('style' => $this->_getBookingStyle($cntFollowBookings, $this->max_number));
					$list[] = Html::tag('span', $txt, $attr);
				}		
		
				return implode(", ", $list);
				
			default: return parent::attributeValue($attr_name, $attr_params);
		}
	}

	public function getTermsText() {
		
		if (!isset($this->Terms)) {
			return '';
		}
		
		$txt = CHtml::encode($this->Terms->name).' ';
		if (isset($this->terms_details) && (strlen($this->terms_details) > 0)) {
			
			$oddeven = $this->terms_details[0];
			switch ($oddeven) {
				case 'o': $txt.= ' nur ungerade KW '; break;
				case 'e': $txt.= ' nur gerade KW '; break;
			}
			
			$terms_wnumbers = array();
			for($i = 1; $i <= 5; $i++) {
				
				$is = ''.$i;
				if (strpos($this->terms_details, $is) !== false) {
					$terms_wnumbers[] = $is;
				}
			}
			
			if ((count($terms_wnumbers) > 0) && (count($terms_wnumbers) < 5)) {
				// if not every week
				$txt.= ' am ';
				foreach ($terms_wnumbers as $num) {
					$txt.= ''.$num.'. ';
				}
				$txt.= 'im Monat ';
			}
		} 
		
		return $txt;
	}

}
