import instance from "./config";

export function getCart() {
    return instance.get("/cart/list");
}
export function cartCheckout(data) {
    return instance.post("/cart-checkout", data);
}
export function createCart(data) {
    return instance.post("/cart/create",data);
}
export function cartCheckoutByProduct(data){
    return instance.post("/cart-checkoutByProduct",data);
}
export function deleteCart(id) {
    return instance.delete(`/cart-product/${id}`);
}