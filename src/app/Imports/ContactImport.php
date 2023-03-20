<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralSetting;

class ContactImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $groupId;
    protected $status;

    public function __construct($groupId, $status) {
        $this->groupId = $groupId;
        $this->status = $status;
    }

    public function collection(Collection $rows)
    {

        $general = GeneralSetting::first();
        $data = [];
        foreach ($rows as $row) {
            foreach($row as $key=>$dataVal){
                if($dataVal !=''){
                    if(filter_var($dataVal, FILTER_SANITIZE_NUMBER_INT)){
                        $data['contact_no'] = $dataVal;
                    }
                    else{
                        $data['name'] = $dataVal;
                    }
                }
            }
            Contact::create([
                'user_id' => $this->status == true ? null : auth()->user()->id,
                'group_id' => $this->groupId,
                'name'=> $data['name'],
                'contact_no'=> $data['contact_no'],
                'status'=> 1,
            ]);
        }
    }
}
