<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::query()
            ->when(request()->has('search'), function ($query) {
                $query->where('model', 'like', '%' .
                    request('search') . '%');
            })
            ->paginate(20);

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicles.create');
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
                'model' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'year' => 'required|numeric',
                'plate' => 'required|string|max:10',
            ]);

            Vehicle::create($validatedData);

            return redirect()->route('vehicles.index')->with('success', 'Veículo criado com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::find($id);

        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return redirect()->route('vehicles.index')->with('error', 'Veículo não encontrado.');
        }

        try {
            $validatedData = $request->validate([
                'model' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'year' => 'required|numeric',
                'plate' => 'required|string|max:10',
            ]);

            $vehicle->update($validatedData);

            return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua solicitação. Detalhes: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::find($id);

            if (!$vehicle) {
                return redirect()->route('vehicles.index')->with('error', 'Veículo não encontrado.');
            }

            $vehicle->delete();

            return redirect()->route('vehicles.index')->with('success', 'Veículo excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir o veículo. Detalhes: ' . $e->getMessage());
        }
    }
}
