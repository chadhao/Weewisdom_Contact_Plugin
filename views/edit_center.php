<?php include 'style.php';?>
<div class="wrap">
  <form class="am-form am-form-horizontal" method="post" action="<?php echo WW_Module::ww_manage_get_url('update_center', $_SESSION['id']);?>">
    <fieldset>
    <div class="am-form-group">
       <label for="name" class="am-u-sm-1 am-form-label">Name</label>
       <div class="am-u-sm-11">
           <input type="text" name="name" value="<?php echo $_SESSION['name'];?>">
       </div>
    </div>
    <div class="am-form-group">
      <label for="address" class="am-u-sm-1 am-form-label">Address</label>
      <div class="am-u-sm-11">
          <input type="text" name="address" value="<?php echo $_SESSION['address'];?>">
      </div>
    </div>
    <div class="am-form-group">
       <label for="email" class="am-u-sm-1 am-form-label">Email</label>
       <div class="am-u-sm-11">
           <input type="text" name="email" value="<?php echo $_SESSION['email'];?>">
       </div>
    </div>
    <div class="am-form-group">
       <label for="phone" class="am-u-sm-1 am-form-label">Phone</label>
       <div class="am-u-sm-11">
           <input type="text" name="phone" value="<?php echo $_SESSION['phone'];?>">
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