<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21/03/2019
 * Time: 23:06
 */

namespace EventBundle\Controller;


//use Composer\DependencyResolver\Request;
use EventBundle\Entity\Event;
use EventBundle\Entity\likeevent;
use EventBundle\Entity\participation;
use EventBundle\Entity\Review;
use EventBundle\Form\EventType;
use EventBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\File;


class EventController extends Controller
{
    public function addAction(Request $request)
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && ($form->isValid())) {


            /**
             * @var UploadedFile $file
             */

            $file = $event->getImageEvent();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('brochures_directory'), $fileName);

            $event->setImageEvent($fileName);
            $event->setIduser($user = $this->getUser());
            if($form['startdateevent']->getData()<new \DateTime('now') || $form['enddateevent']->getData()<$form['startdateevent']->getData()){
                return die('la date n est pas valide');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // return $this->redirect($this->generateUrl('app_product_list'));

            return $this->redirectToRoute('event_list');
        }
        return $this->render("EventBundle:Event:AddEvent.html.twig", array(
            "form" => $form->createView()));

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());

    }

    public function showAction()
    {
        $event = $this->getDoctrine()->getRepository('EventBundle:Event')->find(23);
        return $this->render('EventBundle:Event:Events.html.twig', array('Event' => $event));
    }

    public function listAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->findAll();
        if ($request->isMethod('POST')) {
            {
                $title_event = $request->get('title_event');

                $event = $em->getRepository("EventBundle:Event")
                    ->findBy(array("title_event" => $title_event));
                //  $this->redirectToRoute('App_bon_plan_list_article');
            }
        }

        /////nearest event
        $dql = "select Event from EventBundle:Event Event ORDER BY Event.startdateevent ASC ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/);


        return $this->render("EventBundle:Event:Events.html.twig",
            array('Event' => $event,
                'pagination' => $pagination,

            ));

    }


    public function singleAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        //   $Themes = $em->getRepository("OnsBundle:Theme")->findAll();
        $event = $em->getRepository("EventBundle:Event")
            ->find($id);
        $title = $event->getTitleEvent();
        $type = $event->getTypeEvent();
        $desc = $event->getDescriptionEvent();
        $datestart = $event->getStartdateevent();
        $dateend = $event->getEnddateevent();
        $adresseE = $event->getAdresseEvent();
        $image = $event->getImageEvent();
        $typeH = $event->getTypeHebergement();
        $adresseH = $event->getAdressehebergement();
        $user = $event->getIduser();
        $comments = $event->getCommentCount();
        $likes = $event->getLikeCount();
        $part = $event->getPartCount();




        /////add Comment
        $Review = new Review();
        $Review->setIdEvent($event);
        $Review->setIduser($this->getUser());
        $Review->setDate(new \DateTime('now'));
        $form = $this->createForm(ReviewType::class, $Review);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Review);
            $em->flush();

            return $this->redirectToRoute('event_single', array('id' => $id));
        }

        ////affiche comment
        $dql = "select Review from EventBundle:Review Review WHERE Review.idEvent=$id";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $Commentaires = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $test = $em->getRepository("EventBundle:likeevent")->findBy(array('idevent' => $id, 'iduser' => $this->getUser()));
        $aime = count($test);
        $participe = count($test);
        return $this->render("EventBundle:Event:SingleEvent.html.twig"
            , array(
                "id" => $id,
                "titleEvent" => $title,
                "typeEvent" => $type,
                "descriptionEvent" => $desc,
                "startdateevent" => $datestart,
                "enddateevent" => $dateend,
                "adresseEvent" => $adresseE,
                "imageEvent" => $image,
                "typeHebergement" => $typeH,
                "adressehebergement" => $adresseH,
                "iduser" => $user->getUsername(),
                "form" => $form->createView(),
                "Commentaires" => $Commentaires,
                "comments" => $comments,
                "likes" => $likes,
                'aime' => $aime,
                'participe'=>$participe,
                'part'=>$part,


            ));
    }

    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventBundle:Event")->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('event_list');
    }

    public function updateAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventBundle:Event")
            ->find($id);

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isValid() && ($form->isValid())) {
            $file = $event->getImageEvent();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move($this->getParameter('brochures_directory'), $fileName);
            $event->setImageEvent($fileName);

            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('event_list');
        }
        return $this->render("EventBundle:Event:UpdateEvent.html.twig"
            , array("form" => $form->createView()));
    }

    public function addLikeAction($id)
    {
        $Aime = new likeevent();
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository("EventBundle:likeevent")->findBy(array('idevent' => $id, 'iduser' => $this->getUser()));
        $p = count($test);
        if ($p == 0) {
            $event = $em->getRepository("EventBundle:Event")->find($id);
            $Aime->setIduser($this->getUser());
            $Aime->setIdevent($event);
            $em->persist($Aime);
            $em->flush();
            $like = $em->getRepository("EventBundle:likeevent")->findBy(array('idevent' => $id));
            $a = count($like);
            $event->setNbreLike($a);
            $em->persist($event);
            $em->flush();
        }


        return $this->redirectToRoute("event_single", array(
            'id' => $id
        ));
    }

    public function deleteLikeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Like = $em->getRepository("EventBundle:likeevent")->findBy(array('idevent' => $id, 'iduser' => $this->getUser()));
        $event = $em->getRepository("EventBundle:Event")->find($id);
        $em->remove($Like[0]);
        $em->flush();
        $event->setNbrelike($event->getLikeCount());
        $em->persist($event);
        $em->flush();


        return $this->redirectToRoute('event_single', array('id' => $id));

    }

    public function deleteCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('EventBundle:Review')->find($id);
        // $event=$comment->getIdEvent();
        $event = $comment->getIdEvent();
        $em->remove($comment);
        $em->flush();
        $ev = $em->getRepository('EventBundle:Event')->find($event);
        $id = $ev->getId();

        return $this->redirectToRoute('event_single', array('id' => $id));
    }



    public function addparticipeAction(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);
        $test = $em->getRepository('EventBundle:participation')->findBy(array('idevent' => $id, 'iduser' => $this->getUser()));
        $p = count($test);
        if ($p == 0) {
            if ($event->getNbrplaceEvent() > $event->getNbrPart()) {
                $event->setNbrPart($event->getNbrPart() + 1);
                $em->persist($event);
                $participe = new participation();
                $participe->setIdevent($event);
                $participe->setIduser($user);
                $em->persist($participe);
                $em->flush();
            } else {
                die("Nous sommes désolé il n'y a plus de places !");
            }
        } else
            $request->getSession()->getFlashBag()->add('success', 'Vous avez déja participé');
        return $this->redirectToRoute("event_single", array(
            'id' => $id
        ));
    }


    public function deleteparticipeAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventBundle:participation")->findBy(array('idevent'=>$id,'iduser'=>$this->getUser()));
        $ev = $em->getRepository("EventBundle:Event")->find($id);

        $em->remove($event[0]);
        $em->flush();
        $ev->setNbrPart($ev->getPartCount());
        $em->persist($ev);
        $em->flush();
        return $this->redirectToRoute('event_single', array('id' => $id));
    }
    public function searchAjaxAction($title)

    {

        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository("EventBundle:Event")->FindByLetters($title);
        return $this->render("EventBundle:Event:listEvents.html.twig",
            array('Event' => $article,
            ));
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);


        $normalizer->setCircularReferenceHandler(function ($article) {
            return $article->getId();
        });
        $s = new Serializer(array($normalizer));
        $articles = $s->normalize($article,'json');
        $response = new JsonResponse();
        return $response->setData(array('articles'=>$articles));
    }
    public function listtypeAction(Request $request)
    {
        $id = $request->get('typeEvent');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventBundle:Event")->findBy(array('typeEvent' => $id));
        $dql = "select Event from EventBundle:Event Event";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        /////nearest event
        $dql = "select Event from EventBundle:Event Event ORDER BY Event.startdateevent DESC ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/);

        $em1 = $this->getDoctrine()->getManager();
        return $this->render("EventBundle:Event:Events.html.twig",
            array('Event' => $event,
                'pagination' => $pagination,

            ));

    }

}