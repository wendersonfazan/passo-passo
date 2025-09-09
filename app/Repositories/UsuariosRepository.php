<?php

namespace App\Repositories;

use App\Models\User;

class UsuariosRepository
{

    public function getUsers()
    {
        return User::query()->get();
    }

    public function getUserById($id)
    {
        $user = User::query()
            ->where('id', $id)
            ->first();

        if (!$user) {
            throw new \DomainException('Usuário não encontrado', 404);
        }
        return $user;
    }

    public function createUser(array $data)
    {
        $user = User::query()->where('email', $data['email'])->first();

        if ($user) {
            throw new \DomainException('Email already exists', 400);
        }

        return User::query()->create($data);
    }

    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }


}
