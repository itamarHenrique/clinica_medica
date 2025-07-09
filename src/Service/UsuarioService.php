<?php
namespace App\Service;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioService
{
    public function __construct(private EntityManagerInterface $entityManagerInterface, private UserPasswordHasherInterface $passwordHasher) {

    }

    public function criarUsuario(string $nome, string $email, string $senha, array $roles): Usuario
    {
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($this->passwordHasher->hashPassword($usuario, $senha));
        $usuario->setRoles($roles);

        $this->entityManagerInterface->persist($usuario);
        $this->entityManagerInterface->flush();

        return $usuario;
    }

    public function listarUsuarios(): array
    {
        return $this->entityManagerInterface->getRepository(Usuario::class)->findAll();
    }

    public function editarUsuario(int $id, string $nome, ?string $novaSenha, array $roles): Usuario
    {
        $usuario = $this->entityManagerInterface->getRepository(Usuario::class)->find($id);
        if (!$usuario) {
            throw new \Exception("Usuário não encontrado.");
        }

        $usuario->setNome($nome);
        $usuario->setRoles($roles);

        if ($novaSenha) {
            $usuario->setSenha($this->passwordHasher->hashPassword($usuario, $novaSenha));
        }

        $this->entityManagerInterface->flush();

        return $usuario;
    }

    public function removerUsuario(int $id): void
    {
        $usuario = $this->entityManagerInterface->getRepository(Usuario::class)->find($id);
        if (!$usuario) {
            throw new \Exception("Usuário não encontrado.");
        }

        $this->entityManagerInterface->remove($usuario);
        $this->entityManagerInterface->flush();
    }
}
