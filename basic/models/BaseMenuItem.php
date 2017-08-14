<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%base_menu_item}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $menu_id
 * @property integer $parent_id
 * @property string $icon
 * @property string $description
 * @property string $website
 * @property string $params
 * @property string $subitems_controller
 * @property string $css_class
 * @property integer $order
 * @property integer $restricted
 * @property integer $visible
 * @property string $change_freq
 * @property integer $in_sitemap
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BaseMenu $menu
 */
class BaseMenuItem extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_menu_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'menu_id', 'parent_id', 'create_time'], 'required'],
            [['menu_id', 'parent_id', 'order', 'restricted', 'visible', 'in_sitemap', 'create_user_id', 'update_user_id'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'website', 'params', 'subitems_controller', 'css_class'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 64],
            [['change_freq'], 'string', 'max' => 16],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseMenu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'name' => Yii::t('menu', 'Name'),
            'menu_id' => Yii::t('menu', 'Menu ID'),
            'parent_id' => Yii::t('menu', 'Parent ID'),
            'icon' => Yii::t('menu', 'Icon'),
            'description' => Yii::t('menu', 'Description'),
            'website' => Yii::t('menu', 'Website'),
            'params' => Yii::t('menu', 'Params'),
            'subitems_controller' => Yii::t('menu', 'Subitems Controller'),
            'css_class' => Yii::t('menu', 'Css Class'),
            'order' => Yii::t('menu', 'Order'),
            'restricted' => Yii::t('menu', 'Restricted'),
            'visible' => Yii::t('menu', 'Visible'),
            'change_freq' => Yii::t('menu', 'Change Freq'),
            'in_sitemap' => Yii::t('menu', 'In Sitemap'),
            'create_time' => Yii::t('menu', 'Create Time'),
            'create_user_id' => Yii::t('menu', 'Create User ID'),
            'update_time' => Yii::t('menu', 'Update Time'),
            'update_user_id' => Yii::t('menu', 'Update User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(BaseMenu::className(), ['id' => 'menu_id']);
    }
}
