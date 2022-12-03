import instance from "./config";

export function getComplain() {
    return instance.get("get-complain");
}