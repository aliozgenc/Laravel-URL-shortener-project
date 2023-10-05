<html>

<h1>URL Shortener</h1>
<form method="post" action="/shorten">
    @csrf
    <input type="text" name="url" placeholder="Enter URL">
    <button type="submit">Shorten</button>
</form>

<h2>Latest Shortened URLs</h2>
<ul>
    @foreach ($latestUrls as $urlMapping)
        <li>
            <a href="{{ url($urlMapping->short_url) }}">{{ $urlMapping->short_url }}</a>
            &rarr;
            <a href="{{ $urlMapping->original_url }}" target="_blank">{{ $urlMapping->original_url }}</a>
        </li>
    @endforeach
</ul>

</html>