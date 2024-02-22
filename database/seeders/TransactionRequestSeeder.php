<?php

namespace Database\Seeders;

use App\Models\TransactionRequest;
use Database\Factories\TransactionRequestFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionRequest::factory(70)->create();
    }
}
