<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    Public $remember;
    public $username;
    public $checkcode;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ["remember",'safe'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
    Public function login(){
        $admin = Member::findOne(['username' => $this->username]);
        if ($admin) {

            //验证密码
            //调用安全组件的验证密码方法来验证

            if (\Yii::$app->security->validatePassword($this->password, $admin->password)) {
                //密码正确 可以登录

                //将登录标识保存到session
                //并将最后登录ip和登录时间保存起来
                $admin->last_login_ip = $_SERVER["REMOTE_ADDR"];
                $admin->last_login_time = time();
                $admin->save(false);

                if ($this->remember=="1") {
                    //表示勾选了记住我 将值保存到cookie中
                    $time = 3600;
                } else {
                    $time = 0;
                }
                \Yii::$app->user->login($admin, $time);
                /*var_dump($_SESSION);die;*/
                //session中含有用户id  没有username吗

                return true;
            }

        }
                return false;
    }



}
