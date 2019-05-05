<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blogcategorie controller.
 *
 */
class BlogCategorieController extends Controller
{
    /**
     * Lists all blogCategorie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogCategories = $em->getRepository('BlogBundle:BlogCategorie')->findAll();

        return $this->render('blogcategorie/index.html.twig', array(
            'blogCategories' => $blogCategories,
        ));
    }

    /**
     * Creates a new blogCategorie entity.
     *
     */
    public function newAction(Request $request)
    {
        $blogCategorie = new Blogcategorie();
        $form = $this->createForm('BlogBundle\Form\BlogCategorieType', $blogCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogCategorie);
            $em->flush();

            return $this->redirectToRoute('blogcategorie_show', array('id' => $blogCategorie->getId()));
        }

        return $this->render('blogcategorie/new.html.twig', array(
            'blogCategorie' => $blogCategorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blogCategorie entity.
     *
     */
    public function showAction(BlogCategorie $blogCategorie)
    {
        $deleteForm = $this->createDeleteForm($blogCategorie);

        return $this->render('blogcategorie/show.html.twig', array(
            'blogCategorie' => $blogCategorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogCategorie entity.
     *
     */
    public function editAction(Request $request, BlogCategorie $blogCategorie)
    {
        $editForm = $this->createForm('BlogBundle\Form\BlogCategorieType', $blogCategorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blogcategorie_edit', array('id' => $blogCategorie->getId()));
        }

        return $this->render('blogcategorie/edit.html.twig', array(
            'blogCategorie' => $blogCategorie,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a blogCategorie entity.
     *
     */
    public function deleteAction(Request $request, BlogCategorie $blogCategorie)
    {
        /*
        $form = $this->createDeleteForm($blogCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogCategorie);
            $em->flush();
        }
        */
        if($blogCategorie){
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogCategorie);
            $em->flush();
        }

        return $this->redirectToRoute('blogcategorie_index');
    }

    /**
     * Creates a form to delete a blogCategorie entity.
     *
     * @param BlogCategorie $blogCategorie The blogCategorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogCategorie $blogCategorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blogcategorie_delete', array('id' => $blogCategorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays blogs of a specific categorie.
     *
     */
    public function showBlogsWithBlogCategorieAction(BlogCategorie $blogCategorie)
    {
        $em = $this->getDoctrine()->getManager();

        $blogs = $em->getRepository('BlogBundle:Blog')->findByBlogCategorie($blogCategorie);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('blogcategorie/showBlogsWithBlogCategorie.html.twig', array(
                'blogs' => $blogs,
            ));
        }else{
            return $this->render('blogcategorie/Front/showBlogsWithBlogCategorie.html.twig', array(
                'blogs' => $blogs,
            ));
        }


    }
}
