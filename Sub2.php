<?php

function searchItems2($query, $sort, &$hits2, $lowestPrice, $maximumPrice) {

	$appid = 'dj0zaiZpPUpLa1kwSnByQWc0ayZzPWNvbnN1bWVyc2VjcmV0Jng9YjU-';
	$query = mb_convert_encoding($query, 'UTF-8');
	$query = urlencode($query);	

switch ($sort){
		case '1':
			$url = "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid={$appid}&query={$query}";
		    break;
		case '2':
			$yasuikakaku  = urlencode('+price');
			$url= "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid={$appid}&query={$query}&sort={$yasuikakaku}";
			break;
		case '3':
			$review  = urlencode('-price');
			$url= "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid={$appid}&query={$query}&sort={$review}";
			break;
        case '4':
			$review  = urlencode('-review_count');
			$url= "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid={$appid}&query={$query}&sort={$review}";
			break;
		}

$url = $url . "&results=30";

$price= '&price_from=';
$price2= '&price_to=';

 if ($lowestPrice != "" && $maximumPrice != "") {
   $url= $url.$price.$lowestPrice.$price2.$maximumPrice;
  } else if ($lowestPrice != "") {
   $url= $url.$price.$lowestPrice;
  }else if ($maximumPrice  != "") {
   $url= $url.$price2.$maximumPrice;
  } else {
   $url = $url;
  }

$json = file_get_contents($url);

$arr = json_decode($json,true);

	foreach ($arr['hits'] as $key => $r){
         $hits2[$key]['name']=$r['name'];
		$hits2[$key]['medium']=$r['image']['medium'];
		$hits2[$key]['price']=$r['price'];
		$hits2[$key]['url']=$r['url'];
	$hits2[$key]['seller']=(string)$r['seller']['name'];
	$hits2[$key]['rate']=(string)$r['review']['rate'];
	$hits2[$key]['or']="yahoo!";
	}
}
?>