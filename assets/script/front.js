//observer pr show/hide le btn de scroll top. Reglé si topsection visible à 50%
//classe isVisible sert uniquement pour comme marqueur pour le burger quand topsection n'est pas sur la page
const topSection = document.getElementById('topSection');
const toTheTtop = document.querySelector('.scrollToTheTop');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        toTheTtop.classList.toggle("hide", entry.isIntersecting);
        topSection.classList.toggle("IsVisible", entry.isIntersecting);
    });
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('deplace');
    });
    document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
        hamburger.classList.toggle('deplace');
    }))
}, {
    threshold: 0.5,
})
observer.observe(topSection);

//hamburger

const hamburger = document.querySelector('.hamburger');
let hamburgerStyle = window.getComputedStyle(hamburger);
const navMenu = document.querySelector('.nav-menu');
const navbarFront = document.querySelector('.navbarFront');
const sectionPresentation = document.getElementById('sectionPresentation');
const sectionNews = document.getElementById('sectionNews');
const sectionAcces = document.getElementById('sectionAcces');
const sectionPraticien = document.getElementById('sectionPraticien');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
    navMenu.classList.toggle('backdropBlur');
    document.body.classList.toggle('noScroll')
    if (!(topSection.classList.contains('IsVisible'))) {
        toTheTtop.classList.toggle("hide")
    }
})

document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
    navMenu.classList.toggle('backdropBlur');
    if (hamburgerStyle.getPropertyValue('display') === 'block') {
        document.body.classList.toggle('noScroll')
    }
    if ((!(topSection.classList.contains('IsVisible'))) && (toTheTtop.classList.contains('hide')) ) {
        toTheTtop.classList.remove("hide")
     } else {
            return
        }  
}))

//accordeon pour la section faq


const sectionFaq = document.getElementById('sectionFaq');

if (sectionFaq) {

const containerFaq = sectionFaq.querySelectorAll('div');
const faqExpand = document.getElementById('faqExpand');
const faqBtn = document.querySelectorAll('.faqBtn');
const spans = document.querySelectorAll('.faqSpan');

//btn expand/close all
faqExpand.addEventListener('click', () => {
    containerFaq.forEach(element => {
        if (faqExpand.textContent === 'Ouvrir toutes les réponses') {
            element.setAttribute('aria-expanded', 'true');
            element.lastElementChild.setAttribute('aria-hidden', 'false');
            element.lastElementChild.classList.remove('reponseHide');
            if (!(element.firstElementChild.lastElementChild.classList.contains('active'))) {
                element.firstElementChild.lastElementChild.classList.toggle('active')
            }
        } else {
            element.setAttribute('aria-expanded', 'false');
            element.lastElementChild.setAttribute('aria-hidden', 'true');
            element.lastElementChild.classList.add('reponseHide');
            if ((element.firstElementChild.lastElementChild.classList.contains('active'))) {
                element.firstElementChild.lastElementChild.classList.toggle('active')
            }
        }
    })
    faqExpand.textContent = faqExpand.textContent === 'Ouvrir toutes les réponses' ? 'Fermer toutes les réponses' : 'Ouvrir toutes les réponses';
    faqExpand.getAttribute('aria-expanded') === 'false' ? faqExpand.setAttribute('aria-expanded', 'true') : faqExpand.setAttribute('aria-expanded', 'false');
})
//btn pr chaque faq
containerFaq.forEach(ctn => {
    ctn.addEventListener('click', () => {
        ctn.lastElementChild.classList.toggle('reponseHide');
        ctn.firstElementChild.lastElementChild.classList.toggle('active')
        ctn.getAttribute('aria-expanded') === 'false' ? ctn.setAttribute('aria-expanded', 'true') : ctn.setAttribute('aria-expanded', 'false');
        ctn.lastElementChild.getAttribute('aria-hidden') === 'true' ? ctn.lastElementChild.setAttribute('aria-hidden', 'false') : ctn.lastElementChild.setAttribute('aria-hidden', 'true');
    })
})
}

//skip to main

const skipToContent = document.getElementById('skipToContent');

skipToContent.addEventListener('focus', () => {
    skipToContent.classList.toggle('skipHidden')
    skipToContent.classList.toggle('skipShow')   
});
skipToContent.addEventListener('blur', () => {
    skipToContent.classList.toggle('skipHidden')
    skipToContent.classList.toggle('skipShow')   
})