<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function detail($uri)
    {
        $data = Article::where('uri', $uri)->first();
        return view('article/detail', [
            'title' => $data->title,
            'header_caption' => $data->header_caption,
            'content' => $data->content,
            'author' => $data->author,
            'image_thumbnail' => $data->image_thumbnail,
            'created_at' => $data->created_at,
            'id' => $data->id,
            'uri' => $data->uri
        ]);
    }

    public function loadmore(Request $request)
    {
        $data = Article::select('title', 'header_caption', 'image_thumbnail', 'content', 'uri', 'created_at')->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax()) {
            $output = '';
            if (!$data->isEmpty()) {
                foreach ($data as $item) {
                    $output .= '
                    <div class="article-wrapper">
                        <div class="article-wrapper-left">
                            <img class="article-img" src="' . $item->image_thumbnail . '" alt="">
                        </div>
                        <div class="article-wrapper-right">
                            <div class="date-time">
                                <div class="calendar-icon" style="float: left; margin-right: 18px;"><img src="' . url('/images/icons/calendar.png') . '" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;">' . $item->created_at->isoFormat('D MMMM Y') . '</span></div>
						        <div class="clock-icon" style="margin-right: 18px;"><img src="' . url('/images/icons/clock.png') . '" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;">' . date('H:i', strtotime($item->created_at)) . '</span></div>
                            </div>
                            <span class="hashtag">#YamahaSumbar #YamahaIndonesia ' . $item->header_caption . '</span>
                            <a href="' . url("news/$item->uri") . '">
                                <h1 class="article-title">' . $item->title . '</h1>
                            </a>
                            <div class="article-content">' . $item->content . '</div>
                            <div class="info-count">
                                <div class="eye-icon" style="float: left; margin-right: 18px;"><img src="' . url('/images/icons/eye.png') . '" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;">00</span></div>
						        <div class="share-icon"><img src="' . url('/images/icons/share.png') . '" alt="" style="width: 13px; margin-right: 5px;"><span style="font-weight: bold; font-size:12px;">00</span></div>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
            return $output;
        }
        return view('article/article', compact('data'));
    }
}
