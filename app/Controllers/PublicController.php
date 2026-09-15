<?php
namespace App\Controllers;
use App\Core\App; use App\Core\Request; use App\Core\View; use App\Repositories\ExtracurricularRepository; use App\Repositories\NewsRepository;
final class PublicController {
    private ExtracurricularRepository $extras; private NewsRepository $news;
    public function __construct() {$db=App::container()->get(\App\Core\Database::class);$this->extras=new ExtracurricularRepository($db);$this->news=new NewsRepository($db);}
    public function home(Request $r): never { View::render('public/home',['featured'=>$this->extras->featured(),'news'=>$this->news->published(3)]); }
    public function extracurriculars(Request $r): never { View::render('public/extracurriculars',['items'=>$this->extras->all()]); }
    public function showExtracurricular(Request $r,string $slug): never { $item=$this->extras->bySlug($slug); if(!$item){http_response_code(404);View::render('errors/404');} View::render('public/extracurricular-detail',compact('item')); }
    public function news(Request $r): never { View::render('public/news',['items'=>$this->news->published()]); }
    public function showNews(Request $r,string $slug): never { $item=$this->news->bySlug($slug);if(!$item){http_response_code(404);View::render('errors/404');}View::render('public/news-detail',compact('item')); }
}
