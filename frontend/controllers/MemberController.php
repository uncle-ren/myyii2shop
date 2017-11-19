<?php
namespace frontend\controllers;


use frontend\components\Sms;
use frontend\models\Member;
use frontend\models\SignupForm;
use yii\web\Controller;
use yii\web\Request;

class MemberController extends Controller{
    Public $enableCsrfValidation=false;
    Public function actionLogin(){
        //登录功能
        $model= new SignupForm();
        $request= new Request();

        if ($request->isPost) {
            //var_dump($model);die;
            $model->load($request->post(), '');//不是使用的yii2视图  需要重定义
            //var_dump($model);die;
            //规则中验证数据
            if ($model->login()) {
                //如果验证通过
                return $this->redirect(["/adress/index"]);

                die;
            } else {
                echo "验证失败";
                die;

            }
        }
        return $this->render('login');
    }
    Public function actionEnroll(){
        //$this->layout=false;
        $model= new SignupForm();
        $request = new  Request();
        $member= new Member();
        if ($request->isPost){
            $member->load($request->post(),'');
            //var_dump($member);die;
            if($member->validate()){
                $member->password=\Yii::$app->security->generatePasswordHash($member->password);
                $member->last_login_time=time();
                $member->last_login_ip=$_SERVER["REMOTE_ADDR"];
                $member->status=1;
                $member->created_at=time();

                //将值保存
                $member->save(false);
                echo  "添加成功";
                echo "<a href='login'>立即登录</a>";die;
            }
        }

        //注册账号
        //显示表单
        return $this->render("enroll");
    }
    Public function actionCheck_name($username){
        //检测

        if(Member::findOne(["username"=>$username])){
            return  'false';
        }else{
            return 'true';
        }
    }
    Public function actionSms($tel){

        $sms=rand(1000,9999);

        //$tel= "18731240623";
        $response = Sms::sendSms(
            "知交半零落", // 短信签名
            "SMS_110260002", // 短信模板编号
          "{$tel}", // 短信接收者
   //         "15756877647",  18731240623
   //         "18381719209",
            Array(  // 短信模板中字段的值

                "code"=>$sms,
                /*"product"=>"dsd"*/
            )//,
            // "123"   // 流水号,选填
        );
        if($response->Code =="OK"){
            //如果发送成功 则将值保存进SESSION中   也可用redis  因为本机redis有问题 使用session
            @session_start();
            $_SESSION["sms".$tel]=$sms;

        }else{
            echo "false";
        }
        echo "发送短信(sendSms)接口返回的结果:\n";


    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->redirect(["login"]);
    }
}
