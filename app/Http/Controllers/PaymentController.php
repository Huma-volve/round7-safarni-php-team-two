<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

public function pay(PaymentRequest $request)
{
    $booking = Booking::findOrFail($request->booking_id);

    $response = $this->paymentService->createPayment(
        $booking,
        route('payment.success',  $booking->id),
        route('payment.cancel',  $booking->id)
    );
  


    // تحقق من وجود خطأ
    if (is_array($response) && isset($response['error'])) {
        return response()->json(['success' => false, 'message' => $response['error']], 500);
    }
 
    // الوصول للرابط
    foreach ($response->result->links as $link) {
        if ($link->rel === 'approve') {
            return response()->json([
                'success' => true,
                'redirect_url' => $link->href
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'PayPal redirect URL not found'
    ], 500);
}

 



}
