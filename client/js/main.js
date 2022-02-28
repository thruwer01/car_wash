
//statistics
const sessions_num = document.querySelector('#sessions_num');
const new_clients_num = document.querySelector('#new_clients_num');
const total_money_num = document.querySelector('#total_money_num');

//form
const services_list = document.querySelector('#services_list');
const new_session_hours = document.querySelector('#new_session_hours');
const new_session_money = document.querySelector('#new_session_money');
const car_number_input = document.querySelector('#car_number_input');
const client_name_input = document.querySelector('#client_name_input');
const add_new_session_btn = document.querySelector('#add_new_session_btn');
const hidden_client_id = document.querySelector('#client_id');

//last sessions list
const last_sessions_list = document.querySelector('#last_sessions_list');

//variables of form services selector
let total_sum = 0;
let total_hours = 0;
let selected_sessions = [];

//get last sessions
const get_last_sessions = () => {
    return $.ajax({
        method: "GET",
        url: "/backend/api/sessions/get",
        data: {limit: 10}
    });
}

//render last sessions
const render_last_sessions = async () => {
    const last_sessions = await get_last_sessions();
    last_sessions_list.innerHTML = ``;
    if (last_sessions.length > 0) {
        last_sessions.map(session => {
            let last_session_node = document.createElement('tr');
            last_session_node.innerHTML = `
                <td>${session.client_name}</td>
                <td>${session.client_car_number}</td>
                <td>${session.total}$</td>
                <td>${session.time}</td>
            `;
            last_sessions_list.appendChild(last_session_node);
        });
    } else {
        last_sessions_list.innerHTML = `
            <tr>
                <td>No sessions today</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        `;
    }    
}

//get statistics
const get_statistics = () => {
    return $.ajax({
        method: "GET",
        url: "/backend/api/statistics/today"
    });
}

//render statistics
const render_statistics = async () => {
    const statistics = await get_statistics();
    if (statistics) {
        sessions_num.innerText = statistics.sessions;
        new_clients_num.innerText = statistics.new_clients;
        total_money_num.innerText = statistics.total_earned;
    }
}

//get services
const get_services = () => {
    return $.ajax({
        method: "GET",
        url: "/backend/api/services/get_all"
    });
}

//render services
const render_services = async () => {
    const services = await get_services();
    services.data.map(service => {
        let service_node = document.createElement('label');
        service_node.classList = "form-check form-switch";
        service_node.innerHTML = `
            <input class="form-check-input" type="checkbox" data-service-id="${service.id}" data-service-price="${service.price}" data-service-time="${service.time}">
            <span class="form-check-label">${service.title}</span>
            <span class="form-check-description">
                <span class="strong">${service.price}$</span> (${service.time} hours)
            </span>
        `;
        services_list.appendChild(service_node);
    });
    services_list.querySelectorAll("input").forEach(service_selector => {
        service_selector.addEventListener("change", service_selector_handler);
    });
}

const add_new_session = async (form_data) => {
    $.ajax({
        method: "POST",
        url: "/backend/api/sessions/add/",
        data: form_data,
        success: (data) => {
            if (data.status === "success") {
                render_last_sessions();
                render_statistics();
                clear_form();
            }
        }
    });
}

const clear_form = () => {
    car_number_input.value = null;
    client_name_input.value = null;
    hidden_client_id.value = null;
    services_list.querySelectorAll("input").forEach(service_selector => {
        service_selector.checked = false;
    });
    total_sum = 0;
    total_hours = 0;
    selected_sessions = [];
    new_session_hours.innerText = total_hours;
    new_session_money.innerText = total_sum;
}

//form handlers
const car_number_handler = (event) => {
    let input_value = event.target.value;
    event.target.value = input_value.substr(0,8).toUpperCase();
    client_name_input.value = null;
    hidden_client_id.value = null;
    if (event.target.value.length == 8) {
        $.ajax({
            method: "POST",
            url: "/backend/api/clients/check_by_car_number/",
            data: {car_number: event.target.value},
            success: (data) => {
                if (data.status == "success") {
                    //found client in db
                    const client_id = data.client.id;
                    const client_name = data.client.name;

                    client_name_input.value = client_name;
                    hidden_client_id.value = client_id;
                }
            }
        });
    }
}

const service_selector_handler = (event) => {
    let service_all_data = event.target.dataset;
    let service_time = service_all_data.serviceTime;
    let service_price = service_all_data.servicePrice;
    let service_id = service_all_data.serviceId;

    if (event.target.checked == true) {
        total_sum += Number(service_price);
        total_hours += Number(service_time);
        selected_sessions.push(service_id);
    } else {
        total_sum -= Number(service_price);
        total_hours -= Number(service_time);
        selected_sessions.splice(selected_sessions.indexOf(service_id), 1);
    }

    new_session_hours.innerText = total_hours;
    new_session_money.innerText = total_sum;
}

const addNewSessionHandler = () => {
    if (selected_sessions.length == 0) {
        return false;
    }
    if (car_number_input.value.length !== 8) {
        return false;
    }
    if (client_name_input.value.length == 0) {
        return false;
    }
    const form_data = {
        "services": selected_sessions,
        "client_car_number": car_number_input.value,
        "client_name": client_name_input.value
    }

    if (hidden_client_id.value !== null) {
        form_data.client_id = hidden_client_id.value;
    }

    add_new_session(form_data);
}

//event listeners
car_number_input.addEventListener("input", car_number_handler);
add_new_session_btn.addEventListener("click", addNewSessionHandler);

//init function
const init = async () => {
    await render_last_sessions();
    await render_statistics();
    await render_services();
}

//main function
window.onload = () => {
    init();
}