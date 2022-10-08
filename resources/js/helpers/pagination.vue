<template>
  <div>
      <VueTaildwindPagination
          :current="currentPage"
          :total="total"
          :per-page="perPage"
          class="pagination"
          @page-changed="pageChange($event)"
      >
      </VueTaildwindPagination>
  </div>
</template>

<script>
export default {
  components: {
      VueTailwindPagination,
  },
  data() {
      return {
          listTransaction: [],
          perPage: 0,
          total: 0,
          currentPage: 1,
      };
  },
  methods: {
      pageChange(pageNumber) {
          this.currentPage = pageNumber;
      },
  },
};
</script>
