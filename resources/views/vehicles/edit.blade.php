<x-layout title="Veículos">

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

        <div class="col-md-6 mx-auto"> <!-- Defina o tamanho da coluna como 6 e use mx-auto para centralizar -->
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">Editar Veículo</h2>
                </div>

                <div class="card-body">

                    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="model" class="form-label">Modelo:</label>
                            <input type="text" name="model" value="{{ $vehicle->model }}" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Marca:</label>
                            <input type="text" name="brand" value="{{ $vehicle->brand }}" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Ano:</label>
                            <input type="text" name="year" value="{{ $vehicle->year }}" class="form-control"
                                required>
                            @error('year')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="plate" class="form-label">Placa:</label>
                            <input type="text" name="plate" value="{{ $vehicle->plate }}" class="form-control"
                                required>
                            @error('plate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Edições</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-layout>
