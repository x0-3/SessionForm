<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_place = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Program::class, orphanRemoval: true)]
    private Collection $programs;

    #[ORM\ManyToMany(targetEntity: Stagiaire::class, mappedBy: 'stagiaire_session')]
    private Collection $stagiaire_session;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->stagiaire_session = new ArrayCollection();
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

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(?\DateTimeInterface $beginDate): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(?int $nb_place): self
    {
        $this->nb_place = $nb_place;

        return $this;
    }


    public function currentNbPlace(){

        return $this->nb_place - $this->stagiaire_session->count();
    }

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs->add($program);
            $program->setSession($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSession() === $this) {
                $program->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaireSession(): Collection
    {
        return $this->stagiaire_session;
    }

    public function addStagiaireSession(Stagiaire $stagiaireSession): self
    {
        if (!$this->stagiaire_session->contains($stagiaireSession)) {
            $this->stagiaire_session->add($stagiaireSession);
            $stagiaireSession->addStagiaireSession($this);
        }

        return $this;
    }

    public function removeStagiaireSession(Stagiaire $stagiaireSession): self
    {
        if ($this->stagiaire_session->removeElement($stagiaireSession)) {
            $stagiaireSession->removeStagiaireSession($this);
        }

        return $this;
    }
}
