export function tablesFilters() {
  const filterInput = document.querySelector("#filter-table");

  if (filterInput) {
    const table = document.querySelector("table");
    const tableRows = Array.from(table.querySelectorAll("tr"));
    let noResultsRow = document.querySelector("#no-results-row");

    if (!noResultsRow) {
      noResultsRow = document.createElement("tr");
      noResultsRow.setAttribute("id", "no-results-row");

      const noResultsCell = document.createElement("td");
      const colspanValue = tableRows[0].children.length;

      noResultsCell.textContent = language.noResults;
      noResultsCell.setAttribute("colspan", colspanValue);
      noResultsCell.classList.add("py-10", "text-center", "text-sm", "text-white", "hover:bg-white/10", "duration-300", "transition-all");
      noResultsRow.appendChild(noResultsCell);
    }

    filterInput.addEventListener("keyup", function (e) {
      e.preventDefault();
      const filterValue = filterInput.value.trim().toLowerCase();
      let matchingRows = 0;

      tableRows.forEach((tableRow) => {
        const tableItem = tableRow.querySelector("td:nth-child(2)");

        if (tableItem) {
          const itemText = tableItem.textContent.trim().toLowerCase();
          const shouldDisplay = itemText.includes(filterValue);

          tableRow.classList.toggle("hidden", !shouldDisplay);

          if (shouldDisplay) {
            matchingRows++;
          }
        }
      });

      if (matchingRows === 0) {
        const lastRow = tableRows[tableRows.length - 1];

        if (lastRow.id !== "no-results-row") {
          lastRow.insertAdjacentElement("afterend", noResultsRow);
        }
      } else {
        if (noResultsRow.parentNode) {
          noResultsRow.parentNode.removeChild(noResultsRow);
        }
      }
    });

    const tableHeaders = Array.from(table.querySelectorAll("th"));
    const tableHeadersRow = table.querySelector("thead tr");
    const tableBody = table.querySelector("tbody");
    tableHeaders.forEach((header, index) => {
      header.addEventListener("click", function () {
        const sortAscending = header.dataset.sort === "asc";
        const columnIndex = index;
        const rows = Array.from(tableBody.querySelectorAll("tr")); // Include only rows in the tbody

        rows.sort((a, b) => {
          const aValue = a.children[columnIndex].textContent.toLowerCase();
          const bValue = b.children[columnIndex].textContent.toLowerCase();

          if (!isNaN(parseFloat(aValue)) && !isNaN(parseFloat(bValue))) {
            // If both values are numeric, compare as numbers
            return sortAscending ? aValue - bValue : bValue - aValue;
          } else {
            // Otherwise, compare as strings
            if (aValue < bValue) {
              return sortAscending ? -1 : 1;
            } else if (aValue > bValue) {
              return sortAscending ? 1 : -1;
            }
          }

          return 0;
        });

        tableBody.innerHTML = ""; // Clear existing tbody content

        // Reconstruct the sorted table body
        rows.forEach((row) => {
          tableBody.appendChild(row);
        });

        // Toggle the sort order for the next click
        header.dataset.sort = sortAscending ? "desc" : "asc";
      });
    });
  }
}
