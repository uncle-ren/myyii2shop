<?php
namespace  frontend\controllers;


use backend\models\Goods;
use backend\models\Goods_gallery;
use backend\models\Goods_intro;
use frontend\models\Cart;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;

class GoodsController extends Controller{
    Public $enableCsrfValidation=false;

    Public function actionDetail($id){
        //根据商品id  取出详细信息和相册
        $gallery= Goods_gallery::find()->where(["goods_id"=>$id])->all();
        $info= Goods_intro::findOne(["goods_id"=>$id]);
        $good= Goods::findOne(["id"=>$id]);
        //var_dump($gallery); //var_dump($info);die;

        //数据发送到页面
        return $this->render("goods",["gallery"=>$gallery,"info"=>$info,"good"=>$good]);
    }
    Public function actionCart(){

        //在这里接收数据  添加到数据库
        //判断是否是游客  游客则将值传到cookie中
        if(\Yii::$app->user->isGuest){
            /**
             * 游客的话 将商品id与数量以键值对方式放入cookie 非登录状态的购物车
             */
            $goods_id=$_POST["goods_id"];
            $amount=$_POST["amount"];
            //var_dump($goods_id);
            $carts_old=["$goods_id"=>"$amount"];
            //var_dump($s);die;
            $cookies=\Yii::$app->response->cookies;//这是写操作的cookie对象  准备组件
            $cookie=new Cookie();//实例化对象
            $cookie->name="cart";

            $cookie->value=serialize($carts_old);
            //放入cookie中
            $cookies->add($cookie);

           //var_dump(  $cookies  );



        }else{
            //非游客  将值存贮进数据表
            $cart= new Cart();
            $request= new Request();

            $cart->load($request->post(),'');
            /*if(Cart::findOne([""=>"",""=>""])){//如果能查找出数据

            }*/
            //var_dump($cart);die;
            //存入数据库
            $cart->member_id=\Yii::$app->user->id;
            if($cart->validate()){
                $cart->save(false);
            }
        }

        return $this->redirect(["list"]);

    }
    Public function actionList(){
        //session_start();
        //session_unset();
        //var_dump(\Yii::$app->user->id);
        //取出所有数据
        if(\Yii::$app->user->isGuest){
            //是游客的话
            $cookies=\Yii::$app->request->cookies;
            $carts=$cookies->getValue("cart");
            if($carts){
                //如果cooki e中已有值
                $carts = unserialize($carts);
            }else{
                $carts=[];
            }
            //根据数组取出商品
            $goods = Goods::find()->where(['in','id',array_keys($carts)])->all();
            return $this->render('cart_new',['carts'=>$carts,'models'=>$goods]);
//var_dump($goods);die;
//var_dump($goods);die;
        }else{
            //已经登录了
            $goods=Cart::find()->where(["member_id"=>(\Yii::$app->user->id)])->all();
            return $this->render("cart",["goods"=>$goods]);
        }




    }
    Public function actionDel($id){
        $cart = Cart::findOne(["id"=>7]);
        var_dump($cart);
        //$cart->delete();
        echo "success";
    }
    public function actionAjaxCart($type){
        //登录操作数据库 未登录操作cookie
        switch ($type){
            case 'change'://修改购物车
                $goods_id = \Yii::$app->request->post('goods_id');
                $amount = \Yii::$app->request->post('amount');
                if(\Yii::$app->user->isGuest){
                    //取出cookie中的购物车
                    $cookies = \Yii::$app->request->cookies;
                    $carts = $cookies->getValue('carts');
                    if($carts){
                        $carts = unserialize($carts);
                    }else{
                        $carts = [];
                    }
                    //修改购物车商品数量
                    $carts[$goods_id] = $amount;
                    //保存cookie
                    $cookies = \Yii::$app->response->cookies;
                    $cookie = new Cookie();
                    $cookie->name = 'carts';
                    $cookie->value = serialize($carts);
                    $cookies->add($cookie);

                }else{
                    //是登录状态
//$good=
                }
                break;
            case 'del':
                if (\Yii::$app->user->isGuest){
                    var_dump($_POST);
                }else{
                    //登录状态 删除数据库中的记录

                }
                break;
        }
    }

}
