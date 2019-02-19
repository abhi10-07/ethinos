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
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="wrap-division">
									<div class="col-md-12 col-md-offset-0 heading2 animate-box">
										<h2>All Booking</h2>
									</div>
									<div class="row">
                                        <div id="personaldets" class="personaldets col-xs-12 noonlypadding">
                                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Hotel</th>
                                                <th>Room type</th>
                                                <th>Date</th>
                                                <th>no of nights</th>
                                                <th>Total cost</th>
                                                <th>Approved</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result  as $result) { ?>
                                            <tr>
                                                <td><?php echo $result['name']; ?></td>
                                                <td><?php echo $result['type']; ?></td>
                                                <td><?php echo date('d-M Y', strtotime($result['date_from'])) .' ---- '. date('d-M Y', strtotime($result['date_to'])); ?></td>
                                                <td><?php echo $result['no_of_nights']; ?></td>
                                                <td><?php echo $result['total_cost']; ?></td>
                                                <td><?php echo ($result['approved'] == 0) ? 'Waiting' : 'Approved'; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        
                                        </table>
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
				form = $("#bookForm");
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
						book_to: {
							required: true,
						},
						book_from: {
							required: true,
						},
						
					//rules	
				},
				messages: {
					book_to: {
						service: 'Required',
					},
					book_from: {
						required: 'Required',
					},
					
					//messsage	
				}
			});
				if (form.valid() === true){
					$('#regsiter_btn').attr('disabled', 'disabled');
					
                    setTimeout(function(){
                        $('#bookForm').submit();
                    }, 1000);
					
				}
			});

        });
	</script>
</main>
<?php $this->load->view('footer'); ?>