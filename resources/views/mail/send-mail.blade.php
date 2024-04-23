<!DOCTYPE html>
<html>

<head>
    <title>Verification Email Link</title>
</head>

<body>
    <h3>Hello. {{ $data['name'] }}</h3>
    <p>
        {{ $data['text'] }}<a href="{{ $data['url'] }}"> link verification</a>
    </p>

    <p>Terimakasih</p>
</body>

</html>
