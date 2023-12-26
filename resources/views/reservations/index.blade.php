<x-layout title="Lista de Reservas">

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

        <div class="card">
            <div class="card-header">
                Lista de Reservas
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Veículo</th>
                            <th scope="col">Retirada</th>
                            <th scope="col">Devolução</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->vehicle->model }} ({{ $reservation->vehicle->plate }})</td>
                                <td>{{ $reservation->pickup_date->format('d-m-Y') }}</td>
                                <td>{{ $reservation->return_date->format('d-m-Y') }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-auto">
                                            <a href="{{ route('reservations.edit', $reservation->id) }}"
                                                class="btn btn-warning">Editar</a>
                                        </div>
                                        <div class="col-auto">
                                            <form action="{{ route('reservations.destroy', $reservation->id) }}"
                                                method="post"
                                                onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layout>
