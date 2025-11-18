<!DOCTYPE html>
<html>
<head>
    <title>كود التحقق - OTP</title>
</head>
<body style="font-family: Arial, sans-serif; direction: rtl;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd;">


        <div style="text-align: center; background: #f8f9fa; padding: 20px;">
            <h1 style="color: #333;">كود التحقق</h1>
        </div>

        <div style="padding: 30px 20px;">
            <p style="font-size: 16px; color: #555;">مرحباً <strong>{{ $user->name }}</strong>,</p>

            <p style="font-size: 16px; color: #555;">استخدم كود التحقق التالي لإكمال عملية التسجيل:</p>


            <div style="text-align: center; margin: 30px 0;">
                <div style="background: #f1f1f1; padding: 15px; display: inline-block; border-radius: 8px;">
                    <h2 style="margin: 0; color: #333; letter-spacing: 5px;">{{ $otp }}</h2>
                </div>
            </div>


        </div>

        <div style="text-align: center; padding: 20px; background: #f8f9fa; font-size: 12px; color: #666;">
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>

    </div>

</body>
</html>
