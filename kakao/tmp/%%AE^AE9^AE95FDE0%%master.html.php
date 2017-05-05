<?php /* Smarty version 2.6.13, created on 2012-11-19 18:02:01
         compiled from application/kakaoweb//master.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $this->_tpl_vars['meta']; ?>


<body>
<div id="body">
	<div id="fb-root"></div>
	<script>
	var fbID = <?php echo $this->_tpl_vars['fbID']; ?>
;
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

	<div id="container">
		<?php echo $this->_tpl_vars['mainContent']; ?>

	 </div><!-- end #container -->
	<?php echo $this->_tpl_vars['footer']; ?>

	
</div><!-- end #body -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "application/kakaoweb/widgets/popup_detail.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "application/kakaoweb/widgets/popup_faq.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "application/kakaoweb/widgets/popup_tnc.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="bgpopup">
</div><!-- end #bgpopup-->
</body>
</html>