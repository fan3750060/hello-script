# Hello-Script
PHP 多进程脚本框架
=====

# 安装
	git clone https://github.com/fan3750060/hello-script.git


# 运行命令
	php script
~~~
╔╗╔╗ ╔╦╗  ╔══╗   ╔╗　　　　　
║╚╝╠═╣║╠═╗║══╬═╦╦╬╬═╦══╗
║╔╗║╩╣║║║║╠══║╠╣╔╣║║╠╗╔╝
╚╝╚╩═╩╩╩═╝╚══╩═╩╝╚╣╔╝╚╝　
                  ╚╝

The program run successfully
When you want to execute a script, be sure to have parameters and use '/' split controllers and methods!
Example: php script Index/run param1 param2 param3 ...
Version: 0.2.1
Author : fan3750060@163.com
~~~


# 目录结构
~~~
|--app					程序目录
│-----... 				(自定义脚本)
|--config 				配置目录
│--------config.php 			一般配置文件
│--------database.php 			数据库配置文件
|--core					框架核心目录
│------db				数据操作目录
│--------FileCache.php 			文件缓存操作类
│--------Memcache.php 			Memcache操作类
│--------Mypdo.php 			Mysql操作类
│--------Redis.php 			Redis操作类
│------filter				参数过滤目录(未来弃用)
│------------Filter.php 		参数过滤类
│------lib				类库目录
│---------Cache.php 			缓存操作类
│---------Cookie.php  			Cookie操作类(未来考虑弃用)
│---------Respones.php 			输出类(未来弃用)
│---------Session.php          		Session操作类(未来考虑弃用)
│------query 				数据执行操作类库
│-----------DB.php 			sql快捷操作类
│------App.php 				框架运行文件
│------Base.php 			框架基础文件
│------Common.php 			函数助手公共方法文件
│------Config.php 			框架配置文件
│------Loader.php 			框架自动加载文件
│------Route.php 			框架路由文件
│------Test.php 			框架版本(测试运行)文件
│------Work.php 			框架多进程文件
|--runtime 				框架运行时目录
│---------... 				(可配置缓存储存点)
│--vendor                		第三方类库目录（Composer）
|--script 				脚本入口文件
~~~

# 运行说明
~~~
	php script 控制器/方法 参数1 参数2 参数3

	PS: 
		控制器必须在app目录下建立,控制器文件名须与类名一致
		命令参数使用函数 input() 接收
~~~

# 多进程控制
~~~
	多进程依赖php的pcntl扩展,在windows下无法使用

	安装扩展
		# 通过pecl安装pcntl扩展
		sudo pecl install pcntl
		# 增加 extension=pcntl.so
		sodo vim /etc/php.ini
		# 检查扩展是否安装成功
		php -m | grep pcntl

	代码
		use core\Work;

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
	
	执行命令:
		php script Index/process

	PS:
		controller   脚本控制器
		action       脚本执行方法
		param        脚本传输参数

		windows系统下不支持
~~~


# 单进程控制
~~~
	public function run($param=null)
	{
		Do something...
	}

	执行命令:
		php script Index/run
~~~

