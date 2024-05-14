let users_divs = document.querySelectorAll("div.table.users > div:not(:first-child)");
let data_dependants = document.querySelectorAll("a[data-dependant]");

function changeGivenLogin(given_login){
    data_dependants[0].href = '?operation=edit&given_login='+given_login;
    data_dependants[1].href = '../php/process_user.php?action=delete&given_login='+given_login;
}
users_divs.forEach(users_div => {
    users_div.addEventListener("click", (e) => {
        let login = users_div.querySelector("p:nth-child(2)").innerHTML.trim();
        changeGivenLogin(login);
    })
});