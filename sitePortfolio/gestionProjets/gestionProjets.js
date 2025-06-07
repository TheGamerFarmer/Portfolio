import {getCookie, cookieName, loggedCode} from "../header/header.js";

if (getCookie(cookieName) !== loggedCode) {
    window.location.href = "/";
}

window.addEventListener("load", () => {
    const fileInput = document.getElementById('fileInput');
    const buttonFileInput = document.getElementById("fileInputButton");
    const preview = document.getElementById('preview');
    const formulaire = document.getElementById('formulaire');
    const selectedFiles = [];

    buttonFileInput.addEventListener("click", () => {
        fileInput.click()
    })

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);

        for (const file of files) {
            if (selectedFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) continue;

            selectedFiles.push(file);
            const reader = new FileReader();

            reader.onload = function (event) {
                const containerContainer = document.createElement('div');
                containerContainer.classList.add("mediaContainerContainer");
                const container = document.createElement('div');
                container.classList.add("mediaContainer");

                const btn = document.createElement('button');
                btn.textContent = '❌';
                btn.classList.add("suppMedia");
                btn.onclick = () => {
                    const index = selectedFiles.indexOf(file);
                    if (index > -1) {
                        selectedFiles.splice(index, 1);
                        preview.removeChild(containerContainer);
                        console.log('Fichier supprimé:', file.name, ', selectedFiles:', selectedFiles);
                    }
                };

                let media;
                if (file.type.startsWith('image/')) {
                    media = document.createElement('img');
                    media.src = event.target.result;
                } else if (file.type.startsWith('video/')) {
                    media = document.createElement('video');
                    media.src = event.target.result;
                    media.controls = true;
                }

                container.appendChild(media);
                container.appendChild(btn);
                containerContainer.appendChild(container)
                preview.appendChild(containerContainer);
            };

            reader.readAsDataURL(file);
        }

        fileInput.value = '';
    });

    formulaire.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(formulaire);

        formData.delete('medias[]');
        selectedFiles.forEach((file) => {
            formData.append('medias[]', file);
        });

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(() => {
                formulaire.reset();
                selectedFiles.length = 0;
                preview.innerHTML = '';
            })
            .catch(err => {
                console.error('Erreur fetch:', err);
            });
    });
});