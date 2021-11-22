<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publishingHouse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $placeOfPublication;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DateOfPublication;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $page;

    /**
     * @ORM\OneToMany(targetEntity=Library::class, mappedBy="book")
     */
    private $libraries;

    public function __construct()
    {
        $this->libraries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishingHouse(): ?string
    {
        return $this->publishingHouse;
    }

    public function setPublishingHouse(?string $publishingHouse): self
    {
        $this->publishingHouse = $publishingHouse;

        return $this;
    }

    public function getPlaceOfPublication(): ?string
    {
        return $this->placeOfPublication;
    }

    public function setPlaceOfPublication(?string $placeOfPublication): self
    {
        $this->placeOfPublication = $placeOfPublication;

        return $this;
    }

    public function getDateOfPublication(): ?int
    {
        return $this->DateOfPublication;
    }

    public function setDateOfPublication(?int $DateOfPublication): self
    {
        $this->DateOfPublication = $DateOfPublication;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Collection|Library[]
     */
    public function getLibraries(): Collection
    {
        return $this->libraries;
    }

    public function addLibrary(Library $library): self
    {
        if (!$this->libraries->contains($library)) {
            $this->libraries[] = $library;
            $library->setBook($this);
        }

        return $this;
    }

    public function removeLibrary(Library $library): self
    {
        if ($this->libraries->removeElement($library)) {
            // set the owning side to null (unless already changed)
            if ($library->getBook() === $this) {
                $library->setBook(null);
            }
        }

        return $this;
    }
}
