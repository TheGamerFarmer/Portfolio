let preview;
let formulaire;
let selectedFiles = [];
let selectedFilesNames = [];
let projetID;
let dragSrcEl = null;

window.addEventListener("load", async () => {
    const isLogResponse = await fetch(`/portfolio/api/isLog`, {
        method: "GET",
        credentials: "include",
    });

    let isLog = isLogResponse.ok && (await isLogResponse.json()).value;

    if (!isLog) {
        window.location.href = "/portfolio";
    }

    const fileInput = document.getElementById('fileInput');
    const buttonFileInput = document.getElementById("fileInputButton");
    preview = document.getElementById('preview');
    formulaire = document.getElementById('formulaire');
    formulaire.reset();
    const projetsModifButtons = document.querySelectorAll("main #modificationProjets #projets .projet button");

    buttonFileInput.addEventListener("click", () => {
        fileInput.click()
    })

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);

        for (const file of files) {
            if (selectedFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) continue;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    addElementInPreview(img, file);
                };
                reader.readAsDataURL(file);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                addElementInPreview(video, file);
            }
        }

        fileInput.value = '';
    });

    formulaire.addEventListener('submit', submitAdd);

    const projetsContainer = document.getElementById('projets');
    let dragSrcProjet = null;
    let projetPlaceholder = null;

    projetsContainer.querySelectorAll('.projet').forEach(projet => {
        projet.draggable = true;

        projet.addEventListener('dragstart', () => {
            dragSrcProjet = projet;
            setTimeout(() => {
                projetPlaceholder = projet.cloneNode(true);
                projetPlaceholder.classList.add('projet-placeholder');
                projetPlaceholder.removeAttribute('draggable');
                projet.replaceWith(projetPlaceholder);
            }, 0);
        });

        projet.addEventListener('dragend', () => {
            if (!projetPlaceholder) return;
            projetPlaceholder.replaceWith(dragSrcProjet);
            projetPlaceholder = null;
            dragSrcProjet = null;
            dragCooldown = false;
            saveProjetOrder();
        });
    });

    let dragCooldown = false;

    projetsContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (!projetPlaceholder || dragCooldown) return;
        const target = e.target.closest('.projet:not(.projet-placeholder)');
        if (!target) return;
        const children = [...projetsContainer.children];
        const phIdx = children.indexOf(projetPlaceholder);
        const targetIdx = children.indexOf(target);
        let moved = false;
        if (phIdx < targetIdx) {
            if (target.nextSibling !== projetPlaceholder) {
                target.after(projetPlaceholder);
                moved = true;
            }
        } else {
            if (projetPlaceholder.nextSibling !== target) {
                projetsContainer.insertBefore(projetPlaceholder, target);
                moved = true;
            }
        }
        if (moved) {
            dragCooldown = true;
            setTimeout(() => { dragCooldown = false; }, 80);
        }
    });

    function saveProjetOrder() {
        const ids = Array.from(projetsContainer.querySelectorAll('.projet:not(.projet-placeholder)')).map(p => {
            return p.querySelector('button[id^="modifyProjet"]').id.split(':').at(-1);
        });
        const formData = new FormData();
        ids.forEach((id, i) => formData.append('ids[' + i + ']', id));
        fetch('/BDD/reorderProjets.php', { method: 'POST', credentials: 'include', body: formData });
    }

    projetsModifButtons.forEach(button => {
        let id = button.id;
        if (id.startsWith("modifyProjet")) {
            button.addEventListener("click", () => {
                projetID = id.split(":").reverse().at(0);
                fetch("/BDD/getProjet.php?id=" + projetID)
                    .then(res => res.json())
                    .then(json => {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;

                        const children = formulaire.children;

                        children.namedItem("titre").value = json["projet"][0]["title"];
                        children.namedItem("contexte").value = json["projet"][0]["contexte"];
                        children.namedItem("technologies").value = json["projet"][0]["technologies"];
                        children.namedItem("role").value = json["projet"][0]["role"];
                        children.namedItem("defis").value = json["projet"][0]["defis"];

                        const medias = json["medias"];
                        for (const media of medias) {
                            if (media["type"] === "image") {
                                const imageElement = document.createElement('img');
                                imageElement.src = "/sitePortfolio/projets/images/" + encodeURIComponent(media["lien"]);
                                addElementInPreview(imageElement, media["lien"]);
                            } else {
                                const videoElement = document.createElement('video');
                                videoElement.src = "/sitePortfolio/projets/videos/" + encodeURIComponent(media["lien"]);
                                videoElement.controls = true;
                                addElementInPreview(videoElement, media["lien"]);
                            }
                        }

                        formulaire.removeEventListener("submit", submitAdd);
                        formulaire.addEventListener("submit", submitModify);

                        const cancelButton = document.createElement('button');
                        cancelButton.id = "cancelButton";
                        cancelButton.textContent = "Annuler"

                        cancelButton.addEventListener("click", (e) => {
                            e.preventDefault()
                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;

                            formulaire.removeEventListener("submit", submitModify);
                            formulaire.addEventListener("submit", submitAdd);
                            formulaire.reset()
                            selectedFiles.length = 0;
                            selectedFilesNames.length = 0;
                            preview.innerHTML = '';
                            cancelButton.remove()
                        })

                        children.namedItem("buttons").appendChild(cancelButton)
                    })
            });

        } else if (id.startsWith("suppProjet")) {
            button.addEventListener("click", () => {
                projetID = id.split(":").reverse().at(0);
                void fetch("/BDD/suppProjet.php?id=" + projetID, {
                    method: "POST",
                    credentials: 'include'
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
    containerContainer._mediaRef = (file instanceof File)
        ? {type: 'file', value: file}
        : {type: 'name', value: file};

    const container = document.createElement('div');
    container.classList.add("mediaContainer");

    const btn = document.createElement('button');
    btn.textContent = '❌';
    btn.classList.add("suppMedia");
    btn.onclick = () => {
        if (file instanceof File) {
            const index = selectedFiles.indexOf(file);
            if (index > -1) selectedFiles.splice(index, 1);
        } else {
            const index = selectedFilesNames.indexOf(file);
            if (index > -1) selectedFilesNames.splice(index, 1);
        }
        preview.removeChild(containerContainer);
    };

    container.appendChild(element);
    container.appendChild(btn);
    containerContainer.appendChild(container);
    addDragListeners(containerContainer);
    preview.appendChild(containerContainer);
}

function addDragListeners(el) {
    el.draggable = true;

    el.addEventListener('dragstart', (e) => {
        dragSrcEl = el;
        e.dataTransfer.effectAllowed = 'move';
        setTimeout(() => el.classList.add('dragging'), 0);
    });

    el.addEventListener('dragend', () => {
        el.classList.remove('dragging');
        preview.querySelectorAll('.mediaContainerContainer').forEach(c => c.classList.remove('drag-over-before', 'drag-over-after'));
        dragSrcEl = null;
    });

    el.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (!dragSrcEl || dragSrcEl === el) return;
        e.dataTransfer.dropEffect = 'move';
        const rect = el.getBoundingClientRect();
        const midX = rect.left + rect.width / 2;
        preview.querySelectorAll('.mediaContainerContainer').forEach(c => c.classList.remove('drag-over-before', 'drag-over-after'));
        if (e.clientX < midX) {
            el.classList.add('drag-over-before');
        } else {
            el.classList.add('drag-over-after');
        }
    });

    el.addEventListener('dragleave', () => {
        el.classList.remove('drag-over-before', 'drag-over-after');
    });

    el.addEventListener('drop', (e) => {
        e.preventDefault();
        el.classList.remove('drag-over-before', 'drag-over-after');
        if (!dragSrcEl || dragSrcEl === el) return;
        const rect = el.getBoundingClientRect();
        const midX = rect.left + rect.width / 2;
        if (e.clientX < midX) {
            preview.insertBefore(dragSrcEl, el);
        } else {
            el.after(dragSrcEl);
        }
    });
}

function setLoading(loading) {
    Array.from(formulaire.elements).forEach(el => el.disabled = loading);

    const btn = document.getElementById('submitBtn');

    if (loading) {
        btn.innerHTML = '<div class="btnSpinner"></div>';
    } else {
        btn.textContent = 'Enregistrer';
    }
}

function showStatus(message, isError) {
    let status = document.getElementById('submitStatus');
    if (!status) {
        status = document.createElement('p');
        status.id = 'submitStatus';
        document.getElementById('buttons').insertAdjacentElement('afterend', status);
    }
    status.textContent = message;
    status.className = isError ? 'error' : 'success';
}

function encodeTextFields(formData) {
    for (const field of ['titre', 'contexte', 'technologies', 'role', 'defis']) {
        const val = formData.get(field);
        if (val !== null) formData.set(field, encodeURIComponent(val));
    }
}

function submitAdd (e) {
    e.preventDefault();

    const formData = new FormData(formulaire);
    encodeTextFields(formData);
    setLoading(true);

    formData.delete('medias[]');
    Array.from(preview.children).forEach((container, globalIdx) => {
        const ref = container._mediaRef;
        if (!ref || ref.type !== 'file') return;
        formData.append('medias[]', ref.value);
        formData.append('mediasOrdres[]', globalIdx);
    });

    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
        .then(async res => {
            if (!res.ok) {
                setLoading(false);
                showStatus(await res.text(), true);
                return;
            }
            showStatus('Enregistré !', false);
            formulaire.reset();
            selectedFiles.length = 0;
            selectedFilesNames.length = 0;
            preview.innerHTML = '';
            window.location.reload();
        })
        .catch(err => {
            setLoading(false);
            showStatus('Erreur de connexion.', true);
            console.error('Erreur fetch:', err);
        });
}

function submitModify (e) {
    e.preventDefault();

    const formData = new FormData(formulaire);
    encodeTextFields(formData);
    setLoading(true);

    formData.set("projectID", projetID);

    formData.delete('medias[]');
    Array.from(preview.children).forEach((container, globalIdx) => {
        const ref = container._mediaRef;
        if (!ref) return;
        if (ref.type === 'file') {
            formData.append('medias[]', ref.value);
            formData.append('mediasOrdres[]', globalIdx);
        } else {
            formData.append('oldmedias[]', ref.value);
            formData.append('oldmediasOrdres[]', globalIdx);
        }
    });

    fetch("/BDD/modifyProject.php", {
        method: 'POST',
        credentials: 'include',
        body: formData
    })
        .then(async res => {
            if (!res.ok) {
                setLoading(false);
                showStatus(await res.text(), true);
                return;
            }
            showStatus('Enregistré !', false);
            formulaire.reset();
            selectedFiles.length = 0;
            selectedFilesNames.length = 0;
            preview.innerHTML = '';
            window.location.reload();
        })
        .catch(err => {
            setLoading(false);
            showStatus('Erreur de connexion.', true);
            console.error('Erreur fetch:', err);
        });
}