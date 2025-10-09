<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <title><Adminlogin class="php"></Adminlogin></title>
</head>

<?php
session_start();

// Godkjente brukere
$allowed = [
    'sebastiata@uia.no',
    'robinfo@uia.no',
    'kristineho@uia.no'
];

// Logg ut hvis ?logout i adressen
if (isset($_GET['logout'])) 
{
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$error = "";

// Sjekk innlogging
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $email = strtolower(trim($_POST['email'] ?? ''));

    if (in_array($email, $allowed, true)) 
    {
        $_SESSION['admin_email'] = $email;
    } 
    else 
    {
        $error = "Innlogging feilet: e-posten er ikke godkjent.";
    }
}

$logged_in = isset($_SESSION['admin_email']);
?>
<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <title>Admininnlogging</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- EGEN STIL -->
    <style>
        body 
        {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f8f8f8;
        }

        header, footer 
        {
            background-color: #a91f1f; /* UIA-rød */
            color: white;
            padding: 15px 20px;
        }

        header h2 
        {
            display: inline-block;
            margin: 0;
        }

        .logout 
        {
            float: right;
            background-color: white;
            color: #a91f1f;
            border: 1px solid #a91f1f;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .logout:hover 
        {
            background-color: #a91f1f;
            color: white;
        }

        .container 
        {
            max-width: 700px;
            margin: 80px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1, h2, h3 
        {
            color: #a91f1f;
            margin-top: 0;
        }

        label 
        {
            font-weight: bold;
        }

        input 
        {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button 
        {
            background-color: #a91f1f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover 
        {
            background-color: #8c1a1a;
        }

        .error 
        {
            background: #ffd8d8;
            border: 1px solid #a91f1f;
            padding: 10px;
            color: #a91f1f;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        footer 
        {
            text-align: center;
            margin-top: 50px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <header>
        <h2>Adminområde</h2>

        <?php if ($logged_in): ?>
            <a href="?logout">
                <button class="logout">Logg ut</button>
            </a>
        <?php endif; ?>
    </header>

    <?php if (!$logged_in): ?>

        <!-- INNLOGGINGSSKJEMA -->
        <div class="container">
            <h3>Innlogging</h3>

            <?php if ($error): ?>
                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <label for="email">E-post</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="navn@uia.no" 
                    required
                >

                <label for="password">Passord (valgfritt)</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••"
                >

                <button type="submit">Logg inn</button>
            </form>
        </div>

    <?php else: ?>

        <!-- ADMINPANEL -->
        <div class="container">
            <h3>
                Velkommen, 
                <?php echo htmlspecialchars($_SESSION['admin_email']); ?>
            </h3>

            <p>Du er nå innlogget som administrator.</p>

            <hr>

            <p>Her kan du etter hvert legge til eller endre stillingsannonser.</p>

            <button disabled>Legg til stilling (kommer snart)</button>
        </div>

    <?php endif; ?>

    <footer>
        <p>Universitetet i Agder &copy; <?php echo date("Y"); ?></p>
    </footer>

</body>
</html>
