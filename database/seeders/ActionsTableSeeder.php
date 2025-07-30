<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Action;
use File;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * 
     */
    public function run(): void
    {
        Action::truncate();
        $json = File::get("database/data/actions.json");
        $data = json_decode($json);
            foreach ($data as $obj) 
            {
                Action::create(array(
                    'id' => $obj->id,
                    'action_name' => $obj->action_name
                ));
            }
    }
}
