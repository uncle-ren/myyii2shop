<?php
namespace  backend\controllers;

use backend\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class  CategoryController extends  Controller{
    public function actionList(){
        //使用 分页工具类
        $pager = new Pagination();
        $pager->totalCount= Category::find()->count();
        $pager->pageSize=2;
        //取出数据
        $models = Category::find()->where(["status" =>["1","0"]])->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render("list",["models"=>$models,"pager"=>$pager]);
    }
    Public function actionAdd(){
        $model = new Category();
        $request= new Request();
        if($request->isPost){
            //接收数据
            $model->load($request->post());
            if($model->validate()){
                //数据保存
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect('list');
            }
        }
        //显示添加表单
        $model->status=1;
        return $this->render("add",["model"=>$model]);
    }
    Public function actionEdit($id){
        //取出数据做回显
        $model = Category::findOne(["id"=>$id]);
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                //跳转
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect('list');
            }
        }

        return $this->render("add",["model"=>$model]);

    }
    Public function actionDel($id){
       $model = Category::findOne(["id"=>$id]);
       //将状态值改为 -1
        $model->status = -1;
        $model->save(false);
            echo "1";
    }
}
