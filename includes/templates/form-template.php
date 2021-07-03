<?php 

//Template  Custom Form
$options = get_option( 'Form_Submissions_options' );
$api_key = $options['api_key'];
?>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js" type="text/javascript"></script>
		<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		</script>
		<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
		</script>
		<style>
			.final{display:none;}
			.btn + .btn {margin-left: 0;}
		</style>
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
	<div class="container">

	<form autocomplete="off" id="msform_booking" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" >
		  <h2>Contact Us</h2>
		  <div class="row">
		
			<div class="col-md-6">
			  <div class="form-group">
				<label for="first">First Name</label>
				<input type="text" class="form-control" name="cf-name" required value="<?php  ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) ?>" id="first" placeholder="First Name">
			  </div>
			</div>
			<!--  col-md-6   -->
			<div class="col-md-6">
			  <div class="form-group">
				<label for="first">Last Name</label>
				<input type="text" class="form-control" name="cf-name-last" required value="<?php  ( isset( $_POST["cf-name-last"] ) ? esc_attr( $_POST["cf-name-last"] ) : '' ) ?>" id="last" placeholder="Last Name">
			  </div>
			</div>
			<!--  col-md-6   -->
		  </div>
	  
	  
		  <div class="row">
		  <div class="col-md-6">
        <div class="form-group">
          <label for="company">Company</label>
          <input type="text" class="form-control" placeholder="" id="company">
        </div>


      </div>
			<!--  col-md-6   -->
	  
			<div class="col-md-6">
	  
			  <div class="form-group">
				<label for="phone">Phone Number</label>
				<input type="tel" class="form-control" id="cf-phone" name="cf-phone" placeholder="Phone">
			  </div>
			</div>
			<!--  col-md-6   -->
		  </div>
		  <!--  row   -->
	  
	  
		  <div class="row">
			<div class="col-md-6">
	  
			  <div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="cf-email" name="cf-email" placeholder="Email">
			  </div>
			</div>
			<!--  col-md-6   -->
			<div class="col-md-6">
        <div class="form-group">
          <label for="url">Your Website <small>Please include http://</small></label>
          <input type="url" class="form-control" id="url" placeholder="url">
        </div>

      </div>
		
			<!--  col-md-6   -->
		  </div>
		  <!--  row   -->
			<label for="contact-preference">When is the best time of day to reach you?</label>
    <div class="radio">
      <label>
        <input type="radio" name="contact-preference" id="contact-preference" value="am" checked>Morning
      </label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="contact-preference" id="contact-preference" value="pm" checked>Evening
				</label>
			</div>

			<label for="newsletter">Would you like to recieve our email newsletter?</label>
			<div class="checkbox">

				<label>
					<input type="checkbox" value="Sure!" id="newsletter"> Sure!
				</label>
			</div>


			<span name="submitted_2" id="tohide" onClick="gcaptchacheck()" class="btn btn-primary">Validate</span>

		  <input type="submit" id="#submit_final" name="submitted" class="btn btn-primary final" value="Submit">

			<div style="margin-top:1rem;" id="capchag" class="grecaptcha"></div>			
		</form>
	  </div>
<script type="text/javascript">
var widgetId1;
var onloadCallback = function() {
 widgetId1 = grecaptcha.render('capchag', {
          'sitekey' : '6Levq8saAAAAAOEU55ISv94V09nnU6MY4HrzbqmI',
          'theme' : 'light'
        }); 
};
</script>
<script>
function gcaptchacheck() {
	(function($) {
   var response = grecaptcha.getResponse(widgetId1);
   if(response != ""){
		jQuery("#msform_booking").attr('action', '<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>');
		jQuery("#tohide").hide();
		jQuery(".final").show();
   }else{
     alert("Please complete the captcha!");
   }
	})(jQuery);
}
</script>