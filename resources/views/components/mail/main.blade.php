<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $emailTitle }} - {{ config('app.name') }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <x-mail.header>
            <x-slot:headerMessage>
                {{ $headerMessage }}
            </x-slot:headerMessage>
        </x-mail.header>
        {{ $content }}
        <x-mail.footer></x-mail.footer>
    </div>
</body>

</html>
