<?php

namespace backend\controllers;


use backend\models\Menu;

use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class MenuController extends Controller
{
    public function actionAdd()
    {
        $model = new Menu();
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
        //取出所有分类
        $menus=array_merge( ["0"=>"顶级菜单"],  ArrayHelper::map(Menu::find()->all(),'id',"name")   );
//var_dump($menus);die;
        //取出所有路由
        $auth= \Yii::$app->authManager;
        $pers= ArrayHelper::map($auth->getPermissions(),'name','name')   ;
//var_dump($pers);die;

        return $this->render("add", ["model" => $model,"menus"=>$menus,"permission"=>$pers]);
    }
    Public function actionList()
    {
        //显示分页  实例化分页工具类
        $pager = new Pagination();
        $pager->totalCount = Menu::find()->count();
        //        var_dump($pager->totalCount);die;
        $pager->pagesize = 10;//设置默认最大显示条数
        /*var_dump(Brand::find()->all());*/

        $models = Menu::find()->limit($pager->limit)->offset($pager->offset)->all();
        //显示数据
        /*var_dump($models);die;*/
        return $this->render("list", ["models" => $models, "pager" => $pager]);
    }
    public function actionEdit($id)
    {
        //根据id 查找出数据 并回显修改
        $model=Menu::findOne(["id"=>$id]);
        $request=new Request();

        if ($request->isPost) {
            $model->load($request->post());

            if ($model->validate()) {
                //验证通过后保存
                /*var_dump($model);die;*/
                $model->save(false);
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect('list');
            }
        }
        //取出所有分类
        $menus=array_merge( ["0"=>"顶级菜单"],  ArrayHelper::map(Menu::find()->all(),'id',"name")   );
//var_dump($menus);die;
        //取出所有路由
        $auth= \Yii::$app->authManager;
        $pers= ArrayHelper::map($auth->getPermissions(),'name','name')   ;
//var_dump($pers);die;

        return $this->render("add", ["model" => $model,"menus"=>$menus,"permission"=>$pers]);


    }
    Public function actionDel($id){
        //通过id得到
        $model= Menu::findOne(["id"=>$id]);
        $model->delete();
        echo "1";
    }

}

