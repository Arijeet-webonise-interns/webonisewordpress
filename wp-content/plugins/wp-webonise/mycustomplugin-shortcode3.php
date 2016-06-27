<?php 
function mcp_register_shortcode($atts,$content=null){
	$s='<div id="party-sort" class="wrap">';
		if(!isset($_REQUEST['submit'])){ 
			$s=$s.'<div id="icon-party-admin" class="icon32"><br></div>
				<form method="post" action="#">
				<table width="100%">
					<tr>
						<th>First Name</th><td><input type="text" name="lname" class="inp" /></td>
					</tr>
						<th>Last Name</th><td><input type="text" name="fname" class="inp" /></td>
					</tr>
					<tr>
						<th>User Name:</th><td><input type="text" name="uname" class="inp" /></td>
					</tr>
					<tr>
						<th>Password:</th><td><input type="password" name="pass" class="inp" /></td>
					</tr>
					<tr>
						<th>Email:</th><td><input type="email" name="email" class="inp" /></td>
					</tr>
					<tr>
						<td><input type="submit" name="submit" value="Register" class="inp" /></td>
					</tr>
				</table>
				</form>';
		}else{
				
				$s=$s."<table width='100%' border='1'>
						<tr>
							<th>First Name</th><td>".$_REQUEST['fname']."</td>
						</tr>
						<tr>
							<th>Last Name</th><td>".$_REQUEST['lname']."</td>
						</tr>
						<tr>
							<th>User Name:</th><td>".$_REQUEST['uname']."</td>
						</tr>
						<tr>
							<th>pass:</th><td>".$_REQUEST['pass']."</td>
						</tr>
						<tr>
							<th>email:</th><td>".$_REQUEST['email']."</td>
						</tr>
					</table>";
					$user = array(
						'user_login' => $_REQUEST['uname'],
						'user_pass' => $_REQUEST['pass'],
						'user_email' => $_REQUEST['email'],
						'first_name' => $_REQUEST['fname'],
						'last_name' => $_REQUEST['lname'],
						'role'=>'author'
					);
					$er=wp_insert_user($user);
					if(is_wp_error($er)){
						$s=$s=$er;
					}else{
						$s=$s."user created:".$er;
					}
		} 

	 	$s=$s.'</div> ';
		return $s;
}
add_shortcode('mcp-register-form','mcp_register_shortcode');
?>