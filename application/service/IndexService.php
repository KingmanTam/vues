<?php

class IndexService
{

    /**
     * @throws Exception
     */
    public function load(): void
    {
        AppService::load();
        $params = array();
        $params['title'] = App::$domain['title'];
        $params['keywords'] = App::$domain['keywords'];
        $params['des'] = App::$domain['description'];
        AppService::setSEO($params);
        //$this->setSlide();
        //$this->setLastUpdated();
        $this->setIndexClassify();
    }

    /**
     * @throws Exception
     */
    public function setSlide(): void
    {
        $key = App::$domain['cacheId'].':page_index_slide';
        $slide = Cache::get($key);
        if (empty($slide)){
            $rows = Db::selectAll('select * from mac_vod where vod_pic_slide <>\'\'');
            $slide = '';
            foreach ($rows as $row){
                $p=[
                    'type_id'=>$row['type_id'],
                    'vod_id'=>$row['vod_id'],
                    'vod_en'=>$row['vod_en'],
                ];
                $slide = $slide.'<div class="swiper-slide">
                            <div class="box-video-slide">
                                <a class="slide-pic swiper-lazy" href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'" style="padding-top:60%;background-position:50% 50%;background-size:cover;background-image: url('.$row['vod_pic_slide'].')">
                                    <span class="slide-title"> '.$row['vod_name'].'</span>
                                    <div class="swiper-lazy-preloader"></div>
                                </a>
                            </div>
                        </div>';
            }
            Cache::set($key,$slide,app::$redis['timeout_l']);
        }
        app::$content = str_replace('{mv:slide}', $slide,app::$content);
    }

    /**
     * @throws Exception
     */
    public function setLastUpdated(): void
    {
        $key = App::$domain['cacheId'].':page_last_update';
        $last_page = Cache::get($key);
        if (!empty($last_page)){
            AppService::assign('lastUpdate',$last_page);
        }else{
            $rows = Db::selectAll('select * from mac_vod order by vod_time_add desc limit 6');
            $last_update_page = '';
            foreach ($rows as $row){
                $p=[
                    'type_id'=>$row['type_id'],
                    'vod_id'=>$row['vod_id'],
                    'vod_en'=>$row['vod_en'],
                ];
                $last_update_page = $last_update_page.'<li class="col-md-2 col-sm-3 col-xs-4 ">
                    <a class="video-pic loading"
                       data-original="'.$row['vod_pic'].'"
                       href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">
                        <span class="player"></span>
                        <span class="score">'.$row['vod_score'].'</span>
                        <span class="note text-bg-r"></span>
                    </a>
                    <div class="title">
                        <h5 class="text-overflow">
                            <a href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">'.$row['vod_name'].'</a>
                        </h5>
                    </div>
                    <div class="subtitle text-muted text-overflow hidden-xs">'.$row['vod_actor'].'</div>
                </li>';
            }
            AppService::assign('lastUpdate',$last_update_page);
            Cache::set($key,$last_update_page,App::$redis['timeout_m']);
        }

    }

