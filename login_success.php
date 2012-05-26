<? 
session_start();
if(!session_is_registered("username")){
	header("location:login.php");
}else {
	header("location:index.php");
}
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<html>
<body>
Login Successful
</body>
</html>