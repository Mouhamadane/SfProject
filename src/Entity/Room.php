<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $typeRoom;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $disponibilite;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="numRoom")
     */
    private $numChambre;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="rooms")
     */
    private $building;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    public function __construct()
    {
        $this->numChambre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRoom(): ?string
    {
        return $this->typeRoom;
    }

    public function setTypeRoom(string $typeRoom): self
    {
        $this->typeRoom = $typeRoom;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getNumChambre(): Collection
    {
        return $this->numChambre;
    }

    public function addNumChambre(Student $numChambre): self
    {
        if (!$this->numChambre->contains($numChambre)) {
            $this->numChambre[] = $numChambre;
            $numChambre->setNumRoom($this);
        }

        return $this;
    }

    public function removeNumChambre(Student $numChambre): self
    {
        if ($this->numChambre->contains($numChambre)) {
            $this->numChambre->removeElement($numChambre);
            // set the owning side to null (unless already changed)
            if ($numChambre->getNumRoom() === $this) {
                $numChambre->setNumRoom(null);
            }
        }

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

}
