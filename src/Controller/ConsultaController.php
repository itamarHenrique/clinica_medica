<?php

namespace App\Controller;

use App\Service\ConsultaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ConsultaController extends AbstractController
{

    public function __construct(private ConsultaService $consultaService){

    }

    #[Route('/api/consulta', name: 'app_consulta', methods:['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->consultaService->listarConsultas());
    }

    #[Route('/api/consulta', methods: ['POST'])]
    public function adicionarConsulta(Request $request)
    {
        $data = json_decode($request->getContent(), associative:true);
        $consulta = $this->consultaService->criarConsulta($data['pacienteId'], $data['medicoId'], $data['data'], $data['horario']);

        return new JsonResponse(['id' => $consulta->getId()], 200);

    }

    public function buscarConsultaPorId(int $id)
    {
        $consulta = $this->consultaService->buscarConsulta($id);

        if($consulta){
            return new JsonResponse(["id" => $consulta->getId(), "paciente" => $consulta->getPaciente->getNome(), "medico" => $consulta->getMedico->getNome(), "crm" => $consulta->getMedico->getCrm(), "data da consulta" => $consulta->getData()->format('d-m-Y'), "horario" => $consulta->getHorario()->format('H:m:s'), "status" => $consulta->getStatus()]);
        }
    }

    #[Route('/api/consulta/{id}', methods:['DELETE'])]
    public function removerConsulta(int $id)
    {
        $consulta = $this->consultaService->removerConsulta($id);

        if($consulta){
            return new JsonResponse(['message' => "A consulta {$consulta->getNome()} foi excluido com sucesso"], 200);
        }
    }
}