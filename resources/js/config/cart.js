import instance from "./config";

export function getCart() {

    return instance.get("/cart/list");
}