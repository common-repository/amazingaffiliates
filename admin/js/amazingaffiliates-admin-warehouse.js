var displayMode = 'warehouse';
var ajax = '';
var nonce = '';

const warehouse_title_selector 					= jQuery("#warehouse_title_selector");
const warehouse_asin_selector 					= jQuery("#warehouse_asin_selector");
const warehouse_entries_selector 				= jQuery("#warehouse_entries_selector");

const warehouse_amazing_product_category_selector 		= jQuery("#warehouse_amazing_product_category_selector");
const warehouse_amazing_product_tag_selector 			= jQuery("#warehouse_amazing_product_tag_selector");

let lastTimestamp = 0;
let timeElapsed;
function warehouse_log(message, mode = 'normal') {
	var now = new Date();
	timeElapsed = Math.ceil( (now.getTime() - lastTimestamp) / 10 ) / 100;
	lastTimestamp = now.getTime();			
	var timestamp = now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
	var logText = message;
	if(mode=='normal') 	logText = "["+timestamp+"] "+ message + "<br>";
	if(mode=='pending') logText = "["+timestamp+"] "+ message;
	if(mode=='update') 	logText = message + " [+"+timeElapsed+"s]" + "<br>";
	jQuery("#console").append(logText);
}

function product_display(mode = 'warehouse') {
	var action = "product_display";
	var asin = '';
	asin = jQuery("#warehouse_asin_selector").val();
	var title = '';
	title = jQuery("#warehouse_title_selector").val();
	var entries = '';
	entries = jQuery("#warehouse_entries_selector").val();
	
	var amazing_product_category = jQuery('#warehouse_amazing_product_category_selector input:checked').map(function () {
        return this.value;
    }).get();
    
	var amazing_product_tag = jQuery('#warehouse_amazing_product_tag_selector input:checked').map(function () {
        return this.value;
    }).get();
    
    amazing_product_category.toString();
    amazing_product_tag.toString();
	
	jQuery.ajax(
        ajax, {
            method : "POST",
            dataType : "json",
            data : {
                action: action,
                nonce: nonce,
                mode: mode,
                title: title,
                asin: asin,
                entries: entries,
                amazing_product_category: amazing_product_category,
                amazing_product_tag: amazing_product_tag
            },
            success: function(response) {
                jQuery("#product_display").html(response);
            },
            error: function(response) {
                warehouse_log('ERROR! Impossible to update the list!');				 
            }
        }
	);
}

function copy_field(field) {
	navigator.clipboard.writeText(field);
	console.log(field+" copied into the clipboard!");		
}

function product_update(asin , prod_id , element) {

	if(element!='') {   
		jQuery(element).css({
			'webkit-transform':'rotate(360deg)', 
			'-moz-transform':'rotate(360deg)',
			'transform':'rotate(360deg)'
		});
	}

	var action = "product_update";
	warehouse_log("Product "+asin+" with id ["+prod_id+"] is being updated...", 'pending');

	jQuery.ajax(
		ajax, {
			method : "POST",
			dataType : "json",
			data : {
                action: action,
                nonce: nonce,
                asin: asin
			},
			success: function(response) {
				jQuery("#product-"+asin).html(response);
				warehouse_log(' ...Done!', 'update');
				product_display(displayMode);
			},
			error: function(response) {
				warehouse_log(' ...FAILED!', 'update');
			}
		}
	);

}

function asinsCrucible() {
	jQuery("#asins_crucible").html('');
	let crucibled_asins = jQuery("#asins_crucible")[0].dataset.asin;
	if(crucibled_asins=='') { 
		crucibled_asins = [];
	}
	else {
		crucibled_asins = crucibled_asins.split(",")
	}
	if(crucibled_asins.length < 1) {
		   jQuery("#asins_crucible").append('<p class="crucibled_asin">Insert a link or an ASIN in the field above</p>');
	}
	crucibled_asins.forEach(
		(asin) => {
			jQuery("#asins_crucible").append('<li class="crucibled_asin">'+asin+' <button onclick="removeAsin(\''+asin+'\');">⨯</button></li>');
		}
	)
}

