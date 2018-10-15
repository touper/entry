@extends('admin.admin')
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">内容管理 - 文章</li>
    </ol>
@stop

@section('content')
    <a href="{{url('/article/create')}}" class="btn btn-primary margin-bottom">撰写新文章</a>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">文章列表</h3>
            <div class="box-tools">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="s_title"
                               style="width: 150px;" placeholder="搜索文章标题">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>操作</th>
                    <th>标题</th>
                    <th>作者</th>
                    <th>发布时间</th>
                    <th>更新时间</th>
                </tr>
                <!--tr-th end-->
                @foreach($articles as $article)
                <tr>
                    <td>
                        <form action="{{url('/article/'.$article['id'].'/edit')}}" method="get">
                            <button type="submit" class="btn btn-info">修改</button>
                        </form>
                        
                        <form action="{{url('/article/'.$article['id'])}}" method='post'>
                            <button class="btn btn-danger">删除</button>
                            {{ method_field('DELETE') }}
                            {!! csrf_field() !!}
                        </form>
                    </td>
                    <td class="text-muted">{{$article['title']}}</td>
                    <td class="text-green">{{$article['author']}}</td>
                    <td class="text-navy">{{$article['created_at']}}</td>
                    <td class="text-navy">{{$article['updated_at']}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

