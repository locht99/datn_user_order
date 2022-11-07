import instance from "./config";

export function getFilterOrder(pageNumber, data) {
    return instance.post("/order/get-filter-order?page=" + pageNumber, data);
}