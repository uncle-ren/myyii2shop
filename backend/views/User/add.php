<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'username')->label("用户姓名");
//intro	text	简介
if($model->getIsNewRecord()){
    echo $form->field($model,'password_hash')->passwordInput()->label("用户密码");
}

//邮箱
echo $form->field($model,'email')->label("邮箱");

echo $form->field($model,'role')->checkboxList($roles)->label("选择职位");
echo \yii\bootstrap\Html::submitButton($model->getIsNewRecord()?"立即注册":'修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();