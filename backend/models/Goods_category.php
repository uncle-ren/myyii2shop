<?php
namespace  backend\models;



use creocoder\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

class Goods_category extends  ActiveRecord {

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',  //这里必须打开 因为这里用到了多棵树
                // 'leftAttribute' => 'lft',
// 'rightAttribute' => 'rgt',
// 'depthAttribute' => 'depth',
            ],
        ];
    }
    public function transactions()     {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()     {
        return new Goods_categoryQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['name','intro',"parent_id"],'required'],
            [['intro'], 'string'],

            [['name'], 'string', 'max' => 50],
        ];
    }


    //获取Ztree需要的数据
    public static function getZtreeNodes(){
      return self::find()->select(['id','name','parent_id'])->asArray()->all();

    }

}
