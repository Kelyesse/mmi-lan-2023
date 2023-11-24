document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const button = item.querySelector('.faq-question-btn');
        button.addEventListener('click', () => {
            const wasActive = item.classList.contains('active');

            // Fermez toutes les réponses ouvertes
            faqItems.forEach(i => i.classList.remove('active'));

            // Toggle l'item actuel s'il n'était pas déjà actif
            if (!wasActive) {
                item.classList.add('active');
            }

            // Mettre à jour l'affichage de la réponse
            const answer = item.querySelector('.faq-answer');
            answer.style.display = wasActive ? 'none' : 'block';
        });
    });
});
