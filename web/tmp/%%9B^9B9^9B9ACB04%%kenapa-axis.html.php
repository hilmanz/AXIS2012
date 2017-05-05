<?php /* Smarty version 2.6.13, created on 2012-11-14 16:17:22
         compiled from application/axisweb//axisProduct/kenapa-axis.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?page=kenapaAxis"><?php echo $this->_tpl_vars['locale']['kenapaaxis']['title']; ?>
</a>
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_whyaxis']; ?>

<div id="centerTitle">
	<h1 class="icon_gear"><?php echo $this->_tpl_vars['locale']['knapaaxis']['panduan']; ?>
</h1>
</div><!-- end #centerTitle -->
<div id="theContent">
	<div class="topShadow"></div>
    <div class="theContent">
    	<div class="wrapper" id="panduan">
            <div class="panduan panduan1">
            	<div class="imgPanduan">
                	<img src="assets/content/img/panduan1.png" />
                </div>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['knapaaxis']['kartuaxis']; ?>

                </div>
            </div><!-- end .panduan -->
            <div class="panduan panduan2">
            	<div class="imgPanduan">
                	<img src="assets/content/img/panduan2.png" />
                </div>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['knapaaxis']['kartumu']; ?>
					
                </div>
            </div><!-- end .panduan -->
            <div class="panduan panduan3">
            	<div class="imgPanduan">
                	<img src="assets/content/img/panduan3.png" />
                </div>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['knapaaxis']['registrasi']; ?>
			
                </div>
            </div><!-- end .panduan -->
            <div class="panduan panduan4">
            	<div class="imgPanduan">
                	<img src="assets/content/img/panduan4.png" />
                </div>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['knapaaxis']['restart']; ?>

                </div>
            </div><!-- end .panduan -->
            <div class="panduan panduan5">
            	<div class="imgPanduan">
                	<img src="assets/content/img/panduan5.png" />
                </div>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['knapaaxis']['pengaturan']; ?>

                </div>
            </div><!-- end .panduan -->
            <div class="socialLike">
            	<a class="favorite">&nbsp;<span class="fav-count">3</span></a>
                <div class="facebookLike">
                    <div id="fb-root"></div>
					<?php echo '
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=267918769990528";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, \'script\', \'facebook-jssdk\'));</script>
					'; ?>

                    <div class="fb-like" data-href="http://axisworld.co.id/" data-send="false" data-layout="button_count" data-width="120" data-show-faces="false"></div>
                </div><!-- end .facebookLike -->
                <div class="googlePlus">
					<?php echo '
					<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
                      {parsetags: \'explicit\'}
                    </script>
					'; ?>

                    <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120" data-href="http://axisworld.co.id/"></div>
                    <script type="text/javascript">gapi.plusone.go();</script>
                </div><!-- end .googlePlus -->
            </div><!-- end .socialLike -->
		</div><!-- end #panduan -->
    </div><!-- end .theContent -->
	<div class="bottomShadow"></div>
</div><!-- end #theContent -->
<div class="widget-whyAxis">
<?php echo $this->_tpl_vars['carousel_banner']; ?>

</div><!-- end .widget-whyAxis -->