<?php

require_once('stripe-php-3.20.0/init.php'); // download on https://github.com/stripe/stripe-php/releases


if ($_POST) {
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_live_xxxxxxxxxxxxxxxxxxxxxxxx");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
  
$customer = \Stripe\Customer::create(array(
  "source" => $token, // obtained from Stripe.js
  "plan" => "goldtest",
  "email" => $_POST['email'],
  "application_fee_percent" => 33
),
  
  array("stripe_account" => acct_xxxxxxxxxxxxxxxx)
//acct_xxxxxxxxxxxxxxxx is the connected account id, find it in the dashboard under connected accounts
);
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}

}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Stripe Getting Started Form</title>

        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        





        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below.
	    // See your pub. key here https://dashboard.stripe.com/account/apikeys

            Stripe.setPublishableKey('pk_live_xxxxxxxxxxxxxxxxxxxxxxxx');
			
			
			
        
			
$(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});

function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;
$form.find('.payment-success').text('it worked! token is: ' + token);
    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));
//alert(token);
    // Submit the form:
   $form.get(0).submit();
  }
};


        </script>
    </head>
    <body>
        <h1>Subscribe to a monthly plan. $1.50/mo</h1>
       
       
        

<form action="" method="POST" id="payment-form">


  <div class="form-row">
    <label>
      <span>Card Number</span>
      <input type="text" size="20" data-stripe="number">
    </label>
  </div>
<div class="form-row">
    <label>
      <span>Email</span>
      <input type="text" size="20" data-stripe="email">
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Expiration (MM/YY)</span>
      <input type="text" size="2" data-stripe="exp_month">
    </label>
    <span> / </span>
    <input type="text" size="2" data-stripe="exp_year">
  </div>

  <div class="form-row">
    <label>
      <span>CVC</span>
      <input type="text" size="4" data-stripe="cvc">
    </label>
  </div>

  <input type="submit" class="submit" value="Submit Payment">
  
</form>


    </body>
</html>
