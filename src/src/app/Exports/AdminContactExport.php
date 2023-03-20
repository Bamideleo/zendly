<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class AdminContactExport implements FromView, WithColumnWidths, WithStyles
{

    protected $userId;

    public function __construct($userId) {
        $this->userId = $userId;
    } 

   	public function view(): View
    {
    	if($this->userId == "all"){
        	$contacts = Contact::select('name', 'contact_no')->get();
    	}else{
        	$contacts = Contact::where('user_id', $this->userId)->select('name', 'contact_no')->get();
    	}
        return view('partials.contact_excel', [
            'contacts' => $contacts,
        ]);
    }


    public function styles(Worksheet $sheet)
    {
    	return [
            'A1' => ['font' => ['bold' => true,'size' => 12,]],
            'B1' => ['font' => ['bold' => true,'size' => 12,]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,          
            'B' => 15,          
        ];
    }
}
