const dropdown = document.querySelector(".dropdown");
const dropdownContent = document.querySelector(".dropdown-content");
const enrolements = document.querySelectorAll('.enrolement');
const logins = document.querySelectorAll('.login');
const logouts = document.querySelectorAll('.logout');

const textsEnrolement = [
    'Creation de compte',
    'Enrôlement'
];
const textsLogin = [
    'Se connecter',
    'Ouvrir un passage vers l’Ordre'
];
const textsLogout = [
    'Se deconnecter',
    'Refermer les portes de l’Ordre'
]
let indexEnrolement = 0;
let indexLogin = 0;
let indexLogout = 0;
let isHovered = false;
let cycleInterval;

function updateTexts() {
    indexEnrolement = (indexEnrolement + 1) % textsEnrolement.length;
    indexLogin = (indexLogin + 1) % textsLogin.length;
    indexLogout = (indexLogout + 1) % textsLogout.length;

    enrolements.forEach(el => {
        el.style.opacity = 0;
    });
    logins.forEach(el => {
        el.style.opacity = 0;
    });
    logouts.forEach(el => {
        el.style.opacity = 0;
    });

    setTimeout(() => {
        enrolements.forEach(el => {
            el.textContent = textsEnrolement[indexEnrolement];
            el.style.opacity = 1;
        });
        logins.forEach(el => {
            el.textContent = textsLogin[indexLogin];
            el.style.opacity = 1;
        });
        logouts.forEach(el => {
            el.textContent = textsLogout[indexLogout];
            el.style.opacity = 1;
        });
    }, 250);
}

function startCycle() {
    cycleInterval = setInterval(() => {
        if (!isHovered) updateTexts();
    }, 3000);
}

function stopCycle() {
    clearInterval(cycleInterval);
}

[...enrolements, ...logins, ...logouts].forEach(el => {
    el.addEventListener("mouseover", () => {
        isHovered = true;
        stopCycle();
    });
    el.addEventListener("mouseout", () => {
        isHovered = false;
        startCycle();
    });
});

dropdown.addEventListener("mouseover", () => {
    dropdownContent.style.display = "flex";
    dropdownContent.style.animation = "show-content 0.5s ease forwards";
});

dropdown.addEventListener("mouseout", () => {
    dropdownContent.style.animation = "dont-show-content 0.5s ease forwards";

    dropdownContent.addEventListener("animationend", function handler(element) {
        if (element.animationName === "dont-show-content") {
            dropdownContent.style.display = "none";
        }
        dropdownContent.removeEventListener("animationend", handler);
    });
});

startCycle();