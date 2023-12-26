<x-layout title="Relatório de Reservas">

    <x-nav-bar />
    <div class="container pt-3">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    Relatório de Reservas
                </div>

                <div class="card-body">
                    <form action="{{ route('reservations.report') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="vehicle_id" class="form-label">Veículo:</label>
                                <select name="vehicle_id" class="form-control">
                                    <option value="" selected disabled>Selecione um veículo</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->model }} -
                                            {{ $vehicle->plate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="date" class="form-label">Data:</label>
                                <input type="date" name="date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mt-4">Buscar Reservas</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    @if($request->filled('vehicle_id') && $request->filled('date'))
    <table class="table">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daysInMonthCollection as $day)
                <tr>
                    <td>{{ $day->format('d-m-Y') }}</td>
                    <td>
                        @php
                            $hasReservation = false;

                            foreach ($reservations as $reservation) {
                                if ($reservation->pickup_date->format('d-m-Y') == $day->format('d-m-Y') || $reservation->return_date->format('d-m-Y') == $day->format('d-m-Y')) {
                                    echo $reservation->user->name . ' - ' . $reservation->vehicle->model . '<br>';
                                    $hasReservation = true;
                                }
                            }

                            if (!$hasReservation) {
                                echo 'Disponível';
                            }
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Por favor, selecione um veículo e uma data para buscar as reservas.</p>
@endif

                </div>
            </div>
        </div>
    </div>

</x-layout>
