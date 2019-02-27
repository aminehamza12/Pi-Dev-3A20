<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Blog;
use BlogBundle\Entity\BlogViews;
use BlogBundle\Entity\Comment;
use BlogBundle\Form\BlogType;
use BlogBundle\Form\SearchBlogType;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Response;

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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blog->setCreatedAt(new \DateTime());
            $blog->setEditedAt(new \DateTime());
            $blog->setUser($user);
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

            $searchForm = $this->createForm(SearchBlogType::class,$blog);
            $searchForm->handleRequest($request);
            if($searchForm->isSubmitted() && $searchForm->isValid()){
                $searchQuery = $this->getDoctrine()->getRepository('BlogBundle:Blog')->createQueryBuilder('b')
                    ->where('b.title LIKE :word')->setParameter('word', '%'.$blog->getTitle().'%')->getQuery();
                $blogs = $searchQuery->getResult();
                return $this->render('blog/searchBlog.html.twig',array('searchForm'=>$searchForm->createView(),'blogs'=>$blogs));
            }



            //$searchForm->handleRequest($request);




            /* Views System */

            $date = new \DateTime();
            $today = $date->format('Y-m-d');
            //$today = \DateTime::createFromFormat("m/d/Y",$dateformat);
            $em = $this->getDoctrine()->getManager();
            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('CAST(dateVisite AS date)','dateVisite');
            $rsm->addScalarResult('blog_id','blogId');
            $rsm->addScalarResult('id','blogViewId');
            //$sql = "SELECT CAST(dateVisite AS date) FROM blog_views WHERE blog_id = 1 AND CAST(dateVisite AS date) = \"2019-02-23\" LIMIT 1";

            $query = $em->createNativeQuery
            ('SELECT CAST(dateVisite AS date),blog_id,id FROM blog_views WHERE blog_id = :blogId AND CAST(dateVisite AS date) = :today LIMIT 1',
                $rsm);

            /* //Test Query
            $query = $em->createNativeQuery
            ('SELECT CAST(dateVisite AS date) FROM blog_views WHERE blog_id = :blogId AND CAST(dateVisite AS date) = "2019-02-25" LIMIT 1',
                $rsm);
            */
            $query->setParameter("blogId",$blog->getId());
            $query->setParameter("today",$today);
            $blogViewQuery = $query->getResult();
            //echo $blogView[0]['dateVisite'];die;
            //dump($query);die; //show query


            //dump($today);die;
            //dump($blogViewQuery);die;




            if($blogViewQuery == null){
                $blogView = new BlogViews();
                $blogView->setBlog($blog);
                $blogView->setDateVisite(new \DateTime());
                $blogView->setVisites(1);
                $em->persist($blogView);
                $em->flush();

            }else{
                $blogView = $this->getDoctrine()->getRepository('BlogBundle:BlogViews')->findOneById($blogViewQuery[0]['blogViewId']);
                $blogView->incrementVisites();
                $em->flush();
            }
            /* // to show total blog views
            $rsm1 = new ResultSetMapping();
            $rsm1->addScalarResult('SUM(visites)','visites');
            $query1 = $em->createNativeQuery
            ('SELECT SUM(visites) FROM blog_views WHERE blog_id = :blogId',
                $rsm1);
            $query1->setParameter("blogId",$blog->getId());
            $blogSumVisitesQuery = $query1->getResult();
            */
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
                'searchForm'=>$searchForm->createView()
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

    public function numberVisitesAction($blog){
        $em = $this->getDoctrine()->getManager();
        $rsm1 = new ResultSetMapping();
        $rsm1->addScalarResult('SUM(visites)','visites');
        $query1 = $em->createNativeQuery
        ('SELECT SUM(visites) FROM blog_views WHERE blog_id = :blogId',
            $rsm1);
        $query1->setParameter("blogId",$blog->getId());
        $blogSumVisitesQuery = $query1->getResult();
        $numberVisites = $blogSumVisitesQuery[0]['visites'];
        return $this->render('blog/numberVisites.html.twig', array(
            'numberVisites' => $numberVisites,
        ));
    }

    public function renderMostLikedBlogPostsAction(){
        $em = $this->getDoctrine()->getManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('title','title');
        $rsm->addScalarResult('image','image');
        $rsm->addScalarResult('editedAt','editedAt');
        $rsm->addScalarResult('SUM(visites)','visites');
        $rsm->addScalarResult('id','id');
        $query = $em->createNativeQuery('
        SELECT b.id,title,image,editedAt,SUM(visites) FROM blog as b,blog_views as bv WHERE b.id = bv.blog_id GROUP BY bv.blog_id ORDER BY SUM(visites) DESC LIMIT 3
        ',$rsm);
        $queryResult = $query->getResult();
        return $this->render('blog/renderMostLikedBlogPosts.html.twig', array(
            'mostLikedBlogs' => $queryResult,
        ));

    }

    public function blogStatisticsAction(Blog $blog){
        $em = $this->getDoctrine()->getManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('visites','visites');
        $rsm->addScalarResult('EXTRACT(DAY FROM dateVisite)','day');
        $query = $em->createNativeQuery
        ('SELECT visites,EXTRACT(DAY FROM dateVisite) FROM blog_views WHERE blog_id = :blogId AND EXTRACT(MONTH FROM dateVisite)=2',
            $rsm);
        $query->setParameter("blogId",$blog->getId());
        $blogMonthVisitesQuery = $query->getResult();
        $visites = array_fill(0, 28, 0);

        for($i = 0 ; $i < sizeof($blogMonthVisitesQuery) ; $i++){
            $visites[$blogMonthVisitesQuery[$i]['day']] = (int)$blogMonthVisitesQuery[$i]['visites'];
        }

        $year = 2019;
        $range = array();
        $start = strtotime($year.'-02-01');
        $end = strtotime($year.'-02-28');

        do {
            $range[] = date('Y-m-d',$start);
            $start = strtotime("+ 1 day",$start);
        } while ( $start <= $end );

        // Chart
        $categories = array_fill(0, 30, "2019-02-01");
        $days = [5,4,2,1];
        //var_dump($visites);die;

        $series = array(
            array("name" => "Data Serie Name",    "data" => $visites)
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Chart Title');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->xAxis->categories($range);
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        return $this->render('blog/blogStatistics.html.twig', array(
            'chart' => $ob,'blog'=>$blog,
        ));

    }

    public function blogStatisticsComponentAction(Blog $blog,$monthId){
        $em = $this->getDoctrine()->getManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('visites','visites');
        $rsm->addScalarResult('EXTRACT(DAY FROM dateVisite)','day');
        $query = $em->createNativeQuery
        ('SELECT visites,EXTRACT(DAY FROM dateVisite) FROM blog_views WHERE blog_id = :blogId AND EXTRACT(MONTH FROM dateVisite)= :monthId',
            $rsm);
        $query->setParameter("blogId",$blog->getId());
        $query->setParameter("monthId",$monthId);
        $blogMonthVisitesQuery = $query->getResult();
        $visites = array_fill(0, 28, 0);

        for($i = 0 ; $i < sizeof($blogMonthVisitesQuery) ; $i++){
            $visites[$blogMonthVisitesQuery[$i]['day']] = (int)$blogMonthVisitesQuery[$i]['visites'];
        }

        $year = 2019;
        $range = array();
        $start = strtotime($year.'-02-01');
        $end = strtotime($year.'-02-28');

        do {
            $range[] = date('Y-m-d',$start);
            $start = strtotime("+ 1 day",$start);
        } while ( $start <= $end );

        // Chart

        $series = array(
            array("name" => "Data Serie Name",    "data" => $visites)
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Chart Title');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->xAxis->categories($range);
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        return $this->render('blog/blogStatisticsComponent.html.twig', array(
            'chart' => $ob
        ));

    }

    public function ajaxAction(Request $request){

        //$response['message'] = $this->render('BlogBundle:Blog:blogStatisticsComponent.html.twig', array('id' => $blog->getId()))->getContent();

        $blogId = $request->get('blog_id');
        $monthId = $request->get('month_id');


        $blog = $this->getDoctrine()->getRepository('BlogBundle:Blog')->findOneById($blogId);
        $template = $this->forward('BlogBundle:Blog:blogStatisticsComponent',array('id' => $blog->getId(),'monthId'=>$monthId))->getContent();

        //dump($template);die;
        $json = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;


    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');

        $rsm = new ResultSetMapping();
        $em = $this->getDoctrine()->getManager();
        $rsm->addScalarResult('id','id');
        $rsm->addScalarResult('title','title');
        $rsm->addScalarResult('description','description');
        $rsm->addScalarResult('content','content');
        $rsm->addScalarResult('editedAt','editedAt');
        $rsm->addScalarResult('image','image');
        $rsm->addScalarResult('blogCategorie_id','blogCategorie_id');
        $rsm->addScalarResult('name','blogCategorieName');
        $rsm->addScalarResult('SUM(visites)','visites');
        $query = $em->createNativeQuery
        ('SELECT b.id,b.title,b.description,b.content,b.editedAt,b.image,blogCategorie_id,bg.name,SUM(visites) FROM blog as b,blog_categorie as bg,blog_views as bv WHERE b.title LIKE :str AND b.blogCategorie_id = bg.id AND b.id = bv.blog_id GROUP BY bv.blog_id
',
            $rsm);
        $query->setParameter('str', '%'.$requestString.'%');
        $entities=$query->getResult();


        if(!$entities) {
            $result['entities']['error'] = "Failed!";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity['id']] = [$entity['title'],[$entity['description']],[$entity['content']],[$entity['editedAt']],[$entity['image']],[$entity['blogCategorie_id']],[$entity['blogCategorieName']],[$entity['visites']]];
        }
        return $realEntities;
    }

    public function searchAjaxFinalAction(Request $request){
        $requestString = $request->get('q');

    }

    public function BlogCommentsComponentAction(Blog $blog){
        //$blog = $this->getDoctrine()->getRepository('BlogBundle:Blog')->findOneById($idBlog);
        $comments = $this->getDoctrine()->getRepository('BlogBundle:Comment')->findByBlog($blog);

        return $this->render('blog/BlogCommentsComponent.html.twig',array('comments'=>$comments));
    }

    public function BlogCommentsComponentAjaxAction(Request $request){
        $blogId = $request->get('blog_id');
        //$monthId = $request->get('month_id');


        $blog = $this->getDoctrine()->getRepository('BlogBundle:Blog')->findOneById($blogId);
        $template = $this->forward('BlogBundle:Blog:BlogCommentsComponent',array('id' => $blog->getId()))->getContent();

        //dump($template);die;
        $json = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}
