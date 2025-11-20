<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
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

public function success(Request $request,Booking $booking)
{
    $token = $request->query('token'); // important!

    if (!$token) {
        return response()->json([
            'success' => false,
            'message' => 'Missing PayPal token.'
        ], 400);
    }

    $paymentService = app(PaymentService::class);
    $response = $paymentService->capturePayment($token);

    if (is_array($response) && isset($response['error'])) {
        return response()->json([
            'success' => false,
            'message' => 'Capture failed: '.$response['error'],
        ], 500);
    }

    // استخراج بيانات الدفع من PayPal response
    $transactionId = $response->result->id ?? null;
    $status = $response->result->status ?? null;
    $amount = $response->result->purchase_units[0]->payments->captures[0]->amount->value ?? 0;
    $currency = $response->result->purchase_units[0]->payments->captures[0]->amount->currency_code ?? 'USD';

    // ⬅️ حفظ الدفع في جدول payments
    Payment::create([
        'booking_id'     => $booking->id,
        'amount'         => $amount,
        'currency'       => $currency,
        'gateway'        => 'paypal',
        'status'         => $status,
        'transaction_id' => $transactionId,
        'response_json'  => json_encode($response->result),
    ]);

    // ⬅️ تحديث حالة الحجز
    $booking->update([
        'payment_status' => 'paid',
        'status'         => 'confirmed'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Payment captured and saved successfully!',
        'transaction_id' => $transactionId,
    ]);
}
public function cancel(Request $request)
{

}



}
