<?php
use core\Config;
use core\filter\Filter;
use core\lib\Session;
use core\lib\Cookie;

if (!function_exists('config'))
{
    /**
     * [config 获取和设置配置参数]
     * ------------------------------------------------------------------------------
     * @author  by.fan <fan3750060@163.com>
     * ------------------------------------------------------------------------------
     * @version date:2018-01-04
     * ------------------------------------------------------------------------------
     * @param   string          $name  [参数名]
     * @param   [type]          $value [参数值]
     * @param   string          $range [作用域]
     * @return  [type]                 [description]
     */
    function config($name = '', $value = null, $range = '')
    {
        if (is_null($value) && is_string($name)) {
            return 0 === strpos($name, '?') ? Config::has(substr($name, 1), $range) : Config::get($name, $range);
        } else {
            return Config::set($name, $value, $range);
        }
    }
}

if (!function_exists('input'))
{
    /**
     * [input 获取输入数据 支持默认值和过滤]
     * ------------------------------------------------------------------------------
     * @author  by.fan <fan3750060@163.com>
     * ------------------------------------------------------------------------------
     * @version date:2018-01-04
     * ------------------------------------------------------------------------------
     * @param   string          $key    [获取的变量名]
     * @param   string          $filter [过滤方法 int,string,float,bool]
     * @return  [type]                  [description]
     */
    function input($key = '',$filter = '')
    {
        $param = json_decode(ARGV,true);
        unset($param[0]);
        unset($param[1]);
        sort($param);
        return $param;
    }
}

if (!function_exists('session'))
{
    /**
     * [session]
     * ------------------------------------------------------------------------------
     * @author  by.fan <fan3750060@163.com>
     * ------------------------------------------------------------------------------
     * @version date:2018-01-02
     * ------------------------------------------------------------------------------
     * @param   string          $key   [参数名]
     * @param   string          $value [参数值]
     * @return  [type]                 [description]
     */
    function session($key = null,$value = '_null')
    {

        if (is_null($key) || !$key)
        {
            return Session::boot()->all();
        }elseif($key && $value === '_null')
        {
            return Session::boot()->get($key);
        }elseif($key && $value !== '_null')
        {
            return Session::boot()->set($key,$value);
        }
    }
}

if (!function_exists('cookie'))
{
    /**
     * [cookie]
     * ------------------------------------------------------------------------------
     * @author  by.fan <fan3750060@163.com>
     * ------------------------------------------------------------------------------
     * @version date:2018-01-05
     * ------------------------------------------------------------------------------
     * @param   string          $key   [参数名]
     * @param   string          $value [参数值]
     * @param   integer         $time  [过期时间]
     * @return  [type]                 [description]
     */
    function cookie($key = null,$value = '_null',$time = 0)
    {
        if (is_null($key) || !$key)
        {
            return Cookie::boot()->all();
        }elseif($key && $value === '_null')
        {
            return Cookie::boot()->get($key);
        }elseif($key && $value !== '_null')
        {
            return Cookie::boot()->set($key,$value,$time);
        }
    }
}

if (!function_exists('echolog'))
{
    /**
     * [echolog]
     * ------------------------------------------------------------------------------
     * @author  by.fan <fan3750060@163.com>
     * ------------------------------------------------------------------------------
     * @version date:2018-01-05
     * ------------------------------------------------------------------------------
     * @param   string          $string   [内容]
     * @return  [type]                 [description]
     */
    function echolog($string = null)
    {
        if(is_array($string))
        {
            $string = var_export($string,TRUE).PHP_EOL;
        }
        echo '['.date('Y-m-d H:i:s').']：'.$string.PHP_EOL;
    }
}

if (!function_exists('import'))
{
    /**
     * [import 加载第三方类库]
     * ------------------------------------------------------------------------------
     * @Autor    by.fan
     * ------------------------------------------------------------------------------
     * @DareTime 2017-06-29
     * ------------------------------------------------------------------------------
     * @param    [type]     $folder [目录] 多级目录用'/'间隔
     * @param    [type]     $name   [名称]
     * @param    [type]     $class  [类]  可不填,不填为引入文件
     * @return   [type]             [description]
     *
     * 加载类库: import('PHPMailer','PHPMailerAutoload','PHPMailer')
     */
    function import($folder,$name,$class=null)
    {
        //参数处理
        if(!is_string($name)) return false;
        $file_path = $folder.'/'.$name.'.php';
        if(!file_exists($file_path)) return false;
        require_once($file_path);
        if(!class_exists($class)) return false;
        return new $class();//实例化模型
    }
}

