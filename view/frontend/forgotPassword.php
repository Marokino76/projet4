<?php 
    $title = 'Billet Simple pour l\'Alaska - Mot de passe oublié'; 
    $description = 'Ce formulaire vous permet de retrouver votre mot de passe';
    $body = "body_Access";
    ob_start(); 
?>
<div class="flexboxForm">
    <form method="POST" action="index.php?action=sendPassword">
        <h1>Mot de passe oublié</h1>
        <div class="flexForm">
            <div class="formBox">
                <div class="labelBox">
                    <label>Votre Pseudo</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="pseudo" value="" required>
                </div>
            </div>
        </div>
        <div>
        <input class="boutons" type="submit" value="Envoyer">
        </div>
    </form>
</div>
<?php 
    $content = ob_get_clean(); 
    require('view/template.php'); 
?>
