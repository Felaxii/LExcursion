<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function test_database_connection()
    {
        $this->assertIsArray(DB::select('SELECT 1'));
    }
}
