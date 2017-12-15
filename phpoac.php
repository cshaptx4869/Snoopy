<?php
//采集php开源网
set_time_limit(0);
require_once("Snoopy.class.php");
$snoopy=new Snoopy();
//登陆论坛
$submit_url = "http://www.phpoac.com/bbs/logging.php?action=login";
$submit_vars["loginmode"] = "normal";
$submit_vars["styleid"] = "1";
$submit_vars["cookietime"] = "315360000";
$submit_vars["loginfield"] = "username";
$submit_vars["username"] = "***"; //你的用户名
$submit_vars["password"] = "*****"; //你的密码
$submit_vars["questionid"] = "0";
$submit_vars["answer"] = "";
$submit_vars["loginsubmit"] = "提 交";
$snoopy->submit($submit_url,$submit_vars);
if ($snoopy->results)
{
    //获取连接地址
    $snoopy->fetchlinks("http://www.phpoac.com/bbs");
    $url=array();
    $url=$snoopy->results;
    //print_r($url);
    foreach ($url as $key=>$value)
    {
        //匹配http://www.phpoac.com/bbs/forumdisplay.php?fid=156&sid=VfcqTR地址即论坛板块地址
        if (!preg_match("/^(http:\/\/www\.phpoac\.com\/bbs\/forumdisplay\.php\?fid=)[0-9]*&sid=[a-zA-Z]{6}/i",$value))
        {
            unset($url[$key]);
        }
    }
    //print_r($url);
    //获取到板块数组$url，循环访问，此处获取第一个模块第一页的数据
    $i=0;
    foreach ($url as $key=>$value)
    {
        if ($i>=1)
        {
            //测试限制
            break;
        }
        else
        {
            //访问该模块，提取帖子的连接地址，正式访问里需要提取帖子分页的数据，然后根据分页数据提取帖子数据
            $snoopy=new Snoopy();
            $snoopy->fetchlinks($value);
            $tie=array();
            $tie[$i]=$snoopy->results;
            //print_r($tie);
            //转换数组
            foreach ($tie[$i] as $key=>$value)
            {
                //匹配http://www.phpoac.com/bbs/viewthread.php?tid=68127&extra=page=1&page=1&sid=iBLZfK
                if (!preg_match("/^(http:\/\/www\.phpoac\.com\/bbs\/viewthread\.php\?tid=)[0-9]*&extra=page\=1&page=[0-9]*&sid=[a-zA-Z]{6}/i",$value))
                {
                    unset($tie[$i][$key]);
                }
            }
            //print_r($tie[$i]);
            //归类数组，将同一个帖子不同页面的内容放一个数组里
            $left='';//连接左边公用地址
            $j=0;
            $page=array();
            foreach ($tie[$i] as $key=>$value)
            {
                $left=substr($value,0,52);
                $m=0;
                foreach ($tie[$i] as $pkey=>$pvalue)
                {
                    //重组数组
                    if (substr($pvalue,0,52)==$left)
                    {
                        $page[$j][$m]=$pvalue;
                        $m++;
                    }
                }
                $j++;
            }
            //去除重复项开始
            //$page=array_unique($page);只能用于一维数组
            $paget[0]=$page[0];
            $nums=count($page);
            for ($n=1;$n <$nums;$n++)
            {
                $paget[$n]=array_diff($page[$n],$page[$n-1]);
            }
            //去除多维数组重复值结束
            //去除数组空值
            unset($page);
            $page=array();//重新定义page数组
            $page=array_filter($paget);
            //print_r($page);
            $u=0;
            $title=array();
            $content=array();
            $temp='';
            $tt=array();
            foreach ($page as $key=>$value)
            {
                //外围循环，针对一个帖子
                if (is_array($value))
                {
                    foreach ($value as $k1=>$v1)
                    {
                        //页内循环，针对一个帖子的N页
                        $snoopy=new Snoopy();
                        $snoopy->fetch($v1);
                        $temp=$snoopy->results;
                        //读取标题
                        if (!preg_match_all("/ <h2>(.*) <\/h2>/i",$temp,$tt))
                        {
                            echo "no title";
                            exit;
                        }
                        else
                        {
                            $title[$u]=$tt[1][1];
                        }
                        unset($tt);
                        //读取内容
                        if (!preg_match_all("/ <div id=\"postmessage_[0-9]{1,8}\" class=\"t_msgfont\">(.*) <\/div>/i",$temp,$tt))
                        {
                            print_r($tt);
                            echo "no content1";
                            exit;
                        }
                        else
                        {
                            foreach ($tt[1] as $c=>$c2)
                            {
                                $content[$u].=$c2;
                            }
                        }
                    }
                }
                else
                {
                    //直接取页内容
                    $snoopy=new Snoopy();
                    $snoopy->fetch($value);
                    $temp=$snoopy->results;
                    //读取标题
                    if (!preg_match_all("/ <h2>(.*) <\/h2>/i",$temp,$tt))
                    {
                        echo "no title";
                        exit;
                    }
                    else
                    {
                        $title[$u]=$tt[1][1];
                    }
                    unset($tt);
                    //读取内容
                    if (!preg_match_all("/ <div id=\"postmessage_[0-9]*\" class=\"t_msgfont\">(.*) <\/div>/i",$temp,$tt))
                    {
                        echo "no content2";
                        exit;
                    }
                    else
                    {
                        foreach ($tt[1] as $c=>$c2)
                        {
                            $content[$u].=$c2;
                        }
                    }
                }
                $u++;
            }
            print_r($content);
        }
        $i++;
    }
}
else
{
    echo "login failed";
    exit;
}
? >