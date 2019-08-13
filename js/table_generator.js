/**
 * 
 * @param {Array} JSONData 
 */
function generateTable(JSONData){
     var table = document.createElement("table");
     //create a table header of of the JSONData
     var headers = createTableHeadersFrom(JSONData);
     //append each header to the table object.
     headers.forEach(header => {
         table.appendChild(header);
     });
    //  //populate the table with rows from JSONData
      var rows = createRowsFrom(JSONData);
      rows.forEach(row=>{
          table.appendChild(row);
      });
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
    var tableRows = JSONData.map(createRow);
    return tableRows;
}
function createRow(row){
    //row is a JSON object
    var tr = document.createElement("tr");
    for(key in row){
        var td = document.createElement("td");
        td.textContent = row[key];
        tr.appendChild(td);
    }
    return tr;
}