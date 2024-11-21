document.addEventListener('DOMContentLoaded', () => {
  const productFilter = document.getElementById('productFilter')
  const dateFilter = document.getElementById('dateFilter')
  const quantityFilter = document.getElementById('quantityFilter')
  const clearFilters = document.getElementById('clearFilters')
  const tableRows = Array.from(document.querySelectorAll('#inventoryTable tbody tr'))
  const tableBody = document.querySelector('#inventoryTable tbody')

  const filterTable = () => {
    const productValue = productFilter.value.toLowerCase()
    const dateValue = dateFilter.value
    console.log('fecha', dateValue)
    const quantityValue = parseInt(quantityFilter.value, 10)

    tableRows.forEach(row => {
      const productCell = row.cells[1].textContent.toLowerCase()
      const dateCell = row.cells[2].textContent.split(" ")[0]
      const quantityCell = parseInt(row.cells[3].textContent, 10)

      let showRow = true

      if (productValue && !productCell.includes(productValue)) {
        showRow = false
      }
      if (dateValue && dateCell !== dateValue) {
        showRow = false
      }
      if (!isNaN(quantityValue) && quantityCell !== quantityValue) {
        showRow = false
      }

      row.style.display = showRow ? '' : 'none'
    })
  }

  const sortTable = (sortKey, ascending = true) => {
    const sortedRows = tableRows.sort((rowA, rowB) => {
      const cellA = rowA.cells[sortKey].textContent
      const cellB = rowB.cells[sortKey].textContent

      if (sortKey === 3) { // Cantidad (numérico)
        const valueA = parseInt(cellA, 10)
        const valueB = parseInt(cellB, 10)
        return ascending ? valueA - valueB : valueB - valueA
      } else if (sortKey === 2) { // Fecha (fecha)
        const dateA = new Date(cellA)
        const dateB = new Date(cellB)
        return ascending ? dateA - dateB : dateB - dateA
      }
      return 0
    })

    // Reordenar las filas en el DOM
    tableBody.innerHTML = ''
    sortedRows.forEach(row => tableBody.appendChild(row))
  }

  // Eventos de filtrado
  productFilter.addEventListener('input', filterTable)
  dateFilter.addEventListener('change', filterTable)
  quantityFilter.addEventListener('input', filterTable)

  clearFilters.addEventListener('click', () => {
    productFilter.value = ''
    dateFilter.value = ''
    quantityFilter.value = ''
    filterTable()
  })

  // Eventos de ordenación
  document.querySelectorAll('.sortButton').forEach(button => {
    button.addEventListener('click', () => {
      const sortType = button.dataset.sort

      switch (sortType) {
        case 'cantidad-asc':
          sortTable(3, true) // Ordenar por cantidad (ascendente)
          break;
        case 'cantidad-desc':
          sortTable(3, false) // Ordenar por cantidad (descendente)
          break;
        case 'fecha-asc':
          sortTable(2, true) // Ordenar por fecha (más antiguos)
          break;
        case 'fecha-desc':
          sortTable(2, false) // Ordenar por fecha (más recientes)
          break
        default:
          break
      }
    })
  })
})
