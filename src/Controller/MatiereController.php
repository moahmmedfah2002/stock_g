<?php

namespace App\Controller;


use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MatiereController extends AbstractController
{
   #[Route('/TableauMatiere' ,name: 'tabM')]
public function  index(MatiereRepository $matiereRepository,Request $request): Response
{
    if ($request->getSession(false)->get("login")==true) {


        $matieres = $matiereRepository->findAll();

        return $this->render("Tableau_mat/index.html.twig", ['matieres' => $matieres, "role" => $request->getSession(false)->get("role"),"page"=>"tableM"]);
    }
    else{
        return $this->redirect("/");
    }

    }


    #[Route("/TableauMatiere/{id}",methods:"GET")]
    public function delete(MatiereRepository $matiereRepository,EntityManagerInterface $entityManager,$id):Response
    {
       $entityManager->remove($matiereRepository->findById($id)[0]);
       $entityManager->flush();
       return $this->redirect("/TableauMatiere");

    }



}