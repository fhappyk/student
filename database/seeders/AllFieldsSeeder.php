<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class AllFieldsSeeder extends Seeder
{
    public function run(): void
    {
        $columnNames = [
            'uuid',
            'first_name',
            'last_name',
            'image',
            'user_name',
            'professional_email',
            'phone',
            'professional_phone',
            'address',
            'city',
            'region',
            'country',
            'lattitude',
            'longitude',
            'department',
            'speciality',
            'speciality',
            'other_phone',
            'other_email',
            'title',
            'years_of_experience', 
            'office_name',
        ];

        // Insert fields into all_fields table
        foreach ($columnNames as $field) {
            DB::table('all_fields')->insert([
                'field_name' => $field,
                'status' => 'active', // Default status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
