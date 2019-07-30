<?php
include 'pdoClass.php';
$dbh = new Db('127.0.0.1','root', 'root');
$curl=curl_init();
$url="https://news.baidu.com/";
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
$res = curl_exec($curl);
$reg='#.*<a href=".*" mon=".*" target="_blank">(.*)</a>.*<a href=".*" mon=".*" target="_blank">(.*)</a>.*#isU';
preg_match_all($reg,$res,$arr);
print_r($arr);
$title=$arr[1];
$name=$arr[2];
$sql="insert into list(`title`,`tex`) VALUES ";
foreach($title as $key =>$value){
    $sql.="('$title[$key]','$name[$key]'),";
}

$sql=substr($sql,0,-1);
$dbh->insertData('hhh',$arr);