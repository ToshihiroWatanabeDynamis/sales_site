<?php
// Guzzleの使用
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function scrapeAlbumInfo() {
    // Guzzleクライアントを初期化
    $client = new Client();

    // 取得したいURL
    $url = 'https://www.albumoftheyear.org/ratings/6-highest-rated/all/1';

    // リクエスト送信
    $response = $client->request('GET', $url, [
    'headers' => [
		'User-Agent'=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36',
    'Accept'=> 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
    'Accept-Language'=> 'en-US,en;q=0.9',
    'Accept-Encoding'=> 'gzip, deflate, br',
    'Connection'=> 'keep-alive',
    'Referer' => 'https://www.albumoftheyear.org/',
		'Cookie' => 'cookie_name=cookie_value; another_cookie=another_value'
    ]]);

    // ステータスコードの確認
    if ($response->getStatusCode() !== 200) {
        die('Failed to retrieve the webpage.');
    }

    // レスポンスボディを取得
    $html = $response->getBody()->getContents();

    // DOMDocumentを使用してHTMLをロード
    $dom = new DOMDocument();

    // HTMLを読み込み（エラーを抑制）
    @$dom->loadHTML($html);

    // DOMXPathでHTMLを解析
    $xpath = new DOMXPath($dom);

    // アルバム情報の取得
    $albums = [];

    // アルバム名
    $albumNames = $xpath->query('//div[@class="albumListRow"]//a[@class="albumTitle"]');
    // アーティスト名
    $artistNames = $xpath->query('//div[@class="albumListRow"]//a[@class="artistTitle"]');
    // ジャンル（サイトの構造により変更する必要があるかも）
    $genres = $xpath->query('//div[@class="albumListRow"]//div[@class="genreTitle"]');
    // 発売日
    $releaseDates = $xpath->query('//div[@class="albumListRow"]//div[@class="releaseDate"]');
    // ランキング順位
    $rankings = $xpath->query('//div[@class="albumListRow"]//div[@class="ratingRowTitle"]');
    // ジャケット画像
    $coverImages = $xpath->query('//div[@class="albumListRow"]//img[@class="albumListImage"]');

    // データを配列に格納
    for ($i = 0; $i < $albumNames->length; $i++) {
        $albumInfo = [
            'album_name' => $albumNames->item($i)->textContent,
            'artist_name' => $artistNames->item($i)->textContent,
            'genre' => $genres->item($i) ? $genres->item($i)->textContent : 'N/A',
            'release_date' => $releaseDates->item($i)->textContent,
            'ranking' => $rankings->item($i)->textContent,
            'cover_image' => $coverImages->item($i)->getAttribute('src')
        ];
        $albums[] = $albumInfo;
    }

    // 結果を表示
    foreach ($albums as $album) {
        echo "アルバム名: " . $album['album_name'] . PHP_EOL;
        echo "アーティスト名: " . $album['artist_name'] . PHP_EOL;
        echo "ジャンル: " . $album['genre'] . PHP_EOL;
        echo "発売日: " . $album['release_date'] . PHP_EOL;
        echo "ランキング順位: " . $album['ranking'] . PHP_EOL;
        echo "ジャケット画像: " . $album['cover_image'] . PHP_EOL;
        echo "=============================" . PHP_EOL;
    }
}

scrapeAlbumInfo();