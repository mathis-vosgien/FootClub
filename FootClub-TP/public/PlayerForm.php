<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootClub</title>
</head>
<body>
    <section>

    <h1>
        Formulaire d'ajout de joueur
    </h1>
        <form action="player_form.php" method="POST">
            <label>Prénom :</label>
            <input type="text" name="firstname" required><br>

            <label>Nom :</label>
            <input type="text" name="lastname" required><br>

            <label>Date de naissance :</label>
            <input type="date" name="birthdate" required><br>

            <label>Photo :</label>
            <input type="text" name="photo"><br>

            <button type="submit">Enregistrer</button>
        </form>
    </section>
</body>
</html>