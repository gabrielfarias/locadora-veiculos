<x-layout title="Editar Reserva">

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
                    <h2 class="h4">Editar Reserva</h2>
                </div>

                <div class="card-body">

                    <form action="{{ route('reservations.update', $reservation->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Usuário:</label>
                            <select name="user_id" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $reservation->user_id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Veículo:</label>
                            <select name="vehicle_id" class="form-select" required>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ $vehicle->id == $reservation->vehicle_id ? 'selected' : '' }}>
                                        {{ $vehicle->model }} ({{ $vehicle->plate }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pickup_date" class="form-label">Data de Retirada:</label>
                            <input type="date" name="pickup_date"
                                value="{{ $reservation->pickup_date->format('Y-m-d') }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="return_date" class="form-label">Data de Devolução:</label>
                            <input type="date" name="return_date"
                                value="{{ $reservation->return_date->format('Y-m-d') }}" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Edições</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
