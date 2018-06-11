<?php
//error_reporting(0);
set_time_limit(0);
$start_time = time();
ini_set('memory_limit','10240M');
$mysql = new mysqli('127.0.0.1', 'root', 'HZwPWpf54i');
$mysql -> select_db("data");
$mysql -> set_charset("utf8");
$file = "ceshi.txt";
$real_path = addslashes(realpath($file));
// 忽略重复
// $sql = 'load data infile "' . $real_path .'" ignore into table data FIELDS TERMINATED BY "|" Lines Terminated By "\r\n"';
// 替换重复
$sql = 'load data infile "' . $real_path .'" replace into table data FIELDS TERMINATED BY "|" Lines Terminated By "\r\n"';
$mysql -> query($sql);
$first ='alter table data drop column id';
$mysql->query($first);
$second ='alter table `data` add column id int auto_increment not null first, add primary key(id)';
$mysql->query($second);
echo "++++++++++++++++++++++++++++++\n";
$leng = time() - $start_time;
echo "耗时: {$leng} \n";
echo "完成";
