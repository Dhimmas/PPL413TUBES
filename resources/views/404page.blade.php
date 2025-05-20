<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a; /* Dark blue background */
            color: #f8fafc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: auto; /* Changed to auto to ensure scrolling works */
        }
        .container {
            text-align: center;
            max-width: 800px;
            width: 90%;
            padding: 30px;
            background-color: #1e293b; /* Darker blue for container */
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            position: relative;
            margin: 20px 0; /* Added margin to ensure it's not touching screen edges */
            overflow: visible; /* Ensure content is visible */
        }
        h1 {
            font-size: 6rem;
            margin: 0;
            color: #38bdf8;
            line-height: 1;
            text-shadow: 2px 2px 0 #0c4a6e;
        }
        h2 {
            font-size: 2.2rem;
            margin: 10px 0 20px;
            color: #e2e8f0;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .animation-container {
            margin: 10px auto 30px;
            width: 300px; /* Reduced width */
            height: 240px; /* Reduced height */
            position: relative;
        }
        .dashboard-btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: #38bdf8;
            color: #0f172a;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(56, 189, 248, 0.3);
            margin-bottom: 10px; /* Added margin to ensure button is visible */
        }
        .dashboard-btn:hover {
            background-color: #0ea5e9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(56, 189, 248, 0.4);
        }
        .map {
            animation: map-float 4s ease-in-out infinite;
        }
        .magnifier {
            transform-origin: 150px 120px;
            animation: magnifier-search 6s ease-in-out infinite;
        }
        .question-marks g {
            opacity: 0;
        }
        .question1 {
            animation: question-pop 6s ease-in-out infinite;
        }
        .question2 {
            animation: question-pop 6s 1s ease-in-out infinite;
        }
        .question3 {
            animation: question-pop 6s 2s ease-in-out infinite;
        }
        @keyframes map-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes magnifier-search {
            0%, 100% { transform: rotate(0deg) translate(0, 0); }
            25% { transform: rotate(-15deg) translate(-15px, 0); }
            75% { transform: rotate(15deg) translate(15px, 0); }
        }
        @keyframes question-pop {
            0%, 15%, 85%, 100% { opacity: 0; transform: translateY(0) scale(0.8); }
            30%, 70% { opacity: 1; transform: translateY(-15px) scale(1.2); }
        }
        .error-code {
            background: linear-gradient(45deg, #38bdf8, #0ea5e9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(45deg, rgba(56, 189, 248, 0.05) 0px, rgba(56, 189, 248, 0.05) 2px, transparent 2px, transparent 10px);
            pointer-events: none;
            z-index: -1;
            border-radius: 16px;
        }
        /* Stars in background */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -2;
        }
        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            animation: twinkle ease infinite;
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.8; }
        }
    </style>
</head>
<body>
    <!-- Stars Background -->
    <div class="stars" id="stars"></div>
    
    <div class="container">
        <div class="background-pattern"></div>
        <h1 class="error-code">404</h1>
        <h2>Page Not Found</h2>
        <p>Oops! The page you are looking for seems to have gone missing or doesn't exist.</p>
        
        <div class="animation-container">
            <svg viewBox="0 0 300 240" xmlns="http://www.w3.org/2000/svg">
                <!-- Map/World Background -->
                <g class="map">
                    <!-- World Map Outline (simplified) -->
                    <path d="M50,120 C60,95 90,105 105,90 C120,75 115,60 130,52 
                             C145,45 165,60 180,52 C195,45 210,65 225,58 
                             C240,51 248,72 240,87 C232,102 247,117 232,130 
                             C217,143 225,160 210,168 C195,176 175,160 160,168 
                             C145,176 140,160 125,168 C110,176 102,160 88,168 
                             C74,176 68,145 50,120 Z" 
                          fill="#334155" stroke="#64748b" stroke-width="2"/>
                    
                    <!-- Grid Lines -->
                    <path d="M40,60 L260,60 M40,100 L260,100 M40,140 L260,140 M40,180 L260,180" 
                          stroke="#475569" stroke-width="1" stroke-dasharray="5,5"/>
                    <path d="M80,40 L80,200 M120,40 L120,200 M160,40 L160,200 M200,40 L200,200 M240,40 L240,200" 
                          stroke="#475569" stroke-width="1" stroke-dasharray="5,5"/>
                    
                    <!-- Dots representing cities/locations -->
                    <circle cx="90" cy="85" r="3" fill="#94a3b8"/>
                    <circle cx="160" cy="70" r="3" fill="#94a3b8"/>
                    <circle cx="220" cy="75" r="3" fill="#94a3b8"/>
                    <circle cx="125" cy="130" r="3" fill="#94a3b8"/>
                    <circle cx="190" cy="145" r="3" fill="#94a3b8"/>
                    <circle cx="80" cy="160" r="3" fill="#94a3b8"/>
                    <circle cx="220" cy="155" r="3" fill="#94a3b8"/>
                    
                    <!-- Missing Location with X mark -->
                    <circle cx="150" cy="120" r="8" fill="#ef4444" opacity="0.7"/>
                    <path d="M142,112 L158,128 M158,112 L142,128" stroke="#f87171" stroke-width="2" stroke-linecap="round"/>
                </g>
                
                <!-- Magnifying Glass -->
                <g class="magnifier">
                    <!-- Handle -->
                    <rect x="180" y="145" width="12" height="55" rx="4" 
                          transform="rotate(45, 184, 150)" fill="#38bdf8"/>
                    
                    <!-- Glass Circle -->
                    <circle cx="150" cy="120" r="40" fill="none" stroke="#38bdf8" stroke-width="8"/>
                    <circle cx="150" cy="120" r="32" fill="#1e293b" fill-opacity="0.3"/>
                    
                    <!-- Reflection -->
                    <path d="M125,95 Q135,90 142,95" stroke="white" stroke-width="2" 
                          stroke-linecap="round" fill="none"/>
                </g>
                
                <!-- Question Marks Animation -->
                <g class="question-marks">
                    <g class="question1">
                        <text x="110" y="85" font-size="20" font-weight="bold" fill="#38bdf8">?</text>
                    </g>
                    <g class="question2">
                        <text x="190" y="105" font-size="20" font-weight="bold" fill="#38bdf8">?</text>
                    </g>
                    <g class="question3">
                        <text x="150" y="70" font-size="20" font-weight="bold" fill="#38bdf8">?</text>
                    </g>
                </g>
            </svg>
        </div>
        
        <p>Don't worry! Let's get you back on track to where you need to be.</p>
        <a href="/dashboard" class="dashboard-btn">Back to Dashboard</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create stars in background
            const starsContainer = document.getElementById('stars');
            const starsCount = 100;
            
            for (let i = 0; i < starsCount; i++) {
                const star = document.createElement('div');
                star.classList.add('star');
                
                // Random position
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                
                // Random size
                const size = Math.random() * 2;
                
                // Random animation duration
                const duration = 2 + Math.random() * 3;
                
                star.style.left = `${x}%`;
                star.style.top = `${y}%`;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                star.style.animationDuration = `${duration}s`;
                star.style.opacity = Math.random() * 0.7 + 0.1;
                
                starsContainer.appendChild(star);
            }
            
            // Additional animations for existing elements
            const questionMarks = document.querySelectorAll('.question-marks g');
            questionMarks.forEach(mark => {
                mark.style.opacity = '1';
            });
            
            // Fix for scroll issue - ensure button is in view
            const dashboardBtn = document.querySelector('.dashboard-btn');
            if (dashboardBtn) {
                // Scroll to make button visible if needed
                dashboardBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    </script>
</body>
</html>