<template>
    <DataTable ref="mytable2" id="table_id" class="display" title="Examples Datatable" :options="options">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 2</td>
            </tr>
            <tr>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 2</td>
            </tr>
        </tbody>
    </DataTable>
    <br />
    <DataTable ref="tbuser" title="Server Data" :options="options2">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </DataTable>
    <div><button class="btn btn-primary" @click="cekData">Cek</button></div>
</template>
<script>
import DataTable from '../../components/datatable'

export default {
    setup() {

    },
    data() {
        return {
            options: {
                serverSide: false
            },

            options2: {
                ajax: '/users',
                columns : [
                    {
                        data: "name"
                    },
                    {
                        data: "email"
                    }
                ]
            }
        }
    },
    components: {DataTable},
    mounted() {


        //createTable(this.$refs.mytable)
    },
    methods: {
        cekData(){
            alert('test')
        }
    }
}
</script>
