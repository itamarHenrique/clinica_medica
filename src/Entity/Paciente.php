<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacienteRepository::class)]
class Paciente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nome = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dataNascimento = null;

    #[ORM\Column(length:15)]
    private ?string $telefone = null;

    #[ORM\Column(length: 30)]
    private ?string $cpf = null;

    /**
     * @var Collection<int, Consulta>
     */
    #[ORM\OneToMany(targetEntity: Consulta::class, mappedBy: 'paciente')]
    private Collection $consultas;

    public function __construct()
    {
        $this->consultas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

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

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): static
    {
        $this->dataNascimento = $dataNascimento;

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
            $consulta->setPaciente($this);
        }

        return $this;
    }

    public function removeConsulta(Consulta $consulta): static
    {
        if ($this->consultas->removeElement($consulta)) {
            // set the owning side to null (unless already changed)
            if ($consulta->getPaciente() === $this) {
                $consulta->setPaciente(null);
            }
        }

        return $this;
    }
    
}
