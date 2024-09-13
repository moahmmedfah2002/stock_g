<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\Loader\Configurator\Traits\BindTrait;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    use BaseEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

}
