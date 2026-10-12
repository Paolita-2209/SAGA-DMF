<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/index.css'])
</head>
<body>

<section>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h1>Connexion</h1>

        {{-- Message de statut (ex. mot de passe réinitialisé) --}}
        @if (session('status'))
            <div style="color:#27ae60; margin-bottom:10px; font-size:14px;">
                {{ session('status') }}
            </div>
        @endif

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div style="color:#e74c3c; margin-bottom:10px; font-size:14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="input-box">
            <input type="email" name="email" id="email" placeholder="hello@gmail.com"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" id="password"
                   placeholder="Votre mot de passe" required autocomplete="current-password">
            <i class="fa-solid fa-lock"></i>
        </div>

        <div class="remenber-forgot">
            <label>
                <input type="checkbox" name="remember"> Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Mot de passe oublié</a>
            @endif
        </div>

        <button type="submit" class="login-btn">Se connecter</button>

        <div class="register-link">
            <p>Pas de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
        </div>
    </form>
</section>

</body>
</html>