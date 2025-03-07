<?php

class Common
{

    public static function validUrl(): bool
    {
        try {
            $m = '';
            if (isset($_GET['m'])) {
                $m = $_GET['m'];
            }
            if (empty($m)) {
                app::$method = 'index';
                return app::$valid_url;
            }
            $m = str_replace('.html', '', $m);
            $params = explode('/', $m);
            if ($params[1] === 'content') {
                App::$method = 'content';
                App::$id = $params[2];
                return true;
            }
            if ($params[1] === 'search') {
                App::$method = 'search';
                $args = explode('_', $params[2]);
                App::$searchKey = $args[0];
                if (!empty($args[1])) {
                    App::$page = $args[1];
                }
                return true;
            }
            if ($params[1] === 'robots.txt') {
                App::$method = 'robots';
                return true;
            }
            if ($params[1] === 'sitemap.xml') {
                App::$method = 'map';
                App::$args['method'] = 'map_index';
                return true;
            }
            if ($params[1] === 'bdmap.xml') {
                App::$method = 'map';
                App::$args['method'] = 'map_grade';
                return true;
            }
            if (empty(App::$rute_match[$params[1]])) {
                return false;
            }
            if (App::$rute_match[$params[1]] === 'plots') {
                App::$method = 'story_index';
                App::$args['story_method'] = 'all';
                App::$args['vod_id'] = AppService::hexdecId($params[2]);
                return true;
            }
            if (App::$rute_match[$params[1]] === 'plot') {
                App::$method = 'story_index';
                App::$args['story_method'] = 'detail';
                $row = Db::selectOne('select * from mac_story where story_id=' . $params[2]);
                App::$args['vod_id'] = $row['vod_id'];
                App::$args['story_id'] = $params[2];
                return true;
            }
            if (App::$rute_match[$params[1]] === 'story') {
                App::$method = 'story';
                App::$typeId = 10;
                App::$args['page'] = 1;
                if (!empty($params[2])) {
                    App::$args['page'] = $params[2];
                }
                return true;
            }
            if (App::$rute_match[$params[1]]==='type') {
                App::$args['dir'] = $params[1];
                app::$typeId = App::$rute[$params[1]]['type_id'];
                app::$method = 'type';
                App::$args['type'] = $params[1];
                if (empty($params[2])) {
                    App::$args['class'] = '';
                    App::$args['area'] = '';
                    App::$args['year'] = '';
                    App::$args['page'] = 1;
                    return app::$valid_url;
                } else {
                    $args = explode('_', $params[2]);
                    App::$args['class'] = $args[0];
                    App::$args['area'] = $args[1];
                    App::$args['year'] = $args[2];
                    if (empty($args[3])) {
                        App::$args['page'] = 1;
                    } else {
                        App::$args['page'] = $args[3];
                    }
                    app::$method = 'type';
                }
                return true;
            }
            if (App::$rute_match[$params[1]] === 'details') {
                App::$method = 'detail';
                App::$id = AppService::hexdecId($params[2]);
                return true;
            }
            if (App::$rute_match[$params[1]] === 'relay') {
                App::$method = 'relay';
                $args = explode('-', $params[2]);
                App::$id = AppService::hexdecId($args[0]);
                App::$args['play_id'] = AppService::hexdecId($args[0]);
                App::$args['sid'] = $args[1];
                App::$args['nid'] = $args[2];
                return true;
            }
            if (App::$rute_match[$params[1]] === 'rank') {
                App::$method = 'rank';
                App::$id = $params[2];
                return true;
            }
            if (App::$rute_match[$params[1]] === 'last') {
                App::$method = 'last';
                return true;
            }
            if (App::$rute_match[$params[1]] === 'actor') {
                App::$method = 'actor';
                if (empty($params[2])) {
                    App::$args['page'] = 1;
                } else {
                    App::$args['page'] = $params[2];
                }
                App::$typeId = 7;
                return true;
            }
            if ($params[1] === 'trailer') {
                App::$method = 'info';
                App::$args['method'] = $params[1];
                App::$args['id'] = AppService::hexdecId($params[2]);
                return true;
            }
            if ($params[1] === 'theme') {
                App::$method = 'info';
                App::$args['method'] = $params[1];
                App::$args['id'] = AppService::hexdecId($params[2]);
                return true;
            }
            if (App::$rute_match[$params[1]] === 'star') {
                App::$method = 'star';
                App::$typeId = 7;
                App::$args['method'] = 'index';
                App::$args['id'] = $params[2];
                return true;
            }
            if (App::$rute_match[$params[1]] === 'starinfo') {
                App::$method = 'star';
                App::$typeId = 7;
                App::$args['method'] = 'detail';
                App::$args['id'] = $params[2];
                return true;
            }
            if (App::$rute_match[$params[1]] === 'starworks') {
                App::$method = 'star';
                App::$typeId = 7;
                App::$args['method'] = 'works';
                if (empty($params[2])){
                    return false;
                }
                $args = explode('-', $params[2]);
                App::$args['id'] = $args[0];
                App::$args['page'] = $args[1];
                return true;
            }
            return false;
        } catch (Exception $e) {
            app::$valid_url = false;
        }

        return app::$valid_url;
    }

