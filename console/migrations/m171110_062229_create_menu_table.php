<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m171110_062229_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'premenu' => $this->string()->comment("上级菜单"),
            'adress' => $this->string()->comment("地址/路由"),
            'sort' => $this->string()->comment("排序"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
