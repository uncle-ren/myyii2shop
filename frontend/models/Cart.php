<?php
namespace frontend\models;


use yii\db\ActiveRecord;

class Cart  extends ActiveRecord{

public function rules()
{
    return [
        [["amount","goods_id"],"required"],
        ["member_id","safe"],
    ];
}

}
