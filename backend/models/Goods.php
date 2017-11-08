<?php
namespace backend\models;

use yii\db\ActiveRecord;

class  Goods extends ActiveRecord{
    Public $imgfile=1;
    public function rules()
    {
        return [
            [['name','logo','goods_category_id',
                'brand_id','market_price','shop_price'
                ,'stock','is_on_sale','logo','status','sort'],'required'],
            ['imgfile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>false,],
            [['sort', 'status'], 'integer'],
            [['market_price',"shop_price"], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }
    public static function getZtreeNodes(){
       return  Goods_category::find()->select(['id','parent_id','name'])->asArray()->all();

    }
}
