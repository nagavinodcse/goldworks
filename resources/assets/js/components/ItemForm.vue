<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card animated" :class="[ (isClosing) ? 'bounceOutRight' : 'bounceInLeft']">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Item</p>
                <button class="delete" @click="modalClose"></button>
            </header>
            <section class="modal-card-body">
                <progress class="progress is-primary is-small" v-if="progress" id="progressDiv" :value="progressWidth" max="100"></progress>
                <form method="post" id="itemForm" enctype="multipart/form-data" @submit.prevent="addItem">
                    <b-field label="Item Name">
                        <b-input type="text" v-model="form.item_name" placeholder="Item Name" required></b-input>
                    </b-field>
                    <b-field label="Category">
                        <b-select v-model="form.category_id" required expanded>
                            <option value="">Select a Category</option>
                            <option v-for="category in categories" :value="category.id">{{ category.category_name }}</option>
                        </b-select>
                    </b-field>
                    <div class="field">
                        <label for="images" class="label">Select Images :</label>
                        <div class="control">
                            <input type="file" @change="addFiles" name="images[]" accept="image/*" id="images" multiple>
                        </div>
                        <div id="errors"></div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <button form="itemForm" class="button is-primary" :class="{ 'is-loading':progress }">Add Item</button>
                <button class="button" @click="modalClose" type="button">Close</button>
            </footer>
        </div>
    </div>
</template>
<script>
    import FileForm from '../FileForm';
    export default {
        data() {
            return {
                progress: false,
                images: false,
                progressWidth: 0,
                isClosing:false,
                form:new FileForm({
                    item_name:'',
                    category_id:''
                })
            }
        },
        props: ['categories'],
        methods:{
            addItem(){
                let option = {upload_div: "progressDiv"};
                this.progress = true;
                this.progressWidth = 0;
                let preview2 = document.querySelector('#preview2');
                this.form.post('/items', option).then(item => {
                    this.progress = false;
                    this.working = false, this.images = false,this.$emit('completed', item);
                }).catch(errors => {
                    console.log(errors);
                })
            },
            addFiles(e){
                let errorDiv = document.querySelector('#errors');
                /*if (e.target.files.length < 1) {
                    this.form.finalData.images = false;
                    return false;
                }*/
                this.form.clearFiles();
                this.images = true;
                let files = e.target.files;
                errorDiv.innerHTML = '';
                for (let l = 0; l < files.length; l++) {
                    if (!files[l].type.match('image.*')) {
                        e.target.value = e.target.type = '';
                        e.target.type = 'file';
                        let error = '<p class="help is-danger">We accept only images</p>';
                        errorDiv.innerHTML = error;
                    }
                    /*var reader = new FileReader();
                    reader.onload = function (c) {
                        var html = "<img src='" + c.target.result + "' class='preview-img'>";
                        selDiv.innerHTML += html;
                    }
                    reader.readAsDataURL(files[l]);*/
                    this.form.addFile(e.target.name, files[l], files[l].name)
                }
            },
            modalClose(){
                this.isClosing = true;
                setTimeout(()=>{
                    this.$emit('close');
                },1000);
            }
        }
    }
</script>
<style slot-scope>
    .modal-card {
        width: 400px;
    }
</style>