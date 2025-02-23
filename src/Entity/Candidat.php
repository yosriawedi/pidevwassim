<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_candidature = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column]
    private ?int $PhoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $FullName = null;

    #[ORM\Column]
    private ?bool $Result = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    private ?Internship $internship = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    private ?Student $student = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->Date_candidature;
    }

    public function setDateCandidature(\DateTimeInterface $Date_candidature): static
    {
        $this->Date_candidature = $Date_candidature;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(int $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->FullName;
    }

    public function setFullName(string $FullName): static
    {
        $this->FullName = $FullName;

        return $this;
    }

    public function isResult(): ?bool
    {
        return $this->Result;
    }

    public function setResult(bool $Result): static
    {
        $this->Result = $Result;

        return $this;
    }

    public function getInternship(): ?Internship
    {
        return $this->internship;
    }

    public function setInternship(?Internship $internship): static
    {
        $this->internship = $internship;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }
}
