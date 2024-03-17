<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function activeReservations()
    {
        $now = now();
        $reservations = Reservation::with('user')
            ->where('reservation_date', '>', $now)
            ->get()
            ->map($this->mapReservation());

        return response()->json($reservations);
    }

    public function archivedReservations()
    {
        $now = now();
        $reservations = Reservation::with('user')
            ->where('reservation_date', '<=', $now)
            ->get()
            ->map($this->mapReservation());

        return response()->json($reservations);
    }

    public function reservationsForToday()
    {
        $now = now();
        $todayEnd = now()->endOfDay();

        $reservations = Reservation::with('user')
                            ->whereBetween('reservation_date', [$now, $todayEnd])
                            ->get()
                            ->map($this->mapReservation());

        return response()->json($reservations);
    }

    public function getReservationsForDate($date)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $reservations = Reservation::with('user')
                            ->whereDate('reservation_date', '=', $date)
                            ->get()
                            ->map($this->mapReservation());

        return response()->json($reservations);
    }

    protected function mapReservation()
    {
        return function ($reservation) {
            return [
                'date' => $reservation->reservation_date,
                'clientName' => $reservation->user->first_name ?? '',
                'serviceType' => $reservation->service_name,
                'price' => $reservation->price,
            ];
        };
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
