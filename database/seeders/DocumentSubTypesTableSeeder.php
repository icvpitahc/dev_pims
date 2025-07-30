<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentSubType;
use File;

class DocumentSubTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentSubType::truncate();
        $json = File::get("database/data/document_sub_types.json");
        $data = json_decode($json);
            foreach ($data as $obj) 
            {
                DocumentSubType::create(array(
                    'id' => $obj->id,
                    'document_type_id' => $obj->document_type_id,
                    'document_sub_type_name' => $obj->document_sub_type_name
                ));
            }
    }
}
