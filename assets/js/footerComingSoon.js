const faqLink = document.querySelector("#faq-coming-soon")

faqLink.addEventListener("click", () => {
    faqLink.innerHTML = "Bientôt..."
    setTimeout(() => {
        faqLink.innerHTML = "FAQ"
    }, 2000)
})