    public static function getReqDomain($HTTP_HOST)
    {
        if (str_contains($HTTP_HOST, 'www.')) {
            return str_replace('www.', '', $_SERVER['HTTP_HOST']);
        }
        return $HTTP_HOST;
    }

    public static function saveSpiderLog($isNormal): void
    {
        $ip = self::getIP();
        $isSpider = self::isSpider($ip);
        if ($isSpider){
            $spider_key = 'spider:'.App::$full_url.'_'.time() .mt_rand(0, 1000);
            $jValue['domain'] = App::$full_url;
            $jValue['url'] = $_SERVER['REQUEST_URI'];
            $jValue['ip'] = $ip;
            $jValue['date'] = time();
            if ($isNormal){
                $jValue['code'] = '200';
            }else{
                $jValue['code'] = 'error';
            }
            $jValue['spider'] = 'baidu';
            Cache::set($spider_key,json_encode($jValue),60*60*24);
        }
    }
    public static function isSpider($ip): bool
    {
        $key = 'baidu_ip:' . $ip;
        $ip = Cache::get($key);
        if (!empty($ip)) {
            if ($ip == 1){
                return true;
            }
        }
        return false;
    }

    public static function getIP(): string
    {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim(current($arr));
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        return $long ? $ip : '0.0.0.0';
    }

    public static function getMillisecond(): string
    {
        list($mse, $sec) = explode(' ', microtime());
        $mse_time = (float)sprintf('%.0f', (floatval($mse) + floatval($sec)) * 1000);
        return substr($mse_time, 0, 13);
    }

    public static function getType(): array
    {
        return array (
            0 =>
                array (
                    'type_id' => '1',
                    'type_name' => '电视剧',
                    'type_en' => 'drama',
                    'type_sort' => '1',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => 'play.html',
                    'type_tpl_down' => 'down.html',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            1 =>
                array (
                    'type_id' => '2',
                    'type_name' => '电影',
                    'type_en' => 'film',
                    'type_sort' => '2',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => 'play.html',
                    'type_tpl_down' => 'down.html',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            2 =>
                array (
                    'type_id' => '3',
                    'type_name' => '动漫',
                    'type_en' => 'comics',
                    'type_sort' => '3',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => 'play.html',
                    'type_tpl_down' => 'down.html',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            3 =>
                array (
                    'type_id' => '4',
                    'type_name' => '综艺',
                    'type_en' => 'variety',
                    'type_sort' => '4',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => 'play.html',
                    'type_tpl_down' => 'down.html',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            4 =>
                array (
                    'type_id' => '5',
                    'type_name' => '纪录片',
                    'type_en' => 'documentary',
                    'type_sort' => '5',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => '',
                    'type_tpl_down' => '',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            5 =>
                array (
                    'type_id' => '6',
                    'type_name' => '微视频',
                    'type_en' => 'short',
                    'type_sort' => '6',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => '',
                    'type_tpl_down' => '',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            6 =>
                array (
                    'type_id' => '7',
                    'type_name' => '明星',
                    'type_en' => 'actor',
                    'type_sort' => '7',
                    'type_mid' => '8',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => '',
                    'type_tpl_down' => '',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
            7 =>
                array (
                    'type_id' => '8',
                    'type_name' => '剧情',
                    'type_en' => 'story',
                    'type_sort' => '8',
                    'type_mid' => '1',
                    'type_pid' => '0',
                    'type_status' => '1',
                    'type_tpl' => 'type.html',
                    'type_tpl_list' => 'show.html',
                    'type_tpl_detail' => 'detail.html',
                    'type_tpl_play' => '',
                    'type_tpl_down' => '',
                    'type_key' => '',
                    'type_des' => '',
                    'type_title' => '',
                    'type_union' => '',
                    'type_extend' => '',
                    'type_logo' => '',
                    'type_pic' => '',
                    'type_jumpurl' => '',
                ),
        );
    }
}