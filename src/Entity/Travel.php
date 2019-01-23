<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TravelRepository")
 */
class Travel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location", mappedBy="travelLocation")
     */
    private $locations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\visitor", inversedBy="travels")
     */
    private $visitorTravel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="travels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\post", mappedBy="travel", orphanRemoval=true)
     */
    private $posts;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->visitorTravel = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->addTravelLocation($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            $location->removeTravelLocation($this);
        }

        return $this;
    }

    /**
     * @return Collection|visitor[]
     */
    public function getVisitorTravel(): Collection
    {
        return $this->visitorTravel;
    }

    public function addVisitorTravel(visitor $visitorTravel): self
    {
        if (!$this->visitorTravel->contains($visitorTravel)) {
            $this->visitorTravel[] = $visitorTravel;
        }

        return $this;
    }

    public function removeVisitorTravel(visitor $visitorTravel): self
    {
        if ($this->visitorTravel->contains($visitorTravel)) {
            $this->visitorTravel->removeElement($visitorTravel);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setTravel($this);
        }

        return $this;
    }

    public function removePost(post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getTravel() === $this) {
                $post->setTravel(null);
            }
        }

        return $this;
    }
}
