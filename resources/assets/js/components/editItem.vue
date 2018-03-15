<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card animated" :class="[ (isClosing) ? 'bounceOutRight' : 'bounceInLeft']">
            <header class="modal-card-head">
                <p class="modal-card-title">Update Item</p>
                <button class="delete" @click="modalClose"></button>
            </header>
            <section class="modal-card-body">
                <progress class="progress is-primary is-small" v-if="progress" id="progressDiv" :value="progressWidth" max="100"></progress>
                <form method="post" id="itemForm" enctype="multipart/form-data" @submit.prevent="updateItem">
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
                        <div class="image-container m-t-10" v-if="sourceImages">
                            <div class="card-image animated" :class="[(isDeleting == image) ? 'hinge' : '']" v-for="image in sourceImages">
                                <img :src="domain+'/images/medium/'+image" :alt="form.item_name">
                                <a :href="'/delImg/'+id+'?image='+image" @click.prevent="delImage(image,$event)" class="delete"></a>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <button form="itemForm" class="button is-primary" :class="{ 'is-loading':progress }">Update Item</button>
                <button class="button" @click="modalClose" type="button">Close</button>
            </footer>
        </div>
    </div>
</template>
<script>
    import FileForm from '../FileForm';
    export default {
        mounted(){
            axios.get('/items/'+this.id).then(item=>{
                this.form.item_name = item.data.item_name,this.form.category_id = item.data.category_id;
                this.sourceImages = _.values(JSON.parse(item.data.image_path));
            })
        },
        data() {
            return {
                sourceImages:[],
                domain : window.location.origin,
                progress: false,
                images: false,
                progressWidth: 0,
                isClosing:false,
                isDeleting:'',
                form:new FileForm({
                    item_name:'',
                    category_id:''
                })
            }
        },
        props: ['categories','id'],
        methods:{
            updateItem(){
                let option = {upload_div: "progressDiv"};
                this.progress = true;
                this.progressWidth = 0;
                let preview2 = document.querySelector('#preview2');
                this.form.post('/items/'+this.id, option).then(item => {
                    this.progress = false;
                    this.working = false, this.images = false,this.$emit('completed', item);
                }).catch(errors => {
                    console.log(errors);
                })
            },
            addFiles(e){
                let errorDiv = document.querySelector('#errors');
                this.form.clearFiles();
                this.images = true;
                let files = e.target.files;
                for (let l = 0; l < files.length; l++) {
                    if (!files[l].type.match('image.*')) {
                        e.target.value = e.target.type = '';
                        e.target.type = 'file';
                        let error = '<p class="help is-danger">We accept only images</p>';
                        errorDiv.innerHTML = error;
                    }
                    this.form.addFile(e.target.name, files[l], files[l].name)
                }
            },
            delImage(image,e){
                let url = e.target.href;
                axios.delete(url).then(()=>{
                    let index = this.sourceImages.indexOf(image);
                    this.isDeleting = image;
                    setTimeout(()=>{
                        this.sourceImages.splice(index,1);
                    },2000)
                })
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
    .image-container .card-image{display: inline-block;margin:5px 10px 5px 0; }
    .card-image>.delete{position: absolute;top:0;right:0;}
</style>