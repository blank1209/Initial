<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{

    protected $suppliers = [
        [
            'supplierName' => 'Achievers Food and Bakery Ingredients Corp',
            'address'  => 'M222+J5R, Balingasa St, Quezon City, Metro Manila',
            'contactNumber' => '0283651061'
        ], 
    
        [
            'supplierName' => 'Asco Marketing',
            'address'  => 'Ilagan Street, Barangay Paltok, Quezon City, 1105 Metro Manila',
            'contactNumber' => '0283718182'
        ],
    
        [
            'supplierName' => "Asian Grains", 
            'address' => 'Unit 903, Ayala Life FGU Building, Mindanao Avenue, Cebu City, 6000',
            'contactNumber' => '0328452895' 
        ],

        [
            'supplierName' => "A's Valley Enterprise",   
            'address' => '146 Central Pico, La Tinidad, Benguet, La Trinidad, Philippines',
            'contactNumber' => '0744450786'
        ],
    
        [
            'supplierName' => 'Bakels Philippines Inc.',
            'address' => 'Suites 601 - 603, Raffles Corporate Center, Don Francisco Ortigas, Jr. Road',
            'contactNumber' => '0279150372'   
        ],
        
        [
            'supplierName' => 'Delicatesse Food Corporation',
            'address' => 'San Martin de Porres, Parañaque, 1700 Metro Manila', 
            'contactNumber'=>  '02888007221' 
        ],
    
        [
            'supplierName' => 'DLM Poultry Eggs', 
            'address' => 'N/A', 
            'contactNumber'=>  'N/A' 
        ],
    
        [
            'supplierName' => 'Efgen Marketing',   
            'address' => 'Fortune Village 7, 55 Burgos, Valenzuela, Metro Manila',
            'contactNumber'=>  '09280452700'
        ],
    
        [
            'supplierName' => 'F.Y Sons',   
            'address' => '95 P. De Guzman, Valenzuela, 1440 Metro Manila',
            'contactNumber'=>  '09178238016'
        ],
    
        [
            'supplierName' => 'Golden Eggs - Mapandan',  
            'address' => 'Golden, Pandan Ave, Mapandan, 2429 Pangasinan',
            'contactNumber'=>  'N/A'
        ],
    
        [
            'supplierName' => 'Granville Supply Chain Management Corp',   
            'address' => '405 National Hwy, San Fernando, 2500 La Union',
            'contactNumber'=> '09177131626'
        ],
    
        [
            'supplierName' => 'Limketkai Manufacturing Corporation', 
            'address' => 'Suite 201, Limketkai Building, Ortigas Avenue, Greenhills San Juan City, Metro Manila', 
            'contactNumber'=> '0287214401' 
        ],
    
        [
            'supplierName' => 'MJM Commercial',  
            'address' => "Liquette's Building, Km4, La Trinidad, Philippines",
            'contactNumber' => '09088962890'
        ],
    
        [
            'supplierName' => 'NAPINTAS Commercial',
            'address' => 'S.E. Jayme St., Zone Tamates, Paknaan, Mandaue City, Philippines',
            'contactNumber' => '09778010055' 
        ],
    
        [
            'supplierName' => 'OLEO-FATS Incorporated', 
            'address' => '5 Mercury Ave, Quezon City, 1100 Metro Manila',
            'contactNumber'=> '0287096536' 
        ],
    
        [
            'supplierName' => 'Puratos Philippines',   
            'address' => '14 Perfecto Avenue, Bagumbayan Tanyag Industrial Zone, Taguig City Metro Manila',
            'contactNumber' =>  '09190784520'
        ],
    
        [
            'supplierName' => 'SBCO Merchandise',  
            'address' => '49 Ferguson Road,, Baguio City, Philippines',
            'contactNumber' => '05254750212'
        ],
        
        [
            'supplierName' => 'SANMIE Food',
            'address' => '6 Narra, Quezon City, 1116 Metro Manila',
            'contactNumber' =>  '09325550008',
        ],
    
        [
            'supplierName' => 'TIONG SAN Supermart',   
            'address' => '1 Km4, La Trinidad, 2601 Benguet',
            'contactNumber' => '0744221228'
        ],
    
        [
            'supplierName' => 'UNICOM',
            'address' => '341 Taylo St, Pasay City, Philippines',
            'contactNumber' => '0270016351'   
        ],
    
        [
            'supplierName' => 'SAN MIGUEL Corporation', 
            'address' => '40 San Miguel Avenue, Mandaluyong City 1550 Metro Manila, Philippines',
            'contactNumber' => '06326323000
'
        ],

        [
            'supplierName' => 'SHERWIN Eggs',
            'address' => 'N/A',
            'contactNumber' => '09323665205'  
        ],

        [
            'supplierName' => 'OUT SOURCE',
            'address' => 'N/A',
            'contactNumber' => 'N/A' 
        ],

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        foreach($this->suppliers as $suppliers) {
            Supplier::create($suppliers);
        }
 
    }
}
