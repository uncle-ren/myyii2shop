<?php
namespace  frontend\controllers;


use backend\models\Goods;
use backend\models\Goods_category;
use backend\models\Goods_gallery;
use frontend\models\Adress;
use yii\web\Controller;
use yii\web\Request;

class AdressController extends Controller{
    //管理地址操作
    Public $enableCsrfValidation=false;
    Public function actionList(){
        $model= new Adress();
        $models= Adress::find()->all();
        $categorys= Goods_category::find()->all();
        return $this->render('adress',["models"=>$models,"categorys"=>$categorys]);
        //return $this->render("test");
    }
    Public function actionAdd(){
        $request= new Request();
        $model= new Adress();
        if($request->isPost){
        $model->load($request->post(),'');
        //var_dump($model);die;
        if($model->validate()){
            $model->province=$model->cmbProvince;
            $model->city=$model->cmbCity;
            $model->area=$model->cmbArea;
            if($model->is_default){
                $model->is_default=1;
            }else{
                $model->is_default=0;
            }

            $model->save(false);
        }


        }
        return $this->redirect("list");

    }
    Public function actionDel($id){
        $model=Adress::findOne(["id"=>$id]);
        $model->delete();
        echo "success";
    }
    Public function actionEdit(){
        if(isset($_GET["id"])){
           $id=$_GET["id"];
        }else{
            $id=$_POST["id"];
        }
        $model= Adress::findOne(["id"=>$id]);
        $request= new Request();
        if($request->isPost){

            $model->load($request->post(),'');
            $model->province=$model->cmbProvince;
            $model->city=$model->cmbCity;
            $model->area=$model->cmbArea;
            $model->save(false);
            //保存后回到首页
            return $this->redirect("list");
        }
        return $this->render("edit",["model"=>$model,]);
    }
    Public function actionIndex(){

        $model= new Adress();
        $models= Adress::find()->all();
        $categorys= Goods_category::find()->all();
        return $this->render('index',["models"=>$models,"categorys"=>$categorys]);
    }
    Public function actionGoods($id){
        //根据id显示商品
        $goods= Goods::find()->where(["goods_category_id"=>$id])->all();
        $categorys= Goods_category::find()->all();
        //var_dump($goods);die;
        return $this->render("list",["goods"=>$goods,"categorys"=>$categorys]);
    }

}
