import instance from "./config";

export function getTransaction(pageNumber) {

    return instance.get("/transaction/get-transaction?page="+pageNumber);
}
