<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    // creamos la tabla
    protected $table = "invoices";

    // defino los campos de la tabla
    protected $fillable = [
        "paid", "template",  "logo", "number_invoice", "company_name", "company_address", "company_phone", "company_mail", "company_cif",
        "client_name", "client_address", "client_phone", "client_mail", "client_cif", "iva", "iva_amount", "irpf", "irpf_amount", "issue_date", "expiration_date", "service", "quantity", "price", "user_ID"
    ];
    //establece relación entre las tablas, define una relacion de pertenencia entre invoices
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
