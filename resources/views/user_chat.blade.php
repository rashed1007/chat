<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Responsive Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 10px;
        }

        .chat-input {
            border-top: 1px solid #ddd;
            padding: 10px;
        }

        .user-message {
            background-color: #4CAF50;
            color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            max-width: 80%;
        }

        .other-message {
            background-color: #e0e0e0;
            color: black;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            max-width: 80%;

        }

        .message-time {
            font-size: 0.8rem;
            color: #888;
        }
    </style>


    {{-- Include Pusher from CDN --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

    <!-- Include Axios from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="chat-container mt-5">
            <!-- Chat Header -->
            <div class="chat-header bg-primary text-white text-center py-3 rounded-top">
                <h4>{{ $username . ' - last seen at :' . $last_seen->format('h:i A') }}</h4>
            </div>

            <!-- Chat Box -->
            <div class="chat-box mt-2 mb-2" id="chat-box"> <!-- Add id="chat-box" -->

                @foreach ($messages as $m)
                    @if ($m->sender_id == Auth::id())
                        <div class="message user-message">
                            <p>{{ $m->content }}</p>
                            <div class="message-time">{{ $m->created_at->format('h:i A') }}</div>
                            @if ($m->is_seen == true)
                                <div class="message-time">Seen</div>
                            @else
                                <div class="message-time">Not Seen</div>
                            @endif
                        </div>
                    @else
                        <div class="message other-message">
                            <p>{{ $m->content }}</p>
                            <div class="message-time">{{ $m->created_at->format('h:i A') }}</div>
                        </div>
                    @endif
                @endforeach

            </div>

            <!-- Chat Input -->

            <div class="chat-input d-flex">
                <form action="{{ route('profile.sendMessage', ['user_id' => $user_id]) }}" method="post">
                    @csrf
                    <input name="message" type="text" class="form-control me-2" placeholder="Type a message...">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <input type="hidden" id="auth-user-id" value="{{ Auth::id() }}">

                </form>
            </div>
        </div>
    </div>



    <script>
        // Initialize Pusher and Laravel Echo
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '9aaa201eb4850be666a2', // Replace with your Pusher key
            cluster: 'eu', // Replace with your Pusher cluster
            encrypted: true,
        });



        // Now you can use Axios
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';




        // Listen for the new message event
        const authUserId = document.getElementById('auth-user-id').value;
        Echo.channel('chat.{{ min(Auth::id(), $user_id) }}.{{ max(Auth::id(), $user_id) }}')
            .listen('.message-sent', (event) => {
                let chatBox = document.getElementById('chat-box');
                let newMessage = document.createElement('div');
                // Check if the authenticated user is the sender of the message
                if (event.message.sender_id == authUserId) {
                    // This is the sender's message (user-message style)
                    newMessage.classList.add('message', 'user-message');
                } else {
                    // This is the receiver's message (other-message style)
                    newMessage.classList.add('message', 'other-message');
                }
                newMessage.innerHTML =
                    `<p>${event.message.content}</p><div class="message-time">{{ $m->created_at->format('h:i A') }}</div>`;
                chatBox.appendChild(newMessage);
                chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the latest message
            })



        // Handle message submission
        document.querySelector('.chat-input form').addEventListener('submit', function(e) {
            e.preventDefault();
            let message = document.querySelector('input[name="message"]')
                .value; // Use name attribute to get the input value

            axios.post("{{ route('profile.sendMessage', ['user_id' => $user_id]) }}", {
                message: message
            }).then(response => {
                document.querySelector('input[name="message"]').value = ''; // Clear the input
            }).catch(error => console.log(error));
        });
    </script>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>





</body>

</html>
