<template>
    <div class="user-container">
        <b-table :data="tableData" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed"
                 :checkable="isCheckable" :loading="isLoading" :mobile-cards="hasMobileCards" :paginated="isPaginated"
                 :per-page="perPage" :pagination-simple="isPaginationSimple" default-sort="id" :selected.sync="selected"
                 :checked-rows.sync="checkedRows">
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" sortable numeric>{{ props.row.id }}</b-table-column>
                <b-table-column field="name" label="Name" sortable>{{ props.row.name }}</b-table-column>
                <b-table-column field="email" label="Email">{{ props.row.email }}</b-table-column>
                <b-table-column field="mobile_no" label="Mobile">{{ props.row.mobile_no }}</b-table-column>
                <b-table-column label="Action">
                    <span @click="delUser(props.row.id)" class="is-anchor">
                        <b-icon icon="delete" type="is-danger" size="is-small"></b-icon>
                    </span>
                </b-table-column>
            </template>
            <div slot="empty" class="has-text-centered">
                No Users Found..
            </div>
        </b-table>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                tableData: this.users,
                checkedRows: [],selected: {},isBordered: false,isStriped: true,isNarrowed: true,isCheckable: false,
                isLoading: false,hasMobileCards: true,isPaginated: true,isPaginationSimple: false,perPage: 10
            }
        },
        props: ['users'],
        methods: {
            clearSelected() {
                this.selected = {}
            },
            clearCheckedRows() {
                this.checkedRows = []
            },
            delUser(user){
                this.$dialog.confirm({
                    message: 'Do you really want to delete the User?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    onConfirm: () => {
                        axios.delete('/admin/users/' + user);
                        this.tableData = _.reject(this.tableData, (o => {
                            return o.id === user;
                        }));
                        this.$toast.open('User Deleted Successfully..!');
                    }
                })
            }
        }
    }
</script>