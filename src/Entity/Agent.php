<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent extends User
{
    public function __contstruct()
    {
        $this->role="ROLE_AGENT";
    }
    #[ORM\Column(length: 255)]
    private ?string $Location = null;

    #[ORM\Column(length: 255)]
    private ?string $CompanyName = null;

    /**
     * @var Collection<int, Internship>
     */
    #[ORM\OneToMany(targetEntity: Internship::class, mappedBy: 'agent')]
    private Collection $internships;

    public function __construct()
    {
        parent::__construct();
        $this->internships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): static
    {
        $this->Location = $Location;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    /**
     * @return Collection<int, Internship>
     */
    public function getInternships(): Collection
    {
        return $this->internships;
    }

    public function addInternship(Internship $internship): static
    {
        if (!$this->internships->contains($internship)) {
            $this->internships->add($internship);
            $internship->setAgent($this);
        }

        return $this;
    }

    public function removeInternship(Internship $internship): static
    {
        if ($this->internships->removeElement($internship)) {
            // set the owning side to null (unless already changed)
            if ($internship->getAgent() === $this) {
                $internship->setAgent(null);
            }
        }

        return $this;
    }
}
