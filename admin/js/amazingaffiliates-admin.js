//  product_block
//search fxs
function searchClear() {
    jQuery(".searchbar").val("");
    document.getElementById('search').value = '';
    jQuery('#search').click();
}
function searchGo() {
    document.getElementById('search').value = currentSearch;
    jQuery('#search').click();
}
function searchInput(element) {
    currentSearch = element.value;
}

// common admin
function ctrl_v_this_field(field) {
	navigator.clipboard.writeText(field);
	console.log(field+" copied into the clipboard!");		
}

function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
	tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
	tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

function copyInputShowTaglineRevertBack(e) {
    navigator.clipboard.writeText(jQuery(e.target).val());
    jQuery(e.target).css('width', jQuery(e.target).width() + 'px');
    jQuery(e.target).html( jQuery(e.target)[0].dataset.tagline );
    setTimeout(function() {
        jQuery(e.target).html( jQuery(e.target)[0].dataset.prefix + jQuery(e.target).val() );
        jQuery(e.target).css('width', '');
    }, 900);
}

function product_delete(element) {
	action = "product_delete";
	nonce = jQuery("main").attr("data-nonce");
	button = jQuery(element);
	asin = '';
	asin = jQuery(element).attr("data-asin");
	if (asin == "") { console.log("product already deleted!"); return; }
	if (confirm("Delete product "+asin+"?") == true) {
		console.log("deleting asin = "+asin);
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
                    jQuery(button).css("background-color", "red");
                    jQuery(button).css("color", "white");
                    jQuery(button).html("☠");
                    jQuery(button).attr("data-asin", "");
                    jQuery("#product-"+asin+" *:not(.product_delete)").css("opacity", "0.9");
                    jQuery("#product-"+asin+" *:not(.product_delete)").css("filter", "blur(0.5px)");
                    warehouse_log("Product "+asin+" has been deleted from the database!"); 
                    product_display(displayMode);
                    console.log('success ' + response);
                },
                error: function(response) {
                    console.log('error ' + response);
                    warehouse_log("There are issues in deleting product "+asin); 				 
                }
            }
		);
	}
}

jQuery(document).ready(
    function() {
        
        jQuery("body").on( 'click' , '.tocopy' , function(e) {
            copyInputShowTaglineRevertBack(e);
        });
        
    }
);