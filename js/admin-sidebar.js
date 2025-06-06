// Función para controlar el sidebar en dispositivos móviles
document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.getElementById("sidebarToggle")
  const sidebar = document.querySelector(".admin-sidebar")
  const overlay = document.querySelector(".sidebar-overlay")
  const sidebarLinks = document.querySelectorAll(".admin-sidebar a")

  // Función para mostrar/ocultar el sidebar
  function toggleSidebar() {
    sidebar.classList.toggle("show")
    overlay.classList.toggle("show")
    document.body.classList.toggle("sidebar-open")
  }

  // Event listeners
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", toggleSidebar)
  }

  if (overlay) {
    overlay.addEventListener("click", toggleSidebar)
  }

  // Cerrar sidebar al hacer clic en un enlace (en móvil)
  sidebarLinks.forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= 1024) {
        toggleSidebar()
      }
    })
  })

  // Cerrar sidebar al presionar Escape
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && sidebar.classList.contains("show")) {
      toggleSidebar()
    }
  })

  // Ajustar sidebar al cambiar el tamaño de la ventana
  window.addEventListener("resize", () => {
    if (window.innerWidth > 1024) {
      sidebar.classList.remove("show")
      overlay.classList.remove("show")
      document.body.classList.remove("sidebar-open")
    }
  })
})
