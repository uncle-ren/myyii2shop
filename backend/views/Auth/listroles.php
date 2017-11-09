<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>


<table id="table_id_example" class="table table-bordered">
    <thead>
    <tr>
        <th>角色名</th>
        <th>介绍</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php  foreach($models as $key=>$model): ?>
    <tr>
        <td><?=$key?></td>
        <td><?=$model?></td>
        <td><a href="javascript:;" class="del  btn btn-danger"  name="<?=$key?>">删除</a>　<a href="editroles?name=<?=$key?>" class="btn btn-primary">修改</a></td>
    </tr>
    <?php endforeach;   ?>
    </tbody>
</table>

<?php
$this->registerJs(
    <<<JS
    $(document).ready( function () {
    $('#table_id_example').DataTable();
} );
        //在这里执行jquery
        $(".del").click(function(){
            //添加事件后 执行系列操作
            if(confirm("是否删除?删除后可能导致一些列你看不懂的错误!")){
                //确定后 发送数据到指定位置
                var that = this;
                var id = $(this).attr("name");
                //发送数据
                $.get("delroles",{"name":id},function(data) {
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



