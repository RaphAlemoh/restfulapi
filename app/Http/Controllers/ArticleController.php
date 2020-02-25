<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        // return Article::all();
        $articles = Article::paginate(40);
        return ArticleResource::collection($articles);
    }

    // public function show(Article $article)
    // {

    //     return $article;
    // }

    public function show($id)
    {
        $article = Article::findOrFail($id);        
        return new ArticleResource($article);
    }

    // public function store(Request $request)
    // {
    //     $article = Article::create($request->all());

    //     return response()->json($article, 201);
    // }

    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        if($article->save()){
            return new ArticleResource($article);
        }
    }

    // public function update(Request $request, Article $article)
    // {
    //     $article->update($request->all());

    //     return response()->json($article, 200);
    // }

    // public function delete(Article $article)
    // {
    //     $article->delete();

    //     return response()->json(null, 204);
    // }

    public function destroy($id)
    {
        $article =  Article::findOrFail($id);
        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}
