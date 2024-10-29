<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php $amazingaffiliates_page = "learn";  ?>

<main class="amazingaffiliates_admin_page" >
	
	<div id="navbar" >
		<?php require( AMAZINGAFFILIATES_PLUGIN_URI . '/admin/partials/navbar.php' ); ?>
	</div>
	
	<div id="header" >
		
		<h1 class="amazingaffiliates_admin_page_title" >Amazing Affiliates Handbook</h1>
		<h2>Learn how to use the plug in properly</h2>
		<p>Here you can find out which are the key features of the plugin, how to set it up and a tutorial on how it works! You can also find a useful FAQ Section that is always under development.</p>
		
	</div>
	
	<div class="tab">
	  <button class="tablinks" onclick="openTab(event, 'features')">Features</button>
	  <button class="tablinks" onclick="openTab(event, 'setup')">Setup</button>
	  <button class="tablinks" onclick="openTab(event, 'tutorial')">Tutorial</button>
	  <button class="tablinks" onclick="openTab(event, 'faqs')">FAQs</button>
	</div>
	
	<section id="features" class="tabcontent" >
		<h2>Features</h2>
        <ol>
            <li>Automatically Import Amazon Product Data (PA API 5.0)</li>
            <li>Beatifully designed Product Displays for Desktop and Mobile Devices</li>
            <li>Product Management Dashboard</li>
            <li>Easy to use. No coding required</li>
            <li>SEO Optimized (New Window, NoFollow, and Sponsored link attributes)</li>
            <li>Customize Product title and description directly in the post</li>
            <li>Add Product Wrapper to the product display to make it more eye cathcing</li>
            <li>Automatic Product Stock Availability Checker</li>
        </ol>
	</section>
	
	<section id="setup" class="tabcontent" >
		<h2>How to setup the plugin</h2>
		<p>First of all, you have to set up your Amazon Affiliate ID in order to start using the plugin.</p>
		<ol>
		    
		    <li>Click the "SET(things)" button and then "Amazon APIs Setup".</li>
		    <li>Now insert the required information (operating Country, Partner Tag, Access Key and Secret Key).<br><i>If you do not know where to find these data, you can find detailed explanations on our FAQ section.</i></li>
		    <li>Once you have inserted the required data on the Amazon APIs Setup Section, hit "Save" and you can start using the plugin!</li>
		</ol>
	</section>
	
	<section id="tutorial" class="tabcontent" >
		<h2>Let's create your first product together!</h2>
		<ol>
		    <li>Go to the Workshop by clicking the <span style="border:1px solid coral;border-radius:5px;padding:2px 5px;">Insert</span> Button</li>
		    <li>Copypaste the product ASIN or url on the first field where you read <span style="border:1px solid lightgray;border-radius:5px;padding:2px 5px;">Paste the ASIN or the link   </span></li>
		    <li>If what you copypasted contains a valid ASIN, the list below will spawn a new row with that ASIN<br><i>Tip: You can insert more products in this list by copypasting other ASINs or links</i></li>
		    <li>Click the <span style="border:1px solid lightgray;border-radius:5px;padding:2px 5px;background-color:#f5f5f5;">Insert Products</span> button to start creating the product.<br><i>Tip:Click the "Clear" Button to clear the list</i></li>
		</ol>
		<p>Congratulations! You have now created a product that can be displayed wherever you like to with a block in your blog post.</p>
		
		<h2>Let's add your newly created product into a post! <small>(with Gutenberg blocks)</small></h2>
		<ol>
		    <li>Click on the Product ID of the product you have just created and it will be automatically copied</li>
		    <li>Now go to the blog post where you want to display the product and use the Gutenberg Block Editor</li>
		    <li>Search for the "Amazing Product" Block and select it</li>
		    <li>Once you have added the block in your post you will see a control Panel on the right side of the screen where you must insert the Product ID of the product that you want to display. Paste the ID there.<br>Tip: Otherwise you can use the search field integrated in the "Amazing Product" Block to find the ID of the product that you'd like to insert</li>
		    <li>The block will load the data of the product as soon as you insert the ID. Now just save the post and your are done!</li>
		</ol>
        <p>It's as simple as that! Now you are easily populating your posts with products!</p>
        
        <h2>Let's customize your product blocks</h2>
        <p>From the Control Panel of the "Amazing Product" Block you can also customize the title and description, hide some elements and attach a "wrapper" to make the product display even more eye-catching! Or you can keep the standard product information from Amazon APIS and adjust the number of lines to be displayed.</p>
        <i>Please notice that what you customize on the post remains in the post. If you want to edit the title website-wide you have to edit the product itself. Let's see how!</i>
        
        <h2>Let's edit your product with sitewide customizations</h2>
        <p>Sometimes the product is already perfect, sometimes it requires some adjustements.</p>
        <p>You can customize things like the product title on a sitewide level if you edit it in the product page itself!</p>
        <ol>
            <li>Go to the Warehouse by clicking the <span style="border:1px solid mediumseagreen;border-radius:5px;padding:2px 5px;">Edit</span> Button</li>
            <li>Search the product you want to edit among the ones that you have already added to your website. <i>Tip: use the filters to find it quickly!</i></li>
            <li>Click on the "Edit"<span style="border: 1px solid gold; border-radius: 5px; padding: 3px 1px 0 1px;" ><img alt="" width="16" height="16" src="<?php echo esc_attr( AMAZINGAFFILIATES_PLUGIN_URL . '/admin/img/edit.jpg' ); ?>" ></span> button to open the product editing</li>
            <li>Scroll and search for the editable fields (they are green).</li>
            <li>Save and you are done.</li>
        </ol>
        <p>Now the changes that you made to the product are the new default values for the product blocks, sitewide.</p>
        <i>Please notice that the customizations applied to a specific Amazing Product Block on a specific post through the control panel override the sitewide defaults on that particular post.</i>
	</section>
	
	<section id="faqs" class="tabcontent" >
		<h2>FAQs</h2>
		<?php
		    $faqs[1]['question']    = 'Is the plugin compatible with PA-API 5?';
            $faqs[1]['answer']      = 'Yes. The plugin is compatible with PA-API (Amazon Product Advertising API) 5.0. The PA-API 4 is no longer available as of 10/31/2019 so if you are still using API keys of the old API, you need to reissue them.';
            $faqs[2]['question']    = 'Do I need Amazon Associate ID to use this plug-in?';
            $faqs[2]['answer']      = 'Yes, you need to insert your Amazon Associate ID in order to properly set the plugin and get your affiliatation revenue.';
            $faqs[3]['question']    = 'Where can I find the Amazon Partner Tag, Access Key and Secret Key?';
            $faqs[3]['answer']      = 'For your Amazon Partner tag you have to enter  your Amazon Affiliate Account and click on the "manage tracking id" drop-down under your email address (upper right side of the screen) and select your preferred tracking ID.<br>For  your Amazon Access Key and Secret Key click the ‘Tools’ drop-down on the Amazon Affiliate Dashboard.  Then click the "Product Advertising API"option.  Under the “manage your credentials category” you can view your existing access keys or “Add Credentials” , and then download your keys using the “Download Credentials” option.';
            $faqs[4]['question']    = 'What can I do on the Product Block Settings?';
            $faqs[4]['answer']      = 'On the Product Block Settings you can decide to display an offer banner inside the Product Block that activates whenever the product has a discount. You can also set the minimum discount threshold (by percentage) to show the offer banner.';
            $faqs[5]['question']    = 'What can I do on the Product Pages Settings?';
            $faqs[5]['answer']      = 'On the Product Pages Settings you can decide whether to leave the Product Pages visible on the frontend for the public or keep them private.These Product Pages have no content by default, hence you can populate them with the Product Block using the “Auto Add Content to Product Pages” setting.';
		?>
		
		<?php $i = 0; ?>
		<?php foreach($faqs as $faq) : ?>
		    <details <?php if($i++==0)echo esc_attr( 'open' ); ?> >
		        <summary><big><b><?php echo esc_html( $faq['question'] ); ?></b></big></summary>
		        <p><?php echo esc_html( $faq['answer'] ); ?></p>
		    </details>
		    <br>
		<?php endforeach; ?>

	</section>
	
</main>