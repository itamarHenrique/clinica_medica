<?php

namespace App\Service;

use App\Entity\Paciente;
use Doctrine\ORM\EntityManagerInterface;

class PacienteService
{

    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {

    }

    public function listarPacientes(): array
    {
        return $this->entityManagerInterface->getRepository(Paciente::class)->FindAll();
    }

    public function criarPaciente(array $dados): Paciente
    {
        $paciente = new Paciente();
        $paciente->setNome($dados['nome']);
        $paciente->setCpf($dados['cpf']);
        $paciente->setTelefone($dados['telefone']);
        $paciente->setDataNascimento(new \DateTime($dados['dataNascimento']));

        $this->entityManagerInterface->persist($paciente);
        $this->entityManagerInterface->flush();

        return $paciente;

    }




}