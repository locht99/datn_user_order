<template>
    <section class="homepage-content grid gap-4 mt-10">
        <section class="border rounded-xl shadow-md shadow-gray-400 px-5 max-h-[568px] h-auto overflow-hidden relative">
            <loading v-model:active="is_loading" :is-full-page="false" />
            <p class="my-5 items-center flex">
                <img src="/images/trolley.png" alt="" />
                <b class="mx-2 text-lg">Đơn hàng mới: </b>
                <span class="text-lg font-semibold text-gray-500">{{listItem.length}} đơn</span>
            </p>

            <table class="w-full">
                <thead class="sticky">
                    <tr class="bg-gray-100 h-12 table w-full box-border">
                        <th class="w-1/3 text-left pl-20">Đơn hàng</th>
                        <th class="w-1/3 text-left pl-20">Mã đơn</th>
                        <th class="w-1/3 text-left pl-20">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="block max-h-[438px] overflow-y-auto">
                    <tr v-for="item in listItem"
                        class="h-16 border-b border-gray-300 table w-full box-border">
                        <td class="py-4 flex items-center pl-20 mt-1"> 
                            <a href="" class="mx-2 underline">{{item.product_name}}</a>
                            <span>x{{item.quantity_bought}}</span>
                        </td>
                        <td class="w-1/3 pl-20"># {{item.id}}</td>
                        <td class="w-1/3 pl-20">{{item.status_name}}</td>
                    </tr>

                </tbody>
            </table>
        </section>

        <section class="border rounded-xl shadow-md shadow-gray-400">
            <p class="flex justify-center items-center my-8">
                <img src="/images/payper-send.png" alt="" class="mx-2" />
                <b class="mx-2 text-lg">Hoạt động mới</b>
            </p>
        </section>
    </section>
</template>

<script>
import axios from "axios";
import {getItem} from "../../config/home"
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    components: {
        loading,
    },
    data() {
        return {
            is_loading: false,
            listItem: [],
            dataPagination: {},
            lazyLoad: false,
        };
    },
   
    methods: {
        getAllItem() {
            this.is_loading = true
            getItem().then(res => {
                this.listItem = res.data.data.oderProducts;
                console.log(this.listItem)
                console.log(res.data.data.oderProducts)
            }) 
            .catch((error) => {
                    this.is_loading = false;
                })
                .finally(() => {
                    this.is_loading = false;
                });
            ;
        },
    },              

    mounted() {
        this.getAllItem();                       
    },
};
</script>

<style scoped>
.homepage-content {
    grid-template-columns: 2fr 1fr;
}
</style>
