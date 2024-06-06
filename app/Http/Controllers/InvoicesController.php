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
            $validator = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone' => 'required|integer|max:9',
                'company_mail' => 'requires|string|email|max:255|unique:users',
                'company_cif' => 'required|string|max:9',
                'client_name' => 'required|string|max:255',
                'client_address' => 'required|string|max:255',
                'client_phone' => 'required|integer|max:9',
                'client_mail' => 'requires|string|email|max:255|unique:users',
                'client_cif' => 'required|string|max:9',
                'iva' => 'required|regex:/^\d*\.\d{0,1}$/',
                'iva_amount' => 'required|regex:/^\d*\.\d{0,2}$/',
                'irpf' => 'required|regex:/^\d*\.\d{0,1}$/',
                'irpf_amount' => 'required|regex:/^\d*\.\d{0,2}$/',
                'issue_date' => 'required|',
                'expiration_date' => 'required|',
                'service' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|regex:/^\d*\.\d{0,2}$/',
                'total_invoice' => 'required|regex:/^\d*\.\d{0,2}$/',
                'number_invoice' => 'required|string|min:6|max:6'
            ]);
            /*  if ($validator->fails()) {
                return response()->json($validator->errors());
            } */

            $invoices = new Invoices;

            // la imagen se convierte en binario
            /*  if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageData = file_get_contents($image->getRealPath());
            $invoices->foto = $imageData;
        } */
            // $invoices->logo = $request->logo;
            $invoices->company_name = $request->company_template;
            $invoices->company_name = $request->company_name;
            $invoices->company_adress = $request->company_address;
            $invoices->company_phone = $request->company_phone;
            $invoices->company_mail = $request->company_mail;
            $invoices->company_cif = $request->company_cif;
            $invoices->client_name = $request->client_name;
            $invoices->client_address = $request->client_address;
            $invoices->client_phone = $request->client_phone;
            $invoices->client_mail = $request->client_mail;
            $invoices->client_cif = $request->client_cif;

            $invoices->iva = $request->iva;
            $invoices->irpf = $request->irpf;
            $invoices->issue_date = $request->issue_date;
            $invoices->expiration_date = $request->expiration_date;
            $invoices->service = $request->service;
            $invoices->quantity = $request->quantity;
            $invoices->price = $request->price;
            $invoices->total_invoice = $request->total_invoice;
            $invoices->number_invoice = $request->number_invoice;



            $invoices->save();
            return response()->json([
                "message" => "registro agregado correctamente"
            ]);
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
