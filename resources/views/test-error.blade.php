<!-- resources/views/error-page.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8d7da; color: #721c24; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .error-box { background: #f5c6cb; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Error Terjadi!</h1>
        <p>{{ $message }}</p>
    </div>
</body>
</html>