# DB操作示例
~~~
	
	use core\query\DB;
	
	说明
		DB::table('表名','库名')

		PS: 库名非必填,默认数据库在 database.php 的 database 中配置

	单条查询
		$result = DB::table('表名')->find();

	调试模式
		$where = [];
		$result = DB::table('表名')->where($where)->debug()->find(); //返回sql

	join连表查询
		$where = [];
		$result = DB::table('表名1')
				->alias('a')
				->join('表名2 b','a.id = b.docid','left')
				->where($where)
				->find();//两表查询

		$join = [
			['表名2 b','a.id = b.docid','left'],
			['表名3 c','b.docid = c.apiid','left'],
		];
		$result = DB::table('表名1')->alias('a')->join($join)->find(); //三表查询

	union查询
		$union = array(
			'select * from 表1',
			'select * from 表2',
		);
		$result = DB::table('表3')->alias('a')->union($union)->find(); //多表联合

	多条查询
		$where = array();
		$where['sex']  =  1;

		$order = array();
		$order['id']  = 'desc';
		$order['sex'] = 'asc';

		$limit = [0,10];
		$group = ['id','sex'];
		$result = DB::table('表名')->where($where)->limit($limit)->select();

	插入数据
		$data = array();
		$data['name'] = 'update33233';
		$data['sex']  = 1;
		$result = DB::table('表名')->insert($data);

	更新及事务
		$data = array();
		$data['name'] = 'update222';
		$data['sex']  = 1;
		$data['id']   = 42;

		$bbb   = array();
		$bbb[] = $data;

		DB::Transaction();//开启事务
		$result = DB::table('表名')->update($bbb); 
		if($result)
		{
			DB::Commit();
		}else{
			DB::Rollback();
		}

	删除
		$result = DB::table('表名')->delete(主键id); //根据主键id删除

		$where = [];
		$where['id'] = 1;
		$result = DB::table('表名')->where($where)->delete(); //根据条件删除
~~~

# 缓存操作
~~~
	Cache::drive() 默认为file缓存
	
	set: 	设置缓存 参数1:缓存键名 参数2:数据 参数3:持续时间缓存值将过期的秒数,0表示永不过期
	get: 	获取缓存 参数1:缓存键名 如果值不在缓存中，则返回false
	has: 	是否存在 参数1:缓存键名 如果值不在缓存中，则返回false
	delete: 删除缓存 参数1:缓存键名 成功返回true,失败返回false

	文件缓存
		$a = Cache::drive()->set('key',[1,2,3],10);
		$b = Cache::drive()->get('key');
		$c = Cache::drive()->has('key');
		$d = Cache::drive()->delete('key');

	memcache缓存
		$a = Cache::drive('memcache')->set('key',[1,2,3],30);
		$b = Cache::drive('memcache')->get('key');
		$c = Cache::drive('memcache')->has('key');
		$d = Cache::drive('memcache')->delete('key');

	redis缓存
		$a = Cache::drive('redis')->set('key',[1,2,3],30);
		$b = Cache::drive('redis')->get('key');
		$c = Cache::drive('redis')->has('key');
		$d = Cache::drive('redis')->delete('key');
~~~


# 命令行参数接收
~~~
	命令:
		php script Index/process 213 123 2312
	
	接收:
		input()

	var_dump(input()); //返回数组
~~~


# 读取配置文件
~~~
	$a = config(); //获取全部配置
	$b = config('cache'); //根据keyh获取配置
~~~

# 运行输出
	echolog(); //可打印数组 

# 帮助命令
	列出app中脚本: php script --list 


# 其他
~~~
	session操作方法(将来或将弃用)
		$a = Session::boot()->set('key',[1,2,3]);
		$b = Session::boot()->get('key');
		$c = Session::boot()->delete('key');
		$d = Session::boot()->clear();
		$e = Session::boot()->all();


	session辅助函数(将来或将弃用)
		$a = session('key',[1,2,3]);
		$b = session('key');
		$c = session();
		$d = session('');
		$e = session('key','');
		$f = session('key',null);

	cookie方法(将来或将弃用)
		 $a = Cookie::boot()->set('key',[1,2,3]);
		 $b = Cookie::boot()->get('key');
		 $d = Cookie::boot()->all();
		 $c = Cookie::boot()->delete('key');
		 $e = Cookie::boot()->clear();

	cookie辅助函数(将来或将弃用)
		 $a = cookie('key',123,20);
		 $b = cookie('key');
		 $c = cookie();
		 $d = cookie('');
		 $e = cookie('key','');
		 $f = cookie('key',null);
	}
~~~

PS:
	数据操作类及缓存类有借鉴TP操作方式
