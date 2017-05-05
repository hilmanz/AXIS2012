<?php /* Smarty version 2.6.13, created on 2013-01-25 14:58:02
         compiled from common/admin/login.html */ ?>
	<div class="loginpage">
    <div class="loginbox">
    	<div class="loginboxinner">
            <div class="logo">
            	<h1><span>ADMINISTRATOR</span> AXIS</h1>
            </div><!--logo-->
            <?php if ($this->_tpl_vars['msg'] <> ""): ?>
                <div class="loginmsg"><?php echo $this->_tpl_vars['msg']; ?>
</div>
            <?php endif; ?>
            <form id="login" action="login.php" method="post">
                <div class="username">
                	<div class="usernameinner">
						<input name="username" type="text" id="username" maxlength="20"/> 
                    </div>
                </div>
                <div class="password">
                	<div class="passwordinner">
						<input name="password" type="password" id="password" maxlength="20" />
                    </div>
                </div>
                <div id="chaptcha">
                    <img src="captcha.php"/>
                    <input type="text" class="chaptcha" name="captcha"/>
                </div>
                <input name="f" type="hidden" id="f" value="1"/>
				<input id="button" type="submit" name="Submit" value="LOGIN" />
            </form>
        </div><!--loginboxinner-->
    </div><!--loginbox-->
    </div>