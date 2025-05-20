<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction - Construction Site</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        
        .construction-container {
            text-align: center;
            position: relative;
            z-index: 10;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
            max-width: 600px;
            backdrop-filter: blur(5px);
            border: 2px solid #ffcc00;
        }
        
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ffcc00, #ff9900, #ff6600);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient 5s ease infinite;
            background-size: 300% 300%;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
        }
        
        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
            color: #ddd;
        }
        
        .progress-container {
            width: 100%;
            height: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            margin: 2rem 0;
            overflow: hidden;
            border: 1px solid #ffcc00;
        }
        
        .progress-bar {
            height: 100%;
            width: 65%;
            background: linear-gradient(90deg, #ffcc00, #ff9900, #ff6600);
            border-radius: 10px;
            animation: progress 2s ease-in-out infinite alternate, 
                       colorShift 4s ease infinite;
            background-size: 200% 100%;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.5);
        }
        
        .construction-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: bounce 2s ease infinite;
            filter: drop-shadow(0 0 5px rgba(255, 204, 0, 0.7));
        }
        
        /* CRANE ANIMATION */
        .crane {
            position: absolute;
            bottom: -50px;
            right: -50px;
            font-size: 8rem;
            transform: rotate(-30deg);
            opacity: 0.7;
            animation: craneMove 8s ease-in-out infinite;
            z-index: -1;
        }
        
        /* WORKER ANIMATION */
        .worker {
            position: absolute;
            bottom: 20px;
            left: 10%;
            font-size: 3rem;
            animation: workerHammer 1.5s ease infinite;
        }
        
        /* CONSTRUCTION BARRIER */
        .barrier {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: repeating-linear-gradient(
                45deg,
                #ffcc00,
                #ffcc00 20px,
                #000 20px,
                #000 40px
            );
            animation: barrierBlink 1s steps(2) infinite;
        }
        
        /* ANIMATIONS */
        @keyframes gradient {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        
        @keyframes progress {
            0% {width: 65%;}
            100% {width: 70%;}
        }
        
        @keyframes colorShift {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        
        @keyframes bounce {
            0%, 100% {transform: translateY(0);}
            50% {transform: translateY(-15px);}
        }
        
        @keyframes craneMove {
            0%, 100% {transform: rotate(-30deg) translateY(0);}
            50% {transform: rotate(-25deg) translateY(-20px);}
        }
        
        @keyframes workerHammer {
            0%, 100% {transform: rotate(0deg);}
            50% {transform: rotate(-30deg);}
        }
        
        @keyframes barrierBlink {
            0% {opacity: 0.8;}
            100% {opacity: 1;}
        }
    </style>
</head>
<body>
    <div class="crane">🏗️</div>
    <div class="worker">👷🔨</div>
    <div class="barrier"></div>
    
    <div class="construction-container">
        <div class="construction-icon">🚧</div>
        <h1>This Page Is Under Construction</h1>
        <p>We're building something awesome! Our team is working hard to finish the project.</p>
        
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
        
        <p>Estimated completion: <span id="countdown">15</span> days</p>
    </div>

    <!-- <script>
        // Dynamic countdown
        let days = 15;
        const countdownElement = document.getElementById('countdown');
        
        setInterval(() => {
            if (Math.random() > 0.7 && days > 1) {
                days--;
                countdownElement.textContent = days;
                countdownElement.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    countdownElement.style.transform = 'scale(1)';
                }, 300);
            }
        }, 5000);
    </script> -->
</body>
</html>