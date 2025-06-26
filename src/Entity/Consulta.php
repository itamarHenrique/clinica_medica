<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
class Consulta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $data = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $horario = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'consultas')]
    private ?Paciente $paciente = null;

    #[ORM\ManyToOne(inversedBy: 'consultas')]
    private ?Medico $medico = null;

    #[ORM\Column]
    private ?\DateTime $criado_em = null;

    #[ORM\Column]
    private ?\DateTime $atualizado_em = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTime
    {
        return $this->data;
    }

    public function setData(\DateTime $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getHorario(): ?\DateTime
    {
        return $this->horario;
    }

    public function setHorario(\DateTime $horario): static
    {
        $this->horario = $horario;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;

        return $this;
    }

    public function getMedico(): ?Medico
    {
        return $this->medico;
    }

    public function setMedico(?Medico $medico): static
    {
        $this->medico = $medico;

        return $this;
    }

    public function getCriadoEm(): ?\DateTime
    {
        return $this->criado_em;
    }

    public function setCriadoEm(\DateTime $criado_em): static
    {
        $this->criado_em = $criado_em;

        return $this;
    }

    public function getAtualizadoEm(): ?\DateTime
    {
        return $this->atualizado_em;
    }

    public function setAtualizadoEm(\DateTime $atualizado_em): static
    {
        $this->atualizado_em = $atualizado_em;

        return $this;
    }
}
