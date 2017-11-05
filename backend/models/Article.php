<?php
namespace  backend\models;


use yii\db\ActiveRecord;

class Article extends  ActiveRecord{


    public function rules()
    {
        return [
            [['name', 'intro',"category_id","status"], 'required'],

            ["soft","safe"],
        ];
    }



}
