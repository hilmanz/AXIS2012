<?php /* Smarty version 2.6.13, created on 2012-11-29 15:56:17
         compiled from application/mobile/promo.html */ ?>
<div class="page-body" data-role="content">
		
		<div class="promo">
			 <div class="flexslider">
				<ul class="slides">
					<li><a href=""><img src="assets/images/promo-hot-1.jpg" alt="Akses VIKI pake AXIS" /></a></li>
					<li><a href=""><img src="assets/images/sample-banner-2.jpg" alt="internet gratis dg axis dan htc" /></a></li>
					<li><a href=""><img src="assets/images/sample-banner-3.jpg" alt="internet gratis dg axis dan htc" /></a></li>
				</ul>
			</div>
		</div>
		
		<script type="text/javascript">
			<?php echo '
		    $(\'#page-home\').live( \'pageshow\', function(e){
		        $(\'.flexslider\').flexslider({
		        	controlNav: false,
		        	slideshowSpeed: 10000,
					animation: "slide"
				});
		    });
			'; ?>

		</script>

		<div class="list-nav">
			<ul data-role="listview" data-inset="true">
				<li>
					<a href="index.php?page=promo&act=hot" data-transition="slide">
						<span class="icon icon-megaphone"></span>
						Hot Promo
					</a>
				</li>
				<li>
					<a href="index.php?page=promo&act=axisLife" data-transition="slide">
						<span class="icon icon-smile"></span>
						Hot Di Axis Life
					</a>
				</li>
				<li>
					<a href="index.php" data-transition="slide">
						<span class="icon icon-home"></span>
						Back To Home
					</a>
				</li>
			</ul>
		</div>
	</div><!-- /content -->