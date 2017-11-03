<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput()->label("分类名");
echo $form->field($model,'intro')->textInput()->label("介绍");
echo $form->field($model,'status')->dropDownList(["0"=>"隐藏","1"=>"正常",])->label("状态信息");

echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();

