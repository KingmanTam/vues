<?php

class DetailService
{
    /**
     * @throws Exception
     */
    public function load(): void
    {
        AppService::load();
        $this->setDetails();
    }

    /**
     * @throws Exception
     */
    public function setDetails(): void
    {
        $row = Cache::get('vod:vod_'.App::$id);
        if (empty($row)){
            $row = Db::selectOne('select * from mac_vod where vod_id=' . App::$id);
            Cache::set('vod:vod_'.App::$id,json_encode($row));
        }else{
            $row = json_decode($row,true);
        }
        if (empty($row)){
            throw new Exception('资源未找到！');
        }
        $params = array();
        if ($row['type_id'] == 6){
            $params['title'] = $row['vod_name'].'_'.$row['vod_class'].' '.App::$domain['name'];
            $params['keywords'] = $row['vod_name'];
        }else if ($row['type_id'] == 1 or $row['type_id'] == 4){
            $params['title'] = '《'.$row['vod_name'].'》高清版全集免费在线观看-'.$row['vod_area'].$row['vod_class'].App::$type_name[$row['type_id']].' '.App::$domain['name'];
            $params['keywords'] = $row['vod_name'].'剧情简绍,'.$row['vod_name'].'免费下载,'.$row['vod_name'].'高清资源';
        }else{
            $params['title'] = '《'.$row['vod_name'].'》'.$row['vod_remarks'].'免费在线观看-'.$row['vod_area'].$row['vod_class'].App::$type_name[$row['type_id']].' '.App::$domain['name'];
            $params['keywords'] = $row['vod_name'].'剧情简绍,'.$row['vod_name'].'免费下载,'.$row['vod_name'].'高清资源';
        }
        $params['des'] = App::$domain['name'].'提供你喜欢的'.$row['vod_name'].'剧情:'.$row['vod_blurb'];
        AppService::setSEO($params);
        AppService::assign('vod_name',$row['vod_name']);
        AppService::assign('vod_pic',$row['vod_pic']);
        AppService::assign('vod_id',AppService::dechexId($row['vod_id']));
        AppService::assign('type_id',$row['type_id']);
        AppService::assign('vod_score',$row['vod_score']);
        AppService::assign('type_name',App::$type_name[$row['type_id']]);
        AppService::assign('type_url',App::$type[$row['type_id']]);
        AppService::assign('vod_remarks',$row['vod_remarks']);
        AppService::assign('vod_actor',$row['vod_actor']);
        AppService::assign('vod_year',$row['vod_year']);
        AppService::assign('vod_class',$row['vod_class']);
        AppService::assign('vod_director',$row['vod_director']);
        AppService::assign('vod_area',$row['vod_area']);
        AppService::assign('vod_duration',$row['vod_duration']);
        AppService::assign('vod_lang',$row['vod_lang']);
        AppService::assign('vod_year',$row['vod_year']);
        AppService::assign('vod_time',date('Y-m-d',$row['vod_time']));
        AppService::assign('vod_blurb',$row['vod_blurb']);
        AppService::assign('vod_content',$row['vod_content']);
        $detail = $row['vod_name'].'是由'.$row['vod_area'].'导演'.$row['vod_director'].'执导的'.$row['vod_class'].App::$type_name[$row['type_id']];
        AppService::assign('detail',$detail);
        $play_from = $row['vod_play_from'];
        $fromList = explode('$$$', $play_from);
        $play_from_html = '';
        $play_from_html1 = '';
        $count = 1;
        foreach ($fromList as $f){
            $active = 0;
            if ($count==1){
                $active = 4;
                App::$content = str_replace('{mv:current_from}', $f,App::$content);
            }
            $from_html = '<li class="hidden-xs '.AppService::getActive($active).'">
                        <a class="gico '.$f.'" href="#con_playlist_'.$count.'" data-toggle="tab">'.App::$player_name[$f].'</a></li>';
            $from_html1 = '<li><a class="gico '.$f.'" href="#con_playlist_'.$count.'" tabindex="-1" data-toggle="tab">'.App::$player_name[$f].'</a></li>';
            $count++;
            $play_from_html.=$from_html;
            $play_from_html1.=$from_html1;
        }
        AppService::assign('play_from',$play_from_html);
        AppService::assign('play_from1',$play_from_html1);
        $play_url = $row['vod_play_url'];
        $play_url_arr = explode('$$$',$play_url);
        $count = 1;
        $url_html = '';
        $f_dir = App::$type[$row['type_id']];
        foreach ($play_url_arr as $urls){
            $active = 0;
            if ($count==1){
                $active = 4;
            }
            $play_url_list = explode('#',$urls);
            $play_url_html = '<ul class="clearfix fade in '.AppService::getActive($active).'" id="con_playlist_'.$count.'">';
            $nid_num=1;
            foreach ($play_url_list as $item) {
                $p=[
                    'dir'=>$f_dir,
                    'vod_id'=>$row['vod_id'],
                    'vod_en'=>$row['vod_en'],
                    'sid'=>$count,
                    'nid'=>$nid_num,
                ];
                $js = explode('$', $item);
                $item_html = '<li><a href="'.AppService::getLink(5,$p).'" >'.$js[0].'</a></li>';
                $play_url_html.=$item_html;
                $nid_num++;
            }
            $play_url_html.='</ul>';
            $count++;
            $url_html.=$play_url_html;
        }
        $this->setStar($row['vod_douban_id']);
        App::$content = str_replace('{mv:play_url}', $url_html,App::$content);
        $this->setStory($row['vod_plot']);
        $this->setComment($row);
        $this->setRecommend();
    }
    /**
     * @throws Exception
     */
    public function setStar($starId): void
    {
        $key = 'star:star_rmd_'.$starId;
        $star_list = Cache::get($key);
        if (!empty($star_list)){
            $rows = json_decode($star_list,true);
        }else{
            $rows = Db::selectAll('select * from mac_actor where actor_id<=' . $starId.' ORDER BY actor_id desc LIMIT 3');
            $data = array();
            foreach ($rows as $row){
                $one = array();
                $one['actor_pic'] = $row['actor_pic'];
                $one['actor_id'] = $row['actor_id'];
                $one['actor_name'] = $row['actor_name'];
                array_push($data,$one);
            }
            Cache::set($key,json_encode($data),App::$redis['timeout_l']);
        }
        $hot_star_html = '';
        foreach ($rows as $row){
            $hot_star_html.='<li class="col-md-4 col-sm-4 col-xs-4 active">
                <a class="star-pic loading img-circle" data-original="'.$row['actor_pic'].'" style="padding-top:100%;" href="'.AppService::getLink(6,$row['actor_id']).'"><span>'.$row['actor_name'].'</span></a>
              </li>';
        }
        AppService::assign('relate_star',$hot_star_html);
    }
    /**
     * @throws Exception
     */
    public function setRecommend(): void
    {
        $rows = AppService::getRecommendItem(App::$id);
        $html = '';
        foreach ($rows as $row){
            $p=[
                'type_id'=>$row['type_id'],
                'vod_id'=>$row['vod_id'],
                'vod_en'=>$row['vod_en'],
            ];
            $item = '<li class="col-md-2 col-sm-3 col-xs-4">
              <a class="video-pic loading" data-original="'.$row['vod_pic'].'" href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'" >
                <span class="player"></span>
                <span class="score">'.$row['vod_score'].'</span>
                <span class="note text-bg-r">'.$row['vod_remarks'].'</span></a>
              <div class="title">
                <h5 class="text-overflow">
                  <a href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">'.$row['vod_name'].'</a></h5>
              </div>
              <div class="subtitle text-muted text-overflow hidden-xs">'.$row['vod_actor'].'</div>
            </li>';
            $html.=$item;
        }
        AppService::assign('recommend',$html);
        AppService::setDPTop();
    }

