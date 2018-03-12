<?php

function M($table_name){
	//model对象集合
	static $model_info = array();

	if(!isset($model_info[$table_name])){
		//验证model文件是否存在
		//验证model类是否存在

		//引入model文件
		include MODEL_DIR."/".$table_name.'.php';

		//实例化要调用的model
		$model_info[$table_name] = new $table_name;
	}

	return $model_info[$table_name];
}


function __autoload($class)
{

	include ROOT_DIR."/lib/".$class.'.php';
}

//接口
    function show($data)
    {
        $type=array('json','xml');
        $format= isset($_GET['format']) && in_array($_GET['format'],$type) ? $_GET['format'] : 'json';
        switch ($format)
        {
            case 'json' :_json($data);break;
            case 'xml'  :xml($data);break;
        }
    }

    function _json($data)
    {
        $data= json_encode($data);
        $param='';
        if(isset($_GET['jsonp']) && !empty($_GET['jsonp']))
        {
            $param = $_GET['jsonp'].'('.$data.')';
        }
        echo $param ? $param : $data;
    }
    function xml($data)
    {
        echo "xml";
    }





    function p($data)
    {
        dump($data);die;
    }
    //跳转方法
    function jump($wechat,$url)
    {
        echo "<script>alert('".$wechat."');location.href='".$url."'</script>";
    }
    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return void|string
     */
    function dump($var, $echo=true, $label=null, $strict=true)
    {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }