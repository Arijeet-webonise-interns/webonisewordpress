<?php
function mcp_add_submenu_page(){
	add_submenu_page(
		'edit.php?post_type=party',
		'User Manager',
		'User Manager',
		'manage_options',
		'user_manage',
		'user_manage_callback'
	);
}
add_action('admin_menu','mcp_add_submenu_page');
function user_manage_callback(){
	wp_enqueue_style('mcp-user',plugins_url('css/mcp-user.css',__FILE__));
	$current_user=wp_get_current_user();
	?>
	<div id="party-sort" class="wrap">
		<?php if(!isset($_REQUEST['submit'])){ ?>
		<div id="icon-party-admin" class="icon32"><br></div>
		<h2><?php _e('Sort party Listing','wp-party-listing') ?></h2>
		<?php if($current_user->id!=0): ?>
			<p><?php _e('<strong>Note:</strong>this is only effect party List shortcode'); ?><br> 
			<form method="post" action="#">
				<table width="100%" border="1">
					<tr>
						<th>ID</th><td><?php echo $current_user->ID;?></td>
					</tr>
					<tr>
						<th>Name</th><td><?php echo $current_user->user_login;?></td>
					</tr>
				</table>
		<?php endif; ?>
			<p><?php _e('You have Not Login','wp-party-listing'); ?></p>
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
			</form>
			<?php }else{
				?>
				<table width="100%" border="1">
					<tr>
						<th>First Name</th><td><?php echo $_REQUEST['fname'];?></td>
					</tr>
					<tr>
						<th>Last Name</th><td><?php echo $_REQUEST['lname'];?></td>
					</tr>
					<tr>
						<th>User Name:</th><td><?php echo $_REQUEST['uname'];?></td>
					</tr>
					<tr>
						<th>pass:</th><td><?php echo $_REQUEST['pass'];?></td>
					</tr>
					<tr>
						<th>email:</th><td><?php echo $_REQUEST['email'];?></td>
					</tr>
				</table>
				<?php
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
						var_dump($er);
					}else{
						echo "user created:".$er;
					}
				} ?>
	</div> 
	<?php
	/* Restore original Post Data */
	wp_reset_postdata();
}
?>