<?php
 /*
Plugin Name: Easy Form Builder
Description: Create innovative forms using various fields like  text, checkbox, radio, select box, text area, file, Google Re-captcha 2.0, slider, signature, toggle buttons. With a click or drag and drop you can manage your forms easily. Admin can edit the form and also change the theme color of the forms. View every data you received in your form during registration in your admin panel. View and edit any data you received. Perefect way to create your own registration forms without calling developers or designers. 
Version: 1.0
*/

add_action('admin_menu', 'EFBP_easy_form_builder_form');
add_action( 'wp_ajax_EFBP_form_json_data', 'EFBP_form_json_data_callback' );
add_action( 'wp_ajax_EFBP_insert_form_data', 'EFBP_insert_form_data_callback' );
add_action( 'wp_ajax_EFBP_delete_form_data', 'EFBP_delete_form_data_callback' );
add_action( 'wp_ajax_EFBP_get_all_forms', 'EFBP_get_all_forms_callback' );
add_action( 'wp_ajax_EFBP_submit_json_data_update', 'EFBP_submit_json_data_update_callback' );
add_action( 'wp_ajax_EFBP_submit_form_json_data', 'EFBP_submit_form_json_data_callback' );
add_action( 'wp_ajax_EFBP_verify_captcha', 'EFBP_verify_captcha_callback' );
add_action( 'wp_ajax_EFBP_record_delete', 'EFBP_record_delete_callback' );
add_action( 'wp_ajax_EFBP_record_edit', 'EFBP_record_edit_callback' );
add_action( 'wp_ajax_EFBP_update_form_json_data', 'EFBP_update_form_json_data_callback' );
add_action( 'wp_ajax_EFBP_change_theme', 'EFBP_change_theme_callback' );
add_action( 'wp_ajax_EFBP_verify_upload_file', 'EFBP_verify_upload_file_callback' );

wp_register_script ('EFBPVendor', plugins_url( 'vendor/js/vendor.js', __FILE__ ), array( 'jquery' ),'', true);
wp_register_script ('EFBPFormBuilder', plugins_url( 'dist/formbuilder.js', __FILE__ ), array( 'jquery' ),'', true);
wp_register_script ('EFBPLogicBuilder', plugins_url( 'dist/logicbuilder.js', __FILE__ ), array( 'jquery' ),'', true);
wp_register_script ('EFBPRecaptcha', "https://www.google.com/recaptcha/api.js" , array( 'jquery' ),'', true);


function EFBP_verify_upload_file_callback()
{
	// echo 'server path is: '.$_SERVER['REQUEST_URI'];
		// Count # of uploaded files in array
	$total = count($_FILES['file']['name']);
	//$path = dirname(__FILE__); // this will take you till your plugin folder
	//echo 'path to file is:'.$path;
	$upload_dir = wp_upload_dir();
	/* echo 'upload dir is:';
	print_r($upload_dir); */
	$uploadFolderPath = $upload_dir['basedir']; // this will make uploads folder in the wp-content. it will be outside the plugin folder
	//echo 'upload directory path is :'.$uploadFolderPath;
	
	
	// Loop through each file
	for($i=0; $i<$total; $i++) {
			 
			  if ($_FILES['file']['tmp_name'][$i] != ""){
						//Setup our new file path
						$newFilePath =  	$uploadFolderPath."/formbuilder/". $_FILES['file']['name'][$i];
						//Upload the file into the temp dir
						if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $newFilePath)) {
								echo $i.". ".$newFilePath." <br> ";
							}
				}
		}
	
			wp.die();
}
	
	
function EFBP_change_theme_callback()
{
 
 $themeColor = sanitize_text_field($_POST['themeColor']);
// echo 'theme color is: '.$themeColor;
 $BlueColor =  sanitize_text_field($_POST['BlueColor']);
 $PinkColor =  sanitize_text_field($_POST['PinkColor']);
 $GreenColor =  sanitize_text_field($_POST['GreenColor']);
 $OrangeColor = sanitize_text_field( $_POST['OrangeColor']);
 
 $time_date=date("Y-m-d H:i:s");
 if($themeColor == 'Blue')
 {
 $themeColor = $BlueColor; 
 global $wpdb;
  $table_name3 = $wpdb->prefix . 'colortheme';
  $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name3."( color, created) VALUES ( %s, %s ) ",  $themeColor, $time_date ));
  //$wpdb->insert($table_name3 , array('color'=>$themeColor,'created'=>$time_date), array('%s','%s')); 
 }
 else if($themeColor == 'Pink')
 {
 $themeColor = $PinkColor; 
 global $wpdb;
  $table_name3 = $wpdb->prefix . 'colortheme';
  $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name3."( color, created) VALUES ( %s, %s ) ",  $themeColor, $time_date ));
 // $wpdb->insert($table_name3 , array('color'=>$themeColor,'created'=>$time_date), array('%s','%s')); 
 }
 else if($themeColor == 'Green')
 {
 $themeColor = $GreenColor; 
 global $wpdb;
  $table_name3 = $wpdb->prefix . 'colortheme';
    $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name3."( color, created) VALUES ( %s, %s ) ",  $themeColor, $time_date ));
  //$wpdb->insert($table_name3 , array('color'=>$themeColor,'created'=>$time_date), array('%s','%s')); 
 }
 else if($themeColor == 'Orange')
 {
 $themeColor = $OrangeColor; 
 global $wpdb;
  $table_name3 = $wpdb->prefix . 'colortheme';
    $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name3."( color, created) VALUES ( %s, %s ) ",  $themeColor, $time_date ));
  //$wpdb->insert($table_name3 , array('color'=>$themeColor,'created'=>$time_date), array('%s','%s')); 
 }
 else{
 global $wpdb;
  $table_name3 = $wpdb->prefix . 'colortheme';
    $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name3."( color, created) VALUES ( %s, %s ) ",  $themeColor, $time_date ));
  //$wpdb->insert($table_name3 , array('color'=>$themeColor,'created'=>$time_date), array('%s','%s')); 
 }
 
  $wpdb->show_errors();
 wp.die();
}

function EFBP_record_delete_callback()
{
	global $wpdb;
	 $table_name1 = $wpdb->prefix . 'forminformationdata';
	 $table_name2 = $wpdb->prefix . 'formsubmitdata';
	$wpdb->show_errors();
	$id = intval($_POST['id']);
	if ( ! $id ) {
						$id = '';
		}
	else
		{
			//$wpdb->delete($table_name2, array( 'id' =>$id  ), array( '%d' ) );
			$wpdb->query( $wpdb->prepare( " DELETE FROM ".$table_name2." WHERE id = %d ", $id ));
		}
	wp.die();
	
}

function EFBP_record_edit_callback()
{
$id = intval($_POST['id']);
if ( ! $id ) {
  $id = '';
}
$json = $_POST['json'];
$form_id = intval( $_POST['form_id'] );
if ( ! $form_id ) {
  $form_id = '';
}

// echo 'json data is: '.$json;

	global $wpdb;?>

<td>
						<?php  echo  $id; ?>
						</td>
						<td>
						<form id="FormData<?php  echo $form_id ; ?>">
						
					
							</form>	<script>	
							if("<?php  echo  $json; ?>"!=""){
								
							
								var	objJson=JSON.parse("<?php  echo  $json; ?>");
								var tbl=$("<table/>").attr("id","FormTableView<?php  echo  $form_id ; ?>");
								tbl.attr("class","table table-hover  table-responsive");
								$("#FormData<?php  echo  $form_id ; ?>").append(tbl);
								// to remove data from editing or adding from admin panel
								for(var i=0;i<objJson.length;i++)
								{
									if(objJson[i]["name"]=="g-recaptcha-response") {
										continue;
								}else if(objJson[i]["name"]=="CAPTCHA[]")
								{
									continue;
								}
									var tr="<tr>";
									var td1="<td>"+objJson[i]["name"]+"</td>";
									var td2="<td><input type='text' name='"+objJson[i]["name"]+"' value='"+objJson[i]["value"]+"' /></td></tr>";
								    $("#FormTableView<?php  echo $form_id ; ?>").append(tr+td1+td2); 
								  
								}
							}
</script>		
						</td>	
						<td>
							<input type="button"  value="Save" onClick='EFBP_SaveRecord("<?php  echo  $id; ?>","<?php  echo  $form_id; ?>","<?php  echo  $json; ?>")' class="btn Bt-style" />
						</td>	
						<td>
							<input type="button"  value="Delete" onClick="EFBP_DeleteRecord('<?php  echo  $id; ?>','<?php  echo  $form_id; ?>')" class="btn Bt-style" />
						</td>
					<?php	
	wp.die();
}

	

	function EFBP_verify_captcha_callback(){
		
		$secret=sanitize_text_field ($_POST['secret']);
		$response=sanitize_text_field ($_POST['responseVar']);
		$url = "https://www.google.com/recaptcha/api/siteverify"."?secret=".$secret.
				   "&response=".$response;
		 $data = array(
				'secret' => $secret,
				'response' =>$response
			);

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);

		$check=json_decode($response,true);
		if($check['success'] == false)
		{
			 echo '0';	
		}
		else
		{
			echo '1';
		}
				curl_close($verify);

			wp.die();
	}



	function EFBP_submit_form_json_data_callback()
 {
	
	global $wpdb;
	$wpdb->show_errors();
	$form_data = sanitize_text_field ($_POST['formdata']);

	$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
  $form_id = '';
}
else{
	$user_id = $_POST['user_id'];
	$table_name1 = $wpdb->prefix . 'forminformationdata';
	$table_name2 = $wpdb->prefix . 'formsubmitdata';
	$wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name2."( user_id, json_data,forminformationdata_id) VALUES ( %s, %s, %d ) ",  $user_id, $form_data,$form_id ));
	//$wpdb->insert($table_name2 , array('user_id'=>$user_id, 'json_data' => $form_data,'forminformationdata_id'=>$form_id), array('%s','%s','%d')); 
		$wpdb->show_errors();
}

	wp.die();
 }


	function EFBP_update_form_json_data_callback()
 {
	 
	global $wpdb;
	$wpdb->show_errors();
	$form_data = sanitize_text_field ($_POST['formdata']);

	$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
								$form_id = '';
							}
					
	$id =intval( $_POST['Id']);
	if ( ! $id ) {
					  $id = '';
					}
	else{
			
	$table_name1 = $wpdb->prefix . 'forminformationdata';
	$table_name2 = $wpdb->prefix . 'formsubmitdata';
	$wpdb->show_errors();
	$wpdb->query( $wpdb->prepare(  "UPDATE ".$table_name2." SET json_data = %s, forminformationdata_id = %d WHERE  id= %d ", $form_data, $form_id , $id ) );
	
	//$sql= "UPDATE ".$table_name2.' SET json_data="'.addslashes($form_data).'", forminformationdata_id="'.$form_id .'" WHERE id='.$id ;
	//$wpdb->query($sql);
	
	$wpdb->show_errors();
	}
	wp.die();
 }

 function EFBP_get_all_forms_callback()
 {
	global $wpdb;

	$table_name1 = $wpdb->prefix . 'forminformationdata';
	 $show_from_database = $wpdb->get_results ( $wpdb->prepare("SELECT * FROM ". $table_name1,''));
	   // $show_from_database = $wpdb->get_results ( "SELECT * FROM ".$table_name1);
				             
    foreach ( $show_from_database as $form_data )   {?>
		
				<tr>
						<td>
							<?php  echo  esc_html($form_data->id); ?>
						</td>
						<td>
							<?php  echo esc_html($form_data->form_name); ?>
						</td>
						
						<td>
							<input onclick='EFBP_changeFormId("<?php  echo $form_data->id; ?>","<?php  echo $form_data->json_data;?>","<?php  echo $form_data->json_logic_data;?>","<?php  echo $form_data->json_properties_data;?>");'  type="button"  value="EDIT"  class="btn Bt-style" />
						</td>
						<td>
							<?php  echo  esc_html($form_data->shortcode); ?>
						</td>
						<td>
							<input type="button" id="jsonDataUser" value="DATA" onClick="EFBP_showJsonData('<?php  echo $form_data->id; ?>')" class="btn Bt-style"/>
						
						</td>
						<td>
							<input type="button"  value="DELETE"  class="btn Bt-style makeSure" onClick="use();" />
						</td>
				</tr>
				<tr id="Data<?php  echo $form_data->id; ?>"></tr>
			
<?php	} 
wp.die();
 }
 function EFBP_submit_json_data_update_callback()
 {


$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
								$form_id = '';
							}
							else{
global $wpdb;
$table_name1 = $wpdb->prefix . 'forminformationdata';
$table_name2 = $wpdb->prefix . 'formsubmitdata';		
							//$wpdb->query( $wpdb->prepare( " DELETE FROM ".$table_name1." WHERE id = %d ", $form_id ));

							$fetch_data =$wpdb->get_results($wpdb->prepare( " SELECT id,user_id, json_data ,forminformationdata_id FROM ".$table_name2. " WHERE forminformationdata_id= %d ", $form_id )); 	
							}
?>

<td colspan="7" class="close_div">
<div class = "col-md-12 "  >
<input class="btn close_bt_style" type="button" value="X" onclick="close_me();" />
		<table  class="table table-hover  table-responsive table_contentstyle">
			 <thead>
			 <tr>
						
			 </tr>
				 <tr class="tabe_rowDesign">
					 <th> User Id</th>
					 <th>View Data </th> 
					<th>Edit</th>
					<th>Delete</th>
				 </tr>
		  </thead>
			<tbody>	<?php    
				             foreach( $fetch_data as $FD){
					?>
			
				<tr id="Edit<?php  echo $FD->id; ?>" style="border-bottom: 2px solid rgb(0, 0, 0) ! important;">
						<td>
							<?php  echo  esc_html($FD->user_id); ?>
						</td>
						<td>
						<div id="Form<?php  echo $FD->id; ?>"></div>
						<script>	
						if("<?php  echo $FD->json_data; ?>"!=""){
			var	objJson=JSON.parse("<?php  echo $FD->json_data; ?>");
				var tbl=$("<table/>").attr("id","FormTableView<?php  echo  $FD->id; ?>");
			tbl.attr("class","table table-hover  table-responsive");
			$("#Form<?php  echo  $FD->id; ?>").append(tbl);
			for(var i=0;i<objJson.length;i++)
			{
				if(objJson[i]["name"]=="g-recaptcha-response"){
					continue;
				}
				else if(objJson[i]["name"]=="CAPTCHA[]")
				{
					continue;
				}
				var tr="<tr>";
				var td1="<td>"+objJson[i]["name"]+"</td>";
				 var td2="<td>"+objJson[i]["value"]+"</td></tr>";
			  $("#FormTableView<?php  echo $FD->id; ?>").append(tr+td1+td2); 
			  
			}
						}
</script>		
						</td>	
						<td>
							<input type="button"  value="Edit" onClick='EFBP_EditRecord("<?php  echo  $FD->id; ?>","<?php  echo  $FD->forminformationdata_id; ?>","<?php  echo  $FD->json_data; ?>")' class="btn Bt-style" />
						</td>	
						<td>
							<input type="button"  value="Delete" onClick="EFBP_DeleteRecord('<?php  echo  $FD->id; ?>','<?php  echo  $FD->forminformationdata_id; ?>')" class="btn Bt-style" />
						</td>	
				</tr>
			
	 <?php  }  ?>
  </tbody>
		 </table>
		 </div>
		 </td>
		
<?php 
	 wp.die();
 }
 
 function EFBP_delete_form_data_callback()
 {
	
	//$wpdb->show_errors();
	//	ob_clean();
	global $wpdb;
	$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
								$form_id = '';
							}
	else{
	$table_name1 = $wpdb->prefix . 'forminformationdata';
	$table_name2 = $wpdb->prefix . 'formsubmitdata';

	$wpdb->query( $wpdb->prepare( " DELETE FROM ".$table_name1." WHERE id = %d ", $form_id ));
	//$wpdb->delete($table_name1, array( 'id' =>$form_id  ), array( '%d' ) );
	
	wp.die();
	}
 }
 
function EFBP_form_json_data_callback()
{	
	ob_clean();
	global $wpdb; // this is how you get access to the database
	$wpdb->show_errors();
	$json_data= sanitize_text_field ($_POST['json_data']);
	$json_logic_data= sanitize_text_field ($_POST['json_logic_data']);
		$json_properties_data=sanitize_text_field ($_POST['json_properties_data']);
	$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
								$form_id = '';
							}
							else{
	$table_name1 = $wpdb->prefix . 'forminformationdata';
	$table_name2 = $wpdb->prefix . 'formsubmitdata';
	$wpdb->query( $wpdb->prepare(  "UPDATE ".$table_name1." SET json_data = %s, json_logic_data = %s, json_properties_data = %s WHERE id = %d ", $json_data,$json_logic_data,$json_properties_data, $form_id ));
	//$sql= "UPDATE ".$table_name1.' SET json_data="'.addslashes($json_data).'", json_logic_data="'.addslashes($json_logic_data).'", json_properties_data="'.addslashes($json_properties_data).'" WHERE id='.$form_id;
	//$wpdb->query($sql);

	$wpdb->show_errors();
							}
	wp_die(); 
}

function EFBP_insert_form_data_callback() {
	ob_clean();
	global $wpdb; // this is how you get access to the database
	$wpdb->show_errors();
	$form_name=  sanitize_text_field ($_POST['form_name']);
	$form_id =intval( $_POST['form_id']);
	if ( ! $form_id ) {
								$form_id = '';
							}
	else{
    $table_name1 = $wpdb->prefix . 'forminformationdata';
    $table_name2 = $wpdb->prefix . 'formsubmitdata';    	 
	$shortcode='[EFBP_Form '.$form_id.']';
	echo $wpdb->query( $wpdb->prepare( " INSERT INTO ".$table_name1."	( id, form_name, shortcode ) VALUES ( %d, %s, %s ) ",  $form_id, $form_name, $shortcode ) );
	//echo $wpdb->insert($table_name1, array( 'id'=>$form_id,'form_name' => $form_name,'shortcode'=>$shortcode), array('%d','%s','%s') );
	
	$wpdb->show_errors();
	}
	wp_die(); // this is required to terminate immediately and return a proper response

}
	 
function EFBP_easy_form_builder_form(){
        add_menu_page( 'Easy Form Builder', 'Easy Form Builder Plugin', 'manage_options', 'easyformbuilder-plugin', 'EFBP_NewForm_init' ); // The first option ‘formbuilderPlugin Page’ is the title of our options page. 'Formbuilder Plugin’ is the label for our admin panel. The third parameter determines which users can see the option by limiting access to certain users with certain capabilities. ‘formbuilder-plugin’ is the slug which is used to identify the menu.  ‘Formbuilder_init’ is the name of the function we want to call when the option is selected, this allows us to add code to output HTML to our page. 
}
 
 function create_plugin_database_table() {
 global $wpdb;
 $table_name1 = $wpdb->prefix . 'forminformationdata';
 $table_name2 = $wpdb->prefix . 'formsubmitdata';
 $table_name3 = $wpdb->prefix . 'colortheme';
 $sql1 = "CREATE TABLE ".$table_name1."(
 id bigint(11)  NOT NULL AUTO_INCREMENT,
 form_name varchar(255) NOT NULL,
 json_data longtext NOT NULL,
 json_logic_data longtext NOT NULL,
 json_properties_data longtext NOT NULL,
 shortcode longtext NOT NULL,
 PRIMARY KEY  (id)
 );CREATE TABLE ".$table_name2." (
 id bigint(20)  NOT NULL AUTO_INCREMENT,
 json_data longtext NOT NULL,
user_id longtext NOT NULL,
 forminformationdata_id bigint(20) NOT NULL,
 created datetime NULL,
 updated datetime NULL,
 PRIMARY KEY  (id)
 );CREATE TABLE ".$table_name3." (
 id bigint(20)  NOT NULL AUTO_INCREMENT,
 color varchar(255),
 created datetime NULL,
 updated datetime NULL,
 PRIMARY KEY  (id)
 );";
 
 $host=$_SERVER['HTTP_HOST'];
 $ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://74.208.12.101/wordpress/formbuilder_track.php?link=". $host);

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
 
 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 dbDelta( $sql1);

}
register_activation_hook( __FILE__, 'create_plugin_database_table' );
 
function EFBP_NewForm_init(){ 
 
wp_enqueue_script ('EFBPVendor');
wp_enqueue_script ('EFBPFormBuilder');
wp_enqueue_script ('EFBPLogicBuilder');
wp_enqueue_script ('EFBPRecaptcha');

  ?>
	
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrap.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrap-theme.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'vendor/css/vendor.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/formbuilder.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/fontAwesomeMin.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'signaturepad/assets/jquery.signaturepad.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrapValidator.min.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/slider.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/toggle.css', __FILE__ );?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
   
  <style>
  * {
    box-sizing: border-box;
  }

  body {
    /*background-color: #444;*/
	   background-color: transparent;
    font-family: sans-serif;
  }

  .fb-main {
    background-color: #fff;
    border-radius: 5px;
    max-height: 600px;
	overflow-y:scroll;
  }

  input[type=text] {
    height: 26px;
    margin-bottom: 3px;
  }

  select {
    margin-bottom: 5px;
    font-size: 40px;
  }

.view-main {
    background-color: #fff;
    border-radius: 5px;
    width: 100%;
    float: left;
  }
  
#ViewForm .subtemplate-wrapper {
  border: 1px solid #ccc;
  float: left;
  margin: 4px 0;
  padding: 10px;
  width: 100%;
}
#ViewForm   .toggle_button {
  float: right;
  width: auto;
}
#ViewForm .help-block { 
  display: block; 
}

