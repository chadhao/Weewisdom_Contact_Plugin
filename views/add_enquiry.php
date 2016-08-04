<?php include 'style.php';?>
<div class="wrap">
  <form class="am-form am-form-horizontal" method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('add_enquiry', $_GET['center_id']));?>">
    <fieldset>
    <div class="am-form-group">
       <label for="name" class="am-u-sm-1 am-form-label">Name</label>
       <div class="am-u-sm-11">
           <input type="text" name="name" placeholder="add name">
       </div>
    </div>
    <div class="am-form-group">
      <label for="email" class="am-u-sm-1 am-form-label">Email</label>
      <div class="am-u-sm-11">
          <input type="text" name="email" placeholder="add email">
      </div>
    </div>
    <div class="am-form-group">
       <label for="phone" class="am-u-sm-1 am-form-label">Phone</label>
       <div class="am-u-sm-11">
           <input type="text" name="phone" placeholder="add phone">
       </div>
    </div>
    <div class="am-form-group">
       <label for="center_id" class="am-u-sm-1 am-form-label">Center_ID</label>
       <div class="am-u-sm-11">
           <input type="hidden" name="center_id" value="<?php echo $_GET['center_id'];?>">
       </div>
    </div>
    <div class="am-form-group">
       <label for="is_contacted" class="am-u-sm-1 am-form-label">Is_Contacted</label>
       <div class="am-u-sm-11">
          <input type="text" name="is_contacted">
           <!--<input type="checkbox" name="is_contacted" >-->
       </div>
    </div>

    <div class="am-form-group">
       <div class="am-u-sm-11 am-u-sm-offset-1">
           <button type="submit" class="am-btn am-btn-primary am-radius">Submit</button>
       </div>
    </div>
    </fieldset>
  </form>
</div>
