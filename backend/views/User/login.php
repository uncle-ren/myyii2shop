<?php
$form=\yii\bootstrap\ActiveForm::begin();

//姓名
echo $form->field($model,'username')->textInput()->label("用户名");
//年龄
echo $form->field($model,'password')->passwordInput()->label("密码");


echo "<input type='checkbox' name='remember' value='1'>记住我<br/><br/>";

echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();



