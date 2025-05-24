<? php

namespace App\Service;

use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;

class MedicoService
{


    public function __construct(private EntityManagerInterface $entityManagerInterface, private MedicoRepository $medicoRepository)
    {

    }

    public function listarMedicos(): array
    {
        return $this->entityManagerInterface->getRepository(Medico::class)->findAll();
    }
}