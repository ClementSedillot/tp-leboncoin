<?php

namespace App\Controller;

use DateTime;

use App\Entity\Annonce;
use App\Entity\User;
use App\Form\AnnonceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
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
        $loopCount = 0;

        return $this->render('home.html.twig',[
            'tableau' => $annonce,
            'loopCount' => $loopCount
    ]);
    }
//trad anglais
    #[Route('/home_en', name: 'home_page_en')]
    public function homeEn(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('home_en.html.twig',[
            'tableau' => $annonce
    ]);
    }
    // Redirection de la racine vers la page d'accueil
     #[Route('/', name: 'home')]
     public function racine(ManagerRegistry $doctrine): Response
     {
         return $this->redirectToRoute('home_page');

     }

//PAGE ACTIVITE
#[Route('/activite', name: 'activite')]
    public function activite(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('activite.html.twig',[
            'tableau' => $annonce
    ]);
    }

//OLIVIER VARENNE
#[Route('/olivier-varenne', name: 'olivier-varenne')]
    public function ov(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('ov.html.twig',[
            'tableau' => $annonce
    ]);
    }

#[Route('/horlogerie', name: 'horlogerie')]
    public function horlogerie(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('horlogerie.html.twig',[
            'tableau' => $annonce
    ]);
    }

//PAGE ACTU

#[Route('/actu', name: 'actu')]
    public function actu(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('actu.html.twig',[
            'tableau' => $annonce
    ]);
    }

//PAGE CONCTACT

#[Route('/contact', name: 'contact')]
    public function contact(ManagerRegistry $doctrine): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->findAll();
        return $this->render('contact.html.twig',[
            'tableau' => $annonce
    ]);
    }

//ADD ANNONCE
     #[Route('/add', name: 'add')]
     public function add(ManagerRegistry $doctrine, Request $request): Response
     {
        $annonce = new Annonce();
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(AnnonceFormType::class, $annonce);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data =$form->getData();
            //$data = $annonce->setCreatedAt();
            $data = $annonce->setUser($this->getUser());
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


     #[Route('/edit/annonce/{id}', name: 'edit_annonce')]
     public function editAnnonce(int $id, EntityManagerInterface $em, Request $request)
    {
        $annonce = $em->getRepository(Annonce::class)->find($id);

        $form = $this->createForm(AnnonceFormType::class, $annonce);

        $form->handleRequest($request);

        if($annonce->getUser()->getId() != $this->getUser()->getId()){
            throw new Exception('Vous n`avez pas accès a cette annonce');
        }

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            //$data = $annonce->setUpdatedAt(new DateTime());
            $em->persist($data);
            $em->flush();
            
            return $this->redirectToRoute('app_annonce',[
                "id" => $id
        ]);
        }

        return $this->render('add.html.twig', [
            'formAnnonce' => $form,
            
            //'createdAt' => $annonce->getCreatedAt()
        ]);
    }
     
    #[Route('/delete/annonce/{id}', name: 'delete_annonce')]
     public function deleteAnnonce(int $id, EntityManagerInterface $em, Request $request)
    {
        $annonce = $em->getRepository(Annonce::class)->find($id);

        
        if($annonce->getUser()->getId() != $this->getUser()->getId()){
            throw new Exception('Vous n`avez pas accès a cette annonce');
        }

        
        $em->remove($annonce);
        $em->flush();
            
        return $this->redirectToRoute('home');
    }

     #[Route('annonce/{id}', name: 'app_annonce')]

    public function annonce(ManagerRegistry $doctrine, int $id): Response
    {

        $repository = $doctrine->getRepository(Annonce::class);

        $annonce = $repository->find($id);
        
        
        return $this->render('annonce.html.twig',[
            'annonce' => $annonce,
        ]);
    }

    // MAILER

    

}
