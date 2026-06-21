const itemHeight = "49.5vh - 2.5em";
const visibleCount = 2;
let currentIndex = 0;
let wrapper;
let totalItems;

window.addEventListener("load", () => {
    wrapper = document.getElementById('mediaWrapper');
    totalItems = wrapper.children.length;

    if (totalItems <= visibleCount)
        document.getElementById('counter').style.display = 'none';
    updateCounter();
    updateButtons();

    const medias = Array.from(wrapper.querySelectorAll('img, video'));
    const loader = document.getElementById('mediaLoader');

    if (medias.length === 0) {
        loader.classList.add('hidden');
    } else {
        const firstMedia = medias[0];
        const hideLoader = () => loader.classList.add('hidden');
        if (firstMedia.tagName === 'IMG')
            firstMedia.complete ? hideLoader() : firstMedia.addEventListener('load', hideLoader, { once: true });
        else
            firstMedia.readyState >= 3 ? hideLoader() : firstMedia.addEventListener('canplay', hideLoader, { once: true });
    }

    medias.forEach(media => {
        if (media.tagName === 'IMG')
            media.addEventListener('click', () => openLightbox(media));
    });

    document.getElementById('lightbox').addEventListener('click', (e) => {
        if (e.target === e.currentTarget || e.target.id === 'closeBtn') closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });
});

function updateButtons() {
    document.getElementById('btnUp').disabled = currentIndex === 0;
    document.getElementById('btnDown').disabled = currentIndex >= totalItems - visibleCount;
}

function updateCounter() {
    const totalPages = totalItems - visibleCount + 1;
    document.getElementById('currentIdx').textContent = currentIndex + 1;
    document.getElementById('totalCount').textContent = totalPages;
}

function slide(direction) {
    currentIndex += direction;
    currentIndex = Math.max(0, Math.min(currentIndex, totalItems - visibleCount));
    wrapper.style.transform = `translateY(calc(-${currentIndex} * (${itemHeight})))`;
    updateButtons();
    updateCounter();
}

function openLightbox(media) {
    const lightbox = document.getElementById('lightbox');
    const content = document.getElementById('lightboxContent');
    content.innerHTML = '';

    if (media.tagName === 'IMG') {
        const img = document.createElement('img');
        img.src = media.src;
        img.alt = media.alt;
        content.appendChild(img);
    } else if (media.tagName === 'VIDEO') {
        const video = document.createElement('video');
        const source = media.querySelector('source');
        video.src = source ? source.src : media.src;
        video.type = source ? source.type : '';
        video.controls = true;
        video.autoplay = true;
        content.appendChild(video);
    }

    lightbox.classList.add('open');
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    const video = lightbox.querySelector('video');
    if (video) video.pause();
    lightbox.classList.remove('open');
    document.getElementById('lightboxContent').innerHTML = '';
}