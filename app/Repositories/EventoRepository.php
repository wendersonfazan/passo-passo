<?php

namespace App\Repositories;

use App\Enums\Evento\StatusEventoEnum;
use App\Models\Agenda;
use App\Models\Evento;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class EventoRepository
{
    public function create(array $data): void
    {
        $evento = Evento::query()
            ->where('nome', Arr::get($data, 'nome'))
            ->where('data', Arr::get($data, 'data'))
            ->exists();

        if ($evento) {
            throw new \DomainException('Já existe um evento com este nome e data', 400);
        }

        Evento::query()->create([
            'nome' => Arr::get($data, 'nome'),
            'data' => Arr::get($data, 'data'),
            'duracao' => Arr::get($data, 'duracao'),
            'status' => StatusEventoEnum::ATIVO->value
        ]);
    }

    public function registrar(int $eventoId, int $userId): void
    {

        $agenda = Agenda::query()
            ->where('evento_id', $eventoId)
            ->where('user_id', $userId)
            ->exists();

        if ($agenda) {
            throw new \DomainException('Usuário já registrado neste evento', 400);
        }

        Agenda::query()->create([
            'evento_id' => $eventoId,
            'user_id' => $userId
        ]);
    }

    public function update(Evento $evento, array $data): bool
    {
        return $evento->update($data);
    }

    public function getById(int $id): Evento
    {
        $evento = Evento::query()
            ->where('id', $id)
            ->first();

        if (!$evento) {
            throw new \DomainException('Evento não encontrado', 404);
        }

        return $evento;
    }

    public function listByUser($userId): \Illuminate\Support\Collection
    {
        return Evento::with('agendas')->get()->map(function ($evento) use ($userId) {
            return [
                'id' => $evento->id,
                'title' => $evento->nome,
                'start' => $evento->data,
                'backgroundColor' => $evento->agendas->contains('user_id', $userId) ? '#198754' : '#0d6efd',
                'borderColor' => $evento->agendas->contains('user_id', $userId) ? '#14532d' : '#0d6efd',
                'duracao' => $evento->duracao,
            ];
        });
    }

}
