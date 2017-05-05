<?php /* Smarty version 2.6.13, created on 2012-12-03 10:14:41
         compiled from application/mobile/kenapaAxis.html */ ?>
<div class="breadcrumb">
		<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a>	&raquo; <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=kenapaAxis"><?php echo $this->_tpl_vars['locale']['nav']['kenapaaxis']; ?>
</a>	
	</div>
<div class="page-body" data-role="content">
		
		<div class="page-image-heading">
			<img src="<?php echo $this->_tpl_vars['mobiledomain']; ?>
assets/images/pakai_axis.jpg" />
		</div>
		<div class="page-content clear">
			<div id="product-category-list" class="page-content-list">
				<ul data-role="listview" data-inset="true">
                    <li>
                       <?php echo $this->_tpl_vars['locale']['slider']['whyaxis']['service']; ?>

                    </li>
                    <li>
                        <?php echo $this->_tpl_vars['locale']['slider']['whyaxis']['coverage']; ?>

                    </li>
                    <li>
                        <?php echo $this->_tpl_vars['locale']['slider']['whyaxis']['tariff']; ?>

                    </li>
				</ul>
			</div>
		</div>
		<div class="page-meta">
			<h1 class="page-title"><span class="icon"></span><?php echo $this->_tpl_vars['locale']['knapaaxis']['panduan']; ?>
</h1>
		
			<div class="page-content clear">
				<ul id="manual-activation">
					<li class="activation-step-1">
						<span class="thumb"></span>
						<div>
							<?php echo $this->_tpl_vars['locale']['knapaaxis']['kartuaxis2']; ?>

						</div>
 					</li>
 					<li class="activation-step-2">
 						<div>
	 						<?php echo $this->_tpl_vars['locale']['knapaaxis']['kartumu2']; ?>
		
 						</div>
 						<span class="thumb"></span>
 					</li>
 					<li class="activation-step-3">
 						<span class="thumb"></span>
 						<div>
	 						<?php echo $this->_tpl_vars['locale']['knapaaxis']['registrasi2']; ?>
	
	 					</div>	
 					</li>
 					<li class="activation-step-4">
 						<div>
	 						<?php echo $this->_tpl_vars['locale']['knapaaxis']['restart2']; ?>

						</div>
						<span class="thumb"></span>
 					</li>
 					<li class="activation-step-5">
 						<span class="thumb"></span>
 						<div>
	 						<?php echo $this->_tpl_vars['locale']['knapaaxis']['pengaturan2']; ?>

	 					</div>	
 					</li>
				</ul>
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
				<div class="shareTwit">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://axisworld.co.id/" data-via="axisgsm" data-related="axisgsm" data-hashtags="AXISGSM">Tweet</a>
				<?php echo '
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				'; ?>

				</div><!-- end .shareTwit -->
                
            </div><!-- end .socialLike -->
			</div>
		</div>
		
		<div class="list-nav">
			<ul data-role="listview" data-inset="true">
				<li>
					<a href="index.php" data-transition="slide" data-url="index.php">
						<span class="icon icon-home"></span>
						Back To Home
					</a>
				</li>
			</ul>
		</div>
	</div><!-- /content -->