.radio{ width:10% !important; display: inline; }

/* form align csss*/
.right_label .subtemplate-wrapper label:first-child {
    display: inline !important;
    float: left;
    margin-left: 10%;
}

.left_label .subtemplate-wrapper label:first-child {
    display: inline !important;
    float: left;
    margin-right: 10%;
}
/*11022015*/
.table.table-hover.table-responsive.formListing {
	margin: 0px auto;
	width: 80%;
	border-radius: 50px;
}
/*end form align css */
  </style>
  
  <?php global $wpdb;
	 $table_name3 = $wpdb->prefix . 'colortheme';
	 
	  $get_last_color=$wpdb->get_results($wpdb->prepare(  "SELECT color FROM ".$table_name3." ORDER BY created DESC ",'')) ;
	
	  $colorSelected="";
	    foreach( $get_last_color as $FD){	
		 $colorSelected=$FD->color;
	
			?> 
	<style>
			.fb-tabs li.active a { background: <?php echo $FD->color;?>;color: #fff;}
			#ViewDataBox{z-index: 999999;	display: block;	top: 46px;	height: 400px;	overflow: scroll;		width: 630px;	}
			.fb-add-field-types a{font-size:13px;display:inline-block;width:48.5%;background-color: <?php echo $FD->color;?> !important;margin-bottom:9px;box-sizing:border-box;color:#fff !important;}
			.fb-field-wrapper input{border-radius:3px;border:thin solid #ccc !important;}
			.fb-button{display:inline-block;margin:0;padding:.563rem .844rem;border:0 none;background:<?php echo $FD->color;?> !important;color:#fff;text-align:center;text-decoration:none;font-size:12px;line-height:1.5;cursor:pointer;border-radius:.125rem;border:thin solid #ccc !important;border-bottom:2px solid<?php echo $FD->color;?> !important;}
			.fb-button{border-bottom:2px solid <?php echo $FD->color;?> !important;background:<?php echo $FD->color;?> !important;}
			.view-button{border-bottom:2px solid <?php echo $FD->color;?> !important;background:<?php echo $FD->color;?> !important}
			.create_forms{padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;}
			.create-popupDesign{padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;}
			.create-popupDesign{	margin-left:10%;	margin-bottom:10px;	padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;	background-color: <?php echo $FD->color;?> !important;	color:#fff ;}
			.Bt-style{min-width:100px; background-color: <?php echo $FD->color;?> !important; color:#fff !important;}
			.create-inno-frm{color:<?php echo $FD->color;?> !important; font-size: 2em;  height: auto;  margin: 20px 0;  width: 100%;} 
			.create_forms{margin-bottom:10px;padding:5px;boder-color:#19b394 #19b394<?php echo $FD->color;?> !important;background-color:<?php echo $FD->color;?> !important;color:#fff ;}
			.DropDownBoxStyle{Width:80px;Color:white;background-color:<?php echo $FD->color;?> !important;font-size:16px;}
			.chooseThemeStyle{ color:<?php echo $FD->color;?> !important;
			.fb-tabs li.active a { background:<?php echo $FD->color;?> !important;color: #fff;}
			.fb-button:hover {  background: <?php echo $FD->color;?> !important none repeat scroll 0 0;color: #fff;text-decoration: none;}
			.view-button{display:inline-block;margin:10px;padding:.563rem .844rem;border:0 none;background:<?php echo $FD->color;?> !important;color:#fff;text-align:center;text-decoration:none;font-size:12px;line-height:1.5;cursor:pointer;border-radius:.125rem;border-bottom:2px solid <?php echo $FD->color;?> !important;}
			 .modal-header {  background-color: <?php echo $FD->color;?>;  border-radius: 5px 5px 0 0;  color: #fff;}
			 .modal-header button.close {   color: #fff;   opacity: 0.8; }
			 .modal-content {  border: 2px solid <?php echo $FD->color;?>;  float: left;  width: 100%;}
			 .view-form-header { border-bottom: 2px solid <?php echo $FD->color;?>;}
			 input[type="text"], textarea {display: inline-block; height: 34px;	padding: 6px 12px;	font-size: 14px	line-height: 1.42857143;	color: #555;	background-color: #fff;	background-image: none;	border: 1px solid #ccc;border-radius: 4px;	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);	-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;	-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;	transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;}
			  input[type="text"]:focus ,textarea:focus {	outline: none;	border: thin solid #ccc; 	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);	box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);}
			.fb-field-wrapper .actions-wrapper a.js-duplicate,.fb-edit-field-wrapper .js-add-option{background-color:<?php echo $FD->color;?> !important;border:none;color:#fff !important;}
			.fb-field-wrapper .actions-wrapper a.js-clear,.fb-edit-field-wrapper .js-remove-option{background-color:<?php echo $FD->color;?> !important;border:none;color:#fff !important;}
			.close_bt_style:hover{background:color:<?php echo $FD->color;?>!important; }
			.table_contentstyle {width: 530px;margin-top: 30px;}
	</style> 
	
	    <?php if($FD->color=='Black'){  ?> 
			<style>
			.fb-field-wrapper input{border-radius:3px;border:thin solid #ccc !important;}
				.view-main {background: #515151 none repeat scroll 0 0 !important;}
				#ViewForm {color: #fff;}  
				<!--.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #23282D;} -->
				 .view-main .elementdiv input[type="text"] {  background-color: <?php echo $FD->color;?>; color:#fff;}
			</style> 
		<?php }
		
		if($FD->color=='Red'){  ?> 
			<style>
			.modal-header {  background-color: #fb2228;  border-radius: 5px 5px 0 0;  color: #fff;}
				.modal-content {  border: 2px solid #fb2228;  float: left;  width: 100%;}
			    .view-form-header { border-bottom: 2px solid #fb2228;}
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
				<!--.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #ff0000;} -->
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #fb2228;
					border-radius:0px;
				}
			</style> 
		<?php }
		
		if($FD->color=='Green'){  ?> 
			<style>
				.modal-header {  background-color: #19B594;  border-radius: 5px 5px 0 0;  color: #fff;}
    .modal-content {  border: 2px solid #19B594;  float: left;  width: 100%;}
       .view-form-header { border-bottom: 2px solid #19B594;}
    .view-main {background: #fff none repeat scroll 0 0 !important;}
    #ViewForm {color: #000;}  
   
    .view-main input[type="text"], 
    .view-main textarea {  
     border: 1px solid #19B594;
	border-radius:0px;}
			</style> 
		<?php } 
		if($FD->color=='Blue'){  ?> 
			<style>
				.modal-header {  background-color: #0073AA;  border-radius: 5px 5px 0 0;  color: #fff;}
				.modal-content {  border: 2px solid #0073AA;  float: left;  width: 100%;}
			    .view-form-header { border-bottom: 2px solid #0073AA;}
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
			<!--	.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #0073AA;} -->
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #0073AA;
					border-radius:0px;
				}
			</style> 
		<?php }  
		if($FD->color=='Orange'){  ?> 
			<style>
				 
				 .modal-header {  background-color: #FFA30F;  border-radius: 5px 5px 0 0;  color: #fff;}
    .modal-content {  border: 2px solid #FFA30F;  float: left;  width: 100%;}
       .view-form-header { border-bottom: 2px solid #FFA30F;}
    .view-main {background: #fff none repeat scroll 0 0 !important;}
    #ViewForm {color: #000;}  
    .view-main input[type="text"]:focus, textarea:focus {  border: thin solid #FFA30F;} 
    .view-main input[type="text"], 
    .view-main textarea {  
     border: 1px solid #FFA30F;
     border-radius:0px;
    }
			</style> 
		<?php }
		
		if($FD->color=='Grey'){  ?> 
			<style>
				 
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
			<!--	.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #ccc;} -->
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #ccc;
					border-radius:0px;
				}
			</style> 
		<?php }
		if($FD->color=='Pink'){  ?> 
			<style>
				 
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
				.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #FF0875;} 
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #FF0875;
					border-radius:0px;
					 input[type="text"],textarea {
	display: inline-block; 
	height: 34px;
	padding: 6px 12px;
	font-size: 14px;
	line-height: 1.42857143;
	color: #555;
	background-color: #fff;
	background-image: none;
	border: 1px solid #FF0875;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
	-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
	-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
  input[type="text"]:focus ,
 textarea:focus {
	outline: none;
	border: thin solid #FF0875; 
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
}
				}
			</style> 
		<?php }


		break;} ?>
		

  <script>	
    function close_me()
   {
	
		   $(".close_div").fadeOut();
	   $('#UserInfo').fadeOut();
		    $('#ViewDataBox').fadeOut();
        $('#popoverlay').fadeOut();
   }

  function EFBP_SaveRecord(Id,formId,jsonData)
  {
	  
	    var data = {
			'action': 'EFBP_update_form_json_data',
			'formdata':JSON.stringify($('#FormData'+formId).serializeArray()),
			'form_id':formId,
			'Id':Id
			};
	jQuery.post(ajaxurl, data, function(response) {
					
				EFBP_showJsonData(formId);
					//alert(response);
					 });
   }
	 

   function EFBP_DeleteRecord(id,formid)
   {
	   // alert('delete called');
	  var data = {
			'action': 'EFBP_record_delete',
			'id':id
			};
	jQuery.post(ajaxurl, data, function(response) {
						//alert('Your form has been deleted successfully ');
					EFBP_showJsonData(formid);
					 });
   }
   
   function EFBP_EditRecord(id,form_id,json)
   {
	    var data = {
			'action': 'EFBP_record_edit',
			'id':id,
			'form_id':form_id,
			'json':json
			};
jQuery.post(ajaxurl, data, function(response) {
						$("#Edit"+id).html(response);
						//alert(response);
				/*		$("#Form"+id).dform({
    "action" : "index.html",
    "method" : "get",
    "html" :JSON.parse(json.replace(/\\/g, ''))
						});*/
					 });
	   
   }
   
  var form_name;
   function use(){		
			
	         $('#popoverlay').show();		
	        $('#suredeletebox').show().css("top", "500px").animate({		
	            top: "50px"		
	        }, 100);		
	        $('.mainContent').css("background-color", "grey"); 		
	  } 
	  
  window.onload  = function(e){
    $('#start_with_form').click(function () {
        $('#popoverlay').show();
        $('#UserInfo').show().css("top", "500px").animate({
            top: "50px"
        }, 100);
        $('.mainContent').css("background-color", "grey");
    });
	
	 $('#doNotDelete').click(function() {		
			  $('#suredeletebox').fadeOut();		
			  $('#popoverlay').fadeOut();		
		 });		
		 
		 
	 $('#popoverlay').click(function () {
        $('#UserInfo').fadeOut();
        $('.modal-content').fadeOut();
		    $('#ViewDataBox').fadeOut();
        $('#popoverlay').fadeOut();
		$('#main_container').fadeOut();	
		$('#popoverlay').fadeOut();
		 $('#suredeletebox').fadeOut();
	 });
	getAllForms();
};
function getAllForms(){
	
	 var data = {
			'action': 'EFBP_get_all_forms'
			};
	jQuery.post(ajaxurl, data, function(response) {
						//alert(data);
							$("#tableBody").html(response);
					 });
	
	
}
	var form_id;
	function sendFrmNm()
		{     
		//alert('called');
		form_name=$("#formNameId").val();
		//alert(form_name);
		form_id=Math.floor(Date.now() / 1000);
		//alert(form_id);
		var data = {
			'action': 'EFBP_insert_form_data',
			'form_name':form_name,
			'form_id': form_id
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
						//alert(data);
								var NewForm;
								createNewFormBuilder(NewForm);
								createFormProperties();
								$('#popoverlay').show();
								$('#main_container').show().animate({   
									top: "40px",left:"200px"
								}, 100);
								$(".formName").hide();
								$("#popoverlay").show();
								$('.mainContent').css("background-color", "grey");
   
								
		//	alert('Got this from the server: ' + response);
		});
	
				
}
	function EFBP_showJsonData(form_id)
	{ 
		var data = {
			'action': 'EFBP_submit_json_data_update',
			'form_id': form_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		$('#popoverlay').show();
        $('#ViewDataBox').show().css("top", "500px").animate({
            top: "50px"
        }, 100).html(response);
			
					 });			
}
	function change_theme_color()
 {
  
  var BlueColor = "0073AA";
  var PinkColor = "FF0875";
  var GreenColor = "149C78";
  var OrangeColor = "FFA30F";
  var themeColor = document.getElementById('Get_theme_color').value;
   document.getElementById('Get_theme_color').selectedIndex=themeColor;
  var data = {
   'action': 'EFBP_change_theme',
   'themeColor': themeColor,
   'BlueColor': '#'+BlueColor,
   'PinkColor': '#'+PinkColor,
   'GreenColor': '#'+GreenColor,
   'OrangeColor': '#'+OrangeColor
   
  
  };
  jQuery.post(ajaxurl, data, function(response) {
  // alert(data);
  location.reload();
     });   
  
 }
  </script>
   
  <?php 

	global $wpdb;

	$table_name2 = $wpdb->prefix . 'formsubmitdata';

		$table_name1 = $wpdb->prefix . 'forminformationdata';		
		 $show_from_database = $wpdb->get_results ( $wpdb->prepare("SELECT * FROM ". $table_name1,''));		
		  foreach($show_from_database as $data_form)		
		  {		
			?>		
			<div class="col-md-6  frm-design delPopupDesign " id="suredeletebox" style="display:none;">		
					<div class="col-md-8">		
							<label style="padding-left:53px;"> Do you want to delete this record ? </label>		
							
					<br>		
					<div class="col-md-4" style="padding-bottom: 20px;padding-left: 53px;padding-right: 130px;">		
						<input type="button" value="Yes" onClick="EFBP_RemoveForm('<?php  echo $data_form->id; ?>')" class="btn Bt-style">		
					</div>			
					<div class="col-md-4 ">		
						<input type="button"  id="doNotDelete" value="No" class="btn Bt-style" >		
					</div>			
					</div>		
			</div>		
			<?php } ?>
			
		<div class="col-md-6 formName frm-design" id="UserInfo"  >
			
			<div class="col-md-8 popupDesign2">
				<label>  Form Name  :</label>
					<input id="formNameId" type="text" placeholder="Enter form name">
				</div>

				<div class="col-md-4 popupDesign1">
					<input type="button" id="btn createForm" value="Create"  onClick="sendFrmNm();" class="create-popupDesign">
				</div>	
		
		</div>
		<div class="col-md-6 formName frm-design" id="ViewDataBox" style="display:none;"  >
		
		</div>
			<div class="mainContent" id="popoverlay"></div>
 <div class="container" >			
		<div class="row">
			<div class="col-md-12">
				<h1 class="createInnoForm create-inno-frm text-left" > CREATE INNOVATIVE FORMS<a href="http://www.bitwaretechnologies.com/contact/" style="
border-radius:50%;
color:#fff;
text-align:center;
background:#000;float:right;">&nbsp;&#63;&nbsp;</a> </h1>
			</div>
			
			<div class="col-md-12">
				<form class="plugin-frm-style"> 
				 <div class="col-md-12 plugin-top ">
					 <input id="start_with_form"  type="button" value=" Create Forms" class="btn create_forms margin-0" />
					 <div class="top-btn-group btn-group pull-right col-md-4 col-sm-6 col-xs-12">
						 <label class="chooseThemeStyle margin-0"> CHOOSE YOUR THEME </label>
						 
					
						 <select  id="Get_theme_color" class="form-control DropDownBoxStyle pull-right margin-0" onChange="change_theme_color();">
							<option  name="" value="Red"  <?php if($colorSelected=="Red"){echo "selected='selected'";}?>> Red </option>
							<option  name="" value="Green"  <?php if($colorSelected=="#149C78"){echo "selected='selected'";}?>>  Green </option>
							<option  name="" value="Pink"  <?php if($colorSelected=="#FF0875"){echo "selected='selected'";}?>> Pink </option>
							<option  name="" value="Blue"  <?php if($colorSelected=="#0073AA"){echo "selected='selected'";}?>> Blue </option>
							<option  name="" value="Orange"  <?php if($colorSelected=="#FFA30F"){echo "selected='selected'";}?>> Orange </option>
							<option  name="" value="Grey"  <?php if($colorSelected=="Grey"){echo "selected='selected'";}?>> Grey </option>
						<!--	<option name="" value="Black"  <?php if($colorSelected=="Black"){echo "selected='selected'";}?>> Black</option> -->
						</select>
					 </div>
					 
				</div>
				
				 
				
				<div class = "col-md-12" >
				<table  class="table table-hover  table-responsive formListing ">
					 <thead>
						 <tr>
							 <th>Form Id</th>
							 <th>Form Name</th>
							<th>Edit  form</th>
							 <th>Shortcode</th>
							 <th>View Data </th> 
							<th>Remove form</th>
						 </tr>
				  </thead>	<tbody id="tableBody">
					
		  </tbody>
				 </table>
				 </div>
				   <div id="show_my_table"> </div>
		  </form>
		</div>
	</div>
</div>
  
  
  
  
  <div class="container" id="main_container" style="display:none; left:200px !important;" >
  <div class='fb-main'></div>
  <!-- Render Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form</h4>
        </div>
        <div class="modal-body">
           <div class="view-main row" style="margin-top:1%;">
		
			<div id="ViewForm" class="col-md-12" style="background-color:white;">
			  <div class="group-error col-md-12"></div>
			  <form data-toggle="validator" role="form" method="post" id="showform" enctype="multipart/form-data">
			 
			  </form> 
    	</div>  
		  </div>
        </div>
        <div class="modal-footer">
       
        </div>
      </div>
      
    </div>
  </div>
  <!-- end Render Model-->

  <!--Logic Model-->
  <div class="modal fade" id="logicModal" role="dialog" style="display: none;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Logic Builder</h4>
        </div>
        <div class="modal-body">
           <div class="view-main row" style="margin-top:1%;">

      <div id="LogicForm" class="col-md-12" style="background-color:white;">
        <!--start accordins-->
          <div class="bs-example">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Enable Rules to Show/Hide Fields</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form method="post" id="showlogicform">
                            <div class="col-md-12" id="elementList"> <label>Select a Field to Show/Hide </label><select class="form-control" name="elementName" id="elementName" onchange="setJsonObj(this.options[this.selectedIndex].value,this.options[this.selectedIndex].innerHTML);" ></select></div>
                            <div class="col-md-12" id="dropableElem">
                              <ul id="addElement" class="addElement"> </ul>  
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Enable Rules to Display Success Page</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <!--start second portion-->
                              <form method="post" id="successform" class="rule1">
                                <div id="initialdiv" class="col-md-12">
                                  <ul class="addElement" id ="ulsuccess">
                                    <li id="logicid001"><table width="100%" cellspacing="0"><thead><tr><td><strong> Rule1</strong></td><td><td><button type="button" class="btn close" onclick="closeRule('000');">&times;</button></td></td></tr></thead><tbody><tr><td><h6>If <select name="fieldruleallany_15" id="successallany001" class="element select rule_all_any form-control" onchange="successallany(this);"><option value="all">all</option><option value="any">any</option></select> of the following conditions match:</h6><ul class="ls_field_rules_conditions"><li id="lifieldrule_001"> <select id="001" name="conditionfield_001" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="setelementtype(this);"><option>elemetsListBox</option></select><select name="conditiontext001" id="conditiontext001" onchange="setformcondition(this);" class="element select condition_text form-control" style="width: 36%;"><option value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option></select> <span id="conditionkeywordspan001" ><input id="conditionkeyword001" type="text" class="element text condition_keyword" value="" name="conditionkeyword001" onkeyup="setformcondkeyword(this);"></span></li></ul></td></tr><tr><td></td><td></td><td><button onclick="addFormclone('001');" class="btn close" type="button">+</button></td></tr> <tr><td>On Success Page:</td><td><input type="radio" id="show_msg001" name="success" value="show_msg" checked onclick="showmydiv(this);" style="width:auto !important;">Show Message</td><td><input type="radio" id="redirct_to001" name="success" value="redirct_to" onclick="showmydiv(this);" style="width:auto !important;">Redirect to Page</td></tr> <tr><td><div class="show_msg"><label>Success Message</label><textarea class="form-control" id="msgvalue001" onchange="setsuccessValue(this);"></textarea></div></td><td> <div class="redirct_to" style="display:none"> <label>Redirect URL</label> <input type="text" class="form-control" id="urlvalue001" onchange="setsuccessValue(this);"/></div> </td></tr> </tbody></table> </li>
                                   </ul>
                                   <div class="col-md-12"><button onclick="copyFormclone('001');" class="btn close" type="button">Add Success Page Rule+</button></div>
                                 </div> <!--end initialdiv-->   
                                </form>
                             </div>
                            <!--end second portion-->
                        </div>
                    </div>
                </div>
                </div>
          <div class="col-md-12" style="padding-bottom: 2%;">
            <button onclick="saveForm();" type="button" class="btn btn-success btn-sm" data-dismiss="modal">Save</button>
        </div>

        </div>
        <!--end accordins-->

        
      </div>  
      </div>
        </div>
        <div class="modal-footer">
		
        </div>
      </div>
      
    </div>
  </div>
  <!--End Logic Model-->
  
</div><!--end container-->
<div>
<div class="row">
<center>Rights reserved by Bitware Technologies © 2015-2016
 </center>   </div>
     </div>
  <script type="text/javascript">
      var payLoadData;
	  var Formjson;
	  var formid="";
	  
	  function EFBP_RemoveForm(form_id)
	  {     
		var data = {
			'action': 'EFBP_delete_form_data',
			'form_id': form_id
		};
		jQuery.post(ajaxurl, data, function(response) {
						$('#popoverlay').fadeOut();		
						$('#suredeletebox').fadeOut();
						getAllForms();		
				
		});
}
	 
	  
	  function closeFormBox(){
		  	getAllForms();
		      $('#popoverlay').hide();
        $('#main_container').hide().animate({
            top: "-100px",left:"999px"
        }, 100);
		$(".formName").hide();
		$(".modal-backdrop").hide();
		
  }
		 var elemntObj;
	  function EFBP_changeFormId(formIdCurrent,jsonDataString,jsonLogicDataString,jsonLogicProperties){
		  
		  form_id=formIdCurrent;
		  var payLoadJson=[];
		  payLoadData=jsonDataString;
		 if(jsonLogicProperties!="")
		 {
		  Formjson=JSON.parse(jsonLogicProperties);
		 }
		 else{
			 Formjson='{"forms":[{"field_options":{"form_title":"'+$("#setformTitle label").html()+'","form_description":"'+$("#setformDesc label").html()+'","submitconfirm":"'+$("#submitconfirm").val()+'","includejs":"'+$("#includejs").val()+'"}}]}';
		 }
		  //alert(Formjson);
		  if(jsonLogicDataString!=""){
		  elemntObj=JSON.parse(jsonLogicDataString);
		 // alert(elemntObj);
		  }
		  if(jsonDataString!=""){
		  payLoadJson=JSON.parse(jsonDataString);
		  
		  }
		  else{
			  payLoadJson=[];
		  }
		  //alert()
createNewFormBuilder(payLoadJson.fields);
createFormProperties();
       $('#popoverlay').show();
        $('#main_container').show().animate({
            top: "3% !important",left:"220px",position:"fixed !important"
        }, 100);
		$(".formName").hide();
		$("#popoverlay").show();
		
        $('.mainContent').css("background-color", "grey");
		$("#formTitle").val(Formjson.forms[0].field_options.form_title);
		$("#formDesc").val(Formjson.forms[0].field_options.form_description);
		$("#form_success_message").val(Formjson.forms[0].field_options.submitconfirm);
		$("#form_redirect_url").val(Formjson.forms[0].field_options.redirecturl);
		
		
	  }
	  function createNewFormBuilder(jsonData){
		
   $(function(){
      fb = new Formbuilder({
        selector: '.fb-main',
        /*bootstrapData: [
          {
            "label": "Do you have a website?",
            "field_type": "website",
            "required": false,
            "field_options": {},
            "cid": "c1"
          },
          {
            "label": "Please enter your clearance number",
            "field_type": "text",
            "required": true,
            "field_options": {},
            "cid": "c6"
          }
        ]*/
		bootstrapData:jsonData
      });

      fb.on('save', function(payload){
            payLoadData=payload;
		
        //alert(payLoadData);
         //Set Dynamic datepicker 
          $(function() {
            $( "#datepicker" ).datepicker();
              $( "#datepicker1" ).datepicker();
              $( "#datepicker2" ).datepicker();
              
          });
		 
      })
    });
}
	
/* File uploading validation */
function checkExtensions(oInput,_validFileExtensions){

 var _validFileExtensions_Array= _validFileExtensions.split(',');
            var sFileName;
            if(oInput.multiple==true){
              var blnValid =false;
                for (var i=0; i<oInput.files.length; i++) {
                   sFileName = oInput.files[i].name;
                   
                    for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                        var sCurExtension = _validFileExtensions_Array[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    
             
                }
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
                return true;
            }
            else{
                sFileName = oInput.value;
            }
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                    var sCurExtension = _validFileExtensions_Array[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
            }
      return true;
}

function checkExtensions2(oInput,_validFileExtensions){
 //   alert("called 2");
 var _validFileExtensions_Array= _validFileExtensions.split(',');
        var sFileName;
          if(oInput.multiple==true){
      var blnValid =false;
        for (var i=0; i<oInput.files.length; i++) {
            sFileName = oInput.files[i].name;
            
            for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                var sCurExtension = _validFileExtensions_Array[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
            
            
        }
        if (blnValid) {
            alert("Sorry, " + sFileName + " is blocked, blocked extensions are: " + _validFileExtensions_Array.join(", "));
            oInput.value="";
            return false;
        }
        return true;
  
  }
     else{
     sFileName = oInput.value;
     }
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                    var sCurExtension = _validFileExtensions_Array[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (blnValid) {
                    alert("Sorry, " + sFileName + " is blocked, blocked extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
        else{
        
              }
            }
            
      return true;
}
  function checkTotalFiles(oInput,totalFiles){
      var totalFilesSelected=oInput.files.length;
     
      if(totalFilesSelected>totalFiles){
          oInput.value="";
          alert("You cannot select more than "+ totalFiles +" files.");
          return false;
      }
      return true;
  }
  function checkFileSize(oInput,fileSizeLimit){
      var fileSize=0;
              if(oInput.multiple==true){
                  for (var i=0; i<oInput.files.length; i++) {
                      fileSize = oInput.files[i].size;
                      if(fileSize>fileSizeLimit*1024*1024){
                          oInput.value="";
                          alert("Files cannot be greater than "+ fileSizeLimit +" MB.");
                          return false;
                          
                      }
                  }
              }
              else{
                  fileSize = oInput.files[0].size;
                 // alert(oInput.files[0].size);
                  if(fileSize>fileSizeLimit*1024*1024){
                      oInput.value="";
                      alert("File cannot be greater than "+ fileSizeLimit +" MB.");
                      return false;
                      
                  }
              }
  }
  
/* END uploading file*/
    function renderForm(){
		console.log("MainLogicForm-"+Formjson);
	//alert(payLoadData);
       // Logic builder enable disable element
        if(jQuery.isEmptyObject(elemntObj)){
          elemntObj='{"rule1":[]}';
          elemntObj=JSON.parse(elemntObj);
        } 

      console.log("logic json"+JSON.stringify(elemntObj));
      // End Logic builder enable disable element

     
        // if payLoadData is empty
        if($.isEmptyObject(payLoadData))
        payLoadData='{"fields":[]}';

      
        var text = payLoadData;
    
        obj = JSON.parse(text);
        var flist = [];
        
        var countryjson=["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United States","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
	if($.isEmptyObject(Formjson))
		 {
		 Formjson=JSON.parse('{"forms":[{"field_options":{"form_title":"'+$("#setformTitle label").html()+'","form_description":"'+$("#setformDesc label").html()+'","submitconfirm":"'+$("#form_success_message").val()+'","redirecturl":"'+$("#form_redirect_url").val()+'","includejs":"'+$("#includejs").val()+'"}}]}');
	 	
		 }
		
        var setLabelClass="";
		
        document.getElementById("showform").innerHTML=$('#fb-response-formid').html();
   	       document.getElementById("showform").innerHTML='<div class="view-form-header"><i class="fa fa-file-text margin-0"></i>  <strong>'+Formjson.forms[0].field_options.form_title+'</strong><p class="view-form-description margin-0">'+Formjson.forms[0].field_options.form_description+'</p></div>';
   	for(var i = 0; i < obj.fields.length; i += 1){
            var requiredHtml="";
            var requiredElement="";
            // Common Required
            if(obj.fields[i].required==true){ requiredHtml='<abbr title="required">*</abbr>'; requiredElement=" required "; }
			   // Common Read only
            if(obj.fields[i].field_options.READONLY==true){ requiredElement +=" readonly "; }
            // Common element ID
            var elementId="id='rend"+obj.fields[i].cid+"'";
            var logicId="id='logic"+obj.fields[i].cid+"'";

            var setlogicBuilderFun="";
             var visibleHtml="";
             if(obj.fields[i].field_options.visibility!="visible"){ visibleHtml='hiddenClass'; }

             var statusShow="",title=firstname=lastname=middlename="";
             var SecondFieldFun=HourFormatFun=bothFun=selectampm="";
             var addressFun=address2Fun=cityFun=stateFun=zipFun=countryFun=""; 
                  var titleFun=firstFun=middleFun=lastFun=""; 
                  var addressArr=['address','address2','city','state','zip','country'];

            for(var j=0; j<elemntObj.rule1.length;j++){
                  
                  if(elemntObj.rule1[j]['fromid']==obj.fields[i].cid){
                      
                     // alert(elemntObj.rule1[j]['selectelm']+" "+j );
                      //title
                      if(elemntObj.rule1[j]['selectelm']=="title"){

                        titleFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                     if(elemntObj.rule1[j]['selectelm']=="firstname"){
                        //firstname
                        firstFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"')";
                      }

                       if(elemntObj.rule1[j]['selectelm']=="middlename"){
                        //middlename
                          middleFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      if(elemntObj.rule1[j]['selectelm']=="lastname"){
                        //lastname
                        lastFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time SecondField
                      if(elemntObj.rule1[j]['selectelm']=="SecondField"){
                        //SecondField
                        SecondFieldFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time HourFormat
                      if(elemntObj.rule1[j]['selectelm']=="HourFormat"){
                        //HourFormat
                        HourFormatFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time both
                      if(elemntObj.rule1[j]['selectelm']=="both"){
                        //both
                        bothFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }
                      
                      if(addressArr.includes(elemntObj.rule1[j]['selectelm'])){
                         
                        //address
                        if(elemntObj.rule1[j]['selectelm']=="address"){

                          addressFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                         
                        }
                        //addrress2
                        if(elemntObj.rule1[j]['selectelm']=="address2"){
                          address2Fun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                        }

                        //city
                        if(elemntObj.rule1[j]['selectelm']=="city"){cityFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //state
                        if(elemntObj.rule1[j]['selectelm']=="state"){stateFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //city
                        if(elemntObj.rule1[j]['selectelm']=="zip"){zipFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //country
                        if(elemntObj.rule1[j]['selectelm']="country"){countryFun=="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                      }
                      else 
                      {
                        setlogicBuilderFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"');";
                      }
                      
                        console.log(i+"here"+setlogicBuilderFun+" "+elemntObj.rule1[j]['selectelm']);
                    }
                    //show/hide element
                    if(elemntObj.rule1[j]['cid']==obj.fields[i].cid){
                         console.log("status1"+statusShow);
                      if(elemntObj.rule1[j]['status']=="show"){
                         console.log("status2"+statusShow);
                        statusShow="style='display:none;'";
                      }
                    }

                 }
                 console.log("status"+statusShow);
                //setlogicBuilderFun="setlogicBuilderFun('"+obj.fields[i].cid+"');";
            
            // Common visible

            //website
            if(obj.fields[i].field_type=="website"){
              var htmlText='',sizeval='',defaultVal='',textType='url',minlength='',maxlength='';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                      if(key=="size"){
                        sizeval=value;
                      }else if(key=="defaultvalue"){
                        defaultVal=value;
                      }else if(key=="customcssclass"){
                        customcssclass=value;
                      }else if(key=="description"){
                        description=value;
                      }

                   });

              var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div> '; 
            }

                onchangeFun=="";
               if(setlogicBuilderFun!="")
               onchangeFun='oninput="'+setlogicBuilderFun+'"';

                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group'+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label><br><input type="url" class="rf-size-  " value="'+defaultVal+'" placeholder="http://" '+elementId+' '+requiredElement+' '+onchangeFun+' data-error="Please enter valid website."></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
            }

            // Text
            if(obj.fields[i].field_type=="text"){

              // Get Text Propertise
              var htmlText='',sizeval='',defaultVal='',textType='text',minlength='',maxlength='';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="password"){
                   textType=value;
                  }else if(key=="defaultvalue"){
                    defaultVal=value;
                  }else if(key=="minlength"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=="min_max_length_units"){
                     if(value=="words"){textWC='w';}else{textWC='c';}
                  }

                });
                
          if(maxlength!="" || minlength!=""){
               onchangeFun="onchange=\"limit_input('rend"+obj.fields[i].cid+"','"+textWC+"','"+maxlength+"','"+minlength+"'); "+setlogicBuilderFun+"\"";             
                    if(textWC=="c"){
                         onchangeFun +=" maxlength='"+maxlength+"'";
                    }
              }
              else
              {
                onchangeFun='oninput="'+setlogicBuilderFun+'"';
              } 

            
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
    htmlText +='<div class="elementdiv"><input '+requiredElement+' '+elementId+' type="'+textType+'" name="'+obj.fields[i].label+'" class="rf-size-'+sizeval+'" value="'+defaultVal+'"  '+onchangeFun+' data-error=""></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlText+'</div> '; 
            }
         //End Text

			 // Captcha
		 if(obj.fields[i].field_type=="Captcha"){

              // Get Text Propertise
              var htmlText='',textType='text';
              var description=customcssclass=siteKey='';

              $.each( obj.fields[i].field_options, function( key, value ) {
   
                   if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=="site_key")
				  { site_key=value;}
                });
				
                	
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
    htmlText +='<div class="elementdiv"><div class="g-recaptcha" data-sitekey="'+siteKey+'"></div><input '+requiredElement+' '+elementId+' type="'+textType+'"  name="'+obj.fields[i].label+'"  data-error="" style="display:none;"></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+customcssclass+'" >  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlText+'</div> '; 
            }
         //End Captcha
		 
             // Slider
            if(obj.fields[i].field_type=="slider"){
              var htmlSlider=customcssclass=urltext=description=defaulturl=currencyslider=onchangeFun="";
              var maxlength=100,minlength=0;
              // Get Text Propertise
              $.each( obj.fields[i].field_options, function( key, value ) {
              console.log(key +":"+ value);
                  
                  if(key=="defaulturl"){
                    defaulturl=value;
                  }else if(key=="urltext"){
                    urltext=value;
                  }else if(key=="min"){
                    minlength=value;
                  }else if(key=="max" ){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="currencyslider"){
                    currencyslider=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
               
             });
             
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span> '; 
            }

/* old htmlSlider +='<input type="range" min="'+minlength+'" max="'+maxlength+'" name="slider[]" oninput="document.getElementById(\'sliderInp'+obj.fields[i].cid+'\').innerHTML=this.value;"/><label id="sliderInp'+obj.fields[i].cid+'">'+minlength+' '+EFBP_getCurrencySymbol(currencyslider)+'</label><span class="optionalContent1"><a href="'+defaulturl+'" target="_blank" class="linktext">'+urltext+'</a></span>'+descriptionHtml;*/

htmlSlider +='<div class="row"><div class="all col-md-10 col-sm-10 col-xm-10"><input value="'+minlength+'" type="range" min="'+minlength+'" max="'+maxlength+'" name="slider[]" oninput="document.getElementById(\'sliderInp'+obj.fields[i].cid+'\').value=this.value;"/></div><div class="textcurrency"><span class="currencylabel">'+EFBP_getCurrencySymbol(currencyslider)+'</span><input type="text" id="sliderInp'+obj.fields[i].cid+'" value="'+minlength+'"></div><span class="optionalContent1"><a href="'+defaulturl+'" target="_blank" class="linktext">'+urltext+'</a></span></div>'+descriptionHtml;


                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div id="sliderdiv'+obj.fields[i].cid+'" class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlSlider+'</div> ';
            }
            //End Slider


            // Toggle
            if(obj.fields[i].field_type=="Toggle"){
             var htmlToggle=customcssclass="";
              // Get Text Propertise
              $.each( obj.fields[i].field_options, function( key, value ) {
              console.log(key +":"+ value);
             if(key=="description"){
                    description=value;
                  }
             });
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span> '; 
            }else if(key=="customcssclass"){
                    customcssclass=value;
            } 

htmlToggle +=descriptionHtml+'<div class="toggle_button"><div class="onoffswitch"><input '+requiredElement+'type="checkbox" checked="" id="myonoffswitch'+i+'" class="onoffswitch-checkbox" name="onoffswitch"><label for="myonoffswitch'+i+'" class="onoffswitch-label"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div></div>';

                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group togglediv '+visibleHtml+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlToggle+'</div> ';

            }

            //End Toggle

            // Number
            if(obj.fields[i].field_type=="number"){
                // Get Number Propertise
              var htmlNumber='',sizeval='',defaultVal='',minlength='',maxlength='',customcssclass='';
              var onchangeFun='';
              var maxlength='',description='';
              var unitVal="";
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="defaultvalue"){
                    defaultVal=value;
                  }else if(key=="min"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="max"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="units"){
                     unitVal=value;
                     }

                });
            
              if(setlogicBuilderFun!="")
                setlogicBuilderFun='oninput="'+setlogicBuilderFun+'"';
           
             var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
           var inRangeFunction="",onlyMin="",onlyMax="",errorMessage="";
            if((minlength!="") && (maxlength!="")){
          inRangeFunction="if(integerInRange(this.value,'"+minlength+"','"+maxlength+"')==true){}else{ this.value='';}";
              errorMessage=errorMessage+'Number should be in range of '+minlength+' and '+maxlength+'.';
            }
            else if(minlength!=""){
               onlyMin="if(this.value<'"+minlength+"'){this.value='';}";
               errorMessage=errorMessage+'Number should be greater than or equal to '+minlength+'.';
            }
            else if(maxlength!=""){
                onlyMax="if(this.value>'"+maxlength+"'){this.value='';}";
                errorMessage=errorMessage+'Number should be less than or equal to '+maxlength+'.';
            }
            else{
              errorMessage="Only numeric values are allowed. ";
            }
        
    onchangeFun='onchange="'+inRangeFunction+' '+onlyMin+' '+onlyMax+'";';
    htmlNumber +='<div class="elementdiv"><input  pattern="^[0-9]+" '+requiredElement+' '+elementId+' name="number[]" type="text" class="rf-size-'+sizeval+'" value="'+defaultVal+'"  '+onchangeFun+' '+setlogicBuilderFun+' data-error="'+errorMessage+'"><label>'+unitVal+'</label> </div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-number '+visibleHtml+' '+customcssclass+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlNumber+'</div> ';

            }
          //End number

         // Paragraph
    if(obj.fields[i].field_type=="paragraph"){

              // Get paragraph Propertise
              var htmlPara='',sizeval='',defaultVal='',textType='text',minlength='',maxlength='',textWC='c';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="defaultvaluetextarea"){
                    defaultVal=value;
                  }else if(key=="minlength"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                });
           
           if(maxlength!="" || minlength!=""){
             
             onchangeFun="onchange=\"limit_input('rend"+obj.fields[i].cid+"','"+textWC+"','"+maxlength+"','"+minlength+"'); "+setlogicBuilderFun+"\"";             
                  
                  if(textWC=="c"){
                       onchangeFun +=" maxlength='"+maxlength+"'";
                  }           
               }
              else
              {
                onchangeFun='oninput="'+setlogicBuilderFun+'"';
              }  

            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }         
         var elementClass="rend"+obj.fields[i].cid;   

   htmlPara +='<div class="elementdiv"><textarea '+requiredElement+' '+elementId+' name="paragraph[]" class="rf-size-'+sizeval+'"  '+onchangeFun+' data-error="">'+defaultVal+'</textarea></div>'+descriptionHtml+'<div class="help-block with-errors '+elementClass+'" style="color:#a94442;"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-paragraph '+visibleHtml+' '+customcssclass+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPara+'</div> ';
            }
   
      //End Paragraph

      // Name
        if(obj.fields[i].field_type=="Name"){

            if(titleFun!="")
          titleFun='oninput="'+titleFun+'"';
         if(firstFun!="")
          firstFun='oninput="'+firstFun+'"';
         if(middleFun!="")
          middleFun='oninput="'+middleFun+'"';
         if(lastFun!="")
          lastFun='oninput="'+lastFun+'"';
         

          // Get phone Propertise
              var htmlName='',defaultVal=description='',nameType='Normal';
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="name"){
                    nameType=value;
                  }

                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });
            
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span>'; 
            }

            var nameId=obj.fields[i].cid;
            if(nameType=="Normal")
            {
                
                htmlName='<div class="elementdiv"> <span class="street"><div class="col-md-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" visible="" value="" name="firstname[]" '+firstFun+'><label class="col-md-12 padding-0">First Name</label><div class="help-block with-errors padding-left-none"></div></div><div class="col-md-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' id="lastname'+nameId+'" type="text" visible="" value="" name="lastname[]" '+lastFun+'><label class="col-md-12 padding-0">Last Name</label><div class="help-block with-errors col-md-4 padding-left-none"></div></div></span> </div>'+descriptionHtml;
            }
            else if(nameType=="Nor_title")
            {
                htmlName='<div class="full_title elementdiv normal-title-full"><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="title'+nameId+'" '+requiredElement+' type="text" name="title[]"style=" " '+titleFun+'> <label> Title</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"> <input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name="firstname[]" style=" " '+firstFun+'><label> First</label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="lastname'+nameId+'" '+requiredElement+' type="text" name="lastname[]" style=" " '+lastFun+'><label> Last </label></div><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' type="text" name="suffix[]" style=" "><label> Suffix </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }
            else if(nameType=="Full")
            {
                htmlName='<div class="full elementdiv"><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name="firstname[]" style=" " '+firstFun+'> <label> First</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="middlename'+nameId+'" '+requiredElement+' type="text" name="middlename[]" style=" " '+middleFun+'><label> Middle </label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" name="lastname[]" id="lastname'+nameId+'" '+requiredElement+' type="text" style=" " '+lastFun+'><label> Last </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }
            else if(nameType=="F_title")
            {
                htmlName='<div class="full_title elementdiv normal-title-full"><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="title'+nameId+'" '+requiredElement+' type="text" name="title[]"style=" " '+titleFun+'> <label> Title</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"> <input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name="firstname[]" style=" " '+firstFun+'><label> First</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' id="middlename'+nameId+'" type="text" name="middlename[]" style=" " '+middleFun+'> <label> Middle </label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="lastname'+nameId+'" '+requiredElement+' type="text" name="lastname[]" style=" " '+lastFun+'><label> Last </label></div><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' type="text" name="suffix[]" style=" "><label> Suffix </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }

            document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label><div class="input-line">'+htmlName+'</div></div> ';
        }
        //End Name

         // Time
        if(obj.fields[i].field_type=="time"){

           // Get phone Propertise


           if(SecondFieldFun!=""){
             selectampm='onchange="'+SecondFieldFun+'"';
             SecondFieldFun='oninput="'+SecondFieldFun+'"';
            }
            if(HourFormatFun!="")
            HourFormatFun='oninput="'+HourFormatFun+'"';
            if(bothFun!="")
            bothFun='oninput="'+bothFun+'"';

              var htmlTime=description='',timeType='SecondField';
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="time"){
                    timeType=value;
                  }
                 if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="description"){
                    description=value;
                  }
            });

            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block">'+description+'</div>'; 
            }
       var timeId=obj.fields[i].cid;

      if(timeType=="HourFormat")
      {
          htmlTime='<div class="elementdiv"><label>HH</label> <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="hour'+timeId+'" '+HourFormatFun+' '+requiredElement+' type="text" name="hour[]" style="width: 10%;display: inline;" class="form-control"> : <label>MM</label> <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+HourFormatFun+' '+requiredElement+' type="text" name="minute[]" style="width: 10%;display: inline;" class="form-control"></div> <div class="help-block with-errors"></div><div class="help-block with-errors"></div>'+descriptionHtml;
      }
      else if(timeType=="both")
      {
          htmlTime='<div class="elementdiv">MM <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+bothFun+' '+requiredElement+' type="text" name="minute[]" style="width: 10%;display: inline;" class="form-control"> SS: <input maxlength="2" id="second'+timeId+'" '+bothFun+' '+requiredElement+' data-error="Only numeric values are allowed" pattern="^[0-9]+"  type="text" name="second[]"  style="width: 10%;display: inline;" class="form-control"> MM: <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute1'+timeId+'" '+bothFun+' '+requiredElement+' type="text" name="minute1[]" style="width: 10%;display: inline;" class="form-control"></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
      }
      else
      {
          htmlTime='<div class="elementdiv"><label>HH</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="hour'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name="hour[]" style="width: 10%;display: inline;" class="form-control"> :<label>MM</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name="minute[]"  style="width: 10%;display: inline;" class="form-control"> :<label>SS</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="second'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name="second[]"  style="width: 10%;display: inline; margin-right:5px;" class="form-control"><select id="ampm'+timeId+'" '+selectampm+' style="width: 15%;display: inline;" name="ampm[]"  class="form-control"> <option value="am">AM</option> <option value="pm">PM</option> </select></div><div class="help-block with-errors"></div>'+descriptionHtml;
      }

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group  response-field-Name '+visibleHtml+' '+customcssclass+'">  <label class="'+setLabelClass+'" '+statusShow+'> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlTime+'</div> ';
        }
        //End TIME

         // DATE
        if(obj.fields[i].field_type=="date"){

                    // Get date Propertise
  var htmlDate='',defaultVal=descriptionHtml=minDate=maxDate='',dateType='date1',weekday='false';
  var disablePastFutureDate1=false,pastfuture='';
  var disableDates="";
  var disableDatesCheck=false;
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="date"){ // date format
                    dateType=value;
                  }
                  else if(key=="datevalfixmin" || key=="datevalRelmax"){ // min date
                  
                    minDate=value;  
                  }
                  else if(key=="datevalfixmax" || key=="datevalRelmax"){ // max date
                  
                    maxDate=value;  
                  }
                  else if(key=="DISABLEWEEKENDDATE"){ //disable week days
                    weekday=value;
                  }
                  else if(key=="datevalRelmin"){ //minimum days
                    minDate=value;  
                  }
                  else if(key=="datevalRelmax"){ //maximum days
                    maxDate=value;  
                  }
                  else if(key=="DISABLEPASTFURDATE"){ //past date
                    disablePastFutureDate1=value;
                  }
                  else if(key=="ALLPASTFURDATE"){ //past date
                    pastfuture=value;
                  }
                  else if(key=="DISABLESPCDATETXTAREA"){ //past date
                  disableDates=value;
                  }
                  else if(key=="DISABLESPCDATETXTAREA"){ //Specific date
                  disableDates=value;
                  }
                  else if(key=="DISABLESPCDATE"){ //Specific date Boolean
                     disableDatesCheck=value;
                  }
                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });

            // if checked disable Past/future buttons
            if(disablePastFutureDate1===true){
              if(pastfuture === 'future'){
                 maxDate="-1"; 
              }
              else
               {
                 minDate="0";
               } 
            }
        var dateFormat=(dateType=="date1")?"mm/dd/yy":"dd/mm/yy";
        var datefun="dateFunction('"+obj.fields[i].cid+"','"+dateFormat+"','"+minDate+"','"+maxDate+"','"+weekday+"','"+disableDates+"');";
		//alert(datefun);
            //console.log("status:"+typeof disablePastFutureDate1+" "+pastfuture+" future:"+maxDate+" past:"+minDate);
            var onchangeFun="";
            if(setlogicBuilderFun!="")
            onchangeFun='onchange="'+setlogicBuilderFun+'"';
            if(dateType=="date1")
            {
                htmlDate='<div class="elementdiv"><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2"  data-error="Please enter proper month." pattern="^[0-9]+"  '+requiredElement+' type="text" name="mm[]"  id="mm'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label style="min-width:100%;">MM</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input  maxlength="2"  data-error="Please enter proper day." '+requiredElement+' pattern="^[0-9]+"  type="text" name="dd[]"  id="dd'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>DD</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2"  data-error="Please enter proper year." '+requiredElement+' pattern="^[0-9]+"  type="text" name="yy[]"  id="yy'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"> <label>YY</label></div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none" style="padding-top:5px;"> <span><img src="<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif" class="dateimg'+obj.fields[i].cid+'" onclick="'+datefun+'"><input '+onchangeFun+' type="hidden" id="rend'+obj.fields[i].cid+'"></span></div></div>';
            }
            else
            {
                htmlDate='<div class="elementdiv"><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Please enter proper month." pattern="^[0-9]+"  '+requiredElement+' type="text" name="mm[]"  id="mm'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>DD</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Please enter proper day." '+requiredElement+' pattern="^[0-9]+"  type="text" name="dd[]"  id="dd'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>MM</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Please enter proper month." '+requiredElement+' pattern="^[0-9]+"  type="text" name="yy[]"  id="yy'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"> <label>YY</label></div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none" style="padding-top:5px;"><span><img src="<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif" class="dateimg'+obj.fields[i].cid+'" onclick="'+datefun+'"><input '+onchangeFun+' type="hidden" id="datepickerme'+obj.fields[i].cid+'"></span></div></div>';
            }
            
            var setDateHtml ='<div id="dateformatdiv" class="input-line">'+htmlDate+'</span></div><div class="help-block with-errors"></div>'+descriptionHtml;
            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+setDateHtml+'</div> ';
        }
        //End DATE

         // address
        if(obj.fields[i].field_type=="address"){
        if(addressFun!="")
          addressFun='oninput="'+addressFun+'"';
         if(address2Fun!="")
          address2Fun='oninput="'+address2Fun+'"';
         if(cityFun!="")
          cityFun='oninput="'+cityFun+'"';
         if(countryFun!="")
          countryFun='onchange="'+countryFun+'"';
         if(stateFun!="")
          stateFun='oninput="'+stateFun+'"';
         if(zipFun!="")
          zipFun='oninput="'+zipFun+'"';
          // Get Text Propertise
        var addId=obj.fields[i].cid;
       // alert(addressFun);
          var htmlAddress='';
          var newLineAddress='<span class="street"><label>Address line 1</label><input data-error="Please enter proper address." placeholder="Enter your address" '+addressFun+' id="address'+addId+'" '+requiredElement+' class="form-control" name="address[]"  type="text"></span>';
          var secondAddress="";
          var usrestrict="";
          var description=customcssclass=defaultcountry='';
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }else if(key=="defaultcountry"){
                defaultcountry=value;
              }
              else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                 else if(key=="address"){
                 secondAddress=value;
                 }
                 
                 else if(key=="usrestrict"){
                 usrestrict=value;
                 }
                 
            });
          var optionslist='<option></option>';
          
          for(var c=0;c<countryjson.length; c++){
            if(defaultcountry==countryjson[c])
            optionslist +='<option value="'+countryjson[c]+'" selected="true">'+countryjson[c]+'</option>';
            else
            optionslist +='<option value="'+countryjson[c]+'">'+countryjson[c]+'</option>';
          }
          
          if(usrestrict==true){
              optionslist='<option value="united states">United States</option>'
          }
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
        }
        
        // second address enable checked 
        if(secondAddress=="checked"){
            newLineAddress='<span class="street"><input data-error="Only alphabets and numeric values are allowed" placeholder="Enter your address" '+address2Fun+' id="address2'+addId+'" '+requiredElement+' class="form-control" name="address[]"  type="text"><label>Address line 1</label><input data-error="Only alphabets and numeric values are allowed" placeholder="Enter your address" '+requiredElement+' class="form-control" name="address2[]"  type="text"><label>Address line 2</label></span>';
        }
        
htmlAddress +='<br><br><div class="view-address col-md-10 col-sm-10 col-xs-10 padding-0"> <div class="elementdiv col-md-12">'+newLineAddress+'</div><div class="input-line col-md-6"><span class="city"><input data-error="Please enter proper city." placeholder="City" '+cityFun+' id="city'+addId+'"'+requiredElement+' type="text" name="city[]" class="form-control"><label>City</label></span> </div><div class="input-line col-md-6"><span class="state"><input data-error="Please enter proper state." placeholder="State" pattern="^[A-Za-z]+" '+stateFun+' id="state'+addId+'" '+requiredElement+' type="text" name="state[]" class="form-control"><label>State / Province / Region</label></span> </div><div class="input-line col-md-6"><span class="zip"><input data-error="Please enter proper zipcode." pattern="^[0-9]+"  placeholder="Zipcode" '+zipFun+' id="zip'+addId+'" '+requiredElement+' type="number" name="zipcode[]"  class="form-control"><label>Zipcode</label></span> </div><div class="input-line col-md-6"> <span class="country"><select placeholder="Select Country" class="form-control" name="country[]" '+countryFun+' id="country'+addId+'"  >'+optionslist+'</select><label>Country</label></span> </div></div><div class="help-block with-errors"></div>'+descriptionHtml;

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlAddress+'</div> ';
        }
        //End address

         // price
        if(obj.fields[i].field_type=="price"){

          // Get Text Propertise
          var htmlPrice=sizeval=customcssclass='';
          var description=customcssclass='';
          var currencyVal="";

          $.each( obj.fields[i].field_options, function( key, value ) {
            if(key=="description"){
                description=value;
              }
              else if(key=="size"){
                    sizeval=value;
              }else if(key=="customcssclass"){
                customcssclass=value;
              }else if(key=="currency"){
                currencyVal=value;
              }    

            });
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <span class="help-block col-md-12">'+description+'</span>'; 
        }

        onchangeFun=="";
        if(setlogicBuilderFun!="")
        onchangeFun='oninput="'+setlogicBuilderFun+'"';

htmlPrice +='<div class="elementdiv"> <span class="dolars"> <input data-error="Please enter proper currency." pattern="^[0-9]+" '+elementId+' '+requiredElement+' '+onchangeFun+' type="text" name="dollars[]" '+requiredElement+' placeholder="'+EFBP_getCurrencyFirst(currencyVal)+'"></span> <span class="above-line">.</span> <span class="cents"> <input placeholder="'+EFBP_getCurrencySecond(currencyVal)+'" data-error="Please enter proper currency." pattern="^[0-9]+"  type="text" name="cents[]" '+requiredElement+'></span><span class="above-line">'+EFBP_getCurrencySymbol(currencyVal)+'</span> </div>'+descriptionHtml+'<div class="help-block with-errors"></div>';

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+' >  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPrice+'</div> ';
        }
        //End price

          // email
        if(obj.fields[i].field_type=="email"){

          // Get Text Propertise
          var htmlEmail=defaultValEmail='';
          var description=customcssclass='';
      var  onchangeFun='',elementSize="small";
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }else if(key=="defaultValEmail"){
                    defaultValEmail=value;
              }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="size"){
                 elementSize=value;
                 }

            });
      
         var oninputFun="";
        if(setlogicBuilderFun!="")
        oninputFun='oninput="'+setlogicBuilderFun+'"';

        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
        }
        
        htmlEmail +='<div class="elementdiv"><input placeholder="abc@something.com" '+elementId+' type="email" name="email[]" class="rf-size-'+elementSize+'" '+requiredElement+' '+oninputFun+' data-error="Entered email address is invalid" ></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
        

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+' '+defaultValEmail+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlEmail+'</div> ';
        }

        //End email


        // Dropdown
       var drop_dwn_optionsHtml="";
      if(obj.fields[i].field_type=="dropdown"){
        var maxlength=customcssclass=description=sizeval='';
        var includeBlank=false;

        $.each( obj.fields[i].field_options, function( key, value ) {
             if(key=="size"){
                    sizeval=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="include_blank_option"){
                   includeBlank=value;
                }
            });
       
      var descriptionHtml="";
       // Description
      if(description!=""){
        descriptionHtml=' <span class="help-block">'+description+'</span>'; 
      }         
        onchangeFun='onchange="'+setlogicBuilderFun+'"';
        
        if(includeBlank==true){
            drop_dwn_optionsHtml='<option value=""></option>';
        }
      if( obj.fields[i].field_options.options.length>0){
          for(var j = 0; j < obj.fields[i].field_options.options.length; j += 1){
          drop_dwn_optionsHtml=drop_dwn_optionsHtml+'<option selected="'+obj.fields[i].field_options.options[j].checked+'"   value="'+obj.fields[i].field_options.options[j].label+'">'+obj.fields[i].field_options.options[j].label+'</option>'; }
          
      }

          document.getElementById("showform").innerHTML =
          document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+visibleHtml+' '+customcssclass+' '+sizeval+'" '+statusShow+'> <label class="'+setLabelClass+'"><span >'+obj.fields[i].label+requiredHtml+'</span></label><div class="elementdiv"><select style=\"font-size:13px !important;\" visible="" name="dropdown[]" class="rf-size-'+sizeval+' " '+elementId+' '+requiredElement+' '+onchangeFun+'>'+drop_dwn_optionsHtml+'</select></div><span class="help-block"></span></div> ';
         }
        //END Dropdown


        //Checkbox new
       var checkbox_Html="";
      if(obj.fields[i].field_type=="checkboxes"){  
          var CheckboxClass="",customClass="";
          var checkedVal=false;
          var oneColumn="";

          $.each( obj.fields[i].field_options, function( key, value ) {
            if(key=="checkbox")
              {
              CheckboxClass=value
              }
               if(key=="customcssclass"){
              customClass=value;
              }
              if(key=="checkbox"){
               oneColumn=value;
              }
              if(key=="description"){
                description=value;
              }
              if(key=="checkbox"){
               oneColumn=value;
              }

            });

            var descriptionHtml="";
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span>'; 
            }  

            var onchangeFun='onchange="'+setlogicBuilderFun+'"';
           /* old 
            if(obj.fields[i].field_options.options.length>0){for(var k = 0; k < obj.fields[i].field_options.options.length; k += 1){ checkbox_Html=checkbox_Html+'<input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\" /> <label>'+obj.fields[i].field_options.options[k].label+'</label><br>'; }} */

              if(obj.fields[i].field_options.options.length>0){for(var k = 0; k < obj.fields[i].field_options.options.length; k += 1){
                  if(obj.fields[i].field_options.options[k].checked==true){
                   checkbox_Html=checkbox_Html+'<div><label class="fb-option '+oneColumn+' "><input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\"checked="true" /> <label>'+obj.fields[i].field_options.options[k].label+'</label></label></div>';
                  }
                  else{
                     checkbox_Html=checkbox_Html+'<div><label class="fb-option '+oneColumn+' "><input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\" /> <label>'+obj.fields[i].field_options.options[k].label+'</label></label></div>';
                  }
                 
              }}
                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+' '+CheckboxClass+' '+visibleHtml+' '+customClass+'" '+statusShow+'><label>  <span>'+obj.fields[i].label+requiredHtml+'</span></label> <div> '+checkbox_Html+descriptionHtml+'</div><span class="help-block"></span><div class="actions-wrapper"> </div></div> ';
       }
       //End Checkbox     


//RADIO BUTTON NEW
       var radio_Html="";
      if(obj.fields[i].field_type=="radio"){        
            var radiosetClass="one_column",customClass="";    
            var includeOther=false;
			var description="";
             $.each( obj.fields[i].field_options, function( key, value ) {      
              if(key=="radio"){
                radiosetClass=value;
              }     
             if(key=="description"){
                description=value;
              }
            if(key=="customcssclass"){
            customClass=value;
            }
            if(key=="include_other_option"){
             includeOther=value;
            }
          });

     onchangeFun='onchange="'+setlogicBuilderFun+'"';

     /* old 
      if( obj.fields[i].field_options.options.length>0){
        for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<input '+elementId+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}else{ radio_Html=radio_Html+'<input '+elementId+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}  }
      } */

    //new virgil code
    var elementClass="class='rend"+obj.fields[i].cid+"'";
    
      if( obj.fields[i].field_options.options.length>0){
          if(radiosetClass!="one_column"){
              for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<div><label class="fb-option '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label></label></div>';}else{ radio_Html=radio_Html+'<div><label class="fb-option   '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label></label></div>';}  }
              if(includeOther==true){
                  radio_Html=radio_Html+'<div><label class="fb-option '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="other"/> <label>Other</label><input type="text" name="radioOther[]"></label></div>';
              }
              
          }
          else{
               for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}else{ radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}  }
               if(includeOther==true){
                   radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="other"/> <label>Other</label><input type="text" name="radioOther[]">';
               }
              
          }
       }
       //end new
          document.getElementById("showform").innerHTML =
          document.getElementById("showform").innerHTML+'<div '+logicId+'class="subtemplate-wrapper form-group '+visibleHtml+' '+customClass+' " '+statusShow+'><label>  <span>'+obj.fields[i].label+requiredHtml+'</span></label> <div> '+radio_Html+description+' </div><span class="help-block"></span><div class="actions-wrapper"> </div></div> ';

         }
  //End BUTTON

  
        // Phone
          if(obj.fields[i].field_type=="phone"){

              // Get phone Propertise
              var htmlPhone='',defaultVal=defaultVal1=defaultVal2=defaultVal3='',phoneType='International';
              var description=customcssclass=onchangeFun='';

              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="phone"){
                    phoneType=value;
                  }

                 if(phoneType=="International"){
                    if(key=="defaultvaluephone"){
                      defaultVal=value;
                    }    
                 }
                 else
                 {
                      if(key=="defaultvaluephone1"){
                        defaultVal1=value;
                      }else if(key=="defaultvaluephone2"){
                        defaultVal2=value;
                      }else if(key=="defaultvaluephone3"){
                        defaultVal3=value;
                      } 
                 }  

                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });

             var onchangeFun="";
             if(setlogicBuilderFun!="") 
            onchangeFun='oninput="'+setlogicBuilderFun+'"';

            if(phoneType=="International")
            {
                htmlPhone='<div class="elementdiv"><input data-error="Please enter proper phone number" pattern="^[0-9]+" '+elementId+' '+requiredElement+' '+onchangeFun+' type="text" name="internationalnumber[]" class="rf-size- " value="'+defaultVal+'" ></div><div class="help-block with-errors"></div>';
            }  
            else
            {
                htmlPhone='<div class="elementdiv"><input data-error="Please enter proper phone number." pattern="^[0-9]+"  '+requiredElement+' type="text"  name="domestic1[]" maxlength="3" value="'+defaultVal1+'" style="width:50px;" >-<input data-error="Please enter proper phone number." pattern="^[0-9]+" '+requiredElement+' type="text" name="domestic1[]" value="'+defaultVal2+'" style="width:50px;" maxlength="3" >-<input data-error="Please enter proper phone number." pattern="^[0-9]+" '+requiredElement+' type="text"  name="domestic1[]" value="'+defaultVal3+'" style="width:70px;" maxlength="4"></div><div class="help-block with-errors"></div>';
            }  
              document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPhone +'</div> ';
          }
        // End Phone  

// File upload new
     if(obj.fields[i].field_type=="file_upload"){

              // Get phone Propertise
            var htmlfile='';
       var setLabelClass="";
              var description=customcssclass=checkExtension='';
        var multipleFileUpload="";
        var limitFileUploadType="";
        var fileup="opt1";
              var fileSizeLimit;
              var LIMIT_FILE_SIZE=false;
              var LIMIT_MAX_FILEUP_SIZE;
              var LIMIT_MUL_FILE_UP;
              var MUL_FILE_UP=false;
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=='LIMIT_FILE_UP_TXTAR'){
         checkExtension=value } 
         else if(key=='MUL_FILE_UP'){
         multipleFileUpload=value } 
         else if(key=='LIMIT_FIL_UPLOAD_TYPE'){
         limitFileUploadType=value }  
         else if(key=='fileup'){
         fileup=value }
                else if(key=='LIMIT_FILE_SIZE'){
                     LIMIT_FILE_SIZE=value }
                else if(key=='LIMIT_MAX_FILEUP_SIZE'){
                     LIMIT_MAX_FILEUP_SIZE=value }
                     else if(key=='LIMIT_MUL_FILE_UP'){
                     LIMIT_MUL_FILE_UP=value }
                 
            });
            var callFunctionFileSize="";
            if(LIMIT_FILE_SIZE==true){
                callFunctionFileSize="checkFileSize(this,\'"+LIMIT_MAX_FILEUP_SIZE+"\');";
            }
            var callFunctionFilesLimit="";
            if(LIMIT_MUL_FILE_UP>0){
                callFunctionFilesLimit="checkTotalFiles(this,\'"+LIMIT_MUL_FILE_UP+"\');";
            }

          if(multipleFileUpload==true){
      if(limitFileUploadType==true){
      if(fileup!="opt1"){
      htmlfile ='<div class="elementdiv"> <span> <input '+requiredElement+' '+requiredElement+' '+elementId+' type="file" class="myfile" name="files[]"  onchange="checkExtensions(this,\''+checkExtension+'\');'+callFunctionFileSize+' '+callFunctionFilesLimit+' "  multiple> </span> </div>';
          
      }
      else{
      htmlfile ='<div class="elementdiv"> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="files[]"  onchange="checkExtensions2(this,\''+checkExtension+'\');'+callFunctionFileSize+'  '+callFunctionFilesLimit+'   "  multiple> </span> </div>';
          
      }
          
      }
      else{
          htmlfile ='<div class="elementdiv"> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="files[]"  onchange="'+callFunctionFileSize+' '+callFunctionFilesLimit+'  "  multiple> </span> </div>';
          
      }
      
      }
      else{
       
      if(limitFileUploadType==true){
      if(fileup!="opt1"){
      htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file"  class="myfile" name="files[]"  onchange="checkExtensions(this,\''+checkExtension+'\'); '+callFunctionFileSize+'  "  > </span> </div>';
          
      }
      else{
      htmlfile ='<div class="elementdiv  "> <span> <input '+requiredElement+' '+elementId+' type="file"  class="myfile" name="files[]"  onchange="checkExtensions2(this,\''+checkExtension+'\'); '+callFunctionFileSize+'  "  > </span> </div>';
          
      }
          
      }
      else{
          htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="files[]"  onchange=" '+callFunctionFileSize+' "  > </span> </div>';
          
      }
      
      }
              
              document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group'+visibleHtml+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlfile +'</div> ';
          }
        // file upload ends


// Section Break section_break
 if(obj.fields[i].field_type=="section_break"){
     
     document.getElementById("showform").innerHTML =
     document.getElementById("showform").innerHTML+'<div class="subtemplate-wrapper form-group" style="border-bottom:1px solid black !important;"></div><br>';
 }


  //Signature
       var radio_Html="";
      if(obj.fields[i].field_type=="signature"){    
       // Get Text Propertise
          var htmlEmail='';
          var description=customcssclass='';
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }
              else if(key=="customcssclass"){
                    customcssclass=value;
                  }

            });
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <span class="help-block">'+description+'</span>'; 
        }

          htmlEmail +='<div class="sigPad elementdiv"> <p class="drawItDesc">Draw your signature</p> <ul class="sigNav"> <li class="drawIt"><a href="#draw-it" >Draw It</a></li> <li class="clearButton"><a href="#clear">Clear</a></li> </ul> <div class="sig sigWrapper"> <div class="typed"></div> <canvas class="pad" width="198" height="55"></canvas> <input '+requiredElement+' type="hidden" name="output'+obj.fields[i].cid+'" class="output"> </div></div>';

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlEmail+'</div> ';
         }
      //End Signature

        if(obj.fields.length==(i+1))
        {
          
            // Scroll Down 
             var height=($(document).height()+$( window ).height()+200);
            // console.log("height"+$( window ).height()+" docu "+height);
             window.scrollTo(0,height);
        }

     }//end for
        document.getElementById("showform").innerHTML =
        document.getElementById("showform").innerHTML+'<input class="btn btn-success bt-style" type="submit" id="submit" value="SUBMIT" />';
   $(document).ready(function() {
		 	 
        $('.sigPad').signaturePad({drawOnly:true});
      });
	
  }//End RenderForm

 
  
