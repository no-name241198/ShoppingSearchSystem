<?php

function callWebAPI($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function searchItems($query, $sort, &$hits, $lowestPrice, $maximumPrice) {

	$query_en = urlencode($query);

	$appid = '1094325334360539539';
	$affid = '1e56fe9b.c4db3d21.1e56fe9c.6e478470';

	switch ($sort){
		case '1':
			$hyoujun = urlencode('standard');
			$url= "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222?applicationId={$appid}&affiliateId={$affid}&format=xml&keyword={$query}&sort={$hyoujun}";
			break;
		case '2':
			$kakaku  = urlencode('+itemPrice');
			$url= "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222?applicationId={$appid}&affiliateId={$affid}&format=xml&keyword={$query}&sort={$kakaku}";
			break;
		case '3':
			$kakaku  = urlencode('-itemPrice');
			$url= "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222?applicationId={$appid}&affiliateId={$affid}&format=xml&keyword={$query}&sort={$kakaku}";
			break;
		case '4':
			$review  = urlencode('-reviewCount');
			$url= "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222?applicationId={$appid}&affiliateId={$affid}&format=xml&keyword={$query}&sort={$review}";
			break;
		}

		if ($lowestPrice != "" && $maximumPrice != "") {
			$url = $url."&minPrice=".$lowestPrice."&maxPrice=".$maximumPrice; 
		   } else if ($lowestPrice != "") {
			$url = $url."&minPrice=".$lowestPrice; 
		   }else if ($maximumPrice != "") {
			$url = $url."&maxPrice=".$maximumPrice;
		   } else {
			$url = $url;
		   }

$res = callWebAPI($url);

$xml = simplexml_load_string($res);

	$json = json_encode($xml);
	$result = json_decode( $json, true ) ;

foreach ($result['Items']['Item'] as $key => $r){
			$hits[$key]['price']=$r['itemPrice'];
			$hits[$key]['name']=$r['itemName'];
			$hits[$key]['url']=(string)$r['itemUrl'];
			if ((string)$r['mediumImageUrls']['imageUrl'] == 'Array') {
				$hits[$key]['medium']=(string)$r['mediumImageUrls']['imageUrl'][0];
			} else {
				$hits[$key]['medium']=(string)$r['mediumImageUrls']['imageUrl'];
			}
		$hits[$key]['seller']=(string)$r['shopName'];
		$hits[$key]['rate']=$r['reviewAverage'];
		$hits[$key]['or']="rakuten";
		}
}