<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {
   Public $role;
    public function rules()
    {
        return [
            [["username","password_hash","email"],"required","message"=>"此处不能为空!"],
            ['email', 'email',"message"=>"请输入正确的邮箱格式"],
            [['username',"email"] ,'unique',"message"=>"已存在的名称或邮箱,请换一个"],
            ["role","safe"]
            //状态和添加时间等 在添加时再加上
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }


    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->auth_key ===$authKey ;
    }
    public  function getMenu(){
        //取出菜单
        $menuItems = [];
        $menus= Menu::find()->where(["premenu"=>0])->all();

        //循环一级菜单
        foreach($menus as $menu){
            $items=[];
            //再接着循环二级菜单
                foreach($menu->children as $child){
                    $items[]=['lable'=>$child->name,'url'=>[$child->adress]];
                }
            $menuItem=['lable'=>$menu->name,'items'=>$items];
            //放入数组中
            $menuItems[]=$menuItem;
        }
        return $menuItems;
    }
}