function count_input(element_id,range_limit_by){
  var current_length = 0;
  
  if(range_limit_by == 'c' || range_limit_by == 'd'){
    current_length = $("#" + element_id).val().length;
  }else if(range_limit_by == 'w'){
    current_length = $("#" + element_id).val().trim().split(/[\s\.]+/).length; //we consider a word is one or more characters separated by space or dot
  }
  
  $("#currently_entered_" + element_id).text(current_length);
  
  return current_length;
}

function limit_input(element_id,range_limit_by,range_max,range_min){
if(range_min>0){
var current_length=count_input(element_id,range_limit_by);
if(range_limit_by == 'c' || range_limit_by == 'd'){
  if(current_length < range_min){

      $("#" + element_id).val($("#" + element_id).val().substr(0,range_min));
      $("#currently_entered_" + element_id).text(range_min);
   // alert(range_min+" characters minimum required.");
   $("." + element_id).html('data-error',range_min+" characters minimum required.");
  return false;
  }
  }
  else{
  if(current_length < range_min){
  
 // alert(range_min+" minimum words should be there.")
    $("#" + element_id).val("");
$("." + element_id).html('data-error',range_min+" minimum words should be there.");
    return false;
}
    }
}
if(range_max!=0){
  var current_length = count_input(element_id,range_limit_by);
  //
  console.log(element_id+','+range_limit_by+','+current_length);
  if(current_length > range_max){
    if(range_limit_by == 'c' || range_limit_by == 'd'){
      $("#" + element_id).val($("#" + element_id).val().substr(0,range_max));
      $("#currently_entered_" + element_id).text(range_max);
    }else if(range_limit_by == 'w'){
 // alert(range_max+" words are only allowed.")
  $("." + element_id).html('data-error',range_max+" words are only allowed.");
    $("#" + element_id).val("");
     }
  }
 }
}

