<?php session_start(); 
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
	?>
<html>
<head><title>Login Page</title></head>
<body>
<form action="login.php" method="POST">
Username: <input type="text" name="username"><br/>
Password: <input type="password" name="password"><br/>
<input type="submit" value="Submit">
</form>
<?php 
if(isset($_POST['username']))
{
	$username = $_POST['username'];
	$pwd = $_POST['password'];
	$hash =MD5($pwd);
	$_SESSION['postedby']=$username;
    $sql=$dbh->prepare('select * from users WHERE username= :username AND password= :hash');
	$sql->execute(array(':username'=>$username, ':hash'=>$hash));
	$result =  $sql->fetch(PDO::FETCH_ASSOC);
    if( $sql->rowCount() > 0)
	{
      header("Location:board.php");
	}
	else
	{
       session_regenerate_id (true ); // to avoid session fixation attacks
      header("Location:login.php"); // redirect
       exit ();	
	}
}
?>
</body>
</html>
