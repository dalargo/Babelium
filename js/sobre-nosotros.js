// Animaciones y efectos interactivos para la página sobre nosotros

document.addEventListener("DOMContentLoaded", () => {
  // Smooth scrolling para el indicador de scroll
  const scrollIndicator = document.querySelector(".scroll-indicator")
  if (scrollIndicator) {
    scrollIndicator.addEventListener("click", () => {
      const missionSection = document.querySelector(".mission-vision")
      if (missionSection) {
        missionSection.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  }

  // Animación de aparición para las tarjetas
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1"
        entry.target.style.transform = "translateY(0)"
      }
    })
  }, observerOptions)

  // Elementos a animar
  const animatedElements = document.querySelectorAll(`
        .mission-card,
        .vision-card,
        .audience-card,
        .reason-item,
        .ods-card,
        .idea-card,
        .timeline-item
    `)

  animatedElements.forEach((element) => {
    element.style.opacity = "0"
    element.style.transform = "translateY(30px)"
    element.style.transition = "opacity 0.6s ease, transform 0.6s ease"
    observer.observe(element)
  })

  // Contador animado para las estadísticas
  const statNumbers = document.querySelectorAll(".stat-number")

  const animateCounter = (element, target) => {
    const increment = target / 100
    let current = 0

    const timer = setInterval(() => {
      current += increment
      if (current >= target) {
        current = target
        clearInterval(timer)
      }

      // Formatear números grandes
      if (target >= 1000000000) {
        element.textContent = (current / 1000000000).toFixed(1) + "B"
      } else if (target >= 1000000) {
        element.textContent = (current / 1000000).toFixed(0) + "M"
      } else if (target >= 1000) {
        element.textContent = (current / 1000).toFixed(0) + "K"
      } else {
        element.textContent = Math.floor(current) + "%"
      }
    }, 20)
  }

  // Observer para las estadísticas
  const statsObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const element = entry.target
          const text = element.textContent

          // Extraer el número del texto
          let targetValue
          if (text.includes("1.6B")) {
            targetValue = 1600000000
          } else if (text.includes("463M")) {
            targetValue = 463000000
          } else if (text.includes("70%")) {
            targetValue = 70
          }

          if (targetValue) {
            animateCounter(element, targetValue)
            statsObserver.unobserve(element)
          }
        }
      })
    },
    { threshold: 0.5 },
  )

  statNumbers.forEach((stat) => {
    statsObserver.observe(stat)
  })

  // Efecto parallax suave para el hero
  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset
    const hero = document.querySelector(".hero-about")
    if (hero) {
      const rate = scrolled * -0.5
      hero.style.transform = `translateY(${rate}px)`
    }
  })

  // Animación de hover para las tarjetas de ideas futuras
  const ideaCards = document.querySelectorAll(".idea-card")
  ideaCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      const icon = this.querySelector(".idea-icon")
      if (icon) {
        icon.style.transform = "scale(1.1) rotate(5deg)"
        icon.style.transition = "transform 0.3s ease"
      }
    })

    card.addEventListener("mouseleave", function () {
      const icon = this.querySelector(".idea-icon")
      if (icon) {
        icon.style.transform = "scale(1) rotate(0deg)"
      }
    })
  })

  // Efecto de escritura para el título principal
  const heroTitle = document.querySelector(".hero-content h1")
  if (heroTitle) {
    const text = heroTitle.textContent
    heroTitle.textContent = ""
    heroTitle.style.borderRight = "2px solid white"

    let i = 0
    const typeWriter = () => {
      if (i < text.length) {
        heroTitle.textContent += text.charAt(i)
        i++
        setTimeout(typeWriter, 100)
      } else {
        setTimeout(() => {
          heroTitle.style.borderRight = "none"
        }, 1000)
      }
    }

    setTimeout(typeWriter, 1000)
  }

  // Navegación suave entre secciones
  const navLinks = document.querySelectorAll('nav a[href^="#"]')
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()
      const targetId = this.getAttribute("href").substring(1)
      const targetSection = document.getElementById(targetId)

      if (targetSection) {
        targetSection.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })

  // Efecto de partículas en el hero (opcional)
  const createParticle = () => {
    const hero = document.querySelector(".hero-about")
    if (!hero) return

    const particle = document.createElement("div")
    particle.style.position = "absolute"
    particle.style.width = "4px"
    particle.style.height = "4px"
    particle.style.background = "rgba(255,255,255,0.5)"
    particle.style.borderRadius = "50%"
    particle.style.left = Math.random() * 100 + "%"
    particle.style.top = "100%"
    particle.style.pointerEvents = "none"
    particle.style.animation = "floatUp 6s linear forwards"

    hero.appendChild(particle)

    setTimeout(() => {
      if (particle.parentNode) {
        particle.parentNode.removeChild(particle)
      }
    }, 6000)
  }

  // Crear partículas cada 2 segundos
  setInterval(createParticle, 2000)

  // Agregar animación CSS para las partículas
  const style = document.createElement("style")
  style.textContent = `
        @keyframes floatUp {
            to {
                transform: translateY(-100vh);
                opacity: 0;
            }
        }
    `
  document.head.appendChild(style)

  // Botón de scroll to top
  const scrollToTopBtn = document.getElementById("scrollToTop")

  // Mostrar/ocultar botón según el scroll
  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      scrollToTopBtn.classList.add("visible")
    } else {
      scrollToTopBtn.classList.remove("visible")
    }
  })

  // Funcionalidad de scroll suave hacia arriba
  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  })

  // Animación adicional al hacer hover
  scrollToTopBtn.addEventListener("mouseenter", function () {
    this.style.animation = "pulse 0.6s ease-in-out"
  })

  scrollToTopBtn.addEventListener("mouseleave", function () {
    this.style.animation = ""
  })
})

// Función para manejar el redimensionamiento de ventana
window.addEventListener("resize", () => {
  // Reajustar animaciones si es necesario
  const isMobile = window.innerWidth <= 768

  if (isMobile) {
    // Desactivar algunas animaciones en móvil para mejor rendimiento
    const parallaxElements = document.querySelectorAll('[style*="transform"]')
    parallaxElements.forEach((element) => {
      if (element.style.transform.includes("translateY")) {
        element.style.transform = ""
      }
    })
  }
})

// Añadir animación de pulso
const style = document.createElement("style")
style.textContent += `
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }
`
document.head.appendChild(style)
