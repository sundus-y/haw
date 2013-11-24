<html>
	<head>
		<title>DtoE.com</title>
		<link rel="stylesheet" type"text/css" href="style.css"/> 
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1> Welcome to DtoE.com </h1>
			</div>
			<div id="containt">
			<form action="login_process.php" method="POST">
				<table border="0">
					<tr valign="baseline">
						<td align="center" colspan="2"> <h2> Please enter your Username and Password. </h2> </td>
					</tr>
					<tr valign="baseline">
						<td align="right"> <b>Username:</b> </td>
						<td> <input type="text" name="username"/> </td>
					</tr>
					<tr valign="baseline">
						<td align="right"> <b>Password:</b> </td>
						<td> <input type="password" name="password"/> </td>
					</tr>
					<tr>
						<td align="center" colspan="2" id="error"> 
						<?php 
							if(isset($_GET['error_code']))
							{
								if($_GET['error_code'] == 101)
									echo "Sorry there was error connecting to the Database.";
								elseif($_GET['error_code'] == 201)
									echo "Invalid Username or Password.";
							}
						?>
					</tr>
					<tr>
						<td align="center" colspan="2"> <input type="submit" value="Login"/> </td>
					</tr>
				</table>
			</form>
			</div>
		</div>
	</body>
</html>