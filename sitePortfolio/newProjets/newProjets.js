import {getCookie, cookieName, loggedCode} from "../header/header.js";

if (getCookie(cookieName) !== loggedCode) {
    window.location.href = "/";
}

window.addEventListener("load", () => {
    const fileInput = document.getElementById('fileInput');
    const buttonFileInput = document.getElementById("buttonFileInput");
    const preview = document.getElementById('preview');
    const selectedFiles = [];

    buttonFileInput.addEventListener("click", () => {
        fileInput.click()
    })

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);

        for (const file of files) {
            // Empêche les doublons
            if (selectedFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) continue;

            selectedFiles.push(file);
            const reader = new FileReader();

            reader.onload = function (event) {
                const container = document.createElement('div');
                container.style.position = 'relative';

                const btn = document.createElement('button');
                btn.textContent = '🗑️';
                btn.style.position = 'absolute';
                btn.style.top = '0';
                btn.style.right = '0';
                btn.style.background = 'rgba(255,0,0,0.7)';
                btn.style.color = 'white';
                btn.style.border = 'none';
                btn.style.cursor = 'pointer';
                btn.onclick = () => {
                    const index = selectedFiles.indexOf(file);
                    if (index > -1) {
                        selectedFiles.splice(index, 1);
                        preview.removeChild(container);
                    }
                };

                let media;
                if (file.type.startsWith('image/')) {
                    media = document.createElement('img');
                    media.src = event.target.result;
                    media.style.maxHeight = '200px';
                } else if (file.type.startsWith('video/')) {
                    media = document.createElement('video');
                    media.src = event.target.result;
                    media.controls = true;
                    media.style.maxHeight = '200px';
                }

                container.appendChild(media);
                container.appendChild(btn);
                preview.appendChild(container);
            };

            reader.readAsDataURL(file);
        }

        // Reset input pour pouvoir re-sélectionner les mêmes fichiers si besoin
        fileInput.value = '';
    });

// Formulaire : créer dynamiquement un FormData avec les fichiers sélectionnés
    document.getElementById('formulaire').addEventListener('submit', function (e) {
        const formData = new FormData();

        // Ajout des autres champs (exemple)
        // formData.append('titre', 'titre exemple'); etc.

        selectedFiles.forEach((file, i) => {
            formData.append('medias[]', file); // même nom que côté PHP
        });

        void fetch('', {
            method: 'POST',
            body: formData
        });
    });
});