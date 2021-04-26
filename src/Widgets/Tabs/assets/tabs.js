(function($) {
    $( document ).ready( function() {
    	var selectedTabId = sessionStorage.getItem("yii2wpSelectedTab");
	    selectedTabId = selectedTabId === null ? 0 : selectedTabId;
	    $("#yii2wp_settings_tabs_wrapper").tabs({
	        active: selectedTabId,
	        activate : function( event, ui ) {
	            selectedTabId = $("#yii2wp_settings_tabs_wrapper").tabs("option", "active");
	            sessionStorage.setItem("yii2wpSelectedTab", selectedTabId);
	        }
	    });
        $( '.yii2wp-tab' ).css( 'min-height', $( '#yii2wp_settings_tabs' ).css( 'height' ) );
    });
})(jQuery);