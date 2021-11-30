<?php

namespace App\Controller;

use App\Form\SetPagesType;
use App\Repository\BookRepository;
use App\Repository\LibraryRepository;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my-library")
 */
class MyLibraryController extends AbstractController
{
    private $bookRepository;
    private $libraryRepository;
    private $entityManager;

    public function __construct(
        BookRepository $bookRepository,
        LibraryRepository $libraryRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->bookRepository = $bookRepository;
        $this->libraryRepository = $libraryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app_library")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $paginator = $this->bookRepository->getBooksByUserPaginator();


        return $this->render('my_library/index.html.twig',[
            'books' => $paginator,
        ]);
    }
    /**
     * @Route("/already-read", name="app_library_already_read")
     * @param Request $request
     * @return Response
     */
    public function alreadyRead(Request $request): Response
    {
        $paginator = $this->bookRepository->getAlreadyReadBooksByUserPaginator();

        return $this->render('my_library/index.html.twig',[
            'books' => $paginator,
        ]);
    }
    /**
     * @Route("/not-read", name="app_library_not_read")
     * @param Request $request
     * @return Response
     */
    public function notRead(Request $request): Response
    {
        $paginator = $this->bookRepository->getNotReadBooksByUserPaginator();

        return $this->render('my_library/index.html.twig',[
            'books' => $paginator,
        ]);
    }

    /**
     * @Route("/while-reading", name="app_library_while_reading")
     * @param Request $request
     * @return Response
     */
    public function whileReading(Request $request): Response
    {
        $paginator = $this->bookRepository->getWhileReadingBooksByUserPaginator();


        return $this->render('my_library/index.html.twig', [
            'books' => $paginator,
        ]);
    }

    /**
     * @Route("/remove/{book}", name="app_remove_from_library")
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeBookFromLibrary(Request $request): RedirectResponse
    {

        $book = $this->libraryRepository->findOneBy([
            'book' => $request->get('book'),
            'user' => $this->getUser()
            ]);
        if (!$book) {
            $this->addFlash("warning","This book is not in your library");

            return $this->redirect($this->generateUrl('app_hello'));
        }
        $this->addFlash("success","Book was remove form your library");

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->redirect($this->generateUrl('app_hello'));
    }

    /**
     * @Route("/book-pages/{book}", name="app_book_pages")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function showPageAndDetails(Request $request)
    {
        $bookInLibrary = $this->libraryRepository->findOneBy([
            'book' => $request->get('book'),
            'user' => $this->getUser()
        ]);
        $form = $this->createForm(SetPagesType::class,$bookInLibrary);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            if ($data->getPage() < 0)
            {
                $data->setPage(0);
            }
            if ($data->getPage() > $bookInLibrary->getBook()->getPage())
            {
                $data->setPage($bookInLibrary->getBook()->getPage());
            }
            $this->entityManager->persist($form);
            $this->entityManager->flush();
            $this->addFlash('success',"Changes in your library");
            return $this->redirect($this->generateUrl('app_hello'));
        }

        return $this->render('my_library/singleBook.html.twig',[
            'book' => $bookInLibrary->getBook(),
            'form' => $form->createView()
        ]);
    }
}
