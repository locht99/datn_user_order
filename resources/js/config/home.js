import instance from './config'

export function getAllItem() {

    return instance.get("/transaction/get-transaction?page=");
}