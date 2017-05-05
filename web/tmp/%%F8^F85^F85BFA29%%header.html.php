<?php /* Smarty version 2.6.13, created on 2012-12-03 10:24:16
         compiled from application/mobile/header.html */ ?>
<div class="page-header" data-role="header">
	<div class="branding"><a href="index.php" rel="external"><img src="<?php echo $this->_tpl_vars['mobiledomain']; ?>
assets/images/logo.jpg" alt="Axis, GSM yang baik" /></a></div>
	
	<div class="wrapper clear">
		 <div id="language">
			<a class="flagen locale" href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
?page=locale&country=2&nexturl=<?php echo $this->_tpl_vars['nexturl']; ?>
" lid="2" >EN</a>
			<a class="flagid locale" href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
?page=locale&country=1&nexturl=<?php echo $this->_tpl_vars['nexturl']; ?>
" lid="1" >ID</a>
		</div><!-- end #language -->
		<div class="search-wrapper">
			<form id="searchTop" name="search-form" class="search-form" method="post" action="">
				<div data-role="fieldcontain" class="input">
					<input type="search"  id="querySearch" name="q" class="search-keyword" placeholder="<?php echo $this->_tpl_vars['locale']['gcs']['search']; ?>
" />
					<input name="lang" type="hidden" value="<?php echo $this->_tpl_vars['locale']['country']; ?>
">	
				</div>
			</form>
		</div>
			
    <?php if ($this->_tpl_vars['isLogin'] && $this->_tpl_vars['user']): ?>
    <div id="loginBox">
        <span class="user-info">Hi, 
        <?php if ($this->_tpl_vars['user']->name): ?> <?php echo $this->_tpl_vars['user']->name; ?>
 <?php echo $this->_tpl_vars['user']->last_name; ?>
 
        <?php else: ?> <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=user&act=changeProfile" class="hoverBig" >please add your name</a>
        <?php endif; ?> </span>
        <a href="logout.php" class="logout">Logout</a>
    </div><!-- end #loginBox -->
    <?php else: ?>	
    <div id="loginBtn">
        <div class="thumbNotLogin"></div>
        <span class="loginText">LOGIN :</span>
               <a class="loginFacebook <?php echo $this->_tpl_vars['facebookButton']; ?>
" href="<?php if ($this->_tpl_vars['fbConnect']):  echo $this->_tpl_vars['fbConnect'];  else: ?>javascript:void(0)<?php endif; ?>">&nbsp;</a>
        <a class="loginTwitter <?php echo $this->_tpl_vars['twConnectButton']; ?>
" href="<?php if ($this->_tpl_vars['twConnect']):  echo $this->_tpl_vars['twConnect'];  else: ?>javascript:void(0)<?php endif; ?>">&nbsp;</a>
        <a class="loginGplus <?php echo $this->_tpl_vars['gplusConnectButton']; ?>
" href="<?php if ($this->_tpl_vars['gplusConnect']):  echo $this->_tpl_vars['gplusConnect'];  else: ?>javascript:void(0)<?php endif; ?>">&nbsp;</a>
           </div><!-- end #loginBtn -->
        
    <?php endif; ?>
	</div>
	
	
	
</div><!-- /header -->

<script>
var postGCS;
var basedomain = "<?php echo $this->_tpl_vars['basedomain']; ?>
";
var mobiledomain = "<?php echo $this->_tpl_vars['mobiledomain']; ?>
";
	<?php echo '
		$(document).ready(function(){
			$("#querySubmit").click(function(){
				searchGCS();
			});
		});
		
		$(document).keypress(function(e) {
			if(e.which == 13) {
				searchGCS();
				return false;
			}
		});
		
		function searchGCS(){
			var t = "#searchTop input[name=\'q\']";
			var lang = "#searchTop input[name=\'lang\']";
			var mediumBanner;
			//medium banner
			$(\'#mainContent\').html(\'<div class="loaders"><img src="\'+basedomain+\'assets/images/loader.png"></div>\');
			$.get(\'index.php?page=gcs&act=search_ajax\', function(mediumBanner){
				google_search(t, lang,function(data){
					if(data != null){
					var str=\'\';
					str+=\'<div class="page-meta"><h1 class="page-title">Hasil Pencarian</h1><div class="page-excerpt">You Search "\'+data.q+\'"</a></div></div>\';
					str+=\'<div class="page-content clear searchContent">\';
							str+=\'<div id="life-film-list" class="page-content-list">\';
								str+=\'<ul data-inset="true" data-role="listview" class="ui-listview ui-listview-inset ui-corner-all ui-shadow">\';
										str+=resultListHTML(data);
								str+=\'</ul>\';
							str+=\'</div>\';
						str+=\'</div>\';
					}else{
						window.location = \'404.html\';
					}
					$(\'.page-body\').html(str);
				});
			});
		}
		
		function resultListHTML(data){
			var str=\'\';				
			$.each(data.items, function(k, v){			
				
				
				str+=\'<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="a" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-corner-top ui-btn-up-a"> <div class="ui-btn-inner ui-li ui-corner-top">\';
					str+=\'<a  href="\'+v.url+\'"  data-transition="slide" class="ui-link-inherit">\';
						if(v.image != ""){
							str+=\'<img src="\'+v.image+\'" class="searchthumbnail ui-li-thumb ui-corner-tl" >\';
						}
						str+=\'<span class="text">\';
							str+=\'<p>\'+v.title+\'</p>\';
							str+=\'<small>\'+v.text+\'</small>\';
						str+=\'</span>\';
					str+=\'</a>\';
				str+=\'</div></li>\';
			});
			return str;
		}
		

	'; ?>

</script>