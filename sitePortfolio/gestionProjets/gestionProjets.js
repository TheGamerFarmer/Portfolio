import {cookieName, getCookie, loggedCode} from "../header/header.js";

if (getCookie(cookieName) !== loggedCode) {
    window.location.href = "/";
}

let preview;
let formulaire;
let selectedFiles = [];
let selectedFilesNames = [];


window.addEventListener("load", () => {
    const fileInput = document.getElementById('fileInput');
    const buttonFileInput = document.getElementById("fileInputButton");
    preview = document.getElementById('preview');
    formulaire = document.getElementById('formulaire');
    const projetsModifButtons = document.querySelectorAll("main #modificationProjets #projets .projet button");

    buttonFileInput.addEventListener("click", () => {
        fileInput.click()
    })

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);

        for (const file of files) {
            if (selectedFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) continue;

            const reader = new FileReader();

            reader.onload = function (event) {
                let media;
                if (file.type.startsWith('image/')) {
                    media = document.createElement('img');
                    media.src = event.target.result;
                } else if (file.type.startsWith('video/')) {
                    media = document.createElement('video');
                    media.src = event.target.result;
                    media.controls = true;
                }

                addElementInPreview(media, file);
            };

            reader.readAsDataURL(file);
        }

        fileInput.value = '';
    });

    formulaire.addEventListener('submit', submitListener);

    projetsModifButtons.forEach(button => {
        let id = button.id;
        let projetID = id.split(":").reverse().at(0);
        if (id.startsWith("modifyProjet")) {
            button.addEventListener("click", () => {
                fetch("/BDD/getProjet.php?id=" + projetID)
                    .then(res => res.json())
                    .then(json => {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;

                        const children = formulaire.children;

                        children.namedItem("titre").value = json["projet"][0]["title"];
                        children.namedItem("description").value = json["projet"][0]["description"];
                        children.namedItem("competences").value = json["projet"][0]["competences"];
                        children.namedItem("objectifs").value = json["projet"][0]["objectifs"];
                        children.namedItem("travailDeGroupe").value = json["projet"][0]["travail_En_Groupe"];
                        children.namedItem("travailIndividuel").value = json["projet"][0]["travail_individuel"];
                        children.namedItem("aquis").value = json["projet"][0]["savoir_Faire_Aquis"];

                        const videos = json["videos"];
                        for (const video in videos) {
                            const videoElement = document.createElement('video');
                            videoElement.src = "/sitePortfolio/projets/videos/" + videos[video]["lienVideo"];
                            videoElement.controls = true;

                            addElementInPreview(videoElement);
                        }

                        const images = json["images"];
                        for (const image in images) {
                            const imageElement = document.createElement('img');
                            const nomImage = images[image]["lienImage"];
                            imageElement.src = "/sitePortfolio/projets/images/" + nomImage;

                            addElementInPreview(imageElement, nomImage);
                        }

                        formulaire.removeEventListener("submit", submitListener);
                        formulaire.addEventListener("submit", (e) => {
                            e.preventDefault()

                            const formData = new FormData(formulaire);

                            formData.set("projectID", projetID);

                            formData.delete('medias[]');
                            selectedFiles.forEach((file) => {
                                formData.append('medias[]', file);
                            });

                            selectedFilesNames.forEach((fileName) => {
                                formData.append('oldmedias[]', fileName);
                            });

                            fetch("/BDD/modifyProject.php", {
                                method: 'POST',
                                body: formData
                            })
                                .then(() => {
                                    formulaire.reset();
                                    selectedFiles.length = 0;
                                    preview.innerHTML = '';

                                    window.location.reload()
                                })
                                .catch(err => {
                                    console.error('Erreur fetch:', err);
                                });
                        })

                        const cancelButton = document.createElement('button');
                        cancelButton.id = "cancelButton";
                        cancelButton.textContent = "Annuler"

                        cancelButton.addEventListener("click", (e) => {
                            e.preventDefault()
                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;

                            formulaire.reset()
                            selectedFiles.length = 0;
                            preview.innerHTML = '';
                            cancelButton.remove()
                        })

                        children.namedItem("buttons").appendChild(cancelButton)
                    })
            });

        } else if (id.startsWith("suppProjet")) {
            button.addEventListener("click", () => {
                void fetch("/BDD/suppProjet.php?id=" + projetID, {
                    method: "POST"
                })
                button.parentElement.remove();
            });
        }
    })
});

function addElementInPreview(element, file) {
    if (file instanceof File)
        selectedFiles.push(file);
    else
        selectedFilesNames.push(file);

    const containerContainer = document.createElement('div');
    containerContainer.classList.add("mediaContainerContainer");
    const container = document.createElement('div');
    container.classList.add("mediaContainer");

    const btn = document.createElement('button');
    btn.textContent = '❌';
    btn.classList.add("suppMedia");
    btn.onclick = () => {
        let list;
        if (file instanceof File)
            list = selectedFiles;
        else
            list = selectedFilesNames

        const index = list.indexOf(file);
        if (index > -1) {
            list.splice(index, 1);
        }

        preview.removeChild(containerContainer);
    };


    container.appendChild(element);
    container.appendChild(btn);
    containerContainer.appendChild(container)
    preview.appendChild(containerContainer);
}

function submitListener (e) {
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

            window.location.reload()
        })
        .catch(err => {
            console.error('Erreur fetch:', err);
        });
}