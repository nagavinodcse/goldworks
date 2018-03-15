<template>
    <div class="container p-t-20">
        <button class="button is-primary is-pulled-right" @click="showItemForm = true">Add Item</button>
        <b-table :data="tableData" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed"
                 :checkable="isCheckable" :loading="isLoading" :mobile-cards="hasMobileCards" :paginated="isPaginated"
                 :per-page="perPage" :pagination-simple="isPaginationSimple" :default-sort="sorts" :selected.sync="selected"
                 :checked-rows.sync="checkedRows">
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" sortable numeric>{{ props.row.id }}</b-table-column>
                <b-table-column field="item_name" label="Item Name" sortable>{{ props.row.item_name }}</b-table-column>
                <b-table-column field="category.category_name" label="Category Name" sortable>{{ props.row.category.category_name }}</b-table-column>
                <b-table-column label="Action">
                    <span @click="editItem(props.row.id)" class="is-anchor"><b-icon icon="pencil" type="is-success" size="is-small"></b-icon></span>
                    <span @click="delItem(props.row.id)" class="is-anchor"><b-icon icon="delete" type="is-danger" size="is-small"></b-icon></span>
                </b-table-column>
            </template>
            <div slot="empty" class="has-text-centered">
                No Items Found..
            </div>
        </b-table>
        <item-form :categories="categories" ref="add" @close="showItemForm = false" @completed="addItem" v-if="showItemForm"></item-form>
        <edit-item :categories="categories" ref="edit" :id="editId" @close="showEdit = false" @completed="updateItem" v-if="showEdit"></edit-item>
    </div>
</template>
<script>
    import itemForm from './ItemForm.vue';
    import editItem from './editItem.vue';
    export default{
        components:{ itemForm,editItem },
        created(){
            this.isLoading = true
            axios.get('/items').then(items => {this.tableData = items.data;this.isLoading = false;});
        },
        data(){
            return {
                sorts:['id','desc'],tableData: [],editId:'',showEdit:false,
                checkedRows: [],selected: {},isBordered: false,isStriped: true,isNarrowed: true,isCheckable: false,
                isLoading: false,hasMobileCards: true,isPaginated: true,isPaginationSimple: false,perPage: 10,showItemForm:false
            }
        },
        props: ['user','categories'],
        methods: {
            clearSelected() {
                this.selected = {}
            },
            clearCheckedRows() {
                this.checkedRows = []
            },
            delItem(item){
                this.$dialog.confirm({
                    message: 'Do you really want to delete the Item?',
                    confirmText:'Delete',
                    type:'is-danger',
                    onConfirm:()=>{
                        axios.delete('/items/'+item);
                        this.tableData = _.reject(this.tableData,(o=> { return o.id === item; }));
                        this.$toast.open({message:'Item Deleted Successfully..!',duration:3000,position:'is-top-right',type:'is-danger'});
                    }
                })
            },
            addItem(item){
                this.tableData.unshift(item);
                this.$refs.add.modalClose();
                this.$toast.open({message:'Item Added Successfully..!',duration:3000,position:'is-top-right',type:'is-success'});
            },
            editItem(id){
                this.editId = id;this.showEdit = true;
            },
            updateItem(item){
                let index = _.findIndex(this.tableData,{id:item.id});
                this.tableData.splice(index,1,item);
                this.$refs.edit.modalClose();
                this.$toast.open({message:'Item Updated Successfully..!',duration:3000,position:'is-top-right',type:'is-success'});
            }
        }
    }
</script>