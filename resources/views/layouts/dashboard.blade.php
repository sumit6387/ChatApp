<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<!-- <meta http-equiv="refresh" content="3;url=http://localhost/ChatApp/public/test2" /> -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link rel="stylesheet" type="text/css" href="{{url('css/main.css')}}">
		<!-- 
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css"> -->
		<link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">
	</head>
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts">
						@foreach($users as $user)
								@if(Cache::has('is_online' . $user->id))
                                                <?php $class = ''; ?>
                                            @else
                                                <?php $class = 'offline'; ?>
                                            @endif
								<li class="active">
									<a href="javascript:;" class="show_hide" value="{{$user->id}}"  style="text-decoration: none;">
									<div class="d-flex bd-highlight">
										<input type="hidden" name="id" class="id" value="{{$user->id}}">
										<div class="img_cont">
											<img src="{{$user->images}}" class="rounded-circle user_img">
											<span class="online_icon {{$class}}"></span>
										</div>
										<div class="user_info show_hidess">
											<span>{{$user->name}}</span>
											@if($class == '')
												<p>{{$user->name}} is online</p>
											@else
											<p>offline</p>
											@endif
										</div>
									</div></a>
								</li>
						@endforeach
						
						</ui>
					</div>
					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-8 col-xl-6 chart">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight chats">
								<div class="img_cont">
									<img src="https://randomuser.me/api/portraits/men/41.jpg" class="rounded-circle user_img" id="user_img">
									
								</div>
								<div class="user_info">
									<span id="username"></span>
									<p id="no_messges">1767 Messages</p>
								</div>
								<div class="video_cam">
									<span><i class="fas fa-video"></i></span>
									<span><i class="fas fa-phone"></i></span>
								</div>

							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i> View profile</li>
									<li><i class="fas fa-users"></i> Add to close friends</li>
									<li><i class="fas fa-plus"></i> Add to group</li>
									<li><i class="fas fa-ban"></i> Block</li>
									<li><i class="fas fa-ban"></i><a href="{{url('/logout')}}" style="text-decoration: none;color:white;">Logout</a></li>
								</ul>
							</div>
						</div>
							<input type="hidden" id="recieve_id" data-id=""></a>

						<div class="card-body msg_card_body" id="user_message">
							<!-- sender msg -->
							
							
						
					</div>
				</div>
			</div>
		</div>
	</body>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script> -->
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script type="text/javascript">
		var url = "<?php echo url(''); ?>"
	</script>
	<script>
    var pusher = new Pusher('5d7db225b75d4e70b1d8', {
      cluster: 'ap2'
    });
    var channel = pusher.subscribe('message');
    channel.bind('fetch-data', function(data) {
    	var data = JSON.parse(JSON.stringify(data));
         var n = JSON.parse(data.data);
         console.log(n)
         data = ''
		// var data = document.getElementById('user_message')
		var current_user = <?php echo Session::get('id') ?>;
						      	if(n.send_by != current_user){
						      		data += `<div class="d-flex justify-content-start mb-4">
														<div class="img_cont_msg">
															<img src="${n.images}" class="rounded-circle user_img_msg">
														</div>
														<div class="msg_cotainer">
															${n.msg}
															<span class="msg_time">${n.msg_time}</span>
														</div>
													</div>`;
						      	}else{
						      		data += `<div class="d-flex justify-content-end mb-4">
														<div class="msg_cotainer_send">
															${n.msg}
															<span class="msg_time_send">${n.msg_time}</span>
														</div>
														<div class="img_cont_msg">
													<img src="{{Session::get('image')}}" class="rounded-circle user_img_msg">
														</div>
													</div>`;
						      	}
						      $('#user_message').append(data);
						      $('#type_msg1').val('')
						      // document.getElementById("user_message").appendChild(data);


						      });
  </script>
	<script type="text/javascript">
			$(document).ready(function(){
				$('.chart').hide();
				$('.show_hide').click(function(){
					var user_id = $(this).attr('value');
					$.get(url+'/getMessage/'+user_id,function(data,status){
						var resp = JSON.parse(data);
						      var n = resp.user;
						      var m = resp.data;
						      // console.log(JSON.stringify(data))
						      // console.log(resp)

						      // user's data
						      $('#username').html('Chat with '+n.name);
						      $('#user_img').attr('src',n.images);
						      $('#recieve_id').attr('data-id',n.id)
						      $('#no_messges').html(m.length + ' Messages');
						      data = '';
						      var current_user = <?php echo Session::get('id') ?>;
						      // messages
						      data = '';
						      $.each(m,function(index,value){
						      	if(value.send_by != current_user){
						      		data += `<div class="d-flex justify-content-start mb-4">
														<div class="img_cont_msg">
															<img src="${n.images}" class="rounded-circle user_img_msg">
														</div>
														<div class="msg_cotainer">
															${value.msg}
															<span class="msg_time">${value.msg_time}</span>
														</div>
													</div>`;
						      	}else{
						      		data += `<div class="d-flex justify-content-end mb-4">
														<div class="msg_cotainer_send">
															${value.msg}
															<span class="msg_time_send">${value.msg_time}</span>
														</div>
														<div class="img_cont_msg">
													<img src="{{Session::get('image')}}" class="rounded-circle user_img_msg">
														</div>
													</div>`;
						      	}
						      });
						      data += `<div class="card-footer" style="position: absolute;bottom: 10px;width: 95%;">
													<div class="input-group">
														<div class="input-group-append">
															<span class="input-group-text attach_btn"><i class="fas fa-paperclip" id="submit"></i></span>
														</div>
														<textarea class="form-control type_msg" id="type_msg1" value="" placeholder="Type your message..." ></textarea>
														<input type="hidden" id="csrf" value="{{csrf_token()}}">
														<div class="input-group-append">
															<span class="input-group-text send_btn" id="send_button"><i class="fas fa-location-arrow"></i></span>
														</div>
													</div>
												</div>`;
						      $('#user_message').html(data);
						      $('.chart').css('padding-top','8%');
							  $('.chart').show();

						    });
											});


				$('#action_menu_btn').on('click',function(){
					$('.action_menu').toggle();
				});
	});
	</script>
	<script type="text/javascript">
		document.addEventListener('touchstart',function(){
			var button = document.getElementById('send_button');
			$('#send_button').unbind().on('click',function(){
				var data = $('#type_msg1').val()
				var recieve_id = $('#recieve_id').attr('data-id');
				var time = new Date();
  				var times = time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
				if(data != ''){
					$.post(url+'/sendmessage',{
							'msg' : data,
							'_token' : $('#csrf').val(),
							'recieve_id' : recieve_id,
							'time' : times
						},function(data , status){
						console.log(data)
					});
				}else{
					alert('Enter message');
				}
			});
			return false;
		},{passive : true});
	</script>
	
</html>
