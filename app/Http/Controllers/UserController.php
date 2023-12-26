<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()
            ->when(request()->has('search'), function ($query) {
                $query->where('cpf', 'like', '%' .
                    request('search') . '%');
            })
            ->paginate(20);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'cpf' => 'required|string|max:14|unique:users,cpf',
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']); // Hash da senha

            User::create($validatedData);

            return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->route('users.index')->with('error', 'Usuário não encontrado.');
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'cpf' => 'required|string|max:14|unique:users,cpf,' . $id,
                'password' => 'nullable|string|min:6', // Senha é opcional, mas, se fornecida, deve atender aos requisitos
            ]);

            if ($validatedData['password']) {
                $validatedData['password'] = bcrypt($validatedData['password']); // Hash da senha
            } else {
                unset($validatedData['password']); // Se a senha não for fornecida, remova do array para evitar alteração desnecessária
            }

            $user = User::findOrFail($id);
            $user->update($validatedData);

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->route('users.index')->with('error', 'Usuário não encontrado.');
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir o usuário. Detalhes: ' . $e->getMessage());
        }
    }
}
