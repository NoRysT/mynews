<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//以下を追記でNews Modelが扱える　見落としてた
use App\News;

//以下追記１７
use App\History;

use Carbon\Carbon;

class NewsController extends Controller
{
    // 以下を追記
    public function add()
    {
        return view('admin.news.create');
    }
    
    //以下追記laravel13
    public function create(Request $request)
    {

     //以下を追記
     //Varidationを行う
     $this->validate($request, News::$rules);
     
     $news = new News;
     $form = $request->all();
     
     //フォームから画像が送信されてきたら保存して、$news->image_pathに画像のパスを保存する。
     if (isset($form['image'])) {
         $path = $request->file('image')->store('public/image');
         $news->image_path = basename($path);
     }else{
         $news->image_path = null;
     }
     
     //フォームから送信されてきた_tokenを削除する
     unset($form['_token']);
     //フォームから送信されてきたimageを削除する
     unset($form['image']);
     
     //データベースに保存する
     $news->fill($form);
     $news->save();

        //admin/news/createにリダイレクト
        return redirect('admin/news/create');
    }
    
    //以下を追記１５
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            //検索されたら検索結果取得
            $posts = News::where('title', $cond_title)->get();
        } else {
            //それ以外は全てのニュースを取得
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' =>$posts, 'cond_title' => $cond_title]);
    }
    
    //以下を追記
    
    public function edit(Request $request)
    {
        //News Modelからデータを取得する
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form' =>$news]);
    }
    
    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request, News::$rules);
        //News Modelからデータを取得る
        $news = News::find($request->id);
        //送信されてきたフォームデータを格納
        $news_form = $request->all();
        if (isset($news_form['image'])) {
            $path = $request->file('image')->store('public/image');
            $news->image = basename($path);
            unset($news_form['image']);
        }elseif (isset($request->remove)) {
            $news->image_path = null;
            unset($news_form['remove']);
        }
        unset($news_form['_token']);
        //該当するデータを上書保存
        $news->fill($news_form)->save();
        
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();
        
        return redirect('admin/news/');
    }
    
    //以下を追記
    public function delete(Request $request)
    {
        //該当するNews Modelを取得
        $news = News::find($request->id);
        //削除
        $news->delete();
        return redirect('admin/news/');
    }
}
