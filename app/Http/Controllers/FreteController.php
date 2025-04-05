<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreteController extends Controller
{

     public function calcularFretePorDistancia($cepOrigem, $cepDestino, $valorKm)
     {
         // 1. Calcular distância em km entre os CEPs
         $distanciaKm = $this->calcularDistanciaEntreCEPs($cepOrigem, $cepDestino);
         
         // 2. Calcular valor do frete
         $valorFrete = $distanciaKm * $valorKm;
         
         return [
             'distancia_km' => $distanciaKm,
             'valor_frete' => number_format($valorFrete, 2, ',', '.'),
         ];
     }
 
     private function calcularDistanciaEntreCEPs($cepOrigem, $cepDestino)
     {
         // Implementação simplificada - na prática você usaria uma API de geolocalização
         // ou teria uma tabela com distâncias pré-calculadas
         
         $cep1 = preg_replace('/[^0-9]/', '', $cepOrigem);
         $cep2 = preg_replace('/[^0-9]/', '', $cepDestino);
         
         $diferenca = abs(intval($cep1) - intval($cep2));
         
         $distancia = sqrt($diferenca) * 0.5;
         
         return max(1, min($distancia, 100)); 
     }
}
