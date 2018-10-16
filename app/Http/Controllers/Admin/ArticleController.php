<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::orderBy('created_at','desc')->get();
        return view('admin.article.index',['articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'editorValue' => 'required'
        ],[
            'title.required' => '标题不能为空',
            'author.required' => '作者不能为空',
            'editorValue.required' => '内容不能为空',
        ]);
        $post = $request->all();

        $article = new Article;

        $article->title = $post['title'];
        $article->author = $post['author'];
        $article->content = $post['editorValue'];

        if($article->save()) {
        	return redirect('/article')->with('success','文章添加成功');
        } else {
        	return back()->with('error','文章添加失败');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $article = Article::findOrFail($id);

        return view('admin.article.edit',['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'editorValue' => 'required'
        ],[
            'title.required' => '标题不能为空',
            'author.required' => '作者不能为空',
            'editorValue.required' => '内容不能为空',
        ]);
        
    	$article = Article::findOrFail($id);

    	$article->title = trim($request->title);
    	$article->author = trim($request->author);
    	$article->content = $request->editorValue;

    	if($article->save()) {
    		return redirect('/article')->with('success','更新成功');
    	} else {
    		return back()->with('error','更新失败');
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(Article::destroy($id)) {
        	return redirect('/article')->with('success','删除成功');
        } else {
        	return back()->with('error','删除失败');
        }
    }
}
