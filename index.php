<?php
$page = isset($_GET['page'])?$_GET['page']:1;
$search = isset($_GET['title'])?$_GET['title']:'';
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
if($search==''){
    if($redis->hExists("data2","data2_$page")){
        $arr = $redis->hget("data2","data2_$page");
        $req =array('code'=>1,'code'=>'查询成功','data'=>json_decode("$arr",true));
        echo json_encode($req);
    }
}
else{
    if($redis->hExists("data2","data2_$page&$search")){
        $arr = $redis->hget("data2","data2_$page&$search");
        $req =array('code'=>1,'code'=>'查询成功','data'=>json_decode("$arr",true));
        echo json_encode($req);
    }
}
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=hhh', 'root', 'root');
    $size=6;
    $where='1=1';
    if(!empty($where)){
        $where.=" and title like '%$search%'";
    }
//    echo $where;die;
    $sql="select * from list";
//    echo $sql;die;
    $rowCount=$dbh->query($sql);
    $count = $rowCount->rowCount();
//var_dump($count);
    $last = ceil($count/$size);
    $prev=$page-1<=1?1:$page+1;
    $next=$page+1>=$last?$last:$page+1;
    $limit=($page-1)*$size;
    $sql1="select * from list where $where order by 'id' limit $limit,$size";
    $stam=$dbh->query($sql1);
    $data=$stam->fetchAll(2);
    $arr=[
        'page'=>$page,
        'count'=>$count,
        'prev'=>$prev,
        'last'=>$last,
        'next'=>$next,
        'data'=>$data
    ];
    if($search==''){
        $redis->hSet('data2',"data2_$page",json_encode($arr));
    }else{
        $redis->hSet('data2',"data2_$page&$search",json_encode($arr));
    }
    if(count($arr)==0){
        $req =array('code'=>0,'code'=>'查询失败','data'=>$arr);
    }else{
        $req =array('code'=>1,'code'=>'查询成功','data'=>$arr);
    }

    echo json_encode($req);