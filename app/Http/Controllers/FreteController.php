<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuracao;

class FreteController extends Controller
{
    public function calcularFretePorDistancia($cepOrigem, $cepDestino)
    {
        $valorminimoPadrao = 8.00;
        $valorKmPadrao = 5.7;

        try {
            $configMinimo = Configuracao::where('nome', 'Valor do minimo para entrega')->first();
            $valorminimo = $valorminimoPadrao; // Fallback inicial

            if ($configMinimo && !empty($configMinimo->valores1)) {
                $valorMinimoStr = preg_replace('/[^0-9,.]/', '', $configMinimo->valores1);
                $valorminimo = (float) str_replace(',', '.', $valorMinimoStr);
                if ($valorminimo <= 0) $valorminimo = $valorminimoPadrao;
            }

            // Busca o valor por km
            $configKm = Configuracao::where('nome', 'Valor por km para entrega')->first();
            $valorKm = $valorKmPadrao; // Fallback inicial

            if ($configKm && !empty($configKm->valores1)) {
                $valorKmStr = preg_replace('/[^0-9,.]/', '', $configKm->valores1);
                $valorKm = (float) str_replace(',', '.', $valorKmStr);
                if ($valorKm <= 0) $valorKm = $valorKmPadrao;
            }
        } catch (\Exception $e) {
            $valorminimo = $valorminimoPadrao;
            $valorKm = $valorKmPadrao;
        }

        $distancia = $this->calcularFretePorCep($cepOrigem, $cepDestino) ?? 0;
        $valorvariado = $distancia * $valorKm;

        $valortotal = $valorminimo + $valorvariado;

        return $valortotal;
    }

    public function calcularFretePorCep($cepOrigem, $cepDestino)
    {
        // 1. Obter coordenadas do restaurante (CEP origem)
        $coordenadasOrigem = $this->obterCoordenadas($cepOrigem);
        if (!$coordenadasOrigem) return null;

        // 2. Obter coordenadas do cliente (CEP destino)
        $coordenadasDestino = $this->obterCoordenadas($cepDestino);
        if (!$coordenadasDestino) return null;

        // 3. Calcular distância em km
        return $this->calcularDistanciaEmKm(
            $coordenadasOrigem['lat'],
            $coordenadasOrigem['lon'],
            $coordenadasDestino['lat'],
            $coordenadasDestino['lon']
        );
    }

    private function obterCoordenadas($cep)
    {
        $cep = substr(preg_replace('/[^0-9]/', '', $cep), 0, 8);
        if (strlen($cep) !== 8) {
            return null;
        }

        static $cache = [];
        if (isset($cache[$cep])) {
            return $cache[$cep];
        }

        $cacheFile = sys_get_temp_dir() . '/cep_' . $cep . '.cache';
        if (file_exists($cacheFile)) {
            return $cache[$cep] = json_decode(file_get_contents($cacheFile), true);
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'header' => "User-Agent: SeuAppNome/1.0 (seuemail@dominio.com)\r\n"
            ]
        ]);

        // Tentativa 1: BrasilAPI
        $response = @file_get_contents("https://brasilapi.com.br/api/cep/v2/{$cep}", false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);
            if (!empty($data['location']['coordinates'])) {
                $coords = [
                    'lat' => (float)$data['location']['coordinates']['latitude'],
                    'lon' => (float)$data['location']['coordinates']['longitude'],
                ];
                file_put_contents($cacheFile, json_encode($coords));
                return $cache[$cep] = $coords;
            }
        }

        // Tentativa 2: Nominatim (OpenStreetMap)
        // Para chamar Nominatim, primeiro pega o endereço pelo ViaCEP
        $viaCepResponse = @file_get_contents("https://viacep.com.br/ws/{$cep}/json/", false, $context);
        if ($viaCepResponse !== false) {
            $endereco = json_decode($viaCepResponse, true);
            if (!empty($endereco) && !isset($endereco['erro'])) {
                $query = urlencode("{$endereco['logradouro']}, {$endereco['localidade']}, {$endereco['uf']}, Brasil");
                $nominatimUrl = "https://nominatim.openstreetmap.org/search?q={$query}&format=json&limit=1";

                $nominatimResponse = @file_get_contents($nominatimUrl, false, $context);
                if ($nominatimResponse !== false) {
                    $nominatimData = json_decode($nominatimResponse, true);
                    if (!empty($nominatimData) && isset($nominatimData[0]['lat']) && isset($nominatimData[0]['lon'])) {
                        $coords = [
                            'lat' => (float)$nominatimData[0]['lat'],
                            'lon' => (float)$nominatimData[0]['lon'],
                        ];
                        file_put_contents($cacheFile, json_encode($coords));
                        return $cache[$cep] = $coords;
                    }
                }
            }
        }

        // Se tudo falhar, retorna null
        return null;
    }

    private function calcularDistanciaEmKm($lat1, $lon1, $lat2, $lon2)
    {
        $raioTerra = 6371; // Raio da Terra em km

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($raioTerra * $c, 2); // Distância em km com 2 casas decimais
    }
}
