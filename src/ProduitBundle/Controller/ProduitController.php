<?php

namespace ProduitBundle\Controller;


use ProduitBundle\Entity\Produit;
use ProduitBundle\Entity\Categorie;
use ProduitBundle\Entity\Produitcomment;
use ProduitBundle\Entity\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ProduitBundle\Repository\ProduitRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
/**
 * Produit controller.
 *
 * @Route("produit")
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produit_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        $dql = "select bp from ProduitBundle:Produit bp";
        $query = $em->createQuery($dql);
        $categories = $em->getRepository('ProduitBundle:Categorie')->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result = $paginator->paginate(
          $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',12)


        );
        dump(get_class($paginator));

        return $this->render('ProduitBundle:produit:index.html.twig', array(
            'produits' => $result,'categories' => $categories
        ));
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file;
             */
            $file=$produit->getImage();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$fileName);
            $produit->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_indexadmin', array('id' => $produit->getId()));
        }
        return $this->render('ProduitBundle:produit:new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/show/{id}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ProduitBundle:Categorie')->findAll();
        return $this->render('ProduitBundle:produit:show.html.twig', array(
            'categories'=>$categories,
            'produit' => $produit,

        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('ProduitBundle:produit:edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_indexadmin');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all produit entities.
     *
     * @Route("/admin", name="produit_indexadmin")
     * @Method("GET")
     */

    public function  indexadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "select bp from ProduitBundle:Produit bp";
        $query = $em->createQuery($dql);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',9)


        );
        dump(get_class($paginator));

        return $this->render('ProduitBundle:produit:indexAdmin.html.twig', array(
            'produits' => $result,
        ));
    }


    public function wishlistAction($id)
    {

        $wish= new Wishlist();//new wishlist
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ProduitBundle:Produit')->findOneBy($id);
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $wishes = $em->getRepository('ProduitBundle:Wishlist')->findAll();
        return $this->render('ProduitBundle:produit:wishlist.html.twig', array(
            'produits' => $wishes,
        ))

        ;
    }

    public function getProduitByCatAction(Categorie $categorie, Request $request)
    {
        //var_dump($categorie);
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitBundle:Produit')->findBy(array('idCat' => $categorie));
        $categories = $em->getRepository('ProduitBundle:Categorie')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result = $paginator->paginate(
            $produits,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',12)


        );
        dump(get_class($paginator));
        return $this->render('ProduitBundle:produit:categorie.html.twig', array(
            'produits' => $result,'categories' => $categories
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $produits =  $em->getRepository('ProduitBundle:Produit')->findEntitiesByString($requestString);
        if(!$produits) {
            $result['produits']['error'] = "Post Not found :( ";
        } else {
            $result['produits'] = $this->getRealEntities($produits);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($produits){
        foreach ($produits as $produits){
            $realEntities[$produits->getId()] = [$produits->getImage(),$produits->getNomProd()];
        }
        return $realEntities;
    }





    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}/avis/", name="produit_avis")
     * @Method("GET")
     */
    public function AvisAction(Produit $produit)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('ProduitBundle:Produitcomment')->findBy(array('idProd' => $produit), array('postedAt' => 'asc'));
        return $this->render('ProduitBundle:produit:avis.html.twig', array(
            'produit' => $produit,
            'comm' => $comments
        ));
    }

    public function statAction()
    {

        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $reservation = $em->getRepository(Produit::class)->findAll();

        $data=array();
        $stat=['id', 'quantite'];
        array_push($data,$stat);
        foreach($reservation as $reservations) {
            $nb = $reservations->getQuantite();
            $id = (string)$reservations->getNomProd();
            $stat=array();
            array_push($stat,$id,$nb);
            $stat=[$id,$nb];
            array_push($data ,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );

        $pieChart->getOptions()->setTitle('Statistique');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('ProduitBundle:produit:stat.html.twig', array('piechart' => $pieChart,'produits'=>$reservation));

    }


    // Crud Comment
    public function ajoutComAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $comajout = new Produitcomment();
        $produit = $em->getRepository('ProduitBundle:Produit')->find($req->get('id'));

        $comajout->setIdUser($this->getUser());
        $comajout->setIdProd($produit);
        $comajout->setContent($req->get('com'));
        $em->persist($comajout);
        $em->flush();

        $commentaires = $em->getRepository('ProduitBundle:Produitcomment')->findBy(array('idProd' => $produit), array('postedAt' => 'asc'));

        $data = $this->render('ProduitBundle:produit:Commentaire.html.twig', array(
            'com' => $commentaires));

        $html = $data->getContent();
        $jsonArray = array('data' => $html);
        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    public function SupprimerAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id = $request->get('input');
            $em = $this->getDoctrine()->getManager();
            $comment = $em->getRepository('ProduitBundle:Produitcomment')->find($id);
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('produit_avis', array('id' => $comment->getIdProd()->getId()));
        }
    }


}
