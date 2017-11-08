<?php

$this->registerCssFile('@web/webuploader/webuploader.css');
$this->registerJsFile('@web/webuploader/webuploader.js',[
    'depends'=>\yii\web\JqueryAsset::className(),//指定依赖关系,webuploader.js必须在jquery后面加载(依赖于jquery)

]);

$this->registerJs(
    <<<JS
// 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/js/Uploader.swf',

    // 文件接收服务端。
    server: 'upload?id='+{$models[0]->goods_id},

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/jpg,image/jpeg,image/png',//弹出选择框慢的问题
        
    }
});
//文件上传成功  回显图片
uploader.on( 'uploadSuccess', function( file ,response) {
    //将图片地址赋值给img

    $("#img").attr('src',response);

});
JS

);


?>

    <div id="uploader-demo">
        <!--用来存放item-->
        <div id="fileList" class="uploader-list"></div>
        <div id="filePicker">选择图片上传</div>
    </div>
    <div><img id="img"  src="" /></div>

<a href="/goods/list" class="btn btn-warning">回到商品首页</a>

<table class="table table-bordered">

    <?php  foreach($models as $model): ?>
        <tr>
            <td><img src="<?=$model["path"]?>" width="200px" height="200px"></td>
            <td><a href="JavaScript:;" class="del btn btn-info" id="<?=$model["id"]?>">删除</a></td>
        </tr>
    <?php  endforeach; ?>
</table>

<?php

//添加删除事件
$this->registerJs(
    <<<JS
        //在这里执行jquery
        //如果要使用 ajax删除
        $(".del").click(function(){
            //添加事件后 执行系列操作
            if(confirm("是否删除?删除后可能导致一些列你看不懂的错误!")){
                //确定后 发送数据到指定位置
                var that = this;
                var id = $(this).attr("id");
                //发送数据
                $.get("del",{"id":id},function(data) {
                        //在edit中执行删除操作
                        if(data=="1"){
                            //修改成功  删除这一行
                            $(that).closest("tr").remove();
                            
                        }else{
                            alert("删除失败.未知错误,请稍后重试")
                        }
                })
                
            }
            
        })       
JS
);