<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ContactExport implements FromView, WithColumnWidths, WithStyles
{

    protected $status;

    public function __construct($status) {
        $this->status = $status;
    }

    public function view(): View
    {
        if($this->status){
            $contacts = Contact::whereNull('user_id')->select('name','contact_no')->get();
        }else{
            $contacts = Contact::where('user_id', auth()->user()->id)->select('name','contact_no')->get();
        }
        return view('partials.contact_excel', [
            'contacts' => $contacts,
        ]);
    }


    public function styles(Worksheet $sheet)
    {
    	return [
            'A1' => ['font' => ['bold' => true,'size' => 12,]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30         
        ];
    }



}
