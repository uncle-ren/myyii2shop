<?php
namespace  backend\models;


use yii\db\ActiveRecord;

class Article_detail extends  ActiveRecord{

    public function rules()
    {
        return [
            ["content", 'required'],

        ];
    }

}