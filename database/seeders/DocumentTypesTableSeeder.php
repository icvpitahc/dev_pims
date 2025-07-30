<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType;
use File;
class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentType::truncate();
        $json = File::get("database/data/document_types.json");
        $data = json_decode($json);
            foreach ($data as $obj) 
            {
                DocumentType::create(array(
                    'id' => $obj->id,
                    'document_type_name' => $obj->document_type_name
                ));
            }
    }
}
