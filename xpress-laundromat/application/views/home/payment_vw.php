<form action="https://secure.payu.in/_payment" name="payuForm" id="payForm" method="post">
<input type="hidden" name="key" value="<?=$key?>">
<input type="hidden" name="txnid" value="<?=$txn?>">
<input type="hidden" name="amount" value="<?=$order_detail['amount']?>">
<input type="hidden" name="productinfo" value="<?=$order_detail['pro_info']?>">
<input type="hidden" name="firstname" value="<?=$userdata->firstname?>">
<input type="hidden" name="email" value="<?=$userdata->email_id?>">
<input type="hidden" name="phone" value="<?=$userdata->contact_no?>">
<input type="hidden" name="surl"  value="<?=BASE?>payments/success-payment">
<input type="hidden" name="furl" value="<?=BASE?>payments/fail-payment">
<input type="hidden" name="hash" value="<?=$hash?>">
<input type="hidden" name="service_provider" value="<?=$payment_method?>">
<input type="hidden" name='vald' value="<?=$hash_s?>">
<input type="hidden" name="udf1" value="<?=$userdata->id?>">
<input type="hidden" name="udf2" value="">
</form>

<script>
  var payuForm = document.forms.payuForm;
      payuForm.submit();
</script>
