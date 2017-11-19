<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public $pay;
    public $delivery;
    public $address_id;
    public static  $deliveries=[
        1=>["普通快递送货上门","10.00","	每张订单不满499.00元,运费15.00元"],
        2=>["特快专递","40.00","	每张订单不满499.00元,运费40.00元"],
        3=>["加急快递送货上门","40.00","	每张订单不满499.00元,运费40.00元"],
        4=>["平邮","8.00","	每张订单不满499.00元,运费8.00元"],

    ];
public static  $paies=[
    /**
     * 货到付款	送货上门后再收款，支持现金、POS机刷卡、支票支付
    在线支付	即时到帐，支持绝大数银行借记卡及部分银行信用卡
    上门自提	自提时付款，支持现金、POS刷卡、支票支付
    邮局汇款	通过快钱平台收款 汇款后1-3个工作日到账
     */
        1=>["货到付款","	送货上门后再收款，支持现金、POS机刷卡、支票支付"],
        2=>["在线支付","	即时到帐，支持绝大数银行借记卡及部分银行信用卡"],
        3=>["上门自提","	自提时付款，支持现金、POS刷卡、支票支付"],
        4=>["邮局汇款","	通过快钱平台收款 汇款后1-3个工作日到账"],

    ];


    public function rules()
    {
        return [
            [["pay", "delivery", "address_id"], "safe"],
        ];
    }
}