<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pac;

class PacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pacs = [
            ['name' => 'Ciamis'],
            ['name' => 'Cikoneng'],
            ['name' => 'Cijeungjing'],
            ['name' => 'Cisaga'],
            ['name' => 'Sindangkasih'],
            ['name' => 'Cihaurbeuti'],
            ['name' => 'Panjalu'],
            ['name' => 'Panumbangan'],
            ['name' => 'Kawali'],
            ['name' => 'Panawangan'],
            ['name' => 'Rajadesa'],
            ['name' => 'Sukadana'],
            ['name' => 'Rancah'],
            ['name' => 'Tambaksari'],
            ['name' => 'Lakbok'],
            ['name' => 'Purwadadi'],
            ['name' => 'Banjarsari'],
            ['name' => 'Pamarican'],
            ['name' => 'Cidolog'],
            ['name' => 'Cimaragas'],
            ['name' => 'Cipaku'],
            ['name' => 'Jatinagara'],
            ['name' => 'Baregbeg'],
            ['name' => 'Sadananya'],
            ['name' => 'Lumbung'],
            ['name' => 'Jatiwaras'],
            ['name' => 'Sukamantri'],
        ];

        foreach ($pacs as $pac) {
            Pac::create($pac);
        }
    }
}
