<?php

namespace backend\models;


use yii\db\ActiveRecord;


class Brand extends ActiveRecord
{
    public $imgFile;
    public function rules()
    {
        return [
            ['name', 'required', "message" => "名称不能为空"],
            ['intro', 'required',"message" => "简介不能为空"],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    public static function getStatusOptions($hidden_del=true){
        $options =  [
            -1=>'删除', 0=>'隐藏', 1=>'正常'
        ];
        if($hidden_del){
            unset($options['-1']);
        }
        return $options;
    }

}
