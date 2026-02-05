/**
 * CST Cannabis Portal — Course / Driver Education JavaScript
 *
 * Progress tracking (localStorage), quiz evaluation, certificate generation,
 * and module navigation state management.
 */

(function () {
    'use strict';

    var STORAGE_KEY = 'cst_course_progress';
    var PASSING_SCORE = 70;

    /* ------------------------------------------------------------------ */
    /*  Progress Storage                                                   */
    /* ------------------------------------------------------------------ */

    function getProgress() {
        try {
            var data = localStorage.getItem(STORAGE_KEY);
            return data ? JSON.parse(data) : { modules: {}, quizzes: {}, completedDate: null, certName: '' };
        } catch (e) {
            return { modules: {}, quizzes: {}, completedDate: null, certName: '' };
        }
    }

    function saveProgress(progress) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(progress));
        } catch (e) {
            // localStorage unavailable.
        }
    }

    function isModuleRead(moduleId) {
        var progress = getProgress();
        return !!progress.modules[moduleId];
    }

    function markModuleRead(moduleId) {
        var progress = getProgress();
        progress.modules[moduleId] = { readAt: new Date().toISOString() };
        saveProgress(progress);
    }

    function setQuizScore(moduleId, score, passed) {
        var progress = getProgress();
        progress.quizzes[moduleId] = { score: score, passed: passed, takenAt: new Date().toISOString() };
        saveProgress(progress);
    }

    function getQuizScore(moduleId) {
        var progress = getProgress();
        return progress.quizzes[moduleId] || null;
    }

    function getCompletionPercentage(moduleIds) {
        if (!moduleIds || !moduleIds.length) return 0;
        var progress = getProgress();
        var completed = 0;

        moduleIds.forEach(function (id) {
            var idStr = String(id);
            var moduleRead = progress.modules[idStr];
            var quizPassed = progress.quizzes[idStr] && progress.quizzes[idStr].passed;
            // If module has quiz, both read + quiz needed. If no quiz, just read.
            if (moduleRead) {
                // Check if this module has a quiz by looking at the DOM
                var quizSection = document.querySelector('.cst-quiz[data-module-id="' + idStr + '"]');
                if (quizSection) {
                    if (quizPassed) completed++;
                } else {
                    // No quiz on current page — check stored quiz data
                    if (progress.quizzes[idStr]) {
                        if (quizPassed) completed++;
                    } else {
                        completed++;
                    }
                }
            }
        });

        return Math.round((completed / moduleIds.length) * 100);
    }

    function isAllCompleted(moduleIds) {
        return getCompletionPercentage(moduleIds) === 100;
    }

    /* ------------------------------------------------------------------ */
    /*  Collect Module IDs from DOM                                        */
    /* ------------------------------------------------------------------ */

    function getModuleIdsFromDOM() {
        // From curriculum page module cards
        var cards = document.querySelectorAll('.cst-module-card[data-module-id]');
        if (cards.length) {
            return Array.prototype.map.call(cards, function (c) { return c.getAttribute('data-module-id'); });
        }
        // From lesson nav items
        var navItems = document.querySelectorAll('.cst-lesson-nav__item a[data-module-id]');
        if (navItems.length) {
            return Array.prototype.map.call(navItems, function (a) { return a.getAttribute('data-module-id'); });
        }
        // From certificate page
        if (window.cstCourseModules) {
            return window.cstCourseModules.map(String);
        }
        return [];
    }

    /* ------------------------------------------------------------------ */
    /*  Update Progress Bar UI                                             */
    /* ------------------------------------------------------------------ */

    function updateProgressUI() {
        var moduleIds = getModuleIdsFromDOM();
        var percentage = getCompletionPercentage(moduleIds);

        // Main progress bar (curriculum page)
        var progressFill = document.getElementById('cst-progress-fill');
        var progressText = document.getElementById('cst-progress-text');
        var progressStatus = document.getElementById('cst-progress-status');
        var progressBar = progressFill ? progressFill.closest('[role="progressbar"]') : null;

        if (progressFill) {
            progressFill.style.width = percentage + '%';
        }
        if (progressText) {
            progressText.textContent = percentage + '%';
        }
        if (progressBar) {
            progressBar.setAttribute('aria-valuenow', percentage);
        }
        if (progressStatus) {
            if (percentage === 100) {
                progressStatus.textContent = 'Ha completado todos los módulos. Puede obtener su certificado.';
            } else if (percentage > 0) {
                progressStatus.textContent = 'Ha completado el ' + percentage + '% del curso. Continue con el siguiente módulo.';
            }
        }

        // Certificate page progress
        var certFill = document.getElementById('cst-cert-progress-fill');
        var certText = document.getElementById('cst-cert-progress-text');
        if (certFill) {
            certFill.style.width = percentage + '%';
        }
        if (certText) {
            var completedCount = 0;
            var progress = getProgress();
            moduleIds.forEach(function (id) {
                if (progress.modules[String(id)]) completedCount++;
            });
            certText.textContent = 'Ha completado ' + completedCount + ' de ' + moduleIds.length + ' módulos (' + percentage + '%).';
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Update Module Status in Curriculum & Nav                           */
    /* ------------------------------------------------------------------ */

    function updateModuleStatuses() {
        var progress = getProgress();

        // Curriculum page module cards
        document.querySelectorAll('.cst-module-card[data-module-id]').forEach(function (card) {
            var id = card.getAttribute('data-module-id');
            var statusEl = document.getElementById('module-status-' + id);

            if (progress.modules[id]) {
                card.classList.add('is-completed');
                if (statusEl) {
                    statusEl.classList.add('is-completed');
                    var quizResult = progress.quizzes[id];
                    if (quizResult && quizResult.passed) {
                        statusEl.textContent = 'Completado (' + quizResult.score + '%)';
                    } else if (quizResult && !quizResult.passed) {
                        statusEl.textContent = 'Quiz pendiente';
                        statusEl.classList.remove('is-completed');
                        card.classList.remove('is-completed');
                    } else {
                        statusEl.textContent = 'Leído';
                    }
                }
            }
        });

        // Lesson sidebar navigation
        document.querySelectorAll('.cst-lesson-nav__item a[data-module-id]').forEach(function (a) {
            var id = a.getAttribute('data-module-id');
            var li = a.parentElement;
            var checkEl = document.getElementById('nav-check-' + id);

            if (progress.modules[id]) {
                li.classList.add('is-completed');
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Mark as Read Button                                                */
    /* ------------------------------------------------------------------ */

    function initMarkAsRead() {
        var btn = document.getElementById('cst-mark-read');
        if (!btn) return;

        var moduleId = btn.getAttribute('data-module-id');

        // Check if already read
        if (isModuleRead(moduleId)) {
            btn.textContent = 'Completado';
            btn.classList.add('is-completed');
            btn.disabled = true;
        }

        btn.addEventListener('click', function () {
            markModuleRead(moduleId);
            btn.textContent = 'Completado';
            btn.classList.add('is-completed');
            btn.disabled = true;
            updateProgressUI();
            updateModuleStatuses();

            // Scroll to quiz if exists
            var quizSection = document.getElementById('cst-quiz');
            if (quizSection) {
                var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                quizSection.scrollIntoView({
                    behavior: prefersReducedMotion ? 'auto' : 'smooth',
                    block: 'start'
                });
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Quiz Functionality                                                 */
    /* ------------------------------------------------------------------ */

    function initQuiz() {
        var quizSection = document.getElementById('cst-quiz');
        var submitBtn = document.getElementById('cst-quiz-submit');
        if (!quizSection || !submitBtn) return;

        var moduleId = quizSection.getAttribute('data-module-id');
        var questions = quizSection.querySelectorAll('.cst-quiz__question');
        var resultsDiv = document.getElementById('cst-quiz-results');
        var scoreValue = document.getElementById('cst-quiz-score');
        var resultText = document.getElementById('cst-quiz-result-text');
        var retryBtn = document.getElementById('cst-quiz-retry');
        var nextBtn = document.getElementById('cst-quiz-next');

        // Check if already passed
        var existingScore = getQuizScore(moduleId);
        if (existingScore && existingScore.passed) {
            showQuizResults(existingScore.score, true);
            disableQuiz();
        }

        // Option click — highlight selected
        quizSection.querySelectorAll('.cst-quiz__option').forEach(function (option) {
            option.addEventListener('click', function () {
                var fieldset = this.closest('.cst-quiz__question');
                fieldset.querySelectorAll('.cst-quiz__option').forEach(function (o) {
                    o.classList.remove('is-selected');
                });
                this.classList.add('is-selected');
            });
        });

        submitBtn.addEventListener('click', function () {
            var totalQuestions = questions.length;
            var correctCount = 0;
            var allAnswered = true;

            questions.forEach(function (fieldset) {
                var selectedRadio = fieldset.querySelector('input[type="radio"]:checked');
                var correctIndex = parseInt(fieldset.getAttribute('data-correct'), 10);
                var explanation = fieldset.querySelector('.cst-quiz__explanation');
                var options = fieldset.querySelectorAll('.cst-quiz__option');

                if (!selectedRadio) {
                    allAnswered = false;
                    fieldset.style.borderColor = '#ffc107';
                    return;
                }

                var selectedIndex = parseInt(selectedRadio.value, 10);

                // Reset styles
                options.forEach(function (o) {
                    o.classList.remove('is-correct-answer', 'is-wrong-answer');
                });

                if (selectedIndex === correctIndex) {
                    correctCount++;
                    fieldset.classList.add('is-correct');
                    fieldset.classList.remove('is-incorrect');
                    options[correctIndex].classList.add('is-correct-answer');
                } else {
                    fieldset.classList.add('is-incorrect');
                    fieldset.classList.remove('is-correct');
                    options[selectedIndex].classList.add('is-wrong-answer');
                    options[correctIndex].classList.add('is-correct-answer');
                }

                // Show explanation
                if (explanation) {
                    explanation.hidden = false;
                }

                // Disable radio buttons
                fieldset.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                    radio.disabled = true;
                });
            });

            if (!allAnswered) {
                announceMessage('Por favor, responda todas las preguntas antes de enviar.');
                return;
            }

            var score = Math.round((correctCount / totalQuestions) * 100);
            var passed = score >= PASSING_SCORE;

            // Save quiz result
            setQuizScore(moduleId, score, passed);

            showQuizResults(score, passed);
            submitBtn.hidden = true;

            updateProgressUI();
            updateModuleStatuses();
        });

        function showQuizResults(score, passed) {
            resultsDiv.hidden = false;
            scoreValue.textContent = score + '%';

            if (passed) {
                scoreValue.classList.add('is-passing');
                scoreValue.classList.remove('is-failing');
                resultText.textContent = 'Ha aprobado la evaluación. Puede continuar al siguiente módulo.';
                if (retryBtn) retryBtn.hidden = true;
                if (nextBtn) {
                    nextBtn.hidden = false;
                    // Set next module link
                    var nextLink = document.getElementById('cst-next-module-link');
                    var certLink = document.getElementById('cst-certificate-link');
                    if (nextLink) {
                        nextBtn.href = nextLink.href;
                    } else if (certLink) {
                        nextBtn.href = certLink.href;
                        nextBtn.textContent = 'Obtener certificado';
                    }
                }
            } else {
                scoreValue.classList.add('is-failing');
                scoreValue.classList.remove('is-passing');
                resultText.textContent = 'Necesita al menos 70% para aprobar. Revise el contenido e intente de nuevo.';
                if (retryBtn) retryBtn.hidden = false;
                if (nextBtn) nextBtn.hidden = true;
            }

            // Scroll to results
            var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            resultsDiv.scrollIntoView({
                behavior: prefersReducedMotion ? 'auto' : 'smooth',
                block: 'center'
            });
        }

        function disableQuiz() {
            questions.forEach(function (fieldset) {
                fieldset.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                    radio.disabled = true;
                });
            });
            submitBtn.hidden = true;
        }

        // Retry button
        if (retryBtn) {
            retryBtn.addEventListener('click', function () {
                questions.forEach(function (fieldset) {
                    fieldset.classList.remove('is-correct', 'is-incorrect');
                    fieldset.style.borderColor = '';
                    fieldset.querySelectorAll('.cst-quiz__option').forEach(function (o) {
                        o.classList.remove('is-selected', 'is-correct-answer', 'is-wrong-answer');
                    });
                    fieldset.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                        radio.disabled = false;
                        radio.checked = false;
                    });
                    var explanation = fieldset.querySelector('.cst-quiz__explanation');
                    if (explanation) explanation.hidden = true;
                });

                resultsDiv.hidden = true;
                submitBtn.hidden = false;

                // Scroll back to quiz
                var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                quizSection.scrollIntoView({
                    behavior: prefersReducedMotion ? 'auto' : 'smooth',
                    block: 'start'
                });
            });
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Certificate Page                                                   */
    /* ------------------------------------------------------------------ */

    function initCertificate() {
        var gate = document.getElementById('cst-cert-gate');
        var form = document.getElementById('cst-cert-form');
        var cert = document.getElementById('cst-certificate');
        var generateBtn = document.getElementById('cst-cert-generate');
        var nameInput = document.getElementById('cst-cert-name-input');

        if (!gate) return;

        var moduleIds = getModuleIdsFromDOM();
        var allComplete = isAllCompleted(moduleIds);

        if (allComplete) {
            gate.hidden = true;

            // Check if we already have a certificate name
            var progress = getProgress();
            if (progress.certName) {
                showCertificate(progress.certName);
            } else {
                form.hidden = false;
            }
        }

        if (generateBtn) {
            generateBtn.addEventListener('click', function () {
                var name = nameInput.value.trim();
                if (!name) {
                    nameInput.focus();
                    return;
                }

                // Save name
                var progress = getProgress();
                progress.certName = name;
                if (!progress.completedDate) {
                    progress.completedDate = new Date().toISOString();
                }
                saveProgress(progress);

                form.hidden = true;
                showCertificate(name);
            });
        }

        function showCertificate(name) {
            cert.hidden = false;
            var progress = getProgress();

            var nameEl = document.getElementById('cst-cert-name');
            var dateEl = document.getElementById('cst-cert-date');
            var idEl = document.getElementById('cst-cert-id');

            if (nameEl) nameEl.textContent = name;

            if (dateEl) {
                var date = progress.completedDate ? new Date(progress.completedDate) : new Date();
                dateEl.textContent = date.toLocaleDateString('es-PR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            if (idEl) {
                // Generate a deterministic certificate ID
                var certId = 'CST-EDV-' + generateCertId(name, progress.completedDate || new Date().toISOString());
                idEl.textContent = certId;
            }
        }

        function generateCertId(name, date) {
            var str = name + date;
            var hash = 0;
            for (var i = 0; i < str.length; i++) {
                var chr = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0;
            }
            return Math.abs(hash).toString(36).toUpperCase().substring(0, 8);
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Screen Reader Announcements                                        */
    /* ------------------------------------------------------------------ */

    function announceMessage(msg) {
        var live = document.createElement('div');
        live.setAttribute('role', 'alert');
        live.setAttribute('aria-live', 'assertive');
        live.className = 'sr-only';
        live.textContent = msg;
        document.body.appendChild(live);
        setTimeout(function () { live.remove(); }, 5000);
    }

    /* ------------------------------------------------------------------ */
    /*  Init                                                               */
    /* ------------------------------------------------------------------ */

    document.addEventListener('DOMContentLoaded', function () {
        updateProgressUI();
        updateModuleStatuses();
        initMarkAsRead();
        initQuiz();
        initCertificate();
    });

})();
