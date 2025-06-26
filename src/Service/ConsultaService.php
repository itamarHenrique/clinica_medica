<?php

namespace App\Service;

use App\Dto\ConsultaResource;
use App\Entity\Consulta;
use App\Repository\ConsultaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ConsultaService{


    public function __construct(private EntityManagerInterface $entityManagerInterface, private ConsultaRepository $consultaRepository)
    {

    }

    public function listarConsultas()
    {
        $consultas = $this->entityManagerInterface->getRepository(Consulta::class)->findAll();

        return array_map(function($consulta) {
            return ConsultaResource::fromEntity($consulta);
        }, $consultas);
    }
}