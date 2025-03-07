<?php
require 'application/init.php';
require 'application/core/Cache.php';
require 'application/controller/AppController.php';

$controller = new AppController();

$b = common::validUrl();

try {
    if (!$b) {
        $controller->error();
    }
    switch (App::$method) {
        case 'index':
            $controller->index();
            break;
        case 'type':
            $controller->type();
            break;
        case 'relay':
            $controller->play();
            break;
        case 'rank':
            $controller->rank();
            break;
        case 'actor':
            $controller->actor();
            break;
        case 'star':
            $controller->star();
            break;
        case 'info':
            $controller->info();
            break;
        case 'last':
            $controller->last();
            break;
        case 'search':
            $controller->search();
            break;
        case 'story_index':
        case 'story':
            $controller->story();
            break;
        case 'robots':
            $controller->robots();
            break;
        case 'map':
            $controller->map();
        case 'content':
            $controller->content();
            break;
        case 'detail':
            $controller->detail();
    }
    //Common::saveSpiderLog(true);
    echo App::$content;
} catch (Exception $e) {
    //Common::saveSpiderLog(false);
    $controller->error();
}
