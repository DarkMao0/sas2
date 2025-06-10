document.addEventListener('DOMContentLoaded', () => {
    const roleSelects = document.querySelectorAll('.book_input');
    const errorContainer = document.querySelector('#error-container');

    roleSelects.forEach(select => {
        select.addEventListener('change', async () => {
            const bookId = select.dataset.bookId;
            const newState = select.value;

            function callErrorContainer(container, message = '') {
                if (container) {
                    if (message) {
                        container.textContent = message;
                        container.style.display = 'block';
                    } else {
                        container.textContent = '';
                        container.style.display = 'none';
                    }
                }
            }

            try {
                const response = await fetch('/vendor/change-state', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: bookId, state: newState }),
                });

                const result = await response.json();
                if (!result.success) {
                    console.error(result.message);
                    callErrorContainer(errorContainer, result.message)
                    select.value = select.dataset.originalStatus;
                }
            } catch (error) {
                console.error(error);
                callErrorContainer(errorContainer, error.message)
                select.value = select.dataset.originalStatus;
            }
        });

        select.dataset.originalStatus = select.value;
    });
});