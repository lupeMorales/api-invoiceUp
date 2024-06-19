<?php

namespace App\Http\Controllers;

// use Validator;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class InvoicesController extends Controller
{

    public function index(Request $request) /* devuelve todas las facturas */
    {
        $user = $request->user();
        $invoices = Invoices::where("user_ID", $user->id)->get();

        // devuelve un JSON
        return response()->json($invoices);
    }

    public function indexByUser(Request $request)
    {
        $user = $request->user();
        return response()->json($user->invoices);
    }
    /**
     * almacena y crea un registro nuevo en nuestra BD
     */
    public function store(Request $request)
    {

        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated user',
            ], 401);
        }

        $validated = $request->validate([
            'template' => 'required|string|max:255',
            'logo' => 'nullable|file',
            'number_invoice' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
            'company_mail' => 'required|string|email|max:255',
            'company_cif' => 'required|string|max:20',
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_mail' => 'required|string|email|max:255',
            'client_cif' => 'required|string|max:20',
            'iva' => 'required|numeric|between:0,100',
            'iva_amount' => 'nullable|numeric',
            'irpf' => 'required|numeric|between:0,100',
            'irpf_amount' => 'nullable|numeric',
            'issue_date' => 'required|date',
            'expiration_date' => 'required|date',
            'service' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);
        /*         info("he validado");
        if ($validated->fails()) {
            return response()->json($validated->errors());
        } */

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $path = $request->logo->store('logos', 'public');
            //Guarda el archivo en 'storage/app/public/logos
            /*  info('path');
            info($path); */
            Log::info('Logo uploaded successfully', ['path' => $path]);
            $validated['logo'] = $path; // Guarda la ruta en el array válido
        }

        // Añadir el campo 'paid' con valor predeterminado false
        $validated['paid'] = false;
        $validated['user_ID'] = $user->id;
        $invoices = Invoices::create($validated);
        Log::info('Invoice created successfully', ['invoice' => $invoices]);

        $invoices->save();

        return response()->json([
            "message" => "registro agregado correctamente",
            'invoice' => $invoices
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = Invoices::find($id);
        if (!empty($invoices)) {
            return response()->json($invoices);
        } else {
            return response()->json([
                "message" => "no se ha encontrado el registro solicitado"
            ]);
        };
        header("Content-type: image/jpeg");
        echo $invoices->foto;
        exit;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $number_invoice)
    {

        $invoices = Invoices::find($number_invoice);
        $invoices->company_name = $request->company_name;
        $invoices->company_address = $request->company_adress;
        $invoices->company_phone = $request->company_phone;
        $invoices->company_mail = $request->company_mail;
        $invoices->paid = $request->paid;
        $invoices->save();

        return response()->json([
            "message" => "registro modificado correctamente"
        ]);
    }

    public function markAsPaid($numberInvoice)
    {
        $invoice = Invoices::where('number_invoice', $numberInvoice)->firstOrFail();
        $invoice->update(['paid' => true]);
        return response()->json(['message' => 'Factura marcada como cobrada']);
    }

    // Update el stado de la factura





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($number_invoice)
    {
        try {
            // Buscar la factura por el número de factura
            $invoice = Invoices::where('number_invoice', $number_invoice)->first();

            if (!$invoice) {
                return response()->json([
                    "message" => "Factura no encontrada"
                ], 404);
            }

            $invoice->delete();

            return response()->json([
                "message" => "Registro eliminado correctamente"
            ]);
        } catch (\Exception $e) {
            // Capturar y registrar cualquier excepción ocurrida
            Log::error('Error al eliminar la factura: ' . $e->getMessage());

            return response()->json([
                "message" => "Error al eliminar la factura"
            ], 500);
        }
    }
}
