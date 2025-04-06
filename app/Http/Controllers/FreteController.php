<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FreteController extends Controller
{
    public function calcularFretePorDistancia($cepOrigem, $cepDestino, $valorKm)
    {
    try {
        // Busca coordenadas em paralelo para melhor performance
        $coordenadasOrigem = $this->buscarCoordenadasPorCep($cepOrigem);
        $coordenadasDestino = $this->buscarCoordenadasPorCep($cepDestino);

        if (!$coordenadasOrigem || !$coordenadasDestino) {
            return response()->json([
                'erro' => 'Não foi possível obter a localização de um ou ambos os CEPs.'
            ], 400);
        }

        // Valida coordenadas
        if (!isset($coordenadasOrigem['lat'], $coordenadasOrigem['lng'], 
                  $coordenadasDestino['lat'], $coordenadasDestino['lng'])) {
            return response()->json(['erro' => 'Coordenadas inválidas para cálculo'], 400);
        }

        $distanciaKm = $this->calcularDistanciaHaversine(
            $coordenadasOrigem['lat'],
            $coordenadasOrigem['lng'],
            $coordenadasDestino['lat'],
            $coordenadasDestino['lng']
        );

        // Cálculo do frete com arredondamento
        $valorFrete = round($distanciaKm * $valorKm, 2);

        return response()->json([
            'distancia_km' => round($distanciaKm, 2),
            'valor_frete' => number_format($valorFrete, 2, ',', '.'),
            'cep_origem' => $cepOrigem,
            'cep_destino' => $cepDestino,
            'valor_por_km' => $valorKm
        ], 200);

        } catch (\Exception $e) {
            return response()->json([
            'erro' => 'Ocorreu um erro ao calcular o frete',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }

    private function buscarCoordenadasPorCep($cep)
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        $response = Http::get("https://brasilapi.com.br/api/cep/v2/{$cepLimpo}");

        if ($response->ok()) {
            $data = $response->json();
            return [
                'lat' => $data['location']['coordinates']['latitude'] ?? null,
                'lng' => $data['location']['coordinates']['longitude'] ?? null,
            ];
        }

        return null;
    }

    private function calcularDistanciaHaversine($lat1, $lon1, $lat2, $lon2)
    {
        $raioTerra = 6371; // km

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 +
            cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;

        $c = 2 * asin(sqrt($a));
        return $raioTerra * $c;
    }
}
