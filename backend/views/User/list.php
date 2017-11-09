<br/>
<br/>
<br/>
<!--<form action="">
    <input type="text" name="search" value="<?/*=isset($_GET["search"])?$_GET["search"]:null*/?>"> 　　<input type="submit" value="点击搜素">
</form>-->

<table class="table table-bordered">
    <tr>
        <td>用户名</td>
        <td>邮箱</td>
        <td>注册时间</td>
        <td>最后登录ip</td>
        <td>最后登录时间</td>

        <td>操作</td>
    </tr>

    <?php  foreach($models as $model): ?>
        <tr>
            <td><?=$model["username"]?></td>
            <td><?=$model["email"]?></td>
            <td><?=date("Y-m-d",$model["created_at"])?></td>
            <td><?=$model["last_login_ip"]==null?"无":$model["last_login_ip"]?></td>
            <td><?=$model["last_login_time"]==null?"无":date("Y-m-d h:i:s",$model["created_at"])?></td>
            <td><a href="edit?id=<?=$model["id"]?>" class="btn btn-danger">修改信息</a>　<a href="password?id=<?=$model["id"]?>" class="btn btn-warning">修改密码</a>　<a href="JavaScript:;" class="del btn btn-info" id="<?=$model["id"]?>">删除</a></td>
        </tr>
    <?php  endforeach; ?>
</table>
<a href="add" class="btn btn-danger">添加用户</a><br/>
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