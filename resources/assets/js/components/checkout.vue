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
            </tr>
            </thead>
            <tbody>
                <tr v-for="item,index in cartItems">
                <td class="is-hidden-mobile" v-text="index+1"></td>
                <td data-label="Name" v-text="item.item.item_name"></td>
                <td data-label="Image">
                    <figure class="image is-48x48">
                        <img :src="'/images/small/'+JSON.parse(item.item.image_path)[0]" :alt="item.item.item_name">
                    </figure>
                </td>
                <td data-label="Quantity">
                    <span v-text="item.quantity"></span>
                </td>
                <td data-label="Price">
                    <span v-text="item.price"></span>
                </td>
                <td data-label="Due Date">
                    <span v-text="item.due_date"></span>
                </td>
                <td data-label="Amount" v-text="item.quantity * item.price"></td>
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
            <a href="/cart" class="button is-info"><i class="fa fa-angle-left"></i> Back</a>
            <a href="/" class="button is-primary">Continue Shopping</a>
            <button type="button" v-if="cartItems.length>0" class="button is-success" @click="checkForm = true;">Checkout</button>
        </div>
        <order-form v-if="checkForm" @close="checkForm=false"></order-form>
    </div>
</template>
<script>
    import orderForm from './OrderForm';
    export default {
        mounted(){},
        data: function () {
            return {
                checkForm: false,
            }
        },
        props:['loading'],
        components:{orderForm},
        methods: {
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