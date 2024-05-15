let users_divs = document.querySelectorAll("div.table.users > div:not(:first-child)");
let shifts_divs = document.querySelectorAll("div.table.shifts > div:not(:first-child)");
let dishes_divs = document.querySelectorAll("div.table.dishes > div:not(:first-child)");
let orders_divs = document.querySelectorAll("div.table.orders > div:not(:first-child)");
let ordersc_divs = document.querySelectorAll("div.table.orders-cook > div:not(:first-child)");
let data_dependants = document.querySelectorAll("a[data-dependant]");
if (users_divs){
    function changeGivenLogin(given_login){
        data_dependants[0].href = '?operation=edit&given_login='+given_login;
        data_dependants[1].href = '../php/process_user.php?action=delete&given_login='+given_login;
    }
    users_divs.forEach(users_div => {
        users_div.addEventListener("click", () => {
            let login = users_div.querySelector("p:nth-child(2)").innerHTML.trim();
            users_divs.forEach(div => { div.classList.remove("chosen") })
            users_div.classList.add("chosen");
            changeGivenLogin(login);
        })
    });
}
if (shifts_divs){
    function changeGivenID(given_id, ifClosed){
        data_dependants[0].href = '?operation=edit&given_id='+given_id;
        if (ifClosed) data_dependants[1].href = '../php/process_shift.php?action=close&given_id='+given_id;
        data_dependants[2].href = '../php/process_shift.php?action=delete&given_id='+given_id;
    }
    shifts_divs.forEach(shifts_div => {
        shifts_div.addEventListener("click", () => {
            let login = shifts_div.querySelector("p:first-child").innerHTML.trim();
            let ifClosed = shifts_div.querySelector("p:nth-last-child(2)").innerHTML.trim() === "ОТКРЫТА";
            shifts_divs.forEach(div => { div.classList.remove("chosen") })
            shifts_div.classList.add("chosen");
            changeGivenID(login, ifClosed);
        })
    });
}
if (dishes_divs){
    function changeGivenID(given_id){
        data_dependants[0].href = '?operation=edit&given_id='+given_id;
        data_dependants[1].href = '../php/process_dish.php?action=delete&given_id='+given_id;
    }
    dishes_divs.forEach(dishes_div => {
        dishes_div.addEventListener("click", () => {
            let id = dishes_div.querySelector("p:first-child").innerHTML.trim();
            dishes_divs.forEach(div => { div.classList.remove("chosen") })
            dishes_div.classList.add("chosen");
            changeGivenID(id);
        })
    });
}
if (orders_divs){
    function changeGivenID(given_id, isFinished){
        data_dependants[0].href = '?operation=edit&given_id='+given_id;
        data_dependants[2].href = '../php/process_order.php?action=cancel&given_id='+given_id;
        if (isFinished) data_dependants[1].href = '../php/process_order.php?action=pay&given_id='+given_id;
    }
    orders_divs.forEach(orders_div => {
        orders_div.addEventListener("click", () => {
            let id = orders_div.querySelector("p:first-child").innerHTML.trim();
            orders_divs.forEach(div => { div.classList.remove("chosen") })
            orders_div.classList.add("chosen");
            let ifFinished = orders_div.querySelector("p:nth-child(2)").innerHTML.trim() === "ГОТОВ";
            changeGivenID(id, ifFinished);
        })
    });
}
if (ordersc_divs){
    function changeGivenID(given_id, ifPrepared){
        data_dependants[0].href = '../php/process_order.php?action=prepare&given_id='+given_id;
        if (ifPrepared) data_dependants[1].href = '../php/process_order.php?action=finish&given_id='+given_id;
    }
    ordersc_divs.forEach(ordersc_div => {
        ordersc_div.addEventListener("click", () => {
            let id = ordersc_div.querySelector("p:first-child").innerHTML.trim();
            ordersc_divs.forEach(div => { div.classList.remove("chosen") });
            ordersc_div.classList.add("chosen");
            let ifPrepared = ordersc_div.querySelector("p:nth-child(2)").innerHTML.trim() === "ГОТОВИТСЯ";
            changeGivenID(id, ifPrepared);
        })
    });
}