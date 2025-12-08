<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->isProduction = config('services.midtrans.is_production');
        $this->baseUrl = $this->isProduction
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';
    }

    public function createTransaction($booking)
    {
        $payload = [
            'transaction_details' => [
                'order_id' => $booking->booking_code,
                'gross_amount' => (int) $booking->total_price,
            ],
            'item_details' => [
                [
                    'id' => $booking->showtime->movie->id,
                    'price' => (int) $booking->showtime->price,
                    'quantity' => count(explode(',', $booking->seats)),
                    'name' => $booking->showtime->movie->title,
                ]
            ],
            'customer_details' => [
                'first_name' => $booking->user->full_name ?? $booking->user->username,
                'email' => $booking->user->email,
                'phone' => $booking->user->phone ?? '',
            ],
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
        ])->post($this->baseUrl . '/snap/v1/transactions', $payload);

        if ($response->successful() && isset($response['token'])) {
            return $response['token'];
        }

        Log::error('Midtrans Error: ' . $response->body());
        throw new \Exception('Failed to create Midtrans transaction');
    }

    public function handleNotification($request)
    {
        $notification = $request->all();

        // Verify signature key
        $orderId = $notification['order_id'];
        $statusCode = $notification['status_code'];
        $grossAmount = $notification['gross_amount'];
        $signatureKey = $notification['signature_key'];

        $mySignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        if ($signatureKey !== $mySignatureKey) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $booking = Booking::where('booking_code', $orderId)->first();

        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        if ($booking->status === 'pending') {
            $transactionStatus = $notification['transaction_status'];

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                // Payment success
                $booking->update(['status' => 'confirmed']);

                // Update available seats
                $seatsCount = count(explode(',', $booking->seats));
                $booking->showtime->decrement('available_seats', $seatsCount);

            } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
                // Payment failed
                $booking->update(['status' => 'cancelled']);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
