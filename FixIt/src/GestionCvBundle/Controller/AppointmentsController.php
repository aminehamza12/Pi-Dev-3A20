<?php

namespace GestionCvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Include the used classes as JsonResponse and the Request object
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// The entity of your Appointment
use GestionCvBundle\Entity\Appointments as Appointment;

class AppointmentsController extends Controller
{

    public function indexAction()
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $em = $this->getDoctrine()->getManager();


        $repositoryAppointments = $em->getRepository("GestionCvBundle:Appointments");


        $appointments = $repositoryAppointments->findby(array('user'=>$user));

        $formatedAppointments = $this->formatAppointmentsToJson($appointments);

        // Render scheduler
        return $this->render("appointments/index.html.twig", [
            'appointments' => $formatedAppointments,'user'=>$user
        ]);
    }


    /**
     * Handle the creation of an appointment.
     *
     */
    public function createAction(Request $request){
        $em = $this->getDoctrine()->getManager();


        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Create appointment entity and set fields values
        $appointment = new Appointment();
        $appointment->setTitle($request->request->get("title"));
        $appointment->setDescription($request->request->get("description"));
        $appointment->setStartdate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $appointment->setEnddate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $appointment->setUser($user);

        // Create appointment
        $em->persist($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }


    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAppointments = $em->getRepository("GestionCvBundle:Appointments");

        $appointmentId = $request->request->get("id");

        $appointment = $repositoryAppointments->find($appointmentId);

        if(!$appointment){
            return new JsonResponse(array(
                "status" => "error",
                "message" => "The appointment to update $appointmentId doesn't exist."
            ));
        }

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Update fields of the appointment
        $appointment->setTitle($request->request->get("title"));
        $appointment->setDescription($request->request->get("description"));
        $appointment->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $appointment->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $appointment->setUser(null);

        // Update appointment
        $em->persist($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     * Deletes an appointment from the database
     *
     */
    public function deleteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAppointments = $em->getRepository("GestionCvBundle:Appointments");

        $appointmentId = $request->request->get("id");

        $appointment = $repositoryAppointments->find($appointmentId);

        if(!$appointment){
            return new JsonResponse(array(
                "status" => "error",
                "message" => "The given appointment $appointmentId doesn't exist."
            ));
        }

        // Remove appointment from database !
        $em->remove($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    private function formatAppointmentsToJson($appointments){
        $formatedAppointments = array();

        foreach($appointments as $appointment){
            array_push($formatedAppointments, array(
                "id" => $appointment->getId(),
                "description" => $appointment->getDescription(),
                // Is important to keep the start_date, end_date and text with the same key
                // for the JavaScript area
                // altough the getter could be different e.g:
                // "start_date" => $appointment->getBeginDate();
                "text" => $appointment->getTitle(),
                "start_date" => $appointment->getStartDate()->format("Y-m-d H:i"),
                "end_date" => $appointment->getEndDate()->format("Y-m-d H:i"),
                "user"=> null
            ));
        }

        return json_encode($formatedAppointments);
    }
}