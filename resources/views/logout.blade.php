<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
</head>
<body>

<script>
    // Submit form logout secara otomatis
    document.getElementById('logout-form').submit();
</script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

</body>
</html>
