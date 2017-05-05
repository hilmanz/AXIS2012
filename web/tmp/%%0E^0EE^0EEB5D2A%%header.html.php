<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb//header.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'encrypt', 'application/axisweb//header.html', 56, false),)), $this); ?>
<div id="headContainer">
    <div id="head">
        <div id="top">
            <a id="logo" href="<?php echo $this->_tpl_vars['basedomain']; ?>
index.php">&nbsp;</a>
            <ul id="topNav">
                <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/kartu"><?php echo $this->_tpl_vars['locale']['nav']['kartuaxis']; ?>
</a></li>
                <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/internet"><?php echo $this->_tpl_vars['locale']['nav']['internet']; ?>
</a></li>
                <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
coverage"><?php echo $this->_tpl_vars['locale']['nav']['coverage']; ?>
</a></li>
                				                <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
isi_ulang"><?php echo $this->_tpl_vars['locale']['nav']['isiulang']; ?>
</a></li>
                <li><a href="http://net.axisworld.co.id" target="_blank">AXIS Net</a></li>
                <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
customer_care"><?php echo $this->_tpl_vars['locale']['nav']['customercare']; ?>
</a></li>
            </ul><!-- end #topNav -->
			
			<?php if ($this->_tpl_vars['isLogin'] && $this->_tpl_vars['user']): ?>
			<div id="loginBox">
            	<div class="thumbSmallUser">
				<?php if ($this->_tpl_vars['user']->img != ""): ?><a href="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['userpage']; ?>
"><img src="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/user/photo/<?php echo $this->_tpl_vars['user']->img; ?>
" /></a>
				<?php else: ?><a href="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['userpage']; ?>
"><img src="<?php echo $this->_tpl_vars['user']->socmed; ?>
" /></a>
				<?php endif; ?>
				</div>
                <span class="user-info">Hi, 
				<?php if ($this->_tpl_vars['user']->name): ?> <?php echo $this->_tpl_vars['user']->name; ?>
 <?php echo $this->_tpl_vars['user']->last_name; ?>
 
				<?php else: ?> <a href="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['userpage']; ?>
/changeProfile" class="hoverBig" >please add your name</a>
				<?php endif; ?>
				</span>
                              	<a href="logout.php" class="logout">Logout</a>
            </div><!-- end #loginBox -->
			<?php else: ?>	
            <div id="loginBtn">
				<div class="thumbNotLogin"></div>
                <span class="loginText">LOGIN :</span>
                               <a class="loginpopup loginFacebook <?php echo $this->_tpl_vars['facebookButton']; ?>
" href="javascript:void(0)" url="<?php if ($this->_tpl_vars['fbConnect']):  echo $this->_tpl_vars['fbConnect'];  else: ?>javascript:void(0)<?php endif; ?>" >&nbsp;</a>
                <a class="loginpopup loginTwitter <?php echo $this->_tpl_vars['twConnectButton']; ?>
" href="javascript:void(0)" url="<?php if ($this->_tpl_vars['twConnect']):  echo $this->_tpl_vars['twConnect'];  else: ?>javascript:void(0)<?php endif; ?>">&nbsp;</a>
                <a class="loginpopup loginGplus <?php echo $this->_tpl_vars['gplusConnectButton']; ?>
" href="javascript:void(0)" url="<?php if ($this->_tpl_vars['gplusConnect']):  echo $this->_tpl_vars['gplusConnect'];  else: ?>javascript:void(0)<?php endif; ?>">&nbsp;</a>
                           </div><!-- end #loginBtn -->
				<div class="popup" id="teaserAxisLife">
                    <div class="ui-overlay">
                        <div class="ui-widget-overlay"></div>
                    </div><!-- end .ui-overlay -->
                    <div class="popupContent" style="width:650px;">
                        <div class="entry">
                         <img src="<?php echo $this->_tpl_vars['locale']['loginteaser']['axislife']; ?>
