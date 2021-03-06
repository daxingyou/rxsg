<?php
/**
 * @inform 运营接口 -- 及时数据恢复 --充值人数
 * @author 张昌彪
 * @param null
 * @return 
 * @example  
 */
if (!defined("MANAGE_INTERFACE"))
exit;
try {
	//参数判断
	if (isset($day) && !empty($day)) //如果有某一天的值传递，就返回当天的最高在线
	{
		if($day > time()){
			throw new Exception('date error');
		}
		if (!isset($distance) || empty($distance)) {
			$distance = 24;
		}
		$spacetime = 86400 / $distance;
		for ($i = 1; $i < $distance+1; $i++) {
			$result = sql_fetch_one_cell("select count(distinct(passport)) from pay_log where time>$day and time < ($day + $spacetime*$i)");
			if (empty($result)){$result=0;}
			$pay_num[] = $result;
		}
		if (mysql_error()) {
			throw new Exception(mysql_error());
		}
		$ret['content']['pay_num'] = $pay_num;
	}
}
catch (exception $e) {
	$ret['error'] = $e->getMessage();
}






?>