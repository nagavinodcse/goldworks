require('./bootstrap');
import Vue from "vue";
import moment from 'moment';
window.Vue = Vue;
window.moment = moment;
import Buefy from 'buefy';
import { store } from "./store";
import VeeValidate from 'vee-validate';
const config = {
    errorBagName: 'errors', // change if property conflicts
    fieldsBagName: 'fields',
    delay: 0,
    locale: 'en',
    dictionary: null,
    strict: true,
    classes: false,
    classNames: {
        touched: 'touched', // the control has been blurred
        untouched: 'untouched', // the control hasn't been blurred
        valid: 'valid', // model is valid
        invalid: 'invalid', // model is invalid
        pristine: 'pristine', // control has not been interacted with
        dirty: 'dirty' // control has been interacted with
    },
    events: 'input|blur',
    inject: true,
    validity: false,
    aria: true,
    i18n: null, // the vue-i18n plugin instance,
    i18nRootKey: 'validations' // the nested key under which the validation messsages will be located
};

Vue.use(VeeValidate, config);
Vue.use(Buefy);
Vue.component('cartOperations',require('./components/cartOperations.vue'));
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
const cart = new Vue({
    el:"#cart",
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