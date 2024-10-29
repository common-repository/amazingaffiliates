( function ( blocks, React, serverSideRender, blockEditor ) {
    var el = React.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender,
        useBlockProps = blockEditor.useBlockProps,
		RichText = blockEditor.RichText,
		BlockControls = blockEditor.BlockControls,
		InspectorControls = blockEditor.InspectorControls;
		
    registerBlockType(
        'amazingaffiliates/product', {
        apiVersion: 3,
        title: 'Amazing Product',
        icon: 'star-filled',
        category: 'text',
		
		attributes: {
			refresh: {
                type: 'boolean',
				default: false,
            },
			productid: {
                type: 'string',
				default: '',
            },
			search: {
                type: 'string',
				default: '',
            },
			wrappertitle: {
                type: 'string',
				default: '',
            },
			wrappercolor: {
                type: 'string',
				default: '',
            },
			customtitle: {
                type: 'string',
				default: '',
            },
            customcontentbefore: {
                type: 'string',
				default: '',
            },
			showdetails:{
                type: 'integer',
				default: 3,				
			},
			noprice: {
				type: 'boolean',
				default: false,
			},
			nobuybutton: {
				type: 'boolean',
				default: false,
			}

		},

        edit: 
		function ( props ) {
            var blockProps = useBlockProps();
			
			/* block field prototypes */
			
			var controlscript = el( 
                'script', {},
                'function changeProductid() {	var newProductid = document.getElementById(\'productid\').value; props.setAttributes( { productid: newProductid } );	}',
			);
			
			function textareaFit(e) {
				var cs = window.getComputedStyle(e.target);
				e.target.style.height = "auto";
				e.target.style.height = (e.target.scrollHeight + parseInt(cs.getPropertyValue("border-top-width")) + parseInt(cs.getPropertyValue("border-bottom-width"))) + "px";
			}
			
			function panel( title, content, classes, open=true ) {
				return el( 	'details', {
							className: 'amazingaffiliates_product_field'+' '+classes,
							open: open
							},
							el( 'summary', {
								className: 'panel'
								},
								title
							),								
							content,
				);
			}
			
			function control( title, content ) {
				var label = el( 'label', {
								className: 'label'
								},
								title+':',
				);
				if(title==''){ label = ''; }
				return el( 'div', {
							className: 'control'
							},
							label,
							content
				);
							
			}
			
			function toggle( title, content ) {
				return el( 	'div', {},
							content,
							el( 'label', {}, title	),
				);
			}
			
			function buttonBuild( id, onChange, value ) { 
			    return el( 	'button', {
							id: id,
							onClick: onChange
							},
							value
				);
			}
			
			function selectBuild( id, onChange, value, options ) {
				return el( 	'select', {
							id: id,
							onChange: onChange,
							value: value,
							},
							options,
				);
			}
			
			function textareaBuild( id, onChange, placeholder, value ) {
				return el( 	'textarea', {
							id: id,
							onInput: textareaFit,
							onFocus: textareaFit,
							onChange: onChange,
							onClick: onChange,
							placeholder: placeholder,
							value: value,
							},
				);
			}
			
			function clearableTextareaBuild( id, onChange, placeholder, value, clearid, clearOnClick, cleartext ) {
				return el( 'div', { 
				    className: 'clearableTextarea'
				    },
                    el( 	'textarea', {
							id: id,
							onInput: textareaFit,
							onFocus: textareaFit,
							onChange: onChange,
							onClick: onChange,
							placeholder: placeholder,
							value: value,
							},
                    ),
                    buttonBuild( clearid, clearOnClick, cleartext )
				);
			}
			
			function textinputBuild( id, onChange, placeholder, value ) {
				return el( 	'input', {
							id: id,
							type: 'text',
							onChange: onChange,
							onClick: onChange,
							placeholder: placeholder,
							value: value,
							}
				);
			}
			
			function numberinputValue( id ) {
				var value = document.getElementById(id).value;
				return value;
			}
			function numberinputBuild( id, onChange, placeholder, value, showAll, showMore, showLess, showNone ) {
				
				var buttonClass = 'showcontrol';
				var inputClass = 'shortinput';
				if(showAll=='') {
					buttonClass = 'hiddencontrol';
					inputClass = 'longinput';
				}
				
				return el( 	'div', {
								className: 'numericpanel'
							},
							el( 'div', {
								className: 'numericinput',
								},
								el( 'input', {
									id: id,
									className: inputClass,
									type: 'integer',
									min: -1,
									onChange: onChange,
									placeholder: placeholder,
									disabled: true,
									value: value,
									}
								),
								el( 'button', { 
									onClick: showAll,
									className: buttonClass
									},
									'All'
								),
								el( 'button', { 
									onClick: showMore,
									className: buttonClass
									},
									'+'
								),
								el( 'button', { 
									onClick: showLess,
									className: buttonClass
									},
									'-'
								),
								el( 'button', { 
									onClick: showNone,
									className: buttonClass
									},
									'None'
								),
							),
				);
			}
			
			function switchBuild( id, onChange, value ) {
				return 	el( 	'label', { class:'switch' },
								el(	'input', {
									id: id,
									type: 'checkbox',
									checked: value,
									onChange: onChange,
									value: value,
									}
								),
								el( 'span', { class: 'slider' } ),
						);
			}
			
			/* block fields */
			
			function onChangeRefresh() {
				var newRefresh = document.getElementById('refresh').checked;
                props.setAttributes( { refresh: newRefresh } );
            }
            function onClickRefresh() {
                if( ! document.getElementById('refreshafter').classList.contains("refreshing") ) {
                    document.getElementById('refreshafter').classList.add("refreshing");
                    setTimeout(() => {
                      document.getElementById('refreshafter').classList.remove("refreshing");
                    }, 800 );
                }
            }
			var refresh = el( 'div', {
			    	className: 'refreshdiv'
				},
				
				el(	'label', {
                    for: 'refresh',
                    className: 'container'
                    },
                    
                    el(	'input', {
                        id: 'refresh',
                        type: 'checkbox',
                        checked: props.attributes.refresh,
                        onChange: onChangeRefresh,
                        onClick: onClickRefresh,
                        value: props.attributes.refresh,
                        }
                    ),
                    
                    el( 'span', {
                        id: 'refreshafter',
                        className: 'checkmark'
                        }, '↻'
                    ),
					
				),
				
				el( 'span', {},
				    'Refresh'
				),								
			);

			function onChangeProductid() {
				var newProductid = document.getElementById('productid').value;
                props.setAttributes( { productid: newProductid } );
            }
			function onClickClearproductid() {
				props.setAttributes( { productid: '' } );
            }
			var productid = clearableTextareaBuild( 'productid', onChangeProductid, 'Product ID', props.attributes.productid, 'clearproductid', onClickClearproductid, 'Remove' )
            
			function onChangeSearch( newSearch ) {
				var newSearch = document.getElementById('search').value;
                props.setAttributes( { search: newSearch } );
            }
			var search = textareaBuild( 'search', onChangeSearch, 'Search for the product', props.attributes.search );
			
			function onChangeWrappertitle( newWrappertitle ) {
				var newWrappertitle = document.getElementById('wrappertitle').value;
                props.setAttributes( { wrappertitle: newWrappertitle } );
            }
			var wrappertitle = textareaBuild( 'wrappertitle', onChangeWrappertitle, 'Title', props.attributes.wrappertitle );
			
			function onChangeWrappercolor() {
				var newWrappercolor = document.getElementById('wrappercolor').value;
				props.setAttributes( { wrappercolor: newWrappercolor } );
            }
			var wrappercolor = selectBuild( 'wrappercolor', onChangeWrappercolor, props.attributes.wrappercolor, [
			    el( 'option', { value: 'lightgray' },   'Default' ),
                el( 'option', { value: 'none' },        'None' ),
				el( 'option', { value: '#be9d43' },     'Gold' ),
				el( 'option', { value: '#9a9a9a' },     'Silver' ),
				el( 'option', { value: '#cd7f32' },     'Bronze' ),
				el( 'option', { value: '#516063' },     'Iron' ),
				el( 'option', { value: '#dc3333' },     'Red' ),
				el( 'option', { value: '#ec7f19' },     'Orange' ),
				el( 'option', { value: '#e0ca1f' },     'Yellow' ),
				el( 'option', { value: '#18af5c' },     'Green' ),													
				el( 'option', { value: '#007cba' },     'Blue' ),
				el( 'option', { value: '#9c69c3' },     'Violet' ),
				el( 'option', { value: '#f44c81' },     'Purple' ),
			 ]
			);
			
			function onChangeCustomtitle( newCustomtitle ) {
				var newCustomtitle = document.getElementById('customtitle').value;
                props.setAttributes( { customtitle: newCustomtitle } );
            }
			var customtitle = textareaBuild( 'customtitle', onChangeCustomtitle, '', props.attributes.customtitle );
			
			function onChangeCustomcontentbefore( newCustomcontentbefore ) {
				var newCustomcontentbefore = document.getElementById('customcontentbefore').value;
                props.setAttributes( { customcontentbefore: newCustomcontentbefore } );
            }
			var customcontentbefore = textareaBuild( 'customcontentbefore', onChangeCustomcontentbefore, '', props.attributes.customcontentbefore );
			
			function onChangeShowdetails() {
				var newShowdetails = parseInt( document.getElementById('showdetails').value );
                props.setAttributes( { showdetails: newShowdetails } );
            }
			function showAllShowdetails() {
				props.setAttributes( { showdetails: -1 } );
            }
            function showMoreShowdetails() {
                var newShowdetails = parseInt( document.getElementById('showdetails').value );
				props.setAttributes( { showdetails: newShowdetails+1 } );
            }
            function showLessShowdetails() {
                var newShowdetails = parseInt( document.getElementById('showdetails').value );
				props.setAttributes( { showdetails: newShowdetails-1 } );
            }
            function showNoneShowdetails() {
				props.setAttributes( { showdetails: 0 } );
            }
			var showdetails = numberinputBuild( 'showdetails', onChangeShowdetails, 'List Items', props.attributes.showdetails, showAllShowdetails, showMoreShowdetails, showLessShowdetails, showNoneShowdetails );
			
			function onChangeNoprice() {
				var newNoprice = document.getElementById('noprice').checked;
                props.setAttributes( { noprice: newNoprice } );
            }
			var noprice = switchBuild( 'noprice', onChangeNoprice, props.attributes.noprice );
            
			function onChangeNobuybutton() {
				var newNobuybutton = document.getElementById('nobuybutton').checked;
                props.setAttributes( { nobuybutton: newNobuybutton } );
            }
			var nobuybutton = switchBuild( 'nobuybutton', onChangeNobuybutton, props.attributes.nobuybutton );
			
			var amazingaffiliates_product_block_notice_link = el( 
                'a', {
                    target: '_blank',
                    href: window.location.origin + '/wp-admin/admin.php?page=amazingaffiliates_settings#product_block'
                },
                'settings'
            );
			var amazingaffiliates_product_block_notice = el( 
                'span', {
                    class: 'amazingaffiliates_product_block_notice',
                },
                'For sitewide block customizations go to the plugin\'s ',
                amazingaffiliates_product_block_notice_link,
                ' page'
            );
            
            
            var content = props.attributes.customtitle;
			function onChangeContent( newContent ) {
			    var newContent = document.getElementById('customtitle').value;
				props.setAttributes( { content: newContent } );
			}

            
            return 	el(	
                'div',
				blockProps,
				
				el( ServerSideRender, {
					block: 'amazingaffiliates/product',
					attributes: props.attributes,
					}
				),
				
				el( InspectorControls, {},
					amazingaffiliates_product_block_notice,
					panel( 	'Control Panel' , [
                                control( '', refresh ),
                                control( 'ID', productid ),
                                search,
                                ' ',
                                control( 'Details', showdetails )
						    ],
						    'amazingproductblock'
					),
					panel(	'Customize Product Fields', [
                                control( 'Custom Title', customtitle ),
								control( 'Custom Description', customcontentbefore )
							],
							'amazingproductblockproduct'
					),
					panel( 	'Add a Wrapper' , [
                                control( 'Color', wrappercolor ),
                                control( 'Title', wrappertitle )
							],
							'amazingproductblockwrapper',
							false
					),
					panel( 'Hide Elements', [
                                toggle( 'Price', noprice ),
                                toggle( 'Buy Button', nobuybutton )
							],
							'amazingproductblockhide',
							false
					),
					controlscript,
				)
				
            );
            
            
        },
		
    } );
} )(
    window.wp.blocks,
    window.React,
    window.wp.serverSideRender,
    window.wp.blockEditor
);
