<?php
/**
* 
*/
class Db
{
	private $host;
	private $user;
	private $userpwd;
	private $dbh;
	function __construct($host,$user,$userpwd)
	{
		$this->host = $host;
		$this->user = $user;
		$this->userpwd = $userpwd;
		$this->dbh = new PDO("mysql:host=$this->host;dbname=hhh", $user, $userpwd);
	}
	public function insertData($table,$data)
	{
		if ($table==''||$data=='') {
			return false;
		}
		$file='';
		$val='';
		foreach ($data as $key => $value) {
			$file .=",$key";
			$val .= ",$value";
		}
		$file = substr($file,1);
		$val = substr($val,1);
		$sql = "insert into $table($file) values($val)";
		return $this->dbh->exec($sql);
	}
	public function getOne($table,$where)
	{
		$sql = "select * from $table where $where";

		$res = $this->dbh->query($sql);

		return $res->fetch(2);
	}
	public function getAll($table)
	{
		$sql = "select * from $table ";

		$res = $this->dbh->query($sql);

		return $res->fetchAll(2);
	}
	public function upData($table,$data,$where)
	{
		if ($table==''||$data=='') {
			return false;
		}
     	$val='';
     	foreach ($data as $key => $value) {
		    $val.=",`$key`='$value'";
		}
		// echo $val;
		$val = substr($val,1);
		$sql="update $table set $val";
		return $this->dbh->exec($sql);
	}
	public function del($table,$where)
	{
		
		if ($table==''||$where=='') {
			return false;
		}
     	$sql="delete from $table where $where";

		return $this->dbh->exec($sql);
	}
}
//$db = new Db('127.0.0.1','root','root');
// $data = array("name"=>'一起搜索','price'=>50);
// var_dump($db->insertData('list',$data));
// var_dump($db->getOne('list','1=1'));
// var_dump($db->getAll('list'));
// var_dump($db->upData('list',$data,1));
//var_dump($db->del('list','3=3'));