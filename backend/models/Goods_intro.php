<?php
namespace backend\models;


use yii\db\ActiveRecord;

class Goods_intro extends  ActiveRecord{

    public function rules()
    {
        return [
            ["content","safe"]
        ];
    }

    public function attributeLabels()
    {
    return [


        'content' => '详细内容',
    ];
}
}