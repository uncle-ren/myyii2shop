<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>用户注册</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/login.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>]</li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="enroll" method="post" id="enroll">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" id="username"/><span id="name1"></span>
                        <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password"  id="password"/>
                        <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" class="txt" name="confirm_password"/>
                        <p><span>请再次输入密码</p>
                    </li>
                    <li>
                        <label for="">邮箱：</label>
                        <input type="text" class="txt" name="email"/>
                        <p>邮箱必须合法</p>
                    </li>

                    <li>
                        <label for="">手机号码：</label>
                        <input type="text" class="txt" value="" name="tel" id="tel" placeholder=""/>
                    </li>
                    <li>
                        <label for="">获取验证码：</label>
                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha"/><span  id="danger"></span> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>

                    </li>
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img id="myimg"  src="<?=\yii\helpers\Url::to(['site/captcha'])?>" alt="" />
                        <span>看不清？<a href="JavaScript:;" id="change_captcha">换一张</a></span>
                    </li>

                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb" checked="checked"/> 我已阅读并同意《用户注册协议》
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn"/>
                    </li>
                </ul>
            </form>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。 ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt=""/></a>
        <a href=""><img src="/images/kexin.jpg" alt=""/></a>
        <a href=""><img src="/images/police.jpg" alt=""/></a>
        <a href=""><img src="/images/beian.gif" alt=""/></a>
    </p>
</div>
<!-- 底部版权 end -->
<script type="text/javascript">
    function bindPhoneNum(){
        //点击获取验证码后 将电话号码发送到后台

        //再给验证码输入框添加丢失焦点信息


        //启用输入框
        $('#captcha').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time <=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>



<script>
    $().ready(function() {



// 在键盘按下并释放及提交后验证提交表单
        $("#enroll").validate({
            rules: {
                username: {
                    required: true,
                    //minlength: 2
                    remote:"/member/check_name"
                    //check_name:true
                },
                password: {
                    required: true,
                    //minlength: 5
                },
                confirm_password: {
                    required: true,
                    //minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                checkcode:{
                    check_cap:true
                },
                tel:{
                    required:true
                }

            },
            messages: {
                username: {
                    required: "请输入用户名",
                    remote:'对不起,用户已存在',
                    minlength: "用户名必需由两个字母组成"
                },
                password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字母"
                },
                checkcode:{
                    required: "请输入验证码",
                    remote:'验证码有错'
                },
                email:{
                    required: "请输入邮箱",
                    email:"请输入正确的邮箱"
                },
                confirm_password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字母",
                    equalTo: "两次密码输入不一致"
                },
                tel: {
                    required: "手机号不能为空",
                    minlength: "手机号长度只能为11位",
                    maxlength: "手机号长度只能为11位"
                },

            },
            errorElement:'span'   //没有分号
        });
        //刷新验证码  将方法封装 点击时调用 刷新页面也调用一次
        var flush_captacha=function(){
            $.getJSON('<?=\yii\helpers\Url::to(['site/captcha',"refresh"=>1])?>',function (data) {
                //将取得值放入img标签中
                $("#myimg").attr("src",data.url);
                //在验证码中保存
                $("#myimg").attr("data_hash",data.hash1)

            })
        };

        //点击获取短信验证码
        $("#get_captcha").click(function () {
            var tel=$("#tel").val();

            $.get("/member/sms",{"tel":tel},function(data){
                console.debug(data);
            })
        });
        //验证手机验证码
        $("#captcha").blur(function () {
            var tel=$("#tel").val();
            var sms= $("#captcha").val();
            var that=this;
            $.get("/member/checksms",{"sms":sms,"tel":tel},function (data) {
                if(data=="false"){
                    $("#danger").html("验证码错误");
                    $("#danger").attr("style","color:red");
                }else{
                    $("#danger").html("");
                }
            })
        });

        //看不清 换一张验证码
        $("#change_captcha").click(function () {
            flush_captacha();
        });
        flush_captacha();
    });
    //验证码验证
    jQuery.validator.addMethod("check_cap", function(value, element) {
        var hash = $("#myimg").attr("data_hash");
        var v = value.toLowerCase();
        var h = 0;
        for (var i = v.length - 1; i >= 0; --i) {
            h += v.charCodeAt(i);
        }
        return h == hash;
    },"验证码不正确");


</script>

</body>
</html>