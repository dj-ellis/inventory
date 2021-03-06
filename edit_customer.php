<?php
/**
 * edit_product.php
 *
 * @package default
 */


$page_title = 'Edit customer';
require_once 'includes/load.php';
// Checkin What level user has permission to view this page
page_require_level(2);

$customer = find_by_id('customers', (int)$_GET['id']);

if (!$customer) {
	$session->msg("d", "Missing customer id.");
	redirect('customers.php');
}
?>
<?php
if (isset($_POST['edit_customer'])) {
	$req_fields = array('customer-name' );
	validate_fields($req_fields);

	if (empty($errors)) {
		if (is_null($_POST['customer-name']) || $_POST['customer-name'] === "") {
			$c_name  =  '';
		} else {
			$c_name  = remove_junk($db->escape($_POST['customer-name']));
		}
		if (is_null($_POST['customer-address']) || $_POST['customer-address'] === "") {
			$c_address  =  '';
		} else {
			$c_address  = remove_junk($db->escape($_POST['customer-address']));
		}
		if (is_null($_POST['customer-postcode']) || $_POST['customer-postcode'] === "") {
			$c_postcode  =  '';
		} else {
			$c_postcode  = remove_junk($db->escape($_POST['customer-postcode']));
		}
		if (is_null($_POST['customer-telephone']) || $_POST['customer-telephone'] === "") {
			$c_telephone  =  '';
		} else {
			$c_telephone  = remove_junk($db->escape($_POST['customer-telephone']));
		}
		if (is_null($_POST['customer-email']) || $_POST['customer-email'] === "") {
			$c_email  =  '';
		} else {
			$c_email  = remove_junk($db->escape($_POST['customer-email']));
		}
		if (is_null($_POST['customer-paymethod']) || $_POST['customer-paymethod'] === "") {
			$c_paymethod  =  '';
		} else {
			$c_paymethod  = remove_junk($db->escape($_POST['customer-paymethod']));
		}

	if ( find_by_name('customers',$c_name) )
	{

		$query   = "UPDATE customers SET";
		$query  .=" name ='{$c_name}', address ='{$c_address}', postcode ='{$c_postcode}', telephone ='{$c_telephone}', email ='{$c_email}',";
		$query  .=" paymethod ='{$c_paymethod}'";
		$query  .=" WHERE id ='{$customer['id']}'";
		$result = $db->query($query);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', 'Customer Updated!');
			redirect('customers.php', false);
		} else {
			$session->msg('d', 'Failed to Update!');
			redirect('edit_customer.php?id='.$customer['id'], false);
		}

	} else {
			$session->msg('d', 'Failed to Update, Please Add!');
			redirect('edit_customer.php?id='.$customer['id'], false);
	}


	} else {
		$session->msg("d", $errors);
		redirect('edit_customer.php?id='.$customer['id'], false);
	}

}

?>
<?php include_once 'layouts/header.php'; ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
         <div class="col-md-7">
	<div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Edit Customer</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_customer.php?id=<?php echo (int)$customer['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-user"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-name" value="<?php echo remove_junk($customer['name']);?>">
               </div>
              </div>


              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-address" value="<?php echo remove_junk($customer['address']);?>" placeholder="Address">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-postcode" value="<?php echo remove_junk($customer['postcode']);?>" placeholder="Postal Code">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-telephone" value="<?php echo remove_junk($customer['telephone']);?>" placeholder="Telephone">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-globe"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-email" value="<?php echo remove_junk($customer['email']);?>" placeholder="Email">
               </div>
              </div>

           <div class="form-group">
                    <select class="form-control" name="customer-paymethod">
                      <option value="">Select Payment Method</option>
                     <option value="Cash" <?php if ($customer['paymethod'] === "Cash" ): echo "selected"; endif; ?> >Cash</option>
                     <option value="Check" <?php if ($customer['paymethod'] === "Check" ): echo "selected"; endif; ?> >Check</option>
                     <option value="Credit" <?php if ($customer['paymethod'] === "Credit" ): echo "selected"; endif; ?> >Credit</option>
                     <option value="Charge" <?php if ($customer['paymethod'] === "Charge" ): echo "selected"; endif; ?> >Charge to Account</option>
                    </select>

           </div>

	  <div class="pull-right">
              <button type="submit" name="edit_customer" class="btn btn-info">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once 'layouts/footer.php'; ?>
