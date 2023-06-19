<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Oh pinaise le champs 'nom' ne peut pas etre vide")]
    #[Assert\Length(min : 4,
        max: 50,
        minMessage : "le nom doit avoir au moins 4 caracteres",
        maxMessage : "Et 50 caracteres max"
    )]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 255)]
    private ?string $specie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $placeOfBirth = null;

    #[Assert\Type(type : 'integer',
        message : "Le matriclue doit etre un entier")]
    #[Assert\Range(
        min : 1000,
        max : 9999,
        notInRangeMessage: "Le num doit etre compris entre 1000 et 9999"
    )]
    #[ORM\Column(nullable: true)]
    private ?int $serial = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Pen $pen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getSpecie(): ?string
    {
        return $this->specie;
    }

    public function setSpecie(string $specie): static
    {
        $this->specie = $specie;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): static
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getSerial(): ?int
    {
        return $this->serial;
    }

    public function setSerial(?int $serial): static
    {
        $this->serial = $serial;

        return $this;
    }

    public function getPen(): ?Pen
    {
        return $this->pen;
    }

    public function setPen(?Pen $pen): static
    {
        $this->pen = $pen;

        return $this;
    }
}