    public function setStory($plotId): void
    {
        $html = '';
        if ($plotId == 1){
            $row = Db::selectOne('select * from mac_story where vod_id=' . App::$id . ' order by add_time desc limit 1');
            if (!empty($row)){
                $html = '<div class="layout-box clearfix details-story">
                        <div class="box-title"><h3 class="m-0">'.$row['name'].'分集剧情</h3>
                            <div class="more pull-right"><a href="/plots/'.AppService::dechexId(App::$id).'/" class="text-muted" title="更多">更多 <i
                                    class="icon iconfont"></i></a></div>
                        </div>
                        <div class="item"><h4 class="text-overflow"><a class="pull-left" href="/plot/'.$row['story_id'].'.html"
                                                                       target="_blank">'.$row['name'].'<em>第'.$row['epis'].'集剧情</em><span
                                class="hidden-xs"></span></a><a class="pull-right" href="/plot/'.$row['story_id'].'.html"
                                                                title="第'.$row['epis'].'集剧情" target="_blank">查看详细 <i
                                class="icon iconfont"></i></a></h4>
                        </div>
                    </div>';
            }
        }
        App::$content = str_replace('{mv:vod_story}', $html,App::$content);
    }


    /**
     * @throws Exception
     */
    public function setComment($vod): void
    {
        $id = $vod['vod_id'];
        $id = $id*4;
        $real_id = $id-App::$domain['offset'];
        $start_id = $real_id;
        $end_id = $real_id + 3;
        $rows = Db::selectAll('select * from mac_comment where id BETWEEN '.$start_id.' AND '.$end_id);
        $ct_html = '';
        $pt = '';
        $arr_len = count($rows);
        for ($j = 0; $j < $arr_len; $j++) {
            $obj = $rows[$j];
            $pt.=$obj['origin'].'、';
        }
        for ($j = 0; $j < $arr_len; $j++) {
            if($j==0){
                $ct_html.= '<p>1.《'.$vod['vod_name'].'》那一年上映的？</p>';
                $ct_html.= '<p>答：该影片'.$vod['vod_year'].'年在'.$vod['vod_area'].'上映，'.$pt.App::$domain['name'].'等平台同步上映</p>';
            }
            if($j==1){
                $ct_html.= '<p>2.那些平台可以免费观看《'.$vod['vod_name'].'》HD完整版？</p>';
                $ct_html.= '<p>答：'.'手机版免费无广告观看网址：<a href="/details/'.AppService::dechexId($vod['vod_id']).'.html" target="_blank">https://'.App::$full_url.'/details/'.AppService::dechexId($vod['vod_id']).'.html</a>,还可以在'.$pt.App::$domain['name'].'等平台观看</p>';
            }
            if($j==2){
                $ct_html.= '<p>3.《'.$vod['vod_name'].'》演员表？</p>';
                $ct_html.= '<p>答：该片是'.$vod['vod_year'].'年由'.$vod['vod_director'].'执导，'.$vod['vod_actor'].'等主演的'.App::$type_name[$vod['type_id']].'</p>';
            }
        }
        $ct_html.= '<p>4.《'.$vod['vod_name'].'》相关评价</p>';
        foreach ($rows as $row){
            $ct_html.= '<p>'.$row['origin'].$row['location'].'网友：'.$row['content'].'</p>';
        }
        AppService::assign('comment',$ct_html);
    }

}