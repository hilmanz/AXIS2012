<?php /* Smarty version 2.6.13, created on 2012-11-15 15:07:18
         compiled from application/axisweb//axisProduct/customer-care.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?menu=customer-care"><?php echo $this->_tpl_vars['locale']['customercare']['title']; ?>
</a></h1>
</div><!-- end #breadcumb -->
<div id="headBanner">
    <div class="headBanner">
        <div id="headBannerContent">
            <div class="headBannerImg"><img src="assets/content/slider/cutomer-care.jpg"/></div>
        	<div class="headBannerEntry">
                <?php echo $this->_tpl_vars['locale']['customercare']['headermsg']; ?>

            </div>
        </div><!-- end #headBannerContent -->
    </div><!-- end .headBanner -->
</div><!-- end #headBanner -->
<div id="customerPage">
    <div class="customerPage">
    	<div class="wrapper" id="customer">
            <div class="customerbox box1">
            	<a class="icon_chat">&nbsp;</a>
                <div class="entry">
                	 <?php echo $this->_tpl_vars['locale']['customercare']['onlinechat']; ?>

                </div><!-- end .entry -->
           		<a class="chatNow" href="#"><?php echo $this->_tpl_vars['locale']['btn']['chat']; ?>
</a>
            </div><!-- end .customerbox -->
            <div class="customerbox box2">
            	<a class="icon_phone">&nbsp;</a>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['customercare']['melaluitelepon']; ?>

                </div><!-- end .entry -->
           		<span class="callNumber">838 <span class="white">atau</span> 0838 8000 838</span>
            </div><!-- end .customerbox -->
		</div><!-- end #customer -->
    </div><!-- end .customerPage -->
</div><!-- end #customerPage -->
<div class="wrapper" id="contactBox">
	<div class="headContact">
    	<?php echo $this->_tpl_vars['locale']['customercare']['lewatemail']; ?>

    </div><!-- end .headContact -->
    <div class="entryContact">
    	<form class="contactForm" action="index.php?page=customer_care&act=saveMessage" id="contactForm" method="POST" >
        	<div class="w300 rowBtns">
                <input type="text" name="txtName" value="Nama" onBlur="if(this.value=='')this.value='Nama';" onFocus="if(this.value=='Nama')this.value='';" />
                <input type="text" value="Email" name="txtEmail" onBlur="if(this.value=='')this.value='Email';" onFocus="if(this.value=='Email')this.value='';" />
                <input type="text" name="txtTelepon" value="Nomor Axis" onBlur="if(this.value=='')this.value='Nomor Axis';" onFocus="if(this.value=='Nomor Axis')this.value='';" />
                <select name="txtPropinisi" class="styled">
                    <option value="" ><?php echo $this->_tpl_vars['locale']['customercare']['propinsi']; ?>
</option>
					<option value="DKI Jakarta" >DKI Jakarta</option>
					<option value="Jawabarat" >Jawabarat</option>
                </select>
                <select  name="txtKota" class="styled">
                    <option value="" ><?php echo $this->_tpl_vars['locale']['customercare']['kota']; ?>
</option>
					<option value="jakarta" >Jakarta</option>
					<option value="bandung" >Bandung</option>
                </select>
                <select  name="txtTipe"  class="styled">
                    <option =""><?php echo $this->_tpl_vars['locale']['customercare']['jenispertanyaan']; ?>
</option>
					<option value="makanan" >makanan</option>
					<option value="error" >error</option>
                </select>
            </div>
            <div class="w600">
            	<textarea name="txtMessage"></textarea>
                <div class="agreement">
                	<input type="checkbox" id="checkthis"  class="styled"/>
                    <label><?php echo $this->_tpl_vars['locale']['customercare']['custos']; ?>
</label>
					<span class="tosMsg" ></span>
                </div>
                <input type="submit" class="kirim" value="&nbsp;" />
            </div>
        </form>
    </div><!-- end .entryContact -->
    <div class="popup sendmessage">
        <div class="ui-overlay">
            <div class="ui-widget-overlay"></div>
        </div><!-- end .ui-overlay -->
        <div class="popupMessage">
            <div class="entry">
                <span class="successend"> <h1><?php echo $this->_tpl_vars['locale']['msg']['pesanterkirim']; ?>
</h1></span>
				<span class="failedtosend"> <h1><?php echo $this->_tpl_vars['locale']['msg']['pesantdkterkirim']; ?>
</h1></span>
            </div>
        </div><!-- end .popupMessage -->
    </div><!-- end .popup -->
    <div class="shadow"></div>
</div><!-- end #contactBox -->
<div class="wrapper" id="moreInfo">
	<p><?php echo $this->_tpl_vars['locale']['msg']['infoaxis']; ?>
</p>
</div><!-- end #moreInfo -->
<div class="widget-customer">
	<?php echo $this->_tpl_vars['carousel_banner']; ?>

</div><!-- end .widget-customer -->

<?php echo '
<script>

$("#contactForm").submit(function(){
$(".failedtosend").hide();
$(".successend").hide();
	if($("#checkthis:checked").val()!="on") {
		$(".tosMsg").html("setujui dulu ya");
		return false;
	}else{
		$(this).ajaxSubmit(function(data) { 
			if(data) {
					$(".successend").show();
					$(\'.sendmessage\').show();
				}else {
					$(".failedtosend").show();
					$(\'.sendmessage\').show();
				}
		});
		return false; 
	}
	


});


</script>
'; ?>
