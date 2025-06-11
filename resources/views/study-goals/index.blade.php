<x-app-layout>
    @push('styles')
    <style>
        /* Background dan Layout */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

/* Container Utama */
.overview-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    position: relative;
}

/* Background Effects */
.overview-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

/* Header */
.overview-header {
    text-align: center;
    margin: 40px 0;
    position: relative;
    z-index: 10;
}

.overview-header h2 {
    font-size: 3.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #60a5fa, #a78bfa, #fb7185);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 15px;
    text-shadow: 0 0 30px rgba(168, 139, 250, 0.3);
    animation: glow 2s ease-in-out infinite alternate;
}

.overview-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 30px;
}

@keyframes glow {
    from { filter: drop-shadow(0 0 20px rgba(168, 139, 250, 0.3)); }
    to { filter: drop-shadow(0 0 30px rgba(168, 139, 250, 0.5)); }
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    width: 100%;
    max-width: 800px;
    margin-bottom: 40px;
    z-index: 10;
    position: relative;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s;
}

.stat-card:hover::before {
    left: 100%;
}

.stat-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 255, 255, 0.4);
}

.stat-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    animation: bounce 2s infinite;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    color: white;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

/* Legend */
.legend-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 40px;
    flex-wrap: wrap;
    z-index: 10;
    position: relative;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255, 255, 255, 0.1);
    padding: 15px 25px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.legend-item:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.legend-color {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.legend-text {
    font-size: 16px;
    font-weight: 600;
    color: white;
}

/* Chart Container */
.chart-container {
    max-width: 500px;
    width: 100%;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    margin-bottom: 40px;
    position: relative;
    z-index: 10;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 20px;
    margin-top: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.action-btn {
    padding: 15px 30px;
    border: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, #10b981, #06b6d4);
    color: white;
}

.btn-accent {
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    color: white;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

/* Tips Section */
.tips-section {
    width: 100%;
    max-width: 800px;
    margin-top: 50px;
    position: relative;
    z-index: 10;
}

.tips-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 30px;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.tip-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    transition: all 0.3s ease;
}

.tip-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-5px);
}

.tip-icon {
    font-size: 2rem;
    margin-bottom: 15px;
}

.tip-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    line-height: 1.6;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255, 255, 255, 0.7);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .overview-header h2 {
        font-size: 2.5rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        max-width: 300px;
    }
    
    .legend-container {
        flex-direction: column;
        align-items: center;
    }
    
    .chart-container {
        height: 300px;
        padding: 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
}
    </style>
    @endpush

    <div class="overview-container">
        <div class="overview-header">
            <h2><i class="fas fa-chart-pie"></i> Goal Overview</h2>
            <p class="overview-subtitle">Track your learning progress and achievements</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number">{{ $goalsCreated }}</div>
                <div class="stat-label">Goals Created</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number">{{ $goalsCompleted }}</div>
                <div class="stat-label">Goals Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-number">{{ $goalsInProgress }}</div>
                <div class="stat-label">Goals in Progress</div>
            </div>
        </div>

        <!-- Legend -->
        <div class="legend-container">
            <div class="legend-item">
                <span class="legend-color" style="background-color:rgb(153, 245, 255);"></span>
                <span class="legend-text">Goals Created</span>
            </div>
            <div class="legend-item">
                <span class="legend-color" style="background-color:rgb(152, 255, 138);"></span>
                <span class="legend-text">Goals Completed</span>
            </div>
            <div class="legend-item">
                <span class="legend-color" style="background-color:rgb(252, 203, 112);"></span>
                <span class="legend-text">Goals Progress</span>
            </div>
        </div>

        <!-- Chart -->
        @if($goalsCreated > 0)
            <div class="chart-container">
                <canvas id="goalPieChart"></canvas>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🎯</div>
                <h3>No goals yet!</h3>
                <p>Start your learning journey by creating your first goal</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('study-goals.create') }}" class="action-btn btn-primary">
                <i class="fas fa-plus"></i>
                Create New Goal
            </a>
            <a href="{{ route('study-goals.today') }}" class="action-btn btn-secondary">
                <i class="fas fa-calendar-day"></i>
                Today's Goals
            </a>
            <a href="{{ route('study-goals.upcoming') }}" class="action-btn btn-accent">
                <i class="fas fa-clock"></i>
                Upcoming Goals
            </a>
        </div>

        <!-- Tips Section -->
        <div class="tips-section">
            <h3 class="tips-title">💡 Goal Setting Tips</h3>
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">🎯</div>
                    <div class="tip-text">Set SMART goals: Specific, Measurable, Achievable, Relevant, and Time-bound.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">📅</div>
                    <div class="tip-text">Break large goals into smaller, manageable daily tasks for better progress.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">📊</div>
                    <div class="tip-text">Track your progress regularly to stay motivated and adjust if needed.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon">🎉</div>
                    <div class="tip-text">Celebrate small wins along the way to maintain momentum.</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if($goalsCreated > 0)
        const ctx = document.getElementById('goalPieChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Goals Created', 'Goals Completed', 'Goals Progress'],
                datasets: [{
                    label: 'Goal Distribution',
                    data: [
                        {{ $goalsCreated }},
                        {{ $goalsCompleted }},
                        {{ $goalsInProgress }}
                    ],
                    backgroundColor: [
                        'rgb(153, 245, 255)',
                        'rgb(152, 255, 138)',
                        'rgb(252, 203, 112)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 2,
                    hoverBorderWidth: 4,
                    hoverBorderColor: 'rgba(255, 255, 255, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw;
                                let total = context.chart._metasets[0].total;
                                let percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${percentage}% (${value})`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
        @endif
    </script>
    @endpush
</x-app-layout>