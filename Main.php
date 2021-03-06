<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Shopping Search System</title>
</style>
</head>
<body>
<?php

error_reporting(0);
include "Warning.php";

?><link rel="stylesheet" href="stylesheet.css"><?php
require('Sub.php');
require('Sub2.php');

print "<br><h1>Shopping Search System</h1>"; 

$sel = isset($_POST['SORT']) ? $_POST['SORT'] : '1';

print "<div class=\"container\">";
print "<form method=\"post\" action=\"Main.php\"
            onsubmit=\"return func1()\">";
    print " キーワードを入力: <input type=\"text\"
     name=\"KEYWORD\" size=\"30\" 
    value=\"{$_POST["KEYWORD"]}\">";

    print " 並び順: <select name=\"SORT\" type=\"text\">";
        switch ($sel) {
            case '1' :
                print "<option value=\"1\", selected>---</option>";
                print "<option value=\"2\">価格の安い順</option>";
                print "<option value=\"3\">価格の高い順</option>";
                print "<option value=\"4\">レビュー件数順</option>";
                break;
            case '2' :
                print "<option value=\"1\">---</option>";
                print "<option value=\"2\", selected>価格の安い順</option>";
                print "<option value=\"3\">価格の高い順</option>";
                print "<option value=\"4\">レビュー件数順</option>";
                break;
            case '3' :
                print "<option value=\"1\">---</option>";
                print "<option value=\"2\">価格の安い順</option>";
                print "<option value=\"3\", selected>価格の高い順</option>";
                print "<option value=\"4\">レビュー件数順</option>";
                break;
            case '4' :
                print "<option value=\"1\">---</option>";
                print "<option value=\"2\">価格の安い順</option>";
                print "<option value=\"3\">価格の高い順</option>";
                print "<option value=\"4\", selected>レビュー件数順</option>";
                break;
            }
    print "</select><br>";

    print " 最低金額: <input type=\"text\" name=\"low\" 
    size=\"6\", value=\"{$_POST["low"]}\">";
    print " ～ ";
    print " 最高金額: <input type=\"text\" name=\"max\" 
    size=\"6\", value=\"{$_POST["max"]}\">";
    print "　";
    print "<input type=\"submit\" value=\"検索\"/>"; 
print "</form>";
print "</div>";

if(isset($_POST["KEYWORD"])){

    $query = $_POST["KEYWORD"];
    $sort = $_POST["SORT"];

    $lowestPrice =  $_POST["low"];
    $maximumPrice =  $_POST["max"];

    if ($query != "") {

        print "<h2>検索ワード:".$query."</h2><br>";

        $hits = array();
        $hits2 = array();

        searchItems($query, $sort, $hits, $lowestPrice, $maximumPrice);
        searchItems2($query, $sort, $hits2, $lowestPrice, $maximumPrice);

        $main = array_merge($hits, $hits2);
    
    switch ($sort) {
        case '1':
            $sorted_array = $main;
            break;
        case '2':
            $sorted_array = sortByKey("price", SORT_ASC, $main);
            break;
        case '3':
            $sorted_array = sortByKey("price", SORT_DESC, $main);
            break;
        case '4':
            $sorted_array = sortByKey("rate", SORT_DESC, $main);
            break;
        }
    
    print "<table border=\"5\">";

    print "<tr>";
    print "<th class=\"a\">画像</th>";
    print "<th class=\"b\">商品名</th>";
    print "<th class=\"c\">販売店</th>";
    print "<th nowrap class=\"d\">価　格</th>";
    print "<th nowrap class=\"e\">レビュー</th>";
    print "<th class=\"f\">or</th>";
    print "</tr>";

    foreach($sorted_array as $r) {
        print "<tr>";
        echo "<td><img src=".$r["medium"]."></td>";
        print "<td><a href=".urldecode($r["url"]).
        "</a>".$r["name"]."</td>";
        print "<td>".$r["seller"]."</td>";
        print "<td>".$r["price"]."</td>";
        print "<td>".$r["rate"]."</td>";
        
        print "<td>".$r["or"]."</td>";
        print "</tr>";
    }

    print "</table>";
    
    } else {
        print "<div class=\"container\">
        キーワードが入力されていません。</div>";
    }
}
else {
    print "<div class=\"container\">
    検索したいキーワードを入力してください。"."<br></div>";
}

function sortByKey($key_name, $sort_order, $array) {
    foreach ($array as $key => $value) {
        $standard_key_array[$key] = $value[$key_name];
    }
    array_multisort($standard_key_array, $sort_order, $array);
    return $array;
}

print "<div class=\"container2\">
(noname-241198)</div>";

?>
</body>
</html>