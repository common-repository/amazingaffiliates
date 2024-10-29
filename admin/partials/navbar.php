<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<nav id="amazingaffiliates_navbar">
    
    <?php if( $amazingaffiliates_page == "home" ): ?>
        <span class="navbar_menu_current_item home" 	    >Amazing Affiliates</span>
    <?php else: ?>
        <a class="navbar_menu_item home" 	            href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_menu"              >Amazing Affiliates</a>
    <?php endif; ?>

    <?php if( $amazingaffiliates_page == "insert" ): ?>    
        <span class="navbar_menu_current_item insert" 	    >Insert</span>
    <?php else: ?>
        <a class="navbar_menu_item insert" 	            href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_workshop"  >Insert</a>
    <?php endif; ?>

    <?php if( $amazingaffiliates_page == "edit" ): ?>    
        <span class="navbar_menu_current_item edit" 	>Edit</span>
    <?php else: ?>
        <a class="navbar_menu_item edit" 	        href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_warehouse"     >Edit</a>
    <?php endif; ?>

    <?php if( $amazingaffiliates_page == "learn" ): ?>
        <span class="navbar_menu_current_item learn" 	>Learn</span>
    <?php else: ?>
        <a class="navbar_menu_item learn" 	        href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_handbook"     >Learn</a>
    <?php endif; ?>
    
    <?php if( $amazingaffiliates_page == "settings" ): ?>
        <span class="navbar_menu_current_item settings" 	>Set</span>
    <?php else: ?>
        <a class="navbar_menu_item settings" 	        href="<?php echo esc_url( get_admin_url() ); ?>admin.php?page=amazingaffiliates_settings"     >Set</a>
    <?php endif; ?>

</nav>