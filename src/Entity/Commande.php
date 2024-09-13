<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\Loader\Configurator\Traits\BindTrait;

#[ORM\MappedSuperclass]

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    use BaseEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column]
    private ?bool $statu = null;



    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero_commande): static
    {
        $this->numero = $numero_commande;

        return $this;
    }

    public function isStatu(): ?bool
    {
        return $this->statu;
    }

    public function setStatue(bool $statu): static
    {
        $this->statu = $statu;

        return $this;
    }
}
