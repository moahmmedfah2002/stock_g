<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route("/login",methods: "POST")]
    public function login(Request $request,UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher,SerializerInterface $serializer)
    {
        $user=new User();
        $username=$request->get("username");
        $password=$request->get("password");
        $password=$passwordHasher->hashPassword($user,$password);
        $resultat=$userRepository->findBy(["username"=>$username,"password"=>"$password"]);
        if(!empty($resultat)){
            $role=$resultat[0]->getRole();
            $session=$request->getSession();
            $session->set("role",$role);
            $session->set("login",true);
            $session->set("i",0);
            return $this->redirect("/TableauMatiere");

        }else{

            return $this->redirect("/");
        }

    }
    #[Route("/deconnexion",methods: "GET")]
    public function deconnexion(Request $request){
        $session =$request->getSession();

        $session->invalidate();


        return $this->redirect("/");



    }

}