<html>
<head><title>Message Board</title></head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<body>



<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST['newpost']))
{
	$msg = $_POST['message'];
	$id = uniqid();
	$username= $_SESSION['postedby'];
	if($username!==NULL)
	{
    $sql=$dbh->prepare('INSERT INTO posts (id, postedby, datetime,message) VALUES (:id, :pb, now(),:msg)');
	$sql->execute(array(':id'=>$id,':pb'=>$username, ':msg'=>$msg));
    header("Location:board.php");
	}
	else
	{
		 header("Location:login.php");
	}
}
if(isset($_POST['replyto']))
{
	$msg = $_POST['message'];
	$replyTo=$_POST['replyto'];
	$mid = uniqid();
	$username= $_SESSION['postedby'];
	if($username!==NULL)
	{
    $sql=$dbh->prepare('INSERT INTO posts (id, replyto, postedby, datetime,message) VALUES (:id, :orid, :pb, now(),:msg)');
	$sql->execute(array(':id'=>$mid,':orid'=>$replyTo,':pb'=>$username, ':msg'=>$msg));
    header("Location:board.php");
	}
	else
	{
		 header("Location:login.php");
	}
	
}
?>
<form action="board.php" method="POST" >
Message: <input type="text" name="message" size="100" cols="30" rows="10"><br/>
<input type="submit" name="newpost"value="New Post">
<?php
echo "<table>";
echo "<tr><th>Message Id</th><th>Username</th><th>Full name</th><th>Date time</th><th>Original Message Id</th><th>Message</th></tr>";
$sql = 'SELECT id,replyto, postedby, datetime,message FROM posts ORDER BY datetime desc';
    foreach ($dbh->query($sql) as $row)
	{?>
	   <tr>
        <td><?php print $row['id'];?></td>
		<td><?php print $row['postedby'];?></td>
		<?php 
		$uname=$row['postedby'];
		$_SESSION['id1']=$row['id'];
		$sql1 = $dbh->prepare('SELECT fullname FROM users where username=:uname');
		
		$sql1->execute(array(':uname'=>$uname));
		$result = $sql1->fetch(PDO::FETCH_OBJ);?>
        <td><?php  print_r($result->fullname);?></td>
		<td><?php print $row['datetime'];?></td>
		<td>
		<?php 
		if($row['replyto']!==NULL)
		{
	    print $row['replyto'];
		}
		else 
		{
	     print "Original Message";
		}?>
		</td>
		<td><?php print $row['message'];?></td>
        <td>
		<button type="submit" name="replyto"  value="<?php print  $_SESSION['id1']?>" method="POST" formaction="board.php?replyto=<?php print  $_SESSION['id1']?>">Reply</button>
		</td>
<?php 
 }?>
 </form>
<?php echo "</tr>";		
echo "</table>"; 
?>
<form action="login.php" method="POST">
<input type="submit" value="Logout">
</form>

</body>
</html>
