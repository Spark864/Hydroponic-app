const tb = document.querySelector("table[id='wpdata']");

const tr2 = document.querySelector("tr[id='wp3data']");
console.log(tr2);

function loadControl() {
  $(document).ready(function () {
    $.ajax({
      url: "AjaxDataControl.php",
      type: "get",
      dataType: "json",
      statusCode: {
        404: function () {
          alert("page not found");
        },
      },
      success: function (response) {
        tb.innerHTML = "";
        const trHeaderhtml =
          '<tr style="background: whitesmoke;"><th>Object</th><th>Action</th> </tr>';
        const trheader = document.createElement("tr");
        trheader.innerHTML = trHeaderhtml;
        tb.appendChild(trheader);
        response[0].forEach((item) => {
          const trdata = document.createElement("tr");
          const tdOjbect = document.createElement("td");
          const tdAction = document.createElement("td");
          const selectAction = document.createElement("select");
          const optionOn = document.createElement("option");
          const optionOff = document.createElement("option");
          tdOjbect.innerHTML = `<td> ${item.object}</td>`;
          trdata.appendChild(tdOjbect);
          optionOn.setAttribute("value", "On");
          optionOff.setAttribute("value", "Off");
          selectAction.setAttribute("name", `action${item.id}`);
          optionOn.textContent = "On";
          optionOff.textContent = "Off";
          if (item.action == "On") {
            optionOn.setAttribute("selected", "");
          } else {
            optionOff.setAttribute("selected", "");
          }
          selectAction.appendChild(optionOn);
          selectAction.appendChild(optionOff);
          tdAction.appendChild(selectAction);
          trdata.appendChild(tdAction);
          tb.appendChild(trdata);
        });

        tr2.innerHTML = "";
        response[1].forEach((item) => {
          const tdOjbect = document.createElement("td");
          const tdAction = document.createElement("td");
          const selectAction = document.createElement("select");
          const optionOn = document.createElement("option");
          const optionOff = document.createElement("option");
          tdOjbect.innerHTML = `<td> ${item.object}</td>`;
          tr2.appendChild(tdOjbect);
          optionOn.setAttribute("value", "On");
          optionOff.setAttribute("value", "Off");
          selectAction.setAttribute("name", `action${item.id}`);
          optionOn.textContent = "On";
          optionOff.textContent = "Off";
          if (item.action == "On") {
            optionOn.setAttribute("selected", "");
          } else {
            optionOff.setAttribute("selected", "");
          }
          selectAction.appendChild(optionOn);
          selectAction.appendChild(optionOff);
          tdAction.appendChild(selectAction);
          tr2.appendChild(tdAction);
        });
      },
    });
  });
}

setTimeout(loadControl, 5000);
loadControl();
{
  /*
      while($row = pg_fetch_array($result) ){
            
        $id = $row['id'];
        $object = $row['object'];
        $action = $row['action'];
    }
<td><?= $object ?></td>
<td>
    <select name= 'action<?= $id ?>'>
        <option value="On"
            <?php
            if($action == 'On')
                {
                    echo "selected";
                }
                
            ?>
            
        >On</option>
        
        <option value="Off"
        <?php
            if($action == 'Off')
                {
                    echo "selected";
                    
                }
            ?>
        >Off</option>

     </select>
     
    
</td>

*/
}
