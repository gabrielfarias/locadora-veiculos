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

        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">Criar Novo Veículo</h2>
                </div>

                <div class="card-body">

                    <form action="{{ route('vehicles.store') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="model" class="form-label">Modelo:</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Marca:</label>
                            <input type="text" name="brand" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Ano:</label>
                            <input type="text" name="year" class="form-control" required>
                            @error('year')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="plate" class="form-label">Placa:</label>
                            <input type="text" name="plate" class="form-control" required>
                            @error('plate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Criar Veículo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
