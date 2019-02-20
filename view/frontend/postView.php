<?php 
$title = html_entity_decode($post['title']); 
$meta = "Billet simple pour l'Alaska";
$body = "body_post";
ob_start(); 
?>

<div id="post_wrapper">

    <?php 
    if(isset($_GET['add'])) {
        echo "<div class='message'>" . "Merci pour votre commentaire " . $_GET['add'] . " !" . "</div>";
    }
    else if(isset($_GET['report'])) {
        echo "<div class='message'>" . "Merci pour votre signalement, on s'en occupe !" . "</div>";
    }
    ?>
    <article id="billet" class=" post container">
        <div class="row">
            <div class=col-lg-12">
            <h1><?= $post['title'] ?></h1>
            <em>Publié le <?= $post['creation_date_fr'] ?></em>
            </div>
        </div>
        <div id="contenu" class="row">
            <div class="col-lg-12">
            <?= html_entity_decode($post['content']) ?>
            </div>
        </div>
    </article>

    <?php
    while ($comment = $comments->fetch())
    {
    ?>
    <div  class=" post container">
        <div class="row">
            <div class=col-lg-12">
                <p><strong><?= $comment['author'] ?></strong> 
                <p>Publié le <?= $comment['comment_date_fr'] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p><?= nl2br($comment['comment']) ?></p>
                <a class="boutons" id="bouton_Signalement" href="index.php?action=report&amp;id=<?= $comment['id'] ?>&amp;postid=<?= $comment['post_id'] ?>"><i class="far fa-flag"></i> Signaler</a>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <form method="POST" action="index.php?action=addComment&amp;id=<?= $post['id'] ?>">
        <label for="author">Auteur</label><br>
        <input type="text" name="author" required><br>
        <label for="comment">Contenu</label><br>
        <textarea type="text"  name="comment"></textarea><br>
        <input type="submit" class="boutons" value="Envoyer">
    </form>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>