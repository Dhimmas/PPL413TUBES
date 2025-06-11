// Debug: Log untuk memastikan script dimuat
console.log("Quiz script loaded");

const quizAppElement = document.getElementById('question-display');
if (!quizAppElement) {
    console.error("Elemen #question-display tidak ditemukan.");
    throw new Error("Missing #question-display element");
}

const quizId = parseInt(quizAppElement.dataset.quizId || '0');
const resultId = parseInt(quizAppElement.dataset.resultId || '0');
const timeRemainingFromServer = quizAppElement.dataset.timeRemaining === 'null' ? null : parseInt(quizAppElement.dataset.timeRemaining, 10);
const totalQuestions = parseInt(quizAppElement.dataset.totalQuestions || '0');

console.log("Quiz Config:", { quizId, resultId, timeRemainingFromServer, totalQuestions });

let initialQuestion = null;
try {
    const initialQuestionJson = quizAppElement.dataset.initialQuestion;
    if (initialQuestionJson) {
        initialQuestion = JSON.parse(initialQuestionJson);
        console.log("Initial question loaded:", initialQuestion);
    }
} catch (e) {
    console.error("Error parsing initialQuestion:", e);
}

let userAnswers = {};
try {
    const userAnswersJson = quizAppElement.dataset.currentAnswers;
    if (userAnswersJson) {
        userAnswers = JSON.parse(userAnswersJson);
        console.log("User answers loaded:", userAnswers);
    }
} catch (e) {
    console.error("Error parsing userAnswers:", e);
}

// --- 2. State JavaScript untuk Quiz ---
let currentQuestionData = null; 
let quizTimerInterval; 
let timeRemaining = timeRemainingFromServer;
let questionsCache = [];
let answeredQuestions = new Set();

// --- QUESTION NAVIGATION FUNCTIONS ---

function createQuestionNavigation() {
    // Navigation sudah ada di HTML, jadi kita hanya perlu populate question grid
    const questionGrid = document.getElementById('questionGrid');
    if (questionGrid) {
        questionGrid.innerHTML = generateQuestionCards();
        console.log("Question grid populated");
    }
    
    // Initialize progress
    updateNavigationProgress();
    
    // Setup event listeners
    setupNavigationListeners();
}

function generateQuestionCards() {
    let cardsHTML = '';
    for (let i = 1; i <= totalQuestions; i++) {
        cardsHTML += `
            <div class="question-card" 
                 onclick="goToQuestionCard(${i})"
                 id="nav-card-${i}"
                 data-question="${i}"
                 title="Question ${i}">
                <span class="card-number">${i}</span>
            </div>
        `;
    }
    return cardsHTML;
}

function updateQuestionCardState(questionNumber, state) {
    const card = document.getElementById(`nav-card-${questionNumber}`);
    if (!card) return;

    // Remove all state classes
    card.classList.remove('current', 'answered', 'unanswered');
    
    // Add new state class
    if (state) {
        card.classList.add(state);
    }
}

function updateNavigationProgress() {
    const answered = answeredQuestions.size;
    const percentage = (answered / totalQuestions) * 100;
    
    const progressCount = document.getElementById('progressCount');
    const progressFill = document.getElementById('progressFill');
    
    if (progressCount) progressCount.textContent = `${answered}/${totalQuestions}`;
    if (progressFill) progressFill.style.width = `${percentage}%`;
}

function markQuestionAnswered(questionNumber) {
    answeredQuestions.add(questionNumber);
    updateQuestionCardState(questionNumber, 'answered');
    updateNavigationProgress();
}

function markQuestionUnanswered(questionNumber) {
    answeredQuestions.delete(questionNumber);
    updateQuestionCardState(questionNumber, 'unanswered');
    updateNavigationProgress();
}

function setCurrentQuestion(questionNumber) {
    // Remove current state from all cards
    document.querySelectorAll('.question-card').forEach(card => {
        card.classList.remove('current');
    });
    
    // Add current state to target card
    updateQuestionCardState(questionNumber, 'current');
}

// Global functions for onclick handlers
window.toggleQuestionNav = function() {
    // Only work on mobile/tablet
    if (window.innerWidth >= 1024) return;
    
    const navCard = document.getElementById('questionNavigationCard');
    const overlay = document.getElementById('navOverlay');
    
    if (navCard && overlay) {
        navCard.classList.toggle('show');
        overlay.classList.toggle('show');
        document.body.classList.toggle('nav-open');
    }
}

