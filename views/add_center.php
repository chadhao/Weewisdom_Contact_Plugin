<?php include 'style.php';?>
<div class="wrap">
  <form class="am-form am-form-horizontal" method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('add_center'));?>">
    <fieldset>
    <div class="am-form-group">
       <label for="name" class="am-u-sm-1 am-form-label">Name</label>
       <div class="am-u-sm-11">
           <input type="text" name="name" placeholder="add name">
       </div>
    </div>
    <div class="am-form-group">
      <label for="address" class="am-u-sm-1 am-form-label">Address</label>
      <div class="am-u-sm-11">
          <input type="text" name="address" placeholder="add address">
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
       <div class="am-u-sm-11 am-u-sm-offset-1">
           <button type="submit" class="am-btn am-btn-primary am-radius">Submit</button>
       </div>
    </div>
    </fieldset>
  </form>
</div>
