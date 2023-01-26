<?php

namespace App\Entity;

use App\Repository\HoneyPotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoneyPotRepository::class)
 */
class HoneyPot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $attemptDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttemptDate(): ?\DateTimeInterface
    {
        return $this->attemptDate;
    }

    public function setAttemptDate(\DateTimeInterface $attemptDate): self
    {
        $this->attemptDate = $attemptDate;

        return $this;
    }
}
