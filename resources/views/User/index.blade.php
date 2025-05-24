<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Studify Chatbot</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(180deg, #f8e8ff, #e3d5fa);
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .chat-container {
      width: 100%;
      max-width: 430px;
      height: 90vh;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      position: relative;
    }

    .chat-header {
      background: #ffffff;
      padding: 14px 18px;
      border-bottom: 1px solid #ddd;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .back-button {
      background: none;
      border: none;
      font-size: 20px;
      cursor: pointer;
      color: #555;
      display: flex;
      align-items: center;
    }

    .header-content {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo {
      width: 38px;
      height: 38px;
      object-fit: contain;
    }

    .genie-name {
      background-color: #b79fff;
      padding: 6px 14px;
      border-radius: 20px;
      color: white;
      font-weight: 600;
      font-size: 15px;
    }

    .chat-body {
      flex: 1;
      padding: 16px;
      background: #fdfbff;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 14px;
      scroll-behavior: smooth;
    }

    .chat-message {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 18px;
      font-size: 14px;
      line-height: 1.5;
      word-wrap: break-word;
    }

    .chat-message.user {
      align-self: flex-end;
      background: #c69fff;
      color: white;
    }

    .chat-message.bot {
      align-self: flex-start;
      background: #f0ebff;
      color: #333;
    }

    .chat-footer {
      display: flex;
      padding: 14px 16px;
      background: white;
      border-top: 1px solid #eee;
      gap: 8px;
    }

    textarea {
      flex: 1;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 15px;
      background-color: #f9f5ff;
      font-size: 14px;
      resize: none;
      min-height: 40px;
      transition: all 0.3s ease;
    }

    textarea:focus {
      border-color: #a46cf0;
      outline: none;
      background-color: #fffaff;
    }

    button {
      background-color: #b98eff;
      border: none;
      padding: 10px 16px;
      border-radius: 14px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #a46cf0;
    }

    @media (max-width: 600px) {
      body {
        height: 100dvh;
      }

      .chat-container {
        width: 100%;
        height: 100dvh;
        border-radius: 0;
      }

      .chat-header {
        padding: 12px;
      }

      .genie-name {
        font-size: 13px;
        padding: 5px 12px;
      }

      .chat-body {
        padding: 12px;
        gap: 10px;
      }

      .chat-footer {
        flex-direction: column;
        padding: 10px;
      }

      textarea {
        width: 100%;
        margin: 0;
      }

      button {
        width: 100%;
      }

      .chat-message {
        font-size: 13px;
        padding: 10px 14px;
      }

      .chat-message.user,
      .chat-message.bot {
        max-width: 90%;
      }
    }
  </style>

  <script>
    async function sendInput() {
      const chatBody = document.querySelector(".chat-body");
      const userInput = document.getElementById("user_input").value.trim();

      if (!userInput) return;

      const userMessage = document.createElement("div");
      userMessage.className = "chat-message user";
      userMessage.textContent = userInput;
      chatBody.appendChild(userMessage);
      chatBody.scrollTop = chatBody.scrollHeight;

      const formData = new FormData();
      formData.append("user_input", userInput);
      formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

      try {
        const response = await fetch("http://127.0.0.1:8000/chatbot", {
          method: "POST",
          headers: { "Accept": "application/json" },
          body: formData
        });

        const data = await response.json();

        const botMessage = document.createElement("div");
        botMessage.className = "chat-message bot";
        botMessage.textContent = data.response;
        chatBody.appendChild(botMessage);

        if (data.response.includes("Boleh, silahkan melanjutkan ke halaman konsul, berikut jadwal dari dokter kami")) {
          const button = document.createElement("button");
          button.textContent = "Lihat To-Do List";
          button.onclick = () => window.location.href = "/user/schedules";

          const container = document.createElement("div");
          container.style.textAlign = "center";
          container.style.marginTop = "10px";
          container.appendChild(button);
          chatBody.appendChild(container);
        }

        chatBody.scrollTop = chatBody.scrollHeight;
        document.getElementById("user_input").value = "";
      } catch (error) {
        console.error("Error sending input:", error);
      }
    }
  </script>
</head>

<body>
  <div class="chat-container">
    <div class="chat-header">
      <button class="back-button" onclick="window.location.href='/dashboard'">
        &#8592;
      </button>
      <div class="header-content">
        <img src="{{ asset('images/studify-logo.png') }}" alt="Studify Logo" class="logo" />
        <div class="genie-name">StudiGenie</div>
      </div>
    </div>
    <div class="chat-body">
      <div class="chat-message bot">Halo Studify! Bagaimana saya bisa membantu Anda?</div>
    </div>
    <div class="chat-footer">
      <textarea id="user_input" placeholder="Ketik pesan Anda..." rows="2"></textarea>
      <button onclick="sendInput()">Kirim</button>
    </div>
  </div>
</body>

</html>