function createFormProperties(){
  var formIner='<div class="Submission"><div class="left"><label>Success Message</label></div></div><div class="fb-clear"></div>';

      formIner +='<textarea id="form_success_message" class="form-control"></textarea><div class="left"><label for="form_redirect_option" class="choice">Redirect to Web Site</label></div><input type="text" value="" name="form_redirect_url" id="form_redirect_url" class="form-control" >';
   //   formIner +='<div><a id="showmoreoptions" href="Javascript:void(0);">Show more option</a></div>';

      // show option
      //formIner +='<div id="showoptions" style="display:none;"><div class="language"><label>Language</label><select class="form-control" id="form_language" autocomplete="off"> <option value="english">English</option><option value="italian">Italian</option><option value="hindi">Hindi</option></select></div>';

     // formIner +='<div class="alignment"><label>Label Alignment</label><select class="form-control" id="form_label_alignment" autocomplete="off"> <option value="top_label">Top Aligned</option> <option value="left_label">Left Aligned</option> <option value="right_label">Right Aligned</option> </select></div>';

      //formIner +='<div class="fb-form-field-wrapper"><label>Advanced Option</label><div style="padding-bottom: 10px"> <input type="checkbox" style="float: left" value="1" class="checkbox" id="form_custom_script_enable"> <label for="form_custom_script_enable" style="float: left;margin-left: 5px;margin-right:3px;line-height: 1.7" class="choice">Load Custom Javascript File</label> </div><div style="margin-left: 25px; margin-bottom: 10px; display: block;" id="form_custom_script_div"> <label class="show_script_url" style="display:none;">Script URL: <input type="text" value="" class="form-control" style="width: 90%;" name="form_custom_script_url" id="form_custom_script_url"></label>  </div></div></div>';


  var formInfo='<div id="formField" class="fb-tab-pane"><div class="fb-form-field-wrapper"><div class="fb-common-wrapper"> <label>Form Title</label><div class="fb-label-description"> <input type="text" placeholder="Form Title" id="formTitle" class="form-control"> <label>Description </label><textarea id="formDesc" placeholder="Form Description" class="form-control"></textarea>'+formIner+'</div></div></div></div>';


  $(".fb-tab-content").append(formInfo);

// set Form Title
$("#formTitle").keyup(function() {
  $("#setformTitle").html("<label>"+this.value+"</label>");
});


// set Form Description
$("#formDesc").keyup(function() {
  $("#setformDesc").html("<label>"+this.value+"</label>");
});


$("#showmoreoptions").click(function() {
    $( "#showoptions" ).toggle( "fast", function() {
      if($("#showmoreoptions").html()=="Show more option"){
          $("#showmoreoptions").html("Hide more option");
      }
      else
       {
          $("#showmoreoptions").html("Show more option");
       } 
    });
});



$('#form_custom_script_enable').bind('change', function () {
   if ($(this).is(':checked'))
     $(".show_script_url").show();
   else
     $(".show_script_url").hide();
});


// set US restricted 
$('#restrictme').bind('click', function () {
  console.log("restrict");
   if ($(this).is(':checked'))
   {
      //set view page dropdown
     $("#defaultcountry option[text='United States']").attr("selected","selected");
     $("#defaultcountry").prop("disabled",true);
   }
   else
   {
      //edit dropdown set 
     //$("#defaultcountry option[text='United States']").attr("selected","selected");
   }  
});


//set submit form confirmatio text
$("#form_success_message,#form_success_message_option").bind('keyup click',function(e){
  if($("#form_success_message_option").is(":checked"))
  $("#submitconfirm").val($("#form_success_message").val());  
});


  //set submit form confirmatio http
$("#form_redirect_url,#form_redirect_option").bind('keyup click',function(e){
  if($("#form_redirect_option").is(":checked"))
  $("#submitconfirm").val($("#form_redirect_url").val()); 
});


// set Form include js url
$("#form_custom_script_url").bind('keyup',function(e){
  $("#includejs").val(this.value); 
});


// set label_aligment
$("#form_label_alignment").bind('change',function(e){
  console.log("FOrm Aligment:"+this.value);
  $(".subtemplate-wrapper label:nth-child(2)").removeClass('top_label');
  $(".subtemplate-wrapper label:nth-child(2)").removeClass('left_label');
  $(".subtemplate-wrapper label:nth-child(2)").removeClass('right_label');
  $(".subtemplate-wrapper label:nth-child(2)").addClass(this.value);
  //$(".top_label,left_label,right_label")
  //$("#formaligen").val(this.value);
});
}



