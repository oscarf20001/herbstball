import { ensureTicketCount } from './ticketCount.js';

const shoppingCartIndex = document.getElementById('shoppingCartIndex');

const ts_earlyBird = 1751234399;
const ts_schonBisslTeurer = 1750629599;
const ts_lastMinute = 1754258399;
const ts_currentTime = Date.now() / 1000;
//const ts_currentTime = 1785794399; // 2026er Timestamp für Tests

let value = 0;

if(ts_currentTime > ts_lastMinute){
    value = 18;
}else if(ts_currentTime > ts_schonBisslTeurer){
    value = 15;
}else if(ts_currentTime > ts_earlyBird){
    value = 12.5
}else if(ts_currentTime < ts_earlyBird){
    value = 12;
}

shoppingCartIndex.innerText = 2 * value;

export function updateShoppingCart(count){
    shoppingCartIndex.innerText = count * value;
}

export function getEachTicketprice(){
    return value;
}