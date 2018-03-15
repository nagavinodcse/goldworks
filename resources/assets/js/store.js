import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
export const store = new Vuex.Store({
    state:{
        items:[],
    },
    getters:{
        all_items(state){ return state.items; },
        getQty(state){ return state.items.length; }
    },
    mutations:{
        add_item(state,item){state.items.push(item);},
        del_item(state,item){state.items.splice(item,1);},
        emptyItems(state){state.items = [];}
    }
});