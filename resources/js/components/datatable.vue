<template>
<div class="card">
      <div class="card-header">
        {{title}}
      </div>
      <div class="card-body p-0">
        <table class="table">
    <slot />
</table>
      </div>
    </div>

</template>
<script>
import dt from 'datatables.net-bs5';
import {authFetch} from '@/libs/common'
export default {
    name: "DataTable",
    props: ["ajax", "columns", "options", "title", "actions"],
    mounted() {
        //tableRef.value.$el.querySelector('table');
        const defaultParams = {
            sortable: false,
            serverSide: true,
            dom: "<'p-4 row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto ms-auto'f>><'row mt-2 justify-content-md-center'<'col-12't>><'p-4 row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            //dom: "<'v-table__wrapper'tr>" +"<'v-row mb-5'<'v-col v-col-5'i><'v-col v-col-7 text-right'p>>",
        }
        let options = {...defaultParams, ...this.options};
        if (options.ajax && typeof options.ajax == 'string') {
            var urlPath = options.ajax;
            options['ajax'] = async (data, callback, settings) => {
                const params = {
                    draw: data.draw,
                    length: data.length,
                    start: data.start,
                    search: data.search.value,
                    order_col: data.order[0].column,
                    order_dir: data.order[0].dir
                };
                if (options.paramData) {
                    options.paramData(params);
                }
                const queryString = new URLSearchParams(params).toString();
                let response = await authFetch(urlPath+'?'+queryString);
                if (response.ok) {
                    let msg = await response.json();
                    let recordsTotal = msg.total ? msg.total : 0;
                    let data = {
                        recordsTotal: recordsTotal,
                        recordsFiltered: recordsTotal,
                        draw: msg.draw,
                        data: msg.data ? msg.data : [],
                    };
                    callback(data);
                } else {
                    let data = {
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: [],
                    };
                    callback(data);
                }
            }
        }
        console.log('option', options)
        let tableRef = this.$el.querySelector('table');
        let table = new dt(tableRef, options);
    }
}
</script>
<style>
@import 'datatables.net-bs5';
</style>
