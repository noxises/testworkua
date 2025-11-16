@php use Illuminate\Support\Str; @endphp
    <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>URL Shortener</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }

        input, button {
            padding: 8px;
            font-size: 16px;
        }

        .result {
            margin-top: 16px;
            padding: 12px;
            background: #f0f0f0;
        }
    </style>
</head>
<body>
<h1>URL Shortener</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('shorten') }}">
    @csrf
    <div>
        <label>Original URL</label><br>
        <input type="url" name="url" placeholder="https://example.com/..." style="width:100%" required>
    </div>

    <div style="margin-top:10px;">
        <label>TTL (minutes) — optional</label><br>
        <input type="number" name="expires_in" min="1" placeholder="e.g. 60">
    </div>

    <div style="margin-top:10px;">
        <button type="submit">Shorten</button>
    </div>
</form>

@if(session('short'))
    <div class="result">
        Your short link:
        <a href="{{ session('short') }}" target="_blank">{{ session('short') }}</a>
        <br>

        @php
            $code = Str::after(session('short'), url('/s/'));
        @endphp

        Stats:
        <a href="{{ url('/stats' . $code) }}">
            {{ url('/stats' . $code) }}
        </a>
    </div>
@endif

@if(isset($links) && $links->count())
    <h2 style="margin-top:30px;">Active links</h2>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Original URL</th>
            <th>Short URL</th>
            <th>Expires At</th>
            <th>Stats</th>
        </tr>
        </thead>
        <tbody>
        @foreach($links as $link)
            <tr>
                <td>{{ $link->id }}</td>
                <td><a href="{{ $link->original_url }}" target="_blank">{{ $link->original_url }}</a></td>
                <td><a href="{{ url('/s/' . $link->short_code) }}"
                       target="_blank">{{ url('/s/' . $link->short_code) }}</a></td>
                <td>{{ $link->expires_at ?? 'never' }}</td>
                <td><a href="{{ url('/stats/' . $link->short_code) }}">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

</body>
</html>
