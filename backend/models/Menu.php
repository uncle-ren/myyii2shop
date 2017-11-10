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
}
