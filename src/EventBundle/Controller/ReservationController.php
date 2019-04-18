<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15/04/2019
 * Time: 21:56
 */

namespace EventBundle\Controller;
use EventBundle\Entity\Reservation;
use EventBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends Controller
{
    public function ajoutReservationAction(Request $request,$id)
    {$em=$this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $a= $em->getRepository('EventBundle:Hebergement')->find($id);
        $form->handleRequest($request);

       // $ras=$em->getRepository('SlimBundle:Favoris')->findBy(array('idEtablissement'=>$id,'id_user'=>$this->getUser(),'date'=>$form['date'] ));

        if ($form->isSubmitted()) {
            $res=$em->getRepository('EventBundle:Reservation')->findBy(array('idhebergement'=>$id));
            foreach ($res as $ress){
                if ($ress->getIduser()==$this->getUser() and $ress->getIdhebergement()==$a and $ress->getDated()==$form['dated'] and $ress->getDatef()==$form['datef'] ){
                    return die('vous avez déja résérver');
                }

            }
            $nbe=0;
            foreach($res as $ress)
            {
                $nbe=$nbe+$ress->getNb();
            }

            $nbplace=$form['nombre']->getData();
            $mbm=$nbplace+$nbe;
            if($form['dated']->getData()<new \DateTime('now')){
                return die('la date n est pas valide');
            }

            $b=$em->getRepository('EventBundle:Hebergement')->find($id);
            $nb=$b->getPlace();
            if($nb-$mbm>0) {

              //  die('vous avez déja reserver');

                $reservation->setIduser($this->getUser());
                $reservation->setIdhebergement($a);
                $reservation->setNb($nbplace);
                $em->persist($reservation);
                $em->flush();
                //return $this->redirectToRoute("App_bon_plan_list_restaurant");
            }
          //  else die("nombre de place non possible".$mbm);

        }
        return $this->render("EventBundle:Event:AjouterReservation.html.twig",
            array('form' => $form->createView()

            ));

    }

    /**
     * @Route("/calendar", name="booking_calendar")
     */
    public function calendarAction()
    {
        return $this->render("EventBundle:Event:calendar.html.twig");
    }


}