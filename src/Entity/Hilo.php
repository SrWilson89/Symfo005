<?php

namespace App\Entity;

use App\Repository\HiloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HiloRepository::class)]
class Hilo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateAdd = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateMod = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notas = null;

    #[ORM\ManyToOne]
    private ?user $usuario = null;

    #[ORM\ManyToOne]
    private ?tareas $tarea = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAdd(): ?\DateTime
    {
        return $this->dateAdd;
    }

    public function setDateAdd(?\DateTime $dateAdd): static
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateMod(): ?\DateTime
    {
        return $this->dateMod;
    }

    public function setDateMod(?\DateTime $dateMod): static
    {
        $this->dateMod = $dateMod;

        return $this;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function setNotas(?string $notas): static
    {
        $this->notas = $notas;

        return $this;
    }

    public function getUsuario(): ?user
    {
        return $this->usuario;
    }

    public function setUsuario(?user $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getTarea(): ?tareas
    {
        return $this->tarea;
    }

    public function setTarea(?tareas $tarea): static
    {
        $this->tarea = $tarea;

        return $this;
    }
}
