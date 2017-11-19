<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m171117_020617_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->comment("用户id"),
            'name' => $this->string()->comment("收货人"),
            'province' => $this->string()->comment("省"),
            'city' => $this->string()->comment("市"),
            'area' => $this->string()->comment("县"),
            'tel' => $this->string(11)->comment("电话号码"),
            'adress' => $this->string(255)->comment("详细地址"),
            'delivery_id' => $this->integer()->comment("配送方式id"),
            'delivery_name' => $this->string()->comment("配送方式名称"),
            'delivery_price' => $this->float()->comment("配送方式价格"),
            'payment_id' => $this->decimal(6,2)->comment("支付方式id"),
            'payment_name' => $this->string()->comment("支付方式名称"),
            'total' => $this->decimal()->comment("订单金额"),
            'status' => $this->integer()->comment("订单状态 1待付款 "),
            'trade_no' => $this->string()->comment("支付交易(先随机生成一个字符串)"),
            'create_time' => $this->integer()->comment("创建时间"),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
