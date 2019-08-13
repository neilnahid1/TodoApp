/**
 * 
 * @param {Array} JSONData 
 */
function generateTable(JSONData){
     var table = document.createElement("table");
     table.className = "table table-striped";
     table.id = "table";
    //  table.style.width = "100%";
     //THEAD START
     let thead = document.createElement("thead");
     thead.className = "thead-dark";
     let tr = document.createElement("tr");
     thead.appendChild(tr);
     var headers = createTableHeadersFrom(JSONData);
     headers.forEach(header => {
         tr.appendChild(header);
     });
     table.appendChild(thead);
     //THEAD END
     
     //TBODY START
     let tbody = document.createElement("tbody");
     tbody.className = "tbody";
     //populate the table with rows from JSONData
      var rows = createRowsFrom(JSONData);
      rows.forEach(row=>{
          tbody.appendChild(row);
      });
      table.appendChild(tbody);
    return table;
}
function createTableHeadersFrom(JSONData){
    //creates an array of th elements
    var tableHeaders = Object.keys(JSONData[0]).map(createTableHeader);
    return tableHeaders;
}
function createTableHeader(name){
    var th = document.createElement('th');
    th.textContent = name;
    return th;
}
function createRowsFrom(JSONData){
    let tableRows = JSONData.map(createRow);
    return tableRows;
}
function createRow(row){
    //row is a JSON object
    let tr = document.createElement("tr");
    for(key in row){
        var td = document.createElement("td");
        td.textContent = row[key];
        td.className = "text-truncate";
        tr.appendChild(td);
    }
    return tr;
}