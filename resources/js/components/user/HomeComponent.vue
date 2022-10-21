<template>
    <section class="homepage-content grid gap-4 mt-10">
        <section class="border rounded-xl shadow-md shadow-gray-400 px-5 max-h-[568px] h-auto overflow-hidden">
            <p class="my-5 items-center flex">
                <img src="/images/trolley.png" alt="" />
                <b class="mx-2 text-lg">Đơn hàng mới: </b>
                <span class="text-lg font-semibold text-gray-500">5 đơn</span>
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
                    <tr v-for="(item, index) in listItem" :key="index"
                        class="h-16 border-b border-gray-300 table w-full box-border">
                        <td class="py-4 flex items-center pl-20 mt-1">
                            <img src="/images/product-demo.png" class="max-h-16" alt="" />
                            <a href="" class="mx-2 underline">2022春夏新...</a>
                            <span>x1</span>
                        </td>
                        <td class="w-1/3 pl-20">MD001</td>
                        <td class="w-1/3 pl-20">Chờ xác nhận</td>
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
            lazyLoad: false,
        };
    },
    mounted() {
        this.getAllItem();
    },
    methods: {
        getAllItem() {
            axios.get("api/cart/list").then((res) => {
                console.log(res.data);
            });
        },
    },              

    mounted() {
        this.getAll();                       
    },
};
</script>

<style scoped>
.homepage-content {
    grid-template-columns: 2fr 1fr;
}
</style>
