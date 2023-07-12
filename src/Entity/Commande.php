<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $adrLivraison = null;

    #[ORM\Column(length: 255)]
    private ?string $adrFacturation = null;

    #[ORM\Column(length: 255)]
    private ?string $tsociete = null;

    #[ORM\Column]
    private ?float $tprix = null;

    #[ORM\Column]
    private ?bool $isFinalized = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeId = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Commandeligne::class)]
    private Collection $commandelignes;

    public function __construct()
    {
        $this->commandelignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAdrLivraison(): ?string
    {
        return $this->adrLivraison;
    }

    public function setAdrLivraison(string $adrLivraison): static
    {
        $this->adrLivraison = $adrLivraison;

        return $this;
    }

    public function getAdrFacturation(): ?string
    {
        return $this->adrFacturation;
    }

    public function setAdrFacturation(string $adrFacturation): static
    {
        $this->adrFacturation = $adrFacturation;

        return $this;
    }

    public function getTsociete(): ?string
    {
        return $this->tsociete;
    }

    public function setTsociete(string $tsociete): static
    {
        $this->tsociete = $tsociete;

        return $this;
    }

    public function getTprix(): ?float
    {
        return $this->tprix;
    }

    public function setTprix(float $tprix): static
    {
        $this->tprix = $tprix;

        return $this;
    }

    public function isIsFinalized(): ?bool
    {
        return $this->isFinalized;
    }

    public function setIsFinalized(bool $isFinalized): static
    {
        $this->isFinalized = $isFinalized;

        return $this;
    }

    public function getStripeId(): ?string
    {
        return $this->stripeId;
    }

    public function setStripeId(?string $stripeId): static
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * @return Collection<int, Commandeligne>
     */
    public function getCommandelignes(): Collection
    {
        return $this->commandelignes;
    }

    public function addCommandeligne(Commandeligne $commandeligne): static
    {
        if (!$this->commandelignes->contains($commandeligne)) {
            $this->commandelignes->add($commandeligne);
            $commandeligne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeligne(Commandeligne $commandeligne): static
    {
        if ($this->commandelignes->removeElement($commandeligne)) {
            // set the owning side to null (unless already changed)
            if ($commandeligne->getCommande() === $this) {
                $commandeligne->setCommande(null);
            }
        }

        return $this;
    }
}
