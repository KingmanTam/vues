<?php

class InfoService
{

    /**
     * @throws Exception
     */
    public function load(): void
    {
        if (App::$args['method']=='theme'){
            App::$method='info_theme';
        }
        if (App::$args['method']=='trailer'){
            App::$method='info_trailer';
        }
        AppService::load();
        $this->setData();
    }

    /**
     * @throws Exception
     */
    public function setData(): void
    {
        $row = Cache::get('vod:vod_'.App::$args['id']);
        if (empty($row)){
            $row = Db::selectOne('select * from mac_vod where vod_id = '.App::$args['id']);
            Cache::set('vod:vod_'.App::$args['id'],json_encode($row));
        }else{
            $row = json_decode($row,true);
        }
        if (empty($row)){
            throw new Exception();
        }
        $params = array();
        if (App::$args['method']=='theme'){
            $params['title'] = $row['vod_name'].'主题曲_'.$row['vod_name'].'插曲_'.$row['vod_name'].'片尾曲-'.App::$domain['name'];
            $params['keywords'] = $row['vod_name'].'主题曲,'.$row['vod_name'].'插曲,'.$row['vod_name'].'片尾曲';
            $params['des'] = App::$domain['name'].'提供你喜欢的'.$row['vod_name'].'主题曲_'.$row['vod_name'].'插曲_'.$row['vod_name'].'片尾曲等，更多信息请关注'.App::$domain['name'];
            AppService::setSEO($params);
        }
        if (App::$args['method']=='trailer'){
            $params['title'] = $row['vod_name'].'上映时间_'.$row['vod_name'].'预告片_'.$row['vod_name'].'经典台词-'.App::$domain['name'];
            $params['keywords'] = $row['vod_name'].'上映时间,'.$row['vod_name'].'预告片,'.$row['vod_name'].'经典台词';
            $params['des'] = App::$domain['name'].'提供你喜欢的'.$row['vod_name'].'上映时间_'.$row['vod_name'].'预告片_'.$row['vod_name'].'经典台词等，更多信息请关注'.App::$domain['name'];
            AppService::setSEO($params);
        }
        AppService::assign('vod_id',AppService::dechexId($row['vod_id']));
        AppService::assign('vod_name',$row['vod_name']);
        AppService::assign('type_name',App::$type_name[$row['type_id']]);
        AppService::assign('type_url',App::$type[$row['type_id']]);
        AppService::assign('vod_director',$row['vod_director']);
        AppService::assign('vod_score',$row['vod_score']);
        AppService::assign('vod_pic',$row['vod_pic']);
        AppService::assign('vod_remarks',$row['vod_remarks']);
        AppService::assign('vod_down',$row['vod_down']);
        AppService::assign('vod_actor',$row['vod_actor']);
        AppService::assign('vod_area',$row['vod_area']);
        AppService::assign('vod_lang',$row['vod_lang']);
        AppService::assign('vod_class',$row['vod_class']);
        AppService::assign('vod_year',$row['vod_year']);
        $detail_link = '/details/'.AppService::dechexId($row['vod_id']).'.html';
        AppService::assign('detail_link',$detail_link);
        $this->setRecommend();
    }

    /**
     * @throws Exception
     */
    public function setRecommend(): void
    {
        $rows = AppService::getRecommendItem(App::$args['id']);
        $html = '';
        foreach ($rows as $row){
            $p=[
                'type_id'=>$row['type_id'],
                'vod_id'=>$row['vod_id'],
                'vod_en'=>$row['vod_en'],
            ];
            $item = '<li class="col-md-2 col-sm-3 col-xs-4">
              <a class="video-pic loading" data-original="'.$row['vod_pic'].'" href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">
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

}