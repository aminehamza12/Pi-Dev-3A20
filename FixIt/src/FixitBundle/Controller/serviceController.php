<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\service;
use FixitBundle\Entity\category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service controller.
 *
 */
class serviceController extends Controller
{
    /**
     * Lists all service entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('FixitBundle:service')->findAll();

        return $this->render('service/index.html.twig', array(
            'services' => $services
        ));
    }
    /**
     * Lists all service entities by User.
     *
     */
    public function indexUserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('FixitBundle:service')->findBy(array('user'=>$this->getUser()));

        return $this->render('service/indexUser.html.twig', array(
            'services' => $services,
        ));
    }
    /**
     * Lists all seeking service entities.
     *
     */
    public function indexSeekingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('FixitBundle:service')->findBy(array('type'=>'Seeking'));
        $categories = $em->getRepository('FixitBundle:category')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            $request->query->getInt('page', 10)
        );

        return $this->render('service/indexSeeking.html.twig', array(
            'services' => $result,
            'user' => $this->getUser(),
            'categorys' => $categories
        ));
    }
    /**
     * Lists all providing service entities.
     *
     */
    public function indexProvidingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('FixitBundle:service')->findBy(array('type'=>'Providing'));
        $categories = $em->getRepository('FixitBundle:category')->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('service/indexProviding.html.twig', array(
            'services' => $result,
            'user' => $this->getUser(),
            'categorys' => $categories,
        ));
    }

    /**
     * Lists all providing service entities.
     *
     */
    public function indexCategoryAction(category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('FixitBundle:service')->findBy(array('category'=>$category->getId()));
        $categories = $em->getRepository('FixitBundle:category')->findAll();

        return $this->render('service/indexCategory.html.twig', array(
            'services' => $services,
            'user' =>$this->getUser(),
            'categorys' => $categories,
            'category' =>$category
        ));
    }
    /**
     * Lists all providing service entities by category.
     *
     */
    public function indexByCategoryProvidingAction(category $category,Request $request)
    {
        $en = $this->getDoctrine()->getManager();

//        $services = $en->getRepository('FixitBundle:service')->findBy(array('category'=>$category->getId(),'type'=>'Providing'));
        $categories = $en->getRepository('FixitBundle:category')->findAll();
        $s = new service();
        $s->setType("Providing");
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = 'SELECT c FROM FixitBundle:service c WHERE c.category = '.$category->getId().' AND c.type = :Providing';
        $services = $em->createQuery($dql);
        $services->setParameters(array('Providing' => 'Providing'));

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('service/indexProviding.html.twig', array(
            'services' => $result,
            'user' =>$this->getUser(),
            'categorys' => $categories,
            'category' =>$category
        ));
    }
    public function indexByCategorySeekingAction(category $category,Request $request)
    {
        $en = $this->getDoctrine()->getManager();

//        $services = $en->getRepository('FixitBundle:service')->findBy(array('category'=>$category->getId(),'type'=>'Providing'));
        $categories = $en->getRepository('FixitBundle:category')->findAll();

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = 'SELECT c FROM FixitBundle:service c WHERE c.category = '.$category->getId().' AND c.type = :Seeking';
        $services = $em->createQuery($dql);
        $services->setParameters(array('Seeking' => 'Seeking'));

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('service/indexSeeking.html.twig', array(
            'services' => $result,
            'user' =>$this->getUser(),
            'categorys' => $categories,
            'category' =>$category
        ));
    }

    /**
     * Creates a new service entity.
     *
     */
    public function newAction(Request $request)
    {
        $service = new Service();
        $form = $this->createForm('FixitBundle\Form\serviceType', $service);
        $form->handleRequest($request);
        $user=$this->getUser();
        $service->setAddDate(new \DateTime('now'));
        $service->setViews(0);
        $service->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file=$service->getPicture();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('Service_dir'),$fileName);
            $service->setPicture($fileName);
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }

        return $this->render('service/new.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a service entity.
     *
     */
    public function showAction(service $service)
    {
        $deleteForm = $this->createDeleteForm($service);
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('FixitBundle:category')->findAll();
        $addDate= $service->getAddDate()->format('d-M-Y');
        $service->setViews($service->getViews()+1);
        $related = $em->getRepository('FixitBundle:service')->findBy(array("category"=>$service->getCategory()),array("views"=>"DESC"));
        $this->getDoctrine()->getManager()->flush();
        return $this->render('service/show.html.twig', array(
            'service' => $service,
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'categorys' => $categories,
            'addDate' => $addDate,
            'related' => $related
        ));
    }

    /**
     * Displays a form to edit an existing service entity.
     *
     */
    public function editAction(Request $request, service $service)
    {
        $deleteForm = $this->createDeleteForm($service);
        $editForm = $this->createForm('FixitBundle\Form\serviceType', $service);
        $editForm->handleRequest($request);
        $user=$this->getUser();
        $service->setUser($user);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file=$service->getPicture();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('Service_dir'),$fileName);
            $service->setPicture($fileName);
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }

        return $this->render('service/edit.html.twig', array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a service entity.
     *
     */
    public function deleteAction(Request $request, service $service)
    {
        $form = $this->createDeleteForm($service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_index');
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_delete', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
