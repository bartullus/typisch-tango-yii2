<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event_singledate}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $no
 * @property string $date
 * @property integer $timestamp
 * @property string $start_time
 * @property string $end_time
 * @property integer $active
 * @property integer $manual
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEvent $event
 */
class CalendarEventSingledate extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event_singledate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'no', 'date', 'timestamp'], 'required'],
            [['event_id', 'no', 'timestamp', 'active', 'manual', 'create_user_id', 'update_user_id'], 'integer'],
            [['date', 'start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event_singledate', 'ID'),
            'event_id' => Yii::t('cal_event_singledate', 'Event'),
            'no' => Yii::t('cal_event_singledate', 'No'),
            'date' => Yii::t('cal_event_singledate', 'Date'),
            'timestamp' => Yii::t('cal_event_singledate', 'Timestamp'),
            'start_time' => Yii::t('cal_event_singledate', 'Start Time'),
            'end_time' => Yii::t('cal_event_singledate', 'End Time'),
            'active' => Yii::t('cal_event_singledate', 'Active'),
            'manual' => Yii::t('cal_event_singledate', 'Manual'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(CalEvent::className(), ['id' => 'event_id']);
    }
}
