<template>
    <div class="category-container">
        <b-table :data="tableData" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed"
                 :checkable="isCheckable" :loading="isLoading" :mobile-cards="hasMobileCards" :paginated="isPaginated"
                 :per-page="perPage" :pagination-simple="isPaginationSimple" default-sort="id" :selected.sync="selected"
                 :checked-rows.sync="checkedRows">
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>
                <b-table-column field="category_name" label="Category Name" sortable>
                    {{ props.row.category_name }}
                </b-table-column>
                <b-table-column label="Action">
                    <a :href="'/admin/categories/'+ props.row.id +'/edit'">
                        <b-icon icon="edit" size="is-small"></b-icon>
                    </a>
                    <span @click="delCategory(props.row.id)" class="is-anchor">
                        <b-icon icon="delete" type="is-danger" size="is-small"></b-icon>
                    </span>
                </b-table-column>
            </template>
            <div slot="empty" class="has-text-centered">
                No Categories Found..
            </div>
        </b-table>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                tableData: this.categories,
                checkedRows: [],selected: {},isBordered: false,isStriped: true,isNarrowed: true,isCheckable: false,
                isLoading: false,hasMobileCards: true,isPaginated: true,isPaginationSimple: false,perPage: 10
            }
        },
        props: ['categories'],
        methods: {
            clearSelected() {
                this.selected = {}
            },
            clearCheckedRows() {
                this.checkedRows = []
            },
            delCategory(category){
                this.$dialog.confirm({
                    message: 'Do you really want to delete the Category?',
                    confirmText:'Delete',
                    type:'is-danger',
                    onConfirm:()=>{
                        axios.delete('/admin/categories/'+category);
                        this.tableData = _.reject(this.tableData,(o=> { return o.id === category; }));
                        this.$toast.open({type:'is-danger',duration:'3000',position:'is-top-right',message:'Category Deleted Successfully..!'});
                    }
                })
            }
        }
    }
</script>