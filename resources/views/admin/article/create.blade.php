@extends('admin.admin')
@section('other-css')
    {!! editor_css() !!}
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <style>
       /* label .error{color:red;}*/
    </style>
@endsection
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active"><a href="{{url('/admin/article/index')}}">内容管理 - 文章</a></li>
    </ol>
@stop

@section('content')
    <h2 class="page-header">撰写新文章</h2>
    <form id="myForm" method="POST" action="{{url('/article')}}" accept-charset="utf-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab_1">
                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>标题
                            <small class="text-red">*</small>
                        </label>
                        <input required="required" type="text" class="form-control" name="title" autocomplete="off"
                               placeholder="标题" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label>作者
                            <small class="text-red">*</small>
                        </label>
                        <input required="required" type="text" class="form-control" name="author" autocomplete="off"
                               placeholder="作者" maxlength="80">
                    </div>
                    <!-- <div class="form-group">
                        <label>选择标签
                            <small class="text-red">*</small>
                        </label>
                        <select class="js-example-basic-multiple form-control" multiple="multiple">
                            <option value="1">PHP</option>
                            <option value="2">Web</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>是否置顶
                            <small class="text-red">*</small>
                        </label>
                        <select class="js-example-placeholder-single form-control">
                            <option value=""></option>
                            <option value="1">是</option>
                            <option value="2">否</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label>内容
                            <small class="text-red">*</small>
                            <span class="text-green">min:20</span>
                        </label>
                        <div id="ueditor" class="edui-default">
                            @include('UEditor::head')
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">发布文章</button>
                {!! csrf_field() !!}
            </div>
        </div>
    </form>

@stop
@section('other-js')
    {!! editor_js() !!}
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.full.min.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
    <script id="ueditor"></script>
    <script>

        $().ready(function() {

            window.UEDITOR_HOME_URL = "http://entry.cc/"
            var ue=UE.getEditor("ueditor");
            ue.ready(function(){
                 ue.execCommand('serverparam','_token','{{ csrf_token() }}');
            });

            $("#myForm").validate({
                onsubmit:true,// 是否在提交是验证
                onfocusout:true,// 是否在获取焦点时验证
                onkeyup :false,// 是否在敲击键盘时验证
                rules: {　　　　//规则
                    title: {　　
                        required: true
                    }, 
                    author: {　　
                        required: true,
                    }
                },
                messages:{　　　　//验证错误信息
                    title: {
                        required: "请输入文章标题"
                    },
                    author: {
                        required: "请输入作者姓名"
                    }
                },
                submitHandler: function(form) { 
                    var value = $('[name="editorValue"]').val();
                    if(value=='') {
                        alert('请输入文章内容');
                        return false;
                    }
                    return true;
                },
                invalidHandler: function(form, validator) {return false;}
            });
        });
    </script>
@endsection

