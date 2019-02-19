<?php $this->load->view('header');
$this->session->set_userdata ( 'redirect', current_url ());
?>
<style type="text/css">
   #login, #signup {
      background-color: #e7e7e7;
      margin: 10px 20px;
      padding: 10px 20px;
  }
  .msg_box {
   display:none;
}
.help-block {
  color: red;
  position: absolute;
  top: 0px;
  right: 40px;
}


</style>
<div id="page">
		<nav class="colorlib-nav" role="navigation">
			<div class="top-menu">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-2">
							<div id="colorlib-logo"><a href="index.html">Ethinos</a></div>
						</div>
						<div class="col-xs-10 text-right menu-1">
							<ul>
								<li class="active"><a href="<?php echo base_url() ?>user/user_account">Account</a></li>
								<li><a href="<?php echo base_url() ?>user/booking">Booking</a></li>
								<li><a href="<?php echo base_url() ?>user/logout">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
        <aside id="colorlib-hero">
			<div class="flexslider">
				<ul class="slides">
			   	<li style="background-image: url(<?php echo base_url() ?>images/cover-img-4.jpg);">
			   		<div class="overlay"></div>
			   		<div class="container-fluid">
			   			<div class="row">
				   			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
				   				<div class="slider-text-inner text-center">
				   					<h2>by colorlib.com</h2>
				   					<h1>Find Hotel</h1>
				   				</div>
				   			</div>
				   		</div>
			   		</div>
			   	</li>
			  	</ul>
		  	</div>
		</aside>

		<div class="colorlib-wrap">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="row">
                            <div class="account-form">
                                <h3 class="heading">Your Details</h3>
                                <div id="personaldets" class="personaldets col-xs-12 noonlypadding">
                                    <form class="form-horizontal" role="form" id="personal_form" name="personal_form">

                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-xs-12">Name:</label>
                                        <div class="col-md-4 no-padding col-xs-12">
                                            <input autocomplete="off" type="text" id="fname" name="fname" maxlength="60" value="<?php echo $result[0]['name']; ?>" class="edit-textbox" disabled >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-xs-12">Email Id:</label>
                                        <div class="col-md-4 no-padding col-xs-12">
                                            <input autocomplete="off" type="text" id="email" name="email" maxlength="60" value="<?php echo $result[0]['email']; ?>" class="edit-textbox" disabled >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-xs-12">Mobile:</label>
                                        <div class="col-md-4 no-padding col-xs-12">
                                            <input autocomplete="off" type="text" id="phone" name="phone" maxlength="60" value="<?php echo $result[0]['phone']; ?>" class="edit-textbox" disabled >
                                        </div>
                                    </div> 
                                </div> 
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
	</div>

<script type="text/javascript">
$(document).ready(function(){
$('#regsiter_btn').click(function(event){
				event.preventDefault();
				form = $("#bookingForm");
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
						service: {
							required: true,
						},
						date: {
							required: true,
						},
						
					//rules	
				},
				messages: {
					fname: {
						service: 'Required',
					},
					date: {
						required: 'Required',
					},
					
					//messsage	
				}
			});
				if (form.valid() === true){
					$('#regsiter_btn').attr('disabled', 'disabled');
					
                    setTimeout(function(){
                        $('#bookingForm').submit();
                    }, 1000);
					
				}
			});

        });
	</script>
</main>
<?php $this->load->view('footer'); ?>