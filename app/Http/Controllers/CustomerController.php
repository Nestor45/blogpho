<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Funcion para poder traer a dos los clientes(customers) de la BD
     * retornamos en formato JSON para enviar a la vista.
     */
    public function index() {

        $customers = Customer::all();

        $array = array();
        foreach ($customers as $customer) {
            $objectCustomer = new \stdClass();
            $objectCustomer->customer_id = $customer->id;
            $objectCustomer->name = $customer->name;
            $objectCustomer->phone = $customer->phone;
            $objectCustomer->email = $customer->email;
            $objectCustomer->website = $customer->website;
            array_push($array, $objectCustomer);
        }
        if ($array) {
            return response()->json([
                "customers" => $array
            ], 200);
        } else {
            return response()->json([
                "customers" => "No hay nada en la BD"
            ], 250);
        }

        
    }
    /**
     * Funcion que nos devuelve el cliente buscado por su respectivo id
     * al cual lo mandamos a la vista View.vue 
     */
    public function get($id) {
        $customer = Customer::whereId($id)->first();

        return response()->json([
            "customer" => $customer
        ], 200);
    }
    /**
     * Funcion que nos ayuda a guardar un cliente nuevo a la BD 
     */
    public function store(Request $request) {
        $exito = false;

        DB::beginTransaction();

        try { 
            $customer = new Customer;

            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->website = $request->website;

            $customer->save();
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al guardar los datos",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Información guardada correctamente",
                "customer" => $customer
            ], 200);
        }
    }

    public function editCustomer(Request $request) {
        $exito = false;
        DB::beginTransaction();

        try {
            $customer = Customer::find($request->id_customer);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->website = $request->website;
            $customer->save();
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al editar los datos",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Customer editado correctamente",
                "customer" => $customer
            ], 200);
        }
    }
}
