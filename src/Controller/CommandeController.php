<?php

namespace App\Controller;
use App\Entity\Commande;
use App\Entity\Matiere;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class CommandeController extends AbstractController
{
    #[Route("/commande",methods: "GET")]
    public function index(Request $request,CommandeRepository $commandeRepository):Response{
        if ($request->getSession(false)->get("login")==true && $request->getSession(false)->get("role")=="achat" ) {


            $commande = $commandeRepository->findAll();

            return $this->render("Commande/index.html.twig", ['commandes' => $commande, "role" => $request->getSession(false)->get("role"),"page"=>"commande"]);
        }
        else{
            return $this->redirect("/");
        }


    }

    #[Route("/deleteCommande/{id}",methods:"GET")]
    public function delete(CommandeRepository $commandeRepository,EntityManagerInterface $entityManager,$id):Response
    {
        $entityManager->remove($commandeRepository->findById($id)[0]);
        $entityManager->flush();
        return $this->redirect("/commande");

    }
    #[Route("/confirmeLivreson/{id}",methods:"GET")]
    public function confirme(CommandeRepository $commandeRepository,EntityManagerInterface $entityManager,$id):Response
    {
        $commande=$commandeRepository->findById($id)[0];
        $matiere=new Matiere();
        $matiere->setRef($commande->getRef());
        $matiere->setNom($commande->getNom());
        $matiere->setCategorie($commande->getCategorie());
        $matiere->setType($commande->getType());
        $matiere->setZone($commande->getZone());
        $matiere->setNombre($commande->getNombre());
        $entityManager->persist($matiere);
        $entityManager->flush();
        $commande->setStatue(true);
        $entityManager->persist($commande);

        $entityManager->flush();
        return $this->redirect("/commande");

    }


    #[Route('/formMa')]
    public function  form(Request $request): Response
    {



        return $this->render("Form_mat/index.html.twig",["page"=>"formM","role"=>$request->getSession()->get("role")]);
    }
    #[Route('/ajoutCommande',methods: 'POST')]
    public function ajout(Request $request,EntityManagerInterface $entityManager):Response
    {
        $commande=new Commande();

        $commande->setNumero($request->get("num"));
        $commande->setRef($request->get("ref"));
        $commande->setNom($request->get("nom"));
        $commande->setCategorie($request->get("categorie"));
        $commande->setType($request->get("type"));
        $commande->setZone($request->get("zone"));
        $commande->setNombre($request->get("nbr"));
        $commande->setStatue(false);
        $entityManager->persist($commande);
        $entityManager->flush();
        return $this->redirect("/commande");






    }

}