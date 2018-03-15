require('./bootstrap');
window.Vue = require('vue');
import Buefy from 'buefy';
import { store } from "./store";
Vue.use(Buefy);
const nav = new Vue({
    el: '#navigation',
    mounted(){
        axios.get('/getCart').then(items => {
            if (items.data) {
                for(let i in items.data){
                    this.$store.commit('add_item',items.data[i]);
                }
            }
        })
    },
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
Vue.component('categories', require('./components/Categories.vue'));
const app = new Vue({
    el: '#categories'
});
$('.navbar-start>a').each(function () {
    let href = $(this).attr('href'),current = location.pathname;
    if(href == current){
        $(this).addClass('is-current');
    }
});