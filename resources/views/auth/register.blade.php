@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form id="myForm" class="form-horizontal" role="form">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
<script>
    $().ready(function() {
        $('#email').on('blur',function(){
            var email = $('#email').val();
            var reg = /^\w+@\w+.\w+$/;
            if(reg.test(email)) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "/reg",
                    type : "post",
                    dataType : "json",
                    data: {
                        email: $("#email").val(),
                    },
                    success : function(data) {
                        if(data.status!=1){
                            alert(data.msg);
                        }
                    }
                });
            } else {
                alert('邮箱格式错误');
            }
        });

        $("#myForm").validate({
            onsubmit:true,// 是否在提交是验证
            onfocusout:true,// 是否在获取焦点时验证
            onkeyup :false,// 是否在敲击键盘时验证
            rules: {　　　　//规则
                name: {　　
                    required: true
                }, 
                email: {　　
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages:{　　　　//验证错误信息
                name: {
                    required: "请输入用户名"
                },
                email: {
                    required: "请输入邮箱"
                },
                password: {
                    required: "请输入密码"
                },
                password_confirm: {
                    required: "请输确认密码",
                    equalTo: "输入与上面相同的密码"
                },
            },
            submitHandler: function(form) { //通过之后回调
                //进行ajax传值
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "/register",
                    type : "post",
                    dataType : "json",
                    data: {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                        password_confirmation:$("#password_confirm").val() 
                    },
                    success : function(data) {
                        if(data.status==1){
                            alert("用户注册成功请登录");
                            location.href='/login' ;
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            },
            invalidHandler: function(form, validator) {return false;}
        });
    });
</script>
@endsection