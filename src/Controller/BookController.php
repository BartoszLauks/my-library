<?php

namespace App\Controller;

use App\Entity\Library;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    private $bookRepository;
    private $libraryRepository;
    private $security;
    private $entityManager;

    public function __construct
    (
        BookRepository $bookRepository,
        LibraryRepository $libraryRepository,
        Security $security,
        EntityManagerInterface $entityManager

    ) {
        $this->bookRepository = $bookRepository;
        $this->libraryRepository = $libraryRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app_book")
     */
    public function index(): Response
    {
        $paginator = $this->bookRepository->getBooksNotAddingToLibraryByUserPagination();

        return $this->render('book/index.html.twig',[
            'books' => $paginator,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/book-details/{book}", name="app_book_details")
     */
    public function bookDetails(Request $request)
    {
        $book = $this->bookRepository->findOneBy(['id' => $request->get('book')]);

        return $this->render('book/singleBook.html.twig',[
            'book' => $book
        ]);
    }

    /**
     * @Route("/add-book/{book}", name="app_add_book_to_library")
     */
    public function addBookToLibrary(Request $request)
    {
        if ($this->libraryRepository->findOneBy([
            'user' => $this->security->getUser(),
            'book' => $request->get('book')
        ])) {
            $this->addFlash('warning',"This book already is in your library");
            return $this->redirect($this->generateUrl('app_book'));
        }
        $library = new Library();

        $library->setBook($this->bookRepository->findOneBy(['id' => $request->get('book')]));
        $library->setUser($this->entityManager->getRepository(User::class)->find($this->security->getUser()));
        $library->setPage(0);

        $this->entityManager->persist($library);
        $this->entityManager->flush();

        $this->addFlash('success',"Adding book to your library");

        return $this->redirect($this->generateUrl('app_book'));
    }
}
