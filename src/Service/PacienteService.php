<?php

namespace App\Service;

use App\Entity\Paciente;
use App\Repository\PacienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PacienteService
{

    public function __construct(private EntityManagerInterface $entityManagerInterface, private PacienteRepository $pacienteRepository)
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

    public function buscarPaciente(int $id): Paciente
    {
        $paciente = $this->pacienteRepository->find($id);

        if(!$paciente){
            throw new NotFoundHttpException("Paciente com o ID $id não encontrado.");
        }

        return $paciente;

    }

    public function excluirPaciente(int $id): Paciente
    {
        $paciente = $this->buscarPaciente($id);

        $this->entityManagerInterface->remove($paciente);
        $this->entityManagerInterface->flush();
        
        return $paciente;
    }




}