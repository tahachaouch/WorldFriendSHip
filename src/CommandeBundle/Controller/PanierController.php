<?php

namespace CommandeBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CommandeBundle\Entity\LigneCommande;
use CommandeBundle\Entity\Panier;
use CommandeBundle\Entity\Produit;
use CommandeBundle\Entity\Promotion;
use CommandeBundle\Form\PromotionType;
use PhpParser\Node\Scalar\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class PanierController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        $dql = "select p from CommandeBundle:Produit p";
        $query = $em->createQuery($dql);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)


        );
        dump(get_class($paginator));

        return $this->render('CommandeBundle:Default:shop.html.twig', array(
            'produits' => $result,
        ));
    }

    public function cartAction(Request $request)
    { $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $id= $this->getUser()->getId() ;
        $repo=$this->getDoctrine()->getRepository(Panier::class);
        $panier=$repo->findOneBy(array('etat' => 0, 'idUser' =>$id));
        $panId=$panier->getIdPanier();
        //$prods=$repo2->findBy(array('idPanier' =>$panier->getIdPanier()));
        $q= $this->getDoctrine()->getEntityManager()->createQuery("select l.idPanier, p.idProd,p.nomProd,p.prix,p.image,l.quantite from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where l.idPanier=$panId and p.idProd=l.idProd");
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.prix ,l.quantite   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where l.idPanier=$panId and p.idProd=l.idProd");
        $prixProd=$q2->getResult();




        $produits = $q->getResult();
//foreach ($prixProd as $produit)
        //  $total=+$produit->getQuantite()*$produit->getPrix();

        $total=150;


        return $this->render('CommandeBundle:Default:cart.html.twig',
            ['controller_name'=>'PanierController',
                'produits'=>$produits,
                'total'=>$total
            ]);

    }

    public function AfficheCartAction(Request $request) {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $iduser= $this->getUser()->getId() ;
        $repo=$this->getDoctrine()->getRepository(Panier::class);
        $panier=$repo->findOneBy(array('etat' => 0, 'idUser' =>$iduser));
        if ($panier!=null)
        { $panId=$panier->getIdPanier();}
        else
        {$panId=0;}
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.prix ,l.quantite ,promo.pourcentage   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p ,CommandeBundle\Entity\Promotion promo  where l.idPanier=$panId and p.idProd=l.idProd and promo.idProd=p.idProd");
        $prixProd=$q2->getResult();
        $total=0;
        $remise=0;
        foreach ($prixProd as $produit)
        { $total=$total+$produit['quantite']*$produit['prix'];
            $remise=$remise+($produit['prix']*$produit['pourcentage']/100)*$produit['quantite'];
        }
        $totalfinal=$total-$remise+15;



        return $this->render('@Commande/Default/cart.html.twig',array('total'=>$total,'totalfinal'=>$totalfinal,'remise'=>$remise));

    }


    public function getCartAction(Request $request)
    {


        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $id= $this->getUser()->getId() ;
        // $user=$this->getDoctrine()->getRepository(User::class);
        // $userid=$user->findOneBy(array('id' => 42));
        $repo=$this->getDoctrine()->getRepository(Panier::class);
        $panier=$repo->findOneBy(array('etat' => 0, 'idUser' =>$id));
        if($panier!=null)
            $panId=$panier->getIdPanier();
        else
            $panId=0;
        //$prods=$repo2->findBy(array('idPanier' =>$panier->getIdPanier()));
        $q= $this->getDoctrine()->getEntityManager()->createQuery("select l.idPanier, p.idProd,p.nomProd,p.prix,p.image,l.quantite from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where l.idPanier=$panId and p.idProd=l.idProd");
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.prix ,l.quantite,promo.pourcentage   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p , CommandeBundle\Entity\Promotion promo where l.idPanier=$panId and p.idProd=l.idProd and promo.idProd=p.idProd");
        //$prixProd=$q2->getQuery()->getArrayResult();
        $prixProd=$q2->getResult();




        $produits = $q->getResult();
        $total=0;
        $remise=0;
        foreach ($prixProd as $produit)
        {  $total=+$produit['quantite']*$produit['prix'];
            $remise=$remise+($produit['prix']*$produit['pourcentage']/100);}



        $template = $this->render('@Commande/Default/listcart.html.twig', array('produits'=>$produits,
            'total'=>$total))->getContent();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new
        JsonEncoder()));
        $json = $serializer->serialize($template, 'json');
        return new Response($json);



    }
    /**
     * @return float
     */
    public function getTotal($panId)
    {
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.prix ,l.quantite ,promo.pourcentage   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p ,CommandeBundle\Entity\Promotion promo  where l.idPanier=$panId and p.idProd=l.idProd and promo.idProd=p.idProd");
        $prixProd=$q2->getResult();
        $total=0;
        $remise=0;
        foreach ($prixProd as $produit)
        { $total=$total+$produit['quantite']*$produit['prix'];
            $remise=$remise+($produit['prix']*$produit['pourcentage']/100)*$produit['quantite'];
        }
        $totalfinal=$total-$remise+15;
        return $totalfinal;
    }
    public function deleteAction($id)
    {$ligne=new LigneCommande();
        $em=$this->getDoctrine()->getManager();
        $ligne=$em->getRepository(LigneCommande::class)->findOneBy(array('idProd' => $id));
        $em->remove($ligne);
        $em->flush();
        return $this->redirectToRoute("commande_cart");


    }
    public function updateupAction(Request $request)
    {//$ligne=new LigneCommande();
        $qte=intval($request->request->get('qte'));
        //(if $qte)
        $prod=$request->request->get('prod');
        $panier=$request->request->get('panier');
        $em=$this->getDoctrine()->getManager();
        $ligne=$em->getRepository(LigneCommande::class)->findOneBy(array('idProd' => $prod,'idPanier' =>$panier));
        $ligne->setQuantite($ligne->getQuantite()+1);
        $em->persist($ligne);
        $em->flush();
        return new JsonResponse();


    }
    public function updatedownAction(Request $request)
    {//$ligne=new LigneCommande();
        $qte=intval($request->request->get('qte'));
        $prod=$request->request->get('prod');
        $panier=$request->request->get('panier');
        $em=$this->getDoctrine()->getManager();
        $ligne=$em->getRepository(LigneCommande::class)->findOneBy(array('idProd' => $prod,'idPanier' =>$panier));
        $ligne->setQuantite($ligne->getQuantite()-1);
        $em->persist($ligne);
        $em->flush();
        return new JsonResponse();


    }
    public function addAction($id)
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $iduser= $this->getUser()->getId() ;
        $repo=$this->getDoctrine()->getRepository(Panier::class);
        $prod=$this->getDoctrine()->getRepository(Produit::class);
        $idProd=$prod->findOneBy(array('idProd' => $id));






        $panier=$repo->findOneBy(array('etat' => 0, 'idUser' => $iduser));

        if($panier==NULL)
        {
            $newpanier=new Panier();
            $newpanier->setIdUser($iduser);
            $newpanier->setEtat(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($newpanier);
            $em->flush();

            $newid=$newpanier->getIdpanier();
            $newligne=new LigneCommande();
            $newligne->setIdpanier($newpanier->getIdPanier());

            /*  $e = $request->request->get('value');
              $q = $newligneproduit->getQuantite();
              $newligneproduit->setQuantite($e);*/
            $listpp = $this->getDoctrine()->getRepository(LigneCommande::class)->findAll();
            $i=0;
            foreach ($listpp as $value )
            {if(($value->getIdProd()==$idProd->getIdProd())&&($value->getIdPanier()==$panier->getIdpanier()))
                {
                    $i=1;

                }}
            if($i!=0)
            {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Produit déjà ajouté'
                );
            }
            else {
            $newligne->setIdProd($idProd->getIdProd());
            $newligne->setQuantite(1);

            $em->persist($newligne);
            $em->flush();}

        }
        else
        {
            $panId=$panier->getIdpanier();
            $newligne=new LigneCommande();
            $newligne->setIdpanier($panId);
            $listpp = $this->getDoctrine()->getRepository(LigneCommande::class)->findAll();
            $i=0;
            foreach ($listpp as $value )
            {
                if(($value->getIdProd()==$idProd->getIdProd())&&($value->getIdPanier()==$panier->getIdpanier()))
                {
                    $i=1;

                }}
            if($i!=0)
            {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Produit déjà ajouté'
                );
            }
            else {
                $newligne->setIdProd($idProd->getIdProd());
                $newligne->setQuantite(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($newligne);
            $em->flush();

        }}






        //return $this->render('@Hichem/Front/listproduit.html.twig');
        return $this->redirectToRoute("shop");
    }
    public function listeCommandeAction()
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $repo=$this->getDoctrine()->getRepository(Panier::class);
        $panier=$repo->findBy(array('etat' => 1));
        $q= $this->getDoctrine()->getEntityManager()->createQuery("select u.id, u.username,p.idPanier,p.dateAjout  from UserBundle\Entity\User u , CommandeBundle\Entity\Panier p   where  u.id=p.idUser and p.etat=1");
        $list = $q->getResult();
        $d=array();
        foreach ($list as $l)
        {$total=$this->getTotal($l['idPanier']);
            array_push($d,$total);
        }

        // $list=$list+$d;
        $pieChart = new PieChart();
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select l.quantite  ,p.nomProd  from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where  l.idProd=p.idProd GROUP BY p.nomProd");
        $reservations=$q2->getResult();

        //$em= $this->getDoctrine();

        $q3= $this->getDoctrine()->getEntityManager()->createQuery("select u.username ,p.idUser,sum(l.quantite) AS number from UserBundle\Entity\User u , CommandeBundle\Entity\Panier p,CommandeBundle\Entity\LigneCommande l  where  u.id=p.idUser and l.idPanier=p.idPanier GROUP BY u.username");
        $clients=$q3->getResult();

        $data=array();
        $stat=['Nom Produit', 'Quantité commandées'];
        array_push($data,$stat);
        foreach($reservations as $reservation) {
            $nb = $reservation['quantite'];
            $nom= (string)$reservation['nomProd'];
            $stat=array();
            array_push($stat,$nom,$nb);
            $stat=[$nom,$nb];
            array_push($data ,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );

        $pieChart->getOptions()->setTitle('BestSellers: Les Articles les plus commandés');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#ea4335');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(22);

        $col = new ColumnChart();
        $data2=array();
        $stat2=['Nom Client', 'Total Articles'];
        array_push($data2,$stat2);
        foreach($clients as $client) {
            $nb2 = $client['number'];
            $nom2= (string)$client['username'];
            $stat2=array();
            array_push($stat2,$nom2,$nb2);
            $stat2=[$nom2,$nb2];
            array_push($data2 ,$stat2);

        }

        $col->getData()->setArrayToDataTable(
            $data2
        );

        $col->getOptions()->setTitle('Best Clients ');
        $col->getOptions()->getTitleTextStyle()->setBold(true);
        $col->getOptions()->getTitleTextStyle()->setColor('#ea4335');
        $col->getOptions()->getTitleTextStyle()->setFontSize(22);
        $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
        $col->getOptions()->getAnnotations()->getTextStyle()->setFontSize(20);
        $col->getOptions()->getAnnotations()->getTextStyle()->setColor('#000');
        $col->getOptions()->getAnnotations()->getTextStyle()->setAuraColor('none');
        $col->getOptions()->getVAxis()->setTitle('Rating (scale of 1-10)');
        $col->getOptions()->setWidth(900);
        $col->getOptions()->setHeight(500);

        return $this->render('CommandeBundle:Default:listCommandeAdmin.html.twig',
            ['controller_name'=>'PanierController',
                'list'=>$list,
                'tot'=>$d,
                'panier'=>$panier,
                'piechart' => $pieChart,'LigneCommande'=>$reservations,
                'piechart2' => $col,'clients'=>$clients
            ]);

    }
    public function listeCommandeDeleteAction($id)
    {

        $panier=new Panier();
        $em=$this->getDoctrine()->getManager();
        $panier=$em->getRepository(Panier::class)->findOneBy(array('idPanier' => $id));
        $ligne=$em->getRepository(LigneCommande::class)->findBy(array('idPanier' => $id));
        $em->remove($panier);
        $em->flush();
        foreach ($ligne as $l)
        {  $em->remove($l);
            $em->flush();}
        return $this->redirectToRoute("commande_list_admin");

    }

    public function listePromotionAction(Request $request)
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $repo=$this->getDoctrine()->getRepository(Promotion::class);
        $q= $this->getDoctrine()->getEntityManager()->createQuery("select u.idPromo,u.datePromo,u.description,u.pourcentage,p.nomProd  from CommandeBundle\Entity\Promotion u , CommandeBundle\Entity\Produit p  where  u.idProd=p.idProd");
        $list = $q->getResult();
        $promo=new Promotion();
        $editForm = $this->createForm('CommandeBundle\Form\PromotionType',$promo);
        $editForm->add('idProd',EntityType::class,array(
                'class'  => Produit::class,
                'choice_label' => 'nomProd',
                'placeholder' => 'Liste des Produits',
            )
        );


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('commande_promotion');
        }

        return $this->render('CommandeBundle:Default:listPromotion.html.twig',
            ['controller_name'=>'PanierController',
                'list'=>$list,
                'form' => $editForm->createView(),]);

    }
    public function checkoutAction()
    {$total=150;
        return $this->render('CommandeBundle:Default:checkout.html.twig', ['controller_name'=>'PanierController',
                'total'=>$total,]
        );
    }
    public function payementAction()
    {$total=0;
        $remise=0;
        { $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
            $id= $this->getUser()->getId() ;
            // $user=$this->getDoctrine()->getRepository(User::class);
            // $userid=$user->findOneBy(array('id' => 42));
            $repo=$this->getDoctrine()->getRepository(Panier::class);
            $panier=$repo->findOneBy(array('etat' => 0, 'idUser' =>$id));
            $panId=$panier->getIdPanier();
            //$prods=$repo2->findBy(array('idPanier' =>$panier->getIdPanier()));
            $q= $this->getDoctrine()->getEntityManager()->createQuery("select l.idPanier, p.idProd,p.nomProd,p.prix,p.image,l.quantite,p.quantite AS stock from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where l.idPanier=$panId and p.idProd=l.idProd");
            $produits = $q->getResult();
            $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.idProd, p.prix*l.quantite AS Total,p.prix ,l.quantite,promo.pourcentage,p.quantite AS stock   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p , CommandeBundle\Entity\Promotion promo where l.idPanier=$panId and p.idProd=l.idProd and promo.idProd=p.idProd");
            $prixProd=$q2->getResult();
            foreach ($prixProd as $produit)
            { $total=$total+$produit['Total'];
                $remise=$remise+($produit['prix']*$produit['pourcentage']/100)*$produit['quantite'];
                $quant=$produit['stock']-$produit['quantite'];
                $em=$this->getDoctrine()->getManager();
                $prod=$em->getRepository(Produit::class)->findOneBy(array('idProd' => $produit['idProd']));
                $prod->setQuantite($quant);
                $em->persist($prod);
                $em->flush();
            }
            $totalfinal=$total-$remise+15;

            $td=$total*0.33;


            return $this->render('CommandeBundle:Default:payement.html.twig', ['controller_name'=>'PanierController',
                    'total'=>$total,
                    'remise'=>$remise,
                    'produits'=>$produits,
                    'totalDollar'=>$td,
                    'totalfinal'=>$totalfinal,]
            );
        }
    }
    public function valideAction()
    {$total=0;
        $remise=0;
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $id= $this->getUser()->getId() ;
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository(Panier::class);
        $panier=$repo->findOneBy(array('etat' => 0, 'idUser' =>$id));
        $panId=$panier->getIdPanier();
        $panier->setEtat(1);
        $em->persist($panier);
        $em->flush();
        if($panier!=null)
            $panId=$panier->getIdPanier();
        else
            $panId=0;
        //$prods=$repo2->findBy(array('idPanier' =>$panier->getIdPanier()));
        $q= $this->getDoctrine()->getEntityManager()->createQuery("select l.idPanier, p.idProd,p.nomProd,p.prix,p.image,l.quantite from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p  where l.idPanier=$panId and p.idProd=l.idProd");
        $produits = $q->getResult();
        $q2= $this->getDoctrine()->getEntityManager()->createQuery("select p.prix*l.quantite AS Total,p.prix ,l.quantite,promo.pourcentage   from CommandeBundle\Entity\LigneCommande l , CommandeBundle\Entity\Produit p , CommandeBundle\Entity\Promotion promo where l.idPanier=$panId and p.idProd=l.idProd and promo.idProd=p.idProd");
        $prixProd=$q2->getResult();
        foreach ($prixProd as $produit)
        { $total=$total+$produit['Total'];
            $remise=$remise+($produit['prix']*$produit['pourcentage']/100)*$produit['quantite'];
        }
        $totalfinal=$total-$remise+15;
        return $this->render('CommandeBundle:Default:payementSuccess.html.twig',array(
                'produits'=>$produits,
                'total'=>$totalfinal
                //'some'  => $vars
            )
        );
    }
    public function deletePromoAction($id)
    {$ligne=new LigneCommande();
        $em=$this->getDoctrine()->getManager();
        $ligne=$em->getRepository(Promotion::class)->findOneBy(array('idPromo' => $id));
        $em->remove($ligne);
        $em->flush();
        return $this->redirectToRoute("commande_promotion");


    }
    public function editAction(Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        $listePromo = $em->getRepository('CommandeBundle:Promotion')->find($id);
        $editForm = $this->createForm('CommandeBundle\Form\PromotionType', $listePromo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_promotion');
        }

        return $this->render('@Commande/Default/updatePromo.html.twig', array(
            'list' => $listePromo,
            'form' => $editForm->createView(),
        ));
    }




}
