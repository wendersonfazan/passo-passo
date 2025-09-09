<?php

namespace App\Http\Controllers;

use App\Repositories\UsuariosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public function __construct(
        private readonly UsuariosRepository $usuariosRepository,
    )
    {

    }

    public function usuarios(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $users = $this->usuariosRepository->getUsers();

        } catch (\Exception $e) {
            return Redirect::route('usuarios.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return view('usuarios.index', compact('users'));
    }

    public function setAdmin($id): \Illuminate\Http\RedirectResponse
    {
        try {
            $user = $this->usuariosRepository->getUserById($id);

            $this->usuariosRepository->updateUser($user, ['is_admin' => !$user->is_admin]);

        } catch (\Exception $e) {
            return Redirect::route('usuarios.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return Redirect::route('usuarios.index')->with('message', 'Usuário atualizado com sucesso.');
    }

    public function deleteUser($id): \Illuminate\Http\RedirectResponse
    {
        try {
            $user = $this->usuariosRepository->getUserById($id);

            $this->usuariosRepository->deleteUser($user);

        } catch (\Exception $e) {
            return Redirect::route('usuarios.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return Redirect::route('usuarios.index')->with('message', 'Usuário deletado com sucesso.');
    }
}
