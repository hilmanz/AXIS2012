<?php /* Smarty version 2.6.13, created on 2012-11-14 16:18:00
         compiled from application/coorporate//header.html */ ?>

<div id="headContainer">
    <div id="head">
        <div id="top">
            <a id="logo" href="index.php">&nbsp;</a>
            <a class="axisworldBtn" href="../public_html/index.php">&nbsp;</a>
            <a class="flagen locale" href="javascript:void(0)" lid="2" >&nbsp;</a>
            <a class="flagid locale" href="javascript:void(0)" lid="1" >&nbsp;</a>
            <ul id="topNav">
                <li><a href="index.php?page=blog"><?php echo $this->_tpl_vars['locale']['nav']['blog']; ?>
</a></li>
                <li><a href="index.php?page=distributor_resmi"><?php echo $this->_tpl_vars['locale']['nav']['distributorresmi']; ?>
</a></li>
                <li><a href="index.php?page=hubungi_kami"><?php echo $this->_tpl_vars['locale']['nav']['hubungikami']; ?>
</a></li>
                                            </ul><!-- end #topNav -->
        </div><!-- end #top -->
        <div id="navigation">
            <div class="wrapper">
                <ul id="nav">
                    <li><a href="index.php?page=tentang_axis"><?php echo $this->_tpl_vars['locale']['nav']['tetangaxis']; ?>
</a></li>
                    <li><a href="index.php?page=life_in_axis"><?php echo $this->_tpl_vars['locale']['nav']['lifeinaxis']; ?>
</a></li>
                    <li><a href="index.php?page=berita"><?php echo $this->_tpl_vars['locale']['nav']['ruangberita']; ?>
</a></li>
                    <li><a href="index.php?page=seputar_perusahaan"><?php echo $this->_tpl_vars['locale']['nav']['infoseputar']; ?>
</a></li>
                </ul><!-- end #nav -->
                <div id="searchTop" class="searchTop">
					<input id="querySearch" name="q" type="text" onclick="this.value='';" value="Bisa dibantu? Cari di sini...">
					<input id="querySubmit" type="submit" value="&nbsp;">					
                </div><!-- end .searchTop -->
            </div><!-- end .wrapper -->
        </div><!-- end #navigation -->
    </div><!-- end #head -->
</div><!-- end #headContainer -->
<script>
	<?php echo '
		$(document).ready(function(){
			$("#querySubmit").click(function(){
				var t = "#searchTop input[name=\'q\']";
				var mediumBanner;
				//medium banner
				//$.get(\'index.php?page=gcs&act=search_ajax\', function(mediumBanner){
					google_search(t,function(data){
						if(data != null){
							var str=\'\';
							str+=\'<div class="wrapper" id="breadcumb"><h1><a href="index.php">Home</a> &raquo; <a>You Search "\'+data.q+\'"</a></h1></div>\';
							str+=\'<div id="container"><div id="axisLife" class="wrapper">\';
									str+=\'<div id="sidebar">\';			
										//str+=mediumBanner;
									str+=\'</div>\';
									str+=\'<div id="contents">\';
										str+=\'<div class="theTitle">\';
											str+=\'<h1 class="icon_favorite">Hasil Pencarian</h1>\';
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
							var str = \'<div class="wrapper"><h3>No data available.</h3></div>\';
						}
						$(\'#mainContent\').html(str);
					});
					
				//});
			});
		});
		
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