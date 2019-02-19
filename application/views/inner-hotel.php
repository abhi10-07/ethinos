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
										<h2><?php echo  $hotel_name; ?></h2>
									</div>
									<div class="row">

									<?php foreach($result as $row ) { ?>
										<div class="col-md-12 animate-box">
											<div class="room-wrap">
												<div class="row">
													<div class="col-md-6 col-sm-6">
														<div class="room-img" style="background-image: url(<?php echo base_url() ?>images/<?php echo  $row['image']; ?>"></div>
													</div>
													<div class="col-md-6 col-sm-6">
														<div class="desc">
															<h2><?php echo  $row['type']; ?></h2>
															<p class="price"><span>$<?php echo  $row['cost']; ?></span> <small>/ night</small></p>
															<p><button type="button" class="btn btn-warning btn-lg myBtn" rel="<?php echo  $row['id']; ?>" mel="<?php echo  $row['cost']; ?>" bel="<?php echo  $row['type']; ?>">Book now</button></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Book</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
				<form role="form" action="<?php echo base_url();?>user/doBooking" method="POST" id="bookForm">
						<div class="form-group col-sm-6">
              <input type="text" class="form-control" id="book_type" disabled placeholder="From" value="">
            </div>
						<div class="form-group col-sm-6">
              <input type="text" class="form-control" id="book_cost" disabled value="">
            </div>
						<div class="form-group col-sm-6">
              <input type="text" class="form-control fromDate" id="book_from" name="book_from" placeholder="From" value="<?php if($dataFrom != '') { echo $dataFrom ; } ?>">
            </div>
            <div class="form-group  col-sm-6">
              <input type="text" class="form-control toDate" id="book_to" name="book_to" placeholder="To" value="<?php if($dataTo != '') { echo $dataTo; } ?>">
            </div>
							<input type="hidden" class="form-control date" id="book_id" name="book_id" value="">
              <button type="button" class="btn btn-success btn-block" id="regsiter_btn"><span class="glyphicon glyphicon-off"></span> Book</button>
          </form>
        </div>
        <div class="modal-footer">
          
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