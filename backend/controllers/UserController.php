<?php
namespace backend\controllers;


use backend\models\User;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Session;

class UserController extends   Controller{
    public function actionAdd(){
        $model= new User();
        $auth= \Yii::$app->authManager;
        $roles= $auth->getRoles();
        $roles=ArrayHelper::map($roles,"name","description");
        $a= new LoginForm();
        $request= new Request();
        if($request->isPost){
            //表单提交时
            //接收数据
            $model->load($request->post());

            if ($model->validate()){
                //验证通过后
                //将密码转化为哈希密码
                $model->password_hash= \Yii::$app->security->generatePasswordHash($model->password_hash);
                //var_dump($model->password_hash);die;
                $model->status=1;
                $model->created_at=time();
                //保存
                $model->save(false);
                $id=$model->id;
                //添加后 循环职位    循环保存用户和角色关系
                foreach($model->role  as $v){
                    $role= $auth->getRole($v);
                    $auth->assign($role,$id);
                }

                //添加成功  回到显示页面
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect('list');
            }
        }
        return $this->render("add",["model"=>$model,"roles"=>$roles]);

    }
    public function  actionDel($id){
        $model= User::findOne(["id"=>$id]);
        $model->status=0;
        $model->save(false);
        echo "1";
    }
    public function  actionEdit($id){
        $model= User::findOne(["id"=>$id]);
        $request= new Request();
        if($request->isPost){
            //表单提交时
            //接收数据
            $model->load($request->post());
            if ($model->validate()){
                //验证通过后

                //将密码转化为哈希密码

                //var_dump($model->password_hash);die;
                $model->status=0;
                $model->created_at=time();
                //保存
                $model->save(false);
                //添加成功  回到显示页面
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect('list');
            }
        }
        return $this->render("add",["model"=>$model]);
    }
    public function  actionList(){

        //分页显示
        $pager= new Pagination();
        $pager->pageSize=2;
        $pager->totalCount=User::find()->where(["status"=>1])->count();
        $query= User::find();
        $models= $query->where(["status"=>1])->limit($pager->limit)->offset($pager->offset)->all();

        //发送数据
        return $this->render("list",["models"=>$models,"pager"=>$pager]);
    }
    Public function  actionLogin(){

        $model= new LoginForm();
        $request= new Request();
        if($request->isPost){

            $model->load($request->post());

            if($model->validate()){
                //再判断 Login方法
                if($model->login()){
                    //验证通过的话  转到用户列表首页


                    \Yii::$app->session->setFlash('success','登录成功');
                    //跳转

                    return $this->redirect("list");
           
                }
            }
        }

        return $this->render("login",["model"=>$model]);
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect('login');
    }

}
