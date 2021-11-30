<?php

namespace App\Controller;

use App\Form\NavBarSerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/", name="app_hello")
     */
    public function index(): Response
    {
        return $this->render('hello/index.html.twig',[],
        );
    }

    ///**
    // * @Route("/search", name="search")
    // */
    /*public function search(Request $request): Response
    {

        $form = $this->createForm(NavBarSerType::class);
        $form->handleRequest($request);

        //dd($form->getData());
        //dd($request);
        if ($form->isSubmitted()) {
            dd("work");
        }
        return $this->render('hello/Search.html.twig', [
            'form' => $form->createView()
        ]);
    }
    */
}
