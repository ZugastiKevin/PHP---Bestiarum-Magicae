const tryOpenBook = document.querySelector('.book-close-container');
const reveal = document.querySelector(".reveal");

const text = "⟪ Seuls les initiés inscrits à l’Ordre peuvent déchiffrer les secrets du grimoire... Enrôlez-vous pour révéler la vérité cachée. ⟫";

tryOpenBook.addEventListener('click', () => {
    reveal.textContent = "";
    reveal.style.opacity = 1;
    let i = 0;
    const interval = setInterval(() => {
        if (i < text.length) {
            reveal.textContent += text[i];
            i++;
        } else {
            clearInterval(interval);
        }
    }, 70);
});