<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb//meta.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'application/axisweb//meta.html', 14, false),array('modifier', 'replace', 'application/axisweb//meta.html', 14, false),)), $this); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta property="og:title" content="<?php echo $this->_tpl_vars['metaTag']['title']; ?>
"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/<?php echo $this->_tpl_vars['metaTag']['image']; ?>
"/>
<meta property="og:url" content="<?php echo $this->_tpl_vars['metaURL']; ?>
"/>
<meta property="og:site_name" content="AXIS - GSM YANG BAIK"/>
<meta property="og:description" content="<?php echo $this->_tpl_vars['metaTag']['content']; ?>
"/>
<meta property="fb:app_id" content="<?php echo $this->_tpl_vars['fbID']; ?>
"/>
<meta name="description" content="AXIS TELEKOM INDONESIA OFFICIAL SITE">
<meta name="keywords" content="axis,axisgsm,sms,promo,product,produk">
<meta name="author" content="AXIS TELEKOM INDONESIA">
<title> <?php if ($this->_tpl_vars['metaTag']['title']): ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['metaTag']['title'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', ' ') : smarty_modifier_replace($_tmp, '_', ' ')); ?>
 - <?php else: ?> <?php if ($this->_tpl_vars['currentpage']): ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['currentpage'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', ' ') : smarty_modifier_replace($_tmp, '_', ' ')); ?>
 - <?php endif; ?>  <?php if ($this->_tpl_vars['currentType']): ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['currentType'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', ' ') : smarty_modifier_replace($_tmp, '_', ' ')); ?>
 - <?php endif; ?> <?php endif; ?> AXIS TELEKOM INDONESIA</title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/custom-theme/jquery-ui-1.9.0.custom.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/axis.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/skins/tango/skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/jscrollpane.css" />
<link rel="icon"  type="image/png" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
/images/favicon.ico" />
<link rel="icon"  type="image/png" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
/images/favicon.png" />

<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/ie7.css">
<![endif]-->
<!--[if gt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/ie8.css" />
<![endif]-->

<noscript>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assets_domain']; ?>
css/nojs.css" />
</noscript>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery-ui-1.9.0.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/scroll-startstop.events.jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/detectBrowser.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/modernizr.custom.28468.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.cslider.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/customform.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/axis.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/gl.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/kipagination.js"></script>
</head>
<?php echo '
	<script>
		var basedomain = "{$basedomain}";
	</script>
'; ?>

<!-- s : modules JS -->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/content_detail.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/social_content_detail.js"></script>
<script  type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.Jcrop.js"></script>
<script  type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/jquery.form.js"></script>
<script  type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/validatious-custom-0.9.1.min.js"></script>
<script  type="text/javascript" src="<?php echo $this->_tpl_vars['assets_domain']; ?>
js/locale/errors.<?php if ($this->_tpl_vars['locale']['js'] == '1'): ?>id<?php else: ?>en<?php endif; ?>.js"></script>
<!-- e : module JS -->

<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
<?php echo '
	$(document).ready(function(){
		{parsetags: \'explicit\'}
	});
'; ?>

</script>