function product_link_purify(event) {
	let crucibled_asins = jQuery("#asins_crucible")[0].dataset.asin;
	if(crucibled_asins=='') { 
		crucibled_asins = [];
	}
	else {
		crucibled_asins = crucibled_asins.split(",")
	}
	let url = '';
	let asin_prospected = '';
	let asin_prospected_alt = '';
	let asin_prospected_short = '';
	let asin_to_go = '';
	url = jQuery(event.target).val();
	asin_prospected = url.match("(?:[/])([A-Z0-9]{10})(?:[\/|\?|\&|\s])");
	asin_prospected_alt = url.match("(?:[/])([A-Z0-9]{10})(?:[\/|\?|\&|\s])");
	asin_prospected_short = url.match("([A-Z0-9]{10})");
	
	if (asin_prospected != null) {
		asin_to_go = asin_prospected[1];
	}
	else if (asin_prospected_alt != null) {
		asin_to_go = asin_prospected_alt[1];
	}
	else if (asin_prospected_short != null) {
		asin_to_go = asin_prospected_short[1];
	}
	else if (url!="") {
		asin_to_go = false;
	}
	if(asin_to_go) {
		if(! crucibled_asins.includes(asin_to_go)) {
			crucibled_asins.push(asin_to_go);
		}
	}
	jQuery("#asins_crucible")[0].dataset.asin = crucibled_asins.join(",");
	
	jQuery(event.target).val("");
	
	asinsCrucible();
}

function removeAsin(asin_to_remove='') {
	
	let crucibled_asins = jQuery("#asins_crucible")[0].dataset.asin;
	if(crucibled_asins=='') { 
		crucibled_asins = [];
	}
	else {
		crucibled_asins = crucibled_asins.split(",")
	}
	if(crucibled_asins.includes(asin_to_remove)) {
			let i = 0;
			let new_crucibled_asins = [];
			crucibled_asins.forEach(
				(asin) => {
					if(asin != asin_to_remove) new_crucibled_asins.push(asin);
				}
			);

			crucibled_asins = new_crucibled_asins;
	}
	jQuery("#asins_crucible")[0].dataset.asin = crucibled_asins.join(",");
	asinsCrucible();
	
}

function clearAsinCrucible() {
	let crucibled_asins = jQuery("#asins_crucible")[0].dataset.asin;
	if(crucibled_asins=='') { 
		crucibled_asins = [];
	}
	else {
		crucibled_asins = crucibled_asins.split(",")
	}
	crucibled_asins.forEach(
		(asin) => {
			removeAsin(asin);
		}
	);
	
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms))
}

function product_create() {

	action = "product_create";
	asin = '';
	asin = jQuery("#asins_crucible").attr("data-asin");

	let verb = "is";
	if(asin.length > 10) { verb = "are"; }
	warehouse_log("Product "+asin+" "+verb+" being added to the database...");

	jQuery.ajax(
		ajax, {
			method : "POST",
			dataType : "json",
			data : {
                action: action,
                nonce: nonce,
                asin: asin
			},
			success: function(responses) {
				responses.forEach( (response) => {
					warehouse_log(response.split('#')[1]);
				});
				let i = 0;
				responses.forEach( (response) => {
					sleep((i+1) * 1000).then(() => { product_update( response.split('#')[0].split('&')[0] , response.split('#')[0].split('&')[1] ); });
					i++;
				});
				sleep((i+2) * 1000).then(() => { warehouse_log("Product "+asin+" "+verb+" up to date and inside the database!");  });
			},
			error: function(response) {
				warehouse_log("[Something went wrong] "+response);
			}
		}
	);
}

jQuery(document).ready(
    function() {
        ajax = jQuery("main").attr( "data-ajax" );
        nonce = jQuery("main").attr( "data-nonce" );
        
        jQuery("#warehouse_asin_selector").on('paste keyup mouseup change', function(e) {
            let url = jQuery(this).val();
            let asin_prospected = url.match("(?:[/])([A-Z0-9]{10})(?:[\/|\?|\&|\s])");
            if (asin_prospected != null) { jQuery(this).val(asin_prospected[1]); }
        });
        jQuery("#warehouse_entries_selector").on('change', function(e) 	{ product_display(displayMode); } );
        jQuery("#warehouse_amazing_product_category_selector").on('change', function(e) { product_display(displayMode); } );
        jQuery("#warehouse_amazing_product_tag_selector").on('change', function(e) { product_display(displayMode); } );
        jQuery("#warehouse_title_selector").on('keyup mouseup change', function(e) { product_display(displayMode); } );
        jQuery("#warehouse_asin_selector").on('keyup mouseup change', function(e) { product_display(displayMode); } );
        
        jQuery("#asins_raw").on('keyup mouseup change paste mousedown tap', function(e) { product_prepare(e); } );
        jQuery("#insert_products").click( function(e) { product_create(e);	});
        
        jQuery("#asin_purifier").on( 'keyup change', function(e) { product_link_purify(e); } );
        
        jQuery("#expand").click( function(e) { 
            jQuery("#console").toggleClass( "extended" );
            if( jQuery("#expand").html() == "+ More +" ) {
               jQuery("#expand").html("- Less -");
            }
            else {
                jQuery("#expand").html("+ More +");
            }
        });
        
        product_display(displayMode);
        asinsCrucible();
        
    }
);