window.goToQuestionCard = async function(questionNumber) {
    console.log(`Navigation card ${questionNumber} clicked`);
    
    // Hide navigation on mobile after selection
    if (window.innerWidth < 1024) {
        toggleQuestionNav();
    }
    
    // Disable navigation during transition
    disableAllNavButtons();
    
    try {
        // Save current answer
        await saveCurrentAnswer();
        
        // Navigate to question
        await navigateToQuestion(questionNumber);
        
    } catch (error) {
        console.error("Error during card navigation:", error);
        alert("Terjadi kesalahan saat berpindah soal");
    } finally {
        // Re-enable navigation
        enableAllNavButtons();
    }
}

// Setup navigation event listeners
function setupNavigationListeners() {
    // Close navigation on escape key (only on mobile/tablet)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && window.innerWidth < 1024) {
            const navCard = document.getElementById('questionNavigationCard');
            if (navCard && navCard.classList.contains('show')) {
                toggleQuestionNav();
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            // Desktop: Remove mobile classes and ensure navigation is visible
            const navCard = document.getElementById('questionNavigationCard');
            const overlay = document.getElementById('navOverlay');
            if (navCard) {
                navCard.classList.remove('show');
            }
            if (overlay) overlay.classList.remove('show');
            document.body.classList.remove('nav-open');
        }
    });
}

// --- 3. FUNGSI UTILITY ---

