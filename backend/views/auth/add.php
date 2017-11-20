<?php
$form=\yii\bootstrap\ActiveForm::begin();

//姓名

echo $form->field($model,'name')->textInput()->label("权限(请填写路由)");
echo $form->field($model,'description')->textInput()->label("权限描述");

/*//所在分组
echo $form->field($model,'permissions',["inline"=>1])->checkboxList($permissions)->label("权限类型");*/

echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();



