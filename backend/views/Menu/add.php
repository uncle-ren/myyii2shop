<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'name')->label("菜单名");
//库存


echo $form->field($model,'premenu')->dropDownList($menus)->label("请选择上级菜单");


echo $form->field($model,'adress')->dropDownList($permission)->label("请选择路由");

//sort	int(11)	排序
echo $form->field($model,'sort')->textInput(['type'=>'number'])->label("排序");


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();