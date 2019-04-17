<?php

namespace QRBundle\Controller;

use EventBundle\Entity\Event;
use http\Client\Curl\User;
use http\Env\Response;
use QRBundle\Entity\Question;
use QRBundle\Entity\Rating;
use QRBundle\Entity\Reponse;
use QRBundle\Entity\Signaler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {


        $qs_repo = $this->getDoctrine()->getRepository(Question::class);
        $qs = $qs_repo->getNombreReponseParPost();
        $qs1 = $qs_repo->lastLogin();
        $qs2 = $qs_repo->recentReplies();
    //   echo  $c=  $request->get('variable');

       $titre=  $request->get('codepostal');

       $contenu =$request->get('codepostal1');

        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        date_default_timezone_set('Africa/Tunis');
        $time =  date('yyyy-mm-dd');








        //  $qs1=$qs_repo->getNombreReponseParPost();

        return $this->render("@QR/Default/AcceuilQR.html.twig", array('questions' => $qs, 'logins' => $qs1, 'reply' => $qs2 , 'usrs' => $usr, 'com' =>$request));
    }




    public function createQrAction(Request $request)
    {

        $session=$request->getSession();
        $session->set('maVariable','aymen');
        $post = new Question();
        $form = $this->createFormBuilder($post)
            ->add('titreQuestion', TextType::class, array('attr' => array('class' => 'form-control','name' =>'darnassus', 'style' => 'margin-top:10px;width:50%;margin-left:250px') ))
            ->add('contenuQuestion', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-top:10px;width:50%;height:60px;margin-left:250px')))
            ->add('Save', SubmitType::class, array('label' => 'Create Post', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px;margin-left:550px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usr = $this->get('security.token_storage')->getToken()->getUser();
            $usr->getId();
            $usr = $usr->__toString();
            $usr = intval($usr);

            $titreQuestion = $form['titreQuestion']->getData();
            $contenuQuestion = $form['contenuQuestion']->getData();

            date_default_timezone_set('Africa/Tunis');
            $time = date('H:i:s \O\n d/m/Y');

            $post->setId($usr);
            $post->setTitreQuestion($titreQuestion);
            $post->setContenuQuestion($contenuQuestion);
            $post->setDateQuestion($time);


            //   $question=$this->getDoctrine()->getRepository(Event::class)
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('message', 'Post Created Successfully!');
            return $this->redirectToRoute('qr_homepage');

        }
        return $this->render("@QR/Default/CreateQR.html.twig", ['form' => $form->createView()]);


    }

    public function myPostsAction()
    {

        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        $qs_repo = $this->getDoctrine()->getRepository(Question::class);
        $qs3 = $qs_repo->myPosts($usr);
        $qs1 = $qs_repo->lastLogin();
        $qs2 = $qs_repo->recentReplies();


        return $this->render("@QR/Default/MyPostsQR.html.twig", array('posts' => $qs3, 'logins' => $qs1, 'reply' => $qs2,'usrs' => $usr));
    }


    public function myPosts1Action(Request $request,$id)
    {

        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($id);
        $qs5=$qs_repo->getNbreReponseParQuestion($id);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

         ////////// modifier ma question //////////////
        $post = $this->getDoctrine()->getRepository('QRBundle:Question')->find($id);
        $post->setTitreQuestion($post->getTitreQuestion());
        $post->setContenuQuestion($post->getContenuQuestion());
        $form = $this->createFormBuilder($post)
            ->add('titre_question', TextType::class, array(('attr') => array('class' => 'form-control')))
            ->add('contenu_question', TextareaType::class, array(('attr') => array('class' => 'form-control','style' =>'height:200px')))
            ->add('save', SubmitType::class, array('label' => 'Modifer', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre_question = $form['titre_question']->getData();
            $contenu_question = $form['contenu_question']->getData();

            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('QRBundle:Question')->find($id);
            $post->setTitreQuestion($titre_question);
            $post->setContenuQuestion($contenu_question);
            $em->flush();
            $this->addFlash('message', 'Post Updated Successfully!');
            return $this->redirectToRoute('qr_myposts1', ['id' => $id]);


            }









            return $this->render("@QR/Default/MyPostsQR1.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form->createView()));


    }


    public function myPosts2Action(Request $request,$id)
    {

        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($id);
        $qs5=$qs_repo->getNbreReponseParQuestion($id);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        $qs6=$qs_repo1->getexistsig($usr,$id);



        ////////////////ajouter reponse//////////////////////



        $post1 = new Reponse();
        $form1 = $this->createFormBuilder($post1)
            ->add('contenu_Reponse', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-top:10px','style' =>'height:200px')))
            ->add('Save', SubmitType::class, array('label' => 'Post Comment', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px')))
            ->getForm();
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {


            $contenu_Reponse = $form1['contenu_Reponse']->getData();

            date_default_timezone_set('Africa/Tunis');
            $time1 = date('H:i:s \O\n d/m/Y');

            $post1->setId($usr);
            $post1->setIdQuestion($id);
            $post1->setContenuReponse($contenu_Reponse);
            $post1->setDateReponse($time1);



            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($post1);
            $em1->flush();
            $this->addFlash('message', 'Comment  Created Successfully!');
            return $this->redirectToRoute('qr_myposts2', ['id' => $id]);

        }

        return $this->render("@QR/Default/MyPostsQR2.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form1->createView(),'sigt' =>$qs6));


    }





    public function supprimerquestionAction( $id)
    {
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs_repo1->supprimerQuestion($id);


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        $qs_repo = $this->getDoctrine()->getRepository(Question::class);
        $qs3 = $qs_repo->myPosts($usr);
        $qs1 = $qs_repo->lastLogin();
        $qs2 = $qs_repo->recentReplies();




        return $this->render("@QR/Default/MyPostsQR.html.twig", array('posts' => $qs3, 'logins' => $qs1, 'reply' => $qs2));



    }






    public  function ajouterRateAction(Request $request,$id,$idr,$idu)
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);


        $qs_repo1 = $this->getDoctrine()->getRepository(Rating::class);
        $qs_repo1->AjouterRate($usr,$idr);


        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($id);
        $qs5=$qs_repo->getNbreReponseParQuestion($id);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);


        $post = $this->getDoctrine()->getRepository('QRBundle:Question')->find($id);
        $post->setTitreQuestion($post->getTitreQuestion());
        $post->setContenuQuestion($post->getContenuQuestion());
        $form = $this->createFormBuilder($post)
            ->add('titre_question', TextType::class, array(('attr') => array('class' => 'form-control')))
            ->add('contenu_question', TextareaType::class, array(('attr') => array('class' => 'form-control','style' =>'height:200px')))
            ->add('save', SubmitType::class, array('label' => 'Modifer', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre_question = $form['titre_question']->getData();
            $contenu_question = $form['contenu_question']->getData();

            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('QRBundle:Question')->find($id);
            $post->setTitreQuestion($titre_question);
            $post->setContenuQuestion($contenu_question);
            $em->flush();
            $this->addFlash('message', 'Post Updated Successfully!');
            return $this->redirectToRoute('qr_myposts1', ['id' => $id]);


        }
        if ($usr==$idu)
        return $this->render("@QR/Default/MyPostsQR1.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form->createView()));
        else
            return $this->render("@QR/Default/MyPostsQR2.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form->createView()));

    }



    public  function ajouterUnRateAction(Request $request,$id,$idr,$idu)
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);


        $qs_repo1 = $this->getDoctrine()->getRepository(Rating::class);
        $qs_repo1->AjouterUnRate($usr,$idr);


        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($id);
        $qs5=$qs_repo->getNbreReponseParQuestion($id);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);


        $post = $this->getDoctrine()->getRepository('QRBundle:Question')->find($id);
        $post->setTitreQuestion($post->getTitreQuestion());
        $post->setContenuQuestion($post->getContenuQuestion());
        $form = $this->createFormBuilder($post)
            ->add('titre_question', TextType::class, array(('attr') => array('class' => 'form-control')))
            ->add('contenu_question', TextareaType::class, array(('attr') => array('class' => 'form-control','style' =>'height:200px')))
            ->add('save', SubmitType::class, array('label' => 'Modifer', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre_question = $form['titre_question']->getData();
            $contenu_question = $form['contenu_question']->getData();

            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('QRBundle:Question')->find($id);
            $post->setTitreQuestion($titre_question);
            $post->setContenuQuestion($contenu_question);
            $em->flush();
            $this->addFlash('message', 'Post Updated Successfully!');
            return $this->redirectToRoute('qr_myposts1', ['id' => $id]);


        }
        if($usr==$idu)
        return $this->render("@QR/Default/MyPostsQR1.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form->createView()));
        else
            return $this->render("@QR/Default/MyPostsQR2.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form->createView()));
    }




    public function  signalerQuestionAction(Request $request,$id)
    {

        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);



        $post = new Signaler();
        $form = $this->createFormBuilder($post)
            ->add('cause', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-top:10px;width:50%;height:60px;margin-left:300px')))
            ->add('Save', SubmitType::class, array('label' => 'Report', 'attr' => array('class' => 'btn btn-danger', 'style' => 'margin-top:20px;margin-left:600px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usr = $this->get('security.token_storage')->getToken()->getUser();
            $usr->getId();
            $usr = $usr->__toString();
            $usr = intval($usr);

            $cause = $form['cause']->getData();


            date_default_timezone_set('Africa/Tunis');
            $time = date('H:i:s \O\n d/m/Y');

            $post->setId($usr);
            $post->setCause($cause);
            $post->setIdQuestion($id);
            $post->setDateSignaler($time);
            $post->setSig(1);


            //   $question=$this->getDoctrine()->getRepository(Event::class)
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('message', 'Post Created Successfully!');
            return $this->redirectToRoute('qr_homepage');

        }




        return $this->render("@QR/Default/SignalerQuestion.html.twig", array('usrs' => $usr,'questions' => $qs1,'form' => $form->createView()));

    }




    public function supprimerreponseAction(Request $request,$id,$idq)
    {
        $qs_repo1 = $this->getDoctrine()->getRepository(Reponse::class);
        $qs_repo1->supprimerReponse($id);


        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($idq);
        $qs5=$qs_repo->getNbreReponseParQuestion($idq);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($idq);


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);



        $post1 = new Reponse();
        $form1 = $this->createFormBuilder($post1)
            ->add('contenu_Reponse', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-top:10px','style' =>'height:200px')))
            ->add('Save', SubmitType::class, array('label' => 'Post Comment', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px')))
            ->getForm();
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {


            $contenu_Reponse = $form1['contenu_Reponse']->getData();

            date_default_timezone_set('Africa/Tunis');
            $time1 = date('H:i:s \O\n d/m/Y');

            $post1->setId($usr);
            $post1->setIdQuestion($idq);
            $post1->setContenuReponse($contenu_Reponse);
            $post1->setDateReponse($time1);



            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($post1);
            $em1->flush();
            $this->addFlash('message', 'Comment  Created Successfully!');
            return $this->redirectToRoute('qr_myposts2', ['id' => $idq]);

        }






        return $this->render("@QR/Default/MyPostsQR2.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5,'form' => $form1->createView()));



    }


    public  function modifierReponseAction(Request $request,$id_r,$id_q)

    {


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);


        $post = $this->getDoctrine()->getRepository('QRBundle:Reponse')->find($id_r);
        $post->setContenuReponse($post->getContenuReponse());
        $form = $this->createFormBuilder($post)
            ->add('contenu_reponse', TextareaType::class, array(('attr') => array('class' => 'form-control','style' => 'margin-top:10px;width:50%;height:120px;margin-left:300px' )))
            ->add('save', SubmitType::class, array('label' => 'Modifer', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:20px;margin-left:600px')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contenu_reponse = $form['contenu_reponse']->getData();

            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('QRBundle:Reponse')->find($id_r);
            $post->setContenuReponse($contenu_reponse);
            $em->flush();
            $this->addFlash('message', 'Post Updated Successfully!');
            return $this->redirectToRoute('qr_myposts2', ['id' => $id_q]);


        }


        return $this->render("@QR/Default/ModifierReponse.html.twig", array('form' => $form->createView()));
    }



    public function indexAdminAction(Request $request)
    {

        $qs_repo = $this->getDoctrine()->getRepository(Question::class);
        $qs = $qs_repo->getNombreReponseParPost();
        $qs1 = $qs_repo->lastLogin();
        $qs2 = $qs_repo->recentReplies();

        $nbsig_repo = $this->getDoctrine()->getRepository(Signaler::class);

        $nbsig=$nbsig_repo->getnbrsig();










        return $this->render("@QR/Default/AcceuilAdminQR.html.twig",array('questions' => $qs, 'logins' => $qs1, 'reply' => $qs2 ,'nbrs' =>$nbsig ));
    }



    public function myPostsAdmin1Action(Request $request,$id)
    {

        $qs_repo = $this->getDoctrine()->getRepository(Reponse::class);
        $qs = $qs_repo->getReponseParIdQuestion($id);
        $qs5=$qs_repo->getNbreReponseParQuestion($id);
        $qs_repo1 = $this->getDoctrine()->getRepository(Question::class);
        $qs1 = $qs_repo1->getQuestionParId($id);


        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);





        return $this->render("@QR/Default/MyPostsAdminQR1.html.twig", array('reponses' => $qs,'usrs' => $usr, 'questions' => $qs1,'nbrs' => $qs5));


    }





    public function affichersignalerqrAction()
    {


        $nbsig_repo = $this->getDoctrine()->getRepository(Signaler::class);
        $siga=$nbsig_repo->getsignaler();







        return $this->render("@QR/Default/AfficherSignalerAdmin.html.twig" ,array('sigas' => $siga));

    }

    public function marquerluAction($id,$id_q)
    {


        $nbsig_repo = $this->getDoctrine()->getRepository(Signaler::class);
        $siga=$nbsig_repo->getsignaler();

        $nbsig_repo1=$this->getDoctrine()->getRepository(Signaler::class);
        $siga1=$nbsig_repo1->setsiglu($id,$id_q);





       return  $this->redirectToRoute("qr_affichersignaler" ,array('sigas' => $siga));

    }



    public function supprimersigquestAction($id,$id_q)
    {


        $nbsig_repo = $this->getDoctrine()->getRepository(Signaler::class);
        $siga=$nbsig_repo->getsignaler();

        $nbsig_repo1=$this->getDoctrine()->getRepository(Question::class);
        $siga1=$nbsig_repo1->supprimerQuestion($id_q);





        return $this->redirectToRoute("qr_affichersignaler" ,array('sigas' => $siga));

    }




    public function createqrsoundAction(Request $request)
    {


        return $this->render("@QR/Default/CreateQrSound.html.twig" );
    }


    public function createqrsoundfAction(Request $request)
    {



        $qs_repo = $this->getDoctrine()->getRepository(Question::class);
        $qs = $qs_repo->getNombreReponseParPost();
        $qs1 = $qs_repo->lastLogin();
        $qs2 = $qs_repo->recentReplies();
        //   echo  $c=  $request->get('variable');

        $titre=  $request->get('codepostal');

        $contenu =$request->get('codepostal1');

        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $usr = $usr->__toString();
        $usr = intval($usr);

        date_default_timezone_set('Africa/Tunis');
        $time =  date('yyyy-mm-dd');


        $qs11=$qs_repo->ajouterQuestionSound($usr,$time,$titre,$contenu);





        //  $qs1=$qs_repo->getNombreReponseParPost();

        return $this->redirectToRoute('qr_homepage');
    }
}
