import instance from "./config";

export function getFilterOrder(pageNumber, data) {
    return instance.post("/order/get-filter-order?page=" + pageNumber, data);
}

export function getOrderProductDetail(data) {
    return instance.get("/order/order-detail/" + data);
}

export function getOrderInfo(data) {
    return instance.post("/order/order-info", data);
}

export function getHistoryDetail(data) {
    return instance.post("/order/history-detail", data);
}