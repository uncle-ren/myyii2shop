<?php
namespace backend\controllers;

use backend\models\Goods;
use backend\models\Goods_gallery;
use yii\web\Controller;
use yii\web\UploadedFile;

class Goods_galleryController extends Controller{
    Public $enableCsrfValidation=false;

    Public function actionList($id){
        //根据商品id显示 对应所有图片
        $model= Goods::findOne(["id"=>$id]);
        $model->view_times= ($model->view_times)+1;
        $model->save(0);
        $models= Goods_gallery::find()->where(["goods_id"=>$id])->all();
        //遗留问题  新增的商品没有图片 不能显示
          //在添加logo后  默认添加一张logo图片

        return $this->render("list",["models"=>$models]);
    }
    Public function actionUpload($id){
        $model= new Goods_gallery();
        $imgFile = UploadedFile::getInstanceByName('file');//file相当于输入框名字
        //如果有文件上传
        if($imgFile){
            //上传文件的保存地址
            $fileName = '/uploads/'.uniqid().'.'.$imgFile->extension;
            $imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
            //保存成功
            $model->goods_id=$id;
            $model->path=$fileName;
            $model->save(0);
            //返回路径
            return json_encode($fileName);
        }
    }
    Public function actionDel($id){
        $model= Goods_gallery::findOne(["id"=>$id]);
        $model->delete();
        echo "1";
    }



}
