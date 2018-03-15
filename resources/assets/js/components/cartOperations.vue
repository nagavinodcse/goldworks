<template>
    <div class="b-table m-t-30" :class="{'is-loading':loading}">
        <table class="table has-mobile-cards">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item,index in cartItems" data-vv-scope="form-'+index'">
                <td class="is-hidden-mobile" v-text="index+1"></td>
                <td data-label="Name" v-text="item.item.item_name"></td>
                <td data-label="Image">
                    <figure class="image is-48x48">
                        <img :src="'/images/small/'+JSON.parse(item.item.image_path)[0]" :alt="item.item.item_name">
                    </figure>
                </td>
                <td data-label="Quantity">
                    <div v-if="item.price<100" v-text="item.quantity"></div>
                    <div class="field has-addons has-addons-centered" v-else>
                        <p class="control">
                            <button type="button" @click="decrementQty(item.id)" class="button is-danger">-</button>
                        </p>
                        <p class="control"><input class="input" v-model="item.quantity" readonly="readonly"></p>
                        <p class="control">
                            <button type="button" @click="incrementQty(item.id)" class="button is-success">+</button>
                        </p>
                    </div>
                </td>
                <td data-label="Price">
                    <div class="field">
                        <p class="control">
                            <input v-model="item.price" v-validate="'required:true|min_value:100'" data-vv-as="Price" :name="'price'+index" @blur="updatePrice(item.id)" class="input">
                            <span v-show="errors.has('price'+index)" class="help is-danger">{{ errors.first('price'+index) }}</span>
                        </p>
                    </div>
                </td>
                <td data-label="Due Date">
                    <div class="field">
                        <div class="control">
                            <datepicker placeholder="Due Date" v-model="item.due_date" dateFormat="dd-mm-yy" @update="updatePrice(item.id)" inputClass="input"></datepicker>
                        </div>
                    </div>
                </td>
                <td data-label="Amount" v-text="item.quantity * item.price"></td>
                <td data-label="Action"><span class="icon is-danger is-anchor" @click="delItem(item.id)"><b-icon icon="delete" type="is-danger"></b-icon></span></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="has-text-centered">Total Quantity : {{ totalQty }}</td>
                <td class="has-text-centered">Total Price : {{ totalPrice }}</td>
                <td colspan="3"></td>
            </tr>
            </tfoot>
        </table>
        <div class="has-text-right m-b-40">
            <a href="/" class="button is-primary">Continue Shopping</a>
            <template v-if="cartItems.length>0">
                <button type="button" @click="emptyCart" class="button is-danger">Empty Cart</button>
                <a href="/checkout" v-if="!errors.any()" class="button is-success">Checkout</a>
            </template>
        </div>
    </div>
</template>
<script>
    import Datepicker from './Datepicker.vue';
    import BIcon from "buefy/src/components/icon/Icon";
    export default {
        data: function () {
            let checkForm = false;
            return {
                yesterday: moment().subtract(1, 'days').toDate()
            }
        },
        props:['loading'],
        components: {
            BIcon,
            Datepicker
        },
        methods: {
            updatePrice(item_id) {
                let obj = _.find(this.cartItems, ['id', item_id]);
                if (obj.price > 100) {
                    axios.post('/updateCart', obj);
                }
            },
            incrementQty(item_id) {
                let key = _.findIndex(this.cartItems, ['id', item_id]);
                if (key >= 0) {
                    this.cartItems[key].quantity += 1;
                    this.cartItems.totalQty += 1;
                    this.updatePrice(item_id);
                }
            },
            decrementQty(item_id) {
                let key = _.findIndex(this.cartItems, ['id', item_id]);
                if (key >= 0) {
                    if (this.cartItems[key].quantity > 1) {
                        this.cartItems[key].quantity -= 1;
                        this.updatePrice(item_id);
                    }
                }
            },
            delItem(item_id) {
                this.$dialog.confirm({
                    title: 'Deleting item',
                    message: 'Are you sure you want to <b>delete</b> your item? This action cannot be undone.',
                    confirmText: 'Delete Item',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => {
                        let key = _.findIndex(this.cartItems, ['id', item_id]);
                        if (key >= 0) {
                            axios.delete('/delCartItem/' + item_id).then(() => {
                                this.$store.commit('del_item', key);
                            });
                        }
                        this.$toast.open('Item deleted!')
                    }
                })
            },
            emptyCart(){
                this.$dialog.confirm({
                    title: 'Deleting all items',
                    message: 'Are you sure you want to <b>delete</b> all your items? This action cannot be undone.',
                    confirmText: 'Delete All',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => {
                        axios.delete('/emptyCart').then(() => {
                            this.$store.commit('emptyItems');
                        });
                        this.$toast.open('All Items deleted!')
                    }
                })
            }
        },
        computed: {
            cartItems() {
                return this.$store.getters.all_items;
            },
            totalQty() {
                return _.sumBy(this.cartItems, item => {
                    return item.quantity;
                })
            },
            totalPrice() {
                return _.sumBy(this.cartItems, item => {
                    return item.quantity * item.price;
                });
            }
        }
    }
</script>
<style>
    .bgb-wrapper{position: fixed;top:0;right:0;left:0; bottom:0;background: rgba(0,0,0,.8);}
    .table{border-bottom:solid 2px #ddd;}
    @media screen and (max-width: 767px){
        .vdp-datepicker__calendar{right:0;}
    }
</style>