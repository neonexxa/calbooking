<?php

use Illuminate\Database\Seeder;
use App\Service;
class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
        ['max_sample' => 4, 'equipment_id' => 1, 'user_id' => 17,'name' => 'Imaging','fast_track'=>360,'normal'=>180],
		['max_sample' => 4, 'equipment_id' => 1, 'user_id' => 17,'name' => 'Imaging + Diffraction','fast_track'=>450,'normal'=>225],
		['max_sample' => 4, 'equipment_id' => 1, 'user_id' => 17,'name' => 'Imaging + EELS','fast_track'=>480,'normal'=>240],
		['max_sample' => 4, 'equipment_id' => 1, 'user_id' => 17,'name' => 'Imaging + Diffraction + EELS','fast_track'=>500,'normal'=>250],
		
		['max_sample' => 4, 'equipment_id' => 2, 'user_id' => 18,'name'=>'Imaging','fast_track'=>250,'normal'=>130],
		['max_sample' => 4, 'equipment_id' => 2, 'user_id' => 18,'name'=>'Imaging + EDX','fast_track'=>280,'normal'=>140],
		['max_sample' => 4, 'equipment_id' => 2, 'user_id' => 18,'name'=>'Imaging + EDX + Mapping','fast_track'=>320,'normal'=>160],
		
		['max_sample' => 4, 'equipment_id' => 3, 'user_id' => 19,'name' => 'DFM','fast_track'=>150,'normal'=>75],
		['max_sample' => 4, 'equipment_id' => 3, 'user_id' => 19,'name' => 'AFM','fast_track'=>175,'normal'=>90],
		
		['max_sample' => 1, 'equipment_id' => 4, 'user_id' => 20,'name' => 'Mesopores','fast_track'=>180,'normal'=>90],
		['max_sample' => 1, 'equipment_id' => 4, 'user_id' => 20,'name' => 'Micropores','fast_track'=>285,'normal'=>140],
		
		['max_sample' => 8, 'equipment_id' => 5, 'user_id' => 23,'name' => 'FTIR','fast_track'=>40,'normal'=>20],
		
		['max_sample' => 4, 'equipment_id' => 6, 'user_id' => 21,'name' => 'Spectra','fast_track'=>150,'normal'=>75],
		
		['max_sample' => 4, 'equipment_id' => 7, 'user_id' => 20,'name' => 'Chemical Analysis','fast_track'=>380,'normal'=>190],
		['max_sample' => 4, 'equipment_id' => 7, 'user_id' => 20,'name' => 'Depth Profiling','fast_track'=>460,'normal'=>230],
		
		['max_sample' => 8, 'equipment_id' => 8, 'user_id' => 21,'name' => 'Particle Size','fast_track'=>75,'normal'=>40],
		['max_sample' => 8, 'equipment_id' => 8, 'user_id' => 21,'name' => 'Particle Size + Zeta Potential','fast_track'=>135,'normal'=>70],
		['max_sample' => 1, 'equipment_id' => 8, 'user_id' => 21,'name' => 'pH Titration','fast_track'=>165,'normal'=>85],
		
		['max_sample' => 8, 'equipment_id' => 9, 'user_id' => 22,'name' => 'Flame (Detection limit: sub ppm)','fast_track'=>45,'normal'=>25],
		['max_sample' => 8, 'equipment_id' => 9, 'user_id' => 22,'name' => 'Graphite (Detection limit: sub ppb)','fast_track'=>55,'normal'=>30],
		
		['max_sample' => 4, 'equipment_id' => 10, 'user_id' => 24,'name' => 'GCMS','fast_track'=>170,'normal'=>85],
		['max_sample' => 4, 'equipment_id' => 10, 'user_id' => 24,'name' => 'With pyrolyzer','fast_track'=>210,'normal'=>105],
		
		['max_sample' => 8, 'equipment_id' => 11, 'user_id' => 23,'name' => 'HPLC','fast_track'=>120,'normal'=>60],
		['max_sample' => 4, 'equipment_id' => 11, 'user_id' => 27,'name' => 'LCMS','fast_track'=>280,'normal'=>170],
		
		['max_sample' => 8, 'equipment_id' => 12, 'user_id' => 27,'name' => 'Natural Gas','fast_track'=>280,'normal'=>170],
		['max_sample' => 8, 'equipment_id' => 12, 'user_id' => 27,'name' => 'Sulphur','fast_track'=>405,'normal'=>200],
		
		['max_sample' => 8, 'equipment_id' => 13, 'user_id' => 24,'name' => 'Hydrocarbon','fast_track'=>120,'normal'=>60],
		['max_sample' => 8, 'equipment_id' => 13, 'user_id' => 24,'name' => 'SimDist ASTM D2887','fast_track'=>200,'normal'=>100],
		['max_sample' => 8, 'equipment_id' => 13, 'user_id' => 24,'name' => 'SimDist ASTM D7169','fast_track'=>385,'normal'=>192],
		
		['max_sample' => 2, 'equipment_id' => 14, 'user_id' => 25,'name' => 'TPR','fast_track'=>190,'normal'=>95],
		['max_sample' => 1, 'equipment_id' => 14, 'user_id' => 25,'name' => 'TPD','fast_track'=>235,'normal'=>120],
		['max_sample' => 2, 'equipment_id' => 14, 'user_id' => 25,'name' => 'TPO','fast_track'=>190,'normal'=>95],
		['max_sample' => 2, 'equipment_id' => 14, 'user_id' => 25,'name' => 'Pulse Chemisorption','fast_track'=>190,'normal'=>95],
		
		['max_sample' => 8, 'equipment_id' => 15, 'user_id' => 26,'name' => 'Powder (Bench Top)','fast_track'=>120,'normal'=>60],
		['max_sample' => 8, 'equipment_id' => 15, 'user_id' => 26,'name' => 'Powder (Floor Stand)','fast_track'=>180,'normal'=>90],
		['max_sample' => 8, 'equipment_id' => 15, 'user_id' => 27,'name' => 'Thin Film/ Spot','fast_track'=>360,'normal'=>180],
		['max_sample' => 2, 'equipment_id' => 15, 'user_id' => 27,'name' => 'In-Situ','fast_track'=>'45/H','normal'=>'25/H'],
		
		['max_sample' => 2, 'equipment_id' => 16, 'user_id' => 28,'name' => 'Rheological / WAT','fast_track'=>'50/H','normal'=>'25/H'],
		
		['max_sample' => 1, 'equipment_id' => 17, 'user_id' => 28,'name' => 'Thermal Analysis (Ambient Pressure)','fast_track'=>'35/H','normal'=>'21/H'],
		['max_sample' => 1, 'equipment_id' => 17, 'user_id' => 28,'name' => 'Thermal Analysis (High Pressure: max 150 bar)','fast_track'=>'40/H','normal'=>'24/H'],
		
		['max_sample' => 4, 'equipment_id' => 18, 'user_id' => 28,'name' => 'Thermal Analysis (Ambient Pressure)','fast_track'=>'42/H','normal'=>'21/H'],
		
		['max_sample' => 4, 'equipment_id' => 19, 'user_id' => 28,'name' => 'WAT Test','fast_track'=>75,'normal'=>39],
		['max_sample' => 4, 'equipment_id' => 19, 'user_id' => 28,'name' => 'Morphology','fast_track'=>40,'normal'=>24],
		
		['max_sample' => 4, 'equipment_id' => 20, 'user_id' => 28,'name' => 'Interfacial tension/ surface tension/ contact angle','fast_track'=>85,'normal'=>51],
		
		['max_sample' => 4, 'equipment_id' => 21, 'user_id' => 28,'name' => 'Water content determination (ASTM E203)','fast_track'=>100,'normal'=>60],
		
		['max_sample' => 4, 'equipment_id' => 22, 'user_id' => 28,'name' => 'Total Acid Number (ASTM D664)','fast_track'=>80,'normal'=>48],
		['max_sample' => 4, 'equipment_id' => 22, 'user_id' => 28,'name' => 'Salinity','fast_track'=>80,'normal'=>60],
		
		['max_sample' => 4, 'equipment_id' => 23, 'user_id' => 28,'name' => 'TGA','fast_track'=>120,'normal'=>60],
		['max_sample' => 4, 'equipment_id' => 23, 'user_id' => 28,'name' => 'TGA with MS','fast_track'=>150,'normal'=>75],
		
		['max_sample' => 8, 'equipment_id' => 24, 'user_id' => 23,'name' => 'Calorific value analysis (ASTM D240-17)','fast_track'=>20,'normal'=>10],
		
		['max_sample' => 8, 'equipment_id' => 25, 'user_id' => 29,'name' => 'Tensile strength, bending test, compression test, Static test – Polymer, steel, Concrete beam <500 mm','fast_track'=>50,'normal'=>30],
		
		['max_sample' => 8, 'equipment_id' => 26, 'user_id' => 29,'name' => 'Elemental', 'fast_track'=>120,'normal'=>60],
		['max_sample' => 8, 'equipment_id' => 26, 'user_id' => 29,'name' => 'Oxide', 'fast_track'=>120,'normal'=>60],
		['max_sample' => 8, 'equipment_id' => 26, 'user_id' => 29,'name' => 'Elemental & oxide', 'fast_track'=>150,'normal'=>75],
		
		['max_sample' => 8, 'equipment_id' => 27, 'user_id' => 25,'name' => 'All elements Detection range: 0.4 ppm – 1 ppb','fast_track'=>'135 (50)','normal'=>'81(30)'],
		
		
		['max_sample' => 8, 'equipment_id' => 28, 'user_id' => 22,'name' => 'All elements Detection range: 100 – 1000 ppm','fast_track'=>'135 (50)','normal'=>	'81(30)'],
			
		['max_sample' => 6, 'equipment_id' => 29, 'user_id' => 30,'name' => 'UV-VIS (Liquid/powder)','fast_track'=>25,'normal'=>15],

		['max_sample' => 6, 'equipment_id' => 30, 'user_id' => 30,'name' => 'TOC','fast_track'=>60,'normal'=>36],
		
		['max_sample' => 4, 'equipment_id' => 31, 'user_id' => 22,'name' => 'C, H, N, S (max temp:900 OC)','fast_track'=>125,'normal'=>75],
		
		['max_sample' => 8, 'equipment_id' => 32, 'user_id' => 31,'name' => 'Porosity & permeability','fast_track'=>90,'normal'=>45],
		
		
		['max_sample' => 2, 'equipment_id' => 33, 'user_id' => 25,'name' => 'Fast scan ( 4 hours)','fast_track'=>540,'normal'=>270],
		['max_sample' => 2, 'equipment_id' => 33, 'user_id' => 25,'name' => 'Slow scan (8 hours)','fast_track'=>640,'normal'=>320],
		
		['max_sample' => 4, 'equipment_id' => 34, 'user_id' => 26,'name' => 'Imaging', 'fast_track'=>150,'normal'=>75],
		['max_sample' => 4, 'equipment_id' => 34, 'user_id' => 26,'name' => 'Imaging + EDX', 'fast_track'=>180,'normal'=>90],
		['max_sample' => 4, 'equipment_id' => 34, 'user_id' => 26,'name' => 'Imaging + EDX + Mapping', 'fast_track'=>220,'normal'=>110],
		
		['max_sample' => 4, 'equipment_id' => 35, 'user_id' => 28,'name' => '', 'fast_track'=>42,'normal'=>24],
		];
		Service::insert($services);
		echo "Successfully seed services "." \n";
    }
}
