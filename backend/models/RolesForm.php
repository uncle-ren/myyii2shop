<?php
namespace backend\models;

use yii\base\Model;

class RolesForm extends Model{
    public $name;
    public $description;
    public $promission;


    public function rules()
    {
        return [
            [['name','description','promission'],'required'],
        ];
    }
}