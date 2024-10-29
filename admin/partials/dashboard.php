<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php $amazingaffiliates_page = "home";  ?>

<main class="amazingaffiliates_admin_page" >
	
	<div id="navbar" >
		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/navbar.php' ); ?>
	</div>
	
	<div id="header" >
        
        <h1 class="amazingaffiliates_admin_page_title">Amazing Affiliates Dashboard</h1>
		<h2>Here you can access and monitor all the core features of the plugin.</h2>
		
		<br>
		        
        <div style="background-color: #ffd460; text-align: left; width: 100%; padding: 25px; font-size:120%;" >
            
            <big><h2>Hello! Please read the following instructions to set the plugin properly.</h2></big>
            <br>
            <details open>
                <summary><big><strong>Setting up the Amazon Product APIs</strong></big></summary>
                <ol>
                    <li>First of all, you have to set up your Amazon Affiliate ID in order to start using the plugin.</li>
                    <li>Click the <b><a href="/wp-admin/admin.php?page=amazingaffiliates_settings">SET(things)</a></b> button and then <b><a href="/wp-admin/admin.php?page=amazingaffiliates_settings#api_tab">"Amazon APIs Setup"</a></b>.</li>
                    <li>Now insert the required information (operating Country, Partner Tag, Access Key and Secret Key).<br>
                    <i>If you do not know where to find these data, you can find detailed explanations on our <b><a href="/wp-admin/admin.php?page=amazingaffiliates_handbook">FAQ section</a></b>.</i></li>
                </ol>
            
                <big>Once you have inserted the required data on the Amazon APIs Setup Section, you can start using the plugin!</big>
            </details>
            <br>
            <details>
                <summary><big><strong>Inserting a product into your website database</strong></big></summary>
                <ol>
                    <li>Click the <b>"Insert - Workshop"</b> Button and copy paste the product ASIN or url on the dedicated field.</li>
                    <li>Click the <b>"Insert Products"</b> button to create the product block.<br>
                    <i>You can insert one or even more products in bulk.</i></li>
                    <li>Click the <b>"Clear"</b> Button to clear the data field.</li>
                </ol>
                
                <big>Congratulations! You have now created a product block that can be displayed wherever you like to on your blog post.</big>
            </details>
            <br>
            <details>
                <summary><big><strong>Inserting a product into a post</strong></big></summary>
                <ol>
                    <li>Click on the Product ID and it will be automatically copied.</li>
                    <li>Now go on the blog post where you want to display the product and use the Gutenberg Block Editor.</li>
                    <li>Search for <b>"Amazing Product"</b> Block and select it.</li>
                    <li>You will see a control Panel on the right side of the screen where you must insert the Product ID of the product that you want to display.<br>
                    <i>If you copied it from the <b>"Insert - Workshop"</b> Section, then you can simply paste it there. Otherwise you can use the search field integrated in the "Amazing Product" Block to find the ID of the product that you'd like to insert.</i></li>
                </ol>
                
                <big>Hit save and preview. Congratulations! Now you can enjoy your post with a beautiful affiliate product block displayed inside!</big>
            </details>
            <br>
            <details>
                <summary><big><strong>Customizing the product information</strong></big></summary>
                <br>
                <strong>Locally, in the post</strong>
                <ol>
                    <li>From the Control Panel of the "Amazing Product" Block you can customize the title and description, hide some elements and attach a "wapper" to make the product display even more eye-catching!<br>
                    <i>Or you can keep the standard product information from Amazon APIS and adjust the number of bullet lines to be displayed.</i></li>
                </ol>
                <big>Please notice that all these customized information will be displayed on that specific blog post where you decided to insert the product block.</big>
                <br><br>
                <strong>Sitewide, changing the default data displayed</strong>
                <ol>
                    <li>On the <b>"Edit- Warehouse"</b> section you can edit the product title and it will become the new "default" title of that product on all the blog posts where that product is inserted.</li>
                </ol>
                <big>Now you should be ready to use the plugin! Thank you for your attention and enjoy!</big>
            </details>
            
            <br><br>
            <i>P.S.: We would really love to know if you like the plugin! <b>Your opinion is important for us!</b> Please let us know with a <b><a href="https://wordpress.org/plugins/amazingaffiliates/#reviews" target="_blank" rel="noopener">review</a></b>! Thank you for the support!</i>
            
        </div>
		
	</div>
	
	<div id="dashboard" >

		<a class="dashboard_menu_item insert" 	href="?page=amazingaffiliates_workshop" >
			<h2><big>Insert</big><br><i>new products</i></h2>
			<p><b>Bulk import & update</b> products into your database</p>
		</a>

		<a class="dashboard_menu_item edit" 	href="?page=amazingaffiliates_warehouse" >
			<h2><big>Edit</big><br><i>custom details</i></h2>
			<p><b>Edit & customize</b> product details and specifics</p>
		</a>

		<a class="dashboard_menu_item learn" 	href="?page=amazingaffiliates_handbook" >
			<h2><big>Learn</big><br><i>more</i></h2>
			<p><b>Master</b> the plugin's functionalities or <b>troubleshoot</b> any issues with the FAQs</p>
		</a>
		
		<a class="dashboard_menu_item settings" 	href="?page=amazingaffiliates_settings" >
			<h2><big>Set</big><br><i>things</i></h2>
			<p><b>Add</b> your affiliate <b>IDs</b> and <b>API keys</b> and adjust the <b>advanced settings</b></p>
		</a>

	</div>
	
</main>