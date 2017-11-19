<?php
namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Adress;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\Order_goods;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\Request;

class OrderController extends Controller
{
    Public $enableCsrfValidation = false;

    public function actionAdd()
    {
        if (\Yii::$app->user->isGuest) {
            //未登录的话
            return $this->redirect(["/member/login"]);
            die;
        }
        //添加一个订单
        //取出商品信息和地址信息
        $order = new Order();
        $adress = Adress::find()->all();
        $carts = Cart::find()->where(["member_id" => (\Yii::$app->user->id)])->all();

        $request = new Request();
        if ($request->isPost) {
            //var_dump(1);die;
            //jieshou shuju
            $order->load($request->post(), '');
            //var_dump($order);die;
            $pay = $order->pay;  //支付方式id
            $delivery = $order->delivery;  //配送方式id
            $address_id = $order->address_id;  //地址方式id

            //var_dump($delivery_name);die;
            /**
             *
             *
             * delivery_id    int    配送方式id
             * delivery_name    varchar    配送方式名称
             * delivery_price    float    配送方式价格
             * payment_id    int    支付方式id
             * payment_name    varchar    支付方式名称
             * total    decimal    订单金额
             * status    int    订单状态（0已取消1待付款2待发货3待收货4完成）
             * trade_no    varchar    第三方支付交易号
             * create_time    int    创建时间
             */
            //取出地址信息
            /**
             * "member_id"=>(\Yii::$app->user->id)  我还没写menber_id
             */
            $address = Adress::findOne(["id" => $address_id]);
            //ar_dump($address);die;
            $order->member_id = \Yii::$app->user->id;
            $order->name = $address->name;
            $order->province = $address->province;
            $order->city = $address->city;
            $order->area = $address->area;
            $order->adress = $address->full_address;
            $order->tel = $address->tel;
            $order->delivery_id = $order->delivery;
            $order->delivery_name = Order::$deliveries[$order->delivery_id][0];
            $order->delivery_price = Order::$deliveries[$order->delivery_id][1];
            $order->payment_id = $order->pay;
            $order->payment_name = Order::$paies[$order->payment_id][0];
            $order->total = $order->delivery_price;  //先默认一个小计
            $order->status = 1;  //m默认为1  代付款
            $order->trade_no = time();  //交易号默认为时间戳
            $order->create_time = time();  //交易号默认为时间戳

            //数据处理完  保存数据
            //在此处开启时间
            $transact = \Yii::$app->db->beginTransaction();
            //try{}catch(){}  这是抛出异常和捕获异常

            //var_dump($order);die;
            try {
                if ($order->save(0)) {//$order->save(0)
                    /**
                     * order_id    int    订单id
                     * goods_id    int    商品id
                     * goods_name    varchar(255)    商品名称
                     * logo    varchar(255)    图片
                     * price    decimal    价格
                     * amount    int    数量
                     * total    decimal    小计
                     */
                    //var_dump(1);die;
                    //保存order后  保存order_goods表
                    $order_goods = new Order_goods();
                    $order_goods->order_id = $order->id;
                    //根据用户id  找出商品
                    $carts = Cart::find()->where(["member_id" => (\Yii::$app->user->id)])->all();
                    foreach ($carts as $cart) {
                        $aaa = Goods::findOne(["id" => $cart->goods_id]);
                        //var_dump($cart);die;
                        //var_dump($good->amount);
                        //判断是否购买数量超过了库存
                        if (($cart->amount > $aaa->stock)) {
                            throw new Exception($aaa->name . '商品库存不足');
                        }

                        $order_goods->goods_id = $aaa->id;
                        $order_goods->goods_name = $aaa->name;
                        $order_goods->logo = $aaa->logo;
                        $order_goods->price = $aaa->shop_price;
                        $order_goods->amount = $cart->amount;
                        $order_goods->total = ($cart->amount) * ($aaa->shop_price);
                        //保存
                        $order_goods->save(0);
                        //保存了  将物品的库存-1 增加金额
                        $order->total += $order_goods->total;//订单金额累加 (加上快递费)
                        Goods::updateAllCounters(['stock' => -$cart->amount], ['id' => $cart->goods_id]);

                        Cart::deleteAll('member_id='.\Yii::$app->user->id);
                        //删除当前用户的购物车信息

                        $order->save();
                        //保存一个订单  添加v

                    }


                }//在这里提交事件
                $transact->commit();

            } catch (Exception $e) {
                $transact->rollBack();

                //下单失败,跳转回购物车,并且提示商品库存不足
                echo $e->getMessage();
                exit;
            }
            return $this->redirect(["list"]);
        }
        //var_dump($carts);die;

        return $this->render("addorder", ["adress" => $adress, "carts" => $carts]);
    }

    Public function actionList()
    {
        //先找出当前登录用户的订单信息
        $orders= Order::find()->where(["member_id"=>(\Yii::$app->user->id)])->all();
        //在页面上根据order_id
        return $this->render("list", ["orders" => $orders]);

    }
}
