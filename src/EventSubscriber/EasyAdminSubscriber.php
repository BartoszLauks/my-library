<?php

namespace App\EventSubscriber;

use App\Entity\Book;
use App\Entity\OfferBook;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    public function __construct(
            //
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityDeletedEvent::class => ['addOfferBookToBooks'],
        ];
    }

    public function addOfferBookToBooks(BeforeEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof OfferBook && $entity->getIsAccept())
        {
            $book = new Book();
            $book->setName($entity->getName());
            $book->setAuthor($entity->getAuthor());
            $book->setPublishingHouse($entity->getPublishingHause());
            $book->setPlaceOfPublication($entity->getPlaceOfPublication());
            $book->setDateOfPublication($entity->getDateOfPublication());
            $book->setPage($entity->getPage());
            $book->setDescription($entity->getDescription());

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        }
    }
}
