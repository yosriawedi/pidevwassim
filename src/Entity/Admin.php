<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    /**
     * @var Collection<int, ComplaintResponse>
     */
    #[ORM\OneToMany(targetEntity: ComplaintResponse::class, mappedBy: 'admin')]
    private Collection $complaintResponses;

    public function __construct()
    {
        parent::__construct();
        $this->complaintResponses = new ArrayCollection();
    }

    public function __contstruct()
    {
        $this->role="ROLE_ADMIN";
    }

    /**
     * @return Collection<int, ComplaintResponse>
     */
    public function getComplaintResponses(): Collection
    {
        return $this->complaintResponses;
    }

    public function addComplaintResponse(ComplaintResponse $complaintResponse): static
    {
        if (!$this->complaintResponses->contains($complaintResponse)) {
            $this->complaintResponses->add($complaintResponse);
            $complaintResponse->setAdmin($this);
        }

        return $this;
    }

    public function removeComplaintResponse(ComplaintResponse $complaintResponse): static
    {
        if ($this->complaintResponses->removeElement($complaintResponse)) {
            // set the owning side to null (unless already changed)
            if ($complaintResponse->getAdmin() === $this) {
                $complaintResponse->setAdmin(null);
            }
        }

        return $this;
    }
   
}
