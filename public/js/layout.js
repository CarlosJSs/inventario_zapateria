document.addEventListener('DOMContentLoaded', () => {
  // Obtener todos los botones
  const buttons = document.querySelectorAll('aside li a')

  // Obtener la página actual desde el query string
  const urlParams = new URLSearchParams(window.location.search)
  const currentPage = urlParams.get('page') || 'default' // Página predeterminada si no hay "page"

  // Iterar sobre los botones y agregar/quitar la clase 'active'
  buttons.forEach(button => {
      if (button.dataset.page === currentPage) {
          button.classList.add('active') // Agregar clase 'active' al botón actual
      } else {
          button.classList.remove('active') // Asegurarse de remover la clase de otros botones
      }
  })
})

const navigate = (page) => {
  window.location.href = `?page=${page}`
}

const logout = () => {
  window.location.href = 'logout.php'
}