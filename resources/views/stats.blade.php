<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stats - {{ $url->short_code }}</title>
    <style>body{font-family:Arial;padding:30px;max-width:900px;margin:auto;}table{width:100%;border-collapse:collapse}td,th{padding:8px;border:1px solid #ddd}</style>
</head>
<body>
    <h1>Statistics for {{ url('/s/' . $url->short_code) }}</h1>
    <p>Original URL: <a href="{{ $url->original_url }}">{{ $url->original_url }}</a></p>
    <p>Created at: {{ $url->created_at }}</p>
    <p>Expires at: {{ $url->expires_at ?? 'never' }}</p>
    <p>Total clicks: {{ $stats->count() }}</p>

    <table>
        <thead>
            <tr><th>Date</th><th>IP</th><th>User Agent</th></tr>
        </thead>
        <tbody>
            @foreach($stats as $s)
            <tr>
                <td>{{ $s->created_at }}</td>
                <td>{{ $s->ip_address }}</td>
                <td>{{ $s->user_agent }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
