<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yusuke
 * Date: 13/06/21
 * Time: 12:48
 * To change this template use File | Settings | File Templates.
 */

require_once("twitteroauth.php");

$url = 'http://shop.geeksphone.com/en/phones/5-peak.html';

$ch = curl_init(); // init

curl_setopt($ch, CURLOPT_URL, $url); // URLをセット
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // curl_exec()の結果を文字列で返す
curl_setopt($ch, CURLOPT_HEADER, true); // ヘッダも出力したい場合
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);

$webdata = curl_exec($ch); // 実行

$info = curl_getinfo ($ch);
//var_dump ($info);

$result['body'] = substr( $webdata, $header_size );

if(strpos($result['body'],'Out of stock') === false){
    $tubuyaki = 'Firefox Phone Peak 今日も売り切れ！ http://shop.geeksphone.com/en/phones/5-peak.html';

}else{

    $tubuyaki = 'Firefox Phone Peak 販売中かも！ http://shop.geeksphone.com/en/phones/5-peak.html';

}
echo $tubuyaki;


//token文字列
$consumer_key		="x8d2Ohto6DBSLpUhupMB0w";
$consumer_secret	="toUhEHWJ3qfSDu19gXb9LtqiHKI1GV00MbgAx5mMqI";
$oauth_token		="1535698483-RvZfbBgb0Fq1ZOjTnbNoh7SSYQO7cCnBH9eTn9e";
$oauth_token_secret	="Wk0uKIV45BdVllO9yC15ejupf1RKKmWVbfzdlsI3jBs";

//TwitterOAuthのインスタンスを生成
$twitter = new TwitterOAuth(
    $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret
);

//メソッドを指定(ここではつぶやくメソッドを指定)
$method = "statuses/update";

//パラメータを指定(ここではつぶやく文字列を指定)
$parameters = array("status" => $tubuyaki);

//メソッドを実行(ここではつぶやきます。)
$response = $twitter->post($method, $parameters);

//戻り値取得
$http_info = $twitter->http_info;
$http_code = $http_info["http_code"];

if($http_code == "200" && !empty($response))
{
    //つぶやき成功
    echo "TwitterPost() : success end";
    return true;
}
else
{
    //つぶやき失敗
    echo "TwitterPost() : faile end";
    return false;
}


curl_close($ch); // おまじない