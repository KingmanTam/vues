<?php

class Domain
{

    public static function setInfo($domain): void
    {
        $domains = self::getDomain();
        $v = $domains[$domain];
        if (!empty($v)) {
            app::$domain['title'] = $v['title'];
            app::$domain['domain'] = $v['domain'];
            app::$domain['name'] = $v['name'];
            app::$domain['keywords'] = $v['keywords'];
            app::$domain['description'] = $v['description'];
            app::$domain['template'] = $v['template'];
            app::$domain['vod_rank_id'] = $v['vod_rank_id'];
            app::$domain['story_rank_id'] = $v['story_rank_id'];
            app::$domain['offset'] = $v['offset'];
            app::$domain['inc'] = $v['inc'];
            app::$domain['cacheId'] = $v['cacheId'];
        }
    }

    public static function getDomain(): array
    {
        return array(
            "mercurya.com" => array(
                'title' => '知鸟影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'mercurya.com',
                'name' => '知鸟影视',
                'keywords' => '知鸟影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '知鸟影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13110,24560,33380,37210,41530,54530,62530,68530,74530,81530',
                'story_rank_id' => '3908,11891,20625,36195,44088,53485,61148,76338,82075,92824',
                'offset' => 1,
                'inc' => 7000000,
                'cacheId' => 'mercurya'
            ),
            "zhiliaoshanqi.com" => array(
                'title' => '知鸟影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'zhiliaoshanqi.com',
                'name' => '知鸟影视',
                'keywords' => '知鸟影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '知鸟影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13110,24560,33380,37210,41530,54530,62530,68530,74530,81530',
                'story_rank_id' => '3908,11891,20625,36195,44088,53485,61148,76338,82075,92824',
                'offset' => 1,
                'inc' => 4500000,
                'cacheId' => 'zhiliaoshanqi'
            ),
            "xishufang.com" => array(
                'title' => '书房影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'xishufang.com',
                'name' => '书房影视',
                'keywords' => '书房影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '书房影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13111,24561,33381,37211,41531,54531,62531,68531,74531,81531',
                'story_rank_id' => '1964,13246,29381,34408,48592,59714,66640,75623,83291,99406',
                'offset' => 2,
                'inc' => 5000000,
                'cacheId' => 'xishufang'
            ),
            "yangniujidi.com" => array(
                'title' => '洋洋影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'yangniujidi.com',
                'name' => '洋洋影视',
                'keywords' => '洋洋影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '洋洋影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13112,24562,33382,37212,41532,54532,62532,68532,74532,81532',
                'story_rank_id' => '4109,12040,29085,37809,43182,54161,61940,78121,83987,97336',
                'offset' => 3,
                'inc' => 5500000,
                'cacheId' => 'yangniujidi'
            ),
            "xzystdp.com" => array(
                'title' => '章鱼影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'xzystdp.com',
                'name' => '章鱼影视',
                'keywords' => '章鱼影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '章鱼影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13117,24567,33387,37217,41537,54537,62537,68537,74537,81537',
                'story_rank_id' => '8527,17611,23677,39521,48141,50468,61569,70928,85544,92490',
                'offset' => 4,
                'inc' => 6000000,
                'cacheId' => 'xzystdp'
            ),
            "gongtingyufang.com" => array(
                'title' => '宫廷影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'gongtingyufang.com',
                'name' => '宫廷影视',
                'keywords' => '宫廷影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '宫廷影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13118,24568,33388,37218,41538,54538,62538,68538,74538,81538',
                'story_rank_id' => '2149,19713,26381,32994,46210,55367,67300,72822,84668,96415',
                'offset' => 5,
                'inc' => 6500000,
                'cacheId' => 'gongtingyufang'
            ),
            "yilidianti.com" => array(
                'title' => '屹立影视-2023最新电视剧-高清影视-最新电影电视剧综艺在线观看',
                'domain' => 'yilidianti.com',
                'name' => '屹立影视',
                'keywords' => '屹立影视,超清影视,最新电影在线观看,最新最热门免费电影电视剧,最新一期综艺,免费电影网',
                'description' => '屹立影视为您提供2023最新最热门的电视剧、电影大全、电视剧大全免费在线观看和迅雷电影免费下载，每天更新最新抢先电影大片，热门电视剧，最新综艺真人秀，明星信息与相关电影电视剧，同时提供影视剧情、电视剧演员表等相关内容',
                'template' => 'template/',
                'vod_rank_id' => '13119,24569,33389,37219,41539,54539,62539,68539,74539,81539',
                'story_rank_id' => '1180,17118,21247,36368,48348,54147,61683,79490,85123,96751',
                'offset' => 6,
                'inc' => 7000000,
                'cacheId' => 'yilidianti'
            ),
        );
    }
}