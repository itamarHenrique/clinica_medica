<?php

namespace App\Service;

use App\Dto\ConsultaResource;
use App\Entity\Consulta;
use App\Entity\Medico;
use App\Entity\Paciente;
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

    public function criarConsulta (int $pacienteId, int $medicoId, \DateTimeInterface $data, \DateTimeInterface $horario): Consulta
    {
        $paciente = $this->entityManagerInterface->getRepository(Paciente::class)->find($pacienteId);
        $medico = $this->entityManagerInterface->getRepository(Medico::class)->find($medicoId);

        if(!$paciente){
            throw new \InvalidArgumentException("Paciente não encontrado!");
        } elseif(!$medico){
            throw new \InvalidArgumentException("Medico não encontrado!");
        }

        $conflito = $this->entityManagerInterface->getRepository(Consulta::class)->findOneBy([
            'data' => $data,
            'horario' => $horario,
            'medico' => $medico
        ]);

        if($conflito){
            throw new \Exception('Já existe uma consulta para este medico nesse dia e horario.');
        }

        $consulta = new Consulta();
        $consulta->setPaciente($paciente);
        $consulta->setHorario($horario);
        $consulta->setData($data);
        $consulta->setStatus('agendada');
        $consulta->setCriadoEm(new \DateTime());
        $consulta ->setAtualizadoEm(new \DateTime());

        $this->entityManagerInterface->persist($consulta);
        $this->entityManagerInterface->flush();

        return $consulta;
    }

    public function editarConsulta(int $consultaId, int $pacientId, int $medicoId, \DateTimeInterface $data, \DateTimeInterface $horario): Consulta
    {
        $consulta = $this->entityManagerInterface->getRepository(Consulta::class)->find($consultaId);

        if(!$consulta){
            throw new \InvalidArgumentException("Consulta não encontrada");
        }

        $paciente = $this->entityManagerInterface->getRepository(Paciente::class)->find($pacientId);
        $medico = $this->entityManagerInterface->getRepository(Medico::class)->find($medicoId);
    
        
        if(!$paciente){
            throw new \InvalidArgumentException("Paciente não encontrado!");
        } elseif(!$medico){
            throw new \InvalidArgumentException("Medico não encontrado!");
        }

        $conflito = $this->entityManagerInterface->getRepository(Consulta::class)->findOneBy([
            'data' => $data,
            'horario' => $horario,
            'medico' => $medico
        ]);
    
        if($conflito){
            throw new \Exception('Ja existe outra consulta para esse médico nesse horario.');
        }

        $consulta->setPaciente($paciente);
        $consulta->setMedico($medico);
        $consulta->setHorario($horario);
        $consulta->setAtualizadoEm(new \DateTime());
        $consulta->setData($data);
    
        $this->entityManagerInterface->flush();

        return $consulta;
    
    }

    public function removerConsulta(int $consultaId): void
    {
        $consulta = $this->entityManagerInterface->getRepository(Consulta::class)->find($consultaId);

        if(!$consulta){
            throw new \InvalidArgumentException("Consulta não encontrada");
        }

        $this->entityManagerInterface->remove($consulta);
        $this->entityManagerInterface->flush();
    }
}