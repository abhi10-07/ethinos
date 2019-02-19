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
							<div id="colorlib-logo"><a href="javascript:void(0)">Ethinos</a></div>
						</div>
						<div class="col-xs-10 text-right menu-1">
							<ul>
								<li><a href="<?php echo base_url() ?>user/user_account">Account</a></li>
								<li class="active"><a href="<?php echo base_url() ?>user/booking">Booking</a></li>
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

				<!-- SIDEBAR-->
				<div class="col-md-12">
						<div class="sidebar-wrap">
							<div class="side search-wrap animate-box">
								<h3 class="sidebar-heading">Find your hotel</h3>
								<form method="post" id="searchHotelForm" class="colorlib-form">
				              	<div class="row">
				                <div class="col-md-4">
				                  <div class="form-group">
				                    <label for="date">Check-in:</label>
				                    <div class="form-field">
				                      <i class="icon icon-calendar2"></i>
				                      <input type="text" name="fromDate" class="form-control fromDate" placeholder="Check-in date">
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-4">
				                  <div class="form-group">
				                    <label for="date">Check-out:</label>
				                    <div class="form-field">
				                      <i class="icon icon-calendar2"></i>
				                      <input type="text" name="toDate" class="form-control toDate" placeholder="Check-out date">
				                    </div>
				                  </div>
												</div>
												<!---
				                <div class="col-md-12">
				                  <div class="form-group">
				                    <label for="guests">Guest</label>
				                    <div class="form-field">
				                      <i class="icon icon-arrow-down3"></i>
				                      <select name="people" id="people" class="form-control">
				                        <option value="#">1</option>
				                        <option value="#">2</option>
				                        <option value="#">3</option>
				                        <option value="#">4</option>
				                        <option value="#">5+</option>
				                      </select>
				                    </div>
				                  </div>
				                </div>--->
				                <div class="col-md-4">
				                  <input type="button"  id="findHotel" value="Find Hotel" class="btn btn-primary btn-block">
				                </div>
				              </div>
				            </form>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row">
							<div class="wrap-division hotel_box">
                            <h3 class="ht_msg">Please select dates</h3>
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
$('#findHotel').click(function(event){
				event.preventDefault();
				form = $("#searchHotelForm");
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
						toDate: {
							required: true,
						},
						fromDate: {
							required: true,
						},
						
					//rules	
				},
				messages: {
					fromDate: {
						service: 'This field is required',
					},
					toDate: {
						required: 'This field is required',
					},
					
					//messsage	
				}
			});
				if (form.valid() === true){
					$('#regsiter_btn').attr('disabled', 'disabled');
					
					$('.ht_msg').html('Please wait...');  

					var fromDate = $("[name='fromDate']").val();
					var toDate = $("[name='toDate']").val();

					var url = "<?php echo site_url('user/ajaxHotel');?>"; 
					$.ajax({
						url: url,
						type:'POST',
						data:'fromDate='+fromDate+'&toDate='+toDate,
						success:function(data)
						{						
							$('.hotel_box').html(data);
						}
					});

				}
			});

        });
	</script>
</main>
<?php $this->load->view('footer'); ?>