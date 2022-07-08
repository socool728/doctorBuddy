<html>
<head>
  <title>PeerJS - Video chat example</title>
  <link href="<?php echo asset('css/style_video.css'); ?>" rel="stylesheet">
  <link href="<?php echo asset('css/fancy_video.css'); ?>" rel="stylesheet" type="text/css">
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo asset('js/peer.js'); ?>"></script>
  <script>
    // Compatibility shim
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // PeerJS object
    var peer = new Peer({ key: 'hi9vqjnbeayycik9', debug: 3});

    peer.on('open', function(){
        $('#my-id').text(peer.id);
    });
    
    var connectedPeers = {};
    
    // Await connections from others
    peer.on('connection', connect);

    // Handle a connection object.
    function connect(c) {
        // Handle a chat connection.
        if (c.label === 'chat') {
            var chatbox = $('<div></div>').addClass('connection').addClass('active').attr('id', c.peer);
            var header = $('<h1></h1>').html('Chat with <strong>' + c.peer + '</strong>');
            var messages = $('<div><em>Partner connected.</em></div>').addClass('messages');
            chatbox.append(header);
            chatbox.append(messages);

            // Select connection handler.
            chatbox.on('click', function() {
              if ($(this).attr('class').indexOf('active') === -1) {
                $(this).addClass('active');
              } else {
                $(this).removeClass('active');
              }
            });
            $('.filler').hide();
            $('#connections').append(chatbox);

            c.on('data', function(data) {
                messages.append('<div><span class="peer">' + c.peer + '</span>: ' + data +
                  '</div>');
            });
            c.on('close', function() {
                alert(c.peer + ' has left the chat.');
                chatbox.remove();
                if ($('.connection').length === 0) {
                  $('.filler').show();
                }
                delete connectedPeers[c.peer];
            });
        } 
        connectedPeers[c.peer] = 1;
    }

    // Receiving a call
    peer.on('call', function(call){
      // Answer the call automatically (instead of prompting user) for demo purposes
      call.answer(window.localStream);
      step3(call);
    });
    
    peer.on('error', function(err){
      alert(err.message);
      // Return to step 2 if error occurs
      step2();
    });

    // Click handlers setup
    $(function(){
        $('#make-call').click(function(){
            // Initiate a call!
            var call = peer.call($('#callto-id').val(), window.localStream);

            var requestedPeer = $('#callto-id').val();
            if (!connectedPeers[requestedPeer]) {
                // Create 2 connections, one labelled chat and another labelled file.
                var c = peer.connect(requestedPeer, {
                  label: 'chat',
                  serialization: 'none',
                  metadata: {message: 'hi i want to chat with you!'}
                });
                c.on('open', function() {
                  connect(c);
                });
                c.on('error', function(err) { alert(err); });
                var f = peer.connect(requestedPeer, { label: 'file', reliable: true });
                f.on('open', function() {
                  connect(f);
                });
                f.on('error', function(err) { alert(err); });
            }
            connectedPeers[requestedPeer] = 1;

            step3(call);
        });

        $('#end-call').click(function(){
            eachActiveConnection(function(c) {
                c.close();
            });
            window.existingCall.close();
            step2();
        });
        
        // Send a chat message to all active connections.
        $('#send').submit(function(e) {
            e.preventDefault();
            // For each active connection, send the message.
            var msg = $('#text').val();
            eachActiveConnection(function(c, $c) {
              if (c.label === 'chat') {
                c.send(msg);
                $c.find('.messages').append('<div><span class="you">You: </span>' + msg
                  + '</div>');
              }
            });
            $('#text').val('');
            $('#text').focus();
        });
        
        // Retry if getUserMedia fails
        $('#step1-retry').click(function(){
            $('#step1-error').hide();
            step1();
        });
        
        // Goes through each active peer and calls FN on its connections.
        function eachActiveConnection(fn) {
            var actives = $('.active');
            var checkedIds = {};
            actives.each(function() {
                var peerId = $(this).attr('id');

                if (!checkedIds[peerId]) {
                  var conns = peer.connections[peerId];
                  for (var i = 0, ii = conns.length; i < ii; i += 1) {
                    var conn = conns[i];
                    fn(conn, $(this));
                  }
                }
                
                checkedIds[peerId] = 1;
            });
        }
        
        // Get things started
        step1();
    });

    function step1 () {
      // Get audio/video stream
      navigator.getUserMedia({audio: true, video: true}, function(stream){
        // Set your video displays
        $('#my-video').prop('src', URL.createObjectURL(stream));

        window.localStream = stream;
        step2();
      }, function(){ $('#step1-error').show(); });
    }

    function step2 () {
      $('#step1, #step3').hide();
      $('#step2').show();
    }

    function step3 (call) {
      // Hang up on an existing call if present
      if (window.existingCall) {
        window.existingCall.close();
      }

      // Wait for stream on the call, then set peer video display
      call.on('stream', function(stream){
        $('#their-video').prop('src', URL.createObjectURL(stream));
      });

      // UI stuff
      window.existingCall = call;
      $('#their-id').text(call.peer);
      call.on('close', step2);
      $('#step1, #step2').hide();
      $('#step3').show();
    }

  </script>


</head>

<body>

    <div class="pure-g">
        <div class="stephead">
            <h2>Video Chat</h2>

            <!-- Get local audio/video stream -->
            <div id="step1">
                <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
                <div id="step1-error">
                  <p>Failed to access the webcam and microphone. Make sure to run this demo on an http server and click allow when asked for permission by the browser.</p>
                  <a href="#" class="pure-button pure-button-error" id="step1-retry">Try again</a>
                </div>
            </div>
            
            <!-- Make calls to others -->
            <div id="step2">
                <p>Your id: <span id="my-id">...</span><span> (Share this id with others so they can call you)</span></p>
                <div class="pure-form">
                    <input type="text" placeholder="Call user id..." id="callto-id">
                    <a href="#" class="pure-button pure-button-success" id="make-call">Call</a>
                </div>
            </div>
            
            <!-- Call in progress -->
            <div id="step3">
                <p>Currently in call with <span id="their-id">...</span></p>
                <p><a href="#" class="pure-button pure-button-error" id="end-call">End call</a></p>
            </div>
        </div>
        
        <div class="pure-chat">
            <!-- Left Video Area -->
            <div class="pure-u-2-3" id="video-container">
                <video id="their-video" autoplay></video>
                <video id="my-video" autoplay></video>
            </div>
            <!-- Right Chat Area -->
            <div class="pure-u-1-3">
                <div id="wrap">
                    <div id="connections"><span class="filler">Call to start chat..</span></div>
                    <div class="clear"></div>
                </div>
                <div id="messagebox">
                    <form id="send">
                        <input type="text" id="text" placeholder="Enter message" style="width:96%;">
                        <input class="button" type="submit" value="Send">
                    </form>
                </div>
            </div>
        </div>    
    </div>


</body>
</html>
