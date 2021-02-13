<?php 
    // pour la page maître
    ob_start();     
    $titre_page = "Connexion";
    require_once "core_BO.php";
    if(!isset($_SESSION)) 
    {
        session_start();
    } 
    $error ="";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form
        
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];
        
        $sql = $bdd->prepare('SELECT id, mdp, pseudo FROM compte WHERE pseudo = "'.$pseudo.'"');
        $sql->execute();
    
        $count = 0;

        $result = $sql->fetch(\PDO::FETCH_ASSOC);
        $count ++;
        $pseudo_bdd = $result['pseudo'];
        $mpd_bdd = $result['mdp'];
        
        // if result matched $myusername and $mypassword, table row must be 1 row
        // if($count == 1 && password_verify($mypassword, password_hash($_POST['mdp'], PASSWORD_BCRYPT))) {
        if($count == 1 && ($mdp == $mpd_bdd)) {
            $_SESSION['myusername']="myusername";
            $_SESSION['login_user'] = $pseudo_bdd;
            header("location: page_liste");
        }
        else {
            $error = "Your Login Name or Password is invalid";
        }
   }
?>
<div class="wrapper fadeInDown">
  <div id="formContent" class="bg-dark">
    <!-- Login Form -->
    <form action="login.php" method = "post">
      <input type="text" id="login" class="fadeIn second" name="pseudo" placeholder="Login">
      <input type="password" id="password" class="fadeIn third" name="mdp" placeholder="Password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>
    <!-- Footer -->
    <div id="formFooter" class="text-danger bg-dark">
        <div><?php echo $error; ?></div>
    </div>
  </div>
</div>
</body>
</html>