<?php

namespace App\Entity;

use App\Repository\ComplaintResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplaintResponseRepository::class)]
class ComplaintResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Response = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateResponse = null;

    #[ORM\Column(length: 255)]
    private ?string $Email_sender = null;

    #[ORM\OneToOne(mappedBy: 'complaintresponse', cascade: ['persist', 'remove'])]
    private ?Complaint $complaint = null;

    #[ORM\ManyToOne(inversedBy: 'complaintResponses')]
    private ?Admin $admin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->Response;
    }

    public function setResponse(string $Response): static
    {
        $this->Response = $Response;

        return $this;
    }

    public function getDateResponse(): ?\DateTimeInterface
    {
        return $this->DateResponse;
    }

    public function setDateResponse(\DateTimeInterface $DateResponse): static
    {
        $this->DateResponse = $DateResponse;

        return $this;
    }

    public function getEmailSender(): ?string
    {
        return $this->Email_sender;
    }

    public function setEmailSender(string $Email_sender): static
    {
        $this->Email_sender = $Email_sender;

        return $this;
    }

    public function getComplaint(): ?Complaint
    {
        return $this->complaint;
    }

    public function setComplaint(?Complaint $complaint): static
    {
        // unset the owning side of the relation if necessary
        if ($complaint === null && $this->complaint !== null) {
            $this->complaint->setComplaintresponse(null);
        }

        // set the owning side of the relation if necessary
        if ($complaint !== null && $complaint->getComplaintresponse() !== $this) {
            $complaint->setComplaintresponse($this);
        }

        $this->complaint = $complaint;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

}
