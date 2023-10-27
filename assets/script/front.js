//observer pr show/hide le btn de scroll top. Reglé si topsection visible à 50%, 
// apparait en 0.5sec
const topSection = document.getElementById('topSection');
const toTheTtop = document.querySelector('.scrollToTheTop');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        toTheTtop.classList.toggle("hide", entry.isIntersecting)
    })
}, {
    threshold: 0.5,
})

observer.observe(topSection);

//accordeon pour la section faq

const sectionFaq = document.getElementById('sectionFaq');
const containerFaq = sectionFaq.querySelectorAll('div');
const expandAllFas = document.getElementById('faqExpand');
const faqBtn = document.querySelectorAll('.faqBtn');

//btn expand/close all
faqExpand.addEventListener('click', () => {
    containerFaq.forEach(element => {
        element.lastElementChild.classList.toggle('reponseHide');
        element.getAttribute('aria-expanded') === 'false' ? element.setAttribute('aria-expanded', 'true') : element.setAttribute('aria-expanded', 'false')
    })
    faqExpand.textContent = faqExpand.textContent === 'ouvrir toutes les faq' ? 'fermer toutes les faq' : 'ouvrir toutes les faq';
})
//btn pr chaque faq
faqBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.parentElement.nextElementSibling.classList.toggle('reponseHide');
        btn.parentElement.parentElement.getAttribute('aria-expanded') === 'false' ? btn.parentElement.parentElement.setAttribute('aria-expanded', 'true') : btn.parentElement.parentElement.setAttribute('aria-expanded', 'false')
    })
})
