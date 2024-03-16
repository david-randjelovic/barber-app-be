<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::with('user')
                            ->get(['reservation_date', 'service_name', 'price', 'user_id'])
                            ->map(function ($reservation) {
                                return [
                                    'date' => $reservation->reservation_date,
                                    'clientName' => $reservation->user->first_name,
                                    'serviceType' => $reservation->service_name,
                                    'price' => $reservation->price
                                ];
                            });

        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service.name' => 'required|string',
            'service.price' => 'required|integer',
            'reservation_date' => 'required|date',
        ]);

        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->service_name = $request->service['name'];
        $reservation->price = $request->service['price'];
        $reservation->reservation_date = $request->reservation_date;

        $reservation->save();

        $clientName = $reservation->user->first_name;

        $responseData = [
            'clientName' => $clientName,
            'date' => $reservation->reservation_date,
            'serviceType' => $reservation->service_name,
            'price' => $reservation->price,
        ];

        return response()->json($responseData, 201);
    }
}
