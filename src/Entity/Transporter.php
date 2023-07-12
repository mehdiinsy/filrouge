<?php

namespace App\Entity;

use App\Repository\TransporterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransporterRepository::class)]
class Transporter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameSociety = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionSociety = null;

    #[ORM\Column]
    private ?float $priceSociety = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSociety(): ?string
    {
        return $this->nameSociety;
    }

    public function setNameSociety(string $nameSociety): static
    {
        $this->nameSociety = $nameSociety;

        return $this;
    }

    public function getDescriptionSociety(): ?string
    {
        return $this->descriptionSociety;
    }

    public function setDescriptionSociety(string $descriptionSociety): static
    {
        $this->descriptionSociety = $descriptionSociety;

        return $this;
    }

    public function getPriceSociety(): ?float
    {
        return $this->priceSociety;
    }

    public function setPriceSociety(float $priceSociety): static
    {
        $this->priceSociety = $priceSociety;

        return $this;
    }

    public function __toString()
    {
        return $this->nameSociety . "[br]" . $this->descriptionSociety .  "[br]" . number_format($this->priceSociety,2,',','.') . " €";
         
    }
}
