const tableBody = document.querySelector("tbody");

function loadTable() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "GetDataForAjax.php", true);
  xhr.onload = function () {
    if (this.status == 200) {
      var data = JSON.parse(this.responseText);
      let oddrow = true;
      tableBody.innerHTML = "";
      data.forEach((item) => {
        let css_class;
        if (oddrow) {
          css_class = ' class="table_cells_odd"';
        } else {
          css_class = ' class="table_cells_even"';
        }
        oddrow = !oddrow;
        let tableRow = document.createElement("tr");
        let tableData = document.createElement("td");
        tableData.innerHTML = `<td ${css_class}> ${item.date}</td>`;
        let tableData2 = document.createElement("td");
        tableData2.innerHTML = `<td ${css_class}> ${item.temperature}</td>`;
        let tableData3 = document.createElement("td");
        tableData3.innerHTML = `<td ${css_class}> ${item.humidity}</td>`;
        tableRow.appendChild(tableData);
        tableRow.appendChild(tableData2);
        tableRow.appendChild(tableData3);
        tableBody.appendChild(tableRow);
      });
    }
  };
  xhr.send();
  setTimeout(loadTable, 5000);
}
loadTable();

// //process every record
// while( $row = pg_fetch_array($result) )
// {
//     if ($oddrow)
//     {
//         $css_class=' class="table_cells_odd"';
//     }
//     else
//     {
//         $css_class=' class="table_cells_even"';
//     }

//     $oddrow = !$oddrow;

//     echo '<tr>';
//     echo '   <td'.$css_class.'>'.$row["date"].'</td>';
//     echo '   <td'.$css_class.'>'.$row["temperature"].'</td>';
//     echo '   <td'.$css_class.'>'.$row["humidity"].'</td>';

//     echo '</tr>';
// }
