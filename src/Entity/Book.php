<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    const NOT_LOANED = 0;
    const LOANED = 1;
    const HOLD = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $publisher;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $publicationYear;

    /**
     * @ORM\Column(type="string", length=13, nullable=true)
     */
    private $isbn;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $subject = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $genre = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $loan;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="books")
     */
    private $loanedBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublicationYear(): ?string
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(string $publicationYear): self
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->isbn;
    }

    public function setISBN(string $isbn): self
    {
        $this->isbn= $isbn;

        return $this;
    }

    public function getSubject(): ?array
    {
        return $this->subject;
    }

    public function setSubject(array $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getGenre(): ?array
    {
        return $this->genre;
    }

    public function setGenre(?array $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getLoan(): ?int
    {
        return $this->loan;
    }

    public function setLoan(int $loan): self
    {
        $this->loan = $loan;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getLoanedBy(): ?User
    {
        return $this->loanedBy;
    }

    public function setLoanedBy(?User $loanedBy): self
    {
        $this->loanedBy = $loanedBy;

        return $this;
    }
}
