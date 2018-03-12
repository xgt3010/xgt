<?php


class view{

	public $param;
	public $config;

	public function __construct(){
		$this->config = require CONFIG_DIR."/config.php";
	}

	//渲染变量
	public function assign($key = "", $val = ""){
		$this->param[$key] = $val;

	}

	//加载页面
	public function display($html= "", $data = array())
	{

		//合并渲染的数据
		if(!empty($data)) $data = array_merge($this->param,$data);

		//获取视图路径
		$dir = CONTROLLER_NAME;
		$file = empty($html) ? ACTION_NAME : $html;

		//生成视图路径
		$file_name = VIEW_DIR.'/'.$dir .'/'.$file.'.html';

		//验证视图是否存在
		if(!file_exists($file_name)){
			die('<h1 align="center">404 找不到视图 '.$file.'.html</h1>');
		}

		//制作渲染的变量
		foreach($this->param as $key=>$val)
		{
			$$key = $val;
		}
		//开启缓冲区
		ob_start();
		include $file_name;
		$html = ob_get_clean();


		//判断是否开启模板布局
		if($this->config['layout_on']){

			//公共模板布局视图路径
			$layout_html = VIEW_DIR.'/'.$this->config['layout_html'].'.html';

			//验证模板布局文件是否存在
			if(!file_exists($layout_html)){
				die('<h1 align="center">404 找不到公共模板文件 '.$this->config['layout_html'].'</h1>');
			}

			include $layout_html;
		}else{
			echo $html;
		}
	}
}
