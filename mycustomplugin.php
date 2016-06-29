<?php

/*
 * Plugin Name:       My custom Plugin
 * Plugin URI:        https://www.github.com/bhawnam193
 * Description:       custom plugin
 * Version:           1.0.0
 * Author:            Bhawna
 * Author URI:        https://www.github.com/bhawnam193
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/
/*
add_action('admin_menu','mycustomplugin_admin_action');


function mycustomplugin_admin_action(){

	add_options_page('Custom Plugin','Custom Plugin','manage_options',__FILE__,'mycustomPlugin_admin');
	add_options_page('View Books Details','View Books Details','manage_options',__FILE__,'viewBooks_admin');
}

*/
add_action( 'admin_menu', 'mycustomplugin_admin_action');

//adding menu menu in wordpress admin panel

function mycustomplugin_admin_action() {

	add_menu_page( 'Books', 'Books','manage_options', __FILE__,'mycustomPlugin_admin');

	add_submenu_page( __FILE__, 'Books Submenu','View Books', 'manage_options',__FILE__.'_menu1', viewBooks_admin );

}

function viewBooks_admin(){

?>
<div class="wrap">
<h4>Books List</h4>
<form action="" method="POST">
<table class="widefat">
	<thead>
		<tr>
			<th>Book Name</th>
			<th>Book Description</th>
			<th>Author Name</th>
			<th>Book Price</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Book Name</th>
			<th>Book Description</th>
			<th>Author Name</th>
			<th>Book Price</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
			global $wpdb;
			$mytestdrafts=$wpdb->get_results(
				"
				SELECT *
				from ".$wpdb->prefix."books
				"
			);
		?>

		<?php
			foreach($mytestdrafts as $mytestdraft)
			{
		?>
				<tr>
					<?php
						echo"<td>".$mytestdraft->bookName."</td>";
						echo"<td>".$mytestdraft->bookDescription."</td>";
						echo"<td>".$mytestdraft->authourName."</td>";
						echo"<td>".$mytestdraft->bookPrice."</td>";
					?>
				</tr>
				<?php
			}
 		?>
	
	
	</tbody>
	
	


</table>
<br><br>

</form>
</div>
<?php
	
}

function mycustomPlugin_admin(){

?>
<div class="wrap">
<h4>Enter Your Book Details</h4>
<br/>

<form action="" method="POST">

	Book Name<input type="text" name="book_name" /> <br>
	Book Description<input type="text" name="book_description" />  <br>
	Authour Name<input type="text" name="authour_name" />  <br>
	Book Price<input type="text" name="book_price" />  <br>
	<input type="submit" name="btnSubmit" value="Submit" class="button-primary">
</form>
<br/>

<?php
	global $wpdb;
	
	if(isset($_POST['btnSubmit'])){

		$sql = "insert into ".$wpdb->prefix."books (bookName, bookDescription, authourName, bookPrice) VALUES ('".$_POST['book_name']."','".$_POST['book_description']."','".$_POST['authour_name']."','".$_POST['book_price']."')";

		if($wpdb->query($sql)){
			echo 'Data Saved';
		}
	}
}
	
	function create_table(){
		
		global $wpdb;
	    $table_name   = $wpdb->prefix .'books';
	    $sql = 'CREATE TABLE ' . $table_name . ' (
		    id int(11) NOT NULL AUTO_INCREMENT,
		    bookName varchar(200),bookDescription varchar(200) ,authourName varchar(200),bookPrice varchar(200) ,  PRIMARY KEY (id))';
		$wpdb->query($sql);
	}

	function drop_table(){
		
		global $wpdb;
	    $table_name = $wpdb->prefix .'books';
	    $sql = "DROP TABLE IF EXISTS ". $table_name;
	    $wpdb->query($sql);
	    
	}

	register_activation_hook(__FILE__, 'create_table');
	register_deactivation_hook(__FILE__, 'drop_table');

?>