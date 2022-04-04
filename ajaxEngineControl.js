const trwp1 = document.querySelector("tr[id='wpdata']");
const trwp2 = document.querySelector("tr[id='wpdata2']");

const tr2 = document.querySelector("tr[id='wp3data']");

const tr3 = document.querySelector("tr[id='led']");
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
        console.log(response);

        let tdOjbect1 = document.createElement("td");
        let tdAction1 = document.createElement("td");
        let selectAction1 = document.createElement("select");
        let optionOn1 = document.createElement("option");
        let optionOff1 = document.createElement("option");
        tdOjbect1.innerHTML = `<td> ${response[0][0].object}</td>`;
        trwp1.appendChild(tdOjbect1);
        optionOn1.setAttribute("value", "On");
        optionOff1.setAttribute("value", "Off");
        selectAction1.setAttribute("name", `action${response[0][0].id}`);
        optionOn1.textContent = "On";
        optionOff1.textContent = "Off";
        if (response[0][0].action == "On") {
          optionOn1.setAttribute("selected", "");
        } else {
          optionOff1.setAttribute("selected", "");
        }
        selectAction1.appendChild(optionOn1);
        selectAction1.appendChild(optionOff1);
        tdAction1.appendChild(selectAction1);
        trwp1.appendChild(tdAction1);

        let tdOjbect2 = document.createElement("td");
        let tdAction2 = document.createElement("td");
        let selectAction2 = document.createElement("select");
        let optionOn2 = document.createElement("option");
        let optionOff2 = document.createElement("option");
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
          let tdOjbect = document.createElement("td");
          let tdAction = document.createElement("td");
          let selectAction = document.createElement("select");
          let optionOn = document.createElement("option");
          let optionOff = document.createElement("option");
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

        tr3.innerHTML = "";
        response[2].forEach((item) => {
          const tdOjbect4 = document.createElement("td");
          const tdAction4 = document.createElement("td");
          const selectAction4 = document.createElement("select");
          const optionOn4 = document.createElement("option");
          const optionOff4 = document.createElement("option");
          tdOjbect4.innerHTML = `<td> ${item.object}</td>`;
          tr3.appendChild(tdOjbect4);
          optionOn4.setAttribute("value", "On");
          optionOff4.setAttribute("value", "Off");
          selectAction4.setAttribute("name", `action${item.id}`);
          optionOn4.textContent = "On";
          optionOff4.textContent = "Off";
          if (item.action == "On") {
            optionOn4.setAttribute("selected", "");
          } else {
            optionOff4.setAttribute("selected", "");
          }
          selectAction4.appendChild(optionOn4);
          selectAction4.appendChild(optionOff4);
          tdAction4.appendChild(selectAction4);
          tr3.appendChild(tdAction4);
        });
      },
    });
  });
  setTimeout(loadControl, 20000);
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
