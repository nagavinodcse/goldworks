<template>
    <div class="container p-t-20">
        <div class="item-container columns is-multiline">
            <div v-for="item in orders" class="column is-one-quarter">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img v-if="(JSON.parse(item.item.image_path)[0])" :src="'/images/medium/'+JSON.parse(item.item.image_path)[0]" :alt="item.item.item_name">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content order_details">
                                <p class="order_item">{{ item.item.item_name }}</p>
                                <p class="order_date"><strong>Delivery Date:</strong> {{ myDate(item.due_date) }}</p>
                                <p class="contact">
                                    <strong>Ordered By :</strong> {{ item.order.name + '-' + item.order.mobile }}
                                    <strong>Address : </strong>
                                </p>
                                <p class="address">{{ item.order.address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sk-circle" v-if="isLoading">
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
    export default{
        created(){
            this.isLoading = false
        },
        data(){
            return {
            }
        },
        props: ['user','orders'],
        methods: {
            myDate(date){
                return moment(date).format("Do MMM YYYY");
            }
        }
    }
</script>