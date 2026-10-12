<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/index.css'])
</head>
<body>

<section>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h1>Inscription</h1>

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="error-box" style="color:#e74c3c; margin-bottom:10px; font-size:14px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="input-box">
            <input type="text" name="name" id="name" placeholder="Votre nom"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="input-box">
            <input type="email" name="email" id="email" placeholder="hello@gmail.com"
                   value="{{ old('email') }}" required autocomplete="username">
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" id="password" placeholder="Votre mot de passe"
                   required autocomplete="new-password">
            <i class="fa-solid fa-lock"></i>
        </div>

        <div class="input-box">
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Confirmez le mot de passe" required autocomplete="new-password">
            <i class="fa-solid fa-lock"></i>
        </div>

        <button type="submit" class="login-btn">S'inscrire</button>

        <div class="register-link">
            <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
        </div>
    </form>
</section>

</body>
</html>