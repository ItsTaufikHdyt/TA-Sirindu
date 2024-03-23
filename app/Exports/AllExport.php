<?php

namespace App\Exports;

use App\Models\AllData;
use Maatwebsite\Excel\Concerns\FromCollection;


class AllExport implements FromCollection
{


    public function collection()
    {
        return AllData::all();
    }

    // public function map($data): array
    // {

    //     return [
    //         $data->company_name,
    //         $data->company_code,
    //         $data->company_contact_name,
    //         $data->company_contact_email,
    //         $data->company_contact_phone,
    //         $data->ridercount
    //     ];
    // }

    // public function headings(): array
    // {
    //     return [
    //       'Company Name',
    //       'Company Code',
    //       'Ambassador Name',
    //       'Ambassador Email',
    //       'Ambassador Phone',
    //       'Number of Participants'
    //     ];
    // }
}
