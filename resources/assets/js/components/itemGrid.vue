<template>
    <div class="item-wrapper p-t-20">
        <h2 class="is-size-3">
            Filters
            <span class="control select is-at-right">
                <select name="category_id" v-model="category_id" id="category_id">
                    <option value="">Select a Category</option>
                    <option v-for="category in categories" :value="category.id">{{ category.category_name }}</option>
                </select>
            </span>
        </h2>
        <div class="item-container columns is-multiline">
            <div v-for="item in filteredItems" class="column is-one-quarter">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img v-if="(JSON.parse(item.image_path)[0])" :src="'/images/medium/'+JSON.parse(item.image_path)[0]" :alt="item.item_name">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4">{{ item.item_name }}</p>
                                <p class="subtitle is-6">{{ item.category.category_name }}</p>
                                <p class="subtitle is-6">
                                    <strong>Uploaded By :</strong> {{ item.user.name + '-' + item.user.mobile_no }}
                                </p>
                            </div>
                        </div>
                        <div class="content has-text-centered">
                            <button class="button is-primary" v-if="!cartHas(item.id)" @click="addToCart(item.id,$event)" type="button">Add to Cart</button>
                            <button class="button is-primary" v-if="cartHas(item.id)" type="button"><span class="icon"><i class="material-icons">done_all</i></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sk-circle" v-if="isLoad">
                <div class="sk-circle1 sk-child"></div>
                <div class="sk-circle2 sk-child"></div>
                <div class="sk-circle3 sk-child"></div>
                <div class="sk-circle4 sk-child"></div>
                <div class="sk-circle5 sk-child"></div>
                <div class="sk-circle6 sk-child"></div>
                <div class="sk-circle7 sk-child"></div>
                <div class="sk-circle8 sk-child"></div>
                <div class="sk-circle9 sk-child"></div>
                <div class="sk-circle10 sk-child"></div>
                <div class="sk-circle11 sk-child"></div>
                <div class="sk-circle12 sk-child"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted: function () {
            this.isLoad = true;
            if (this.lastPage == 0) {
                axios.get('/getItems').then(info => {
                    this.lastPage = info.data.last_page;
                    this.nextPage = info.data.next_page_url;
                    info.data.data.forEach(item => {
                        this.items.push(item);
                    });
                    if (info.data.next_page_url == null) {
                        this.isLoad = false;
                    } else {
                        this.updateItems();
                    }
                });
            }
        },
        data() {
            return {
                lastPage: 0, nextPage: '', items: [], category_id: '', mobile: '', isLoad: false
            }
        },
        props: ['categories'],
        computed: {
            filteredItems() {
                let filtered = this.items, selectedCategory = this.category_id, mob = this.mobile;
                if (!selectedCategory && !mob) {
                    return filtered;
                }
                if (selectedCategory) {
                    filtered = filtered.filter(item => {
                        if (item.category_id == selectedCategory) {
                            return item;
                        }
                    })
                }
                if (mob) {
                    mob = mob.trim().toLowerCase();
                    filtered = filtered.filter(item => {
                        if ((item.user.name.toLowerCase().indexOf(mob) >= 0) || (item.user.mobile_no.indexOf(mob))) {
                            return item;
                        }
                    })
                }
                return filtered;
            },
            cartItems(){
                return this.$store.getters.all_items
            }
        },
        methods: {
            updateItems() {
                if (this.nextPage !== null) {
                    axios.get(this.nextPage).then(info => {
                        this.nextPage = info.data.next_page_url;
                        info.data.data.forEach(item=>{
                            this.items.push(item);
                        });
                        if (info.data.next_page_url == null) {
                            this.isLoad = false;
                        }else{
                            this.updateItems();
                        }
                    })
                }
            },
            addToCart(item,e){
                let elm = e.target.classList;elm.add('is-loading');
                axios.get('/addToCart/'+item).then(item=>{
                    elm.remove('is-loading');
                    this.$store.commit('add_item',item.data);
                })
            },
            cartHas(id){
                return _.some(this.cartItems,['id',id]);
            }
        }
    }
</script>