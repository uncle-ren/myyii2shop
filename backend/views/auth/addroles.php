<?php
$form=\yii\bootstrap\ActiveForm::begin();

//姓名

echo $form->field($model,'name')->textInput()->label("角色名");
echo $form->field($model,'description')->textInput()->label("描述");
echo $form->field($model,'promission',["inline"=>1])->checkboxList($Promissions)->label("选择权限");

/*//所在分组
echo $form->field($model,'permissions',["inline"=>1])->checkboxList($permissions)->label("权限类型");*/

echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();



