<?php

namespace App\Http\Controllers;

use App\Events\CarReservation;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::with('user', 'vehicle')->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $vehicles = Vehicle::all();

        return view('reservations.create', compact('users', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'pickup_date' => 'required|date',
                'return_date' => 'required|date',
            ]);

            // Verifica se o veículo já está reservado por outro usuário
            if (Reservation::vehicleAlreadyReserved($request->vehicle_id, $request->user_id, $request->pickup_date, $request->return_date)) {
                return redirect()->back()->with('error', 'Este veículo já está reservado por outro usuário.');
            }

            $reservation = Reservation::create($validatedData);

            event(new CarReservation($reservation->user_id, $reservation->vehicle_id));

            return redirect()->route('reservations.index')->with('success', 'Reserva criada com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $users = User::all();
        $vehicles = Vehicle::all();

        return view('reservations.edit', compact('reservation', 'users', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'pickup_date' => 'required|date',
                'return_date' => 'required|date',
            ]);

            $reservation = Reservation::findOrFail($id);

            // Impedir a exclusão se a reserva estiver em andamento
            if ($reservation->pickup_date <= now() && now() <= $reservation->return_date) {
                return redirect()->route('reservations.index')->with('error', 'Não é possível atualizar uma reserva em andamento.');
            }

            // Verifica se o veículo já está reservado por outro usuário
            if (Reservation::vehicleAlreadyReserved($request->vehicle_id, $request->user_id, $request->pickup_date, $request->return_date)) {
                return redirect()->back()->with('error', 'Este veículo já está reservado por outro usuário.');
            }

            $reservation->update($validatedData);

            return redirect()->route('reservations.index')->with('success', 'Reserva atualizada com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            // Impedir a exclusão se a reserva estiver em andamento
            if ($reservation->pickup_date <= now() && now() <= $reservation->return_date) {
                return redirect()->route('reservations.index')->with('error', 'Não é possível excluir uma reserva em andamento.');
            }

            $reservation->delete();

            return redirect()->route('reservations.index')->with('success', 'Reserva excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'Ocorreu um erro ao excluir a reserva. Detalhes: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        try {
            $vehicles = Vehicle::all();

            // Obter o mês selecionado a partir do formulário
            $selectedMonth = Carbon::parse($request->input('date'));

            // Calcular o número de dias no mês
            $daysInMonth = $selectedMonth->daysInMonth;

            // Criar uma coleção de objetos DateTime representando cada dia do mês
            $daysInMonthCollection = collect();
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $daysInMonthCollection->push($selectedMonth->copy()->day($day));
            }

            $query = Reservation::query();

            if ($request->filled('vehicle_id')) {
                $query->where('vehicle_id', $request->input('vehicle_id'));
            }

            if ($request->filled('date')) {
                $query->whereDate('pickup_date', '<=', $request->input('date'))
                    ->whereDate('return_date', '>=', $request->input('date'));
            }

            $reservations = $query->get();

            return view('reservations.report', compact('reservations', 'vehicles', 'daysInMonthCollection', 'request'))
                ->with('success', 'Reservas carregadas com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar a busca de reservas. Detalhes: ' . $e->getMessage());
        }
    }
}
