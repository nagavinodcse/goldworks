require('./bootstrap');
import Vue from 'vue';
import Buefy from 'buefy';
window.Vue = Vue;
Vue.use(Buefy);
import { store } from "./store";
Vue.component('checkout',require('./components/checkout.vue'));
const nav = new Vue({
    el: '#navigation',
    data(){
        return {
            open: false
        }
    },
    store,
    methods: {
        toggleNav(){
            this.open = !this.open;
        },
    },
    computed:{
        cartQty(){
            return this.$store.getters.getQty;
        }
    }
});
const checkout = new Vue({
    el:"#checkout",
    mounted(){
        axios.get('/getCart').then(items => {
            if (items.data) {
                for(let i in items.data){
                    this.$store.commit('add_item',items.data[i]);
                }
                this.loading = false;
            }
        })
    },
    data(){
        return{
            loading:true,
        }
    },
    store
});
$('.navbar-start>a').each(function () {
    let href = $(this).attr('href'),current = location.pathname;
    if(href == current){
        $(this).addClass('is-current');
    }
});