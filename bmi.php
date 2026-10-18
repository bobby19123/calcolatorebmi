<?php
// Gestione della richiesta POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $peso = filter_var($_POST['peso'] ?? 0, FILTER_VALIDATE_FLOAT);
    $altezza_cm = filter_var($_POST['altezza'] ?? 0, FILTER_VALIDATE_FLOAT);

    if ($nome && $peso > 0 && $altezza_cm > 0) {
        // Conversione altezza da cm a metri
        $altezza_m = $altezza_cm / 100;

        // Calcolo del BMI: peso / (altezza in metri)^2
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formattato = number_format($bmi, 2, '.', '');

        // Determinazione della fascia e della classe CSS corrispondente
        if ($bmi < 18.5) {
            $classe_fascia = "sottopeso";
            $testo_fascia = "SOTTOPESO";
        } elseif ($bmi <= 24.9) {
            $classe_fascia = "normopeso";
            $testo_fascia = "NORMOPESO";
        } elseif ($bmi <= 29.9) {
            $classe_fascia = "sovrappeso";
            $testo_fascia = "SOVRAPPESO";
        } else {
            $classe_fascia = "obesita";
            $testo_fascia = "OBESITÀ";
        }
    } else {
        header("Location: form.html");
        exit;
    }
} else {
    header("Location: form.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo BMI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Il tuo BMI</h1>

    <!-- Card dinamica con due classi: 'card' + classe della fascia -->
    <div class="card <?php echo $classe_fascia; ?>">
        <div class="user-name"><?php echo $nome; ?></div>
        <div class="user-details">Peso <?php echo $peso; ?> kg · Altezza <?php echo $altezza_cm; ?> cm</div>
        <div class="bmi-score"><?php echo $bmi_formattato; ?></div>
        <div class="bmi-category"><?php echo $testo_fascia; ?></div>
    </div>

    <a href="form.html" class="back-link">Calcola di nuovo</a>

</body>
</html>