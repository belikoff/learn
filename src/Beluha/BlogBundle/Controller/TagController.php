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

        $tagRepo = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Tag');
        $ids = $tagRepo->getResourceIdsForTag('tag', $slug);

        $repository = $this->getDoctrine()
            ->getRepository('BeluhaBlogBundle:Post');
        $qb = $repository->createQueryBuilder('p');
        $query = $qb->add('where', $qb->expr()->in('p.id', $ids))->getQuery();
        $posts = $query->getResult();

        $dumper = new VarDumper();
        $dumper->dump($posts);
        
        $latestPosts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findLatest(5);

        if(null === $posts){
            throw $this->createNotFoundException('Постов с такими тэгами не найдено');
        }



        
        return $this->render('BeluhaBlogBundle:Post:index.html.twig',[
            'posts'         => $posts,
            'latestPosts'   => $latestPosts
        ]);
    }    
}
