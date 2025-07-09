<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/usuarios')]
class UsuarioController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function criar(Request $request, UsuarioService $usuarioService): JsonResponse
    {
        $data = $request->toArray();

        try {
            $usuario = $usuarioService->criarUsuario(
                $data['nome'],
                $data['email'],
                $data['senha'],
                $data['roles'] ?? ['ROLE_USER']
            );

            return new JsonResponse(['id' => $usuario->getId()], 201);

        } catch (\Throwable $e) {
            return new JsonResponse(['erro' => $e->getMessage()], 400);
        }
    }

    #[Route('', methods: ['GET'])]
    public function listar(UsuarioService $usuarioService): JsonResponse
    {
        $usuarios = $usuarioService->listarUsuarios();

        $data = array_map(function (Usuario $usuario) {
            return [
                'id' => $usuario->getId(),
                'nome' => $usuario->getNome(),
                'email' => $usuario->getEmail(),
                'roles' => $usuario->getRoles(),
            ];
        }, $usuarios);

        return new JsonResponse($data);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function editar(int $id, Request $request, UsuarioService $usuarioService): JsonResponse
    {
        $data = $request->toArray();

        try {
            $usuario = $usuarioService->editarUsuario(
                $id,
                $data['nome'],
                $data['senha'] ?? null,
                $data['roles'] ?? ['ROLE_USER']
            );

            return new JsonResponse(['success' => true]);

        } catch (\Throwable $e) {
            return new JsonResponse(['erro' => $e->getMessage()], 400);
        }
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function remover(int $id, UsuarioService $usuarioService): JsonResponse
    {
        try {
            $usuarioService->removerUsuario($id);
            return new JsonResponse(['success' => true]);

        } catch (\Throwable $e) {
            return new JsonResponse(['erro' => $e->getMessage()], 400);
        }
    }
}
