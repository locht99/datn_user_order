import instance from "./config";

export function getTransaction(pageNumber) {

    return instance.get("/transaction/get-transaction?page="+pageNumber);
}
export function createTransaction(data){
   return instance.post("/transaction/create",data);
}
export function getTypeTransaction(){
    return instance.get("/transaction/type-transaction");
}
export function getPayment() { 
    return instance.get("/transaction/type-payment");
 }
export function getCodeTransaction() { 
    return instance.get("/transaction/generateCode");
 }
 export function checkOrCreateTransaction(){
    return instance.get("/transaction/checkOrCreateTransaction");
 }