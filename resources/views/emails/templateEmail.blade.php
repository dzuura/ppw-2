<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['subject'] }}</title>
</head>

<body>
    <h3 style="color: #2c3e50;">Halo, {{ $data['name'] }}!</h3>
    <h4 style="color: #34495e;">Terima kasih telah bergabung dengan kami.</h4>

    <p style="font-size: 16px; line-height: 1.5;">
        Kami sangat senang menerima email Anda: <strong>{{ $data['email'] }}</strong>.
    </p>

    <p style="font-size: 16px; line-height: 1.5;">
        Anda mendaftar pada: <strong>{{ $data['created_at'] }}</strong>.
    </p>

    <p style="font-size: 16px; line-height: 1.5;">
        Terima kasih telah mempercayai kami.
    </p>
</body>
</html>
