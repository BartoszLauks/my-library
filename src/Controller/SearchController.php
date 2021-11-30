<?php

namespace App\Controller;

use App\Form\NavBarSerType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private $bookRepository;
    public function __construct(
        BookRepository $bookRepository
    ) {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request): Response
    {

        $form = $this->createForm(NavBarSerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $book = $this->bookRepository->searchFieldByName($form->getData()['field_name']);
            $author = $this->bookRepository->searchFieldByAuthor($form->getData()['field_name']);

            return $this->render("hello/BeforeSearch.html.twig",[
                'books' => $book,
                'author' => $author
            ]);

        }
        return $this->render('hello/Search.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
