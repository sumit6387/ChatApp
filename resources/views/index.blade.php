<!DOCTYPE html>
<head>
  <title>Pusher Test</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>
    hello()
function hello(){
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('5d7db225b75d4e70b1d8', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
    //  var n =  JSON.parse(JSON.stringify(data));
    //  var m = JSON.parse(n.text);
    // console.log(m.id);
      $('#text').html(data.text);
      alert(JSON.stringify(data));
    });
  }
  </script>
  <script type="text/javascript">
    // setInterval(hello,2000)
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p id="text">{{$coins->coins}}</p>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>