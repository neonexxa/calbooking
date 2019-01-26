<?php

use Illuminate\Database\Seeder;
use App\Equipment;

class EquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipments = [
			['name'=>'HRTEM'],
			['name'=>'FESEM'],
			['name'=>'USPM'],
			['name'=>'SAP'],
			['name'=>'FTIR'],
			['name'=>'Raman'],
			['name'=>'XPS'],
			['name'=>'Particle Sizer'],
			['name'=>'AAS (per sample per element)'],
			['name'=>'GCMS'],
			['name'=>'LCMS'],
			['name'=>'NGA-SCD'],
			['name'=>'GC-FID'],
			['name'=>'TPDRO'],
			['name'=>'XRD'],
			['name'=>'Rheometer'],
			['name'=>'Micro DSC (-20 – 100 OC)'],
			['name'=>'DSC (-20 – 450 OC)'],
			['name'=>'CPM'],
			['name'=>'Goniometer'],
			['name'=>'Karl Fisher Titrator (V30)'],
			['name'=>'TAN (T70)'],
			['name'=>'TGA'],
			['name'=>'Bomb calorimeter' ],
			['name'=>'Universal Testing Machine (UTM)'],
			['name'=>'XRF'],
			['name'=>'ICP-OES'],
			['name'=>'MP-AES'],
			['name'=>'UV-VIS'],
			['name'=>'TOC'],
			['name'=>'CHNS'],
			['name'=>'POROPERM'],
			['name'=>'Mercury Porosimeter'],
			['name'=>'SEM'],
			['name'=>'Pour Point Test'],
        ];
        Equipment::insert($equipments);
        echo "Successfully seed equipments "." \n";
    }
}
