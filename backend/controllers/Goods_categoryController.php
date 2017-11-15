<?php
namespace  backend\controllers;


use backend\models\Goods_category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class Goods_categoryController extends Controller{

    Public function actionAdd(){
        $model= new Goods_category();
       /* //使用 makeroot  创建根节点
        $category2 = new Goods_category (['name' => '冰箱',"intro"=>"123333"]);
        /*$category1 ->makeRoot();
        //创建子节点 需要使用
        //$category2 ->prependTo(父节点对象);
        $category1 = Goods_category::findOne(["id"=>1]);
        $category2 ->prependTo($category1);*/
        $request= new Request();
        if($request->isPost){

            $model->load($request->post());
           // var_dump($model);die;
            if($model->validate()){
                if ($model->parent_id == 0){
                    $model->makeRoot();
                }else{
                    $a =Goods_category::findOne(["id"=> $model->parent_id]);
                    //执行添加子节点的操作
                    $model->prependTo($a);
                }
                \Yii::$app->session->setFlash('success','分类添加成功');
                return $this->redirect(['goods_category/list']);
            }
        }
        //var_dump($model);die;
        $model->parent_id=0;

        return $this->render("add",["model"=>$model]);
    }
    Public function actionList(){
        //取值
        $pager = new Pagination();
        $pager->totalCount= Goods_category::find()->count();
//        return  $this->render()
        $pager->pageSize = 2;

        // limit 0,2  ====> 两个参数 0(偏移量offset)   , 2(限制数量limit)
        $models = Goods_category::find()->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('list',['models'=>$models,'pager'=>$pager]);
    }
    public function actionTest(){

        $this->layout=false;

        return $this->render("test");

    }
    Public function actionDel($id){
        //删除这条记录

        $goods_category= Goods_category::findOne(["id"=>$id]);
        //判断是否有子节点
        if($goods_category->isleaf){
            //再判断是否是父节点
            if($goods_category->parent_id !=0){

            }
        }
        if($goods_category->delete()){
            //删除成功
            echo "1";
        }else{
            echo "0";
        }
    }
    Public function actionEdit($id){
        $model = Goods_category::findOne(["id"=>$id]);

        $request= new Request();
        if($request->isPost){
            $model->load($request->post());

            if($model->validate()){
                if ($model->parent_id == 0){
                    //再判断
                    $model->makeRoot();
                }else{
                    $a =Goods_category::findOne(["id"=> $model->parent_id]);
                    //执行添加子节点的操作
                    $model->prependTo($a);
                }
                \Yii::$app->session->setFlash('success','信息修改成功');
                return $this->redirect(['goods_category/list']);
            }
        }

        return $this->render("add",["model"=>$model]);
    }

}