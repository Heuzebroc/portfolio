<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisationRepository::class)
 */
class Realisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $intro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introImageFilename;

    /**
     * @ORM\OneToMany(targetEntity=Screenshot::class, mappedBy="realisation", orphanRemoval=true)
     */
    private $screenshots;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, inversedBy="realisations")
     */
    private $technologies;

    /**
     * @ORM\Column(type="text")
     */
    private $mainText;

    /**
     * @ORM\Column(type="text")
     */
    private $features;

    /**
     * @ORM\Column(type="text")
     */
    private $introLong;

    /**
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="realisation")
     */
    private $links;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $frontPage;

    public function __construct()
    {
        $this->screenshots = new ArrayCollection();
        $this->technologies = new ArrayCollection();
        $this->links = new ArrayCollection();
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

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getIntroImageFilename(): ?string
    {
        return $this->introImageFilename;
    }

    public function setIntroImageFilename(?string $introImageFilename): self
    {
        $this->introImageFilename = $introImageFilename;

        return $this;
    }

    /**
     * @return Collection|Screenshot[]
     */
    public function getScreenshots(): Collection
    {
        return $this->screenshots;
    }

    /**
     * @return Collection|Screenshot[]
     */
    public function getCarouselScreenshots(): Collection
    {
        return new ArrayCollection(
            array_filter($this->screenshots->toArray(), function($screenshot){ return !$screenshot->getSupplement();})
        );
    }

    public function addScreenshot(Screenshot $screenshot): self
    {
        if (!$this->screenshots->contains($screenshot)) {
            $this->screenshots[] = $screenshot;
            $screenshot->setRealisation($this);
        }

        return $this;
    }

    public function removeScreenshot(Screenshot $screenshot): self
    {
        if ($this->screenshots->removeElement($screenshot)) {
            // set the owning side to null (unless already changed)
            if ($screenshot->getRealisation() === $this) {
                $screenshot->setRealisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Technology[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getMainText(): ?string
    {
        return $this->mainText;
    }

    public function setMainText(string $mainText): self
    {
        $this->mainText = $mainText;

        return $this;
    }

    public function getFeatures(): ?string
    {
        return $this->features;
    }

    public function setFeatures(string $features): self
    {
        $this->features = $features;

        return $this;
    }

    public function getIntroLong(): ?string
    {
        return $this->introLong;
    }

    public function setIntroLong(string $introLong): self
    {
        $this->introLong = $introLong;

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setRealisation($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getRealisation() === $this) {
                $link->setRealisation(null);
            }
        }

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFrontPage(): ?bool
    {
        return $this->frontPage;
    }

    public function setFrontPage(bool $frontPage): self
    {
        $this->frontPage = $frontPage;

        return $this;
    }
}
