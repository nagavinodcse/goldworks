<template>
    <input :placeholder="placeholder" :value="value" :class="inputClass"/>
</template>
<script>
    require('../jquery-ui.min');
    export default {
        mounted() {
            var self = this;
            $(this.$el).datepicker({
                dateFormat: this.dateFormat,
                minDate: 'today',
                changeYear: true,
                changeMonth: true,
                showOtherMonths: true,
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                onSelect: function (date) {
                    self.$emit('input', date);
                    self.$emit('update');
                }
            });
        },
        beforeDestroy: function () {
            $(this.$el).datepicker('hide').datepicker('destroy');
        },
        props: ['dateFormat', 'placeholder', 'inputClass', 'value'],
    }
</script>
<style>
    @import "../jquery-ui.min.css";
</style>