<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m171112_035501_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50),
            'auth_key' => $this->string(32),
            'password' => $this->string(100)->comment("哈希密码"),
            'email' => $this->string(100)->comment("邮箱"),
            'tel' => $this->string(11)->comment("电话"),
            'last_login_time' => $this->integer()->comment("最后登录时间"),
            'last_login_ip' => $this->integer()->comment("最后登录ip"),
            'status' => $this->integer()->comment("状态  0删除  1正常"),
            'created_at' => $this->integer()->comment("创建时间"),
            'updated_at_at' => $this->integer()->comment("修改时间"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
