<?php

class MapService
{

    public function map(): void
    {
        $method = App::$args['method'];
        if ($method == 'map_index'){
            $this->mapIndex();
        }else{
            $this->mapGrade();
        }
    }

    /**
     * @throws Exception
     */
    public function mapIndex(): void
    {
        $key = App::$domain['cacheId'].App::$full_url.'sitemap';
        $html = Cache::get($key);
        if (!empty($html)){
            App::$content = $html;
        }else{
            $html = file_get_contents('template/film/html/public/map.html');
            $rows = Db::selectAll('select * from mac_vod order by vod_id DESC limit 1000');
            $item_html = '';
            foreach ($rows as $row){
                $item_html.='<url>
                            <loc>https://'.App::$site_url.'/details/'.AppService::dechexId($row['vod_id']).'.html</loc>
                            <lastmod>'.date('Y-m-d',$row['vod_time_add']).'</lastmod>
                            <changefreq>daily</changefreq>
                            <priority>0.8</priority>
                          </url>';
            }
            App::$content = str_replace('{mv:sitemap}', $item_html,$html);
            Cache::set($key,App::$content,App::$redis['timeout_l']);
        }
    }

    /**
     * @throws Exception
     */
    public function mapGrade(): void
    {

        $key = App::$domain['cacheId'].App::$full_url.'bdmap';
        $grade_html = Cache::get($key);
        if (!empty($grade_html)){
            App::$content = $grade_html;
        }else{
            $res = Db::selectOne('select * from sitemap where id = 1');
            $start = $res['now_id']-App::$domain['offset']*100;
            $base_size = $res['size'];
            $end = $start + $base_size;
            $html = file_get_contents('template/film/html/public/map.html');
            $sql = 'select * from mac_vod where vod_id>'.$start.' and  vod_id<'.$end.' order by vod_id desc';
            $rows = Db::selectAll($sql);
            $item_html = '';
            $now_date = date('Y-m-d', time());
            foreach ($rows as $row){
                $item_html.='<url><loc>https://'.App::$full_url.'/details/'.AppService::dechexId($row['vod_id']).'.html</loc><lastmod>'.$now_date.'</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>';
            }
            App::$content = str_replace('{mv:sitemap}', $item_html,$html);
            Cache::set($key,App::$content,App::$redis['timeout_l']);
        }

    }
}