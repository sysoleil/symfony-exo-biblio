<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// J'ajoute un alias au namespace

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez indiquer un titre")
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(
     *     min="0",
     *     minMessage="La valeur doit être supérieure à 0",
     *     max="4",
     *     maxMessage="La valeur doit être infèrieure à 4"
     * )
     */
    private $nbpages;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $genre;

    // Je crée ma variable privée resume
    // Je crée ma route au dessus avec ses caractéristiques

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resume;

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

    public function getNbpages(): ?int
    {
        return $this->nbpages;
    }

    public function setNbpages(?int $nbpages): self
    {
        $this->nbpages = $nbpages;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume($resume): void
    {
        $this->resume = $resume;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
