<?php
/**
 * @param $month
 * @param $day
 * @return bool
 * 十二星座
 */
function getConstellation($month, $day)
{
    // 检查参数有效性
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31)
    {
        return (false);
    }
    //   ‘Capricorn’, ‘Aquarius’, ‘Pisces’, ‘Aries’, ‘Taurus’, ‘Gemini’,
    //     ‘Cancer’,'Leo’, ‘Virgo’, ‘Libra’, ‘Scorpio’, ‘Sagittarius’
    // 星座名称以及开始日期
    $signs = array(
        array( "20" => "水瓶座|aquarius"),
        array( "19" => "双鱼座|pisces"),
        array( "21" => "白羊座|aries"),
        array( "20" => "金牛座|taurus"),
        array( "21" => "双子座|gemini"),
        array( "22" => "巨蟹座|cancer"),
        array( "23" => "狮子座|leo"),
        array( "23" => "处女座|virgo"),
        array( "23" => "天秤座|libra"),
        array( "24" => "天蝎座|scorpio"),
        array( "22" => "射手座|sagittarius"),
        array( "22" => "摩羯座|capricorn")
    );
    list($sign_start, $sign_name) = each($signs[(int)$month-1]);
    if ($day < $sign_start)
    {
        list($sign_start, $sign_name) = each($signs[($month -2 < 0) ? $month = 11: $month -= 2]);
    }
    return $sign_name;
}