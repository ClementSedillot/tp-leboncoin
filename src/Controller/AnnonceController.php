<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceFormType;
use App\Form\AnnonceType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\Label;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    public function new(ManagerRegistry $doctrine ,Request $request)
    {
       
       
    }
}


