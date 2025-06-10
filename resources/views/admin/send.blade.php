<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Bot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">ChatBot</h1>
        <div class="card mt-4">
            <div class="card-body">
                <div id="chat-window" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                    <!-- Chat messages will be appended here -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan Anda di sini...">
                    <button class="btn btn-primary" id="send-button">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Kirim pesan ke server
            $('#send-button').on('click', function () {
                const userInput = $('#user-input').val().trim();
                if (userInput === '') {
                    alert('Mohon masukkan pesan!');
                    return;
                }

                // Tambahkan pesan pengguna ke jendela chat
                $('#chat-window').append('<div><strong>Anda:</strong> ' + userInput + '</div>');

                // Kirim pesan ke server menggunakan AJAX
                $.ajax({
                    url: "{{ route('chatbot.send') }}",
                    method: "POST",
                    data: {
                        user_input: userInput,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        // Tampilkan respons bot
                        $('#chat-window').append('<div><strong>Bot:</strong> ' + response.response + '</div>');
                        $('#chat-window').scrollTop($('#chat-window')[0].scrollHeight);
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat mengirim pesan.');
                    }
                });

                // Kosongkan input setelah dikirim
                $('#user-input').val('');
            });
        });
    </script>
</body>
</html>