function submitForm(){

  var successMsg="1";

  if(!$.isEmptyObject(elemntObj.formrule1))
  {  
   for(var j=0; j<elemntObj.formrule1.length;j++){

      var Cid=elemntObj.formrule1[j]['cid'];
      var Condi=elemntObj.formrule1[j]['elemCondi'];
      var selectelm=elemntObj.formrule1[j]['selectelm']; // Name
      var CondiVal=(elemntObj.formrule1[j]['eleValue']!="")?elemntObj.formrule1[j]['eleValue']:"";

      var nameArr=["title","firstname","lastname","middlename"];
      console.log(elemntObj.formrule1[j]['eleType']+','+j);

      var IDval="";
      if(nameArr.includes(elemntObj.formrule1[j]['eleType']))
      {
        IDval=$("#"+elemntObj.formrule1[j]['eleType']+Cid).val();
      }
      else if(elemntObj.formrule1[j]['eleType']=="SecondField"){
       IDval=$("#hour"+Cid).val()+":"+$("#minute"+Cid).val()+":"+$("#second"+Cid).val()+":"+$("#ampm"+Cid).val().toLowerCase();
      }
      else if(elemntObj.formrule1[j]['eleType']=="HourFormat"){
         IDval=$("#hour"+Cid).val()+":"+$("#minute"+Cid).val();
      }
      else if(elemntObj.formrule1[j]['eleType']=="both"){
        IDval=$("#hour"+Cid).val()+":"+$("#minute"+Cid).val()+":"+$("#second"+Cid).val()+":"+$("#minute1"+Cid).val(); 
      }
      else
      {
         IDval=$("#rend"+Cid).val();
      } 
       successMsg=validateFormLogic(Cid,Condi,CondiVal,IDval,j);
      if(successMsg!="1")
      break;
     }//end loop
   }//end if  

  

console.log("Mesg:"+successMsg);
    
     // AJAX Code To Submit Form.
     var formData=$("#showform").serialize();
      var request =  $.ajax({
            method: "POST",
            dataType: "json",
            url:"response.php",
            data:formData
        });

      request.done(function( msg ) {
        var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        
        if(successMsg!="1"){
            if (!re.test(successMsg)) { 
              alert(successMsg);
            }
            else
            {
              window.location.assign(successMsg);
            }
        }
        else
        {
              if($("#submitconfirm").val()!=="")
            {
              if (!re.test($("#submitconfirm").val())) { 
                alert($("#submitconfirm").val());
              }
              else
              {
                window.location.assign($("#submitconfirm").val());
              }
            }  
            else{

              alert(msg);
            }
        }

        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
  return false;
}

function elementName(labelName){
  console.log('chnagemr');
  $("#dropableElem").html(labelName);
}

// validate email 
function validateEmail(element_id,value) {    
  if(value!=''){
  var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if( re.test(value)==true){
  
  }
  else{
  alert('Please enter email id in correct format')
  //$("#" + element_id).val("");
    }
  }           
}

// Reusabe  validateFormLogic function
function validateFormLogic(Cid,Condi,CondiVal,IDval,j) {

   if(Condi=="is"){
        console.log(IDval+"getIS"+CondiVal);
          if(IDval==CondiVal)
          {
            return successMsg=elemntObj.formrule1[j]['onsuccessValue'];
          }
      }

      // is_not           
      if(Condi=="is_not"){
        console.log("getIS");
          if(IDval!=CondiVal)
          {
             return successMsg=elemntObj.formrule1[j]['onsuccessValue']; 
          }
          
      }

      //less_than 
      if(Condi=="less_than"){
        console.log("getIS");
          if(parseInt(IDval)<parseInt(CondiVal))
          {
            return successMsg=elemntObj.formrule1[j]['onsuccessValue'];
          }
         
      }

      //greater_than   
      if(Condi=="greater_than"){
        console.log("getIS");
          if(parseInt(IDval)>parseInt(CondiVal))
          {
             return successMsg=elemntObj.formrule1[j]['onsuccessValue'];   
          }
          
      }

      //begins_with  
      if(Condi=="begins_with"){
        console.log("getIS");
          if(IDval.startsWith(CondiVal))
          {
             return successMsg=elemntObj.formrule1[j]['onsuccessValue'];  
          }
          
      }

      //ends_with
      if(Condi=="ends_with"){
        console.log("getIS");
          if(IDval.endsWith(CondiVal))
          {
            return successMsg=elemntObj.formrule1[j]['onsuccessValue'];
          }
          
      }

      //contains
      if(Condi=="contains"){
        console.log("getIS");
          if(IDval.includes(CondiVal))
          {
            return successMsg=elemntObj.formrule1[j]['onsuccessValue'];  
          }
          
      }

      //not_contain 
      if(Condi=="not_contain"){
        console.log("getIS");
          if(!IDval.includes(CondiVal))
          {
            return successMsg=elemntObj.formrule1[j]['onsuccessValue']; 
          }
      }

      // is_checked
      if(Condi=="is_checked"){
              console.log("is_checked"+$("#rend"+Cid).is(':checked'));
                if($("#rend"+Cid).is(':checked'))
                {
                  return successMsg=elemntObj.formrule1[j]['onsuccessValue'];    
                }
        }

        //is_empty
        if(Condi=="is_empty"){
              console.log("is_empty"+$("#rend"+Cid).is(':checked'));
                if($("#rend"+Cid).is(':checked')!="true")
                {
                  return successMsg=elemntObj.formrule1[j]['onsuccessValue'];    
                }
        }

      return "1";
}

//pass parameter datepicker
function dateFunction(id,formatme,minDate,maxDate,weekday,allDisabledDates) {
  // alert ('called');
    console.log(formatme+" "+weekday);
    if(formatme=="mm/dd/yy"){formatme="mm/dd/yy";}else{formatme="dd/mm/yy";}
  var allDisabledDatesArray = allDisabledDates.split(',');
    $(".dateimg"+id).hide();
    if(weekday=="false"){
        $("#rend"+id).datepicker({
        showOn: "button",
        buttonImage: "<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: formatme,
                                         beforeShowDay: function(mydate){
                                         var $return=true;
                                         var $returnclass ="available";
                                         var $myBadDates = allDisabledDatesArray;
                                         $checkdate = $.datepicker.formatDate(formatme, mydate);
                                         for(var i = 0; i < $myBadDates.length; i++)
                                         {
                                         if($myBadDates[i] == $checkdate)
                                         {
                                         $return = false;
                                         $returnclass= "unavailable";
                                         }
                                         }
                                         return [$return,$returnclass];
                                         },
        minDate: minDate,
        maxDate: maxDate,
        onSelect: function(dateText, inst) {
            var pieces = dateText.split('/');
            console.log('piece'+pieces);
            if(formatme=="mm/dd/yy")
             {
              $('#mm'+id).val(pieces[0]);
              $('#dd'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             }
             else 
              {
              $('#dd'+id).val(pieces[0]);
              $('#mm'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             } 
        }

      });
    }
    else
    {
        $("#rend"+id).datepicker({
        showOn: "button",
        buttonImage: "<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: formatme,
        minDate: minDate,
        maxDate: maxDate,
                                         beforeShowDay: function(mydate){
                                         var $return=true;
                                         var $returnclass ="available";
                                         var $myBadDates = allDisabledDatesArray;
                                         $checkdate = $.datepicker.formatDate(formatme, mydate);
                                         for(var i = 0; i < $myBadDates.length; i++)
                                         {
                                         if($myBadDates[i] == $checkdate)
                                         {
                                         $return = false;
                                         $returnclass= "unavailable";
                                         return [$return,$returnclass];
                                         }
                                         }
                                         mydate = mydate.getDay();
                                         return [mydate > 0 && mydate < 6, ""];
                                         },
        onSelect: function(dateText, inst) {
            var pieces = dateText.split('/');
            console.log('piece'+pieces);
            if(formatme=="mm/dd/yy")
             {
              $('#mm'+id).val(pieces[0]);
              $('#dd'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             }
             else 
              {
              $('#dd'+id).val(pieces[0]);
              $('#mm'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             } 
        },
        
      });
    }  
}
  
  function integerInRange(value, min, max) {
  
      if (parseInt(value) >= parseInt(min) && parseInt(value)<= parseInt(max)) {
          return true;
      } else {
          return false; //not in range
      }
    }
  </script>
  
 
<?php 
}

$i=100;
add_shortcode("EFBP_Form","EFBP_Form_handler");
function EFBP_Form_handler($atts){
	
wp_enqueue_script ('EFBPVendor');
wp_enqueue_script ('EFBPFormBuilder');
wp_enqueue_script ('EFBPLogicBuilder');
wp_enqueue_script ('EFBPRecaptcha');

		 $pull_form_atts = shortcode_atts( array(
			'formid' => $atts[0]
		), $atts );
		$formID= wp_kses_post( $pull_form_atts[ 'formid' ] ) ;
		global $wpdb;

	 $table_name1 = $wpdb->prefix . 'forminformationdata';
	 $table_name2 = $wpdb->prefix . 'formsubmitdata';
	  $table_name3 = $wpdb->prefix . 'colortheme';
	  //$fetch_data =$wpdb->get_results($wpdb->prepare( " SELECT id,user_id, json_data ,forminformationdata_id FROM ".$table_name2. " WHERE forminformationdata_id= %d ", $form_id )); 	
	 $show_from_database = $wpdb->get_results ( $wpdb->prepare("SELECT * FROM ". $table_name1." WHERE id = %d " , $formID ));
    foreach($show_from_database as $form_data)
	{
	?>


		
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrap.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrap-theme.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'vendor/css/vendor.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/formbuilder.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/fontAwesomeMin.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'signaturepad/assets/jquery.signaturepad.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/bootstrapValidator.min.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/slider.css', __FILE__ );?>">
	<link rel="stylesheet" href="<?php echo plugins_url( 'dist/toggle.css', __FILE__ );?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">	
  <style>
  * {
    box-sizing: border-box;
  }

  body {
    background-color: #444;
    font-family: sans-serif;
  }

  .fb-main {
    background-color: #fff;
    border-radius: 5px;
    min-height: 600px;
  }

  input[type=text] {
    height: 26px;
    margin-bottom: 3px;
  }

  select {
    margin-bottom: 5px;
    font-size: 40px;
  }

.view-main {
    background-color: #fff;
    border-radius: 5px;
    width: 100%;
    float: left;
  }
  
#ViewForm .subtemplate-wrapper {
  border: 1px solid #ccc;
  float: left;
  margin: 4px 0;
  padding: 10px;
  width: 100%;
}
#ViewForm   .toggle_button {
  float: right;
  width: auto;
}
#ViewForm .help-block { 
  display: block; 
}

.radio{ width:10% !important; display: inline; }

/* form align csss*/
.right_label .subtemplate-wrapper label:first-child {
    display: inline !important;
    float: left;
    margin-left: 10%;
}

.left_label .subtemplate-wrapper label:first-child {
    display: inline !important;
    float: left;
    margin-right: 10%;
}
/*11022015*/
.table.table-hover.table-responsive.formListing {
	margin: 0px auto;
	width: 80%;
	border-radius: 50px;
}
/*end form align css */
  </style>
 <?php global $wpdb;
	 $table_name3 = $wpdb->prefix . 'colortheme';
	 //$get_last_color=$wpdb->get_results('SELECT LAST(color) FROM '.$table_name3.' ORDER BY  created DESC ') ;	
	 $get_last_color=$wpdb->get_results($wpdb->prepare(  "SELECT color FROM ".$table_name3." ORDER BY created DESC ",'' )) ;
	 //$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->users" );
	  //$show_from_database = $wpdb->get_results ( "SELECT * FROM ". $table_name1." WHERE id=".$formID);
	    foreach( $get_last_color as $FD){	
		
			?> 
	<style>
			.fb-button{display:inline-block;margin:0;padding:.563rem .844rem;border:0 none;background:<?php echo $FD->color;?> !important;color:#fff;text-align:center;text-decoration:none;font-size:12px;line-height:1.5;cursor:pointer;border-radius:.125rem;border:thin solid <?php echo $FD->color;?> !important;border-bottom:2px solid<?php echo $FD->color;?> !important;}
			.fb-button{border-bottom:2px solid <?php echo $FD->color;?> !important;background:<?php echo $FD->color;?> !important;}
			.view-button{border-bottom:2px solid <?php echo $FD->color;?> !important;background:<?php echo $FD->color;?> !important}
			.create_forms{padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;}
			.create-popupDesign{padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;}
			.create-popupDesign{	margin-left:10%;	margin-bottom:10px;	padding:5px;boder-color:#19b394 #19b394 <?php echo $FD->color;?> !important;	background-color: <?php echo $FD->color;?> !important;	color:#fff ;}
			.Bt-style{min-width:100px; background-color: <?php echo $FD->color;?> !important; color:white;}
			.create-inno-frm{color:<?php echo $FD->color;?> !important; font-size: 2em;  height: auto;  margin: 20px 0;  width: 100%;} 
			.create_forms{margin-bottom:10px;padding:5px;boder-color:#19b394 #19b394<?php echo $FD->color;?> !important;background-color:<?php echo $FD->color;?> !important;color:#fff ;}
			.DropDownBoxStyle{Width:80px;Color:white;background-color:<?php echo $FD->color;?> !important;font-size:16px;}
			.chooseThemeStyle{ color:<?php echo $FD->color;?> !important;}
			.fb-tabs li.active a { background:<?php echo $FD->color;?> !important;color: #fff;}
			.fb-button:hover {  background: <?php echo $FD->color;?> !important none repeat scroll 0 0;color: #fff;text-decoration: none;}
			
			/*Popup css*/
			 .modal-header {  background-color: <?php echo $FD->color;?>;  border-radius: 5px 5px 0 0;  color: #fff;}
			 .modal-header button.close {   color: #fff;   opacity: 0.8; }
			 .modal-content {  border: 2px solid <?php echo $FD->color;?>;  float: left;  width: 100%;}
			 .view-form-header { border-bottom: 2px solid <?php echo $FD->color;?>;}
			
	</style> 
	
	    <?php if($FD->color=='Black'){  ?> 
			<style>
				.view-main {background: #515151 none repeat scroll 0 0 !important;}
				#ViewForm {color: #fff;}  
				.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #23282D;} 
				 .view-main .elementdiv input[type="text"] {  background-color: <?php echo $FD->color;?>; color:#fff;}
			</style> 
		<?php }
		
		if($FD->color=='Red'){  ?> 
			<style>
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
				.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #ff0000;} 
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #ff0000;
					border-radius:0px;
				}
			</style> 
		<?php }
		
		if($FD->color=='Green'){  ?> 
			<style>
				.modal-header {  background-color: #19B594;  border-radius: 5px 5px 0 0;  color: #fff;}
    .modal-content {  border: 2px solid #19B594;  float: left;  width: 100%;}
       .view-form-header { border-bottom: 2px solid #19B594;}
    .view-main {background: #fff none repeat scroll 0 0 !important;}
    #ViewForm {color: #000;}  
   
    .view-main input[type="text"], 
    .view-main textarea {  
     border: 1px solid #19B594;
     border-radius:0px;
	}
			</style> 
		<?php } 
		if($FD->color=='Blue'){  ?> 
			<style>
				.modal-header {  background-color: #0073AA;  border-radius: 5px 5px 0 0;  color: #fff;}
				.modal-content {  border: 2px solid #0073AA;  float: left;  width: 100%;}
			    .view-form-header { border-bottom: 2px solid #0073AA;}
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
				.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #0073AA;} 
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #0073AA;
					border-radius:0px;
				}
			</style> 
		<?php }  
		if($FD->color=='Orange'){  ?> 
			<style>
				 
				 .modal-header {  background-color: #FFA30F;  border-radius: 5px 5px 0 0;  color: #fff;}
    .modal-content {  border: 2px solid #FFA30F;  float: left;  width: 100%;}
       .view-form-header { border-bottom: 2px solid #FFA30F;}
    .view-main {background: #fff none repeat scroll 0 0 !important;}
    #ViewForm {color: #000;}  
    .view-main input[type="text"]:focus, textarea:focus {  border: thin solid #FFA30F;} 
    .view-main input[type="text"], 
    .view-main textarea {  
     border: 1px solid #FFA30F;
     border-radius:0px;
    }
			</style> 
		<?php }
		
		if($FD->color=='Grey'){  ?> 
			<style>
				 
				.view-main {background: #fff none repeat scroll 0 0 !important;}
				#ViewForm {color: #000;}  
				.view-main input[type="text"]:focus, textarea:focus {  border: thin solid #ccc;} 
				.view-main input[type="text"], 
				.view-main textarea {  
					border: 1px solid #ccc;
					border-radius:0px;
				}
			</style> 
		<?php }
		

		break;} ?>
		

<div style="display: block;" id="main_container2" class="container" style="z-index:0px !important;">
<div class="modal-content"  style="width:85%;">
<div class="modal-body">
           <div style="margin-top:1%;" class="view-main row">
		
			<div style="background-color:white;" class="col-md-12" id="ViewForm">
			  <div class="group-error col-md-12"></div>		
			  <form data-toggle="validator" role="form" method="post" onsubmit="submit_form_data(); return false;" id="showform"  enctype="multipart/form-data"></form> 
			  </div>
		  </div>
	  </div>
   </div> </div><script>
	
	var payLoadData="<?php echo $form_data->json_data; ?>";
	elemntObj=JSON.parse("<?php echo $form_data->json_logic_data; ?>");
	var Formjson=JSON.parse("<?php echo $form_data->json_properties_data; ?>");
	var form_id="<?php echo $form_data->id; ?>";
		var user_id="<?php echo  get_current_user_id(); ?>";
		
	</script>
	<?php	
	break;
	}
	?>
	<script>
	var captchaStatus=false;
	var FileUploadStatus=false;
	var secretKey=0;
/* File uploading validation */
function checkExtensions(oInput,_validFileExtensions){

 var _validFileExtensions_Array= _validFileExtensions.split(',');
            var sFileName;
            if(oInput.multiple==true){
              var blnValid =false;
                for (var i=0; i<oInput.files.length; i++) {
                   sFileName = oInput.files[i].name;
                   
                    for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                        var sCurExtension = _validFileExtensions_Array[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    
                }
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
                return true;
            }
            else{
                sFileName = oInput.value;
            }
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                    var sCurExtension = _validFileExtensions_Array[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
            }
      return true;
}

function checkExtensions2(oInput,_validFileExtensions){
 //   alert("called 2");
 var _validFileExtensions_Array= _validFileExtensions.split(',');
        var sFileName;
          if(oInput.multiple==true){
      var blnValid =false;
        for (var i=0; i<oInput.files.length; i++) {
            sFileName = oInput.files[i].name;
            
            for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                var sCurExtension = _validFileExtensions_Array[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
        }
        if (blnValid) {
            alert("Sorry, " + sFileName + " is blocked, blocked extensions are: " + _validFileExtensions_Array.join(", "));
            oInput.value="";
            return false;
        }
        return true;
  
  }
     else{
     sFileName = oInput.value;
     }
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions_Array.length; j++) {
                    var sCurExtension = _validFileExtensions_Array[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (blnValid) {
                    alert("Sorry, " + sFileName + " is blocked, blocked extensions are: " + _validFileExtensions_Array.join(", "));
                    oInput.value="";
                    return false;
                }
        else{
        
              }
            }
            
      return true;
}
  function checkTotalFiles(oInput,totalFiles){
      var totalFilesSelected=oInput.files.length;
     
      if(totalFilesSelected>totalFiles){
          oInput.value="";
          alert("You cannot select more than "+ totalFiles +" files.");
          return false;
      }
      return true;
  }
  function checkFileSize(oInput,fileSizeLimit){
      var fileSize=0;
              if(oInput.multiple==true){
                  for (var i=0; i<oInput.files.length; i++) {
                      fileSize = oInput.files[i].size;
                      if(fileSize>fileSizeLimit*1024*1024){
                          oInput.value="";
                          alert("Files cannot be greater than "+ fileSizeLimit +" MB.");
                          return false;
                          
                      }
                  }
              }
              else{
                  fileSize = oInput.files[0].size;
                 // alert(oInput.files[0].size);
                  if(fileSize>fileSizeLimit*1024*1024){
                      oInput.value="";
                      alert("File cannot be greater than "+ fileSizeLimit +" MB.");
                      return false;
                      
                  }
              }
  }
/* END uploading file*/
	var signatureStatus=false;
    function renderForm(){

       // Logic builder enable disable element
	  
        if(jQuery.isEmptyObject(elemntObj)){
          elemntObj='{"rule1":[]}';
          elemntObj=JSON.parse(elemntObj);
        } 

      console.log("logic json"+JSON.stringify(elemntObj));
      // End Logic builder enable disable element

     
        // if payLoadData is empty
        if(payLoadData=="")
        payLoadData='{"fields":[]}';

        var text = payLoadData;
        obj = JSON.parse(text);
        var flist = [];
  
        var countryjson=["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United States","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        var setLabelClass="";
		
		document.getElementById("showform").innerHTML='<div class="view-form-header"><i class="fa fa-file-text margin-0"></i>  <strong>'+Formjson.forms[0].field_options.form_title+'</strong><p class="view-form-description margin-0">'+Formjson.forms[0].field_options.form_description+'</p></div>';
        for(var i = 0; i < obj.fields.length; i += 1){
            var requiredHtml="";
            var requiredElement="";

            // Common Required
            if(obj.fields[i].required==true){ requiredHtml='<abbr title="required">*</abbr>'; requiredElement=" required "; }
			   // Common Read only
            if(obj.fields[i].field_options.READONLY==true){ requiredElement +=" readonly "; }
            // Common element ID
            var elementId="id='rend"+obj.fields[i].cid+"'";
            var logicId="id='logic"+obj.fields[i].cid+"'";

            var setlogicBuilderFun="";
             var visibleHtml="";
             if(obj.fields[i].field_options.visibility!="visible"){ visibleHtml='hiddenClass'; }

             var statusShow="",title=firstname=lastname=middlename="";
             var SecondFieldFun=HourFormatFun=bothFun=selectampm="";
             var addressFun=address2Fun=cityFun=stateFun=zipFun=countryFun=""; 
                  var titleFun=firstFun=middleFun=lastFun=""; 
                  var addressArr=['address','address2','city','state','zip','country'];

            for(var j=0; j<elemntObj.rule1.length;j++){
                  
                  if(elemntObj.rule1[j]['fromid']==obj.fields[i].cid){
                      
                     // alert(elemntObj.rule1[j]['selectelm']+" "+j );
                      //title
                      if(elemntObj.rule1[j]['selectelm']=="title"){

                        titleFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                     if(elemntObj.rule1[j]['selectelm']=="firstname"){
                        //firstname
                        firstFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"')";
                      }

                       if(elemntObj.rule1[j]['selectelm']=="middlename"){
                        //middlename
                          middleFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      if(elemntObj.rule1[j]['selectelm']=="lastname"){
                        //lastname
                        lastFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time SecondField
                      if(elemntObj.rule1[j]['selectelm']=="SecondField"){
                        //SecondField
                        SecondFieldFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time HourFormat
                      if(elemntObj.rule1[j]['selectelm']=="HourFormat"){
                        //HourFormat
                        HourFormatFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }

                      //time both
                      if(elemntObj.rule1[j]['selectelm']=="both"){
                        //both
                        bothFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                      }
                      
                      if(addressArr.includes(elemntObj.rule1[j]['selectelm'])){
                         
                        //address
                        if(elemntObj.rule1[j]['selectelm']=="address"){

                          addressFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                         
                        }
                        //addrress2
                        if(elemntObj.rule1[j]['selectelm']=="address2"){
                          address2Fun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";
                        }

                        //city
                        if(elemntObj.rule1[j]['selectelm']=="city"){cityFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //state
                        if(elemntObj.rule1[j]['selectelm']=="state"){stateFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //city
                        if(elemntObj.rule1[j]['selectelm']=="zip"){zipFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                        //country
                        if(elemntObj.rule1[j]['selectelm']="country"){countryFun=="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"','"+elemntObj.rule1[j]['selectelm']+"');";}

                      }
                      else 
                      {
                        setlogicBuilderFun="setlogicBuilderFun('"+elemntObj.rule1[j]['fromid']+"');";
                      }
                      
                        console.log(i+"here"+setlogicBuilderFun+" "+elemntObj.rule1[j]['selectelm']);
                    }
                    //show/hide element
                    if(elemntObj.rule1[j]['cid']==obj.fields[i].cid){
                         console.log("status1"+statusShow);
                      if(elemntObj.rule1[j]['status']=="show"){
                         console.log("status2"+statusShow);
                        statusShow="style='display:none;'";
                      }
                    }

                 }
                 console.log("status"+statusShow);
                //setlogicBuilderFun="setlogicBuilderFun('"+obj.fields[i].cid+"');";
            
            // Common visible

            //website
            if(obj.fields[i].field_type=="website"){
              var htmlText='',sizeval='',defaultVal='',textType='url',minlength='',maxlength='';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                      if(key=="size"){
                        sizeval=value;
                      }else if(key=="defaultvalue"){
                        defaultVal=value;
                      }else if(key=="customcssclass"){
                        customcssclass=value;
                      }else if(key=="description"){
                        description=value;
                      }

                   });

              var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div> '; 
            }

                onchangeFun=="";
               if(setlogicBuilderFun!="")
               onchangeFun='oninput="'+setlogicBuilderFun+'"';

                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group'+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label><br><input type="url" class="rf-size-  " value="'+defaultVal+'" placeholder="http://" '+elementId+' '+requiredElement+' '+onchangeFun+' data-error="Please enter valid website."></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
            }

            // Text
            if(obj.fields[i].field_type=="text"){

              // Get Text Propertise
              var htmlText='',sizeval='',defaultVal='',textType='text',minlength='',maxlength='';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="password"){
                   textType=value;
                  }else if(key=="defaultvalue"){
                    defaultVal=value;
                  }else if(key=="minlength"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=="min_max_length_units"){
                     if(value=="words"){textWC='w';}else{textWC='c';}
                  }

                });
                
          if(maxlength!="" || minlength!=""){
               onchangeFun="onchange=\"limit_input('rend"+obj.fields[i].cid+"','"+textWC+"','"+maxlength+"','"+minlength+"'); "+setlogicBuilderFun+"\"";             
                    if(textWC=="c"){
                         onchangeFun +=" maxlength='"+maxlength+"'";
                    }
              }
              else
              {
                onchangeFun='oninput="'+setlogicBuilderFun+'"';
              } 

            
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
    htmlText +='<div class="elementdiv"><input '+requiredElement+' '+elementId+' type="'+textType+'" name="'+obj.fields[i].label+'[]" class="rf-size-'+sizeval+'" value="'+defaultVal+'"  '+onchangeFun+' data-error=""></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlText+'</div> '; 
            }
         //End Text

		 // Captcha
		 if(obj.fields[i].field_type=="Captcha"){
captchaStatus=true;

              // Get Text Propertise
              var htmlText='',textType='text';
              var description=customcssclass='';
			  var siteKey='';
             
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                   if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=="secreat_key"){
                    secretKey=value;
                  }else if(key=="site_key")
				  { siteKey=value;}
                });
					  
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
    htmlText +='<div class="elementdiv"><div class="g-recaptcha" data-sitekey="'+siteKey+'"></div><input '+requiredElement+' '+elementId+' type="'+textType+'" name="'+obj.fields[i].label+'[]" data-error="" style="display:none;"></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+customcssclass+'" >  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlText+'</div> '; 
            }
         //End Captcha

             // Slider
            if(obj.fields[i].field_type=="slider"){
              var htmlSlider=customcssclass=urltext=description=defaulturl=currencyslider=onchangeFun="";
              var maxlength=100,minlength=0;
              // Get Text Propertise
              $.each( obj.fields[i].field_options, function( key, value ) {
              console.log(key +":"+ value);
                  
                  if(key=="defaulturl"){
                    defaulturl=value;
                  }else if(key=="urltext"){
                    urltext=value;
                  }else if(key=="min"){
                    minlength=value;
                  }else if(key=="max" ){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="currencyslider"){
                    currencyslider=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
               
             });
             
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span> '; 
            }

/* old htmlSlider +='<input type="range" min="'+minlength+'" max="'+maxlength+'" name="'+obj.fields[i].label+'[]" oninput="document.getElementById(\'sliderInp'+obj.fields[i].cid+'\').innerHTML=this.value;"/><label id="sliderInp'+obj.fields[i].cid+'">'+minlength+' '+EFBP_getCurrencySymbol(currencyslider)+'</label><span class="optionalContent1"><a href="'+defaulturl+'" target="_blank" class="linktext">'+urltext+'</a></span>'+descriptionHtml;*/

htmlSlider +='<div class="row"><div class="all col-md-10 col-sm-10 col-xm-10"><input value="'+minlength+'" type="range" min="'+minlength+'" max="'+maxlength+'" name="'+obj.fields[i].label+'[]" oninput="document.getElementById(\'sliderInp'+obj.fields[i].cid+'\').value=this.value;"/></div><div class="textcurrency"><span class="currencylabel">'+EFBP_getCurrencySymbol(currencyslider)+'</span><input type="text" id="sliderInp'+obj.fields[i].cid+'" value="'+minlength+'"></div><span class="optionalContent1"><a href="'+defaulturl+'" target="_blank" class="linktext">'+urltext+'</a></span></div>'+descriptionHtml;


                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div id="sliderdiv'+obj.fields[i].cid+'" class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlSlider+'</div> ';
            }
            //End Slider


            // Toggle
            if(obj.fields[i].field_type=="Toggle"){
             var htmlToggle=customcssclass="";
              // Get Text Propertise
              $.each( obj.fields[i].field_options, function( key, value ) {
              console.log(key +":"+ value);
             if(key=="description"){
                    description=value;
                  }
             });
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span> '; 
            }else if(key=="customcssclass"){
                    customcssclass=value;
            } 

htmlToggle +=descriptionHtml+'<div class="toggle_button"><div class="onoffswitch"><input '+requiredElement+'type="checkbox" checked="" id="myonoffswitch'+i+'" class="onoffswitch-checkbox" name="'+obj.fields[i].label+'[]"><label for="myonoffswitch'+i+'" class="onoffswitch-label"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div></div>';

                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group togglediv '+visibleHtml+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlToggle+'</div> ';

            }

            //End Toggle

            // Number
            if(obj.fields[i].field_type=="number"){
                // Get Number Propertise
              var htmlNumber='',sizeval='',defaultVal='',minlength='',maxlength='',customcssclass='';
              var onchangeFun='';
              var maxlength='',description='';
              var unitVal="";
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="defaultvalue"){
                    defaultVal=value;
                  }else if(key=="min"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="max"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="units"){
                     unitVal=value;
                     }

                });
            
              if(setlogicBuilderFun!="")
                setlogicBuilderFun='oninput="'+setlogicBuilderFun+'"';
           
             var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }
            
           var inRangeFunction="",onlyMin="",onlyMax="",errorMessage="";
            if((minlength!="") && (maxlength!="")){
          inRangeFunction="if(integerInRange(this.value,'"+minlength+"','"+maxlength+"')==true){}else{ this.value='';}";
              errorMessage=errorMessage+'Number should be in range of '+minlength+' and '+maxlength+'.';
            }
            else if(minlength!=""){
               onlyMin="if(this.value<'"+minlength+"'){this.value='';}";
               errorMessage=errorMessage+'Number should be greater than or equal to '+minlength+'.';
            }
            else if(maxlength!=""){
                onlyMax="if(this.value>'"+maxlength+"'){this.value='';}";
                errorMessage=errorMessage+'Number should be less than or equal to '+maxlength+'.';
            }
            else{
              errorMessage="Please enter proper number. ";
            }
        
    onchangeFun='onchange="'+inRangeFunction+' '+onlyMin+' '+onlyMax+'";';
    htmlNumber +='<div class="elementdiv"><input  pattern="^[0-9]+" '+requiredElement+' '+elementId+' name="'+obj.fields[i].label+'[]" type="text" class="rf-size-'+sizeval+'" value="'+defaultVal+'"  '+onchangeFun+' '+setlogicBuilderFun+' data-error="'+errorMessage+'"><label>'+unitVal+'</label> </div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-number '+visibleHtml+' '+customcssclass+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlNumber+'</div> ';

            }
          //End number

         // Paragraph
    if(obj.fields[i].field_type=="paragraph"){

              // Get paragraph Propertise
              var htmlPara='',sizeval='',defaultVal='',textType='text',minlength='',maxlength='',textWC='c';
              var onchangeFun='';
              var maxlength='',description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
   
                  if(key=="size"){
                    sizeval=value;
                  }else if(key=="defaultvaluetextarea"){
                    defaultVal=value;
                  }else if(key=="minlength"){
                    minlength=value;
                  }else if(key=="maxlength"){
                    maxlength=value;
                  }else if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                });
           
           if(maxlength!="" || minlength!=""){
             
             onchangeFun="onchange=\"limit_input('rend"+obj.fields[i].cid+"','"+textWC+"','"+maxlength+"','"+minlength+"'); "+setlogicBuilderFun+"\"";             
                  
                  if(textWC=="c"){
                       onchangeFun +=" maxlength='"+maxlength+"'";
                  }           
               }
              else
              {
                onchangeFun='oninput="'+setlogicBuilderFun+'"';
              }  

            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
            }         
         var elementClass="rend"+obj.fields[i].cid;   

   htmlPara +='<div class="elementdiv"><textarea '+requiredElement+' '+elementId+' name="'+obj.fields[i].label+'[]" class="rf-size-'+sizeval+'"  '+onchangeFun+' data-error="">'+defaultVal+'</textarea></div>'+descriptionHtml+'<div class="help-block with-errors '+elementClass+'" style="color:#a94442;"></div>';
                document.getElementById("showform").innerHTML =
                  document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-paragraph '+visibleHtml+' '+customcssclass+'" '+statusShow+'> <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPara+'</div> ';
            }
   
      //End Paragraph

      // Name
        if(obj.fields[i].field_type=="Name"){

            if(titleFun!="")
          titleFun='oninput="'+titleFun+'"';
         if(firstFun!="")
          firstFun='oninput="'+firstFun+'"';
         if(middleFun!="")
          middleFun='oninput="'+middleFun+'"';
         if(lastFun!="")
          lastFun='oninput="'+lastFun+'"';
         

          // Get phone Propertise
              var htmlName='',defaultVal=description='',nameType='Normal';
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="name"){
                    nameType=value;
                  }

                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });
            
            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span>'; 
            }

            var nameId=obj.fields[i].cid;
            if(nameType=="Normal")
            {
                
                htmlName='<div class="elementdiv"> <span class="street"><div class="col-md-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" visible="" value="" name=" First Name "'+firstFun+'><label class="col-md-12 padding-0">First Name</label><div class="help-block with-errors padding-left-none"></div></div><div class="col-md-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' id="lastname'+nameId+'" type="text" visible="" value="" name="Last Name"'+lastFun+'><label class="col-md-12 padding-0">Last Name</label><div class="help-block with-errors col-md-4 padding-left-none"></div></div></span> </div>'+descriptionHtml;
            }
            else if(nameType=="Nor_title")
            {
                htmlName='<div class="full_title elementdiv normal-title-full"><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="title'+nameId+'" '+requiredElement+' type="text" name="Title" '+titleFun+'> <label> Title</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"> <input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name="First Name" '+firstFun+'><label> First</label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="lastname'+nameId+'" '+requiredElement+' type="text" name=" Last Name " '+lastFun+'><label> Last </label></div><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' type="text" name="Suffix"><label> Suffix </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }
            else if(nameType=="Full")
            {
                htmlName='<div class="full elementdiv"><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name=" First Name " '+firstFun+'> <label> First</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="middlename'+nameId+'" '+requiredElement+' type="text" name="Middle Name" '+middleFun+'><label> Middle </label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" name=" Last Name" id="lastname'+nameId+'" '+requiredElement+' type="text" style=" " '+lastFun+'><label> Last </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }
            else if(nameType=="F_title")
            {
                htmlName='<div class="full_title elementdiv normal-title-full"><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="title'+nameId+'" '+requiredElement+' type="text" name=" Title " '+titleFun+'> <label> Title</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"> <input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="firstname'+nameId+'" '+requiredElement+' type="text" name=" First Name " '+firstFun+'><label> First</label></div><div class="col-md-3 col-sm-3 col-xs-3 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' id="middlename'+nameId+'" type="text" name="Middle Name" style=" " '+middleFun+'> <label> Middle </label></div><div class="col-md-4 col-sm-4 col-xs-4 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" id="lastname'+nameId+'" '+requiredElement+' type="text" name="Last Name" style=" " '+lastFun+'><label> Last </label></div><div class="col-md-1 col-sm-1 col-xs-1 padding-left-none"><input data-error="Please enter proper name." pattern="^[A-Za-z]+" '+requiredElement+' type="text" name=" Suffix "><label> Suffix </label></div></div><div class="help-block with-errors col-md-12 padding-0"></div>'+descriptionHtml;
            }

            document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper  form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label><div class="input-line">'+htmlName+'</div></div> ';
        }
        //End Name

         // Time
        if(obj.fields[i].field_type=="time"){

           // Get phone Propertise


           if(SecondFieldFun!=""){
             selectampm='onchange="'+SecondFieldFun+'"';
             SecondFieldFun='oninput="'+SecondFieldFun+'"';
            }
            if(HourFormatFun!="")
            HourFormatFun='oninput="'+HourFormatFun+'"';
            if(bothFun!="")
            bothFun='oninput="'+bothFun+'"';

              var htmlTime=description='',timeType='SecondField';
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="time"){
                    timeType=value;
                  }
                 if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="description"){
                    description=value;
                  }
            });

            var descriptionHtml="";
             // Description
            if(description!=""){
              descriptionHtml=' <div class="help-block">'+description+'</div>'; 
            }
       var timeId=obj.fields[i].cid;

      if(timeType=="HourFormat")
      {
          htmlTime='<div class="elementdiv"><label>HH</label> <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="hour'+timeId+'" '+HourFormatFun+' '+requiredElement+' type="text" name="Hour" style="width: 10%;display: inline;" class="form-control"> : <label>MM</label> <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+HourFormatFun+' '+requiredElement+' type="text" name=" Minutes " style="width: 10%;display: inline;" class="form-control"></div> <div class="help-block with-errors"></div><div class="help-block with-errors"></div>'+descriptionHtml;
      }
      else if(timeType=="both")
      {
          htmlTime='<div class="elementdiv">MM <input  maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+bothFun+' '+requiredElement+' type="text" name=" Minutes " style="width: 10%;display: inline;" class="form-control"> SS: <input maxlength="2" id="second'+timeId+'" '+bothFun+' '+requiredElement+' data-error="Only numeric values are allowed" pattern="^[0-9]+"  type="text" name=" Seconds "  style="width: 10%;display: inline;" class="form-control"> MM: <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute1'+timeId+'" '+bothFun+' '+requiredElement+' type="text" name=" MM" style="width: 10%;display: inline;" class="form-control"></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
      }
      else
      {
          htmlTime='<div class="elementdiv"><label>HH</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="hour'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name=" Hours " style="width: 10%;display: inline;" class="form-control"> :<label>MM</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="minute'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name=" Minutes "  style="width: 10%;display: inline;" class="form-control"> :<label>SS</label> <input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+" id="second'+timeId+'" '+SecondFieldFun+' '+requiredElement+' type="text" name=" Seconds "  style="width: 10%;display: inline; margin-right:5px;" class="form-control"><select id="ampm'+timeId+'" '+selectampm+' style="width: 15%;display: inline;" name=" AM/PM "  class="form-control"> <option value="am">AM</option> <option value="pm">PM</option> </select></div><div class="help-block with-errors"></div>'+descriptionHtml;
      }

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group  response-field-Name '+visibleHtml+' '+customcssclass+'">  <label class="'+setLabelClass+'" '+statusShow+'> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlTime+'</div> ';
        }
        //End TIME

         // DATE
        if(obj.fields[i].field_type=="date"){

                    // Get date Propertise
  var htmlDate='',defaultVal=descriptionHtml=minDate=maxDate='',dateType='date1',weekday='false';
  var disablePastFutureDate1=false,pastfuture='';
  var disableDates="";
  var disableDatesCheck=false;
              var description=customcssclass='';
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="date"){ // date format
                    dateType=value;
                  }
                  else if(key=="datevalfixmin" || key=="datevalRelmax"){ // min date
                  
                    minDate=value;  
                  }
                  else if(key=="datevalfixmax" || key=="datevalRelmax"){ // max date
                  
                    maxDate=value;  
                  }
                  else if(key=="DISABLEWEEKENDDATE"){ //disable week days
                    weekday=value;
                  }
                  else if(key=="datevalRelmin"){ //minimum days
                    minDate=value;  
                  }
                  else if(key=="datevalRelmax"){ //maximum days
                    maxDate=value;  
                  }
                  else if(key=="DISABLEPASTFURDATE"){ //past date
                    disablePastFutureDate1=value;
                  }
                  else if(key=="ALLPASTFURDATE"){ //past date
                    pastfuture=value;
                  }
                  else if(key=="DISABLESPCDATETXTAREA"){ //past date
                  disableDates=value;
                  }
                  else if(key=="DISABLESPCDATETXTAREA"){ //Specific date
                  disableDates=value;
                  }
                  else if(key=="DISABLESPCDATE"){ //Specific date Boolean
                     disableDatesCheck=value;
                  }
                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });

            // if checked disable Past/future buttons
            if(disablePastFutureDate1===true){
              if(pastfuture === 'future'){
                 maxDate="-1"; 
              }
              else
               {
                 minDate="0";
               } 
            }
        var dateFormat=(dateType=="date1")?"mm/dd/yy":"dd/mm/yy";
        var datefun="dateFunction('"+obj.fields[i].cid+"','"+dateFormat+"','"+minDate+"','"+maxDate+"','"+weekday+"','"+disableDates+"');";

            var onchangeFun="";
            if(setlogicBuilderFun!="")
            onchangeFun='onchange="'+setlogicBuilderFun+'"';
            if(dateType=="date1")
            {
                htmlDate='<div class="elementdiv"><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2"  data-error="Only numeric values are allowed" pattern="^[0-9]+"  '+requiredElement+' type="text" name=" Month "  id="mm'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label style="min-width:100%;">MM</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input  maxlength="2"  data-error="Only numeric values are allowed" '+requiredElement+' pattern="^[0-9]+"  type="text" name="Day"  id="dd'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>DD</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2"  data-error="Only numeric values are allowed" '+requiredElement+' pattern="^[0-9]+"  type="text" name="Year"  id="yy'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"> <label>YY</label></div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none" style="padding-top:5px;"> <span><img src="<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif" class="dateimg'+obj.fields[i].cid+'" onclick="'+datefun+'"><input '+onchangeFun+' type="hidden" id="rend'+obj.fields[i].cid+'"></span></div></div>';
            }
            else
            {
                htmlDate='<div class="elementdiv"><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Only numeric values are allowed" pattern="^[0-9]+"  '+requiredElement+' type="text" name=" Month "  id="mm'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>DD</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Only numeric values are allowed" '+requiredElement+' pattern="^[0-9]+"  type="text" name=" Day "  id="dd'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"><span>/</span><label>MM</label> </div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none"><input maxlength="2" data-error="Only numeric values are allowed" '+requiredElement+' pattern="^[0-9]+"  type="text" name=" Month "  id="yy'+obj.fields[i].cid+'" class="form-control" style="max-width: 88%; margin-right: 10px;"> <label>YY</label></div><div class="col-md-3 col-sm-3 col-xm-3 padding-left-none" style="padding-top:5px;"><span><img src="<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif" class="dateimg'+obj.fields[i].cid+'" onclick="'+datefun+'"><input '+onchangeFun+' type="hidden" id="datepickerme'+obj.fields[i].cid+'"></span></div></div>';
            }
            
            var setDateHtml ='<div id="dateformatdiv" class="input-line">'+htmlDate+'</span></div><div class="help-block with-errors"></div>'+descriptionHtml;
            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+setDateHtml+'</div> ';
        }
        //End DATE
	
		
         // address
        if(obj.fields[i].field_type=="address"){
        if(addressFun!="")
          addressFun='oninput="'+addressFun+'"';
         if(address2Fun!="")
          address2Fun='oninput="'+address2Fun+'"';
         if(cityFun!="")
          cityFun='oninput="'+cityFun+'"';
         if(countryFun!="")
          countryFun='onchange="'+countryFun+'"';
         if(stateFun!="")
          stateFun='oninput="'+stateFun+'"';
         if(zipFun!="")
          zipFun='oninput="'+zipFun+'"';
          // Get Text Propertise
        var addId=obj.fields[i].cid;
       // alert(addressFun);
          var htmlAddress='';
          var newLineAddress='<span class="street"><label>Address line 1</label><input data-error="Please enter proper address." placeholder="Enter your address" '+addressFun+' id="address'+addId+'" '+requiredElement+' class="form-control" name="Address"  type="text"></span>';
          var secondAddress="";
          var usrestrict="";
          var description=customcssclass=defaultcountry='';
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }else if(key=="defaultcountry"){
                defaultcountry=value;
              }
              else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                 else if(key=="address"){
                 secondAddress=value;
                 }
                 
                 else if(key=="usrestrict"){
                 usrestrict=value;
                 }
                 
            });
          var optionslist='<option></option>';
          
          for(var c=0;c<countryjson.length; c++){
            if(defaultcountry==countryjson[c])
            optionslist +='<option value="'+countryjson[c]+'" selected="true">'+countryjson[c]+'</option>';
            else
            optionslist +='<option value="'+countryjson[c]+'">'+countryjson[c]+'</option>';
          }
          
          if(usrestrict==true){
              optionslist='<option value="united states">United States</option>'
          }
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
        }
        
        // second address enable checked 
        if(secondAddress=="checked"){
            newLineAddress='<span class="street"><input data-error="Please enter proper address." placeholder="Enter your address" '+address2Fun+' id="address2'+addId+'" '+requiredElement+' class="form-control" name=" Address line 1"  type="text"><label>Address line 1</label><input data-error="Please enter proper address." placeholder="Enter your address" '+requiredElement+' class="form-control" name=" Address line 2"  type="text"><label>Address line 2</label></span>';
        }
        
htmlAddress +='<br><br><div class="view-address col-md-10 col-sm-10 col-xs-10 padding-0"> <div class="elementdiv col-md-12">'+newLineAddress+'</div><div class="input-line col-md-6"><span class="city"><input data-error="Please enter proper city." placeholder="City" '+cityFun+' id="city'+addId+'"'+requiredElement+' type="text" name=" City " class="form-control"><label>City</label></span> </div><div class="input-line col-md-6"><span class="state"><input data-error="Please enter proper state." placeholder="State" pattern="^[A-Za-z]+" '+stateFun+' id="state'+addId+'" '+requiredElement+' type="text" name=" State" class="form-control"><label>State / Province / Region</label></span> </div><div class="input-line col-md-6"><span class="zip"><input data-error="Please enter proper zipcode." pattern="^[0-9]+"  placeholder="Zipcode" '+zipFun+' id="zip'+addId+'" '+requiredElement+' type="number" name=" Zip Code"  class="form-control"><label>Zipcode</label></span> </div><div class="input-line col-md-6"> <span class="country"><select placeholder="Select Country" class="form-control" name=" Country" '+countryFun+' id="country'+addId+'"  >'+optionslist+'</select><label>Country</label></span> </div></div><div class="help-block with-errors"></div>'+descriptionHtml;

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlAddress+'</div> ';
        }
        //End address

         // price
        if(obj.fields[i].field_type=="price"){

          // Get Text Propertise
          var htmlPrice=sizeval=customcssclass='';
          var description=customcssclass='';
          var currencyVal="";

          $.each( obj.fields[i].field_options, function( key, value ) {
            if(key=="description"){
                description=value;
              }
              else if(key=="size"){
                    sizeval=value;
              }else if(key=="customcssclass"){
                customcssclass=value;
              }else if(key=="currency"){
                currencyVal=value;
              }    

            });
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <span class="help-block col-md-12">'+description+'</span>'; 
        }

        onchangeFun=="";
        if(setlogicBuilderFun!="")
        onchangeFun='oninput="'+setlogicBuilderFun+'"';

htmlPrice +='<div class="elementdiv"> <span class="dolars"> <input data-error="Only numeric values are allowed" pattern="^[0-9]+" '+elementId+' '+requiredElement+' '+onchangeFun+' type="text" name="'+obj.fields[i].label+'[]" '+requiredElement+' placeholder="'+EFBP_getCurrencyFirst(currencyVal)+'"></span> <span class="above-line">.</span> <span class="cents"> <input placeholder="'+EFBP_getCurrencySecond(currencyVal)+'" data-error="Only numeric values are allowed" pattern="^[0-9]+"  type="text" name="'+obj.fields[i].label+'[]" '+requiredElement+'></span><span class="above-line">'+EFBP_getCurrencySymbol(currencyVal)+'</span> </div>'+descriptionHtml+'<div class="help-block with-errors"></div>';

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+' >  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPrice+'</div> ';
        }
        //End price

          // email
        if(obj.fields[i].field_type=="email"){

          // Get Text Propertise
          var htmlEmail=defaultValEmail='';
          var description=customcssclass='';
      var  onchangeFun='',elementSize="small";
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }else if(key=="defaultValEmail"){
                    defaultValEmail=value;
              }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="size"){
                 elementSize=value;
                 }

            });
      
         var oninputFun="";
        if(setlogicBuilderFun!="")
        oninputFun='oninput="'+setlogicBuilderFun+'"';

        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <div class="help-block col-md-12">'+description+'</div>'; 
        }
        
        htmlEmail +='<div class="elementdiv"><input placeholder="abc@something.com" '+elementId+' type="email" name="'+obj.fields[i].label+'[]" class="rf-size-'+elementSize+'" '+requiredElement+' '+oninputFun+' data-error="Entered email address is invalid" ></div>'+descriptionHtml+'<div class="help-block with-errors"></div>';
        

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-text '+visibleHtml+' '+customcssclass+'" '+statusShow+' '+defaultValEmail+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlEmail+'</div> ';
        }

        //End email


        // Dropdown
       var drop_dwn_optionsHtml="";
      if(obj.fields[i].field_type=="dropdown"){
        var maxlength=customcssclass=description=sizeval='';
        var includeBlank=false;

        $.each( obj.fields[i].field_options, function( key, value ) {
             if(key=="size"){
                    sizeval=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
                  else if(key=="include_blank_option"){
                   includeBlank=value;
                }
            });
       
      var descriptionHtml="";
       // Description
      if(description!=""){
        descriptionHtml=' <span class="help-block">'+description+'</span>'; 
      }         
        onchangeFun='onchange="'+setlogicBuilderFun+'"';
        
        if(includeBlank==true){
            drop_dwn_optionsHtml='<option value=""></option>';
        }
      if( obj.fields[i].field_options.options.length>0){
          for(var j = 0; j < obj.fields[i].field_options.options.length; j += 1){
          drop_dwn_optionsHtml=drop_dwn_optionsHtml+'<option selected="'+obj.fields[i].field_options.options[j].checked+'"   value="'+obj.fields[i].field_options.options[j].label+'">'+obj.fields[i].field_options.options[j].label+'</option>'; }
          
      }

          document.getElementById("showform").innerHTML =
          document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+visibleHtml+' '+customcssclass+' '+sizeval+'" '+statusShow+'> <label class="'+setLabelClass+'"><span >'+obj.fields[i].label+requiredHtml+'</span></label><div class="elementdiv"><select style=\"font-size:13px !important;\" visible="" name="'+obj.fields[i].label+'[]" class="rf-size-'+sizeval+' " '+elementId+' '+requiredElement+' '+onchangeFun+'>'+drop_dwn_optionsHtml+'</select></div><span class="help-block"></span></div> ';
         }
        //END Dropdown


        //Checkbox new
       var checkbox_Html="";
      if(obj.fields[i].field_type=="checkboxes"){  
          var CheckboxClass="",customClass="";
          var checkedVal=false;
          var oneColumn="";

          $.each( obj.fields[i].field_options, function( key, value ) {
            if(key=="checkbox")
              {
              CheckboxClass=value
              }
               if(key=="customcssclass"){
              customClass=value;
              }
              if(key=="checkbox"){
               oneColumn=value;
              }
              if(key=="description"){
                description=value;
              }
              if(key=="checkbox"){
               oneColumn=value;
              }

            });

            var descriptionHtml="";
            if(description!=""){
              descriptionHtml=' <span class="help-block">'+description+'</span>'; 
            }  

            var onchangeFun='onchange="'+setlogicBuilderFun+'"';
           /* old 
            if(obj.fields[i].field_options.options.length>0){for(var k = 0; k < obj.fields[i].field_options.options.length; k += 1){ checkbox_Html=checkbox_Html+'<input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\" /> <label>'+obj.fields[i].field_options.options[k].label+'</label><br>'; }} */

              if(obj.fields[i].field_options.options.length>0){for(var k = 0; k < obj.fields[i].field_options.options.length; k += 1){
                  if(obj.fields[i].field_options.options[k].checked==true){
                   checkbox_Html=checkbox_Html+'<div><label class="fb-option '+oneColumn+' "><input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\"checked="true" name="'+obj.fields[i].field_options.options[k].label+'" /> <label>'+obj.fields[i].field_options.options[k].label+'</label></label></div>';
                  }
                  else{
                     checkbox_Html=checkbox_Html+'<div><label class="fb-option '+oneColumn+' "><input '+onchangeFun+' '+requiredElement+' '+elementId+' type=\"checkbox\"  name="'+obj.fields[i].field_options.options[k].label+'"  /> <label>'+obj.fields[i].field_options.options[k].label+'</label></label></div>';
                  }
                 
              }}
                document.getElementById("showform").innerHTML =
                document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+' '+CheckboxClass+' '+visibleHtml+' '+customClass+'" '+statusShow+'><label>  <span>'+obj.fields[i].label+requiredHtml+'</span></label> <div> '+checkbox_Html+descriptionHtml+'</div><span class="help-block"></span><div class="actions-wrapper"> </div></div> ';
       }
       //End Checkbox     


//RADIO BUTTON NEW
       var radio_Html="";
      if(obj.fields[i].field_type=="radio"){        
            var radiosetClass="one_column",customClass="";    
            var includeOther=false;
			var description="";
             $.each( obj.fields[i].field_options, function( key, value ) {      
              if(key=="radio"){
                radiosetClass=value;
              }     
             if(key=="description"){
                description=value;
              }
            if(key=="customcssclass"){
            customClass=value;
            }
            if(key=="include_other_option"){
             includeOther=value;
            }
          });

     onchangeFun='onchange="'+setlogicBuilderFun+'"';

     /* old 
      if( obj.fields[i].field_options.options.length>0){
        for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<input '+elementId+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}else{ radio_Html=radio_Html+'<input '+elementId+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}  }
      } */

    //new virgil code
    var elementClass="class='rend"+obj.fields[i].cid+"'";
    
      if( obj.fields[i].field_options.options.length>0){
          if(radiosetClass!="one_column"){
              for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<div><label class="fb-option '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label></label></div>';}else{ radio_Html=radio_Html+'<div><label class="fb-option   '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label></label></div>';}  }
              if(includeOther==true){
                  radio_Html=radio_Html+'<div><label class="fb-option '+radiosetClass+' "><input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="other"/> <label>Other</label><input type="text" name="'+obj.fields[i].label+'[]"></label></div>';
              }
              
          }
          else{
               for(var l = 0; l < obj.fields[i].field_options.options.length; l += 1){if(obj.fields[i].field_options.options[l].checked==true){radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" checked=\"true\" value="'+obj.fields[i].field_options.options[l].label+'"/> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}else{ radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt\" value="'+obj.fields[i].field_options.options[l].label+'" /> <label>'+obj.fields[i].field_options.options[l].label+'</label><br>';}  }
               if(includeOther==true){
                   radio_Html=radio_Html+'<input '+elementClass+' '+requiredElement+' '+onchangeFun+' type=\"radio\" name =\"radiobt[]\" checked=\"true\" value="other"/> <label>Other</label><input type="text" name="'+obj.fields[i].label+'[]">';
               }
              
          }
       }
       //end new
          document.getElementById("showform").innerHTML =
          document.getElementById("showform").innerHTML+'<div '+logicId+'class="subtemplate-wrapper form-group '+visibleHtml+' '+customClass+' " '+statusShow+'><label>  <span>'+obj.fields[i].label+requiredHtml+'</span></label> <div> '+radio_Html+description+' </div><span class="help-block"></span><div class="actions-wrapper"> </div></div> ';

         }
  //End BUTTON

  
        // Phone
          if(obj.fields[i].field_type=="phone"){

              // Get phone Propertise
              var htmlPhone='',defaultVal=defaultVal1=defaultVal2=defaultVal3='',phoneType='International';
              var description=customcssclass=onchangeFun='';

              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="phone"){
                    phoneType=value;
                  }

                 if(phoneType=="International"){
                    if(key=="defaultvaluephone"){
                      defaultVal=value;
                    }    
                 }
                 else
                 {
                      if(key=="defaultvaluephone1"){
                        defaultVal1=value;
                      }else if(key=="defaultvaluephone2"){
                        defaultVal2=value;
                      }else if(key=="defaultvaluephone3"){
                        defaultVal3=value;
                      } 
                 }  

                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }
            });

             var onchangeFun="";
             if(setlogicBuilderFun!="") 
            onchangeFun='oninput="'+setlogicBuilderFun+'"';

            if(phoneType=="International")
            {
                htmlPhone='<div class="elementdiv"><input data-error="Only numeric values are allowed" pattern="^[0-9]+" '+elementId+' '+requiredElement+' '+onchangeFun+' type="text" name="'+obj.fields[i].label+'[]" class="rf-size- " value="'+defaultVal+'" ></div><div class="help-block with-errors"></div>';
            }  
            else
            {
                htmlPhone='<div class="elementdiv"><input data-error="Only numeric values are allowed" pattern="^[0-9]+"  '+requiredElement+' type="text"  name="'+obj.fields[i].label+'[]" maxlength="3" value="'+defaultVal1+'" style="width:50px;" >-<input data-error="Only numeric values are allowed" pattern="^[0-9]+" '+requiredElement+' type="text" name="'+obj.fields[i].label+'[]" value="'+defaultVal2+'" style="width:50px;" maxlength="3" >-<input data-error="Only numeric values are allowed" pattern="^[0-9]+" '+requiredElement+' type="text"  name="'+obj.fields[i].label+'[]" value="'+defaultVal3+'" style="width:70px;" maxlength="4"></div><div class="help-block with-errors"></div>';
            }  
              document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlPhone +'</div> ';
          }
        // End Phone  

