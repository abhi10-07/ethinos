<?php $this->load->view('admin/header');?>
<style type="text/css">

	#login{
		min-height: 250px;
	}
	
	.help-block
	{
		font-size: 15px;
		color: #ff0000;
		position: absolute;
		top: 25px;
		right: 17px;
		font-weight: bold;
	}

	.email_check
	{
		position: absolute;
		top: 31px;
		color: red;
		font-size: 16px;
		margin: 0px 5px;
		display: block;
		font-weight: bold;
	}
	
	#logerror
	{
		color: red;
		font-size: 15px;
		font-weight: 600;
	}
	
	.forgot_click, .login_click
	{
		display: block;
		font-size: 16px;
		font-weight: 600;
		padding: 3px 0px;
	}
	
	.btn-block + .btn-block {
    margin-top: 5px;
	}
	.btn-facebook {
		color: #fff;
		background-color: #3b5998;
		border-color: rgba(0,0,0,0.2);
	}
	.btn-google {
		color: #fff;
		background-color: #DD4B39;
		border-color: rgba(0,0,0,0.2);
	}
	.btn-social {
		position: relative;
		text-align: center;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		margin-bottom:10px;
	}
	.btn-block {
		display: block;
		width: 100%;
	}
	
	.btn-social>:first-child {
		position: absolute;
		left: 0;
		top: 0;
		bottom: 0;
		width: 60px;
		line-height: 33px;
		font-size: 24px;
		text-align: center;
		border-right: 1px solid rgba(0,0,0,0.2);
	}
	
	.ref_box{
		font-size: 18px;
		border: 1px solid #eaeaea;
		padding: 10px;
		color: #000;
		background-color: #eaeaea;
	}
	
	.ref_box p{ 
	  font-size: 15px;
	  margin: 0px;
	}
	
</style>
<main id="main-contents">
	
	<div class="container">
		<div>
			<h1 class="service-title-main">Sign-up/Login</h1>
			
			<div class="col-md-6 col-md-offset-0 col-sm-offset-2 col-sm-8 col-xs-12 noonlypadding">
				
				<div id="login" class="col-md-10 col-xs-12 noonlypadding">
					<h4>ADMIN</h4>
					<div class="login-box">
					<h3 class="form-heading">Login</h3>

					<form id="loginForm" class="form-horizontal" name="login_form">
					
						<div class="form-group">
							<div class="col-xs-12 no-padding">

								<input type="text" maxlength="40" id="username" class="form-control col-xs-12" name="username" title="" placeholder="Email" value="<?php echo $this->session->userdata('email'); ?>">

							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="password" maxlength="40" id="password" class="form-control col-xs-12" name="password" title="" placeholder="Password">

							</div>
						</div>

						<div class="clearfix"></div>
						<div class="form-group">
							<div class="col-xs-8 no-padding">
								<button class="btn custom-btn col-xs-10" id="login_btn" type="submit">Login</button>
							</div>
						</div>
												
						<div id="logerror"></div> 
					</form>
					</div>
					
				
					
				</div>
			
			</div>
			
			
			

		</div>
	</div>


	<script type="text/javascript">
		var emailFlag = 0;
		var email_typ = /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/; 
		function email_check()
		{
			var email = $('#email').val();
			var url = "<?php echo site_url('user/check_email');?>"; 
			$.ajax({
				url: url,
				type:'POST',
				data:'email='+email,
				success:function(data)
				{
					if(data > 0)
					{
						$('.email_check').html('Email-id already used');
						emailFlag = 1;
					}
					else
					{
						$('.email_check').html('Email-id available to register');
						emailFlag = 0;
					}
				}
			});
		}

		$(document).ready(function(){

	

			$('#login_btn').click(function(event){
				event.preventDefault();
				form = $("#loginForm");
				form.validate({
					errorElement: 'span',
					errorClass: 'help-block',
					highlight: function(element, errorClass, validClass) {
						$(element).closest('.divFormField').addClass("has-error");
					},
					unhighlight: function(element, errorClass, validClass) {
						$(element).closest('.divFormField').removeClass("has-error");
					},
					rules: {
						username: {
							required: true,
							email: true,
						},
						password: {
							required: true,
							minlength: 5,
						}
					//rules	
				},
				messages: {
					username: {
						required: 'Required',
						email: 'Invalid Email'
					},
					password: {
						required: 'Required',
						minlength: 'Minimum 5 characters',
					}						
					//rules	
				}
			});
				if (form.valid() === true){
					$('#login_btn').attr('disabled', 'disabled');
					var url = "<?php echo site_url('admin/check_credentials');?>";       

					$('#logerror').html('Please wait...');  
					$.ajax({
						type: "POST",
						url: url,
							   data: $("#loginForm").serialize(), // serializes the form's elements.
							   success: function(data)
							   {
									console.log(data);
									if(data==1)
									{
										var currentUrl = '<?php echo $this->session->userdata ( 'redirect' ); ?>';
										if(currentUrl == '')
										{
											currentUrl = 'admin'
										}
										window.location.href = currentUrl;
									}										 
									else  
									{
										$('#login_btn').attr('disabled', false);
										$('#logerror').html('Incorrect email id or password.');
										$('#logerror').addClass("error");
									}
								}
							});

					return false;

				}
			});
			
		
			
			
		});
	</script>
