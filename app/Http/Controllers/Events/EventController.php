<?php

namespace App\Http\Controllers\Events;

use App\Enums\Evento\StatusEventoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Eventos\CriarEventoRequest;
use App\Http\Requests\Eventos\EditarEventoRequest;
use App\Http\Requests\Eventos\RegistrarEventoRequest;
use App\Models\Agenda;
use App\Models\Evento;
use App\Repositories\EventoRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{

    public function __construct(
        private readonly EventoRepository $eventoRepository
    )
    {

    }

    public function criar(CriarEventoRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['data'] = Carbon::parse($data['data'])->format('Y-m-d H:i');

            $this->eventoRepository->create($data);
        } catch (\Exception $e) {
            return Redirect::route('eventos.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return Redirect::route('eventos.index')->with(['message' => 'Evento criado com sucesso']);

    }

    public function registrar(RegistrarEventoRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            $this->eventoRepository->registrar($data['evento_id'], auth()->id());
        } catch (\Exception $e) {
            return Redirect::route('eventos.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return Redirect::route('eventos.index')->with(['message' => 'Registrado com sucesso no evento']);

    }

    public function editar(EditarEventoRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            $evento = $this->eventoRepository->getById($data['evento_id']);
            $this->eventoRepository->update($evento, $data);
        } catch (\Exception $e) {
            return Redirect::route('eventos.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }


        return Redirect::route('eventos.index')->with(['message' => 'Evento editado com sucesso']);

    }

    public function cancelar(int $id)
    {
        try {
            $evento = $this->eventoRepository->getById($id);

            $this->eventoRepository->update($evento, [
                'status' => StatusEventoEnum::CANCELADO->value
            ]);
        } catch (\Exception $e) {
            return Redirect::route('eventos.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return Redirect::route('eventos.index')->with(['message' => 'Evento Cancelado com sucesso']);
    }

    public function eventos(Request $request)
    {
        try {
            $userId = auth()->id();
            $eventos = $this->eventoRepository->listByUser($userId);

        } catch (\Exception $e) {
            return Redirect::route('eventos.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        }

        return view('eventos.index', compact('eventos'));
    }

}
