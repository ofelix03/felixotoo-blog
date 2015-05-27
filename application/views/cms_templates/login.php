<html>
<head>
	<title></title>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jQuery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/layout.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/form.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/edit_article.css'); ?>">


	<style type="text/css">

	p.success{
		border: 1px solid green;
		background-color: green;
		color: #fff;
		width: 80%;
		margin: 0px auto;
		text-align: center;
	}
	p.warning{
		color: #fff;
		text-align: center;
		width: 80%;
		margin: 20px auto;
		background-color: red;
	}

	p.warning span{
		display: block;
		padding: 5px;

	}

	p.warning span:first-child{
		background-color: red;

	}

.container .content-box{
	border: none;
	background-color: transparent;
	margin-top: 100px;
}
	.container .content-box .head{
		padding-left: 10px;
		width: 40%;
		margin: auto auto;
	}

	.container .container-head .logo h3{
		margin-top: 4px;
	}
	.container .content-box .content div.left{
		float: none;
		display: block;
		margin: auto auto;
		width: 40%;
	}

	</style>
</head>
<body>

	<div class="container">
		<div class="container-head">
			<div class="logo">
				<h3>CMS Dashboard</h3>
			</div>

			<div class="notification">Notifiction : <br><span></span></div>
			<p class="clear"></p>
		</div><!-- container-head ends here -->




		<div class="content-box">
			<div class="head"><h3>Login</h3></div>

			<div class="content">
				<div class="left">
					<h4>User Details</h4>
					<?php  if(isset($login_fail_status)):?>
						<p class='warning'><?php echo $login_fail_status; ?></p>
				<?php endif;?>
					<?php  echo form_open('cms/login',  array('id' => 'ofelix'));?>
						<label>Username</label><span><input type='text' name='username' value="<?php echo set_value('username');  ?>" 
						 class="<?php echo isset($warning['username'])?  'warning' : ''; ?>" /></span>
						<label>Password</label><span><input type='password' name='password' value=''  
						class="<?php echo isset($warning['password'])?  'warning' : ''; ?>"/></span>
						<span><a href="">Forgotten your password?</a></span>
						<span><input type='submit' value='Login'   style='width: 15%; float:right;'/><input type='reset' name='reset' value='Reset'  style='width: 15%; float:right;'/></span>

					</form>
			    </div>
			</div>

		</div>



	</div>



<!-- DO NOT DELETE THIS, VERY IMPORTANT 
	USED by site_url() function in cms_funtions
	USED by base_url() function  in cms_functions -->
	<p id='base_url' data-url="<?php echo base_url(); ?>"></p>
	<p id="site_url" data-url="<?php echo site_url(); ?>"></p>
	<!-- end of DO NOT DELETE THIS, VERY IMPORTANT -->


	


	<script type="text/javascript">
		//input and textarea focusout event
		//on focusout if input or textarea contains value change to green or show red
		$(function(){
			var $form = $('form');
			var $spans = $form.find('span');
			$spans.each(function(index){
				$input = $(this).find('input');
				$input.focusout(function(){
					$this = $(this);
					if($this.val() != '')
					{
						//detach the warning class form the input
						$this.removeAttr('class', 'warning');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('class', 'warning');
					}
				})
			})
		})

		$(function(){
			var $form = $('form');
			var $spans = $form.find('span');
			$spans.each(function(index){
				$textarea = $(this).find('textarea');
				$textarea.focusout(function(){
					$this = $(this);
					if($this.val() != '')
					{
						//detach the warning class form the input
						$this.removeAttr('class', 'warning');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('class', 'warning');
					}
				})
			})
		})
	</script>

	<script type="text/javascript">
		//ajax call to server to verify user credentials

		var $form = $('form');
		var $username = $form.find("input[name='username']");
		var $password = $form.find("input[name='password']");

		// focusout($username);
		// focusout($password);

		 focusout_mouseleave($username);
		 focusout_mouseleave($password);
		 keypress($username);


		// function focusout($elementNode){
		// 	$elementNode.focusout(function(){
		// 		if($elementNode.val() != "")
		// 		{
		// 			var data = {
		// 				"request_type" : "ajax",
		// 				"field" : $elementNode.attr('name'),
		// 				"field_val" :  $elementNode.val()
		// 			}

		// 			//ajax call now
		// 			var bool = ajax_call(data, $elementNode);
		// 		}
		// 	})

		// }



		function focusout_mouseleave($elementNode){
			$elementNode.bind('focusout mouseleave', function(){
				$this = $(this);
	             if($this.val() != "")
				{
					var data = {
						"request_type" : "ajax",
						"field" : $this.attr('name'),
						"field_val" :  $this.val()
					}

					//ajax call now
					var bool = ajax_call(data, $this);
		     	}
			});
		}


		
		function ajax_call(data, $elementNode){
			var src = $('#site_url').data('url') + '/cms/login';
		
			$.post(src, data, function(ret){
				ret = $.parseJSON(ret);
				if(ret.status)
				{
					//change the input field border to green;
					$elementNode.attr("style", "border: 2px solid green");
				}
				else
				{
					//change the input field border to red
					$elementNode.attr("style", "border:2px solid red");
				}
			});


		}

	</script>





</body>
</html>