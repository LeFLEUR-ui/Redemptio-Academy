document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('grade-settings-modal');
    const openModalBtn = document.getElementById('open-settings-modal-btn');
    const saveSettingsBtn = document.getElementById('save-settings-btn');

    // Function to open the modal
    openModalBtn.onclick = () => {
        modal.classList.remove('hidden');
    };

    // Function to close the modal and save settings
    saveSettingsBtn.onclick = () => {
        // Read the values from the input fields
        const midtermQuizzes = parseInt(document.getElementById('midterm-quizzes').value, 10);
        const midtermActivities = parseInt(document.getElementById('midterm-activities').value, 10);
        const finalsQuizzes = parseInt(document.getElementById('finals-quizzes').value, 10);
        const finalsActivities = parseInt(document.getElementById('finals-activities').value, 10);

        // Basic validation (optional, but good practice)
        if (isNaN(midtermQuizzes) || isNaN(midtermActivities) || isNaN(finalsQuizzes) || isNaN(finalsActivities) || 
            midtermQuizzes < 0 || midtermActivities < 0 || finalsQuizzes < 0 || finalsActivities < 0) {
            console.error('Invalid input for grade settings. Must be non-negative numbers.');
            return;
        }

        console.log(`Midterm: ${midtermQuizzes} Quizzes, ${midtermActivities} Activities`);
        console.log(`Finals: ${finalsQuizzes} Quizzes, ${finalsActivities} Activities`);

        // *** CRITICAL CHANGE: Call a function in gradesheet.js to regenerate the table
        if (typeof regenerateGradesheetColumns === 'function') {
            regenerateGradesheetColumns({
                midtermQuizzes,
                midtermActivities,
                finalsQuizzes,
                finalsActivities
            });
        } else {
            console.error('regenerateGradesheetColumns function not found in gradesheet.js.');
        }

        modal.classList.add('hidden');
    };

    // Optional: Close modal if user clicks outside of it
    window.onclick = (event) => {
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    };
});