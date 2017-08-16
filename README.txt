<!-- This is a READ ME FILE,you can save the file as insert.php and run it in the browser in order to insert the values into users table or you can directly and cut and paste the insert statetements in  phpMyAdmin console-->

<html>
<head><title>Message Board</title></head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $dbh->beginTransaction();
  $dbh->exec('insert into users values("john","' . md5("john123") . '","John kennedy","john@cse.uta.edu")')
        or die(print_r($dbh->errorInfo(), true));
  $dbh->exec('insert into users values("sravani","' . md5("sravani556") . '","Sravani Machineni","sravani@gmail.com")')
        or die(print_r($dbh->errorInfo(), true));
   $dbh->exec('insert into users values("smith","' . md5("mypass") . '","John Smith","smith@cse.uta.edu")')
        or die(print_r($dbh->errorInfo(), true));
  $dbh->commit();

  
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
</body>
</html>