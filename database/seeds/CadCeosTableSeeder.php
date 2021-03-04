<?php

use Illuminate\Database\Seeder;

class CadCeosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('cad_ceos')->insert([
            [
            'id'=> 1,
            'nome'=>null,
            'cpf'=>null,
            'fnome'=>'Agnus',
            'razsoc'=>'Agnus',
            'cnpj'=>'01.234.567/0001-00',
            'email'=>'email@email.com',
            'pessoa'=>'J',
            'status'=>'A',
            'endereco'=>'Rua teste',
            'numero'=>'777',
            'bairro'=>'Santo Cristo',
            'cel'=>'(12) 3123-4567',
            'fone'=>'(12) 90123-4567',
            'cep'=>'84.000-000',
            'cidade'=>'3028',
            'estado'=>'16'
            ],
            [
                'id'=> 2,
                'nome'=>'Carlos',
                'cpf'=>'123.456.789-0',
                'fnome'=>null,
                'razsoc'=>null,
                'cnpj'=>null,
                'email'=>'alexblacee@gmail.com',
                'pessoa'=>'F',
                'status'=>'A',
                'endereco'=>'Rua teste',
                'numero'=>'777',
                'bairro'=>'Santo Cristo',
                'cel'=>'(12) 3123-4567',
                'fone'=>'(12) 90123-4567',
                'cep'=>'84.000-000',
                'cidade'=>'3028',
                'estado'=>'16'
            ],
        ]);
    }
}
