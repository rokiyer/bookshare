<div class="row">
  <div class="span4">
    <div class="alert alert-error hide" id="msg-box"></div>
    
		<table class="table table-striped">
		    <tr>
		      <td>User Name</td>
		      <td><?=$username?></td>
		    </tr>
		    <tr>
		      <td>Cellphone</td>
		      <td><?=$cellphone?></td>
		    </tr>
		    <tr>
		      <td>E-mail</td>
		      <td><?=$email?></td>
		    </tr>
		    <!-- <tr>
		      <td>School</td>
		      <td><?=$school?></td>
		    </tr>
		    <tr>
		      <td>Student Number</td>
		      <td><?=$stuno?></td>
		    </tr> -->
		    <tr>
		      <td>Create Date</td>
		      <td><?=$create_time?></td>
		    </tr>
		</table>

		<a class="btn btn-block btn-primary" href="<?php echo site_url('space/profile_edit');?>" type="button">Edit My Profile</a>
		<a class="btn btn-block btn-success" href="<?php echo site_url('space/profile_pwd');?>"type="button">Change Password</a>
		<!-- <button class="btn btn-block btn-danger" type="button">Delete Account</button> -->

	</div> 
	<!-- end of span -->

	<div class="span5">
		<?php if( substr($username , 0 , 4) == 'User' ){ ?>
		<div class="alert alert-block">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Warning!</h4>
		  Please change your default username .
		</div>
		<?php }?>

		<?php if( empty($email) ){ ?>
		<div class="alert alert-block">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Warning!</h4>
		  Please set up your Email address .
		</div>
		<?php }?>
	</div> 

</div>


<script type="text/javascript">
  
</script>