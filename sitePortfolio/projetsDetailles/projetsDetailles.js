const itemHeight = "49.5vh - 2.5em";
const visibleCount = 2;
let currentIndex = 0;
let wrapper;
let totalItems;

window.addEventListener("load", () => {
    wrapper = document.getElementById('mediaWrapper');
    totalItems = wrapper.children.length;

    updateButtons();
});

function updateButtons() {
    document.getElementById('btnUp').disabled = currentIndex === 0;
    document.getElementById('btnDown').disabled = currentIndex >= totalItems - visibleCount;
}

function slide(direction) {
    currentIndex += direction;
    currentIndex = Math.max(0, Math.min(currentIndex, totalItems - visibleCount));
    wrapper.style.transform = `translateY(calc(-${currentIndex} * (${itemHeight})))`;
    updateButtons();
}