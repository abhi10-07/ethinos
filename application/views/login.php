<?php $this->load->view('header');?>
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

</style>
<main id="main-contents">
	
	<div class="container">
		<div>
			<h1 class="service-title-main">Sign-up/Login</h1>
			
			<div class="col-md-6 col-md-offset-0 col-sm-offset-2 col-sm-8 col-xs-12 noonlypadding">
				
				<div id="login" class="col-md-10 col-xs-12 noonlypadding">
					<h4>REGISTERED CUSTOMERS</h4>
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
			
			
			<div class="col-md-offset-1 col-md-5 col-xs-12 noonlypadding">
				
				<div id="signup" class="col-md-12 col-md-offset-0 col-sm-offset-2 col-sm-8 col-xs-12 noonlypadding">
					<h4>NEW CUSTOMERS</h4>
					<h3 class="form-heading">Sign Up</h3>

					<form action="<?php echo base_url();?>user/register" method="POST" id="signupForm" class="form-horizontal" name="signup_form" enctype="multipart/form-data">


						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="text" maxlength="40" id="fname" class="form-control col-xs-12" name="fname" placeholder="First Name" value="<?php echo $this->session->userdata('fname') == '' ? set_value('fname'):$this->session->userdata('fname') ; ?>" >
								<?php echo form_error('fname'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="text" maxlength="40" id="lname" class="form-control col-xs-12" name="lname" placeholder="Last Name" value="<?php echo $this->session->userdata('lname') == '' ? set_value('lname'):$this->session->userdata('lname') ; ?>">
								<?php echo form_error('lname'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="text" id="phone" maxlength="10" class="form-control col-xs-12" onkeypress="return isNumber(event)" name="phone" placeholder="Phone Number" value="<?php echo $this->session->userdata('phone') == '' ? set_value('phone'):$this->session->userdata('phone') ; ?>">
								<?php echo form_error('phone'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="text" maxlength="40" id="email" class="form-control col-xs-12" name="email" placeholder="Email" value="<?php echo $this->session->userdata('email') == '' ? set_value('email'):$this->session->userdata('email') ; ?>">
								<?php echo form_error('email'); ?><span class="email_check"></span>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="password" maxlength="40" id="rpassword" class="form-control col-xs-12" name="rpassword" title="" placeholder="Password">
								<?php echo form_error('rpassword'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<input type="password" maxlength="40" id="rcpassword" class="form-control col-xs-12" name="rcpassword" title="" placeholder="Confirm Password">
								<?php echo form_error('rcpassword'); ?>
							</div>
						</div>


						<div class="clearfix"></div>
						
						<div class="form-group">
							<div class="col-xs-12 no-padding">
								<button class="btn custom-btn col-xs-offset-3 col-xs-6" id="regsiter_btn" type="submit">Sign Up</button> 
							</div>
						</div>
					</form>
										
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

			$('#email').blur(function(){
				var check = ($('#email').val()).match(email_typ);
				if(check)
				{
					email_check();
				}
				
			});

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
					var url = "<?php echo site_url('user/check_credentials');?>";       

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
											currentUrl = 'user/user_account'
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
			
			
			$('#regsiter_btn').click(function(event){
				event.preventDefault();
				form = $("#signupForm");
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
						fname: {
							required: true,
						},
						lname: {
							required: true,
						},
						phone: {
							required: true,
							number: true,
							minlength:10,
							maxlength:10
						},
						email: {
							required: true,
							email: true
						},
						rpassword: {
							minlength : 5,
							required: true,
						},
						rcpassword: {
							minlength : 5,
							required: true,
							equalTo: "#rpassword"
						}
					//rules	
				},
				messages: {
					fname: {
						required: 'Required',
					},
					lname: {
						required: 'Required',
					},
					phone: {
						required: 'Required',
						number: 'Invalid Phone number',
						minlength:'10 digit number',
						maxlength:'10 digit number'
					},
					email: {
						required: 'Required',
						email: 'Invalid email id'
					},
					rpassword: {
						minlength : 'Min length should be greater than 5',
						required: 'Required',
					},
					rcpassword: {
						minlength : 'Min length should be greater than 5',
						required: 'Required',
						equalTo: 'Passwrod does nt match'
					}					
					//messsage	
				}
			});
				if (form.valid() === true){
					$('#regsiter_btn').attr('disabled', 'disabled');
					email_check();
					if(emailFlag == 0)
					{
					    setTimeout(function(){
						  $('#signupForm').submit();
						}, 1000);
					}
					
				}
			});			
			
		});
	</script>
