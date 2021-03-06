<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_shop_basket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 * @property int $count
 *
 * @property ShopItems $item
 */
class ShopBasket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_basket}}';
    }

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
        $this->count = 1;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_id'], 'required'],
            [['user_id', 'item_id', 'count'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopItems::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'item_id' => Yii::t('common', 'Item ID'),
            'count' => Yii::t('common', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationItem()
    {
        return $this->hasOne(ShopItems::className(), ['id' => 'item_id']);
    }
    
    public function search($params) {
        $query = ShopBasket::find()->where(['user_id' => Yii::$app->user->getId()])->with(['shopItem']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort'=> [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);
        return $dataProvider;
    }
    
}
