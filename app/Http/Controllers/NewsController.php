<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Usoft\RabbitRpc\Services\ProducerRpc;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = (new ProducerRpc())->setQueueName('news-crud')->call(json_encode([
            'method' => 'get-items',
            'news' => $request->input('app_id')
        ]));

        return json_decode($news);
    }

    public function store(Request $request)
    {
        $image = $request->file('image')->store('images/news', 's3');
        Storage::disk('s3')->setVisibility($image, 'public');

        $news = (new ProducerRpc())->setQueueName('news-crud')->call(json_encode([
            'method' => 'store',
            'image' => $image,
            'data' => $request->all()
        ]));

        return json_decode($news);
    }

    public function update($news, Request $request)
    {
        if ($request->isMethod('get')){
            $data = (new ProducerRpc())->setQueueName('news-crud')->call(json_encode([
                'method' => 'get-item',
                'news' => (integer)$news
            ]));
            return json_decode($data);
        }

        if ($request->hasFile('image')){
            $image = $request->file('image')->store('images/news', 's3');
            Storage::disk('s3')->setVisibility($image, 'public');
        }

        $data = (new ProducerRpc())->setQueueName('news-crud')->call(json_encode([
            'method' => 'update',
            'news' => (integer)$news,
            'image' => $image ?? null,
            'data' => $request->all()
        ]));

        return json_decode($data);

    }

    public function destroy($news, Request $request)
    {
        $data = (new ProducerRpc())->setQueueName('news-crud')->call(json_encode([
            'method' => 'delete',
            'news' => $news,
            'data' => $request
        ]));

        return json_decode($data);
    }
}
