<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de Vérification</title>
</head>
<body>
    <p>Bonjour {{ $user->identifiant }},</p>
    <p>Nous avons reçu une demande d'accès à votre compte avec l'adresse email {{ $user->email }}. Votre code de vérification est :</p>
    <h2>{{ $code }}</h2>
    <p>Si vous n'avez pas demandé ce code, il est possible que quelqu'un essaie d'accéder à votre compte. Ne partagez pas ce code avec qui que ce soit.</p>
    <p>Bien à vous,</p>
    <p>L'équipe de support</p>
</body>
</html>
