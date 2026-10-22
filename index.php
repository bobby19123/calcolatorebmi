<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatore BMI</title>
    
    <!-- CSS INCORPORATO PER FUNZIONAMENTO AUTONOMO -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #F1F3F5;
            color: #1F2328;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }

        /* Container del Form */
        .container {
            background-color: #ffffff;
            width: 360px;
            max-width: 100%;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #D0D7DE;
            border-radius: 8px;
            font-size: 16px;
            color: #1F2328;
            outline: none;
        }

        .form-group input:focus {
            border-color: #1F2328;
        }

        .btn {
            width: 100%;
            background-color: #1F2328;
            color: #ffffff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Card del Risultato */
        .card {
            width: 360px;
            max-width: 100%;
            padding: 24px;
            border-radius: 12px;
            border-width: 3px;
            border-style: solid;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card .user-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card .user-details {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .card .bmi-score {
            font-size: 48px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 12px;
        }

        .card .bmi-category {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Le 4 classi cromatiche della card */
        .card.sottopeso {
            background-color: #E3EEF9;
            border-color: #2F6FB3;
        }
        .card.sottopeso .bmi-category {
            color: #2F6FB3;
        }

        .card.normopeso {
            background-color: #E3F4E6;
            border-color: #256D34;
        }
        .card.normopeso .bmi-category {
            color: #256D34;
        }

        .card.sovrappeso {
            background-color: #FCEBD7;
            border-color: #9A4F06;
        }
        .card.sovrappeso .bmi-category {
            color: #9A4F06;
        }

        .card.obesita {
            background-color: #FBE2E2;
            border-color: #B32D2D;
        }
        .card.obesita .bmi-category {
            color: #B32D2D;
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: #1F2328;
            text-decoration: underline;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Qui l'utente deve vedere solo il form
?>

    <h1>Calcolatore BMI</h1>

    <div class="container">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Luca" required>
            </div>

            <div class="form-group">
                <label for="peso">Peso (kg)</label>
                <input type="number" id="peso" name="peso" step="any" min="1" placeholder="70" required>
            </div>

            <div class="form-group">
                <label for="altezza">Altezza (cm)</label>
                <input type="number" id="altezza" name="altezza" step="any" min="1" placeholder="178" required>
            </div>

            <button type="submit" class="btn">Calcola</button>
        </form>
    </div>

<?php
} else {
    // Qui dobbiamo far vedere i risultati del calcolo (richiesta POST)
    $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $peso = floatval($_POST['peso'] ?? 0);
    $altezza_cm = floatval($_POST['altezza'] ?? 0);

    if ($nome !== "" && $peso > 0 && $altezza_cm > 0) {
        // Conversione altezza da cm a metri e calcolo BMI
        $altezza_m = $altezza_cm / 100;
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formattato = number_format($bmi, 2, '.', '');

        // Determinazione fascia e classe CSS
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
?>

        <h1>Il tuo BMI</h1>

        <div class="card <?php echo $classe_fascia; ?>">
            <div class="user-name"><?php echo $nome; ?></div>
            <div class="user-details">Peso <?php echo $peso; ?> kg · Altezza <?php echo $altezza_cm; ?> cm</div>
            <div class="bmi-score"><?php echo $bmi_formattato; ?></div>
            <div class="bmi-category"><?php echo $testo_fascia; ?></div>
        </div>

        <a href="index.php" class="back-link">Calcola di nuovo</a>

<?php
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

</body>
</html>