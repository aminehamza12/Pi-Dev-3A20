<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Blog;
use BlogBundle\Entity\Comment;
use BlogBundle\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 */
class BlogController extends Controller
{
    /**
     * Lists all blog entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogs = $em->getRepository('BlogBundle:Blog')->findAll();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        return $this->render('blog/index.html.twig', array(
            'blogs' => $blogs,
        ));
        }else{
            return $this->render('blog/Front/index.html.twig', array(
                'blogs' => $blogs,
            ));
        }
    }

    /**
     * Creates a new blog entity.
     *
     */
    public function newAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm('BlogBundle\Form\BlogType', $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blog->setCreatedAt(new \DateTime());
            $blog->setEditedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute('blog_show', array('id' => $blog->getId()));
        }

        return $this->render('blog/new.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blog entity.
     *
     */
    public function showAction(Blog $blog,Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Execute some php code here
            $deleteForm = $this->createDeleteForm($blog);
            /* Testing Show Comments */
            $comments = $this->getDoctrine()->getRepository('BlogBundle:Comment')->findByBlog($blog);

            /* Testing Show Comments */
            /* Testing Comment */
            $comment = new Comment();
            $form = $this->createForm('BlogBundle\Form\CommentType', $comment);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user = $this->get('security.token_storage')->getToken()->getUser();
                $comment->setUser($user);
                $comment->setBlog($blog);
                $comment->setCreatedAt(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('blog_show', array('id' => $blog->getId()));
            }

            /* Testing Comment */
            return $this->render('blog/show.html.twig', array(
                'blog' => $blog,
                'delete_form' => $deleteForm->createView(),
                'comment' => $comment,
                'form_comment' => $form->createView(),
                'comments' => $comments,
            ));
        }else{

            /* Testing Show Comments */
            $comments = $this->getDoctrine()->getRepository('BlogBundle:Comment')->findByBlog($blog);

            /* Testing Show Comments */
            /* Testing Comment */
            $comment = new Comment();
            $form = $this->createForm('BlogBundle\Form\CommentType', $comment);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user = $this->get('security.token_storage')->getToken()->getUser();
                $comment->setUser($user);
                $comment->setBlog($blog);
                $comment->setCreatedAt(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('blog_show', array('id' => $blog->getId()));
            }

            /* Testing Comment */
            return $this->render('blog/Front/show.html.twig', array(
                'blog' => $blog,
                'comment' => $comment,
                'form_comment' => $form->createView(),
                'comments' => $comments,
            ));
        }

    }

    /**
     * Displays a form to edit an existing blog entity.
     *
     */
    public function editAction(Request $request, Blog $blog)
    {
        $deleteForm = $this->createDeleteForm($blog);
        $editForm = $this->createForm('BlogBundle\Form\BlogType', $blog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_edit', array('id' => $blog->getId()));
        }

        return $this->render('blog/edit.html.twig', array(
            'blog' => $blog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blog entity.
     *
     */
    public function deleteAction(Request $request, Blog $blog)
    {
        /*
        $form = $this->createDeleteForm($blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blog);
            $em->flush();
        }
        */
        if($blog){
            $em = $this->getDoctrine()->getManager();
            $em->remove($blog);
            $em->flush();
        }

        return $this->redirectToRoute('blog_index');
    }

    /**
     * Creates a form to delete a blog entity.
     *
     * @param Blog $blog The blog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blog $blog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', array('id' => $blog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
