<?php

namespace App\Dto;

use App\Entity\Consulta;

class ConsultaResource
{
    public static function fromEntity(Consulta $consulta): array
    {
        return [
            'id' => $consulta->getId(),
            'data' => $consulta->getData()->format('Y-m-d'),
            'horario' => $consulta->getHorario()->format('H:i'),
            'status' => $consulta->getStatus(),
            'paciente' => [
                'id' => $consulta->getPaciente()->getId(),
                'nome' => $consulta->getPaciente()->getNome(),
                'telefone' => $consulta->getPaciente()->getTelefone(),
            ],
            'medico' => [
                'id' => $consulta->getMedico()->getId(),
                'nome' => $consulta->getMedico()->getNome()
            ],
        ];
    }
}
