<?php

namespace Beluha\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Beluha\BlogBundle\Form\CommentType;
use Symfony\Component\VarDumper\VarDumper;
use Beluha\BlogBundle\Entity\Comment;

class PostController extends Controller
{
    /**
     * Show the posts index
     * @return array 
     * 
     * @Route("/", name="blog_show")
     */
    public function indexAction(Request $request)
    {
        //$locale = $request->getLocale(); exit($locale);
        //$request->getSession()->set('_locale', 'ru');
        //$locale = $request->getLocale(); exit($locale);
        $posts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findAll();
        $latestPosts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findLatest(5);
        return $this->render('BeluhaBlogBundle:Post:index.html.twig',[
            'posts'         => $posts,
            'latestPosts'   => $latestPosts
        ]);
    }
    
    /**
     * Show a post
     * 
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * @return array
     * 
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findOneBy(
                [
                    'slug' => $slug
                ]);
        
        if(null === $post){
            throw $this->createNotFoundException('Такой пост не найден');
        }
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($post);
        $dumper = new VarDumper();
        $dumper->dump($post);
        //
        //В этом коде нет необходимости, так как комментарии и так подтянутся из базы
        /*$comments = $this->getDoctrine()->getRepository('Beluha\BlogBundle:Comment')->findBy(
                [
                    'post' => $post
                ]);*/
        $comment = new CommentType();
        $form = $this->createForm(CommentType::class);
        
        return [
            'post' => $post,
            'form' => $form->createView()
            //'comments' =>$comments
            ];
    }
    

    /**
     * Create comment
     * 
     * @param Request $request
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * 
     * @return array 
     * 
     * @Route("/{slug}/create-comment")
     * @Method({"POST"})
     * @Template("Beluha\BlogBundle:Post:show.html.twig")
     */
    public function createCommentAction( Request $request, $slug)
    {
        $post = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findOneBy(
                [
                    'slug' => $slug
                ]);
        
        if(null === $post){
            throw $this->createNotFoundException('Такой пост не найден');
        }   
        
        $comment = new Comment();
        $comment->setPost($post);
        
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            
            $this->get('session')->getFlashBag()->add('success','Ваш комментарий успешно отправлен');
            return $this->redirect($this->generateUrl('core_post_show', ['slug' => $post->getSlug()]));
        }        
        return [
            'post' => $post,
            'form' => $form->createView()            
        ];
    }
}
