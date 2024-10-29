<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="amazingaffiliates_custom_meta_metabox" > 
    <?php wp_nonce_field( 'amazingaffiliates_metabox', 'amazingaffiliates_metabox_field' ); ?>
    
<?php foreach( array_keys($this->custom_post_meta) as $post_type_target ) : ?>
    <?php if( get_post_type() == $post_type_target ) : ?>
        <?php foreach( array_keys($this->custom_post_meta[$post_type_target]) as $custom_post_meta_group_key ) : ?>
           
            <div class="amazingaffiliates_custom_fields_group" >
                <p class="amazingaffiliates_custom_fields_group_title" ><?php echo esc_html( $this->custom_post_meta_groups[$custom_post_meta_group_key]['group_name'] ); ?></p>
                
                <?php foreach( $this->custom_post_meta[$post_type_target][$custom_post_meta_group_key] as $custom_post_meta ) : ?>
                    <?php $field_content = get_post_meta( get_the_ID(), $custom_post_meta['slug'], true ); ?>
                    
                    <div class="amazingaffiliates_custom_fields <?php echo esc_attr( $custom_post_meta['metabox_classes'] ); ?>" >
                        <label for="<?php echo esc_attr( $custom_post_meta['slug'] ); ?>"><?php echo esc_html( $custom_post_meta['name'] ); ?></label>
                        
                        <?php
                        switch ( $custom_post_meta['metabox'] ) {
                            case 'display':
                                echo '<p id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >';
                                if( $field_content == '' ) { echo '-'; }
                                else { echo wp_kses_post( $field_content ); }
                                echo '</p>';
                                break;
                            case 'displaylink':
                                echo '<a id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" href="' . esc_url( $field_content ) . '" >';
                                if( $field_content == '' ) { echo '-'; }
                                else {  echo wp_kses_post( $field_content ); }
                                echo '</a>';
                                break;
                            case 'displayx100':
                                echo '<p id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >';
                                if( $field_content == '' ) { echo '-'; }
                                else { echo wp_kses_post( $field_content ) . '%'; }
                                echo '</p>';
                                break;
                            case 'displaybool':
                                echo '<p id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >';
                                if( $field_content == '' ) { echo '-'; }
                                else { 
                                    if( $field_content == 1 ) { echo 'TRUE'; }
                                    if( $field_content == 0 ) { echo 'FALSE'; }
                                }
                                echo '</p>';
                                break;
                            case 'displayjson':
                                echo '<pre id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >';
                                if( $field_content == '' AND ! is_null( json_decode( $field_content ) ) ) { echo '-'; }
                                else { 
                                    echo wp_kses_post( wp_json_encode( json_decode( $field_content , null , 2048 , JSON_INVALID_UTF8_IGNORE ), JSON_PRETTY_PRINT ) );
                                }
                                echo '</pre>';
                                break;
                            case 'details':
                                echo '<details id="' . esc_attr( $custom_post_meta['slug'] ) . '" closed ><summary>Dump</summary><p>';
                                if( $field_content == '' AND ! is_null( json_decode( $field_content ) ) ) { echo '-'; }
                                else { echo wp_kses_post( $field_content ); }
                                echo '</p></details>';
                                break;
                            case 'image':
                                echo wp_get_attachment_image( $field_content , "thumbnail" );
                                echo '<p id="' . esc_html( $custom_post_meta['slug'] ) . '" type="text" >';
                                if( empty($field_content) ) { echo '-'; }
                                else { 
                                    echo wp_kses_post( $field_content );
                                }
                                echo '</p>';
                                break;
                            case 'time':
                                echo '<p id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >';
                                echo wp_kses_post( $field_content );
                                if(is_numeric($field_content)) {
                                    echo ' - ' . esc_html( gmdate('d F Y H:i:s',$field_content) ) . ' GMT</p>';
                                }
                                else {
                                    echo '-';
                                }
                                break;
                            case 'input':
                                echo	'<input name="' . esc_attr( $custom_post_meta['slug'] ) . '" id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" value="' . esc_attr( $field_content ) . '">';
                                break;
                            case 'textarea':
                                echo	'<textarea name="' . esc_attr( $custom_post_meta['slug'] ) . '" id="' . esc_attr( $custom_post_meta['slug'] ) . '" type="text" >' . esc_attr( $field_content ) . '</textarea>';
                                break;
                            case 'editor':
                                $editor_content = get_post_meta( get_the_ID(), $custom_post_meta['slug'], true );
                                $editor_id = $custom_post_meta['slug'];
                                $editor_settings = array(
                                    'textarea_name' => $custom_post_meta['slug'],
                                    'textarea_rows' => 5
                                 );
                                wp_editor($editor_content, $editor_id);
                                break;
                        }
                        ?>
                        
                        </div>
                    
                <?php endforeach; ?>
                
            </div>
            
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

</div>