" />
                        </div><!-- end .entry -->
                    </div><!-- end .popupContent -->
                </div><!-- end .popup -->
				
			<?php endif; ?>
			
				<a class="flagen " href="<?php echo smarty_function_encrypt(array('url' => $this->_tpl_vars['basedomain'],'page' => 'locale','country' => '2','nexturl' => $this->_tpl_vars['nexturl']), $this);?>
" lid="2" >EN</a>
				<a class="flagid " href="<?php echo smarty_function_encrypt(array('url' => $this->_tpl_vars['basedomain'],'page' => 'locale','country' => '1','nexturl' => $this->_tpl_vars['nexturl']), $this);?>
" lid="1" >ID</a>
			
			
        </div><!-- end #top -->
		
        <div id="navigation">
            <div class="wrapper">
                <ul id="nav">
                    <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
kenapaAxis"><?php echo $this->_tpl_vars['locale']['nav']['kenapaaxis']; ?>
</a></li>
                    <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk" class="submenu"><?php echo $this->_tpl_vars['locale']['nav']['produk']; ?>
</a></li>
                    <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo"><?php echo $this->_tpl_vars['locale']['nav']['promo']; ?>
</a></li>
                    <li><a href="<?php if ($this->_tpl_vars['isLogin']):  echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['userpage'];  else:  echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['userpage'];  endif; ?>"><?php echo $this->_tpl_vars['locale']['nav']['axislife']; ?>
</a></li>
                </ul><!-- end #nav -->
                <form id="searchTop" class="searchTop" action="" method="post">
					<input id="querySearch" name="q" type="text" onclick="this.value='';" value="<?php echo $this->_tpl_vars['locale']['gcs']['search']; ?>
">
					<input name="lang" type="hidden" value="<?php echo $this->_tpl_vars['locale']['country']; ?>
">
					<input id="querySubmit" type="submit" value="&nbsp;">					               
				</form><!-- end .searchTop -->
            </div><!-- end .wrapper -->
        </div><!-- end #navigation -->

    </div><!-- end #head -->
</div><!-- end #headContainer -->
<div id="subMenu">
    <div id="subContent" class="wrapper">
        <ul>
            <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/internet" class="subInternet"><?php echo $this->_tpl_vars['locale']['nav']['internet']; ?>
</a></li>
            <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/telepon" class="subTelepon"><?php echo $this->_tpl_vars['locale']['nav']['telepon']; ?>
</a></li>
            <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/bundling" class="subBundling"><?php echo $this->_tpl_vars['locale']['nav']['bundling']; ?>
</a></li>
            <li><a href="<?php echo $this->_tpl_vars['basedomain']; ?>
produk/detail/kartu" class="subKartu"><?php echo $this->_tpl_vars['locale']['nav']['kartuaxis']; ?>
</a></li>
        </ul>
        <div class="bannerNav" id="internetBanner">
        	<!--<p><img src="assets/images/internet.png" /></p>-->
		<p><img src="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['locale']['nav']['internet_img']; ?>
" /></p>
        </div>
        <div class="bannerNav" id="teleponBanner">
        	<p><img src="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['locale']['nav']['telepon_img']; ?>
" /></p>
        </div>
        <div class="bannerNav" id="bundlingBanner">
        	<p><img src="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['locale']['nav']['bundling_img']; ?>
" /></p>
        </div>
        <div class="bannerNav" id="kartuBanner">
        	<p><img src="<?php echo $this->_tpl_vars['basedomain'];  echo $this->_tpl_vars['locale']['nav']['kartuaxis_img']; ?>
" /></p>
        </div>
    </div><!-- end .wrapper -->