    /**
     * @throws Exception
     */
    public function setIndexClassify(): void
    {
        $key = App::$domain['cacheId'].':type_list';
        $type_list_page = Cache::get($key);
        if (!empty($type_list_page)){
            AppService::assign('typeList',$type_list_page);
        }else{
            $content = file_get_contents('template/film/html/public/index_classify.html');
            $rows = Db::selectAll('select * from mac_type  where type_pid=0 order by type_id ASC');
            $type_html = '';
            foreach ($rows as $row){
                if ($row['type_id']>5){
                    break;
                }
                $type_i_content = $content;
                $type_i_content = str_replace('{mv:type_id}', $row['type_id'],$type_i_content);
                $more_link = '/'.App::$type[$row['type_id']].'/';
                $type_i_content = str_replace('{mv:more}', $more_link,$type_i_content);
                $type_i_content = str_replace('{mv:type_name}', $row['type_name'],$type_i_content);
                //$type_i_content = $this->setClassifySlide($type_i_content, $row['type_id']);
                //$type_i_content = $this->setTypeClass($type_i_content, $row['type_id']);
                $indexTypeTop = $this->getIndexTypeTop($row['type_id']);
                $type_i_content = str_replace('{mv:index_type_top}', $indexTypeTop,$type_i_content);
                $typeItemList = $this->getTypeItemList($row['type_id']);
                $type_i_content = str_replace('{mv:index_type_list}', $typeItemList,$type_i_content);
                $type_html = $type_html . $type_i_content;
            }
            AppService::assign('typeList',$type_html);
            Cache::set($key,$type_html,App::$redis['timeout_l']);
        }

    }
    public function setTypeClass($content,$type_id): array|string
    {
        $key = App::$domain['cacheId'].':page_index_type_class_'.$type_id;
        $class_html = Cache::get($key);
        if (!empty($class_html)){
            return str_replace('{mv:index_type_class}', $class_html,$content);
        }
        $class = App::$extend[$type_id];
        foreach ($class as $k=>$v){
            $p=array(
                'type_rute'=>$k,
                'type_id'=>$type_id,
                'class'=>$k,
            );
            $class_html = $class_html .'<li>
                  <a class="text-overflow"  target="_blank" href="'.AppService::getLink(3,$p).'">'.$v.'</a>
                </li>';
        }
        Cache::set($key,$class_html,App::$redis['timeout_l']);
        return str_replace('{mv:index_type_class}', $class_html,$content);
    }
    /**
     * @throws Exception
     */
    public function setClassifySlide($content, $typeId): array|string
    {
        $key = App::$domain['cacheId'].':page_index_type_slide_'.$typeId;
        $classifySlide = Cache::get($key);
        if (!empty($classifySlide)){
            return str_replace('{mv:index_classifySlide}', $classifySlide,$content);
        }
        $rows = Db::selectAll('select * from mac_vod  where type_id='.$typeId.' order by vod_hits DESC limit 4');
        $classifySlide = '';
        foreach ($rows as $row){
            $p=[
                'type_id'=>$typeId,
                'vod_id'=>$row['vod_id'],
                'vod_en'=>$row['vod_en'],
            ];
            $classifySlide = $classifySlide.'<div class="swiper-slide">
              <div class="box-video-slide">
                <a class="slide-pic swiper-lazy" href="'.AppService::getLink(4,$p).'"
                   title="'.$row['vod_name'].'"
                   style="padding-top:60%;background-position:50% 50%;background-size:cover;background-image: url('.$row['vod_pic'].')">
                  <span class="slide-title">'.$row['vod_name'].'</span>
                  <div class="swiper-lazy-preloader"></div>
                </a>
              </div>
            </div>';
        }
        Cache::set($key,$classifySlide,App::$redis['timeout_l']);
        return str_replace('{mv:index_classifySlide}', $classifySlide,$content);
    }
    /**
     * @throws Exception
     */
    public function getIndexTypeTop($typeId): array|string
    {
        $key = App::$domain['cacheId'].':page_index_type_top_'.$typeId;
        $top_html = Cache::get($key);
        if (!empty($top_html)){
            return $top_html;
        }
        $rows = Db::selectAll('select * from mac_vod  where type_id='.$typeId.' order by vod_time_add DESC limit 10');
        $top_html = '';
        $count = count($rows);
        for ($i = 0; $i < $count; $i++) {
            $row = $rows[$i];
            $class_num = 3;
            if ($i<2){
                $class_num = 2;
            }
            $p=[
                'type_id'=>$typeId,
                'vod_id'=>$row['vod_id'],
                'vod_en'=>$row['vod_en'],
            ];
            $top_html = $top_html.'<li class="list p-0 ">
                    <span class="pull-right text-color">'.$row['vod_score'].'</span>
                    <a href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">
                      <em '.AppService::getActive($class_num).'>'.($i+1).'</em>'.$row['vod_name'].'
                    </a>
                  </li>';
        }
        Cache::set($key,$top_html,App::$redis['timeout_l']);
        return $top_html;
    }
    /**
     * @throws Exception
     */
    public function getTypeItemList($typeId): array|string
    {
        $rows = Db::selectAll('select * from mac_vod  where type_id='.$typeId.' order by vod_time_add DESC limit 12');
        $item_html = '';
        foreach ($rows as $row) {
            $p=[
                'type_id'=>$typeId,
                'vod_id'=>$row['vod_id'],
                'vod_en'=>$row['vod_en'],
            ];
            $item_html = $item_html.'<li class="col-md-2 col-sm-2 col-xs-4">
                      <a class="video-pic loading" data-original="'.$row['vod_pic'].'" href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">
                        <span class="player"></span>
                        <span class="score">'.$row['vod_score'].'</span>
                        <span class="note text-bg-r">'.$row['vod_remarks'].'</span>
                      </a>
                      <div class="title">
                        <h5 class="text-overflow">
                          <a href="'.AppService::getLink(4,$p).'" title="'.$row['vod_name'].'">'.$row['vod_name'].'</a>
                        </h5>
                      </div>
                      <div class="subtitle text-muted text-overflow hidden-xs">演员：'.$row['vod_actor'].'</div>
                    </li>';
        }
        return $item_html;
    }
}