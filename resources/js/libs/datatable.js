//import DataTable from 'datatables.net';
import DataTable from 'datatables.net-bs5';

export function createTable(tableRef, options) {
    var tableEl = tableRef;
    console.log('table', tableEl)
    let table = new DataTable(tableEl, {
        // config options...
    });

}