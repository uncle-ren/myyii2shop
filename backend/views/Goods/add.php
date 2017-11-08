<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'name')->label("货品名");
//库存
echo $form->field($model,'stock')->label("库存数量");

echo $form->field($model,'imgfile')->fileInput()->label("选择图片上传");

echo $form->field($model,'goods_category_id')->hiddenInput()->label("请选择分类");
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
$nodes = \yii\helpers\Json::encode(\backend\models\Goods::getZtreeNodes());
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
                    //将id写入
                    $("#goods-goods_category_id").val(id);
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
        var node = zTreeObj.getNodeByParam("id",$model->goods_category_id, null);   
        zTreeObj.selectNode(node);
        
JS

);
echo "<div>
    <ul id='treeDemo' class='ztree'></ul>
</div>";

//=================================
//sort	int(11)	排序
echo $form->field($model,'sort')->textInput(['type'=>'number'])->label("排序");

//是否上架
echo $form->field($model,'is_on_sale',["inline"=>1])->radioList(["1"=>"上架","0"=>"下架"])->label("是否上架");
//status	int(2)	状态(-1删除 0隐藏 1正常)
//品牌
echo $form->field($model,"brand_id")->dropDownList($brand)->label("选择品牌");
// 商店价格
echo $form->field($model,"market_price")->textInput()->label("市场价格");
//市场价格
echo $form->field($model,"shop_price")->textInput()->label("本店价格");
 //
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::getStatusOptions())->label("状态信息");
//先用文本域代替富文本框
echo $form->field($goods_intro,'content')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
        //定制菜单
        'toolbars' => [
            [
                'fullscreen', 'source', 'undo', 'redo', '|',
                'fontsize',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor', '|',
                'lineheight', '|',
                'indent', '|'
            ],
        ]
      ]
    ]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();