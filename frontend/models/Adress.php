<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Adress extends  ActiveRecord{
Public $cmbProvince;
Public $cmbCity;
Public $cmbArea;
public function rules()
{
    return [
        [["name","full_address","tel","cmbProvince","cmbCity","cmbArea"],"required"],
        ["is_default","safe"]
    ];
}
}