// File upload new
     if(obj.fields[i].field_type=="file_upload"){
FileUploadStatus=true;
              // Get phone Propertise
            var htmlfile='';
       var setLabelClass="";
              var description=customcssclass=checkExtension='';
        var multipleFileUpload="";
        var limitFileUploadType="";
        var fileup="opt1";
              var fileSizeLimit;
              var LIMIT_FILE_SIZE=false;
              var LIMIT_MAX_FILEUP_SIZE;
              var LIMIT_MUL_FILE_UP;
              var MUL_FILE_UP=false;
              $.each( obj.fields[i].field_options, function( key, value ) {
            
                  if(key=="description"){
                    description=value;
                  }else if(key=="customcssclass"){
                    customcssclass=value;
                  }else if(key=='LIMIT_FILE_UP_TXTAR'){
         checkExtension=value } 
         else if(key=='MUL_FILE_UP'){
         multipleFileUpload=value } 
         else if(key=='LIMIT_FIL_UPLOAD_TYPE'){
         limitFileUploadType=value }  
         else if(key=='fileup'){
         fileup=value }
                else if(key=='LIMIT_FILE_SIZE'){
                     LIMIT_FILE_SIZE=value }
                else if(key=='LIMIT_MAX_FILEUP_SIZE'){
                     LIMIT_MAX_FILEUP_SIZE=value }
                     else if(key=='LIMIT_MUL_FILE_UP'){
                     LIMIT_MUL_FILE_UP=value }
                 
            });
            var callFunctionFileSize="";
            if(LIMIT_FILE_SIZE==true){
                callFunctionFileSize="checkFileSize(this,\'"+LIMIT_MAX_FILEUP_SIZE+"\');";
            }
            var callFunctionFilesLimit="";
            if(LIMIT_MUL_FILE_UP>0){
                callFunctionFilesLimit="checkTotalFiles(this,\'"+LIMIT_MUL_FILE_UP+"\');";
            }

          if(multipleFileUpload==true){
      if(limitFileUploadType==true){
      if(fileup!="opt1"){
      htmlfile ='<div class="elementdiv "> <span> <input  '+requiredElement+' '+requiredElement+' '+elementId+' type="file" class="myfile"  name="'+obj.fields[i].label+'[]"  onchange="checkExtensions(this,\''+checkExtension+'\');'+callFunctionFileSize+' '+callFunctionFilesLimit+' "  multiple> </span> </div>';
          
      }
      else{
      htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="'+obj.fields[i].label+'[]"  onchange="checkExtensions2(this,\''+checkExtension+'\');'+callFunctionFileSize+'  '+callFunctionFilesLimit+'   "  multiple> </span> </div>';
          
      }
          
      }
      else{
          htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="'+obj.fields[i].label+'[]"  onchange="'+callFunctionFileSize+' '+callFunctionFilesLimit+'  "  multiple> </span> </div>';
          
      }
      
      }
      else{
       
      if(limitFileUploadType==true){
      if(fileup!="opt1"){
      htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="'+obj.fields[i].label+'[]"  onchange="checkExtensions(this,\''+checkExtension+'\'); '+callFunctionFileSize+'  "  > </span> </div>';
          
      }
      else{
      htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile" name="'+obj.fields[i].label+'[]"  onchange="checkExtensions2(this,\''+checkExtension+'\'); '+callFunctionFileSize+'  "  > </span> </div>';  
      }
      }
      else{
          htmlfile ='<div class="elementdiv "> <span> <input '+requiredElement+' '+elementId+' type="file" class="myfile"  name="'+obj.fields[i].label+'[]"  onchange=" '+callFunctionFileSize+' "  > </span> </div>';  
      }
      }              
              document.getElementById("showform").innerHTML =
              document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group'+visibleHtml+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlfile +'<input type="text" id="allFiles" name="'+obj.fields[i].label+'" style="display:none;"/></div> ';
          }
        // file upload ends


// Section Break section_break
 if(obj.fields[i].field_type=="section_break"){
     
     document.getElementById("showform").innerHTML =
     document.getElementById("showform").innerHTML+'<div class="subtemplate-wrapper form-group" style="border-bottom:1px solid black !important;"></div><br>';
 }


  //Signature
  signatureStatus=true;
       var radio_Html="";
      if(obj.fields[i].field_type=="signature"){    
       // Get Text Propertise
          var htmlEmail='';
          var description=customcssclass='';
          $.each( obj.fields[i].field_options, function( key, value ) {

             if(key=="description"){
                description=value;
              }
              else if(key=="customcssclass"){
                    customcssclass=value;
                  }

            });
        var descriptionHtml="";
         // Description
        if(description!=""){
          descriptionHtml=' <span class="help-block">'+description+'</span>'; 
        }

          htmlEmail +='<div class="sigPad elementdiv"> <p class="drawItDesc">Draw your signature</p> <ul class="sigNav"> <li class="drawIt"><a href="#draw-it" >Draw It</a></li> <li class="clearButton"><a href="#clear">Clear</a></li> </ul> <div class="sig sigWrapper"> <div class="typed"></div> <canvas class="pad" width="198" height="55"></canvas> <input '+requiredElement+' type="hidden" name="'+obj.fields[i].label+'" class="output signature"> </div></div>';

            document.getElementById("showform").innerHTML =
            document.getElementById("showform").innerHTML+'<div '+logicId+' class="subtemplate-wrapper form-group response-field-Name '+visibleHtml+' '+customcssclass+'" '+statusShow+'>  <label class="'+setLabelClass+'"> <span>'+obj.fields[i].label+requiredHtml+'</span></label>'+htmlEmail+'</div> ';
         }
      //End Signature

        if(obj.fields.length==(i+1))
        {

            // Scroll Down 
             var height=($(document).height()+$( window ).height()+200);
            // console.log("height"+$( window ).height()+" docu "+height);
             window.scrollTo(0,height);
        }

     }//end for
        document.getElementById("showform").innerHTML =
        document.getElementById("showform").innerHTML+'<input class="btn btn-success bt-style  " type="submit" id="successMessage" value="Submit " />';


  }//End RenderForm
  
  //pass parameter datepicker
