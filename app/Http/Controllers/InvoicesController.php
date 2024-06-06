 <?php

    namespace App\Http\Controllers;

    // use Validator;
    use App\Http\Controllers\Controller;
    use App\Models\Invoices;
    use Illuminate\Http\Request;


    class InvoicesController extends Controller
    {

        public function index()
        {
            $invoices = Invoices::all();
            return response()->json($invoices);
        }

        /**
         * almacena y crea un registro nuevo en nuestra BD
         */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'template' => 'required|string|max:255',
                'logo' => 'nullable|string|max:255',
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
            /*  if ($validator->fails()) {
                return response()->json($validator->errors());
            } */

            $invoices = Invoices::create($validated);

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
        public function update(Request $request, $id)
        {

            $invoices = Invoices::find($id);
            $invoices->company_name = $request->company_name;
            $invoices->company_adress = $request->company_adress;
            $invoices->company_phone = $request->company_phone;
            $invoices->company_mail = $request->company_mail;
            $invoices->save();

            return response()->json([
                "message" => "registro modificado correctamente"
            ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
            $invoices = Invoices::find($id);
            $invoices->delete();

            return response()->json([
                "message" => "registro eliminado correctamente"
            ]);
        }
    }
