<table class="table table-bordered">
    <tr>
        <td>菜单名</td>
        <td>路由地址</td>
        <td>排序</td>

        <td>操作</td>
    </tr>

    <?php  foreach($models as $model): ?>
        <tr>

            <td><?=$model["name"]?></td>
            <td><?=$model["adress"]?></td>
            <td><?= $model["sort"]?></td>
            <td><a href="edit?id=<?=$model["id"]?>" class="btn btn-danger">修改</a>　<a href="JavaScript:;" class="del btn btn-info" id="<?=$model["id"]?>">删除</a></td>
        </tr>
    <?php  endforeach; ?>
</table>
<a href="add" class="btn btn-danger">添加菜单</a><br/>
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
                            
                        }
                })
                
            }
            
        })       
JS
);