</div>
<script>
var postGCS;
var defaultText = '<?php echo $this->_tpl_vars['locale']['gcs']['search']; ?>
';
var lid = "<?php echo $this->_tpl_vars['locale']['gcs']['searchresult']; ?>
";
var you = "<?php echo $this->_tpl_vars['locale']['gcs']['you']; ?>
";
var noresult = "<?php echo $this->_tpl_vars['locale']['gcs']['noresult']; ?>
";
var basedomain = "<?php echo $this->_tpl_vars['basedomain']; ?>
";
var userpage = "<?php echo $this->_tpl_vars['userpage']; ?>
";
	<?php echo '
		$(document).ready(function(){
			$("#searchTop").submit(function(){
				var str = strip_tags($(\'#querySearch\').val());
				if(str != \'\' || str != defaultText){
					searchGCS();
				}
				return false; 
			});
			
			$("#querySearch").blur(function(){
				var str = $(this).val();
				if(str != \'\' || str != defaultText){
					searchGCS();
				}
				return false; 
			});
			
			
		});
		
		function searchGCS(){
			var t = "#searchTop input[name=\'q\']";
			var lang = "#searchTop input[name=\'lang\']";
			var key = strip_tags($(\'#querySearch\').val());
			var mediumBanner;
			//medium banner
			$(\'#mainContent\').html(\'<div class="loaders loaderBox"><img src="\'+basedomain+\'assets/images/loader.gif"></div>\');
			$.get(basedomain+\'gcs/search_ajax\', function(mediumBanner){
				google_search(t, lang,function(data){
					if(data != null){
					var str=\'\';
					str+=\'<div class="wrapper" id="breadcumb"><h1><a href="index.php">Home</a> &raquo; <a>\'+you+\' "\'+data.q+\'"</a></h1></div>\';
					str+=\'<div id="container"><div id="axisLife" class="wrapper">\';
							str+=\'<div id="sidebar">\';			
								str+=mediumBanner;
							str+=\'</div>\';
							str+=\'<div id="contents">\';
								str+=\'<div class="theTitle">\';
									str+=\'<h1 class="icon_favorite">\'+lid+\'</h1>\';
								str+=\'</div>\';
								str+=\'<div class="shadowCtop">\';
									str+=\'<div class="shadowCbottom">\';
										str+=\'<div class="entryDetail list">\';
										str+=resultListHTML(data);
										str+=\'</div>\';
									str+=\'</div>\';
								str+=\'</div>\';
							str+=\'</div>\';
						str+=\'</div></div>\';
					}else{
						var str=\'\';
						str+=\'<div class="wrapper" id="breadcumb"><h1><a href="\'+basedomain+\'index.php">Home</a> &raquo; <a>\'+you+\' "\'+key+\'"</a></h1></div>\';
						str+=\'<div id="container"><div id="axisLife" class="wrapper">\';
							str+=\'<div id="sidebar">\';			
								str+=mediumBanner;
							str+=\'</div>\';
							str+=\'<div id="contents">\';
								str+=\'<div id="SearchNotFound">\';
									str+=noresult;
								str+=\'</div>\';
							str+=\'</div>\';
						str+=\'</div></div>\';
					}
					$(\'#mainContent\').html(str);
				});
			});
		}
		
		function resultListHTML(data){
			var str=\'\';				
			$.each(data.items, function(k, v){			
				
				str+=\'<div class="row">\';
					if(v.image != ""){
						str+=\'<div class="circleThumb">\';
							str+=\'<a href="\'+v.url+\'"><img src="\'+v.image+\'"></a>\';
						str+=\'</div>\';
					}
					str+=\'<div class="searchText">\';
						str+=\'<div class="entry">\';
							str+=\'<h3><a href="\'+v.url+\'">\'+v.title+\'</a></h3>\';
							str+=\'<a href="\'+v.url+\'">\'+v.url+\'</a>\';
							str+=\'<p>\'+v.text+\'</p>\';
						str+=\'</div>\';
					str+=\'</div>\';
				str+=\'</div>\';
			});
			return str;
		}
		

	'; ?>

</script>