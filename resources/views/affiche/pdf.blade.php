<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page { size: A4 landscape; margin: 0; }
        html, body { margin: 0; padding: 0; }
    </style>
</head>
<body>
    @include('affiche.canvas', ['affiche' => $affiche, 'embedFonts' => true])
</body>
</html>
