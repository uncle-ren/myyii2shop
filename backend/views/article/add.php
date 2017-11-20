<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name')->textInput()->label("文章标题");
echo $form->field($article,'intro')->textInput()->label("介绍");
echo $form->field($article,'status')->dropDownList(["-1"=>"删除","0"=>"隐藏","1"=>"正常",])->label("状态信息");
echo $form->field($article,'category_id')->dropDownList($ids)->label("所属的分类");
echo $form->field($article_detail,'content')->textarea()->label("详细信息");
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();

