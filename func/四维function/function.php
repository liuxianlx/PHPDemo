<?php

/**
 * 根据配置类型解析配置
 * @param  string $type  配置类型
 * @param  string  $value 配置值
 */
function parse_attr($value, $type = ''){
    switch ($type) {
        default: //解析"1:1\r\n2:3"格式字符串为数组
            $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
            if(strpos($value,':')){
                $value  = array();
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            }else{
                $value = $array;
            }
            break;
    }
    return $value;
}

/**
 * 字符串截取(中文按2个字符数计算)，支持中文和其他编码
 * @static
 * @access public
 * @param str $str 需要转换的字符串
 * @param str $start 开始位置
 * @param str $length 截取长度
 * @param str $charset 编码格式
 * @param str $suffix 截断显示字符
 * @return str
 */
function get_str($str, $start, $length, $charset='utf-8', $suffix=true) {
    $str = trim($str);
    $length = $length * 2;
    if($length){
        //截断字符
        $wordscut = '';
        if(strtolower($charset) == 'utf-8'){
            //utf8编码
            $n = 0;
            $tn = 0;
            $noc = 0;
            while($n < strlen($str)){
                $t = ord($str[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)){
                    $tn = 1;
                    $n++;
                    $noc++;
                }elseif(194 <= $t && $t <= 223){
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                }elseif(224 <= $t && $t < 239){
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                }elseif(240 <= $t && $t <= 247){
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                }elseif(248 <= $t && $t <= 251){
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                }elseif($t == 252 || $t == 253){
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                }else{
                    $n++;
                }
                if ($noc >= $length){
                    break;
                }
            }
            if($noc > $length){
                $n -= $tn;
            }
            $wordscut = substr($str, 0, $n);
        }else{
            for($i = 0; $i < $length - 1; $i++){
                if(ord($str[$i]) > 127) {
                    $wordscut .= $str[$i].$str[$i + 1];
                    $i++;
                } else {
                    $wordscut .= $str[$i];
                }
            }
        }
        if($wordscut == $str){
            return $str;
        }
        return $suffix ? trim($wordscut).'...' : trim($wordscut);
    }else{
        return $str;
    }
}

/**
 * 获取所有数据并转换成一维数组
 */
function select_list_as_tree($model, $map = null, $extra = null){
    //获取列表
    $con['status'] = array('eq', 1);
    if($map){
        $con = array_merge($con, $map);
    }
    $list = D($model)->where($con)->select();
    $pk   = D($model)->getPk();

    //转换成树状列表(非严格模式)
    $tree = new \Common\Util\Tree();
    $list = $tree->toFormatTree($list, 'title', $pk, 'pid', 0, false);

    if($extra){
        $result[0] = $extra;
    }

    //转换成一维数组
    foreach($list as $val){
        $result[$val[$pk]] = $val['title_show'];
    }
    return $result;
}

/**
 * 获取上传文件路径
 * @param  int $id 文件ID
 * @return string
 */
function get_cover($id = 0, $type = 'avatar'){
    $id = $id === NULL ? 0 : intval($id);
    
    $cache_name = 'upload_'.$id;
    $url = S($cache_name);
    if($url){
        return $url;
    }
    
    $upload_info = D('PublicUpload')->find($id);
    $url = $upload_info['real_path'];
    if(!$url){
        switch($type){
            case 'default' : //默认图片
                $url = C('TMPL_PARSE_STRING.__PUBLIC__').'/logo/default.gif';
                break;
            case 'avatar' : //用户头像
                $url = C('TMPL_PARSE_STRING.__PUBLIC__').'/avatar/avatar'.rand(1,7).'.png';
                break;
            default: //文档列表默认图片
                break;
        }
    }else{
        S($cache_name, $url);
    }
    
    return $url;
}

/**
 * 是否是pjax请求
 */
function is_pjax(){
    return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];    
}

/**
 * 数据签名
 */
function data_auth_sign($data){
    if(!is_array($data)){
        $data = (array) $data;
    }
    ksort($data);
    $code = http_build_query($data);
    $sign = sha1($code);
    return $sign;
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 */
function password_md5($str, $auth_key = ''){
    if(!$auth_key){
        $auth_key = C('AUTH_KEY');
    }
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 */
function time_format($time = NULL, $format='Y-m-d H:i:s'){
    $time = $time === NULL ? time() : intval($time);
    return date($format, $time);
}

/**
 * TODO
 * @param string $name
 * @return string
 */
function slug_format($name){
    return $name;
}

/**
 * @param string|array $ids
 * @return array:
 */
function ids_format($ids){
    if(is_array($ids)){
        return array_unique(array_map('trim', $ids));
    }else{
        $ids = str_replace('，', ',', $ids);
        $ids = explode(',', $ids);
        return array_unique(array_map('trim', $ids));
    }
}

/**
 * 加密+解密
 * @param integer|string $str
 * @return string|integer
 */
function sharecode($str){
	if(is_numeric($str)){//encode,加密时需要传入手机号+id号，如：134023672231，即：mob=13402367223,id=1
        $str=time().'1'.$str;
		$rndstr=base64_encode($str);
		$pre_fix=substr($rndstr,0,2);
		$suf_fix=substr($rndstr,-3);
		$id=substr($str,11);
		$code=$pre_fix.base64_encode('['.$id.']').$suf_fix;
		return $code;
	}else{//decode
		$true_code=base64_decode(substr($str,2,-3));
		$id=substr($true_code,1,-1);
		return $id;
	}
}

function time_diff($difference){
    $_second = 1;
    $_minute = $_second * 60;
    $_hour   = $_minute * 60;
    $_day    = $_hour * 24;
    
    $days    = floor($difference/$_day);
    $hours   = floor(($difference%$_day)/$_hour);
    $minutes = floor(($difference%$_hour)/$_minute);
    $seconds = floor(($difference%$_minute)/$_second);
    
    $str = '';
    if($days){
        $str .= $days.'天';
    }
    if($hours){
        $str .= $hours.'小时';
    }
    if($minutes){
        $str .= $minutes.'分钟';
    }
    if($seconds){
        $str .= $seconds.'秒';
    }
    return $str;
}

function get_config_class($id = null){
    $list = C('CLASS');
    return $id === null ? $list : $list[$id];
}
