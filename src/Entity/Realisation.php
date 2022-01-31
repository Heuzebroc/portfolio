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
     * @ORM\Column(type="string", length=255)
     */
    private $downloadLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $downloadWeight;

    /**
     * @ORM\OneToMany(targetEntity=Screenshot::class, mappedBy="realisation", orphanRemoval=true)
     */
    private $screenshots;

    /**
     * @ORM\OneToMany(targetEntity=Screenshot::class, mappedBy="realisationSup", orphanRemoval=true)
     */
    private $supImages;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, inversedBy="realisations")
     */
    private $technologies;

    /**
     * @ORM\Column(type="text")
     */
    private $technologyText;

    /**
     * @ORM\Column(type="text")
     */
    private $mainText;

    public function __construct()
    {
        $this->screenshots = new ArrayCollection();
        $this->supImages = new ArrayCollection();
        $this->technologies = new ArrayCollection();
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

    public function getDownloadLink(): ?string
    {
        return $this->downloadLink;
    }

    public function setDownloadLink(string $downloadLink): self
    {
        $this->downloadLink = $downloadLink;

        return $this;
    }

    public function getDownloadWeight(): ?string
    {
        return $this->downloadWeight;
    }

    public function setDownloadWeight(?string $downloadWeight): self
    {
        $this->downloadWeight = $downloadWeight;

        return $this;
    }

    /**
     * @return Collection|Screenshot[]
     */
    public function getScreenshots(): Collection
    {
        return $this->screenshots;
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
     * @return Collection|Screenshot[]
     */
    public function getSupImages(): Collection
    {
        return $this->supImages;
    }

    public function addSupImage(Screenshot $supImage): self
    {
        if (!$this->supImages->contains($supImage)) {
            $this->supImages[] = $supImage;
            $supImage->setRealisationSup($this);
        }

        return $this;
    }

    public function removeSupImage(Screenshot $supImage): self
    {
        if ($this->supImages->removeElement($supImage)) {
            // set the owning side to null (unless already changed)
            if ($supImage->getRealisationSup() === $this) {
                $supImage->setRealisationSup(null);
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

    public function getTechnologyText(): ?string
    {
        return $this->technologyText;
    }

    public function setTechnologyText(string $technologyText): self
    {
        $this->technologyText = $technologyText;

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
}
