function important_field_missing_alert(cssSelector) {
    if( jQuery( cssSelector ).attr('data-saved-value') == '' || jQuery( cssSelector ).attr('data-saved-value') == '{"name":"- SELECT -","amazon_domain":"","pa_endpoint":"","region":""}' ) {
        jQuery( cssSelector ).addClass( 'missing_value' );
    }
    jQuery( 'tr').removeClass( 'missing_value_row' );
    jQuery( 'tr[data-saved-value=""]').addClass( 'missing_value_row' );
}

jQuery(document).ready( function() {
    
    jQuery(".amazingaffiliates_tab").tabs();
    
    important_field_missing_alert( 'select[name="amazingaffiliates_settings_api_country"]' );
    important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_partner_tag"]' );
    important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_accessKey"]' );
    important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_secretKey"]' );
    
    jQuery( "input" ).on( "change keyup mouseup paste", function(e) {
        important_field_missing_alert( 'select[name="amazingaffiliates_settings_api_country"]' );
        important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_partner_tag"]' );
        important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_accessKey"]' );
        important_field_missing_alert( 'input[name="amazingaffiliates_settings_api_secretKey"]' );
    });
});
