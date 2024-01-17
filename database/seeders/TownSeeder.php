<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Town;

class TownSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $towns = [
      "Alaró", "Alcúdia", "Algaida", "Andratx", "Ariany", "Artà", "Banyalbufar", 
      "Binissalem", "Bunyola", "Búger", "Calvià", "Campanet", "Campos", "Capdepera", 
      "Consell", "Costitx", "Deià", "Escorca", "Esporles", "Estellencs", "Felanitx", 
      "Fornalutx", "Inca", "Lloret de Vista Alegre", "Lloseta", "Llubí", "Llucmajor", 
      "Manacor", "Mancor de la Vall", "Maria de la Salut", "Marratxí", "Montuïri", 
      "Muro", "Palma de Mallorca", "Petra", "Pollença", "Porreres", "Puigpunyent", 
      "Sa Pobla", "Sant Joan", "Sant Llorenç", "Santa Eugènia", "Santa Margalida", 
      "Santa Maria del Camí", "Santanyí", "Selva", "Sencelles", "Ses Salines", 
      "Sineu", "Sóller", "Valldemossa"
    ];

    foreach ($towns as $townName) {
      Town::create(['name' => $townName]);
    }
  }
}
