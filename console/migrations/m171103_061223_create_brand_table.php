<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m171103_061223_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'intro' => $this->text(),
            'status' => $this->smallInteger(),
            'logo' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
{
    $this->dropTable('brand');
}
}
