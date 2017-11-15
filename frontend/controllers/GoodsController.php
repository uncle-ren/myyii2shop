<?php
namespace  frontend\controllers;


use backend\models\Goods;
use backend\models\Goods_gallery;
use backend\models\Goods_intro;
use yii\web\Controller;

class GoodsController extends Controller{

    Public function actionDetail($id){
        //根据商品id  取出详细信息和相册
        $gallery= Goods_gallery::find()->where(["goods_id"=>$id])->all();
        $info= Goods_intro::findOne(["goods_id"=>$id]);
        $good= Goods::findOne(["id"=>$id]);
        //var_dump($gallery); //var_dump($info);die;

        //数据发送到页面
        return $this->render("goods",["gallery"=>$gallery,"info"=>$info,"good"=>$good]);
    }

}
