<?php

namespace Beluha\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class  FunController extends Controller{
    
    public function indexAction( $number, Request $request){
        //$start = rand(0,100);
        echo "<pre>";
        var_dump($request->attributes->get('_format'));
        $start = $number;
        $response = '';
        for($i=0; $i<$start; ++$i){
            $response .= "fun controller run <br>";
        }
        
        return new Response($response);
    }
}

