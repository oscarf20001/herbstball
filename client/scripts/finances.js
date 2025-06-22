import { ensureTicketCount } from './ticketCount.js';

const shoppingCartIndex = document.getElementById('shoppingCartIndex');

const ts_earlyBird = 1751234399;
const ts_schonBisslTeurer = 1750629599;
const ts_lastMinute = 1754258399;
const currentTime = Date.now() / 1000;
//const currentTime = 1785794399; // 2026er Timestamp für Tests

let value = 0;

if(currentTime > ts_lastMinute){
    value = 18;
}else if(currentTime > ts_schonBisslTeurer){
    value = 15;
}else if(currentTime > ts_earlyBird){
    value = 12.5
}else if(currentTime < ts_earlyBird){
    value = 12;
}

shoppingCartIndex.innerText = 2 * value;

export function updateShoppingCart(count){
    shoppingCartIndex.innerText = count * value;
}

export function getEachTicketprice(){
    return value;
}