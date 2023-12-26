<!--@ extends('layouts.default')-->

<x-layout title="Lista de Veículos">

    <!--<livewire:nav-bar /> -->
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
                Lista de Veículos
            </div>

            <div class="card-body">
                <form action="{{ route('vehicles.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Buscar modelo"
                            aria-label="search" aria-describedby="basic-addon1">
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Ano</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->id }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->year }}</td>
                                <td>{{ $vehicle->plate }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-auto">
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                class="btn btn-warning">Editar</a>
                                        </div>
                                        <div class="col-auto">
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="post"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este veículo?')">
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
