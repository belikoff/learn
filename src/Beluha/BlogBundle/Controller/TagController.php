<?php

namespace Beluha\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Description of TagController
 *
 * @author belikov
 */
class TagController extends Controller
{
    /**
     * Show a post by tag
     * 
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * @return array
     * 
     * @Route("/{slug}", name="blog_tag")
     */
    public function showAction($slug)
    {

        $tagRepo = $this->getDoctrine()->getRepository('\DoctrineExtensions\Taggable\Entity\Tag');

        
        $dumper = new VarDumper();
        $dumper->dump($tagRepo);
        //if(null === $tagRepo){
            //throw $this->createNotFoundException('Постов с такими тэгами не найдено');
        //}



        
        return $this->render('BeluhaBlogBundle:Post:index.html.twig',[]);
    }    
}
