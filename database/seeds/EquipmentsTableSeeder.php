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
			['name'=>'HRTEM','location_id'=>1],
			['name'=>'FESEM','location_id'=>1],
			['name'=>'USPM','location_id'=>1],
			['name'=>'SAP','location_id'=>1],
			['name'=>'FTIR','location_id'=>1],
			['name'=>'Raman','location_id'=>1],
			['name'=>'XPS','location_id'=>1],
			['name'=>'Particle Sizer','location_id'=>1],
			['name'=>'AAS (per sample per element)','location_id'=>1],
			['name'=>'GCMS','location_id'=>1],
			['name'=>'LCMS','location_id'=>1],
			['name'=>'NGA-SCD','location_id'=>1],
			['name'=>'GC-FID','location_id'=>1],
			['name'=>'TPDRO','location_id'=>1],
			['name'=>'XRD','location_id'=>1],
			['name'=>'Rheometer','location_id'=>1],
			['name'=>'Micro DSC (-20 – 100 OC)','location_id'=>1],
			['name'=>'DSC (-20 – 450 OC)','location_id'=>1],
			['name'=>'CPM','location_id'=>1],
			['name'=>'Goniometer','location_id'=>1],
			['name'=>'Karl Fisher Titrator (V30)','location_id'=>1],
			['name'=>'TAN (T70)','location_id'=>1],
			['name'=>'TGA','location_id'=>1],
			['name'=>'Bomb calorimeter' ,'location_id'=>1],
			['name'=>'Universal Testing Machine (UTM)','location_id'=>1],
			['name'=>'XRF','location_id'=>1],
			['name'=>'ICP-OES','location_id'=>1],
			['name'=>'MP-AES','location_id'=>1],
			['name'=>'UV-VIS','location_id'=>1],
			['name'=>'TOC','location_id'=>1],
			['name'=>'CHNS','location_id'=>1],
			['name'=>'POROPERM','location_id'=>1],
			['name'=>'Mercury Porosimeter','location_id'=>1],
			['name'=>'SEM','location_id'=>1],
			['name'=>'Pour Point Test','location_id'=>1],
        ];
        Equipment::insert($equipments);
        echo "Successfully seed equipments "." \n";
    }
}
