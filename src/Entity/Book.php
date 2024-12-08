<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\ManyToOne(inversedBy: 'book')]
    private ?Author $author = null;

    /**
     * @var Collection<int, Borrow>
     */
    #[ORM\OneToMany(targetEntity: Borrow::class, mappedBy: 'book')]
    private Collection $borrowed;

    public function __construct()
    {
        $this->borrowed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Borrow>
     */
    public function getBorrowed(): Collection
    {
        return $this->borrowed;
    }

    public function addBorrowed(Borrow $borrowed): static
    {
        if (!$this->borrowed->contains($borrowed)) {
            $this->borrowed->add($borrowed);
            $borrowed->setBook($this);
        }

        return $this;
    }

    public function removeBorrowed(Borrow $borrowed): static
    {
        if ($this->borrowed->removeElement($borrowed)) {
            // set the owning side to null (unless already changed)
            if ($borrowed->getBook() === $this) {
                $borrowed->setBook(null);
            }
        }

        return $this;
    }
}
