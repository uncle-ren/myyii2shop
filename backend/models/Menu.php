<?php
namespace  backend\models;


use yii\db\ActiveRecord;

class  Menu extends ActiveRecord{



    public function rules()
    {
        return [
            [["name","premenu","adress","sort"],"required"],

        ];
    }
    Public function getChildren(){
        //get方法
        return $this->hasMany(self::className(),["premenu"=>"id"]);
    }
}
