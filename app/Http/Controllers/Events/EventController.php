<?php

namespace App\Http\Controllers\Events;

use App\Enums\Evento\StatusEventoEnum;
use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Evento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{

    public function criar(Request $request)
    {
        try {
            $data = $request->all();

            $evento = Evento::query()
                ->where('nome', Arr::get($data, 'nome'))
                ->where('data', Arr::get($data, 'data'))
                ->exists();

            if ($evento) {
                return Redirect::route('eventos.index')->with('error', 'Evento já existe');
            }


            Evento::query()->create([
                'nome' => Arr::get($data, 'nome'),
                'data' => Arr::get($data, 'data'),
                'duracao' => Arr::get($data, 'duracao'),
                'status' => StatusEventoEnum::ATIVO->value
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar evento: ' . $e->getMessage()
            ], 500);
        }

        return Redirect::route('eventos.index');
    }

    public function editar(int $id, Request $request)
    {
        try {
            $data = $request->all();

            $evento = Evento::query()
                ->where('id', $id)
                ->first();

            if (!$evento) {
                return response()->json([
                    'message' => 'Evento não encontrado'
                ], 404);
            }

            $evento->update([
                'nome' => Arr::get($data, 'nome', $evento->nome),
                'data' => Arr::get($data, 'data', $evento->data),
                'descricao' => Arr::get($data, 'descricao', $evento->descricao),
                'duracao' => Arr::get($data, 'duracao', $evento->duracao),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao editar evento: ' . $e->getMessage()
            ], 500);
        }


        return response()->json([
            'message' => 'Evento atualizado com sucesso',
            'evento' => $evento
        ]);
    }

    public function cancelar(int $id)
    {
        try {
            $evento = Evento::query()
                ->where('id', $id)
                ->first();

            if (!$evento) {
                return response()->json([
                    'message' => 'Evento não encontrado'
                ], 404);
            }

            $evento->update([
                'status' => StatusEventoEnum::CANCELADO->value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cancelar evento: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Evento cancelado com sucesso',
            'evento' => $evento
        ]);
    }

    public function eventos()
    {
        try {
            $userId = auth()->id();
            $eventos = Evento::with('agendas')->get()->map(function ($evento) use ($userId) {
                return [
                    'id' => $evento->id,
                    'title' => $evento->nome,
                    'start' => $evento->data,
                    // verifica se o usuário participa
                    'backgroundColor' => $evento->agendas->contains('user_id', $userId) ? '#198754' : '#0d6efd',
                    'borderColor' => $evento->agendas->contains('user_id', $userId) ? '#14532d' : '#0d6efd',
                ];
            });


        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar meus eventos: ' . $e->getMessage()
            ], 500);
        }
        return view('eventos.index', compact('eventos'));
    }

}
