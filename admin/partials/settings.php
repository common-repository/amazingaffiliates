<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php $amazingaffiliates_page = "settings";  ?>

<main class="amazingaffiliates_admin_page amazingaffiliates_settings" >

	<div id="navbar" >
		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/navbar.php' ); ?>
	</div>
	
	<div id="header" >
		
		<h1 class="amazingaffiliates_admin_page_title" >Amazing Affiliates Settings</h1>
		<h2>Setup the plugin and customize its functionalities</h2>
		<p>Here you can set things to make the plugin work properly for you! First of all, you must set up your Amazon Affiliate Data in order to get affiliate commissions. Then, you can also customize the product block display. For instance, you can set a custom default text for the Buy Button. Or you can decide to show/hide the Offer banner for certain circumstances (% of discount).</p>
		
	</div>
	
	<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/settings_settings.php' ); ?>
	
	<div class="amazingaffiliates_tab" >
	    
	    <ul class="filtertab" >
            <?php foreach(array_keys($settings) as $setting_group_key) : ?>
                <li>
                    <a 
                        id="<?php echo esc_attr( $setting_group_key ); ?>_tab" 
                        data-tab="<?php echo esc_attr( $setting_group_key ); ?>" 
                        href="#<?php echo esc_attr( $setting_group_key ); ?>"
                    >
                        <?php echo esc_html( $settings_groups[$setting_group_key]['title'] ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <form method="post" action="options.php">
            
            <?php settings_fields( 'amazingaffiliates_settings' ); ?>
            
            <?php foreach(array_keys($settings) as $setting_group_key) : ?>
                
                <section id="<?php echo esc_attr( $setting_group_key ); ?>" class="tabcontent">
                    
                    <p><?php echo esc_html( $settings_groups[$setting_group_key]["desc"] ); ?></p>
                    
                    <table class="form-table">
                        
                        <?php foreach($settings[$setting_group_key] as $setting) : ?>
                        
                            <?php $setting_slug = 'amazingaffiliates_settings_' . $setting_group_key . '_' . $setting['name']; ?>
                            
                            <tr data-saved-value="<?php echo esc_attr( get_option($setting_slug) ); ?>" >
                                <th scope="row"><?php echo esc_html( $setting["display"] ); ?></th>
                                <td>
                                    
                                    <?php
                                        
                                    switch ($setting["type"]) {
                                    
                                    	case "text":
                                    		echo '<input type="text" name="' . esc_attr( $setting_slug ) . '" value="' . esc_attr( get_option($setting_slug) ) . '" data-saved-value="' . esc_attr( get_option($setting_slug) ) . '" />';
                                    		break;
                                    
                                    	case "number":
                                    		echo '<input type="number" name="' . esc_attr( $setting_slug ) . '" value="' . esc_attr( get_option($setting_slug) ) . '" data-saved-value="' . esc_attr( get_option($setting_slug) ) . '" />';
                                    		break;
                                    
                                    	case "password":
                                    		echo '<input type="password" name="' . esc_attr( $setting_slug ) . '" value="' . esc_attr( get_option($setting_slug) ) . '" data-saved-value="' . esc_attr( get_option($setting_slug) ) . '" />';
                                    		break;
                                    
                                    	case "select":
                                    		echo '<select name="' . esc_attr( $setting_slug ) . '" >';
                                    		foreach($setting["options"] as $setting_option) {
                                    			$selected_status = '';
                                    			if( get_option($setting_slug) == $setting_option["value"] ) {
                                    				$selected_status = 'selected';
                                    			}
                                    			echo '<option value="' . esc_attr( $setting_option["value"] ) .'" ' . esc_attr( $selected_status ) . '>'
                                    				.	esc_attr( $setting_option["innerText"] )
                                    				.'</option>';
                                    		}
                                    		echo '</select>';
                                    		break;
                                    		
                                    	case "config":
                                    		echo '<select name="' . esc_attr( $setting_slug ) . '" data-saved-value="' . esc_attr( get_option($setting_slug) ) . '" >';
                                    		foreach($setting["options"] as $setting_option) {
                                    			$selected_status = '';
                                    			$current_option = json_decode(get_option($setting_slug));
                                    			if( $current_option->name == $setting_option["name"] ) {
                                    				$selected_status = 'selected';
                                    			}
                                    			if( $setting_option["name"] == '- SELECT -' ) {
                                    			   echo '<option value="" ' . esc_attr( $selected_status ) . '>' .	esc_attr( $setting_option["name"] ) .'</option>'; 
                                    			}
                                    			else {
                                    			    $valid_value = array( 
                                    			        "name" => $setting_option["name"] , 
                                    			        "amazon_domain" => $setting_option["amazon_domain"] ,  
                                    			        "pa_endpoint" => $setting_option["pa_endpoint"] , 
                                    			        "region" => $setting_option["region"]  
                                        			);
                                        			
                                        			echo '<option value="' . esc_attr( wp_json_encode( $valid_value ) ) .'" ' . esc_attr( $selected_status ) . '>' .	esc_attr( $setting_option["name"] ) .'</option>';
                                    			}
                                    			
                                    		}
                                    		echo '</select>';
                                    		break;
                                    
                                    	default:
                                    		echo "Invalid Field";
                                    		break;
                                    
                                    }
                                    
                                    ?>
                                    
                                </td>
                                <td style="width:100%;">
                                    <?php echo esc_html( $setting['desc'] ); ?>
                                </td>
                            </tr>
                            
                        <?php endforeach; ?>
                        
                    </table>
                    
                </section>
                
            <?php endforeach; ?>
            
            <?php submit_button('','primary amazingaffiliates_submit'); ?>
    
    	</form>
    	
	</div>
	
</main>