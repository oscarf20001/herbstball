import { ensureTicketCount } from './ticketCount.js';

const shoppingCartIndex = document.getElementById('shoppingCartIndex');

const ts_earlyBird = 1751839199; // 12€
const ts_schonBisslTeurer = 1753048799; // 13€
const ts_nochEtwasMehrBisslTeurer = 1755467999; // 14€
const ts_preLastMinute = 1759528799; // 15€
const ts_lastMinute = 1760565599; // 17,50€
const ts_currentTime = Date.now() / 1000;
//const ts_currentTime = 1785794399; // 2026er Timestamp für Tests

let value = 0;

if(ts_currentTime > ts_lastMinute){
    value = 18;
}else if(ts_currentTime > ts_preLastMinute){
    value = 17.50;
}else if(ts_currentTime > ts_nochEtwasMehrBisslTeurer){
    value = 15;
}else if(ts_currentTime > ts_schonBisslTeurer){
    value = 14;
}else if(ts_currentTime > ts_earlyBird){
    value = 13;
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