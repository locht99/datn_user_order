import instance from './config'

export function getLog() {

    return instance.get("/logs");
}