<?php

namespace App\Entity;

use App\Repository\TutorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TutorRepository::class)]
class Tutor extends User
{
    #[ORM\Column(length: 255)]
    private ?string $Domain = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'tutor')]
    private Collection $courses;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
    }

    public function __contstruct()
    {
        $this->role="ROLE_TUTOR";
    }

    public function getDomain(): ?string
    {
        return $this->Domain;
    }

    public function setDomain(string $Domain): static
    {
        $this->Domain = $Domain;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setTutor($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getTutor() === $this) {
                $course->setTutor(null);
            }
        }

        return $this;
    }
}
