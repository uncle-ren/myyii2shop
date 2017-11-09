<br/>
<br/>
<br/>
<form action="">
    <input type="text" name="search" value="<?=isset($_GET["search"])?$_GET["search"]:null?>"> 　　<input type="submit" value="点击搜素">
</form>

<table class="table table-bordered">
    <tr>
        <td>商品编号</td>
        <td>商品名称</td>
        <td>市场价格</td>
        <td>本店价格</td>
        <td>是否上架</td>
        <td>添加时间</td>
        <td>浏览次数</td>
        <td>Logo</td>
        <td>操作</td>
    </tr>

    <?php  foreach($models as $model): ?>
        <tr>
            <td><?=$model["sn"]?></td>
            <td><?=$model["name"]?></td>
            <td><?=$model["market_price"]?></td>
            <td><?=$model["shop_price"]?></td>
            <td><?= $model["status"]==0?"下架":"上架"?></td>
            <td><?= date("Y-m-d",$model["create_time"])?></td>
            <td><?= $model["view_times"]?></td>
            <td><img src="<?=$model["logo"]?>" width="166px" ></td>
            <td><a href="/goods_gallery/list?id=<?=$model["id"]?>" class="btn btn-info"><span class="glyphicon glyphicon-sort-by-attributes"></span> 查看相册</a>　<a href="edit?id=<?=$model["id"]?>" class="btn btn-danger">修改</a>　<a href="JavaScript:;" class="del btn btn-info" id="<?=$model["id"]?>">删除</a></td>
        </tr>
    <?php  endforeach; ?>
</table>
<a href="add" class="btn btn-danger">添加商品</a><br/>
<!--添加分页工具条-->
<?php
echo \yii\widgets\LinkPager::widget([
'pagination'=>$pager,
//'nextPageLabel'=>'下一页'
]);
//添加删除事件
$this->registerJs(
    <<<JS
        //在这里执行jquery
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