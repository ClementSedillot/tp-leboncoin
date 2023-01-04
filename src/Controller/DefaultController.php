<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceFormType;
use App\Form\AnnonceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'home_page')]
    public function home(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('home.html.twig',[
            'tableau' => $annonce
    ]);
    }
    // Redirection de la racine vers la page d'accueil
     #[Route('/', name: 'home')]
     public function racine(ManagerRegistry $doctrine): Response
     {
         return $this->redirectToRoute('home_page');

     }

     #[Route('/add', name: 'add')]
     public function add(ManagerRegistry $doctrine, Request $request): Response
     {
        $annonce = new Annonce();
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(AnnonceFormType::class, $annonce);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data =$form->getData();
            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre annonce a bien été posté'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('add.html.twig', [
            'formAnnonce' => $form
        ]);
     }
     
     

}