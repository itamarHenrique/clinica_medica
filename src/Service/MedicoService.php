<?php

namespace App\Service;

use App\Entity\Medico;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MedicoService
{


    public function __construct(private EntityManagerInterface $entityManagerInterface, private MedicoRepository $medicoRepository)
    {

    }

    public function listarMedicos(): array
    {
        return $this->entityManagerInterface->getRepository(Medico::class)->findAll();
    }

    public function criarMedico(array $dados): Medico
    {
        $medico = new Medico();
        $medico->setNome($dados['nome']);
        $medico->setTelefone($dados['telefone']);
        $medico->setCrm($dados['crm']);
        
        $this->entityManagerInterface->persist($medico);
        $this->entityManagerInterface->flush();

        return $medico;
    }

    public function buscarMedico(int $id): Medico
    {
        $medico = $this->medicoRepository->find($id);

        if(!$medico){
            throw new NotFoundHttpException("Paciente com o ID `${id}` não foi encontrado.");
        }

        return $medico;
    }

    public function removerMedico(int $id): Medico
    {
        $medico = $this->buscarMedico($id);

        $this->entityManagerInterface->remove($medico);
        $this->entityManagerInterface->flush();

        return $medico;
    }
}