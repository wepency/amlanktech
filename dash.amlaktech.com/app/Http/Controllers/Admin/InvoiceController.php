<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    
    public function index()
    {
        $invoices = Invoice::paginate(10); 
        $invoicesCount = Invoice::count(); 
        
        return view('Admin.Invoices.index', [
            'page_title'=>'الفواتير',
            'invoices'=>$invoices,
            'invoicesCount'=>$invoices,
        ]); 
    }

}
