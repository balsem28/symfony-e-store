<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: DetailleCommande::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $detaileCommande;

    #[ORM\ManyToOne(inversedBy: 'commande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\Column(length: 255)]
    private ?string $verifie = null;

    public function __construct()
    {
        $this->detaileCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, DetailleCommande>
     */
    public function getDetaileCommande(): Collection
    {
        return $this->detaileCommande;
    }

    public function addDetaileCommande(DetailleCommande $detaileCommande): static
    {
        if (!$this->detaileCommande->contains($detaileCommande)) {
            $this->detaileCommande->add($detaileCommande);
            $detaileCommande->setCommande($this);
        }

        return $this;
    }

    public function removeDetaileCommande(DetailleCommande $detaileCommande): static
    {
        if ($this->detaileCommande->removeElement($detaileCommande)) {
            // set the owning side to null (unless already changed)
            if ($detaileCommande->getCommande() === $this) {
                $detaileCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getVerifie(): ?string
    {
        return $this->verifie;
    }

    public function setVerifie(string $verifie): static
    {
        $this->verifie = $verifie;

        return $this;
    }
}
