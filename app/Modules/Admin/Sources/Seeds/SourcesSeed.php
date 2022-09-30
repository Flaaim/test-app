<?php

namespace App\Modules\Admin\Sources\Seeds;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SourcesSeed extends Seeder {
    public function run()
    {
        DB::table('sources')->insert([
            [
                'title'=> 'Instagram'
            ],
            [
                'title'=> 'Viber'
            ],
            [
                'title'=> 'Website'
            ],
            [
                'title'=> 'Phone'
            ],
        ]);
    }
}