
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Chat App - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="icon" type="{{url('image/png')}}" href="images/icons/favicon.ico"/> -->
	<link rel="stylesheet" type="text/css" href="{{url('vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('css/main.css')}}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" id="form_data">
					<span class="login100-form-title p-b-51">
						Login
					</span>
						<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Mobile Number is required">
						<input class="input100" type="text" name="mobile" placeholder="Mobile Number">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt1">
								Forgot?                    
							</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="{{url('/signup')}}" class="txt1">
								Signup
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" id="submit_data">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	<script src="{{url('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{url('vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{url('js/main.js')}}"></script>
	<script type="text/javascript">
		var url = "<?php echo url(''); ?>";
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#submit_data').click(function(){
				var data = $('#form_data').serialize();
				$.post(url+'/login_sub',data,function(data,status){
					var resp = $.parseJSON(data);
					if(resp.status == 'true'){
						window.location.href = resp.url
					}else{
						alert(resp.msg)
					}
				});
				return false;
			});
		});
	</script>

</body>
</html>