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

.account-left {
    float: right;
}


</style>
<main id="main-contents">
   <div class="container">
      <div class="account-info-con col-xs-12 noonlypadding">
        <div class="account-left col-md-2 col-xs-12">
            <ul>
               <?php 
                    $logged_in = $this->session->userdata('is_admin_logged_in');
                    if(isset($logged_in) && !empty($logged_in)){ ?>
                    <li><a href="<?php echo base_url()?>user/logout">Logout</a></li>
                    <?php }else{ ?>
                    <li><a href="<?php echo base_url()?>user">Sign Up</a></li>
                    <?php } ?>
           </ul>
       </div>
       <div class="account-right col-md-10 col-xs-12 noonlypadding">
            <div class="account-con">
               
                
            <div class="account-form">
                <h3 class="heading">All Booking</h3>
                <div id="personaldets" class="personaldets col-xs-12 noonlypadding">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Hotel</th>
                    <th>Room type</th>
                    <th>Date</th>
                    <th>no of nights</th>
                    <th>Total cost</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result['booking']  as $row) { ?>
                    <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo date('d-M Y', strtotime($row['date_from'])) .' ---- '. date('d-M Y', strtotime($row['date_to'])); ?></td>
                    <td><?php echo $row['no_of_nights']; ?></td>
                    <td><?php echo $row['total_cost']; ?></td>
                    <td><?php if($row['approved'] == 0 ) { ?><a class="btn btn-warning global_delete del<?php echo $row['id']; ?>" rel="<?php echo $row['id']; ?>" bel="booking" href="javascript:void(0)">Approve</a> <?php }else{ echo 'Approved'; } ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                
                </table>
                </div>
        </div>

        <div class="account-right col-md-10 col-xs-12 noonlypadding">
            <div class="account-con">
               
                
            <div class="account-form">
                <h3 class="heading">Users</h3>
                <div id="personaldets" class="personaldets col-xs-12 noonlypadding">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result['users']  as $result) { ?>
                    <tr>
                        <td><?php echo $result['username']; ?></td>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['phone']; ?></td>
                        <td><a href="<?php echo base_url(); ?>uploads/<?php echo $result['file_upload']; ?>" target="_blank"><?php echo $result['file_upload']; ?> </a></td>
                    
                    </tr>
                    <?php } ?>
                </tbody>
                
                </table>
                </div>
        </div>

    </div>

<div class="clear"></div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('body').on('click','.global_delete',function(){
					  
                      if(confirm('Are you sure you want to Approve it?')==true)
                 {
                     var table=$(this).attr('bel');
                     var id=$(this).attr('rel');
                     
                     $.ajax({
                         type:'POST',
                         url:'admin/updateIntoTableAjax',
                         data:'table='+table+'&id='+id,
                         success:function(){
                             
                             $('.del'+id).text('Approved');

                             }
                         

                         })
                     
                 }
                     });
        });
	</script>
</main>
<?php $this->load->view('footer'); ?>