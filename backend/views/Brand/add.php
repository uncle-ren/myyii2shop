<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput()->label("品牌名");
echo $form->field($model,'intro')->textInput()->label("品牌介绍");
//上传文件

//echo $form->field($model,'logo')->fileInput()->label("上传图片");
echo $form->field($model,'status')->dropDownList(["0"=>"隐藏","1"=>"正常",])->label("状态信息");

echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();

//注册cs和js文件
$this->registerCssFile("@web/webloader/webloader.css");
$this->registerJsFile("@web/webloader/webloader.css");

/*$this->registerJs(
    <<<JS

        var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: BASE_URL + '/js/Uploader.swf',

    // 文件接收服务端。
    server: 'http://webuploader.duapp.com/server/fileupload.php',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});

JS
);*/


?>



