<?php
class welcome extends controller{

    public function demo()
    {
        //实例化memcache
        $mem=new memcache();
        //连接memcache
        $mem->connect('127.0.0.1');

        //随机
        $sql="select i_ip from ip where i_id=".mt_rand(1,12);
        $res=M('ip_model')->pdo->query($sql)->fetch();
        //取出随机获取的ip 地址
        $ip_name=$res['i_ip'];
        echo $ip_name;echo "<pre>";


        $sql="select * from ip_num  where name='$ip_name'";
        $data=M('ip_num_model')->pdo->query($sql)->fetch();
        if(empty($data))
        {
            //入库
            $sql="insert into ip_num(name) value('$ip_name')";
            M('ip_num_model')->pdo->query($sql);
        }
        else
        {
              //如果存在该ip  访问量+1
            $sql="UPDATE ip_num set num=num+1 where name='$ip_name'";
            M('ip_num_model')->pdo->exec($sql);

        }



        //查出访问前三的数据
        $sql="select * from ip_num order by num desc limit 3";
        $item=md5($sql);
        //二次刷新清除一下
        $mem->delete($item);
        if(!$ip=$mem->get($item))
        {
             echo "读取数据库!";
            $ip=M('ip_num_model')->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $mem->set($item,$ip);

        }

        //赋值展示页面
        $this->assign('ip',$ip);
        $this->display();



    }
    public function cha()
    {
        $val=isset($_GET['val']) ? $_GET['val'] : '';
        $sql="select * from ip_num where name like '%$val%' limit 3";
        $ip=M('ip_num_model')->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                //赋值展示页面
        $this->assign('ip',$ip);
        $this->display('demo');
    }













}