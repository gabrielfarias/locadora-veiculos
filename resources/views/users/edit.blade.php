<x-layout title="Usuários">

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
                    <h2 class="h4">Editar Usuário</h2>
                </div>

                <div class="card-body">

                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome:</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" name="email" value="{{ $user->email }}" class="form-control"
                                required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha:</label>
                            <input type="password" name="password" value="{{ $user->password }}" class="form-control"
                                required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" name="cpf" value="{{ $user->cpf }}" class="form-control"
                                required>
                            @error('cpf')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Outros campos -->

                        <button type="submit" class="btn btn-primary">Salvar Edições</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-layout>
