<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UtilsController extends Controller
{
    public function cotizacion(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'precio' => 'required|numeric|min:1',
            'pago_inicial' => 'required|numeric|min:0',
            'meses' => 'required|integer|in:12,24,36,48',
            'edad' => 'required|integer|min:18'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 400);
        }

        $precio = $data['precio'];
        $pagoInicial = $data['pago_inicial'];
        $meses = $data['meses'];
        $edad = $data['edad'];

        // 1️⃣ Monto a financiar
        $montoFinanciado = max($precio - $pagoInicial, 0);

        // 2️⃣ Factor por plazo
        $factoresPlazo = [
            12 => 1.05,
            24 => 1.10,
            36 => 1.15,
            48 => 1.20,
        ];

        $montoAjustado = $montoFinanciado * $factoresPlazo[$meses];

        // 3️⃣ Penalización por edad
        if ($edad < 30) {
            $montoAjustado *= 1.10; // +10%
        }

        // 4️⃣ Pago mensual
        $pagoMensual = $montoAjustado / $meses;

        return response()->json([
            'message' => 'Cotización calculada correctamente',
            'pago_mensual' => round($pagoMensual, 2),
            'detalle' => [
                'precio' => $precio,
                'pago_inicial' => $pagoInicial,
                'meses' => $meses,
                'edad' => $edad,
                'monto_financiado' => round($montoFinanciado, 2),
            ]
        ], 200);
    }
}