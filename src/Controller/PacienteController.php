<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PacienteService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PacienteController extends AbstractController
{
    public function __construct(private PacienteService $service) {}

    #[Route('/api/pacientes', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->service->listarPacientes());
    }

    #[Route('/api/pacientes', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $paciente = $this->service->criarPaciente($data);

        return new JsonResponse(['id' => $paciente->getId()], 201);
    }

    #[Route('/api/pacientes/{id}', methods:['GET'])]
    public function getPacienteById(int $id)
    {
        $paciente = $this->service->buscarPaciente($id);

        return new JsonResponse(['id' => $paciente->getId(), 'nome' => $paciente->getNome(), 'cpf' => $paciente->getCpf(), 'telefone' => $paciente->getTelefone(), 'data-de-nascimento' => $paciente->getDataNascimento()->format('d/m/Y')]);
    }


    #[Route('/api/pacientes/{id}', methods:['DELETE'])]
    public function excluirPaciente(int $id)
    {
        $paciente = $this->service->excluirPaciente($id);

        if($paciente){
            return new JsonResponse( ['mensagem' => "Paciente {$paciente->getNome()}excluido com sucesso."], 200);
        }
    }
}