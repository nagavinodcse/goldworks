<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card animated" :class="[ (isClosing) ? 'bounceOutRight' : 'bounceInLeft']">
            <header class="modal-card-head">
                <p class="modal-card-title">User Details</p>
                <button class="delete" @click="modalClose"></button>
            </header>
            <section class="modal-card-body">
                <progress class="progress is-primary is-small" v-if="progress" id="progressDiv" :value="progressWidth" max="100"></progress>
                <form method="post" id="checkoutForm" @submit.prevent="checkOut">
                    <b-field label="Name">
                        <b-input type="text" v-model="form.name" placeholder="Name" required></b-input>
                    </b-field>
                    <b-field label="Mobile No">
                        <b-input type="text" v-model="form.mobile" placeholder="Mobile No" required></b-input>
                    </b-field>
                    <b-field label="Address">
                        <b-input type="textarea" placeholder="Address" v-model="form.address" maxlength="255"></b-input>
                    </b-field>
                </form>
            </section>
            <footer class="modal-card-foot">
                <button form="checkoutForm" class="button is-primary" :class="{ 'is-loading':progress }">Checkout</button>
                <button class="button" @click="modalClose" type="button">Close</button>
            </footer>
        </div>
    </div>
</template>
<script>
    import FileForm from '../FileForm';
    export default {
        mounted(){},
        data() {
            return {
                progress: false,
                progressWidth: 0,
                isClosing:false,
                form:new FileForm({
                    name:'',
                    mobile:'',
                    address:''
                })
            }
        },
        methods:{
            checkOut(){
                let option = {upload_div: "progressDiv"};
                this.progress = true;
                this.progressWidth = 0;
                this.form.post('/cart/save', option).then(item => {
                    this.progress = false;
                    this.working = false;
                    location.pathname = '/';
                }).catch(errors => {
                    console.log(errors);
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
    .modal-card {
        width: 400px;
    }
</style>