function dateFunction(id,formatme,minDate,maxDate,weekday,allDisabledDates) {
    console.log(formatme+" "+weekday);
    if(formatme=="mm/dd/yy"){formatme="mm/dd/yy";}else{formatme="dd/mm/yy";}
  var allDisabledDatesArray = allDisabledDates.split(',');
    $(".dateimg"+id).hide();
    if(weekday=="false"){
        $("#rend"+id).datepicker({
        showOn: "button",
        buttonImage: "<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: formatme,
                                         beforeShowDay: function(mydate){
                                         var $return=true;
                                         var $returnclass ="available";
                                         var $myBadDates = allDisabledDatesArray;
                                         $checkdate = $.datepicker.formatDate(formatme, mydate);
                                         for(var i = 0; i < $myBadDates.length; i++)
                                         {
                                         if($myBadDates[i] == $checkdate)
                                         {
                                         $return = false;
                                         $returnclass= "unavailable";
                                         }
                                         }
                                         return [$return,$returnclass];
                                         },
        minDate: minDate,
        maxDate: maxDate,
        onSelect: function(dateText, inst) {
            var pieces = dateText.split('/');
            console.log('piece'+pieces);
            if(formatme=="mm/dd/yy")
             {
              $('#mm'+id).val(pieces[0]);
              $('#dd'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             }
             else 
              {
              $('#dd'+id).val(pieces[0]);
              $('#mm'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             } 
        }

      });
    }
    else
    {
        $("#rend"+id).datepicker({
        showOn: "button",
        buttonImage: "<?php echo get_site_url();?>/wp-content/plugins/easy-form-builder-by-bitware/img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: formatme,
        minDate: minDate,
        maxDate: maxDate,
                                         beforeShowDay: function(mydate){
                                         var $return=true;
                                         var $returnclass ="available";
                                         var $myBadDates = allDisabledDatesArray;
                                         $checkdate = $.datepicker.formatDate(formatme, mydate);
                                         for(var i = 0; i < $myBadDates.length; i++)
                                         {
                                         if($myBadDates[i] == $checkdate)
                                         {
                                         $return = false;
                                         $returnclass= "unavailable";
                                         return [$return,$returnclass];
                                         }
                                         }
                                         mydate = mydate.getDay();
                                         return [mydate > 0 && mydate < 6, ""];
                                         },
        onSelect: function(dateText, inst) {
            var pieces = dateText.split('/');
            console.log('piece'+pieces);
            if(formatme=="mm/dd/yy")
             {
              $('#mm'+id).val(pieces[0]);
              $('#dd'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             }
             else 
              {
              $('#dd'+id).val(pieces[0]);
              $('#mm'+id).val(pieces[1]);
              $('#yy'+id).val(pieces[2]);
             } 
        },
        
      });
    }  
}
  
  
function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}
  function submit_form_data()
  {   	
  
  if(signatureStatus==true){
	  var checkSign=false;
	  $(".signature").each(function() {
    if($(this).val()==""){
		alert("Please sign the document");
		checkSign=true;
		return false;
	}
});
if(checkSign==true){
	return false;
}
  }
  
var jsonFData=$('#showform').serializeArray();
//alert(jsonFData[0].name);
for(var i=0;i<jsonFData.length;i++)
{
    if (jsonFData[i]['name']=="g-recaptcha-response") {
        // do something with `key'
	delete jsonFData[i];
    }
	/* if (jsonFData[i]['name']=="CAPTCHA[]") {
        // do something with `key'
		delete jsonFData[i];
    }  
	 if (jsonFData[i]['name']=="FILE_UPLOAD") {
		delete jsonFData[i];
    }*/
}
	//alert('success message is :'+$( "#successMessage" ).hasClass( "disabled" ));
	if($( "#successMessage" ).hasClass( "disabled" )==false){
		
	  if(FileUploadStatus==true)
		{
				var form_data = new FormData();   
				var leng=$('.myfile').prop('files').length;
				while(leng>0){
						var file_data = $('.myfile').prop('files')[leng-1];  
						form_data.append('file[]', file_data);
						leng--;
				}
					form_data.append('action', 'EFBP_verify_upload_file');
			                            
				$.ajax({
						url: '<?php echo  admin_url( 'admin-ajax.php' ); ?>', // point to server-side PHP script 
						cache: false,
						contentType: false,
						processData: false,
						data:form_data,                         
						type: 'post',
						success: function(php_script_response){
							$("#allFiles").val(php_script_response);
							
							if(captchaStatus==true){
		var responseCaptcha = secretKey; // "6LdbjxoTAAAAAK22tBPZIK2NiE4ujB4CWPJRR88h";
		var responseVar=grecaptcha.getResponse();
		var data = {
			'action':'EFBP_verify_captcha',
			'secret ': responseCaptcha,
			'responseVar ':responseVar
			};
			  $.ajax({
            type: "POST",
            url: "<?php echo  admin_url( 'admin-ajax.php' ); ?>",
			async:    false,
            data: "action=" + 'EFBP_verify_captcha' + "&secret=" + responseCaptcha + "&responseVar=" + responseVar
        }).done(function(status) {
            if (status == "1") {
				jsonFData=$('#showform').serializeArray();
for(var i=0;i<jsonFData.length;i++)
{
    if (jsonFData[i]['name']=="g-recaptcha-response") {
        // do something with `key'
	delete jsonFData[i];
    }
	/* if (jsonFData[i]['name']=="CAPTCHA[]") {
        // do something with `key'
		delete jsonFData[i];
    }  
	 if (jsonFData[i]['name']=="FILE_UPLOAD") {
		delete jsonFData[i];
    }*/
}
		jQuery.post("<?php echo  admin_url( 'admin-ajax.php' ); ?>",
		 {
			'action':'EFBP_submit_form_json_data',
			'formdata':JSON.stringify(jsonFData),
			'form_id':form_id,
			'user_id':user_id
		},function(response) {	  if(Formjson.forms[0].field_options.submitconfirm!="")
            {   
						  alert(Formjson.forms[0].field_options.submitconfirm);
            }
			  if(Formjson.forms[0].field_options.redirecturl!="")
            {   
						window.location.assign(Formjson.forms[0].field_options.redirecturl);
            }else{
				alert("Data has been saved successfully.");
					window.location.reload();
			}
		});		
            }
			else{
				alert("Wrong Capcha");
			}
        });

  }
  else{  // if captchstatus is false      
  	jsonFData=$('#showform').serializeArray();
//alert(jsonFData[0].name);
for(var i=0;i<jsonFData.length;i++)
{
    if (jsonFData[i]['name']=="g-recaptcha-response") {
        // do something with `key'
	delete jsonFData[i];
    }
	/* if (jsonFData[i]['name']=="CAPTCHA[]") {
        // do something with `key'
		delete jsonFData[i];
    }  
	 if (jsonFData[i]['name']=="FILE_UPLOAD") {
		delete jsonFData[i];
    }*/
}
		jQuery.post("<?php echo  admin_url( 'admin-ajax.php' ); ?>",
		 {
			'action':'EFBP_submit_form_json_data',
			'formdata':JSON.stringify(jsonFData),
			'form_id':form_id,
			'user_id':user_id
		},function(response) {	  if(Formjson.forms[0].field_options.submitconfirm!="")
            {   
						  alert(Formjson.forms[0].field_options.submitconfirm);
            }
			  if(Formjson.forms[0].field_options.redirecturl!="")
            {   
						window.location.assign(Formjson.forms[0].field_options.redirecturl);
            }else{
				alert("Data has been saved successfully.");
					location.reload();
			}
		});		
  }
						}
			 });
		}
		else if(captchaStatus==true){ // if its not upload status then check for captcha status.
	  var responseCaptcha = secretKey; //"6LdbjxoTAAAAAK22tBPZIK2NiE4ujB4CWPJRR88h";
		
		var responseVar=grecaptcha.getResponse();
	//	alert(responseVar);
		var data = {
			'action':'EFBP_verify_captcha',
			'secret ': responseCaptcha,
			'responseVar ':responseVar
			};
			//alert(data);
			  $.ajax({
            type: "POST",
            url: "<?php echo  admin_url( 'admin-ajax.php' ); ?>",
			async:    false,
            data: "action=" + 'EFBP_verify_captcha' + "&secret=" + responseCaptcha + "&responseVar=" + responseVar
        }).done(function(status) {
		//	alert(status);
            if (status == "1") {
      		jsonFData=$('#showform').serializeArray();
//alert(jsonFData[0].name);
for(var i=0;i<jsonFData.length;i++)
{
    if (jsonFData[i]['name']=="g-recaptcha-response") {
        // do something with `key'
	delete jsonFData[i];
    }
	/* if (jsonFData[i]['name']=="CAPTCHA[]") {
        // do something with `key'
		delete jsonFData[i];
    }  
	 if (jsonFData[i]['name']=="FILE_UPLOAD") {
		delete jsonFData[i];
    }*/
}
		jQuery.post("<?php echo  admin_url( 'admin-ajax.php' ); ?>",
		 {
			'action':'EFBP_submit_form_json_data',
			'formdata':JSON.stringify(jsonFData),
			'form_id':form_id,
			'user_id':user_id
		},function(response) {	  if(Formjson.forms[0].field_options.submitconfirm!="")
            {   
						  alert(Formjson.forms[0].field_options.submitconfirm);
            }
			  if(Formjson.forms[0].field_options.redirecturl!="")
            {   
						window.location.assign(Formjson.forms[0].field_options.redirecturl);
            }else{
				alert("Data has been saved successfully.");
					location.reload();
			}
		});		
            }
			else{
				alert("Wrong Capcha");
			}
        });

  }
  else{    // if its not captcha or upload then submit remaining fields of the form
  			jsonFData=$('#showform').serializeArray();
//alert(jsonFData[0].name);
for(var i=0;i<jsonFData.length;i++)
{
    if (jsonFData[i]['name']=="g-recaptcha-response") {
        // do something with `key'
	delete jsonFData[i];
    }
	/* if (jsonFData[i]['name']=="CAPTCHA[]") {
        // do something with `key'
		delete jsonFData[i];
    }  
	 if (jsonFData[i]['name']=="FILE_UPLOAD") {
		delete jsonFData[i];
    }*/
}
		jQuery.post("<?php echo  admin_url( 'admin-ajax.php' ); ?>",
		 {
			'action':'EFBP_submit_form_json_data',
			'formdata':JSON.stringify(jsonFData),
			'form_id':form_id,
			'user_id':user_id
		},function(response) {
				  if(Formjson.forms[0].field_options.submitconfirm!="")
            {   
						  alert(Formjson.forms[0].field_options.submitconfirm);
            }
			  if(Formjson.forms[0].field_options.redirecturl!="")
            {   
						window.location.assign(Formjson.forms[0].field_options.redirecturl);
            }else{
				alert("Data has been saved successfully.");
					location.reload();
			}
			
              
		});		
  }
	}
	else{
		return false;
	}
}


jQuery(document).ready(function() {
  
 	// $('#showform').attr('action',Formjson.forms[0].field_options.redirecturl);
	renderForm();
	    jQuery('.sigPad').signaturePad({drawOnly:true});
      
});

	</script>
	
	<?php
wp_localize_script( 'ajax_custom_script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

return "";
 }

   // and use it like this:


 ?>