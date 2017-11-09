<?php
namespace backend\models;

use yii\base\Model;

class AuthForm extends Model{
    public $name;
public $description;


public function rules()
{
    return [
        [['name','description'],'required'],
    ];
}
}