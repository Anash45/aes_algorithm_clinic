// Will contain all the scripts
document.getElementById('search').addEventListener('keyup', function () {
    var searchValue = this.value.toLowerCase();
    var rows = document.getElementById('result-table').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var rowData = rows[i].getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < rowData.length; j++) {
            if (rowData[j].innerText.toLowerCase().indexOf(searchValue) > -1) {
                found = true;
                break;
            }
        }
        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});