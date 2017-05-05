<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb//master.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<?php echo $this->_tpl_vars['meta']; ?>

<body class="<?php if ($this->_tpl_vars['locale']['country'] == 1): ?>lang-ID<?php else: ?>lang-EN<?php endif; ?>">
<div id="body">
	<div id="fb-root"></div>
	<script>
	var fbID = <?php if ($this->_tpl_vars['fbID']):  echo $this->_tpl_vars['fbID'];  else: ?>0<?php endif; ?>;
	<?php echo '
	  window.fbAsyncInit = function() {
		FB.init({
		  appId      : fbID, // App ID
		 // channelUrl : \'//WWW.YOUR_DOMAIN.COM/channel.html\', // Channel File
		  status     : true, // check login status
		  cookie     : true, // enable cookies to allow the server to access the session
		  xfbml      : true  // parse XFBML
		});

		// Additional initialization code here
	  };

	  // Load the SDK Asynchronously
	 (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));
	'; ?>

	</script>
	<?php echo $this->_tpl_vars['header']; ?>

	<div id="mainContent">
	<?php echo $this->_tpl_vars['mainContent']; ?>

	</div>
	<?php echo $this->_tpl_vars['footer']; ?>

	
</div><!-- end #body -->

<?php echo '
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-7659873-1\']);
  _gaq.push([\'_setDomainName\', \'axisworld.co.id\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\'  : \'http://www\')  + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
'; ?>

</body>
</html>