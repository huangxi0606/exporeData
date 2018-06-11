<?php
error_reporting(0);
set_time_limit(0);
$start_time = time();
ini_set('memory_limit','10240M');
$mysql = new mysqli('127.0.0.1', 'data', 'root');
$mysql -> select_db("data");
$mysql -> set_charset("utf8");
$file = fopen("ceshi.txt", "r");
$line = count(file('ceshi.txt'));
$max =floor($line/1000)*1000;
$user = array();
$i = 0;
//输出文本中所有的行，直到文件结束为止。
$res = $mysql -> query("select * from data");
$filds = $res ->fetch_fields();
$sql = "insert into data (`";

foreach ($filds as $field)
{
    if ($field -> name != 'id')
        $sql .= $field -> name . "`,`";
}
$sql = trim(trim($sql , "`"),",") . ") values ";
$values = "";
$i=1;
$h=0;
while (!feof($file)) {
    $user[$i] = fgets($file);//fgets()函数从文件指针中读取一行

	$h =$h+1;
    // $data =explode('|', $user[$i]);
    $data =array_slice(explode('|', $user[$i]), 1);
      // var_dump($data);exit;
    $values .= "('";
    foreach ($data as $item)
    {
//        $item = iconv("gbk","utf-8");
        $values .=  trim($item) . "','";
    }
     $values = substr($values,0,strlen($values) - 2) . "),";
    if($i >$max||$i % 1000 == 0){
        $values = rtrim($values,",");
        $mysql -> query($sql . $values);
        // if($mysql->error){
            // var_dump($mysql->error); 
            // var_dump($i);
        // }     
        $values = ""; 
    }
    $i++;


}
fclose($file);
echo "++++++++++++++++++++++++++++++\n";
$leng = time() - $start_time;
echo "耗时: {$leng} \n";
echo "导入数据个数: {$h}\n";
