function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("sort");
  switching = true;
  
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          if(n==0){
            document.getElementsByClassName('NameUp')[0].style.display = 'inline-block';
            document.getElementsByClassName('NameDown')[0].style.display = 'none';
            // document.getElementsByClassName('RoleUp')[0].style.display = 'none';
            // document.getElementsByClassName('RoleDown')[0].style.display = 'none';
          }
          // else{
          //   document.getElementsByClassName('NameUp')[0].style.display = 'none';
          //   document.getElementsByClassName('NameDown')[0].style.display = 'none';
          //   // document.getElementsByClassName('RoleUp')[0].style.display = 'inline-block';
          //   // document.getElementsByClassName('RoleDown')[0].style.display = 'none';
          // }
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          if(n==0){
            document.getElementsByClassName('NameUp')[0].style.display = 'none';
            document.getElementsByClassName('NameDown')[0].style.display = 'inline-block';
            // document.getElementsByClassName('RoleUp')[0].style.display = 'none';
            // document.getElementsByClassName('RoleDown')[0].style.display = 'none';
          }
          // else{
          //   document.getElementsByClassName('NameUp')[0].style.display = 'none';
          //   document.getElementsByClassName('NameDown')[0].style.display = 'none';
          //   // document.getElementsByClassName('RoleUp')[0].style.display = 'none';
          //   // document.getElementsByClassName('RoleDown')[0].style.display = 'inline-block';
          // }
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;      
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}