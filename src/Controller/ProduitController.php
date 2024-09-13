<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
   #[Route('/TableauProduit')]
    public function  index(Request $request,ProduitRepository $produitRepository): Response
    {if ($request->getSession(false)->get("login")==true) {

            if((int)$request->getSession()->get("i")==1){
            $request->getSession()->set("etat","");

             }
            $etat=$request->getSession()->get("etat");
            $request->getSession()->set("i",0);





        $produits = $produitRepository->findAll();

        return $this->render("Tableau_prod/index.html.twig", ['produits' => $produits, "role" => $request->getSession(false)->get("role"),"page"=>"tableP","etat"=>$etat]);
    }
    else{
        return $this->redirect("/");
    }
    }

    #[Route('/FormProd')]
    public function  form(Request $request): Response
    {



        return $this->render("Form_prod/index.html.twig",["page"=>"formP","role"=>$request->getSession()->get("role")]);
    }
    #[Route("/addproduit",methods:"POST")]
    public function add(EntityManagerInterface $entityManager,Request $request):Response
    {

        $produit=new Produit();
        $produit->setRef($request->get("ref"));
        $produit->setNom($request->get("nom"));
        $produit->setCategorie($request->get("categorie"));
        $produit->setType($request->get("type"));
        $produit->setNombre($request->get("nombre"));
        $entityManager->persist($produit);
        $entityManager->flush();
        return $this->redirect("/TableauProduit");

    }
    #[Route("/ajoutRebut/{id}",methods: "GET")]
    public function rebut($id,EntityManagerInterface $entityManager,ProduitRepository $produitRepository,Request $request):Response{

       $produit=$produitRepository->findById($id)[0];
        $produits = $produitRepository->findAll();
        $nb=$produit->getNombre();
        $nb_rebut=(int)$request->get("nombre");
        if($nb_rebut>$nb){
           $etat="le nombre de rebut et plus grand que le nombre de produit";
           $request->getSession()->set('etat',$etat);
            $this->addFlash('etat', $etat);
            return $this->redirect("/TableauProduit");
            }else{

            $nom = $produit->getNom();
            $etat="sucess";
            $nb=$nb-$nb_rebut;

            }
        $nbreb=$produit->getNombreRebut();
        $nbreb+=$nb_rebut;
        $produit->setNombreRebut($nbreb);
        $produit->setNombre($nb);
        $entityManager->persist($produit);
        $entityManager->flush();
        $request->getSession()->set('etat',$etat);
        $this->addFlash('etat', $etat);
        return $this->redirect("/TableauProduit");
    }
    #[Route("/deleteProduit/{id}")]
    public function delete(Request $request,EntityManagerInterface $entityManager,ProduitRepository $produitRepository,$id)
    {
        $produit=$produitRepository->findById((int)$id)[0];
        $entityManager->remove($produit);
        $entityManager->flush();
        return $this->redirect("/TableauProduit");



    }

}