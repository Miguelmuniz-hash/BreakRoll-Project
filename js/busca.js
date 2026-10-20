document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const contentCards = document.querySelectorAll('.content-card');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase().trim();

            contentCards.forEach(card => {
                const title = card.querySelector('.content-title').textContent.toLowerCase();
                const desc = card.querySelector('.content-desc').textContent.toLowerCase();
                const category = card.querySelector('.content-category').textContent.toLowerCase();

                if (title.includes(searchTerm) || desc.includes(searchTerm) || category.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});