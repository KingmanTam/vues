<?php

class ErrorService
{
    /**
     * @throws Exception
     */
    public static function load(): void
    {
        try {
            $error_page = Cache::get(App::$domain['cacheId'] . ':page_error');
            if (empty($error_page)){
                $error_page = file_get_contents('template/film/html/public/error.html');
            }
            App::$content = $error_page;
            AppService::assign('name',App::$domain['name']);
            AppService::assign('site_url',App::$full_url);
            Cache::set(App::$domain['cacheId'] . ':page_error', App::$content);
            echo App::$content;
            exit();
        } catch (Exception $e) {
            throw new Exception();
        }
    }
}