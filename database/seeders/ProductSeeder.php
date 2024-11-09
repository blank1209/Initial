<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    protected $product_categories = [
        /*'categoryName' => "Bread"
        'categoryName' => "Cakes"
        'categoryName' => "Pastries"
        'categoryName' => "Pasalubong"
        'categoryName' => "Hotbakes"
        'categoryName' => "Loaves"*/

        //cakes
        [
            'productCategory' => '1',
            'productName' => 'Burger Buns',
            'unit' => 'Pack x6',
            'quantity'=> '50',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Cheese Buns',
            'unit' => 'Pack x8',
            'quantity'=> '50',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Cinnamon Round',
            'unit' => 'Piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Cinnamon Round-Special',
            'unit' => 'Piece',
            'quantity'=> '16',
                    ],

        [
            'productCategory' => '1',
            'productName' => 'Coco Bites',
            'unit' => 'Pack',
            'quantity'=> '11',
                    ],

        [
            'productCategory' => '1',
            'productName' => 'Cream Bread',
            'unit' => 'Piece',
            'quantity'=> '335',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Lady Finger',
            'unit' => 'Piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Mamon Kabayan',
            'unit' => 'Pack x8',
            'quantity'=> '286',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Milk Bread',
            'unit' => 'Piece',
            'quantity'=> '61',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Mongo Bread',
            'unit' => 'Piece',
            'quantity'=> '31',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Panderosa',
            'unit' => 'Piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Pandesal',
            'unit' => 'Pack x10',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Pandesal-Malunggay',
            'unit' => 'Pack x10',
            'quantity'=> '15',
                    ],

        [
            'productCategory' => '1',
            'productName' => 'Peanut Butter',
            'unit' => 'Piece',
            'quantity'=> '87',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Raisin Buns',
            'unit' => 'Piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Raisin Bread',
            'unit' => 'Piece',
            'quantity'=> '18',
                    ],

        [
            'productCategory' => '1',
            'productName' => 'Spanish Bread',
            'unit' => 'Pack x5',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Squash Pandesal',
            'unit' => 'Pack x10',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '1',
            'productName' => 'Steamed Siopao',
            'unit' => 'Piece',
            'quantity'=> '720',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Toasted Siopao',
            'unit' => 'Piece',
            'quantity'=> '600',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Ube Bites',
            'unit' => 'Pack',
            'quantity'=> '9',
                    ],

        [
            'productCategory' => '1',
            'productName' => 'Ube Bread 500g',
            'unit' => 'Piece',
            'quantity'=> '49',
            
        ],

        [
            'productCategory' => '1',
            'productName' => 'Wheat Bread Buns',
            'unit' => 'Piece',
            'quantity'=> '40',
            
        ],
        //cakes
        [
            'productCategory' => '2',
            'productName' => '8 Round Yema Cake',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => '8 Round Choco Marble',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => ' 8 Round Custard Cake',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => ' 8x12 YemaCake',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => 'Cake Roll-Yema & Choco-Whole',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => 'Cake Roll-Yema & Choco-Half',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => ' Streamline Vanilla',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => ' Streamline Caramel',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '2',
            'productName' => 'Streamline Choco',
            'unit' => 'Cake',
            'quantity'=> '0',
                  ],

        //pastries
       
        [
            'productCategory' => '3',
            'productName' => 'Banana/Carrot Muffin',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Brownies Small',
            'unit' => 'pack x8',
            'quantity'=> '79',
            
        ],

        [
            'productCategory' => '3',
            'productName' => 'Brownies',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Brownies Big',
            'unit' => 'pack x12',
            'quantity'=> '62',
            
        ],

        [
            'productCategory' => '3',
            'productName' => 'Choco Crinkles',
            'unit' => 'JAR',
            'quantity'=> '79',
            
        ],

        [
            'productCategory' => '3',
            'productName' => 'Choco Crinkles',
            'unit' => 'pack x4',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Mamon Special',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Cinnamon Roll',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Chiffon Slice',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Egg Pie',
            'unit' => 'Whole',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Hopia Baboy',
            'unit' => 'piece',
            'quantity'=> '373',
            
        ],

        [
            'productCategory' => '3',
            'productName' => 'Hopia Baboy',
            'unit' => 'pack x4',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Hopia Mongo',
            'unit' => 'pack x4',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Hopia Ube',
            'unit' => 'pack x4',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'NUTRI-PEANUT Cookies',
            'unit' => 'piece',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Premium Brownies',
            'unit' => 'Box',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '3',
            'productName' => 'Toasted Ensaymada',
            'unit' => 'Box',
            'quantity'=> '0',
                  ],

        //PASALUBONG
        [
            'productCategory' => '4',
            'productName' => 'Butter Toast',
            'unit' => 'Piece',
            'quantity'=> '1546',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Merigue Kisses',
            'unit' => 'Piece',
            'quantity'=> '510',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Merigue Kisses Jar',
            'unit' => 'Piece',
            'quantity'=> '35',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Merigue Kisses Jar',
            'unit' => 'Piece',
            'quantity'=> '35',
            
        ],
        /*Pacencia Cookies	|piece 100g	|580	|32.00	|18,560.00
        Pacencia Cookies JAR	|piece 225g		|100.00
        Pilipit			|piece 10 pcs		|32.00
        Pilipit			|piece 15 pcs		|50.00		
        Sesame Cookies		|piece 100g	|377	|32.00	|12,064.00
        Sesame Cookies		|piece 175g		|100.00
        Toasted Muffin		|piece		|803	|38.00	|30,514.00
        Crinkles Pack		|piece		|172	|45.00	|7,740.00
        Crinkles Jar		|piece		|30	|130.00	|3,900.00*/
        
        [
            'productCategory' => '4',
            'productName' => '*Pacencia Cookies',
            'unit' => 'Piece 100g',
            'quantity'=> '580',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Pacencia Cookies JAR',
            'unit' => 'Piece 225g',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '4',
            'productName' => 'Pilipit',
            'unit' => 'Piece 10 pcs',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '4',
            'productName' => 'Pilipit',
            'unit' => 'Piece 15 pcs',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '4',
            'productName' => 'Sesame Cookies ',
            'unit' => 'Piece 100g',
            'quantity'=> '377',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Sesame Cookies',
            'unit' => 'Piece 175g',
            'quantity'=> '0',
                  ],

        [
            'productCategory' => '4',
            'productName' => 'Toasted Muffin',
            'unit' => 'Piece',
            'quantity'=> '803',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Crinkles Pack',
            'unit' => 'Piece',
            'quantity'=> '172',
            
        ],

        [
            'productCategory' => '4',
            'productName' => 'Crinkles JAR',
            'unit' => 'Piece',
            'quantity'=> '30',
            
        ],
    ];
    
    public function run(): void
    {
    //
        foreach($this->product_categories as $product_categories) {
            Product::create($product_categories);
        }

    }
}
     

