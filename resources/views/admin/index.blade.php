<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Studify Admin Chat Interface</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: #F4F3FE;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    .container {
      max-width: 960px;
      padding: 20px;
    }

    h1 {
      font-weight: 700;
      color: #6C63FF;
      margin-bottom: 30px;
      text-align: center;
    }

    .card {
      background-color: #ffffff;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .card-header {
      background-color: transparent;
      border-bottom: none;
      padding: 16px 24px 0;
    }

    .card-header h5 {
      font-weight: 600;
      color: #6C63FF;
      margin-bottom: 0;
    }

    .card-body {
      padding: 20px 24px 24px;
    }

    .message-box {
      background-color: #f9f9ff;
      padding: 16px;
      border-radius: 10px;
      margin-bottom: 16px;
      box-shadow: 0 4px 10px rgba(108, 99, 255, 0.05);
    }

    .message-box p {
      margin-bottom: 6px;
    }

    .message-box strong {
      color: #6C63FF;
    }

    .btn {
      border-radius: 8px;
      font-weight: 600;
    }

    .btn-warning {
      background-color: #FFB547;
      border: none;
    }

    .btn-danger {
      background-color: #FF6B6B;
      border: none;
    }

    .btn-primary {
      background-color: #6C63FF;
      border: none;
    }

    .btn-primary:hover {
      background-color: #574FDB;
    }

    textarea,
    select {
      border-radius: 8px;
    }

    textarea:focus,
    select:focus {
      outline: none;
      border-color: #6C63FF;
      box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.25);
    }

    .footer {
      text-align: center;
      padding: 20px;
      background-color: #6C63FF;
      color: white;
      font-size: 0.9rem;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
      margin-top: 40px;
    }

    @media (max-width: 576px) {
      .container {
        padding: 15px;
      }

      h1 {
        font-size: 1.5rem;
      }

      .card-body,
      .card-header {
        padding: 16px;
      }

      .message-box {
        font-size: 0.95rem;
      }

      .btn {
        font-size: 0.875rem;
        padding: 6px 12px;
      }

      .footer {
        font-size: 0.8rem;
        padding: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Studify Admin Chat Interface</h1>

    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header">
        <h5>Riwayat Percakapan</h5>
      </div>
      <div class="card-body">
        @if($conversations->count())
          @foreach($conversations as $conversation)
            <div class="message-box">
              <p><strong>User:</strong> {{ $conversation->user_input }}</p>
              <p><strong>Bot/Admin:</strong> {{ $conversation->bot_response }}</p>
              <div class="d-flex justify-content-end mt-2">
                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $conversation->id }}">Edit</button>
                <form action="{{ route('chatbot.destroy', $conversation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus percakapan ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </div>
            </div>

            <div class="modal fade" id="editModal{{ $conversation->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $conversation->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $conversation->id }}">Edit Percakapan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('chatbot.update', $conversation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="user_input{{ $conversation->id }}" class="form-label">User Input:</label>
                        <textarea name="user_input" id="user_input{{ $conversation->id }}" class="form-control" required>{{ $conversation->user_input }}</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="bot_response{{ $conversation->id }}" class="form-label">Bot Response:</label>
                        <textarea name="bot_response" id="bot_response{{ $conversation->id }}" class="form-control" required>{{ $conversation->bot_response }}</textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <p class="text-muted">Belum ada percakapan.</p>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h5>Kirim Pesan ke User & Update Respon Chatbot</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('chatbot.send') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="admin_message" class="form-label">Pesan User:</label>
            <textarea name="admin_message" id="admin_message" rows="3" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label for="stage" class="form-label">Stage:</label>
            <select name="stage" id="stage" class="form-select" required>
              <option value="greeting">Greeting</option>
              <option value="check_health">Check Health</option>
              <option value="closing">Closing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="chatbot_response" class="form-label">Respon Chatbot:</label>
            <textarea name="chatbot_response" id="chatbot_response" rows="3" class="form-control" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100">Kirim Pesan & Update Respon</button>
        </form>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; 2025 Studify Admin Chat Interface. Built with care for the community.</p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
