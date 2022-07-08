<form action="<?php echo $data['action_url']; ?>" method="post" id="paypal_form">

    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business" value="<?php echo $data['paypal_id']; ?>">

    <!-- Specify a Buy Now button. -->
    <input type="hidden" name="cmd" value="_xclick">

    <!-- Specify details about the item that buyers will purchase. -->
    <input type="hidden" name="item_name" value="<?php echo $data['item_name']; ?>">
    <input type="hidden" name="item_number" value="<?php echo $data['item_number']; ?>">
    <input type="hidden" name="amount" value="<?php echo $data['amount']; ?>">
    <input type="hidden" name="currency_code" value="<?php echo $data['currency_code']; ?>">

    <!-- Specify URLs -->
    <input type='hidden' name='cancel_return' value='<?php echo $data['cancel_return']; ?>'>
    <input type='hidden' name='return' value='<?php echo $data['return']; ?>'>
    <input type='hidden' name='notify_url' value='<?php echo $data['notify_url']; ?>'>
    <input type="hidden" value="2" name="rm">
    <input type="hidden" value="<?php echo $data['custom']; ?>" name="custom">

</form>