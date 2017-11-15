

<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput()->label("商品分类名");
/*echo $form->field($model,'parent_id')->textInput()->label("上级分类");*/
echo $form->field($model,'parent_id')->hiddenInput();


//加载所需配置文件
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
$nodes = \yii\helpers\Json::encode(\yii\helpers\ArrayHelper::merge([['id'=>0,'parent_id'=>0,'name'=>'顶级分类']],\backend\models\Goods_category::getZtreeNodes()));
$this->registerJs(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            callback:{
                onClick: function(event, treeId, treeNode){
                    //获取被点击节点的id
                    var id= treeNode.id;
                    //alert(treeNode.tId + ", " + treeNode.name);
                    //将id写入parent_id的值
                    $("#goods_category-parent_id").val(id);
                }
            }
            ,
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};
        
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        //展开节点
        zTreeObj.expandAll(true);
        //获取节点  ,根据节点的id搜索节点
        var node = zTreeObj.getNodeByParam("id",$model->parent_id, null);   
        zTreeObj.selectNode(node);
        
JS

);
echo "<div>
    <ul id='treeDemo' class='ztree'></ul>
</div>";

echo $form->field($model,'intro')->textInput()->label("分类介绍");


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
