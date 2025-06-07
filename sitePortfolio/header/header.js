const correctPassword = "1234";
export const loggedCode = "C'est bon on est connecté"
export const cookieName = "authPassword";
let link;
let modal;
let input;
let button;
let errorMsg;

window.addEventListener("load", () => {
    link = document.getElementById("protectedLink");
    modal = document.getElementById("modalOverlay");
    input = document.getElementById("passwordInput");
    button = document.getElementById("submitPassword");
    errorMsg = document.getElementById("errorMsg");

    if (getCookie(cookieName) === loggedCode) {
        link.textContent = "Gestion Projets"
        link.href = "/portfolio/gestionProjets"
    }

    link.addEventListener("click", (e) => {
        if (getCookie(cookieName) !== loggedCode) {
            e.preventDefault();
            modal.style.display = "flex";
            input.value = "";
            errorMsg.textContent = "";
            input.focus();
        }
    });

    button.addEventListener("click", () => {
        if (input.value === correctPassword) {
            setCookie(cookieName, loggedCode, 7);
            modal.style.display = "none";
            window.location.href = "/portfolio/gestionProjets";
        } else {
            errorMsg.textContent = "Mot de passe incorrect.";
        }
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });
});

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

export function getCookie(name) {
    const cname = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for(let c of ca) {
        while (c.charAt(0) === ' ') c = c.substring(1);
        if (c.indexOf(cname) === 0) return c.substring(cname.length, c.length);
    }
    return "";
}