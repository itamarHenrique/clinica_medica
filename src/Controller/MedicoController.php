<?php

namespace App\Controller;

use App\Service\MedicoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class MedicoController extends AbstractController
{

    public function __construct(private MedicoService $medicoService)
    {

    }

    #[Route('/api/medico', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->medicoService->listarMedicos());
    }

    #[Route('/api/medico', methods: ['POST'])]
    public function adicionaMedico(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $paciente = $this->medicoService->criarMedico($data);

        return new JsonResponse(['id' => $paciente->getId()], 200);
    }

    #[Route('api/medico/{id}', methods:['GET'])]
    public function getMedicoById(int $id): JsonResponse
    {
        $medico = $this->medicoService->buscarMedico($id);

        return new JsonResponse(["id" => $medico->getId(), "nome do medico: " => $medico->getNome(), "crm do medico: " => $medico->getCrm(), "telefone do medico: " => $medico->getTelefone()]);
    }

    #[Route('/api/medico/{id}', methods:['DELETE'])]
    public function excluirMedico(int $id)
    {
        $medico = $this->medicoService->removerMedico($id);

        if($medico){
            return new JsonResponse(['message' => "O médico {$medico->getNome()} foi excluído com sucesso."], 200);
        }
    }
}
