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
     */
    public function indexAction(Request $request)
    {

        $posts       = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findAll();
        $latestPosts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findLatest(5);
        return $this->render('BeluhaBlogBundle:Post:index.html.twig',
                [
                'posts' => $posts,
                'latestPosts' => $latestPosts
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
     */
    public function showAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findOneBy(
            [
                'slug' => $slug
        ]);

        if (null === $post) {
            throw $this->createNotFoundException('Такой пост не найден');
        }
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($post);

        return $this->render('BeluhaBlogBundle:Post:show.html.twig',
                [
                'post' => $post,
                //'form' => $form->createView()
                //'comments' =>$comments
        ]);
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
     */
    public function createCommentAction(Request $request, $slug)
    {
        $post = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findOneBy(
            [
                'slug' => $slug
        ]);

        if (null === $post) {
            throw $this->createNotFoundException('Такой пост не найден');
        }

        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add('success',
                'Ваш комментарий успешно отправлен');
            return $this->redirect($this->generateUrl('core_post_show',
                        ['slug' => $post->getSlug()]));
        }
        return $this->render('BeluhaBlogBundle:Post:show.html.twig',
                [
                'post' => $post,
                'form' => $form->createView()
        ]);
    }

    /**
     * Show a post by tag
     * 
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * @return array
     * 
     */
    public function showByTagAction($slug)
    {

        $tagRepo = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Tag');
        $ids     = $tagRepo->getResourceIdsForTag('tag', $slug);

        $repository = $this->getDoctrine()
            ->getRepository('BeluhaBlogBundle:Post');
        $qb         = $repository->createQueryBuilder('p');
        $query      = $qb->add('where', $qb->expr()->in('p.id', $ids))->getQuery();
        $posts      = $query->getResult();

        $dumper = new VarDumper();
        $dumper->dump($posts);

        $latestPosts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findLatest(5);

        if (null === $posts) {
            throw $this->createNotFoundException('Постов с такими тэгами не найдено');
        }

        return $this->render('BeluhaBlogBundle:Post:index.html.twig',
                [
                'posts' => $posts,
                'latestPosts' => $latestPosts
        ]);
    }
}