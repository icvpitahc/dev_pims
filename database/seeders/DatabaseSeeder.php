<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AvailedServicesTableSeeder::class);
        // $this->call(ClientTypesTableSeeder::class);
        // $this->call(DivisionsTableSeeder::class);
        // $this->call(OfficesTableSeeder::class);
        // $this->call(RatingsTableSeeder::class);
        // $this->call(SexTypesTableSeeder::class);
        // $this->call(StatusTypesTableSeeder::class);
        // $this->call(TransactingOfficesTableSeeder::class);
        // $this->call(UserlevelsTableSeeder::class);
        // $this->call(OfficeTypesTableSeeder::class);
        // $this->call(AwarenessResponsesTableSeeder::class);
        // $this->call(VisibilityResponsesTableSeeder::class);
        // $this->call(HelpfulnessResponsesTableSeeder::class);
        // $this->call(ServiceTypesTableSeeder::class);
        // $this->call(ServiceCategoriesTableSeeder::class);
        // $this->call(ClientGroupsTableSeeder::class);
        // $this->call(RegionsTableSeeder::class);
        // $this->call(ProvincesTableSeeder::class);
        // $this->call(CitiesTableSeeder::class);
        // $this->call(BarangaysTableSeeder::class);
        // $this->call(RequestStatusTypesTableSeeder::class);
        // $this->call(RequestTypesTableSeeder::class);
        // $this->call(SubRequestTypesTableSeeder::class);
        // $this->call(PositionsTableSeeder::class);
        // $this->call(SalaryGradesTableSeeder::class);
        // $this->call(DocumentTypesTableSeeder::class);
        $this->call(DocumentSubTypesTableSeeder::class);
        // $this->call(ActionsTableSeeder::class);
    }
}
