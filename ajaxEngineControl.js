const trwp1 = document.querySelector("tr[id='wpdata']");
const trwp2 = document.querySelector("tr[id='wpdata2']");

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
        trwp1.innerHTML = "";
        trwp2.innerHTML = "";

        const tdOjbect = document.createElement("td");
        const tdAction = document.createElement("td");
        const selectAction = document.createElement("select");
        const optionOn = document.createElement("option");
        const optionOff = document.createElement("option");
        tdOjbect.innerHTML = `<td> ${response[0][0].object}</td>`;
        trwp1.appendChild(tdOjbect);
        optionOn.setAttribute("value", "On");
        optionOff.setAttribute("value", "Off");
        selectAction.setAttribute("name", `action${response[0][0].id}`);
        optionOn.textContent = "On";
        optionOff.textContent = "Off";
        if (response[0][0].action == "On") {
          optionOn.setAttribute("selected", "");
        } else {
          optionOff.setAttribute("selected", "");
        }
        selectAction.appendChild(optionOn);
        selectAction.appendChild(optionOff);
        tdAction.appendChild(selectAction);
        trwp1.appendChild(tdAction);

        const tdOjbect2 = document.createElement("td");
        const tdAction2 = document.createElement("td");
        const selectAction2 = document.createElement("select");
        const optionOn2 = document.createElement("option");
        const optionOff2 = document.createElement("option");
        tdOjbect2.innerHTML = `<td> ${response[0][1].object}</td>`;
        trwp2.appendChild(tdOjbect2);
        optionOn2.setAttribute("value", "On");
        optionOff2.setAttribute("value", "Off");
        selectAction2.setAttribute("name", `action${response[0][1].id}`);
        optionOn2.textContent = "On";
        optionOff2.textContent = "Off";
        if (response[0][1].action == "On") {
          optionOn2.setAttribute("selected", "");
        } else {
          optionOff2.setAttribute("selected", "");
        }
        selectAction2.appendChild(optionOn2);
        selectAction2.appendChild(optionOff2);
        tdAction2.appendChild(selectAction2);
        trwp2.appendChild(tdAction2);

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
  setTimeout(loadControl, 5000);
}

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
