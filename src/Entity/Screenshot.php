<?php

namespace App\Entity;

use App\Repository\ScreenshotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScreenshotRepository::class)
 */
class Screenshot
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
    private $imageFilename;

    /**
     * @ORM\ManyToOne(targetEntity=Realisation::class, inversedBy="screenshots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisation;

    /**
     * @ORM\ManyToOne(targetEntity=Realisation::class, inversedBy="supImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisationSup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getRealisationSup(): ?Realisation
    {
        return $this->realisationSup;
    }

    public function setRealisationSup(?Realisation $realisationSup): self
    {
        $this->realisationSup = $realisationSup;

        return $this;
    }
}
