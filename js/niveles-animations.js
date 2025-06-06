/**
 * Animaciones y efectos para la página de niveles educativos
 * Babelium - Sistema de gestión educativa
 */

/**
 * Configuración del Intersection Observer para animaciones de entrada
 */
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
}

/**
 * Función para animar la entrada de las tarjetas de niveles
 */
function animarEntradaCards() {
  const cards = document.querySelectorAll(".nivel-card")

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1"
        entry.target.style.transform = "translateY(0)"
      }
    })
  }, observerOptions)

  cards.forEach((card, index) => {
    card.style.opacity = "0"
    card.style.transform = "translateY(30px)"
    card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`
    observer.observe(card)
  })
}

/**
 * Función para agregar efectos hover adicionales (opcional)
 */
function agregarEfectosHover() {
  const cards = document.querySelectorAll(".nivel-card")

  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-5px) scale(1.02)"
    })

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0) scale(1)"
    })
  })
}

/**
 * Función para animar el hero section
 */
function animarHeroSection() {
  const heroContent = document.querySelector(".hero-content")
  if (heroContent) {
    heroContent.style.opacity = "0"
    heroContent.style.transform = "translateY(20px)"

    setTimeout(() => {
      heroContent.style.transition = "opacity 0.8s ease, transform 0.8s ease"
      heroContent.style.opacity = "1"
      heroContent.style.transform = "translateY(0)"
    }, 100)
  }
}

/**
 * Función para animar las tarjetas de información
 */
function animarInfoCards() {
  const infoCards = document.querySelectorAll(".info-card")

  const infoObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateY(0)"
        }, index * 200)
      }
    })
  }, observerOptions)

  infoCards.forEach((card) => {
    card.style.opacity = "0"
    card.style.transform = "translateY(30px)"
    card.style.transition = "opacity 0.6s ease, transform 0.6s ease"
    infoObserver.observe(card)
  })
}

/**
 * Inicialización de todas las animaciones cuando el DOM esté listo
 */
document.addEventListener("DOMContentLoaded", () => {
  // Animar hero section
  animarHeroSection()

  // Animar cards de niveles
  animarEntradaCards()

  // Animar cards de información
  animarInfoCards()

  // Agregar efectos hover (opcional)
  // agregarEfectosHover();
})

/**
 * Función para reiniciar animaciones (útil para SPA o cambios dinámicos)
 */
function reiniciarAnimaciones() {
  animarEntradaCards()
  animarInfoCards()
}

// Exportar funciones para uso externo si es necesario
if (typeof module !== "undefined" && module.exports) {
  module.exports = {
    animarEntradaCards,
    agregarEfectosHover,
    animarHeroSection,
    animarInfoCards,
    reiniciarAnimaciones,
  }
}
