<?php
namespace app;
use core\query\DB;
use core\lib\Cache;
use core\lib\Session;
use core\lib\Cookie;
use core\Work;

/**
 * 
 */
class Index
{
	/**
	 * [process 进程控制]
	 * ------------------------------------------------------------------------------
	 * @author  by.fan <fan3750060@163.com>
	 * ------------------------------------------------------------------------------
	 * @version date:2018-05-08
	 * ------------------------------------------------------------------------------
	 * @return  [type]          [description]
	 */
	public function process()
	{
		//总进程的数量
		$totals = 5;

		// 执行的脚本数量
		$param = array();

		// 执行的脚本数量的数组
		for ($i = 0; $i < $totals; $i++)
		{
		    $param[] = ['controller' =>'Index','action'=>'run','param'=>['pid'=>$i,'total' => $totals]];
		}
		
		Work::run($param);
	}

	/**
	 * [run 脚本执行]
	 * ------------------------------------------------------------------------------
	 * @author  by.fan <fan3750060@163.com>
	 * ------------------------------------------------------------------------------
	 * @version date:2018-05-08
	 * ------------------------------------------------------------------------------
	 * @return  [type]          [description]
	 */
	public function run($param=null)
	{
		/********* 查询 ************/
		//find查询
		// $result = DB::table('testuser')->find();
		// var_dump($result);
		
		//调试模式
		// $where = [];
		// $result = DB::table('testuser')->where($where)->debug()->find(); //返回sql

		//join连表查询
		// $where = [];
		// $result = DB::table('testuser')->alias('a')->join('apidoc b','a.id = b.docid','left')->where($where)->find();//两表
		// $join = [
		// 	['apidoc b','a.id = b.docid','left'],
		// 	['apilist c','b.docid = c.apiid','left'],
		// ];
		// $result = DB::table('testuser')->alias('a')->join($join)->find(); //三表查询

		// union查询
		// $union = array(
		// 	'select * from testuser',
		// 	'select * from testuser',
		// );
		// $result = DB::table('testuser')->alias('a')->union($union)->find(); //多表联合

		// select查询
		// $where = array();
		// $where['sex']  =  1;
		// $order = array();
		// $order['id']  = 'desc';
		// $order['sex'] = 'asc';
		// $limit = [0,10];
		// $group = ['id','sex'];
		// $result = DB::table('testuser')->where($where)->limit($limit)->select();

		/********* 插入数据 ************/
		// $data = array();
		// $data['name'] = 'update33233';
		// $data['sex']  = 1;
		// $result = DB::table('testuser')->insert($data);
		// var_dump($result);die;

		/********* 更新及事务 ************/
		// $data = array();
		// $data['name'] = 'update222';
		// $data['sex']  = 1;
		// $data['id']   = 42;

		// $bbb= array();
		// $bbb[] = $data;

		// DB::Transaction();//开启事务
		// $result = DB::table('testuser')->update($bbb); 
		// if($result)
		// {
		// 	DB::Commit();
		// }else{
		// 	DB::Rollback();
		// }
		// var_dump($result);die;

		/********* 删除 ************/
		// $result = DB::table('表名')->delete(主键id); //根据主键id删除

		// $where = [];
		// $where['id'] = 1;
		// $result = DB::table('表名')->where($where)->delete(); //根据条件删除
		
		/********* 文件缓存 Cache::drive()默认为file缓存************/
		// $a = Cache::drive()->set('key',array(1,2,3),10);
		// $b = Cache::drive()->get('key');
		// $c = Cache::drive()->has('key');
		// $d = Cache::drive()->delete('key');
		// var_dump($a,$b,$c,$d);die;

		/********* memcache缓存 ************/
		// $a = Cache::drive('memcache')->set('key',array(1,2,3),30);
		// $b = Cache::drive('memcache')->get('key');
		// $c = Cache::drive('memcache')->has('key');
		// $d = Cache::drive('memcache')->delete('key');
		// var_dump($a,$b,$c,$d);die;
		
		/********* redis缓存 ************/
		// $a = Cache::drive('redis')->set('key',array(array('a'=>123),2,3),30);
		// $b = Cache::drive('redis')->get('key');
		// $c = Cache::drive('redis')->has('key');
		// $d = Cache::drive('redis')->delete('key');
		// var_dump($a,$b,$c,$d);die;
		
		/********* input方法 ************/
		// $a = input();
		// var_dump($a);die;

		/********* config方法 ************/
		// $a = config();
		// $b = config('cache');
		// var_dump($a,$b);die;

		/********* session操作方法 ************/
		//session类
		// $a = Session::boot()->set('thistest',array(1,2,3));
		// $b = Session::boot()->get('thistest');
		// $c = Session::boot()->delete('thistest');
		// $d = Session::boot()->clear();
		// $e = Session::boot()->all();
		// var_dump($a,$b,$c,$d,$e);die;

		//session辅助函数
		// $a = session('thistest',array(1,2,3));
		// $b = session('thistest');
		// $c = session();
		// $d = session('');
		// $e = session('thistest','');
		// $f = session('thistest',null);
		// var_dump($a,$b,$c,$d,$e,$f);die;

		/********* cookie方法 ************/
		//cookie类
		// $a = Cookie::boot()->set('userinfo',array('12321'));
		// $b = Cookie::boot()->get('userinfo');
		// $d = Cookie::boot()->all();
		// $c = Cookie::boot()->delete('userinfo');
		// $e = Cookie::boot()->clear();
		// var_dump($a,$b,$c,$d,$e);die;

		//cookie辅助函数
		// $a = cookie('abc',123,20);
		// $b = cookie('abc');
		// $c = cookie();
		// $d = cookie('');
		// $e = cookie('abc','');
		// $f = cookie('abc',null);
		// var_dump($a,$b,$c,$d,$e,$f);die;
	}
}