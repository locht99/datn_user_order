import instance from './config'

export function getItem() {

    return instance.get("/order/get-order?");
}