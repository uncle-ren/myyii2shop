<?php
namespace  backend\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Goods_categoryQuery extends ActiveQuery {
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    } }