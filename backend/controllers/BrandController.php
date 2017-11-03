<?php

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class BrandController extends Controller
{

    public function actionAdd()
    {
        $model = new Brand();
        $request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                //验证通过后保存
                /*var_dump($model);die;*/
                $model->save(false);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect('list');
            }
        }
        $model->status = 1;  //默认正常状态
        return $this->render("add", ["model" => $model]);
    }

    Public function actionList()
    {
        //显示分页  实例化分页工具类
        $pager = new Pagination();
        $pager->totalCount = Brand::find()->count();
        //        var_dump($pager->totalCount);die;
        $pager->pagesize = 2;//设置默认最大显示条数
        /*var_dump(Brand::find()->all());*/

        $models = Brand::find()->limit($pager->limit)->offset($pager->offset)->where(["status"=>["1","0"]])->all();
        //显示数据
        /*var_dump($models);die;*/
        return $this->render("list", ["models" => $models, "pager" => $pager]);
    }

    public function actionEdit($id)
    {
        $model = Brand::findOne(["id" => $id]);
        $request = new Request();
        if ($request->isPost) {
            //接收数据 做修改
            $model->load($request->post());
            if ($model->validate()) {
                //保存数据
                $model->save();
                //保存后跳转到list
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect('list');
            }
        }
        //发送数据做回显
        return $this->render("add", ["model" => $model]);
    }
    Public function actionDel($id){
        //接收ajax数据   逻辑删除数据  即将状态改为-1[
        $model= Brand::findOne(["id"=>$id]);
        $model->status= -1;
        $model->save(false);
        echo "1";
    }
}