function updateQuizTimerDisplay() {
    if (timeRemaining === null) return; 
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    const timerEl = document.getElementById('quiz-timer');
    if (timerEl) {
        timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}

function startQuizTimer() {
    if (timeRemaining === null || timeRemaining <= 0) {
        updateQuizTimerDisplay(); 
        return; 
    }
    updateQuizTimerDisplay();
    quizTimerInterval = setInterval(() => {
        timeRemaining--;
        updateQuizTimerDisplay();
        if (timeRemaining <= 0) {
            clearInterval(quizTimerInterval);
            alert('Waktu quiz habis! Quiz akan diselesaikan.');
            window.location.href = `/quiz/${quizId}/result`; 
        }
    }, 1000);
}

function renderAnswerInput(question) {
    let html = '';
    const options = Array.isArray(question.options) ? question.options : []; 
    if (question.question_type === 'multiple_choice' && options.length > 0) { 
        options.forEach((option, i) => {
            const radioId = `q${question.id}-option${i}`;
            html += `
                <label for="${radioId}" class="block mb-2 cursor-pointer p-3 rounded-md border border-gray-700 hover:bg-gray-700 transition duration-200 ease-in-out">
                    <input type="radio" id="${radioId}" name="user_answer" value="${option}" class="mr-3 transform scale-125 accent-blue-500">
                    ${option}
                </label>
            `;
        });
    } else { 
        html += `<textarea name="user_answer" class="w-full mt-2 p-3 border border-gray-700 rounded-md bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" rows="6" placeholder="Tulis jawaban Anda di sini..."></textarea>`;
    }
    return html;
}

function getCurrentAnswer() {
    const answerInputArea = document.getElementById('answer-input-area');
    if (!answerInputArea) return null; 
    const questionType = currentQuestionData.question_type;
    let answer = null;
    if (questionType === 'multiple_choice') {
        const checkedRadio = answerInputArea.querySelector('input[name="user_answer"]:checked');
        if (checkedRadio) answer = checkedRadio.value;
    } else { 
        const textarea = answerInputArea.querySelector('textarea[name="user_answer"]');
        if (textarea) answer = textarea.value;
    }
    return answer;
}

function updateNavigationButtons() {
    if (!currentQuestionData) return;
    const currentQNum = currentQuestionData.question_number;
    const prevBtn = document.getElementById('prev-question-btn');
    const nextBtn = document.getElementById('next-question-btn');
    if (!prevBtn || !nextBtn) return;

    prevBtn.classList.toggle('hidden', currentQNum === 1);
    
    if (currentQNum === totalQuestions) {
        nextBtn.innerHTML = 'Selesai <i class="fas fa-check ml-2"></i>';
        nextBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        nextBtn.classList.add('bg-green-600', 'hover:bg-green-700');
    } else {
        nextBtn.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right ml-2"></i>';
        nextBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        nextBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
    }
}

// Remove circular pagination - replace with empty function
function renderQuestionPagination() {
    // Hide circular pagination completely
    const paginationContainer = document.getElementById('question-pagination');
    if (paginationContainer) {
        paginationContainer.style.display = 'none';
    }
    console.log("Circular pagination hidden - using navigation card instead");
}

// Remove circular pagination event listeners
function attachPaginationEventListeners() {
    // No longer needed - navigation card handles this
    console.log("Circular pagination listeners skipped - using navigation card");
}

/**
 * @returns {Promise<boolean>} 
 */
async function saveCurrentAnswer() {
    if (!currentQuestionData) return false;
    
    let answer = getCurrentAnswer();
    if (answer !== null && answer.trim() === '') {
        answer = null;
    }

    console.log("Saving answer for question", currentQuestionData.id, ":", answer);

    // Update state lokal langsung
    userAnswers[currentQuestionData.id] = answer;

    // Mark as answered if not empty
    if (answer !== null && answer.trim() !== '') {
        markQuestionAnswered(currentQuestionData.question_number);
    } else {
        markQuestionUnanswered(currentQuestionData.question_number);
    }

    try {
        const response = await fetch(`/quiz/${quizId}/submit-answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                question_id: currentQuestionData.id,
                user_answer: answer,
                result_id: resultId
            })
        });
        
        const success = response.ok;
        console.log("Answer save result:", success);
        return success;
    } catch (error) {
        console.error("Gagal menyimpan jawaban:", error);
        return false;
    }
}

function disableAllNavButtons() {
    const buttons = document.querySelectorAll('#prev-question-btn, #next-question-btn, .question-card');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.style.pointerEvents = 'none';
    });
    console.log("Disabled", buttons.length, "navigation buttons");
}

function enableAllNavButtons() {
    const buttons = document.querySelectorAll('#prev-question-btn, #next-question-btn, .question-card');
    buttons.forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        btn.style.pointerEvents = 'auto';
    });
    console.log("Enabled", buttons.length, "navigation buttons");
}

async function displayQuestion(question) {
    console.log("Displaying question:", question.question_number);
    
    if (!question || !question.id) {
        const displayArea = document.getElementById('current-question-content');
        if (displayArea) displayArea.innerHTML = `<p class="text-center text-red-500 text-lg mt-8">Gagal memuat soal. Data pertanyaan tidak valid.</p>`;
        return;
    }
    
    currentQuestionData = question;
    const displayArea = document.getElementById('current-question-content');
    if (!displayArea) return;
    
    displayArea.innerHTML = `<p class="text-center text-lg mt-8 text-gray-400">Memuat soal...</p>`;
    await new Promise(resolve => setTimeout(resolve, 100)); 

    const questionHtml = `
        <p class="font-semibold mb-4 text-xl text-blue-300">
            <span class="text-gray-400 mr-2">${question.question_number}.</span> ${question.question_text || ''}
        </p>
        ${question.image ? `<img src="/storage/${question.image}" alt="Question Image" class="mb-4 w-full max-w-lg mx-auto rounded-lg shadow-md">` : ''}
        ${question.question_file ? `
            <a href="/storage/${question.question_file}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg my-4 transition duration-300 ease-in-out">
                <i class="fas fa-download mr-2"></i> Lihat/Unduh File Soal
            </a>
        ` : ''}
        <div class="mt-4" id="answer-input-area">${renderAnswerInput(question)}</div>
    `;
    displayArea.innerHTML = questionHtml;

    const questionNumberEl = document.getElementById('question-number');
    const totalQuestionsEl = document.getElementById('total-questions');
    if (questionNumberEl) questionNumberEl.textContent = question.question_number;
    if (totalQuestionsEl) totalQuestionsEl.textContent = totalQuestions;

    // Pre-fill answer if exists
    if (userAnswers[question.id]) {
        const answer = userAnswers[question.id];
        console.log("Pre-filling answer:", answer);
        if (question.question_type === 'multiple_choice') {
            const radioToSelect = displayArea.querySelector(`input[type="radio"][value="${answer}"]`);
            if(radioToSelect) radioToSelect.checked = true;
        } else {
            const textarea = displayArea.querySelector(`textarea[name="user_answer"]`);
            if(textarea) textarea.value = answer;
        }
    }
    
    // Update navigation states
    setCurrentQuestion(question.question_number);
    updateNavigationButtons();
    
    console.log("Question displayed successfully:", question.question_number);
}

async function navigateToQuestion(targetQNumber) {
    console.log(`Navigating to question ${targetQNumber}`);
    
    // Validasi input
    if (!targetQNumber || targetQNumber < 1 || targetQNumber > totalQuestions) {
        console.error("Invalid question number:", targetQNumber);
        return;
    }
    
    // 1. Cek apakah soal ada di cache
    let targetQuestion = questionsCache.find(q => q.question_number === targetQNumber);

    if (targetQuestion) {
        console.log(`Question ${targetQNumber} found in cache`);
    } else {
        // 2. Jika tidak ada, minta ke server
        console.log(`Question ${targetQNumber} not in cache, fetching from server...`);
        
        const displayArea = document.getElementById('current-question-content');
        if (displayArea) {
            displayArea.innerHTML = `<p class="text-center text-lg mt-8 text-gray-400">Memuat soal no. ${targetQNumber}...</p>`;
        }
        
        try {
            const response = await fetch(`/quiz/${quizId}/get-question/${targetQNumber}`);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const newQuestion = await response.json();
            console.log("Received question from server:", newQuestion);
            
            // Validasi data yang diterima
            if (!newQuestion || !newQuestion.id) {
                throw new Error("Invalid question data received from server");
            }
            
            questionsCache.push(newQuestion);
            questionsCache.sort((a, b) => a.question_number - b.question_number);
            targetQuestion = newQuestion;
            
            console.log("Question added to cache, cache size:", questionsCache.length);
            
        } catch (error) {
            console.error("Failed to fetch question:", error);
            alert(`Tidak bisa memuat soal no. ${targetQNumber}. Error: ${error.message}`);
            return;
        }
    }

    // 3. Tampilkan soal yang dituju
    if (targetQuestion) {
        await displayQuestion(targetQuestion);
        console.log(`Successfully navigated to question ${targetQNumber}`);
    } else {
        console.error("Target question is null after processing");
    }
}

async function handleNextQuestion() {
    if (!currentQuestionData) return;
    
    const currentQNum = currentQuestionData.question_number;
    console.log("Next button clicked, current question:", currentQNum);
    
    if (currentQNum === totalQuestions) {
        // Jika ini soal terakhir, selesaikan kuis di server
        console.log("Finishing quiz...");
        try {
            const response = await fetch(`/quiz/result/${resultId}/finalize`, { 
                method: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            });
            const data = await response.json();
            if (response.ok) {
                alert('Quiz Selesai!');
                window.location.href = data.redirect_url;
            } else {
                alert('Gagal menyelesaikan kuis.');
            }
        } catch (e) {
            console.error("Error finalizing quiz:", e);
            alert('Terjadi error saat menyelesaikan kuis.');
        }
    } else {
        // Pindah ke soal berikutnya
        await navigateToQuestion(currentQNum + 1);
    }
}

async function handlePrevQuestion() {
    if (!currentQuestionData) return;
    
    const currentQNum = currentQuestionData.question_number;
    console.log("Previous button clicked, current question:", currentQNum);
    
    if (currentQNum > 1) {
        await navigateToQuestion(currentQNum - 1);
    }
}

// --- 4. EVENT LISTENERS ---
document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM loaded, initializing quiz...");
    
    // Initialize questions cache
    try {
        const questionsCacheJson = quizAppElement.dataset.questionCache;
        if (questionsCacheJson) {
            const parsedCache = JSON.parse(questionsCacheJson);
            if (Array.isArray(parsedCache)) {
                questionsCache = parsedCache;
                questionsCache.sort((a, b) => a.question_number - b.question_number);
                console.log("Questions cache loaded:", questionsCache.length, "questions");
            }
        }
    } catch (e) {
        console.error("Error parsing questionsCache from data attribute:", e);
    }
    
    // Create question navigation (hanya populate grid, HTML sudah ada)
    createQuestionNavigation();
    
    // Initialize answered questions from cache
    questionsCache.forEach(question => {
        if (userAnswers[question.id] && userAnswers[question.id].trim() !== '') {
            answeredQuestions.add(question.question_number);
        }
    });
    
    // Validate initial question
    if (!initialQuestion || !initialQuestion.id) {
        console.error("Invalid initial question:", initialQuestion);
        const contentEl = document.getElementById('current-question-content');
        if (contentEl) contentEl.innerHTML = `<p class="text-center text-red-500 text-lg mt-8">Gagal memuat soal awal. Mohon coba lagi.</p>`;
        return;
    }

    // Display initial question
    displayQuestion(initialQuestion);
    console.log("Initial question displayed");

    // Initialize timer
    if (timeRemaining !== null && timeRemaining > 0) {
        startQuizTimer();
    } else {
        updateQuizTimerDisplay();
        const timerEl = document.getElementById('quiz-timer');
        if (timeRemaining === null && timerEl) {
            timerEl.textContent = "Tidak Terbatas";
        }
    }

    // Attach navigation button event listeners
    const nextBtn = document.getElementById('next-question-btn');
    const prevBtn = document.getElementById('prev-question-btn');

    if (nextBtn) {
        nextBtn.addEventListener('click', async (event) => {
            event.preventDefault();
            console.log("Next button clicked");
            disableAllNavButtons();
            await saveCurrentAnswer();
            await handleNextQuestion();
            enableAllNavButtons();
        });
        console.log("Next button listener attached");
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', async (event) => {
            event.preventDefault();
            console.log("Previous button clicked");
            disableAllNavButtons();
            await saveCurrentAnswer();
            await handlePrevQuestion();
            enableAllNavButtons();
        });
        console.log("Previous button listener attached");
    }
    
    console.log("Quiz initialization complete");
});