<?php

namespace backend\models;


use yii\db\ActiveRecord;


class Brand extends ActiveRecord
{

    public function rules()
    {
        return [
            ['name', 'required', "message" => "名称不能为空"],
            ['intro', 'required',"message" => "简介不能为空"],
            ['status', 'safe'],
        ];
    }
}
