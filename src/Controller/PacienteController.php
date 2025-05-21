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
}