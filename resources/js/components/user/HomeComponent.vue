<template>
    <section
        style="height: 568px; max-height: 568px"
        class="homepage-content grid gap-4 mt-10"
    >
        <section
            class="border rounded-xl shadow-md shadow-gray-400 px-5 max-h-[568px] h-auto overflow-hidden relative"
        >
            <loading v-model:active="is_loading" :is-full-page="false" />
            <p v-show="!is_loading" class="my-5 items-center flex">
                <b class="mx-2 text-lg">Đã đặt gần đây: </b>
                <span class="text-lg font-semibold text-gray-500"
                    >{{ listLimit.length }} sản phẩm</span
                >
            </p>

            <table class="w-full" v-show="listLimit.length > 0">
                <thead class="sticky">
                    <tr class="bg-gray-100 h-12 table w-full box-border">
                        <th class="w-1/4 text-left pl-10">Tên sản phẩm</th>
                        <th class="w-1/4 text-left pl-14">Hình ảnh</th>
                        <th class="w-1/4 text-left pl-14">Mã đơn</th>
                        <th class="w-1/4 text-left pl-12">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="block max-h-[438px] overflow-y-auto">
                    <tr
                        v-for="item in listLimit"
                        :key="item.id"
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="py-4 flex items-center pl-8 mt-1">
                            <a :href="item.url" class="mx-2 underline text-sm">{{
                                item.product_name
                            }}</a>
                            <span>x{{ item.quantity_bought }}</span>
                        </td>
                        <td class="w-1/4 pl-16">
                            <img :src="item.image_link" width="100" />
                        </td>
                        <td class="w-1/4 pl-16"># {{ item.order_code }}</td>
                        <td class="w-1/4 pl-16">{{ item.status_name }}</td>
                    </tr>
                </tbody>
            </table>
            <div
                v-show="!is_loading"
                class="w-full flex flex-col items-center justify-center"
                style="height: 100%; padding-bottom: 150px"
            >
                <span class="font-semibold text-lg"
                    >Bạn chưa có đơn hàng nào!</span
                >
            </div>
        </section>

        <section class="border rounded-xl shadow-md shadow-gray-400 relative">
            <loading
                v-model:active="is_loading_activity"
                :is-full-page="false"
            />
            <p class="flex justify-center items-center my-8">
                <img src="/images/payper-send.png" alt="" class="mx-2" />
                <b class="mx-2 text-lg">Hoạt động mới</b>
            </p>
            <div class="pt-5">
                <div
                    v-for="(item, index) in listLog"
                    :key="index"
                    class="flex px-[25px] m-auto h-[90px]"
                    :class="{ 'no-line': index == listLog.length - 1 }"
                >
                    <span class="font-semibold text-md w-[100px]">{{
                        item.created_at
                    }}</span>
                    <div class="relative">
                        <p
                            class="break-point inline-block relative w-[17px] h-[17px]"
                            :class="{
                                'bg-[#E93B3B]':
                                    item.content.includes('Thêm sản phẩm'),
                                'bg-[#5672fd]':
                                    item.content.includes('Nạp tiền cho'),
                                'bg-[#FEF745]':
                                    item.content.includes('Đặt cọc tiền cho'),
                            }"
                        ></p>
                    </div>
                    <span class="w-[200px]">{{ item.content }}</span>
                </div>
            </div>
            <div v-show="listLog.length == 0 && is_loading_activity == false" class="flex justify-center items-center" style="height: 400px;">
                <p class="font-semibold text-center px-3">
                    Bạn chưa có hoạt động nào gần đây.
                </p>
            </div>
        </section>
    </section>
</template>

<script>
import axios from "axios";
import { getItem } from "../../config/home";
import { getLog } from "../../config/log";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    components: {
        loading,
    },
    data() {
        return {
            is_loading: false,
            is_loading_activity: false,
            listItem: [],
            dataPagination: {},
            lazyLoad: false,
            listLimit: [],
            listLog: [],
        };
    },

    methods: {
        getAllItem() {
            this.is_loading = true;
            getItem()
                .then((res) => {
                    this.listItem = res.data.data.oderProducts;
                    for (const item of this.listItem) {
                        this.listLimit.push(item);
                        if (this.listLimit.length >= 5) {
                            break;
                        }
                    }
                })
                .catch((error) => {
                    this.is_loading = false;
                })
                .finally(() => {
                    this.is_loading = false;
                });
        },

        getAllLog() {
            this.is_loading_activity = true;
            getLog().then((res) => {
                this.listLog = res.data
                this.is_loading_activity = false;
            });
        },
    },

    mounted() {
        this.getAllItem();
        this.getAllLog();
    },
};
</script>

<style scoped>
.homepage-content {
    grid-template-columns: 2fr 1fr;
}
.break-point {
    margin: 5px 25px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
}
.break-point:after {
    content: "";
    width: 5px;
    height: 80px;
    background: #eee8e8;
    position: absolute;
    top: 17px;
}
.no-line .break-point::after {
    position: unset;
    width: 0;
    height: 0;
}
</style>
