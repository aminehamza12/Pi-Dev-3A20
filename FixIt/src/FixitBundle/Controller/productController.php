<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\product;
use FixitBundle\Entity\CategoryProduct;
use FixitBundle\Entity\notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Product controller.
 *
 */
class productController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $products = $em->getRepository('FixitBundle:product')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        return $this->render('product/index.html.twig', array(
            'products' => $products,'user'=> $user,'media' => $media,'category' => $category,'comments' => $comments,
            'thread' => $thread,
        ));
    }
    public function indexadminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $products = $em->getRepository('FixitBundle:product')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();

        return $this->render('product/index1.html.twig', array(
            'products' => $products,
            'user'=> $user,
            'media' => $media,
            'category' => $category,
        ));
    }
    public function catAction(Request $request)
    {

        $em    = $this->get('doctrine.orm.entity_manager');
        if($_POST['nadim']=='sell')
        {
            $dql   = "SELECT a FROM FixitBundle:product a ORDER BY a.nbcommande ";
        }elseif ($_POST['nadim']=='view')
        {
            $dql   = "SELECT a FROM FixitBundle:product a ORDER BY a.view ";
        }elseif ($_POST['nadim']=='name')
        {
            $dql   = "SELECT a FROM FixitBundle:product a ORDER BY a.name ";
        }elseif ($_POST['nadim']=='price')
        {
            $dql   = "SELECT a FROM FixitBundle:product a ORDER BY a.price ";
        }

        $query = $em->createQuery($dql);
        $user=$this->getUser();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        // parameters to template
        return $this->render('product/index.html.twig', array('pagination' => $pagination,
            'user' =>$user,
            'category'=> $category,
            'media'=>$media,
            'nbr' => $nbr,
            'comments' =>$comments,
            'thread' =>$thread));
    }
    public function listadminAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM FixitBundle:product a";
        $query = $em->createQuery($dql);
        $user=$this->getUser();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('product/index1.html.twig', array('pagination' => $pagination,
            'user' =>$user,
            'category'=> $category,
            'media'=>$media,
            'nbr' =>$nbr,));
    }
    public function listAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM FixitBundle:product a";
        $query = $em->createQuery($dql);
        $user=$this->getUser();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        // parameters to template
        return $this->render('product/index.html.twig', array('pagination' => $pagination,
            'user' =>$user,
            'category'=> $category,
            'media'=>$media,
            'nbr' => $nbr,
            'comments' => $comments,
            'thread' => $thread,));
    }
    public function filterAction(Request $request)
    {
        if(isset($_POST['categ']))
        {
            $_SESSION['nadim']=$_POST['categ'];
        }
        $in = '(' . implode(',', $_SESSION['nadim']) .')';
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = 'SELECT a FROM FixitBundle:product a WHERE a.category IN '.$in;
        $query = $em->createQuery($dql);
        $user=$this->getUser();
        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        // parameters to template
        return $this->render('product/index.html.twig', array('pagination' => $pagination,
            'user' =>$user,
            'category'=> $category,
            'media'=>$media,
            'nbr' =>$nbr,
            'comments' =>$comments,
            'thread'=>$thread));
    }
    public function mesproduitsAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $user=$this->getUser();
        $dql   = "SELECT a FROM FixitBundle:product a WHERE a.user=".$user->getId();
        $query = $em->createQuery($dql);

        $category = $em->getRepository('FixitBundle:CategoryProduct')->findAll();
        $media = $em->getRepository('FixitBundle:Media')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ,'user' =>$user ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        // parameters to template
        return $this->render('product/index.html.twig', array('pagination' => $pagination,
            'user' =>$user,
            'category'=> $category,
            'media'=>$media,
            'nbr'=>$nbr));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('FixitBundle\Form\productType', $product);
        $form->handleRequest($request);
        $user=$this->getUser();
        $product->setUser($user);
        $nbr=0;
        $em = $this->getDoctrine()->getManager();
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0,'user' =>$user  ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setView(0);
            $product->setNbcommande(0);
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('media_new', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
            'user'=> $user,
            'nbr' => $nbr
        ));
    }
    public function newadminAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('FixitBundle\Form\productType', $product);
        $form->handleRequest($request);
        $user=$this->getUser();
        $product->setUser($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('media_new', array('id' => $product->getId()));
        }

        return $this->render('product/new1.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),'user'=> $user
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Request $request ,product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('FixitBundle:Media')->findBy(array('product_id'=>$product));
        $product->setView($product->getView()+1);
        $user = $this->getUser();
        $em->flush();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0,'user' =>$user  ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $user=$this->getUser();
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'media'=>$media,
            'delete_form' => $deleteForm->createView(),
            'user'=> $user,
            'nbr' => $nbr,
            'comments' => $comments,
            'thread' => $thread,
        ));
    }
    public function showadminAction(product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('FixitBundle:Media')->findBy(array('product_id'=>$product));

        $user=$this->getUser();
        return $this->render('product/show1.html.twig', array(
            'product' => $product,'media'=>$media,
            'delete_form' => $deleteForm->createView(),'user'=> $user,
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('FixitBundle\Form\productType', $product);
        $editForm->handleRequest($request);
        $user=$this->getUser();
        $product->setUser($user);
        $nbr=0;
        $em = $this->getDoctrine()->getManager();
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ,'user' =>$user ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId(),'user'=> $user,'nbr'=>$nbr));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user'=> $user,
            'nbr' => $nbr
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, product $product)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ,'user' =>$user ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }

        return $this->redirectToRoute('product_index',array('nbr' => $nbr));
    }
    public function deleteadminAction(Request $request, product $product)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();


        return $this->redirectToRoute('productadmin_index');
    }

        /**
     * Creates a form to delete a product entity.
     *
     * @param product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $em->getRepository('FixitBundle:product')->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "Desolé on a pas une produit avec ce nom . ";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = [$entity->getName()];
        }
        return $realEntities;
    }

}
