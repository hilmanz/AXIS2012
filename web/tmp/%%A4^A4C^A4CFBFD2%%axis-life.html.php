<?php /* Smarty version 2.6.13, created on 2012-11-14 16:12:48
         compiled from application/axisweb//axisLife/axis-life.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="<?php if ($this->_tpl_vars['user']): ?>index.php?page=user<?php else: ?>index.php?page=axisLife<?php endif; ?>"><?php echo $this->_tpl_vars['locale']['axislife']['title']; ?>
</a></h1>
</div><!-- end #breadcumb -->
<div id="container">
<!-- s : coming soon -->
  <div class="wrapper" id="axisLife">
        <div id="headBanner">
            <div class="headBanner">
                <div id="headBannerContent">
                    <div class="headBannerImg" style="left:0;"><img src="assets/content/slider/axis_life_teaser.jpg"/></div>
                    <div class="entryTeaser">
                    	<h1>Segera hadir : AXIS LIFE</h1>
						<h2>Tempat paling seru untuk berbagi inspirasi setiap hari, sesuai minatmu</h2>
                        <p>Siap-siap buat mengucapkan selamat tinggal pada rasa bosan karena fitur-fitur keren dari AXIS Life bakalan selalu mewarnai hari-harimu. Ngakses Twitter, Facebook dan Google Plus juga bakal jadi lebih seru!</p>
                    </div>
                    <form id="subscribe">
                    	<input type="text" name="email" value="Untuk info selengkapnya daftarkan email Kamu" onBlur="if(this.value=='')this.value='Untuk info selengkapnya daftarkan email Kamu';" onFocus="if(this.value=='Untuk info selengkapnya daftarkan email Kamu')this.value='';" />
                        <input type="button" value="<?php echo $this->_tpl_vars['locale']['axislife']['daftar']; ?>
" />
						<p id="saveStatus" style="text-align: right; color: rgb(122, 24, 120);"></p>
                    </form>
                </div><!-- end #headBannerContent -->
            </div><!-- end .headBanner -->
        </div><!-- end #headBanner -->
    </div><!-- end #axisLife -->
<!-- e :coming soon -->
        <div class="widget-axisLife">
    <?php echo $this->_tpl_vars['carousel_banner']; ?>

    </div><!-- end .widget-whyAxis -->
</div><!-- end #container -->

<script>
<?php echo '
	$(document).ready(function(){
		$("#subscribe input[type=\'button\']").click(function(){
			$("#saveStatus").show().html(\'\');
			var t = $("#subscribe input[name=\'email\']").val();
		
			$.post(\'index.php?page=axisLife&act=saveEmail\', {email: t}, function(status){
				$("#subscribe input[name=\'email\']").val(\'\');
				$("#saveStatus").html(status);
			});
		});
	});
'; ?>

</script>