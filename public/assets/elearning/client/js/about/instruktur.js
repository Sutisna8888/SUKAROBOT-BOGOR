let instructorsPerPage = 8;
let currentPage = 1;
let selectedKeahlian = 'all';

const filteredInstructors = () => selectedKeahlian === 'all'
    ? instructors
    : instructors.filter(i => i.keahlian === selectedKeahlian);
const totalPages = () => Math.ceil(filteredInstructors().length / instructorsPerPage);

function renderPage(page) {
    const grid = document.getElementById('instructorGrid');
    grid.innerHTML = '';
    const start = (page - 1) * instructorsPerPage;
    const pageInstructors = filteredInstructors().slice(start, start + instructorsPerPage);

    pageInstructors.forEach(inst => {
        const card = document.createElement('div');
        card.className = 'h-full';
        card.innerHTML = `
            <div class="cyber-card-wrapper">
                <div class="cyber-card-layer-3"></div>
                <div class="cyber-card-layer-2"></div>
                <div class="cyber-card-front-border">
                    <div class="cyber-card-content">
                        <div class="flex items-center gap-3.5 sm:gap-4">
                            <div class="cyber-avatar-frame">
                                <div class="cyber-avatar-inner">
                                    <svg viewBox="0 0 100 100" class="cyber-wireframe-globe" aria-hidden="true">
                                        <circle cx="50" cy="50" r="46" fill="none" stroke="#0284c7" stroke-width="1.2" stroke-dasharray="2 2" />
                                        <ellipse cx="50" cy="50" rx="46" ry="16" fill="none" stroke="#0284c7" stroke-width="1" />
                                        <ellipse cx="50" cy="50" rx="46" ry="32" fill="none" stroke="#0284c7" stroke-width="1" />
                                        <ellipse cx="50" cy="50" rx="16" ry="46" fill="none" stroke="#0284c7" stroke-width="1" />
                                        <ellipse cx="50" cy="50" rx="32" ry="46" fill="none" stroke="#0284c7" stroke-width="1" />
                                        <line x1="4" y1="50" x2="96" y2="50" stroke="#0284c7" stroke-width="1" />
                                        <line x1="50" y1="4" x2="50" y2="96" stroke="#0284c7" stroke-width="1" />
                                    </svg>
                                    <img src="${inst.foto}" alt="${inst.nama}" class="relative z-10">
                                </div>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between gap-1.5">
                                    <h3 class="cyber-name truncate">${inst.nama}</h3>
                                    <i class="fa-solid fa-robot text-sky-500 text-xs opacity-75 flex-shrink-0"></i>
                                </div>
                                <p class="cyber-role mt-0.5 truncate">${inst.jabatan}</p>
                            </div>
                        </div>
                        <div class="cyber-bio-box">
                            <p class="line-clamp-3 text-xs leading-relaxed">${inst.deskripsi}</p>
                        </div>
                        <div class="cyber-profile-footer">
                            <span class="cyber-experience">
                                <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                <span>${inst.pengalaman}</span>
                            </span>
                            <button type="button" class="cyber-profile-btn viewProfileBtn">Lihat Profil</button>
                        </div>
                    </div>
                </div>
            </div>`;
        grid.appendChild(card);
        card.querySelector('.viewProfileBtn').addEventListener('click', () => showModal(inst));
    });
    renderPagination();
}

function renderPagination() {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    for (let i = 1; i <= totalPages(); i++) {
        const btn = document.createElement('button');
        btn.className = `w-10 h-10 rounded-xl text-sm font-bold transition-all flex items-center justify-center ${i === currentPage
            ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30'
            : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-400 hover:text-blue-600'}`;
        btn.innerText = i;
        btn.onclick = () => { currentPage = i; renderPage(i); };
        pagination.appendChild(btn);
    }
}

const dropdownBtn = document.getElementById('dropdownBtn');
const dropdownMenu = document.getElementById('dropdownMenu');
const dropdownIcon = document.getElementById('dropdownIcon');

new Set(instructors.map(i => i.keahlian)).forEach(k => {
    const li = document.createElement('li');
    li.className = 'px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 cursor-pointer transition-colors text-sm font-medium text-gray-600';
    li.innerText = k;
    li.dataset.value = k;
    li.addEventListener('click', e => {
        selectedKeahlian = e.target.dataset.value;
        currentPage = 1;
        renderPage(1);
        dropdownBtn.querySelector('span').textContent = e.target.innerText;
        dropdownMenu.classList.add('hidden');
        dropdownIcon.classList.remove('rotate-180');
    });
    dropdownMenu.appendChild(li);
});

document.querySelector('[data-value="all"]').addEventListener('click', e => {
    selectedKeahlian = 'all';
    currentPage = 1;
    renderPage(1);
    dropdownBtn.querySelector('span').textContent = e.target.innerText;
    dropdownMenu.classList.add('hidden');
    dropdownIcon.classList.remove('rotate-180');
});

dropdownBtn.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
    dropdownIcon.classList.toggle('rotate-180');
});

document.addEventListener('click', e => {
    if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.add('hidden');
        dropdownIcon.classList.remove('rotate-180');
    }
});

renderPage(1);

(function handleHighlight() {
    const highlightName = new URLSearchParams(window.location.search).get('highlight');
    if (!highlightName) return;
    const idx = instructors.findIndex(i => i.nama.toLowerCase() === decodeURIComponent(highlightName).toLowerCase());
    if (idx === -1) return;

    const targetPage = Math.floor(idx / instructorsPerPage) + 1;
    currentPage = targetPage;
    renderPage(targetPage);

    requestAnimationFrame(() => setTimeout(() => {
        const cards = document.getElementById('instructorGrid').querySelectorAll(':scope > div');
        const targetCard = cards[idx - (targetPage - 1) * instructorsPerPage];
        if (!targetCard) return;
        targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        targetCard.style.boxShadow = '0 0 0 3px #3b82f6, 0 0 24px rgba(59, 130, 246, 0.35)';
        targetCard.style.transform = 'scale(1.03)';
        setTimeout(() => showModal(instructors[idx]), 800);
        setTimeout(() => { targetCard.style.boxShadow = ''; targetCard.style.transform = ''; }, 3000);
        window.history.replaceState({}, '', window.location.pathname);
    }, 150));
})();

const modalBg = document.getElementById('modalBg');
const modalBody = document.getElementById('modalBody');
const modalImage = document.getElementById('modalImage');
const modalClose = document.getElementById('modalClose');

function showModal(inst) {
    modalImage.src = inst.foto;
    modalBody.innerHTML = `
        <div class="mb-4">
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-full mb-2 border border-blue-100">${inst.keahlian}</span>
            <h2 class="text-2xl font-bold text-gray-900">${inst.nama}</h2>
            <p class="text-blue-600 font-medium">${inst.jabatan}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 bg-gray-50 p-3 rounded-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span class="font-semibold">Pengalaman: ${inst.pengalaman}</span>
        </div>
        <p class="text-gray-700 leading-relaxed">${inst.deskripsi}</p>`;
    modalBg.classList.remove('hidden');
}

modalClose.addEventListener('click', closeModal);
modalBg.addEventListener('click', e => { if (e.target === modalBg) closeModal(); });
function closeModal() { modalBg.classList.add('hidden'); }
