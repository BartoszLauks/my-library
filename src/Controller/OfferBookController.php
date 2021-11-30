<?php

namespace App\Controller;

use App\Entity\OfferBook;
use App\Entity\User;
use App\Form\OfferBookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OfferBookController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/offer-book", name="app_offer_book")
     */
    public function index(Request $request): Response
    {
        $offerbook = new OfferBook();
        $form = $this->createForm(OfferBookType::class,$offerbook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $offerbook->setUser($this->entityManager->getRepository(User::class)->find($this->security->getUser()));
            $offerbook->setIsAccept(false);

            $this->entityManager->persist($offerbook);
            $this->entityManager->flush();

            $this->addFlash('success','Thanks you ! <3.Wait for Admin check your offer new book');

            return $this->redirect($this->generateUrl('app_hello'));
        }
        return $this->render('offer_book/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
