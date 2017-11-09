<?php
namespace backend\models;

use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $remember;

    public function rules()
    {
        return [
            [['username','password'],'required'],
        ];
    }

    public function login(){
        //验证账号
        $admin = User::findOne(['username'=>$this->username]);
        if($admin){

            //验证密码
            //调用安全组件的验证密码方法来验证

            if(\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
                //密码正确 可以登录

                //将登录标识保存到session
                //并将最后登录ip和登录时间保存起来
                $admin->last_login_ip=$_SERVER["REMOTE_ADDR"];
                $admin->last_login_time=time();
                $admin->save(false);

                if($_COOKIE){
                    //表示勾选了记住我 将值保存到cookie中
                    $time=1000;
                }else{
                    $time=0;
                }
               \Yii::$app->user->login($admin,$time);
                /*var_dump($_SESSION);die;*/
                //session中含有用户id  没有username吗?




                return true;
            }else{
                //echo '密码错误';exit;
                //给模型添加错误信息
                $this->addError('password','密码错误');
            }
        } else{

            $this->addError('username','用户不存在');
        }
        return false;
    }
    Public function name(){
        $admin = User::findOne(['username'=>$this->username]);
        if($admin){
            $this->addError('username','用户名已存在,请换一个');
        }
    }


}