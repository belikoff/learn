<?php

namespace Beluha\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AdvancedController extends Controller{
    /*
     * Beluha_store_advanced:
    path: /advanced/{year}/{culture}/{title}.{_format}
    defaults: {_controller: BeluhaStoreBundle:Advanced:advanced}
    requirements:
        culture: ru|en
        year: \d+
        _format: html|php
     * http://symtest/app_dev.php/Beluha/advanced/1977/ru/foo.php
     * Symfony в состоянии установить соответствие между именами параметров маршрута и сигнатурой 
     * метода в контроллере. Другими словами, это работает таким образом, что параметр {last_name} 
     * соответствует аргументу $last_name. Аргументы контроллера менять местами и 
     * он всё равно будет работать:
     */
    public function advancedAction($_controller, $year, Request $Request){
        //echo "<br> _controller = ".$_controller;
        //echo "<br> year = ".$year;
        
        
        /*
         * По умолчанию, маршрутизатор генерирует относительные URL (например /blog). 
         * Для того, чтобы сгенерировать абсолютный URL, просто укажите “true” 
         * в качестве третьего аргумента метода generate():
         * 
         * Метод generate принимает массив значений для генерации URL. 
         * Если вы передадите лишний (не указанный в определении маршрута) 
         * параметр, он будет добавлен как query string:
         */
        $url = $this->get('router')->generate('Beluha_store_advanced', array(
            'year' => '1955', 
            'culture' => 'en',
            'title' => 'ok',
            '_format' => 'html',
            'fig' => 5
            ),true);
        $log = $this->get('monolog.logger.event');
        //echo "<pre>";
        //var_dump($log);
        $session = $this->get('session');
        echo "<pre>";
        var_dump($session);
        
        return new Response ("<a href='{$url}'>жми</a><br>{$url}<pre>".$Request);
        //$this->redirect('/');
    }
}
