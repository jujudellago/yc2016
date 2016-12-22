<?php

/*
Plugin Name: Simple Google Analytics Plugin
Plugin URI: http://rachelmccollin.com
Description: Adds a Google analytics trascking code to the <head> of your theme, by hooking to wp_head.
Author: Rachel McCollin
Version: 1.0
 */
function wpmudev_google_analytics() { ?>
	
	<script type="text/javascript">
	//<![CDATA[
	// Set to the same value as the web property used on the site
	var gaProperty = 'UA-6667101-3';

	// Disable tracking if the opt-out cookie exists.
	var disableStr = 'ga-disable-' + gaProperty;
	if (document.cookie.indexOf(disableStr + '=true') > -1) {
	  window[disableStr] = true;
	}

	// Opt-out function
	function gaOptout() {
	  document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
	  window[disableStr] = true;
	//  bootbox.modal("Google Analytics Disabled", "Success");
		alert("Google Analytics Disabled");
	}


	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-6667101-3']);
	  _gaq.push(['_setDomainName', 'yabo-concept.ch']);
	  _gaq.push(['_setAllowLinker', true]);
	 _gaq.push ([ '_ gat._ anonymizeIp']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	//]]>
	</script>
	<?php 
	#<script type="text/javascript">
	#    window.smartlook||(function(d) {
	#    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
	#    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
	#    c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);
	#    })(document);
	#    smartlook('init', '63ea4fbf899988e23a484e1906dfea7a68c2bc82');
	#</script>
	?>
	<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
	<script type="text/javascript">
	    window.cookieconsent_options = {"message":"<?php echo __('This website uses cookies to ensure you get the best experience on our website')?>","dismiss":"<?php echo __('Got it')?>","learnMore":"<?php echo __('More info')?>","link":"<?php echo __('cookie link')?>","theme":"dark-bottom"};
	</script>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
	<!-- End Cookie Consent plugin -->
	

<?php }
add_action( 'wp_head', 'wpmudev_google_analytics', 10 );