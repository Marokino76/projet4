<?php
// Chargement des classes
require_once('model/CommentManager.php');
require_once('model/AdminManager.php');
require_once('model/PostManager.php');

                               
function dataAdmin($pageCourante) // Fonction qui récupère la liste des billets page par page

{
    if(isset($_SESSION['pseudo'])){

        $postManagerAdmin = new \Model\PostManager();

        $postsAdmin = $postManagerAdmin->getPostAdmin();

        $postsParPage = 5;

        $postsTotaleReq = $postsAdmin;

        $postsTotales = $postsTotaleReq->rowCount(); // On compte le nombre de posts

        $pagesTotales = ceil($postsTotales/$postsParPage); // On divise le nombre de post par le nombre de post par page, pour avoir le nombre de page totale
    
        $depart = ($pageCourante-1)*$postsParPage; // On fixe un point de départ, qui correspond à la page actuel x le nombre de page.
        
        $postManagerAdmin2 = new \Model\PostManager();

        $postsAdminPage = $postManagerAdmin2->getPostsPage($depart,$postsParPage); // On récupère les posts page par page

        require('view/backend/admin.php');
    }
    else{
        require('view/frontend/forbidden.php');
    }
}

function adminCommentReport($pageCouranteComments) {

    if(isset($_SESSION['pseudo'])){

        $commentReport = new \Model\CommentManager();

        $commentsReporting = $commentReport->getCommentsReport();


        $commentsParPage = 3;

        $commentsTotaleReq = $commentsReporting;

        $commentsTotales = $commentsTotaleReq->rowCount();  // On compte le nombre de posts


        $pagesTotalesComments = ceil($commentsTotales/$commentsParPage); // On divise le nombre de commentaires par le nombre de commentaires par page, pour avoir le nombre de page totale

    

        $departComments = ($pageCouranteComments-1)*$commentsParPage; // On fixe un point de départ, qui correspond à la page actuel x le nombre de commentaires.

        $commentsByPage = new \Model\CommentManager();

        $getCommentsByPage = $commentsByPage->getCommentsReportByPage($departComments,$commentsParPage); // On récupère les commentaires page par page


        require('view/backend/commentAdmin.php');
    }
    else{
        require('view/frontend/forbidden.php');
    }


}

function updatePost() // Fonction qui récupère le billet à modifier (afin de l'insérer dans un formulaire pour le modifier)
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $postUpdate = new \Model\PostManager();

        $postUp = $postUpdate->getPost($_GET['id']);

        require('view/backend/updateNews.php');
    }
    else{
        require('view/frontend/error.php');
    }
}

function confirmUpdatePost($idUpdate, $titleUpdate, $contentUpdate) // Fonction qui modifie le billet
{
    if(isset($_POST['id']) && $_POST["id"] > 0 && !empty($_POST['titleUpdate']) && !empty($_POST['contentUpdate'])) {

        $confirmPostUpdate = new \Model\PostManager();

        $confirmUp = $confirmPostUpdate->updatePostDB($idUpdate, $titleUpdate, $contentUpdate);


        if ($confirmUp === false) {
            require('view/frontend/error.php');
        }
        else {
            
            header('Location: index.php?action=admin&update'); 

        }
    }
    else{
        require('view/frontend/error.php');
    }
}

function addPost($title, $content) // Fonction qui permet d'ajouter un billet
{
    if (!empty($_POST['title']) && !empty($_POST['content'])) { 

        $newPost = new \Model\PostManager();

        $addedPost = $newPost->addPost($title, $content);

        if ($addedPost === false) {
            require('view/frontend/error.php');
        }
        else {
            header('Location: index.php?action=admin&add'); 
        }
    }
    else{
        require('view/frontend/error.php');
    }
}   

function deletePost() // Fonction qui permet de supprimer un billet
{
    if(isset($_GET['id']) && $_GET['id'] > 0) { 

        $postManagerDeletePosts = new \Model\PostManager();

        $deletePost = $postManagerDeletePosts->deletePost($_GET['id']);

        if ($deletePost === false) {
            require('view/frontend/error.php');
        }
        else {
            header('Location: index.php?action=admin&delete'); 
        }
    }
    else{
        require('view/frontend/error.php');
    }

}

function allowComment($idComment) // Fonction qui autorise un commentaire signalé
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {

        $allow = new \Model\CommentManager();

        $allowingComment = $allow->allowCommentDB($idComment);

        if ($allowingComment === false) {
            require('view/frontend/error.php');
        }
        else {
            header('Location: index.php?action=adminreport&allow');
        }
    }
    else{
        require('view/frontend/error.php');
    }
}

function deleteComment($id) // Fonction qui permet de supprimer un commentaire signalé
{
    if(isset($_GET['id']) && $_GET['id'] > 0) {

        $deleteComment = new \Model\CommentManager();

        $confirmDeleteComment = $deleteComment->deleteComment($id);

        if ($confirmDeleteComment === false) {
            require('view/frontend/error.php');
        }
        else {
            header('Location: index.php?action=adminreport&deleteComment'); 
        }
    }
    else{
        require('view/frontend/error.php');
    }
}

function deleteCommentAdmin($id,$postid) // Fonction qui permet de supprimer un commentaire signalé
{
    if(isset($_GET['id']) && $_GET['id'] > 0  && isset($_GET['postid']) && $_GET['postid'] > 0) {

        $deleteComment = new \Model\CommentManager();

        $confirmDeleteComment = $deleteComment->deleteComment($id);

        if ($confirmDeleteComment === false) {
            require('view/frontend/error.php');
        }
        else {
            header('Location: index.php?action=post&deleteAdminok&id=' . $postid);
        }
    }
    else{
        require('view/frontend/error.php');
    }
}

function disconnect () { // Fonction qui permet la deconnexion de l'admin

    session_unset();
    session_destroy();
    listPostsHome();
}
