<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'name'=>'hr alamin',
            'type'=>'admin',
            'phone'=>'01472583695',
            'email'=>'hralamin2020@gmail.com',
            'email_verified_at' => now(),
            'password'=>Hash::make('000000')
        ]);
        $categories = [
            'Tablet',
            'Capsule',
            'Syrup',
            'Injection',
            'Ointment',
            'Cream',
            'Gel',
            'Drops',
            'Inhaler',
            'Powder',
        ];

        $brands = [
            'Square Pharmaceuticals Ltd.',
            'Beximco Pharmaceuticals Ltd.',
            'Incepta Pharmaceuticals Ltd.',
            'Eskayef Bangladesh Ltd.',
            'ACI Limited',
            'Opsonin Pharma Limited',
            'Renata Limited',
            'Radiant Pharmaceuticals Ltd.',
            'Novartis (Bangladesh) Limited',
            'GSK Bangladesh Limited'
        ];
        $groups = [
            'Paracetamol',
            'Ibuprofen',
            'Aspirin',
            'Amoxicillin',
            'Ciprofloxacin',
            'Metformin',
            'Omeprazole',
            'Fluoxetine',
            'Loratadine',
            'Diazepam',
        ];
        $units = [
            'Piece',
            'Box',
            'Packet',
            'Bottle',
            'Tube',
            'Sachet',
            'Ampoule',
            'Vial',
            'Jar',
            'Canister',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
        foreach ($groups as $group) {
            Group::create([
                'name' => $group,
            ]);
        }
        foreach ($units as $unit) {
            Unit::create([
                'name' => $unit,
            ]);
        }
        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand
            ]);
        }
        $products = [
            'Paracetamol', 'Ibuprofen', 'Aspirin', 'Ciprofloxacin', 'Doxycycline', 'Amoxicillin', 'Metronidazole', 'Azithromycin', 'Clarithromycin', 'Levofloxacin', 'Moxifloxacin', 'Co-trimoxazole', 'Fluconazole', 'Ketoconazole', 'Terbinafine', 'Acyclovir', 'Valacyclovir', 'Famciclovir', 'Oseltamivir', 'Ribavirin', 'Sildenafil', 'Tadalafil', 'Vardenafil', 'Atorvastatin', 'Simvastatin', 'Rosuvastatin', 'Ezetimibe', 'Fenofibrate', 'Gemfibrozil', 'Irbesartan', 'Losartan', 'Valsartan', 'Amlodipine', 'Felodipine', 'Lisinopril', 'Ramipril', 'Clopidogrel', 'Aspirin and Clopidogrel', 'Warfarin', 'Rivaroxaban', 'Apixaban', 'Dabigatran', 'Omeprazole', 'Pantoprazole', 'Lansoprazole', 'Rabeprazole', 'Esomeprazole', 'Famotidine', 'Ranitidine', 'Metformin', 'Gliclazide', 'Glimepiride', 'Pioglitazone', 'Sitagliptin', 'Vildagliptin', 'Insulin Glargine', 'Insulin Detemir', 'Insulin Aspart', 'Insulin Lispro', 'Human Regular Insulin', 'Levothyroxine', 'Methylprednisolone', 'Prednisolone', 'Prednisone', 'Cetirizine', 'Loratadine', 'Fexofenadine', 'Chlorpheniramine', 'Diphenhydramine', 'Prochlorperazine', 'Domperidone', 'Ondansetron', 'Granisetron', 'Dexamethasone', 'Hydroxyzine', 'Buspirone', 'Lorazepam', 'Clonazepam', 'Alprazolam', 'Fluoxetine', 'Sertraline', 'Citalopram', 'Paroxetine', 'Escitalopram', 'Amitriptyline', 'Nortriptyline', 'Imipramine', 'Desipramine', 'Phenobarbital', 'Phenytoin', 'Carbamazepine', 'Valproic Acid', 'Lamotrigine', 'Gabapentin', 'Pregabalin', 'Methotrexate', 'Cyclophosphamide', 'Fluorouracil', 'Doxorubicin', 'Cisplatin', 'Paclitaxel', 'Docetaxel', 'Vincristine', 'Vinblastine', 'Bleomycin', 'Etanercept', 'Adalimumab', 'Infliximab', 'Rituximab', 'Trastuzumab', 'Bevacizumab', 'Cetuximab', 'Erlotinib', 'Gefitinib', 'Imatinib', 'Dasatinib', 'Sorafenib', 'Sunitinib', 'Lenalidomide',
        ];
        foreach ($products as $product) {
            Product::create([
                'name' => $product,
                'size' => rand(10, 1000).' - mg',
                'price' => rand(1, 1000),
                'category_id' => rand(1, 10),
                'brand_id' => rand(1, 10),
                'group_id' => rand(1, 10),
                'buying_unit_id' => rand(1, 10),
                'selling_unit_id' => rand(1, 10),
            ]);
        }
             \App\Models\User::factory(10)->create();
             \App\Models\Post::factory(50)->create();
             \App\Models\Comment::factory(100)->create();
        \App\Models\Setup::factory(1)->create();
//             \App\Models\Category::factory(10)->create();
//             \App\Models\Brand::factory(10)->create();
//             \App\Models\Unit::factory(10)->create();
//             \App\Models\Group::factory(10)->create();
//        \App\Models\Product::factory(30)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
