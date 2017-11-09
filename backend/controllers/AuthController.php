<?php
namespace  backend\controllers;


use backend\models\AuthForm;
use backend\models\RolesForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class AuthController extends Controller{
    Public function actionMana(){
        //做权限的增删改查


        //添加权限
        //先准备两个权限
       $auth= \Yii::$app->authManager;
       $model= new AuthForm();
       /*$primission1=$auth->createPermission("超级管理员");
       $primission1->description="拥有所有权限";
       $primission2=$auth->createPermission("普通管理员");
       $primission2->description="添加用户权限";
       $auth->add($primission1);
       $auth->add($primission2);*/

        $request= new Request();
            if($request->isPost){
                $model->load($request->post());

                if($model->validate()){
                    $primission=$auth->createPermission($model->name);
                    $primission->description=$model->description;
                    $auth->add($primission);
                }
                \Yii::$app->session->setFlash("success","权限添加完成");
                return $this->redirect("list");
            }
        return $this->render("add",["model"=>$model]);
    }
    Public function actionList(){
        $auth=\Yii::$app->authManager;
        $Promissions=$auth->getPermissions();
//var_dump(ArrayHelper::map($Promissions,"name","description"));die;
        $Promissions= ArrayHelper::map($Promissions,"name","description");
        //var_dump($Promissions);die;
        return $this->render("list",["models"=>$Promissions]);
    }
    Public function actionDelmana(){

    }
    Public function actionDelrole(){

    }
    Public function actionRoles(){
        //添加角色
        $auth= \Yii::$app->authManager;
        $request= new Request();
        $model= new RolesForm();
        if($request->isPost){
           $model->load($request->post());
           //var_dump($model);die;
            //先添加juese

            $role=$auth->createRole($model->name);
            $role->description=$model->description;
            $auth->add($role);
            foreach($model->promission   as  $k=>$v){
                //从表中获取角色 和权限
                $role= $auth->getRole($model->name);
                $promission=$auth->getPermission($v);

                $auth->addChild($role,$promission);
            }
            //添加成功后 回到角色列表
            \Yii::$app->session->setFlash("success","角色权限分配完成");
            return $this->redirect("listroles");
        }
        //获取所有权限
        $Promissions= ArrayHelper::map($auth->getPermissions(),"name","description");
        return $this->render("addroles",["model"=>$model,"Promissions"=>$Promissions]);
    }
    Public function actionListroles(){
        //将角色信息取出
        $auth=\Yii::$app->authManager;
        $models= $auth->getRoles();

        $models=ArrayHelper::map($models,'name','description');
        return $this->render("listroles",["models"=>$models]);
    }
    Public function actionDelroles($name){
        //得到了名字 找出并删除角色
        $auth=\Yii::$app->authManager;
        $role=$auth->getRole($name);
        $auth->remove($role);
        echo "1";

    }

}
