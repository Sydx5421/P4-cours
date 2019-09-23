

<?php if ( isset($_POST['motDePasse']) && $_POST['motDePasse'] == "Bitch!"){ ?>
    <p>La caverne au merveilles !</p>
    <a href="formulaire.php">GO BACK !</a>
<?php }else{ ?>
    <p>désolé brah, mauvais MDP !</p>

    <a href="formulaire.php">GO BACK !</a>
<?php
}