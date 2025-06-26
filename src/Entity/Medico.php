<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicoRepository::class)]
class Medico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $crm = null;

    #[ORM\Column(length: 15)]
    private ?string $telefone = null;

    /**
     * @var Collection<int, Consulta>
     */
    #[ORM\OneToMany(targetEntity: Consulta::class, mappedBy: 'medico')]
    private Collection $consultas;

    public function __construct()
    {
        $this->consultas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCrm(): ?string
    {
        return $this->crm;
    }

    public function setCrm(string $crm): static
    {
        $this->crm = $crm;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): static
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * @return Collection<int, Consulta>
     */
    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function addConsulta(Consulta $consulta): static
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas->add($consulta);
            $consulta->setMedico($this);
        }

        return $this;
    }

    public function removeConsulta(Consulta $consulta): static
    {
        if ($this->consultas->removeElement($consulta)) {
            // set the owning side to null (unless already changed)
            if ($consulta->getMedico() === $this) {
                $consulta->setMedico(null);
            }
        }

        return $this;
    }
}
