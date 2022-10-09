<template>
    <section
        style="height: 568px; max-height: 568px"
        class="border rounded-xl shadow-md shadow-gray-400 px-5 mt-10"
    >
        <p class="flex my-8 items-center">
            <i
                class="fa-solid fa-money-bill-transfer text-2xl text-red-500"
            ></i>
            <span class="mx-4 text-lg font-bold">Giao dịch</span>
        </p>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Loại giao dịch</th>
                    <th>Nội dung</th>
                    <th>Tiền giao dịch</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(transaction, index) in listTransaction"
                    :key="index"
                    class="border-b border-gray-300 text-center h-12"
                >
                    <td>{{ ++index }}</td>
                    <td>{{ transaction.order_id }}</td>
                    <td>{{ transaction.type_name }}</td>
                    <td>{{ transaction.content }}</td>
                    <td>{{ formatPrice(transaction.point) }}</td>
                    <td>{{ transaction.created_at }}</td>
                </tr>
            </tbody>
        </table>

        <VueTaildwindPagination
                :current="currentPage"
                :total="total"
                :per-page="perPage"
                class="pagination"
                @page-changed="pageChange($event)"
            >
            </VueTaildwindPagination>
    </section>
</template>

<script>
import { getTransaction } from "../../config/transaction";
import "@ocrv/vue-tailwind-pagination/styles";

export default {
    data() {
        return {
            listTransaction: [],
            perPage: 0,
            total: 0,
            currentPage: 1,
        };
    },
    mounted() {
        this.getTransactionByUser();
    },

    methods: {
        formatPrice(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },

        getTransactionByUser() {
            getTransaction(this.currentPage).then((res) => {
                const responseData = res.data;
                this.listTransaction = responseData.data;
                this.perPage = responseData.per_page;
                this.total = responseData.total;
            });
        },

        pageChange(pageNumber) {
            this.currentPage = pageNumber;
            this.getTransactionByUser()
        },
    },
};
</script>

<style scoped>
.min-w-max.pagination div{
    display: none !important;
    background: yellow;
}
</style>
