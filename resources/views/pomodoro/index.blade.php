<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pomodoro Timer</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Hapus padding/margin top di body, biar tidak dobel dengan layout */
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #2c3e50;
                color: white;
                min-height: 100vh;
            }

            /* Tambahkan padding-top pada .container agar tidak tertutup navbar */
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 24px 20px 20px 20px; /* dari 40px jadi 24px */
                padding-top: 4rem; /* dari 6rem jadi 4rem */
                min-height: 80vh; /* agar tetap proporsional */
                display: flex;
                flex-direction: column;
                justify-content: center; /* tengah vertikal */
            }

            /* Header Section */
            .header {
                text-align: center;
                margin-bottom: 24px; /* dari 40px jadi 24px */
            }

            .header-icon {
                display: inline-block;
                background: linear-gradient(135deg, #3498db, #8e44ad);
                padding: 20px;
                border-radius: 50%;
                margin-bottom: 20px;
                box-shadow: 0 10px 30px rgba(52, 152, 219, 0.3);
            }

            .header-icon svg {
                width: 48px;
                height: 48px;
                stroke: white;
                stroke-width: 2;
                fill: none;
            }

            .main-title {
                font-size: 3rem;
                font-weight: 900;
                color: white;
                margin-bottom: 10px;
            }

            .subtitle {
                font-size: 1.1rem;
                color: rgba(255, 255, 255, 0.8);
                font-weight: 500;
            }

            /* Form Section */
            .form-section {
                background: rgba(255, 255, 255, 0.1);
                padding: 30px;
                border-radius: 20px;
                margin-bottom: 40px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                margin-bottom: 8px;
                color: rgba(255, 255, 255, 0.9);
            }

            .form-input {
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 12px;
                padding: 12px 16px;
                color: white;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .form-input:focus {
                outline: none;
                border-color: #3498db;
                box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.3);
                background: rgba(255, 255, 255, 0.15);
            }

            .form-input::placeholder {
                color: rgba(255, 255, 255, 0.5);
            }

            textarea.form-input {
                resize: none;
                height: 80px;
            }

            /* Timer Section */
            .timer-section {
                text-align: center;
                margin-bottom: 40px;
            }

            .timer-display {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 30px;
                padding: 40px;
                margin-bottom: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .timer-time {
                font-size: 5rem;
                font-family: 'Poppins', monospace;
                font-weight: 900;
                color: white;
                margin-bottom: 15px;
                letter-spacing: 2px;
            }

            .session-info {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin-bottom: 15px;
            }

            .session-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #7f8c8d;
                transition: all 0.3s ease;
            }

            .session-indicator.active {
                background: #3498db;
                animation: pulse 2s infinite;
            }

            .session-indicator.break {
                background: #27ae60;
            }

            .session-type {
                font-size: 1.5rem;
                font-weight: 700;
                color: #3498db;
            }

            .status-info {
                background: rgba(255, 255, 255, 0.05);
                padding: 12px 20px;
                border-radius: 12px;
                font-size: 14px;
                color: rgba(255, 255, 255, 0.8);
                min-height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Control Buttons */
            .controls {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
                margin-bottom: 40px;
            }

            .btn {
                padding: 12px 24px;
                border: none;
                border-radius: 15px;
                font-weight: 700;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                color: white;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            }

            .btn-start {
                background: linear-gradient(135deg, #27ae60, #2ecc71);
            }

            .btn-stop {
                background: linear-gradient(135deg, #f39c12, #e67e22);
            }

            .btn-complete {
                background: linear-gradient(135deg, #3498db, #2980b9);
            }

            .btn-reset {
                background: linear-gradient(135deg, #7f8c8d, #95a5a6);
            }

            /* Break Buttons */
            .break-section {
                margin-bottom: 40px;
            }

            .break-title {
                text-align: center;
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 20px;
                color: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .break-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .btn-break {
                background: rgba(155, 89, 182, 0.2);
                border: 1px solid rgba(155, 89, 182, 0.4);
                color: #bb8fce;
                padding: 8px 16px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .btn-break:hover {
                background: rgba(155, 89, 182, 0.4);
                transform: scale(1.05);
            }

            /* History Section */
            .history-section {
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                padding-top: 30px;
            }

            .history-title {
                font-size: 1.3rem;
                font-weight: 700;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 10px;
                color: rgba(255, 255, 255, 0.9);
            }

            .history-list {
                max-height: 300px;
                overflow-y: auto;
            }

            .history-item {
                background: rgba(255, 255, 255, 0.05);
                padding: 20px;
                border-radius: 15px;
                margin-bottom: 15px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }

            .history-item:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            .history-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 15px;
            }

            .history-info {
                display: flex;
                align-items: center;
                gap: 15px;
                flex: 1;
            }

            .history-icon {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: bold;
            }

            .history-icon.work {
                background: linear-gradient(135deg, #3498db, #8e44ad);
            }

            .history-icon.break {
                background: linear-gradient(135deg, #27ae60, #2ecc71);
            }

            .history-details h4 {
                font-weight: 700;
                font-size: 14px;
                margin-bottom: 5px;
            }

            .history-details p {
                font-size: 12px;
                color: rgba(255, 255, 255, 0.6);
            }

            .history-meta {
                text-align: right;
                font-size: 12px;
                color: rgba(255, 255, 255, 0.7);
            }

            .history-duration {
                background: rgba(255, 255, 255, 0.1);
                padding: 4px 8px;
                border-radius: 8px;
                margin-bottom: 5px;
            }

            .empty-history {
                text-align: center;
                padding: 40px;
                color: rgba(255, 255, 255, 0.5);
                background: rgba(255, 255, 255, 0.05);
                border-radius: 15px;
            }

            /* Custom Scrollbar */
            .history-list::-webkit-scrollbar {
                width: 6px;
            }

            .history-list::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            .history-list::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #3498db, #8e44ad);
                border-radius: 10px;
            }

            /* Animations */
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .main-title {
                    font-size: 2.5rem;
                }

                .timer-time {
                    font-size: 4rem;
                }

                .controls {
                    flex-direction: column;
                    align-items: center;
                }

                .btn {
                    width: 200px;
                    justify-content: center;
                }

                .history-content {
                    flex-direction: column;
                    gap: 10px;
                }

                .history-meta {
                    text-align: left;
                }
            }

            @media (max-width: 480px) {
                .container {
                    padding: 20px 10px;
                }

                .main-title {
                    font-size: 2rem;
                }

                .timer-time {
                    font-size: 3rem;
                }
            }
        </style>
    </head>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"></path>
                    <circle cx="12" cy="12" r="1.5" fill="currentColor"></circle>
                </svg>
            </div>
            <h1 class="main-title">Pomodoro Timer</h1>
            <p class="subtitle">🍅 Fokus dan tingkatkan produktivitas Anda</p>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="form-group">
                <label class="form-label">
                    <span>📝</span>
                    Nama Aktivitas
                </label>
                <input type="text" id="activityName" class="form-input" placeholder="Contoh: Belajar Laravel">
            </div>
            <div class="form-group">
                <label class="form-label">
                    <span>📋</span>
                    Deskripsi
                </label>
                <textarea id="activityDesc" class="form-input" placeholder="Contoh: Mengerjakan modul otentikasi"></textarea>
            </div>
        </div>

        <!-- Timer Section -->
        <div class="timer-section">
            <div class="timer-display">
                <div id="timer" class="timer-time">25:00</div>
                <div class="session-info">
                    <div id="sessionIndicator" class="session-indicator"></div>
                    <div id="sessionType" class="session-type">Sesi Kerja</div>
                </div>
                <div id="statusInfo" class="status-info"></div>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="controls">
            <button id="startButton" class="btn btn-start">
                <span>▶️</span>
                Mulai
            </button>
            <button id="stopButton" class="btn btn-stop">
                <span>⏸️</span>
                Stop
            </button>
            <button id="completeButton" class="btn btn-complete">
                <span>✅</span>
                Selesai
            </button>
            <button id="resetButton" class="btn btn-reset">
                <span>🔄</span>
                Reset
            </button>
        </div>

        <!-- Break Buttons -->
        <div class="break-section">
            <div class="break-title">
                <span>☕</span>
                Quick Break Options
            </div>
            <div class="break-buttons">
                <button class="btn-break breakButton" data-break="2">2m Break</button>
                <button class="btn-break breakButton" data-break="5">5m</button>
                <button class="btn-break breakButton" data-break="10">10m</button>
                <button class="btn-break breakButton" data-break="30">30m</button>
            </div>
        </div>

        <!-- History Section -->
        <div class="history-section">
            <div class="history-title">
                <span>📊</span>
                Riwayat Pomodoro
            </div>
            <div class="history-list" id="historyList">
                <div class="empty-history">
                    <span style="font-size: 2rem; display: block; margin-bottom: 10px;">🌱</span>
                    Belum ada sesi yang direkam. Mulai sekarang!
                </div>
            </div>
        </div>
    </div>

    <script>
        let timer;
        let totalSeconds = 25 * 60;
        let isRunning = false;
        let sessionType = 'work';
        let startTime;
        let sessions = [];

        function updateDisplay() {
            const minutes = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            const seconds = String(totalSeconds % 60).padStart(2, '0');
            document.getElementById('timer').textContent = `${minutes}:${seconds}`;
            
            // Update session indicator
            const indicator = document.getElementById('sessionIndicator');
            if (isRunning) {
                indicator.className = sessionType === 'work' ? 
                    'session-indicator active' : 
                    'session-indicator active break';
            } else {
                indicator.className = 'session-indicator';
            }
        }

        function updateStatus(status) {
            const statusEl = document.getElementById('statusInfo');
            statusEl.textContent = status;
        }

        function startTimer(duration, type) {
            if (isRunning) return;
            totalSeconds = duration * 60;
            sessionType = type;
            isRunning = true;
            startTime = new Date();
            
            const sessionTypeEl = document.getElementById('sessionType');
            sessionTypeEl.textContent = type === 'work' ? 'Sesi Kerja' : `Break ${duration} Menit`;

            const activityName = document.getElementById('activityName').value || 'Tanpa Judul';
            updateStatus(`${type === 'work' ? '🎯 Mengerjakan' : '☕ Beristirahat'}: ${activityName}`);

            timer = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timer);
                    isRunning = false;
                    saveSession(duration, type);
                    
                    // Notification
                    if (Notification.permission === 'granted') {
                        new Notification('Pomodoro Timer', {
                            body: `${type === 'work' ? 'Sesi kerja' : 'Break'} selesai!`,
                            icon: '🍅'
                        });
                    }
                    
                    alert(`${type === 'work' ? '🎯 Sesi kerja' : '☕ Break'} selesai!`);
                    updateStatus('✅ Sesi telah selesai.');
                    return;
                }
                totalSeconds--;
                updateDisplay();
            }, 1000);
        }

        function saveSession(minutes, type) {
            const endTime = new Date();
            const session = {
                activity_name: document.getElementById('activityName').value || 'Tanpa Judul',
                description: document.getElementById('activityDesc').value,
                started_at: startTime,
                ended_at: endTime,
                duration_minutes: minutes,
                type: type
            };
            
            sessions.unshift(session);
            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            const historyList = document.getElementById('historyList');
            
            if (sessions.length === 0) {
                historyList.innerHTML = `
                    <div class="empty-history">
                        <span style="font-size: 2rem; display: block; margin-bottom: 10px;">🌱</span>
                        Belum ada sesi yang direkam. Mulai sekarang!
                    </div>
                `;
                return;
            }

            historyList.innerHTML = sessions.map(session => `
                <div class="history-item">
                    <div class="history-content">
                        <div class="history-info">
                            <div class="history-icon ${session.type}">
                                ${session.type === 'work' ? '🎯' : '☕'}
                            </div>
                            <div class="history-details">
                                <h4>${session.type === 'work' ? 'Work' : 'Break'}: ${session.activity_name}</h4>
                                ${session.description ? `<p>${session.description}</p>` : ''}
                            </div>
                        </div>
                        <div class="history-meta">
                            <div class="history-duration">${session.duration_minutes}m</div>
                            <div>${session.started_at.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Event listeners
        document.getElementById('startButton').addEventListener('click', () => startTimer(25, 'work'));
        
        document.getElementById('resetButton').addEventListener('click', () => {
            clearInterval(timer);
            totalSeconds = 25 * 60;
            isRunning = false;
            sessionType = 'work';
            document.getElementById('sessionType').textContent = 'Sesi Kerja';
            updateDisplay();
            updateStatus('');
        });
        
        document.getElementById('stopButton').addEventListener('click', () => {
            clearInterval(timer);
            isRunning = false;
            updateDisplay();
            updateStatus('⏸️ Sesi dihentikan.');
        });
        
        document.getElementById('completeButton').addEventListener('click', () => {
            if (!isRunning) return;
            clearInterval(timer);
            isRunning = false;
            const durationPassed = Math.round((new Date().getTime() - startTime.getTime()) / (1000 * 60));
            saveSession(durationPassed, sessionType);
            updateStatus('✅ Aktivitas diselesaikan lebih awal.');
            updateDisplay();
        });
        
        document.querySelectorAll('.breakButton').forEach(btn => {
            btn.addEventListener('click', () => {
                const mins = parseInt(btn.getAttribute('data-break'));
                startTimer(mins, 'break');
            });
        });

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        // Initialize display
        updateDisplay();
        updateHistoryDisplay();
    </script>
</x-app-layout>