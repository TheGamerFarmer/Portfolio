let link;
let modal;
let input;
let submit;
let passwordForm;
let errorMsg;

window.addEventListener("load", async () => {
    link = document.getElementById("protectedLink");
    modal = document.getElementById("modalOverlay");
    input = document.getElementById("passwordInput");
    submit = document.getElementById("submitPassword");
    passwordForm = document.getElementById("passwordForm");
    errorMsg = document.getElementById("errorMsg");

    const isLogResponse = await fetch(`/portfolio/api/isLog`, {
        method: "GET",
        credentials: "include",
    });

    let isLog = isLogResponse.ok && (await isLogResponse.json()).value;

    if (isLog) {
        link.textContent = "Gestion Projets"
        link.href = "/portfolio/gestionProjets"
    }

    link.addEventListener("click", (e) => {
        if (!isLog) {
            e.preventDefault();
            modal.style.display = "flex";
            input.value = "";
            errorMsg.textContent = "";
            input.focus();
        }
    });

    passwordForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        submit.disabled = true;
        try {
            const passwordHashed = CryptoJS.SHA256("salut je met du sel sur mon hash zftgvbh" + input.value + "Bonjour, Ceci est du poivre pour un hash pour du sha256 aueaie").toString();

            const response = await fetch(`/portfolio/api/login`, {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    password: passwordHashed,
                }),
            });

            if (response.ok) {
                modal.style.display = "none";
                window.location.href = "/portfolio/gestionProjets";
            } else
                errorMsg.textContent = await response.text();

            submit.disabled = false;
        } catch (err) {
            console.log(err);
            errorMsg.textContent = "Erreur de connexion au serveur";
        }
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal)
            modal.style.display = "none";
    });
});