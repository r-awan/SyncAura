const chatbot = document.getElementById("chatbot");
const chatbotIcon = document.getElementById("chatbot-icon");

// Toggle chatbot visibility
chatbotIcon.addEventListener("click", () => {
    chatbot.classList.toggle("active");
});

// Close chatbot when clicking outside
document.addEventListener("click", (e) => {
    if (!chatbot.contains(e.target) && e.target !== chatbotIcon) {
        chatbot.classList.remove("active");
    }
});

// Remove Spline logo
window.onload = function() {
    const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
    if (shadowRoot) {
        const logo = shadowRoot.querySelector('#logo');
        if (logo) logo.remove();
    }
}

// Fullscreen toggle
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        document.exitFullscreen();
    }
}